<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #0b1c30; margin: 24px; }
  h1 { color: #9d4300; font-size: 16px; margin: 0; }
  h2 { color: #131b2e; font-size: 14px; margin: 16px 0 8px; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
  .sub { color: #45464d; font-size: 10px; margin: 2px 0; }
  .meta { margin-bottom: 16px; }
  .stats { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
  .stats td { border: 1px solid #c6c6cd; padding: 10px; width: 33%; }
  .stats strong { display: block; font-size: 14px; color: #9d4300; margin-top: 4px; }
  table.data { width: 100%; border-collapse: collapse; }
  table.data th { background: #131b2e; color: #fff; padding: 8px; text-align: left; font-size: 10px; }
  table.data td { border-bottom: 1px solid #e5eeff; padding: 8px; }
  .footer { margin-top: 24px; font-size: 9px; color: #76777d; }
  .kop { width: 100%; border-bottom: 3px solid #9d4300; padding-bottom: 12px; margin-bottom: 16px; }
  .kop td { vertical-align: middle; }
  .kop-logo { width: 70px; height: 70px; object-fit: contain; }
  .kop-title { font-size: 18px; font-weight: bold; color: #131b2e; letter-spacing: 1px; }
  .kop-sub { font-size: 10px; color: #45464d; line-height: 1.5; }
  .ttd { margin-top: 40px; width: 220px; float: right; text-align: center; }
  .ttd-space { height: 60px; }
  .operasional-note { background: #e5eeff; padding: 8px 12px; border-left: 4px solid #9d4300; margin-bottom: 16px; font-size: 10px; }
</style>
</head>
<body>
<?php helper('anabie'); $resmi = ($jenisLaporan ?? 'operasional') === 'resmi'; ?>

<table class="kop">
  <tr>
    <td style="width:80px;">
      <img src="<?= logo_base64() ?>" class="kop-logo" alt="Anabie Net"/>
    </td>
    <td style="text-align:center;">
      <div class="kop-title">ANABIE NET</div>
      <div class="kop-sub">Layanan Internet WiFi — Kec. Warungasem, Kab. Batang, Jawa Tengah</div>
      <div class="kop-sub">Jl. Raya Warungasem No. 12 | Telp: 0812-3456-7890 | Email: info@anabienet.local</div>
    </td>
    <td style="width:80px;"></td>
  </tr>
</table>

<h2><?= $resmi ? 'Laporan Pembayaran' : 'Laporan Operasional Pembayaran' ?></h2>
<p style="text-align:center; color:#45464d; margin:0 0 16px;">Periode: <?= esc($periodeLabel) ?></p>

<?php if (! $resmi): ?>
<div class="operasional-note">Dokumen operasional internal — bukan laporan resmi perusahaan.</div>
<?php endif; ?>

<p class="meta">
  Dicetak: <?= esc($dicetakPada) ?> | Oleh: <?= esc($dicetakOleh) ?> | Total pelanggan terdaftar: <?= (int) $totalPelanggan ?>
</p>
<table class="stats">
  <tr>
    <td>Total Pendapatan</td>
    <td>Tagihan Lunas</td>
    <td>Tagihan Belum Lunas</td>
  </tr>
  <tr>
    <td><strong><?= esc(format_rupiah($totalPendapatan)) ?></strong></td>
    <td><strong><?= (int) $tagihanLunas ?></strong></td>
    <td><strong><?= (int) $tagihanBelum ?></strong></td>
  </tr>
</table>
<table class="data">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Kode Pelanggan</th>
      <th>Nama</th>
      <th>Jumlah</th>
      <th>Metode</th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($pembayaran)): ?>
    <tr><td colspan="6" style="text-align:center;padding:16px;">Tidak ada pembayaran pada periode ini.</td></tr>
  <?php else: ?>
    <?php foreach ($pembayaran as $i => $pb): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= esc(date('d/m/Y', strtotime($pb['tanggal_bayar']))) ?></td>
      <td><?= esc($pb['kode_pelanggan']) ?></td>
      <td><?= esc($pb['nama_lengkap']) ?></td>
      <td><?= esc(format_rupiah($pb['jumlah'])) ?></td>
      <td><?= esc($pb['metode']) ?></td>
    </tr>
    <?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>

<?php if ($resmi): ?>
<div class="ttd">
  <p>Warungasem, <?= esc(date('d F Y')) ?></p>
  <p>Owner Anabie Net</p>
  <div class="ttd-space"></div>
  <p><strong><?= esc($dicetakOleh) ?></strong></p>
</div>
<div style="clear:both;"></div>
<?php endif; ?>

<p class="footer">Dokumen ini digenerate otomatis oleh Sistem Informasi Manajemen Layanan & Pembayaran WiFi Anabie Net.</p>
</body>
</html>
