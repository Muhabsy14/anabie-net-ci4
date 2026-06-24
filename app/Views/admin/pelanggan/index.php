<div class="space-y-6">
<div class="flex flex-wrap justify-between items-center gap-4">
<h2 class="text-2xl font-bold text-primary">Kelola Pelanggan</h2>
<button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-secondary text-on-secondary px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2">
<span class="material-symbols-outlined text-lg">add</span> Tambah Pelanggan
</button>
</div>

<div class="bg-surface-container-low border border-outline-variant rounded-xl p-4 flex flex-wrap gap-3 items-end">
<form method="get" class="flex flex-wrap gap-3 items-end">
<div>
<label class="text-xs font-semibold text-on-surface-variant">Periode jatuh tempo</label>
<select name="bulan" class="block border rounded-lg p-2 text-sm mt-1">
<?php for ($i = 1; $i <= 12; $i++): ?><option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= nama_bulan($i) ?></option><?php endfor; ?>
</select>
</div>
<input name="tahun" type="number" value="<?= $tahun ?>" class="border rounded-lg p-2 text-sm w-24"/>
<button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold">Tampilkan</button>
</form>
<p class="text-xs text-on-surface-variant flex-1 min-w-[200px]">
<span class="material-symbols-outlined text-sm align-middle text-secondary">info</span>
Jatuh tempo dihitung dari <strong>tanggal pemasangan</strong> (mis. pasang tgl 15 → jatuh tempo setiap tanggal 15).
</p>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm table-responsive">
<table class="w-full text-sm">
<thead class="bg-surface-container-low border-b">
<tr class="text-left text-on-surface-variant">
<th class="p-4">Kode</th>
<th>Nama</th>
<th>Tgl. Pemasangan</th>
<th class="whitespace-nowrap">Jatuh Tempo (<?= nama_bulan($bulan) ?>)</th>
<th>Paket</th>
<th>No. HP</th>
<th>Status</th>
<th class="text-right">Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($pelanggan as $p):
    $statusJt = status_keterlambatan_tagihan($p['jatuh_tempo_periode'] ?? date('Y-m-d'));
