<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService {

    private readonly ?string $apiId;

    private readonly array $domainSender;

    public function __construct($apiId)
    {
        $this->apiId = $apiId;
        $this->domainSender = [
            'domain1' => 'someName',
            'domain2' => 'someName2'
        ];

    }

    public function sendSms(string $number, string $message, string $from) {


        $response = Http::withOptions([
            'verify' => false,
        ])->post("https://sms.ru/sms/send?api_id={$this->apiId}&to={$number}&msg={$message}&from={$from}&json=1");

        if (!$response->successful()) {
            Log::error('Ошибка при отправке SMS сообщения: ' . $response->json());
        }

        return new Response($response->json(), $response->status());

    }

}
