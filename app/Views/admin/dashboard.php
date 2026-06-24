<div class="space-y-8">
<h2 class="text-3xl font-bold text-primary">Dashboard <?= esc($user['role'] ?? 'Admin') ?></h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary-fixed rounded-lg"><span class="material-symbols-outlined text-primary">group</span></div>
</div>
<p class="text-sm text-on-surface-variant">Total Pelanggan</p>
<p class="text-3xl font-bold text-primary"><?= $totalPelanggan ?></p>
<p class="text-xs text-green-600 mt-1"><?= $pelangganAktif ?> aktif</p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
<div class="p-2 bg-secondary-fixed rounded-lg inline-block mb-4"><span class="material-symbols-outlined text-secondary">receipt_long</span></div>
<p class="text-sm text-on-surface-variant">Tagihan Belum Lunas</p>
<p class="text-3xl font-bold text-primary"><?= $tagihanPending ?></p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
<div class="p-2 bg-primary-fixed rounded-lg inline-block mb-4"><span class="material-symbols-outlined text-primary">campaign</span></div>
<p class="text-sm text-on-surface-variant">Pengaduan Baru</p>
<p class="text-3xl font-bold text-primary"><?= $pengaduanBaru ?></p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
<div class="p-2 bg-secondary-fixed rounded-lg inline-block mb-4"><span class="material-symbols-outlined text-secondary">payments</span></div>
<p class="text-sm text-on-surface-variant">Pendapatan Bulan Ini</p>
<p class="text-2xl font-bold text-primary"><?= format_rupiah($pendapatanBulanIni) ?></p>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
<h3 class="text-lg font-semibold mb-4">Pelanggan Terbaru</h3>
<div class="table-responsive">
<table class="w-full text-sm">
<thead><tr class="border-b text-left text-on-surface-variant"><th class="py-2">Kode</th><th>Nama</th><th>Paket</th><th>Status</th></tr></thead>
<tbody>
<?php foreach ($pelangganTerbaru as $p): ?>
<tr class="border-b border-outline-variant/30 hover:bg-surface-container-low">
<td class="py-3"><?= esc($p['kode_pelanggan']) ?></td>
<td><?= esc($p['nama_lengkap']) ?></td>
<td><?= esc($p['nama_paket']) ?></td>
<td><span class="px-2 py-1 rounded-full text-xs <?= $p['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100' ?>"><?= esc($p['status']) ?></span></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
<h3 class="text-lg font-semibold mb-4">Pengaduan Terbaru</h3>
<?php if (empty($pengaduanTerbaru)): ?>
<p class="text-sm text-on-surface-variant">Belum ada pengaduan.</p>
<?php else: ?>
<ul class="space-y-3">
<?php foreach ($pengaduanTerbaru as $pg): ?>
<li class="p-3 rounded-lg bg-surface-container-low border border-outline-variant/30">
<p class="font-semibold text-sm"><?= esc($pg['judul']) ?></p>
<p class="text-xs text-on-surface-variant"><?= esc($pg['nama_lengkap']) ?> — <?= badge_status_pengaduan($pg['status']) ?></p>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>
</div>
