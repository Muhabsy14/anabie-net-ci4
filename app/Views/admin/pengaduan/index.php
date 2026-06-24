<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Kelola Pengaduan</h2>
<div class="space-y-4">
<?php foreach ($pengaduan as $pg): ?>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
<div class="flex flex-wrap justify-between gap-2 mb-3">
<div>
<h3 class="font-bold text-primary"><?= esc($pg['judul']) ?></h3>
<p class="text-sm text-on-surface-variant"><?= esc($pg['nama_lengkap']) ?> (<?= esc($pg['kode_pelanggan']) ?>) — <?= esc($pg['created_at']) ?></p>
</div>
<?= badge_status_pengaduan($pg['status']) ?>
</div>
<p class="text-sm mb-4"><?= esc($pg['isi']) ?></p>
<form method="post" action="<?= panel_url('pengaduan/update/' . $pg['id'], $panelPrefix ?? null) ?>" class="grid grid-cols-1 md:grid-cols-3 gap-3 border-t pt-4">
<?= csrf_field() ?>
<select name="status" class="border rounded-lg p-2 text-sm">
<option value="menunggu" <?= $pg['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
<option value="diproses" <?= $pg['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
<option value="selesai" <?= $pg['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
</select>
<input name="balasan_admin" class="md:col-span-2 border rounded-lg p-2 text-sm" placeholder="Balasan admin" value="<?= esc($pg['balasan_admin'] ?? '') ?>"/>
<button type="submit" class="md:col-start-3 bg-secondary text-white rounded-lg py-2 text-sm font-semibold">Update</button>
</form>
</div>
<?php endforeach; ?>
</div>
</div>
