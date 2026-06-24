<div class="max-w-2xl space-y-6">
<h2 class="text-2xl font-bold text-primary">Profil <?= esc($user['role'] ?? 'Admin') ?></h2>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8">
<form method="post" action="<?= panel_url('profil', $panelPrefix ?? null) ?>" class="space-y-4"><?= csrf_field() ?>
<div class="flex items-center gap-4 mb-6">
<div class="w-20 h-20 rounded-full bg-secondary text-on-secondary flex items-center justify-center text-3xl font-bold"><?= strtoupper(substr($profil['nama_lengkap'], 0, 1)) ?></div>
<div>
<p class="font-bold text-lg"><?= esc($profil['nama_lengkap']) ?></p>
<p class="text-sm text-on-surface-variant">@<?= esc($profil['username']) ?> — <?= esc($user['role'] ?? 'Administrator') ?></p>
</div>
</div>
<label class="text-sm font-semibold">Nama Lengkap</label>
<input name="nama_lengkap" value="<?= esc($profil['nama_lengkap']) ?>" class="w-full border rounded-lg p-3 text-sm" required/>
<label class="text-sm font-semibold">Email</label>
<input name="email" type="email" value="<?= esc($profil['email']) ?>" class="w-full border rounded-lg p-3 text-sm" required/>
<label class="text-sm font-semibold">No. HP</label>
<input name="no_hp" value="<?= esc($profil['no_hp']) ?>" class="w-full border rounded-lg p-3 text-sm"/>
<label class="text-sm font-semibold">Password Baru (kosongkan jika tidak diubah)</label>
<input name="password" type="password" class="w-full border rounded-lg p-3 text-sm"/>
<button type="submit" class="bg-secondary text-white px-6 py-3 rounded-lg font-semibold">Simpan Perubahan</button>
</form>
</div>
</div>
