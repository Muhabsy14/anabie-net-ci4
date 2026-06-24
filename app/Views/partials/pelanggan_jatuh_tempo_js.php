<?php
/** @var list<array<string, mixed>> $pelanggan */
$map = [];
foreach ($pelanggan as $p) {
    $map[$p['id']] = [
        'nama'              => $p['nama_lengkap'],
        'tanggal_pasang'    => $p['tanggal_berlangganan'] ?? '',
        'hari_jt'           => $p['hari_jatuh_tempo'] ?? null,
        'jatuh_tempo'       => $p['jatuh_tempo_periode'] ?? '',
        'jatuh_tempo_label' => $p['jatuh_tempo_format'] ?? '',
        'label_bulanan'     => $p['label_jatuh_tempo'] ?? '',
        'harga'             => $p['harga'] ?? 0,
    ];
}
?>
<script>
window.pelangganJatuhTempo = <?= json_encode($map, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
window.hitungJatuhTempoDariPasang = function(tanggalPasang, bulan, tahun) {
  if (!tanggalPasang) return '';
  const d = new Date(tanggalPasang + 'T00:00:00');
  const hariPasang = d.getDate();
  const terakhir = new Date(tahun, bulan, 0).getDate();
  const hari = Math.min(hariPasang, terakhir);
  const mm = String(bulan).padStart(2, '0');
  const dd = String(hari).padStart(2, '0');
  return tahun + '-' + mm + '-' + dd;
};
</script>
