<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class WhatsApp extends BaseConfig
{
    /**
     * WhatsApp Cloud API (Meta) — https://developers.facebook.com/docs/whatsapp/cloud-api
     * Set whatsapp.cloud.enabled = true di .env setelah token & phone_number_id valid.
     */
    public bool $cloudEnabled = false;

    public string $accessToken = '';

    public string $phoneNumberId = '';

    public string $apiVersion = 'v21.0';

    /** Fallback wa.me jika API gagal atau nonaktif */
    public bool $fallbackWaMe = true;

    public function __construct()
    {
        parent::__construct();

        $this->cloudEnabled  = filter_var(env('whatsapp.cloud.enabled', false), FILTER_VALIDATE_BOOLEAN);
        $this->accessToken   = (string) env('whatsapp.cloud.access_token', '');
        $this->phoneNumberId = (string) env('whatsapp.cloud.phone_number_id', '');
        $this->apiVersion    = (string) env('whatsapp.cloud.api_version', 'v21.0');
        $this->fallbackWaMe  = filter_var(env('whatsapp.fallback_wame', true), FILTER_VALIDATE_BOOLEAN);
    }

    public function isCloudReady(): bool
    {
        return $this->cloudEnabled
            && $this->accessToken !== ''
            && $this->phoneNumberId !== '';
    }
}
