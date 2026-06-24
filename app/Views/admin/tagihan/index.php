<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Kelola Tagihan</h2>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm table-responsive">
<div class="flex flex-wrap justify-between items-center gap-3 p-4 border-b border-outline-variant/30">
<h3 class="font-semibold text-primary">Daftar Tagihan</h3>
<form method="get" class="flex flex-wrap gap-2 items-center">
<select name="bulan" class="border rounded-lg p-2 text-sm">
<?php for ($i = 1; $i <= 12; $i++): ?><option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= nama_bulan($i) ?></option><?php endfor; ?>
</select>
<input name="tahun" type="number" value="<?= $tahun ?>" class="border rounded-lg p-2 text-sm w-24"/>
<button type="submit" class="bg-primary text-on-primary px-3 py-2 rounded-lg text-sm">Filter</button>
</form>
</div>
<table class="w-full text-sm">
<thead class="bg-primary text-on-primary"><tr class="text-left"><th class="p-4">Pelanggan</th><th>Periode</th><th>Jumlah</th><th>Jatuh Tempo</th><th>Status</th><th class="p-4 text-right">Aksi</th></tr></thead>
<tbody>
<?php if (empty($tagihan)): ?>
<tr><td colspan="6" class="p-8 text-center text-on-surface-variant">Belum ada tagihan.</td></tr>
<?php else: foreach ($tagihan as $t): ?>
<tr class="border-b border-outline-variant/30 hover:bg-surface-container-low/40">
<td class="p-4">
<p class="font-semibold"><?= esc($t['nama_lengkap']) ?></p>
<p class="text-xs text-on-surface-variant font-mono"><?= esc($t['kode_pelanggan']) ?></p>
</td>
<td><?= periode_tagihan((int) $t['periode_bulan'], (int) $t['periode_tahun']) ?></td>
<td class="font-semibold text-secondary"><?= format_rupiah($t['jumlah']) ?></td>
<td><?= ! empty($t['jatuh_tempo']) ? format_tanggal_indo($t['jatuh_tempo']) : '-' ?></td>
<td><?= badge_status_tagihan($t['status']) ?></td>
<td class="p-4 text-right">
<a href="<?= panel_url('tagihan/delete/' . $t['id'], $panelPrefix ?? null) ?>" class="text-error text-xs" onclick="return confirm('Hapus tagihan ini?')">Hapus</a>
</td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<h3 class="font-semibold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-secondary">add_circle</span>
Buat Tagihan Baru
</h3>
<form method="post" action="<?= panel_url('tagihan', $panelPrefix ?? null) ?>" class="space-y-3" id="form-tagihan"><?= csrf_field() ?>
<select name="pelanggan_id" id="select-pelanggan-tagihan" class="w-full border rounded-lg p-2 text-sm" required>
<?php foreach ($pelanggan as $p): ?>
<option value="<?= $p['id'] ?>" data-jt="<?= esc($p['jatuh_tempo_periode']) ?>"><?= esc($p['nama_lengkap']) ?> — JT: <?= esc($p['jatuh_tempo_format']) ?></option>
<?php endforeach; ?>
</select>
<div id="preview-jt" class="text-sm p-3 rounded-lg bg-surface-container-low border border-outline-variant/50 text-on-surface-variant"></div>
<input name="periode_bulan" id="input-bulan" type="number" min="1" max="12" class="w-full border rounded-lg p-2 text-sm" value="<?= $bulan ?>"/>
<input name="periode_tahun" id="input-tahun" type="number" class="w-full border rounded-lg p-2 text-sm" value="<?= $tahun ?>"/>
<label class="text-xs font-semibold text-on-surface-variant">Jatuh tempo (otomatis dari tgl. pemasangan)</label>
<input name="jatuh_tempo" id="input-jatuh-tempo" type="date" class="w-full border rounded-lg p-2 text-sm bg-surface-container-low" readonly/>
<button type="submit" class="w-full bg-secondary text-on-secondary py-2 rounded-lg font-semibold">Generate Tagihan</button>
</form>
</div>
</div>
</div>

<?= view('partials/pelanggan_jatuh_tempo_js', ['pelanggan' => $pelanggan]) ?>
<script>
(function () {
  const sel = document.getElementById('select-pelanggan-tagihan');
  const bulan = document.getElementById('input-bulan');
  const tahun = document.getElementById('input-tahun');
  const jtInput = document.getElementById('input-jatuh-tempo');
  const preview = document.getElementById('preview-jt');

  function updateJatuhTempo() {
    const id = sel?.value;
    const data = window.pelangganJatuhTempo?.[id];
    const b = parseInt(bulan?.value || '<?= $bulan ?>', 10);
    const y = parseInt(tahun?.value || '<?= $tahun ?>', 10);
    if (!data || !data.tanggal_pasang) {
      preview.textContent = '';
      return;
    }
    const jt = window.hitungJatuhTempoDariPasang(data.tanggal_pasang, b, y);
    jtInput.value = jt;
    preview.innerHTML = '<strong class="text-secondary">' + data.nama + '</strong><br/>' +
      data.label_bulanan + '<br/>Jatuh tempo periode ini: <strong>' + (data.jatuh_tempo_label || jt) + '</strong>';
  }

  sel?.addEventListener('change', updateJatuhTempo);
  bulan?.addEventListener('change', updateJatuhTempo);
  tahun?.addEventListener('change', updateJatuhTempo);
  updateJatuhTempo();
})();
</script>
