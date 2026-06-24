<div class="max-w-2xl space-y-6">
<h2 class="text-2xl font-bold text-primary">Profil Pengguna</h2>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8">
<?php if ($pelanggan ?? null): ?>
<div class="mb-6 p-4 bg-surface-container-low rounded-lg text-sm">
<p><strong>ID Pelanggan:</strong> <?= esc($pelanggan['kode_pelanggan']) ?></p>
<p><strong>Paket:</strong> <?= esc($pelanggan['nama_paket']) ?> (<?= esc($pelanggan['kecepatan']) ?>)</p>
<p><strong>Alamat:</strong> <?= esc($pelanggan['alamat']) ?></p>
</div>
<?php endif; ?>
<form method="post" action="<?= base_url('pelanggan/profil') ?>" class="space-y-4"><?= csrf_field() ?>
<label class="text-sm font-semibold">Nama Lengkap</label>
<input name="nama_lengkap" value="<?= esc($profil['nama_lengkap']) ?>" class="w-full border rounded-lg p-3 text-sm" required/>
<label class="text-sm font-semibold">Email</label>
<input name="email" type="email" value="<?= esc($profil['email']) ?>" class="w-full border rounded-lg p-3 text-sm" required/>
<label class="text-sm font-semibold">No. HP / WhatsApp</label>
<input name="no_hp" value="<?= esc($profil['no_hp']) ?>" class="w-full border rounded-lg p-3 text-sm"/>
<label class="text-sm font-semibold">Password Baru (opsional)</label>
<input name="password" type="password" class="w-full border rounded-lg p-3 text-sm"/>
<button type="submit" class="bg-secondary text-white px-6 py-3 rounded-lg font-semibold">Simpan</button>
</form>
</div>
</div>
