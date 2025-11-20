<?php

namespace App\Jobs;

use App\Enums\DeliveryStatusEnum;
use App\Helpers\GeneralHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\SmsController;
use App\Models\Student;
use App\Models\Sms;

class SendStudentAccountSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student;
    public $password;

    /**
     * Create a new job instance.
     */
    public function __construct(Student $student, string $password)
    {
        $this->student = $student;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Executing SendStudentAccountSms job for ' . $this->student->user->name);

        $formattedPhoneNumber = GeneralHelper::phoneNumberToInternational($this->student->guardian->user->phone_number);
        if (empty($formattedPhoneNumber)) return;

        $sms = new Sms();
        $sms->external_ref = Str::uuid();
        $sms->recipient = $formattedPhoneNumber;
        $sms->text = "You have successfully created an account for " . $this->student->user->name . " Please use below credentials to log in to student account\nCenty-Plus-ID: " . $this->student->user->centy_plus_id . "\n" . "PIN: " . $this->password . "\n" . "Login LinK: " . config('app.url') . "/login" . "\n" . "Thank you for using Centy Plus";
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


