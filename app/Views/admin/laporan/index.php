<div class="space-y-6">
<div class="flex flex-wrap justify-between items-center gap-4">
<h2 class="text-2xl font-bold text-primary"><?= ($jenisLaporan ?? 'operasional') === 'resmi' ? 'Laporan' : 'Laporan Operasional' ?></h2>
<a href="<?= panel_url('laporan/pdf?' . http_build_query(['bulan' => $bulan, 'tahun' => $tahun]), $panelPrefix ?? null) ?>" class="inline-flex items-center gap-2 bg-secondary text-on-secondary px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:bg-secondary-container transition-colors" target="_blank">
<span class="material-symbols-outlined text-lg">picture_as_pdf</span>
Cetak PDF
</a>
</div>
<form method="get" class="flex flex-wrap gap-3 items-end bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
<div>
<label class="text-xs font-semibold text-on-surface-variant">Bulan</label>
<select name="bulan" class="block border border-outline-variant rounded-lg p-2 text-sm mt-1 focus:ring-2 focus:ring-secondary/30">
<?php for ($i = 1; $i <= 12; $i++): ?><option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= nama_bulan($i) ?></option><?php endfor; ?>
</select>
</div>
<div>
<label class="text-xs font-semibold text-on-surface-variant">Tahun</label>
<input name="tahun" type="number" value="<?= $tahun ?>" class="block border border-outline-variant rounded-lg p-2 text-sm mt-1 w-28 focus:ring-2 focus:ring-secondary/30"/>
</div>
<button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold">Tampilkan</button>
</form>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<p class="text-sm text-on-surface-variant">Total Pendapatan</p>
<p class="text-2xl font-bold text-secondary"><?= format_rupiah($totalPendapatan) ?></p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<p class="text-sm text-on-surface-variant">Tagihan Lunas</p>
<p class="text-2xl font-bold text-green-600"><?= $tagihanLunas ?></p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<p class="text-sm text-on-surface-variant">Belum Lunas</p>
<p class="text-2xl font-bold text-error"><?= $tagihanBelum ?></p>
</div>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm table-responsive">
<table class="w-full text-sm">
<thead class="bg-primary text-on-primary"><tr class="text-left"><th class="p-4">Tanggal</th><th>Pelanggan</th><th>Jumlah</th><th>Metode</th></tr></thead>
<tbody>
<?php if (empty($pembayaran)): ?>
<tr><td colspan="4" class="p-8 text-center text-on-surface-variant">Tidak ada data pembayaran.</td></tr>
<?php else: foreach ($pembayaran as $pb): ?>
<tr class="border-b border-outline-variant/30 hover:bg-surface-container-low/50">
<td class="p-4"><?= esc(date('d/m/Y', strtotime($pb['tanggal_bayar']))) ?></td>
<td><?= esc($pb['nama_lengkap']) ?></td>
<td class="font-semibold text-secondary"><?= format_rupiah($pb['jumlah']) ?></td>
<td><?= esc($pb['metode']) ?></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>
</div>
