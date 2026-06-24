<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\WhatsApp as WhatsAppConfig;

class WhatsAppCloudService
{
    protected WhatsAppConfig $config;

    public function __construct(?WhatsAppConfig $config = null)
    {
        $this->config = $config ?? config('WhatsApp');
    }

    public function isEnabled(): bool
    {
        return $this->config->isCloudReady();
    }

    /**
     * @return array{success: bool, message_id: ?string, error: ?string, http_code: ?int}
     */
    public function sendText(string $phoneE164, string $message): array
    {
        if (! $this->isEnabled()) {
            return [
                'success'    => false,
                'message_id' => null,
                'error'      => 'WhatsApp Cloud API belum dikonfigurasi.',
                'http_code'  => null,
            ];
        }

        $to = $this->normalizePhone($phoneE164);
        if ($to === '') {
            return [
                'success'    => false,
                'message_id' => null,
                'error'      => 'Nomor telepon tidak valid.',
                'http_code'  => null,
            ];
        }

        $url = sprintf(
            'https://graph.facebook.com/%s/%s/messages',
            $this->config->apiVersion,
            $this->config->phoneNumberId
        );

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $to,
            'type'              => 'text',
            'text'              => [
                'preview_url' => false,
                'body'        => $message,
            ],
        ];

        /** @var CURLRequest $client */
        $client = service('curlrequest', [
            'timeout' => 30,
        ]);

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->config->accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $payload,
            ]);

            $httpCode = $response->getStatusCode();
            $body     = json_decode($response->getBody(), true);

            if ($httpCode >= 200 && $httpCode < 300) {
                $messageId = $body['messages'][0]['id'] ?? null;

                return [
                    'success'    => true,
                    'message_id' => $messageId,
                    'error'      => null,
                    'http_code'  => $httpCode,
                ];
            }

            $errorMsg = $body['error']['message'] ?? $response->getReasonPhrase();

            return [
                'success'    => false,
                'message_id' => null,
                'error'      => $errorMsg,
                'http_code'  => $httpCode,
            ];
        } catch (\Throwable $e) {
            log_message('error', 'WhatsApp API: ' . $e->getMessage());

            return [
                'success'    => false,
                'message_id' => null,
                'error'      => $e->getMessage(),
                'http_code'  => null,
            ];
        }
    }

    public function buildWaMeUrl(string $phone, string $message): string
    {
        $to = $this->normalizePhone($phone);

        return 'https://wa.me/' . $to . '?text=' . rawurlencode($message);
    }

    public function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8') && ! str_starts_with($digits, '62')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }
}
