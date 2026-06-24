<?php

if (! function_exists('format_rupiah')) {
    function format_rupiah($amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}

if (! function_exists('nama_bulan')) {
    function nama_bulan(int $bulan): string
    {
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $bulanList[$bulan] ?? '';
    }
}

if (! function_exists('periode_tagihan')) {
    function periode_tagihan(int $bulan, int $tahun): string
    {
        return nama_bulan($bulan) . ' ' . $tahun;
    }
}

if (! function_exists('badge_status_tagihan')) {
    function badge_status_tagihan(string $status): string
    {
        return match ($status) {
            'lunas'       => '<span class="px-md py-xs rounded-full text-label-sm font-label-sm bg-green-100 text-green-800">Lunas</span>',
            'belum_lunas' => '<span class="px-md py-xs rounded-full text-label-sm font-label-sm bg-secondary-fixed text-on-secondary-fixed">Belum Lunas</span>',
            default       => esc($status),
        };
    }
}

if (! function_exists('badge_status_pengaduan')) {
    function badge_status_pengaduan(string $status): string
    {
        return match ($status) {
            'menunggu' => '<span class="px-md py-xs rounded-full text-label-sm font-label-sm bg-yellow-100 text-yellow-800">Menunggu</span>',
            'diproses' => '<span class="px-md py-xs rounded-full text-label-sm font-label-sm bg-blue-100 text-blue-800">Diproses</span>',
            'selesai'  => '<span class="px-md py-xs rounded-full text-label-sm font-label-sm bg-green-100 text-green-800">Selesai</span>',
            default    => esc($status),
        };
    }
}

if (! function_exists('logo_url')) {
    function logo_url(): string
    {
        $png = FCPATH . 'assets/img/logo-anabie.png';
        if (is_file($png)) {
            return base_url('assets/img/logo-anabie.png');
        }

        return base_url('assets/img/logo-anabie.svg');
    }
}

if (! function_exists('logo_path')) {
    function logo_path(): string
    {
        $png = FCPATH . 'assets/img/logo-anabie.png';
        if (is_file($png)) {
            return $png;
        }

        return FCPATH . 'assets/img/logo-anabie.svg';
    }
}

if (! function_exists('logo_base64')) {
    function logo_base64(): string
    {
        $path = logo_path();
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = $ext === 'png' ? 'image/png' : 'image/svg+xml';

        return 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($path));
    }
}

if (! function_exists('panel_url')) {
    function panel_url(string $path, ?string $panelPrefix = null): string
    {
        $prefix = $panelPrefix ?? session()->get('role');

        if (! in_array($prefix, ['owner', 'admin'], true)) {
            $prefix = 'admin';
        }

        return base_url($prefix . '/' . ltrim($path, '/'));
    }
}

if (! function_exists('bukti_pembayaran_url')) {
    function bukti_pembayaran_url(?string $filename): ?string
    {
        if (! $filename) {
            return null;
        }

        return base_url('uploads/bukti/' . $filename);
    }
}

if (! function_exists('hari_dari_tanggal_pasang')) {
    /** Hari jatuh tempo bulanan (1–31) dari tanggal pemasangan/berlangganan. */
    function hari_dari_tanggal_pasang(string $tanggalBerlangganan): int
    {
        return (int) date('j', strtotime($tanggalBerlangganan));
    }
}

if (! function_exists('hitung_jatuh_tempo')) {
    /**
     * Jatuh tempo periode tertentu = tanggal pasang di bulan/tahun periode tagihan.
     * Contoh: pasang 15 Jan → jatuh tempo Mei 2026 = 15 Mei 2026.
     */
    function hitung_jatuh_tempo(string $tanggalBerlangganan, ?int $bulan = null, ?int $tahun = null): string
    {
        $bulan = $bulan ?? (int) date('n');
        $tahun = $tahun ?? (int) date('Y');
        $hariPasang          = hari_dari_tanggal_pasang($tanggalBerlangganan);
        $hariTerakhirPeriode = (int) date('t', mktime(0, 0, 0, $bulan, 1, $tahun));
        $hari                = min($hariPasang, $hariTerakhirPeriode);

        return sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
    }
}

if (! function_exists('label_jatuh_tempo_bulanan')) {
    function label_jatuh_tempo_bulanan(string $tanggalBerlangganan): string
    {
        return 'Setiap tanggal ' . hari_dari_tanggal_pasang($tanggalBerlangganan) . ' setiap bulan';
    }
}

if (! function_exists('format_tanggal_indo')) {
    function format_tanggal_indo(string $dateYmd): string
    {
        $ts = strtotime($dateYmd);

        return date('d', $ts) . ' ' . nama_bulan((int) date('n', $ts)) . ' ' . date('Y', $ts);
    }
}

if (! function_exists('status_keterlambatan_tagihan')) {
    /** @return array{label: string, class: string} */
    function status_keterlambatan_tagihan(string $jatuhTempoYmd, string $statusTagihan = 'belum_lunas'): array
    {
        if ($statusTagihan === 'lunas') {
            return ['label' => 'Lunas', 'class' => 'bg-green-100 text-green-800'];
        }

        $today = strtotime(date('Y-m-d'));
        $due   = strtotime($jatuhTempoYmd);
        $diff  = (int) floor(($due - $today) / 86400);

        if ($diff < 0) {
            return ['label' => 'Terlambat ' . abs($diff) . ' hr', 'class' => 'bg-red-100 text-red-800'];
        }

        if ($diff <= 3) {
            return ['label' => $diff === 0 ? 'Jatuh tempo hari ini' : 'H-' . $diff, 'class' => 'bg-yellow-100 text-yellow-800'];
        }

        return ['label' => 'Aktif', 'class' => 'bg-blue-100 text-blue-800'];
    }
}

if (! function_exists('pelanggan_dengan_jatuh_tempo')) {
    /**
     * Melengkapi data pelanggan dengan info jatuh tempo periode berjalan.
     *
     * @param array<string, mixed> $pelanggan
     * @return array<string, mixed>
     */
    function pelanggan_dengan_jatuh_tempo(array $pelanggan, ?int $bulan = null, ?int $tahun = null): array
    {
        $bulan = $bulan ?? (int) date('n');
        $tahun = $tahun ?? (int) date('Y');
        $tgl   = $pelanggan['tanggal_berlangganan'] ?? null;

        if (! $tgl) {
            return $pelanggan;
        }

        $jatuhTempo = hitung_jatuh_tempo($tgl, $bulan, $tahun);

        $pelanggan['hari_jatuh_tempo']        = hari_dari_tanggal_pasang($tgl);
        $pelanggan['label_jatuh_tempo']       = label_jatuh_tempo_bulanan($tgl);
        $pelanggan['jatuh_tempo_periode']     = $jatuhTempo;
        $pelanggan['jatuh_tempo_format']      = format_tanggal_indo($jatuhTempo);
        $pelanggan['tanggal_pasang_format']   = format_tanggal_indo($tgl);

        return $pelanggan;
    }
}
