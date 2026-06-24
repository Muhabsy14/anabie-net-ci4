<div class="space-y-6">
<div class="flex flex-wrap justify-between items-start gap-4">
<h2 class="text-2xl font-bold text-primary">Kirim Notifikasi Via WhatsApp</h2>
<?php if ($cloudEnabled): ?>
<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
<span class="material-symbols-outlined text-sm">cloud_done</span> Cloud API Aktif
</span>
<?php elseif ($cloudConfigured): ?>
<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">API belum lengkap (token/phone ID)</span>
<?php else: ?>
<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-surface-container text-on-surface-variant text-xs font-semibold">Mode: WhatsApp manual (wa.me)</span>
<?php endif; ?>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<h3 class="font-semibold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-green-600">chat</span> Form Pesan
</h3>
<form method="post" action="<?= panel_url('notifikasi/kirim', $panelPrefix ?? null) ?>" class="space-y-4">
<?= csrf_field() ?>
<select name="pelanggan_id" id="select-pelanggan-wa" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-4 focus:ring-secondary/10 focus:border-secondary" required>
<option value="">Pilih pelanggan</option>
<?php foreach ($pelanggan as $p): ?>
<option value="<?= $p['id'] ?>" data-harga="<?= (float) $p['harga'] ?>"><?= esc($p['nama_lengkap']) ?> — JT: <?= esc($p['jatuh_tempo_format']) ?> — <?= esc($p['no_hp']) ?></option>
<?php endforeach; ?>
</select>
<div id="info-jatuh-tempo" class="hidden p-3 rounded-lg bg-secondary-fixed/30 border border-secondary/20 text-sm">
<p class="font-semibold text-on-secondary-fixed-variant">Info jatuh tempo pelanggan</p>
<p id="info-jt-detail" class="mt-1 text-on-surface-variant"></p>
<button type="button" id="btn-template-wa" class="mt-2 text-xs font-semibold text-secondary hover:underline">Isi template pesan tagihan</button>
</div>
<textarea name="pesan" id="textarea-pesan-wa" rows="6" class="w-full border border-outline-variant rounded-lg p-3 text-sm focus:ring-4 focus:ring-secondary/10 focus:border-secondary" placeholder="Contoh: Yth. Budi, tagihan WiFi Anabie Net bulan ini sebesar Rp 355.000 jatuh tempo 15 Mei 2026. Terima kasih." required></textarea>
<label class="text-sm font-semibold text-on-surface-variant">Metode pengiriman</label>
<select name="mode" class="w-full border border-outline-variant rounded-lg p-3 text-sm">
<option value="auto">Otomatis (API dulu, cadangan wa.me)</option>
<?php if ($cloudEnabled): ?>
<option value="api">Hanya WhatsApp Cloud API</option>
<?php endif; ?>
<option value="wame">Hanya buka WhatsApp (wa.me)</option>
</select>
<button type="submit" class="w-full bg-secondary text-on-secondary py-3 rounded-lg font-label-md font-semibold flex items-center justify-center gap-2 shadow-lg shadow-secondary/20 hover:bg-secondary-container transition-all">
<span class="material-symbols-outlined">send</span>
<?= $cloudEnabled ? 'Kirim via Cloud API' : 'Buka WhatsApp & Kirim' ?>
</button>
<p class="text-xs text-on-surface-variant leading-relaxed">
<?php if ($cloudEnabled): ?>
Pesan dikirim otomatis melalui <strong>WhatsApp Business Cloud API</strong> (Meta). Jika gagal dan mode otomatis, sistem membuka wa.me.
<?php else: ?>
Aktifkan API di file <code>.env</code> (lihat README). Saat ini menggunakan tautan <code>wa.me</code>.
<?php endif; ?>
</p>
</form>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<h3 class="font-semibold mb-4">Riwayat Notifikasi</h3>
<ul class="space-y-3 max-h-[28rem] overflow-y-auto">
<?php foreach ($riwayat as $r): ?>
<li class="p-3 rounded-lg bg-surface-container-low border border-outline-variant/30 text-sm">
<div class="flex justify-between items-start gap-2">
<p class="font-semibold"><?= esc($r['nama_lengkap'] ?? '—') ?></p>
<span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded <?= ($r['metode_kirim'] ?? '') === 'cloud_api' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
<?= ($r['metode_kirim'] ?? 'wa_me') === 'cloud_api' ? 'API' : 'wa.me' ?>
</span>
</div>
<p class="text-on-surface-variant mt-1"><?= esc($r['pesan']) ?></p>
<p class="text-xs mt-2 text-outline">
<?= esc($r['created_at']) ?> —
<span class="<?= $r['status_kirim'] === 'terkirim' ? 'text-green-700' : ($r['status_kirim'] === 'gagal' ? 'text-error' : '') ?>"><?= esc($r['status_kirim']) ?></span>
<?php if (!empty($r['wa_message_id'])): ?> | ID: <?= esc($r['wa_message_id']) ?><?php endif; ?>
</p>
<?php if (!empty($r['api_error'])): ?>
<p class="text-xs text-error mt-1"><?= esc($r['api_error']) ?></p>
<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>

<?= view('partials/pelanggan_jatuh_tempo_js', ['pelanggan' => $pelanggan]) ?>
<script>
(function () {
  const sel = document.getElementById('select-pelanggan-wa');
  const info = document.getElementById('info-jatuh-tempo');
  const detail = document.getElementById('info-jt-detail');
  const pesan = document.getElementById('textarea-pesan-wa');
  const btnTpl = document.getElementById('btn-template-wa');

  function refresh() {
    const data = window.pelangganJatuhTempo?.[sel.value];
    if (!data) {
      info.classList.add('hidden');
      return;
    }
    info.classList.remove('hidden');
    detail.innerHTML = data.label_bulanan + '<br/>Jatuh tempo bulan ini: <strong class="text-secondary">' + data.jatuh_tempo_label + '</strong><br/>Tanggal pemasangan: ' + data.tanggal_pasang;
  }

  btnTpl?.addEventListener('click', function () {
    const data = window.pelangganJatuhTempo?.[sel.value];
    if (!data) return;
    const nominal = new Intl.NumberFormat('id-ID').format(data.harga || 0);
  pesan.value = 'Yth. ' + data.nama + ', tagihan WiFi Anabie Net bulan ini sebesar Rp ' + nominal +
      '. Mohon dibayar sebelum jatuh tempo ' + data.jatuh_tempo_label + '. Terima kasih — Anabie Net Warungasem.';
  });

  sel?.addEventListener('change', refresh);
  refresh();
})();
</script>
