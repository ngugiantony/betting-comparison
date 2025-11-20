<?php

namespace App\Jobs;

use App\Enums\DeliveryStatusEnum;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\SmsController;
use App\Models\Sms;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendTeacherAccountSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $teacher;
    public $password;

    /**
     * Create a new job instance.
     */
    public function __construct(Teacher $teacher, string $password)
    {
        $this->teacher = $teacher;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Executing Teacher job for ' . $this->teacher->user->name);

        $formattedPhoneNumber = GeneralHelper::phoneNumberToInternational($this->teacher->user->phone_number);
        if (empty($formattedPhoneNumber)) return;

        $sms = new Sms();
        $sms->external_ref = Str::uuid();
        $sms->recipient = $formattedPhoneNumber;
        $sms->text = "Hello " .$this->teacher->user->name. " Your teacher account has been created. Here are your login details: " . "\n". "CentyPlus Id: " . $this->teacher->user->centy_plus_id . "\n" . "PIN: " . $this->password . "\n" . "Login LinK: " . config('app.url') . "/login" . "\n" . "Thank you for using Centy Plus";
        $sms->short_code = config('app.sms.celcom.short_code');
        $sms->save();

        $result = (new SmsController)->sendSms($sms);
        Log::info("Response from SMS API: " . $result);

        // Update SMS status
        $result = json_decode($result);
        if (intval($result->responses[0]->{"response-code"}) === 200) {
            $sms->delivery_status = DeliveryStatusEnum::SENT;
        } else {
            $sms->delivery_status = DeliveryStatusEnum::UNDELIVERED;
        }
        $sms->status_description = $result->responses[0]->{"response-description"};
        $sms->save();
    }
}
