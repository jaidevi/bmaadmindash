<?php

namespace App\Http\Controllers\Admin;

use App\AdminSetting;
use App\AppUsers;
use App\FuelProvider;
use App\Http\Controllers\Controller;
use App\ServiceProvider;
use App\ShopOwner;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{


    public function sendOTPUser(Request $request, $gateway, $type = 'verification', $userType)
    {
        $userData =null;

        if ($userType == 0) {
            $userData = AppUsers::Where([['phone_no', $request->phone_no]])->first();
        } elseif ($userType == 1) {
            $userData = FuelProvider::Where([['phone_no', $request->phone_no]])->first();
        }

        if ($userData && $userData['verified'] === 1 &&  $type === 'verification') {
            return ['otp' => '', 'success' => false];
        } else {

            $string = '0123456789';
            $string_shuffled = str_shuffle($string);
            $otp = substr($string_shuffled, 1, 4);
            $message = $otp . ' your verification code for ' . env('APP_NAME');

            if ($gateway === 'twilio') {
                $this->twilio($request->phone_no, $message);
            } else {
                $this->textLocal($request->phone_no, $message);
            }

            return ['otp' => $otp, 'success' => true];
        }
    }
    private function textLocal($ph, $message)
    {
        try {
            //code...


            $apiKey = urlencode(env("TEXT_LOCAL_API"));
            $sender = urlencode('TXTLCL');
            $message = rawurlencode($message);
            $ph = '91' . $ph;
            $data = array('apikey' => $apiKey, 'numbers' => $ph, 'sender' => $sender, 'message' => $message);
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            //throw $th;

        }
    }
    private function twilio($ph, $message)
    {
        try {
            $d =   AdminSetting::get(['country_code'])->first();
            $ph =  $d['country_code'] . $ph;
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_NUMBER");
            AdminSetting::get(['id', 'verification', 'sms_gateway'])->first();
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $ph,
                ['from' => $twilio_number, 'body' => $message]
            );
        } catch (\Exception $e) {
        }
    }
    public function updateTwilio(Request $request)
    {
        $data = [
            'TWILIO_SID' => $request->TWILIO_SID,
            'TWILIO_AUTH_TOKEN' => $request->TWILIO_AUTH_TOKEN,
            'TWILIO_NUMBER' => $request->TWILIO_NUMBER,
            'TEXT_LOCAL_API' => $request->TEXT_LOCAL_API,
        ];
        //  country_code
        try {
            (new AdminSettingController)->updateENV($data);
        } catch (\Throwable $th) {
        }

        $verification = 0;
        if ($request->verification == '1') {
            $verification = 1;
        } else {

            $verification = 0;
        }
        $pp = AdminSetting::get()->first();
        $pp->country_code = $request->country_code;
        $pp->sms_gateway = $request->sms_gateway;
        $pp->verification = $verification;
        $pp->update();
        // return "true";
        return redirect('setting')->withStatus(__('Twilio Configuration updated successfully.'));
    }
}