?>
<tr class="border-b hover:bg-surface-container-low/50">
<td class="p-4 font-mono text-xs"><?= esc($p['kode_pelanggan']) ?></td>
<td class="p-4 font-semibold"><?= esc($p['nama_lengkap']) ?></td>
<td class="p-4 whitespace-nowrap text-on-surface-variant"><?= esc($p['tanggal_pasang_format'] ?? '-') ?></td>
<td class="p-4 whitespace-nowrap">
<div class="font-semibold text-secondary"><?= esc($p['jatuh_tempo_format'] ?? '-') ?></div>
<div class="text-[11px] text-on-surface-variant"><?= esc($p['label_jatuh_tempo'] ?? '') ?></div>
<span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $statusJt['class'] ?>"><?= esc($statusJt['label']) ?></span>
</td>
<td><?= esc($p['nama_paket']) ?> (<?= esc($p['kecepatan']) ?>)</td>
<td class="whitespace-nowrap"><?= esc($p['no_hp']) ?></td>
<td><span class="px-2 py-1 rounded-full text-xs <?= $p['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100' ?>"><?= esc($p['status']) ?></span></td>
<td class="p-4 text-right whitespace-nowrap">
<button type="button" onclick='editPelanggan(<?= json_encode($p) ?>)' class="text-secondary font-semibold text-xs mr-2">Edit</button>
<a href="<?= panel_url('pelanggan/delete/' . $p['id'], $panelPrefix ?? null) ?>" class="text-error text-xs" onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
<div class="bg-white rounded-xl p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
<h3 class="text-lg font-bold mb-4">Tambah Pelanggan</h3>
<form method="post" action="<?= panel_url('pelanggan', $panelPrefix ?? null) ?>" class="space-y-3">
<?= csrf_field() ?>
<input name="nama_lengkap" class="w-full border rounded-lg p-2 text-sm" placeholder="Nama lengkap" required/>
<input name="username" class="w-full border rounded-lg p-2 text-sm" placeholder="Username" required/>
<input name="email" type="email" class="w-full border rounded-lg p-2 text-sm" placeholder="Email" required/>
<input name="password" type="password" class="w-full border rounded-lg p-2 text-sm" placeholder="Password" required/>
<input name="no_hp" class="w-full border rounded-lg p-2 text-sm" placeholder="No. HP / WhatsApp" required/>
<textarea name="alamat" class="w-full border rounded-lg p-2 text-sm" placeholder="Alamat" required></textarea>
<select name="paket_id" class="w-full border rounded-lg p-2 text-sm" required>
<?php foreach ($paket as $pk): ?><option value="<?= $pk['id'] ?>"><?= esc($pk['nama_paket']) ?> - <?= format_rupiah($pk['harga']) ?></option><?php endforeach; ?>
</select>
<label class="text-xs font-semibold text-on-surface-variant">Tanggal pemasangan layanan (menentukan jatuh tempo bulanan)</label>
<input name="tanggal_berlangganan" type="date" class="w-full border rounded-lg p-2 text-sm" value="<?= date('Y-m-d') ?>" required/>
<select name="status" class="w-full border rounded-lg p-2 text-sm"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
<div class="flex gap-2 justify-end">
<button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm">Batal</button>
<button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg text-sm font-semibold">Simpan</button>
</div>
</form>
</div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
<div class="bg-white rounded-xl p-6 w-full max-w-lg">
<h3 class="text-lg font-bold mb-4">Edit Pelanggan</h3>
<form id="formEdit" method="post" class="space-y-3">
<?= csrf_field() ?>
<input name="nama_lengkap" id="edit_nama" class="w-full border rounded-lg p-2 text-sm" required/>
<input name="email" id="edit_email" type="email" class="w-full border rounded-lg p-2 text-sm" required/>
<input name="no_hp" id="edit_hp" class="w-full border rounded-lg p-2 text-sm" required/>
<textarea name="alamat" id="edit_alamat" class="w-full border rounded-lg p-2 text-sm" required></textarea>
<select name="paket_id" id="edit_paket" class="w-full border rounded-lg p-2 text-sm">
<?php foreach ($paket as $pk): ?><option value="<?= $pk['id'] ?>"><?= esc($pk['nama_paket']) ?></option><?php endforeach; ?>
</select>
<select name="status" id="edit_status" class="w-full border rounded-lg p-2 text-sm"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option><option value="suspend">Suspend</option></select>
<label class="text-xs font-semibold text-on-surface-variant">Tanggal pemasangan (ubah = ubah jatuh tempo)</label>
<input name="tanggal_berlangganan" id="edit_tgl_pasang" type="date" class="w-full border rounded-lg p-2 text-sm"/>
<p class="text-xs text-on-surface-variant" id="edit_jt_info"></p>
<div class="flex gap-2 justify-end">
<button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-sm">Batal</button>
<button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg text-sm font-semibold">Update</button>
</div>
</form>
</div>
</div>

<script>
function editPelanggan(p) {
  document.getElementById('formEdit').action = '<?= panel_url('pelanggan/update', $panelPrefix ?? null) ?>/' + p.id;
  document.getElementById('edit_nama').value = p.nama_lengkap;
  document.getElementById('edit_email').value = p.email;
  document.getElementById('edit_hp').value = p.no_hp;
  document.getElementById('edit_alamat').value = p.alamat;
  document.getElementById('edit_paket').value = p.paket_id;
  document.getElementById('edit_status').value = p.status;
  document.getElementById('edit_tgl_pasang').value = p.tanggal_berlangganan || '';
  document.getElementById('edit_jt_info').textContent = p.label_jatuh_tempo
    ? 'Jatuh tempo: ' + p.label_jatuh_tempo + ' (periode ini: ' + (p.jatuh_tempo_format || '-') + ')'
    : '';
  document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
