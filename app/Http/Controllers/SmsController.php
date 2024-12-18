<?php

namespace App\Http\Controllers;

use App\Models\SmsConfirmation;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SmsController extends Controller {

    public function sendCode(Request $request) {

        $request->validate([
            'phone' => 'required|string|starts_with:+',
            'domain' => 'nullable|string'
        ]);

        $code = rand(10000, 99999);

        SmsConfirmation::create([
            'phone' => $request->phone,
            'code' => $code
        ]);

        return json_encode(["status" => "OK", "sms" => [
            $request->phone => [
                'status' => 'OK',
                'code' => $code
            ]
        ]]);

        $from = match ($request->domain) {
            'gazpromoptika.ru' => 'GAZoptika',
            'dmzed.ru' => 'DZmed',
            default => 'GAZoptika,'
        };


        $sms = new SmsService(config('services.sms.api_id'));

        $message = "Код для записи к доктору $code";

        return $sms->sendSms($request->phone, $message, $from);

    }

    public function verifySms (Request $request) {

        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
        ]);

        $code = SmsConfirmation::where("code", "=", $request->code)->where("phone", "=", $request->phone)->where('created_at', '>=', Carbon::now()->subMinutes(5))->first();

        if (!$code) {
            return response()->json(['message' => 'Код неверный или срок его действия истёк', 'status' => "ERROR", 'code' => $code]);
        }

        return response()->json(['message' => 'Код подтверждён успешно', 'status' => "OK", 'code' => $code]);

    }

}


