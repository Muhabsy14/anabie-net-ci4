<?php $nama = explode(' ', session()->get('nama_lengkap') ?? 'Pelanggan')[0]; ?>
<section class="space-y-8">
<h2 class="text-3xl font-bold text-primary">Selamat datang, <?= esc($nama) ?></h2>
<p class="text-lg text-on-surface-variant">Pantau koneksi dan kelola tagihan WiFi Anda dengan mudah.</p>
<div class="grid grid-cols-12 gap-6">
<div class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-xl border border-outline-variant p-8 shadow-sm relative overflow-hidden">
<?php if ($tagihanAktif): ?>
<span class="bg-secondary-container text-on-secondary-container px-4 py-1 rounded-full text-xs font-semibold mb-2 inline-block">Menunggu Pembayaran</span>
<h3 class="text-2xl font-bold text-primary mb-4">Tagihan Aktif</h3>
<p class="text-sm text-on-surface-variant">Total Tagihan <?= periode_tagihan((int)$tagihanAktif['periode_bulan'], (int)$tagihanAktif['periode_tahun']) ?></p>
<p class="text-4xl font-bold text-primary my-2"><?= format_rupiah($tagihanAktif['jumlah']) ?></p>
<p class="text-sm text-error flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> Jatuh tempo: <?= date('d F Y', strtotime($tagihanAktif['jatuh_tempo'])) ?></p>
<a href="<?= base_url('pelanggan/tagihan') ?>" class="inline-flex mt-6 bg-secondary text-on-secondary px-6 py-3 rounded-lg font-semibold items-center gap-2">
<span class="material-symbols-outlined">account_balance_wallet</span> Lihat Tagihan
</a>
<?php else: ?>
<h3 class="text-2xl font-bold text-primary">Tidak ada tagihan aktif</h3>
<p class="text-on-surface-variant mt-2">Semua tagihan Anda sudah lunas.</p>
<?php endif; ?>
</div>
<div class="col-span-12 lg:col-span-4 bg-primary text-on-primary rounded-xl p-6">
<h3 class="text-secondary font-bold mb-2">Paket Anda</h3>
<?php if ($pelanggan): ?>
<p class="text-xl font-bold"><?= esc($pelanggan['nama_paket']) ?></p>
<p class="text-on-primary/70"><?= esc($pelanggan['kecepatan']) ?></p>
<p class="text-secondary-fixed-dim text-2xl font-bold mt-4"><?= format_rupiah($pelanggan['harga']) ?>/bln</p>
<p class="text-xs mt-4 text-on-primary/60">Status: <?= esc($pelanggan['status']) ?></p>
<?php endif; ?>
</div>
</div>
<?php if (!empty($pengaduan)): ?>
<div class="bg-surface-container-lowest border rounded-xl p-6">
<h3 class="font-semibold mb-4">Pengaduan Terakhir</h3>
<?php $pg = $pengaduan[0]; ?>
<p class="font-bold"><?= esc($pg['judul']) ?></p>
<p class="text-sm text-on-surface-variant mt-1"><?= badge_status_pengaduan($pg['status']) ?></p>
</div>
<?php endif; ?>
</section>
