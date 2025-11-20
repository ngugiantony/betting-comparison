<?php

namespace App\Http\Controllers;

use App\Enums\SmsPassType;
use App\Models\Sms;
use Illuminate\Support\Facades\Log;


class SmsController extends Controller
{
    public function sendSMS(Sms $message){
        Log::info("Message sent to SMS API: " . $message);

        $curl = curl_init();

        $smsBody = json_encode(array(
            "partnerID" => config('app.sms.celcom.partner_id'),
            "apikey" => config('app.sms.celcom.api_key'),
            "pass_type" => SmsPassType::getDescription($message->pass_type),
            "clientsmsid" => $message->external_ref,
            "mobile" => $message->recipient,
            "message" => $message->text,
            "shortcode" => $message->short_code
        ));
        Log::info("SMS Body: " . $smsBody);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mysms.celcomafrica.com/api/services/sendsms/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $smsBody,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
