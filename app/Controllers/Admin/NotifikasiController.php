<?php

namespace App\Controllers\Admin;

use App\Libraries\WhatsAppCloudService;
use App\Models\NotifikasiWhatsappModel;
use App\Models\PelangganModel;
use App\Models\TemplateWhatsappModel;

class NotifikasiController extends BaseAdminController
{
    public function index()
    {
        $waConfig = config('WhatsApp');

        $bulan = (int) date('n');
        $tahun = (int) date('Y');

        return $this->render('admin/notifikasi/index', [
            'activeMenu'    => 'notifikasi',
            'title'         => 'Kirim Notifikasi WhatsApp - Anabie Net',
            'pelanggan'     => model(PelangganModel::class)->getWithJatuhTempo($bulan, $tahun),
            'riwayat'       => model(NotifikasiWhatsappModel::class)->getRiwayat(30),
            'templates'     => model(TemplateWhatsappModel::class)->getTemplateAktif(),
            'cloudEnabled'  => $waConfig->isCloudReady(),
            'cloudConfigured' => $waConfig->cloudEnabled,
        ]);
    }

    public function kirim()
    {
        $pelangganId = (int) $this->request->getPost('pelanggan_id');
        $pesan       = trim((string) $this->request->getPost('pesan'));
        $mode        = $this->request->getPost('mode') ?? 'auto';
        if ($mode === 'wame') {
            $mode = 'manual';
        }

        if ($pesan === '') {
            return redirect()->back()->with('error', 'Pesan tidak boleh kosong.');
        }

        $pelanggan = model(PelangganModel::class)->getWithRelations($pelangganId);
        if (! $pelanggan || empty($pelanggan['no_hp'])) {
            return redirect()->back()->with('error', 'Nomor WhatsApp pelanggan tidak tersedia.');
        }

        $waService = new WhatsAppCloudService();
        $waConfig  = config('WhatsApp');

        if ($mode === 'manual') {
            model(NotifikasiWhatsappModel::class)->insert([
                'pelanggan_id'  => $pelangganId,
                'pesan'         => $pesan,
                'metode_kirim'  => 'wa_me',
                'status_kirim'  => 'terkirim',
            ]);

            return redirect()->to($waService->buildWaMeUrl($pelanggan['no_hp'], $pesan));
        }

        $useApi = in_array($mode, ['api', 'auto'], true) && $waService->isEnabled();
        $record = [
            'pelanggan_id' => $pelangganId,
            'pesan'        => $pesan,
            'metode_kirim' => 'wa_me',
            'status_kirim' => 'draft',
            'wa_message_id'=> null,
            'api_error'    => null,
        ];

        if ($useApi) {
            $result = $waService->sendText($pelanggan['no_hp'], $pesan);
            $record['metode_kirim'] = 'cloud_api';

            if ($result['success']) {
                $record['status_kirim']  = 'terkirim';
                $record['wa_message_id'] = $result['message_id'];
                model(NotifikasiWhatsappModel::class)->insert($record);

                return $this->redirectPanel(
                    'notifikasi',
                    'Pesan berhasil dikirim via WhatsApp Cloud API. ID: ' . ($result['message_id'] ?? '-')
                );
            }

            $record['status_kirim'] = 'gagal';
            $record['api_error']    = $result['error'];

            if (! $waConfig->fallbackWaMe || $mode === 'api') {
                model(NotifikasiWhatsappModel::class)->insert($record);

                return redirect()->back()->with('error', 'Gagal kirim API: ' . $result['error']);
            }
        }

        $record['metode_kirim'] = 'wa_me';
        $record['status_kirim'] = 'terkirim';
        model(NotifikasiWhatsappModel::class)->insert($record);

        $waUrl = $waService->buildWaMeUrl($pelanggan['no_hp'], $pesan);

        if ($useApi && $waConfig->fallbackWaMe) {
            session()->setFlashdata('success', 'API gagal — membuka WhatsApp manual sebagai cadangan.');
        }

        return redirect()->to($waUrl);
    }
}
