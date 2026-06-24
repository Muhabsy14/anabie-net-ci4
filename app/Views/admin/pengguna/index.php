<div class="space-y-6">
<div class="flex justify-between items-center">
<h2 class="text-2xl font-bold text-primary">Kelola Admin</h2>
<button onclick="document.getElementById('modalAdmin').classList.remove('hidden')" class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold">+ Tambah Admin</button>
</div>
<div class="table-responsive bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
<table class="w-full text-sm">
<thead class="bg-surface-container-low border-b"><tr class="text-left"><th class="p-4">Username</th><th>Nama</th><th>Email</th><th>No. HP</th><th class="text-right p-4">Aksi</th></tr></thead>
<tbody>
<?php foreach ($pengguna as $u): ?>
<tr class="border-b"><td class="p-4"><?= esc($u['username']) ?></td><td><?= esc($u['nama_lengkap']) ?></td><td><?= esc($u['email']) ?></td><td><?= esc($u['no_hp']) ?></td>
<td class="p-4 text-right">
<?php if ((int)$u['id'] !== (int)session()->get('user_id')): ?>
<a href="<?= panel_url('admin/delete/' . $u['id'], $panelPrefix ?? null) ?>" class="text-error text-xs" onclick="return confirm('Hapus admin ini?')">Hapus</a>
<?php endif; ?>
</td></tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<div id="modalAdmin" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-xl p-6 w-full max-w-md">
<h3 class="text-lg font-bold mb-4">Tambah Admin</h3>
<form method="post" action="<?= panel_url('admin', $panelPrefix ?? null) ?>" class="space-y-3"><?= csrf_field() ?>
<input name="nama_lengkap" class="w-full border rounded-lg p-2 text-sm" placeholder="Nama" required/>
<input name="username" class="w-full border rounded-lg p-2 text-sm" placeholder="Username" required/>
<input name="email" type="email" class="w-full border rounded-lg p-2 text-sm" placeholder="Email" required/>
<input name="no_hp" class="w-full border rounded-lg p-2 text-sm" placeholder="No. HP"/>
<input name="password" type="password" class="w-full border rounded-lg p-2 text-sm" placeholder="Password" required/>
<button type="submit" class="w-full bg-secondary text-white py-2 rounded-lg font-semibold">Simpan</button>
<button type="button" onclick="document.getElementById('modalAdmin').classList.add('hidden')" class="w-full border py-2 rounded-lg text-sm mt-2">Batal</button>
</form>
</div>
</div>
