<!DOCTYPE html>
<html lang="id">
<head>
<?= view('partials/head', ['title' => $title ?? 'Pelanggan - Anabie Net']) ?>
</head>
<body class="bg-background text-on-background min-h-screen">
<div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden" aria-hidden="true"></div>

<aside id="app-sidebar" class="fixed left-0 top-0 bottom-0 z-50 flex flex-col p-4 gap-2 bg-primary shadow-xl w-[280px] max-w-[min(280px,88vw)] -translate-x-full transition-transform duration-300 ease-out lg:translate-x-0">
<div class="flex items-center justify-between gap-3 mb-6 px-1">
<div class="flex items-center gap-3 min-w-0">
<img alt="Anabie Net" class="w-10 h-10 shrink-0 object-contain rounded-lg" src="<?= logo_url() ?>"/>
<div class="min-w-0">
<span class="text-lg text-secondary font-bold block truncate">Anabie Net</span>
<span class="text-xs text-on-primary/60">Portal Pelanggan</span>
</div>
</div>
<button type="button" id="sidebar-close" class="lg:hidden touch-target flex items-center justify-center rounded-lg text-on-primary hover:bg-primary-fixed-dim/10" aria-label="Tutup menu">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<nav class="flex-1 flex flex-col gap-2 overflow-y-auto overscroll-contain">
<?php
$menus = [
    'dashboard' => ['url' => '/pelanggan/dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
    'tagihan'   => ['url' => '/pelanggan/tagihan', 'icon' => 'receipt_long', 'label' => 'Tagihan Saya'],
    'riwayat'   => ['url' => '/pelanggan/riwayat', 'icon' => 'history', 'label' => 'Riwayat Pembayaran'],
    'pengaduan' => ['url' => '/pelanggan/pengaduan', 'icon' => 'campaign', 'label' => 'Ajukan Pengaduan'],
    'profil'    => ['url' => '/pelanggan/profil', 'icon' => 'person', 'label' => 'Profil'],
];
foreach ($menus as $key => $menu):
    $active = ($activeMenu ?? '') === $key;
    $cls = $active
        ? 'flex items-center gap-3 bg-secondary text-on-secondary rounded-lg px-4 py-3 border-l-4 border-secondary-fixed'
        : 'flex items-center gap-3 text-on-primary/70 hover:text-on-primary px-4 py-3 rounded-lg hover:bg-primary-fixed-dim/10 transition-all';
?>
<a class="<?= $cls ?>" href="<?= base_url(ltrim($menu['url'], '/')) ?>">
<span class="material-symbols-outlined shrink-0"><?= $menu['icon'] ?></span>
<span class="text-sm font-semibold"><?= $menu['label'] ?></span>
</a>
<?php endforeach; ?>
</nav>
<div class="mt-auto border-t border-on-primary/10 pt-4">
<a class="flex items-center gap-3 text-on-primary/70 hover:text-on-primary px-4 py-3" href="<?= base_url('logout') ?>">
<span class="material-symbols-outlined">logout</span>
<span class="text-sm font-semibold">Keluar</span>
</a>
</div>
</aside>

<main class="min-h-screen flex flex-col w-full lg:ml-[280px]">
<header class="sticky top-0 z-30 flex items-center gap-3 h-16 px-4 lg:px-8 bg-surface-container-lowest border-b border-outline-variant shadow-sm">
<button type="button" id="sidebar-open" class="lg:hidden touch-target flex items-center justify-center rounded-lg bg-surface-container-low shrink-0" aria-label="Buka menu">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="flex items-center gap-2 min-w-0 flex-1">
<img alt="Anabie Net" class="h-9 w-9 shrink-0 object-contain" src="<?= logo_url() ?>"/>
<h1 class="text-lg sm:text-xl text-secondary font-black tracking-tight truncate">Anabie Net</h1>
</div>
<div class="flex items-center gap-2 shrink-0 pl-2 border-l border-outline-variant">
<div class="text-right hidden sm:block max-w-[100px] md:max-w-[140px]">
<p class="text-sm font-semibold truncate"><?= esc($user['nama'] ?? '') ?></p>
<p class="text-xs text-on-surface-variant truncate">ID: <?= esc($user['kode'] ?? '') ?></p>
</div>
<div class="h-10 w-10 rounded-full border-2 border-secondary bg-primary-fixed flex items-center justify-center font-bold text-primary text-sm"><?= strtoupper(substr($user['nama'] ?? 'P', 0, 1)) ?></div>
</div>
</header>
<div class="p-4 md:p-6 lg:p-8 max-w-[1440px] w-full mx-auto flex-1">
<?= view('partials/flash') ?>
<?= $content ?>
</div>
</main>
<?= view('partials/mobile_nav_script') ?>
</body>
</html>
