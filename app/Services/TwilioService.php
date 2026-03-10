<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;

class TwilioService
{
    private Client $client;
    private string $from;

    public function __construct()
    {
        $this->client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN')
        );
        $this->from = env('TWILIO_PHONE');
    }

    public function sendSms(string $to, string $message): bool
    {
        try {
            $this->client->messages->create(
                $this->formatPhone($to),
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );
            return true;
        } catch (Exception $e) {
            \Log::error('Twilio SMS Error: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) === 10) {
            return '+1' . $digits;
        }
        if (strlen($digits) === 11 && $digits[0] === '1') {
            return '+' . $digits;
        }
        return '+' . $digits;
    }
}