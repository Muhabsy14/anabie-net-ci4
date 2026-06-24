<div class="space-y-6">
<h2 class="text-2xl font-bold text-primary">Tagihan Saya</h2>
<div class="grid gap-4">
<?php foreach ($tagihan as $t): ?>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-wrap justify-between items-center gap-4">
<div>
<p class="text-sm text-on-surface-variant">Periode</p>
<p class="text-xl font-bold text-primary"><?= periode_tagihan((int)$t['periode_bulan'], (int)$t['periode_tahun']) ?></p>
<p class="text-sm mt-1">Jatuh tempo: <?= date('d/m/Y', strtotime($t['jatuh_tempo'])) ?></p>
</div>
<div class="text-right">
<p class="text-2xl font-bold text-secondary"><?= format_rupiah($t['jumlah']) ?></p>
<div class="mt-2"><?= badge_status_tagihan($t['status']) ?></div>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
