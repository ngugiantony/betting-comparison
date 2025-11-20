<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\SmsController;
use App\Enums\DeliveryStatusEnum;
use App\Enums\CentyOtpVerified;
use App\Models\User;
use App\Models\Sms;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Str;

class SendUserOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Executing SendUserOtp job for ' . $this->user->name);
        $formattedPhoneNumber = GeneralHelper::phoneNumberToInternational($this->user->phone_number);
        if (empty($formattedPhoneNumber)) return;

        $sms = new Sms();
        $sms->external_ref = Str::uuid();
        $sms->recipient = $formattedPhoneNumber;
        $sms->text = "<#> Verification code " . intval($this->user->centy_plus_otp) . "\nDo not share with anyone. Thank you for using CentyPlus";
        $sms->short_code = config('app.sms.celcom.short_code');
        $sms->save();

        $result = (new SmsController)->sendSms($sms);
        Log::info("Response from SMS API: " . $result);

        // Update SMS status
        $result = json_decode($result);
        if (intval($result->responses[0]->{"response-code"}) === 200) {
            $sms->delivery_status = DeliveryStatusEnum::SENT;
            $this->user->centy_plus_otp_verified = CentyOtpVerified::SENT;
            $this->user->centy_plus_otp_sent_at = Carbon::now();
        } else {
            $sms->delivery_status = DeliveryStatusEnum::UNDELIVERED;
            $this->user->centy_plus_otp = null;
            $this->user->centy_plus_otp_verified = CentyOtpVerified::INACTIVE;
        }
        $sms->status_description = $result->responses[0]->{"response-description"};
        $sms->save();
        $this->user->save();
    }
}
