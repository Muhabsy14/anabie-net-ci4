<?php
$pelangganMap = [];
foreach ($pelanggan as $p) {
    $pelangganMap[$p['id']] = $p;
}
$panel = $panelPrefix ?? 'admin';
?>
<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Kelola Pembayaran</h2>

<div class="bg-surface-container-low border border-outline-variant rounded-xl p-4">
<div class="flex flex-wrap justify-between items-center gap-3 mb-4">
<h3 class="font-semibold text-primary flex items-center gap-2">
<span class="material-symbols-outlined text-secondary">calendar_month</span>
Jadwal Jatuh Tempo — <?= nama_bulan($bulan) ?> <?= $tahun ?>
</h3>
<form method="get" class="flex flex-wrap gap-2 items-center">
<select name="bulan" class="border rounded-lg p-2 text-sm">
<?php for ($i = 1; $i <= 12; $i++): ?><option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= nama_bulan($i) ?></option><?php endfor; ?>
</select>
<input name="tahun" type="number" value="<?= $tahun ?>" class="border rounded-lg p-2 text-sm w-24"/>
<button type="submit" class="bg-primary text-on-primary px-3 py-2 rounded-lg text-sm">Filter</button>
</form>
</div>
<div class="table-responsive">
<table class="w-full text-sm bg-surface-container-lowest rounded-lg overflow-hidden">
<thead class="bg-primary text-on-primary">
<tr>
<th class="p-3 text-left">Tgl. JT</th>
<th class="p-3 text-left">Pelanggan</th>
<th class="p-3 text-left">Pemasangan</th>
<th class="p-3 text-left">Paket</th>
<th class="p-3 text-left">Tagihan</th>
</tr>
</thead>
<tbody>
<?php foreach ($pelanggan as $p):
    $tagihanPel = array_filter($tagihan, static fn ($t) => (int) $t['pelanggan_id'] === (int) $p['id'] && (int) $t['periode_bulan'] === $bulan && (int) $t['periode_tahun'] === $tahun);
    $tagihanRow = $tagihanPel ? reset($tagihanPel) : null;
    $st = status_keterlambatan_tagihan($p['jatuh_tempo_periode'], $tagihanRow['status'] ?? 'belum_lunas');
?>
<tr class="border-b border-outline-variant/20 hover:bg-surface-container-low/40">
<td class="p-3 whitespace-nowrap">
<span class="font-bold text-secondary"><?= (int) ($p['hari_jatuh_tempo'] ?? 0) ?></span>
<span class="text-on-surface-variant">/bulan</span>
<div class="text-xs font-semibold"><?= esc($p['jatuh_tempo_format']) ?></div>
<span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $st['class'] ?>"><?= esc($st['label']) ?></span>
</td>
<td class="p-3 font-semibold"><?= esc($p['nama_lengkap']) ?></td>
<td class="p-3 text-xs text-on-surface-variant whitespace-nowrap"><?= esc($p['tanggal_pasang_format']) ?></td>
<td class="p-3 text-xs"><?= esc($p['nama_paket']) ?></td>
<td class="p-3 text-xs">
<?php if ($tagihanRow): ?>
<?= badge_status_tagihan($tagihanRow['status']) ?> <?= format_rupiah($tagihanRow['jumlah']) ?>
<?php else: ?>
<span class="text-on-surface-variant">Belum dibuat — <a href="<?= panel_url('tagihan', $panel) ?>" class="text-secondary underline">Buat tagihan</a></span>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
<h3 class="font-semibold mb-4">Catat Pembayaran</h3>
<form method="post" action="<?= panel_url('pembayaran', $panel) ?>" enctype="multipart/form-data" class="space-y-3"><?= csrf_field() ?>
<select name="tagihan_id" class="w-full border rounded-lg p-2 text-sm">
<option value="">— Tanpa tagihan —</option>
<?php foreach ($tagihan as $t): if ($t['status'] === 'lunas') continue;
    $jtLabel = ! empty($t['jatuh_tempo']) ? format_tanggal_indo($t['jatuh_tempo']) : '-';
?>
<option value="<?= $t['id'] ?>"><?= esc($t['nama_lengkap']) ?> | JT: <?= $jtLabel ?> | <?= periode_tagihan((int)$t['periode_bulan'], (int)$t['periode_tahun']) ?> (<?= format_rupiah($t['jumlah']) ?>)</option>
<?php endforeach; ?>
</select>
<select name="pelanggan_id" class="w-full border rounded-lg p-2 text-sm" required>
<?php foreach ($pelanggan as $p): ?>
<option value="<?= $p['id'] ?>"><?= esc($p['nama_lengkap']) ?> — JT <?= esc($p['jatuh_tempo_format']) ?></option>
<?php endforeach; ?>
</select>
<input name="tanggal_bayar" type="date" class="w-full border rounded-lg p-2 text-sm" value="<?= date('Y-m-d') ?>" required/>
<input name="jumlah" type="number" class="w-full border rounded-lg p-2 text-sm" placeholder="Jumlah" required/>
<select name="metode" class="w-full border rounded-lg p-2 text-sm"><option>Transfer Bank</option><option>Tunai</option><option>E-Wallet</option></select>
<textarea name="keterangan" class="w-full border rounded-lg p-2 text-sm" placeholder="Keterangan"></textarea>
<div>
<label class="text-xs font-semibold text-on-surface-variant block mb-1">Bukti Pembayaran</label>
<input name="bukti_pembayaran" type="file" accept="image/jpeg,image/png,image/webp,application/pdf" class="w-full border rounded-lg p-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-secondary file:text-on-secondary"/>
<p class="text-[11px] text-on-surface-variant mt-1">Format: JPG, PNG, WEBP, atau PDF. Maks. 2 MB.</p>
</div>
<button type="submit" class="w-full bg-secondary text-white py-2 rounded-lg font-semibold">Simpan Pembayaran</button>
</form>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
<h3 class="p-4 font-semibold border-b">Riwayat Pembayaran</h3>
<div class="table-responsive">
<table class="w-full text-sm">
<thead class="bg-surface-container-low"><tr class="text-left text-on-surface-variant"><th class="p-4">Tanggal</th><th>Pelanggan</th><th>Periode</th><th>Jumlah</th><th>Metode</th><th>Bukti</th></tr></thead>
<tbody>
<?php foreach ($pembayaran as $pb): ?>
<tr class="border-b">
<td class="p-4"><?= esc($pb['tanggal_bayar']) ?></td>
<td><?= esc($pb['nama_lengkap']) ?></td>
<td><?= $pb['periode_bulan'] ? periode_tagihan((int)$pb['periode_bulan'], (int)$pb['periode_tahun']) : '-' ?></td>
<td class="font-semibold text-secondary"><?= format_rupiah($pb['jumlah']) ?></td>
<td><?= esc($pb['metode']) ?></td>
<td class="p-4">
<?php if (! empty($pb['bukti_pembayaran'])): ?>
<a href="<?= bukti_pembayaran_url($pb['bukti_pembayaran']) ?>" target="_blank" class="inline-flex items-center gap-1 text-secondary text-xs font-semibold">
<span class="material-symbols-outlined text-sm">visibility</span> Lihat
</a>
<?php else: ?>
<span class="text-on-surface-variant text-xs">-</span>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
