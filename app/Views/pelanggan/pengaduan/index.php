<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Ajukan Pengaduan</h2>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
<h3 class="font-semibold mb-4">Form Pengaduan Baru</h3>
<form method="post" action="<?= base_url('pelanggan/pengaduan') ?>" class="space-y-4"><?= csrf_field() ?>
<input name="judul" class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-secondary/30" placeholder="Judul pengaduan" required value="<?= esc(old('judul')) ?>"/>
<textarea name="isi" rows="5" class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-secondary/30" placeholder="Jelaskan kendala Anda..." required><?= esc(old('isi')) ?></textarea>
<button type="submit" class="w-full bg-secondary text-on-secondary py-3 rounded-lg font-semibold">Kirim Pengaduan</button>
</form>
</div>
<div class="space-y-4">
<h3 class="font-semibold">Riwayat Pengaduan</h3>
<?php foreach ($pengaduan as $pg): ?>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
<div class="flex justify-between items-start mb-2">
<p class="font-bold"><?= esc($pg['judul']) ?></p>
<?= badge_status_pengaduan($pg['status']) ?>
</div>
<p class="text-sm text-on-surface-variant mb-2"><?= esc($pg['isi']) ?></p>
<?php if ($pg['balasan_admin']): ?>
<div class="bg-surface-container-low rounded-lg p-3 text-sm border-l-4 border-secondary">
<strong class="text-secondary">Balasan Admin:</strong> <?= esc($pg['balasan_admin']) ?>
</div>
<?php endif; ?>
<p class="text-xs text-outline mt-2"><?= esc($pg['created_at']) ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
