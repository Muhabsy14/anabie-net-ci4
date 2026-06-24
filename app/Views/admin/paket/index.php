<div class="space-y-6">
<div class="flex justify-between items-center">
<h2 class="text-2xl font-bold text-primary">Kelola Paket & Layanan</h2>
<button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-secondary text-on-secondary px-4 py-2 rounded-lg text-sm font-semibold">+ Tambah Paket</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php foreach ($paket as $pk): ?>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<div class="flex justify-between items-start mb-4">
<span class="material-symbols-outlined text-secondary text-3xl">wifi</span>
<span class="px-2 py-1 rounded-full text-xs <?= $pk['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100' ?>"><?= esc($pk['status']) ?></span>
</div>
<h3 class="text-lg font-bold text-primary"><?= esc($pk['nama_paket']) ?></h3>
<p class="text-secondary font-semibold text-xl my-2"><?= format_rupiah($pk['harga']) ?><span class="text-sm text-on-surface-variant font-normal">/bulan</span></p>
<p class="text-sm text-on-surface-variant mb-2"><?= esc($pk['kecepatan']) ?></p>
<p class="text-sm text-on-surface-variant mb-4"><?= esc($pk['deskripsi']) ?></p>
<div class="flex gap-2">
<button onclick='editPaket(<?= json_encode($pk) ?>)' class="text-sm text-secondary font-semibold">Edit</button>
<a href="<?= panel_url('paket/delete/' . $pk['id'], $panelPrefix ?? null) ?>" class="text-sm text-error" onclick="return confirm('Hapus paket?')">Hapus</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-xl p-6 w-full max-w-md">
<h3 class="font-bold mb-4">Tambah Paket</h3>
<form method="post" action="<?= panel_url('paket', $panelPrefix ?? null) ?>" class="space-y-3"><?= csrf_field() ?>
<input name="nama_paket" class="w-full border rounded-lg p-2 text-sm" placeholder="Nama paket" required/>
<input name="kecepatan" class="w-full border rounded-lg p-2 text-sm" placeholder="Kecepatan (mis. 50 Mbps)" required/>
<input name="harga" type="number" class="w-full border rounded-lg p-2 text-sm" placeholder="Harga/bulan" required/>
<textarea name="deskripsi" class="w-full border rounded-lg p-2 text-sm" placeholder="Deskripsi"></textarea>
<select name="status" class="w-full border rounded-lg p-2 text-sm"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
<button type="submit" class="w-full bg-secondary text-white py-2 rounded-lg font-semibold">Simpan</button>
</form>
</div>
</div>
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-xl p-6 w-full max-w-md">
<h3 class="font-bold mb-4">Edit Paket</h3>
<form id="formEditPaket" method="post" class="space-y-3"><?= csrf_field() ?>
<input name="nama_paket" id="pk_nama" class="w-full border rounded-lg p-2 text-sm" required/>
<input name="kecepatan" id="pk_kec" class="w-full border rounded-lg p-2 text-sm" required/>
<input name="harga" id="pk_harga" type="number" class="w-full border rounded-lg p-2 text-sm" required/>
<textarea name="deskripsi" id="pk_desk" class="w-full border rounded-lg p-2 text-sm"></textarea>
<select name="status" id="pk_status" class="w-full border rounded-lg p-2 text-sm"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
<button type="submit" class="w-full bg-secondary text-white py-2 rounded-lg font-semibold">Update</button>
</form>
</div>
</div>
<script>
function editPaket(p) {
  document.getElementById('formEditPaket').action = '<?= panel_url('paket/update', $panelPrefix ?? null) ?>/' + p.id;
  document.getElementById('pk_nama').value = p.nama_paket;
  document.getElementById('pk_kec').value = p.kecepatan;
  document.getElementById('pk_harga').value = p.harga;
  document.getElementById('pk_desk').value = p.deskripsi || '';
  document.getElementById('pk_status').value = p.status;
  document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
