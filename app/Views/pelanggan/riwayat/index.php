<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Riwayat Pembayaran</h2>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden table-responsive">
<table class="w-full text-sm">
<thead class="bg-surface-container-low border-b"><tr class="text-left text-on-surface-variant"><th class="p-4">Tanggal</th><th>Periode</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Keterangan</th></tr></thead>
<tbody>
<?php if (empty($riwayat)): ?>
<tr><td colspan="6" class="p-8 text-center text-on-surface-variant">Belum ada riwayat pembayaran.</td></tr>
<?php else: foreach ($riwayat as $r): ?>
<tr class="border-b hover:bg-surface-container-low/50">
<td class="p-4"><?= date('d/m/Y', strtotime($r['tanggal_bayar'])) ?></td>
<td><?= $r['periode_bulan'] ? periode_tagihan((int)$r['periode_bulan'], (int)$r['periode_tahun']) : '-' ?></td>
<td class="font-semibold text-secondary"><?= format_rupiah($r['jumlah']) ?></td>
<td><?= esc($r['metode']) ?></td>
<td>
<?php if (! empty($r['bukti_pembayaran'])): ?>
<a href="<?= bukti_pembayaran_url($r['bukti_pembayaran']) ?>" target="_blank" class="text-secondary text-xs font-semibold">Lihat</a>
<?php else: ?>-<?php endif; ?>
</td>
<td class="text-on-surface-variant"><?= esc($r['keterangan'] ?? '-') ?></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>
</div>
