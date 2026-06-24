<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<?= view('partials/tailwind_anabie_config') ?>
<title><?= esc($title ?? 'Login - Anabie Net') ?></title>
</head>
<?php $activeRole = old('role', $role ?? 'pelanggan'); ?>
<body class="bg-pattern min-h-screen flex items-center justify-center p-md font-body-md text-on-surface">
<main class="w-full max-w-[440px] flex flex-col gap-lg">
<div class="flex flex-col items-center gap-md">
<div class="w-24 h-24 bg-surface-container-lowest rounded-xl p-sm shadow-xl flex items-center justify-center">
<img alt="Anabie Net Logo" class="w-full h-full object-contain" src="<?= logo_url() ?>"/>
</div>
<div class="text-center">
<h1 class="font-h2 text-h2 text-surface-container-lowest tracking-tight">Selamat Datang di Anabie Net</h1>
<p class="font-body-sm text-body-sm text-on-primary-container/80 mt-xs">Kelola koneksi internet Anda dengan mudah</p>
<p class="font-label-sm text-label-sm text-surface-container-lowest/50 mt-xs">Kec. Warungasem, Kab. Batang</p>
</div>
</div>
<div class="bg-surface-container-lowest rounded-xl p-xl login-card-glow border border-outline-variant/30">
<div class="flex p-xs bg-surface-container-low rounded-lg mb-xl">
<a href="<?= base_url('login?role=pelanggan') ?>" class="flex-1 py-sm px-sm rounded-md font-label-md text-label-md text-center transition-all duration-200 <?= $activeRole === 'pelanggan' ? 'bg-secondary text-on-secondary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">Pelanggan</a>
<a href="<?= base_url('login?role=admin') ?>" class="flex-1 py-sm px-sm rounded-md font-label-md text-label-md text-center transition-all duration-200 <?= $activeRole === 'admin' ? 'bg-secondary text-on-secondary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">Admin</a>
<a href="<?= base_url('login?role=owner') ?>" class="flex-1 py-sm px-sm rounded-md font-label-md text-label-md text-center transition-all duration-200 <?= $activeRole === 'owner' ? 'bg-secondary text-on-secondary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">Owner</a>
</div>
<?= view('partials/flash') ?>
<form class="flex flex-col gap-lg" method="post" action="<?= base_url('login') ?>">
<?= csrf_field() ?>
<input type="hidden" name="role" value="<?= esc($activeRole) ?>"/>
<div class="flex flex-col gap-sm">
<label class="font-label-md text-label-md text-on-surface-variant px-xs">Username atau Email</label>
<div class="relative group">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">person</span>
<input name="login" value="<?= esc(old('login', $loginHint ?? '')) ?>" class="w-full pl-[48px] pr-md py-md bg-surface border border-outline-variant rounded-lg focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all placeholder:text-outline-variant font-body-sm text-body-sm" placeholder="Masukkan username Anda" type="text" required autocomplete="username"/>
</div>
</div>
<div class="flex flex-col gap-sm">
<div class="flex justify-between items-center px-xs">
<label class="font-label-md text-label-md text-on-surface-variant">Kata Sandi</label>
<a class="font-label-sm text-label-sm text-secondary hover:underline" href="#" onclick="alert('Hubungi admin Anabie Net untuk reset password.');return false;">Lupa password?</a>
</div>
<div class="relative group">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">lock</span>
<input id="password" name="password" class="w-full pl-[48px] pr-[48px] py-md bg-surface border border-outline-variant rounded-lg focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all placeholder:text-outline-variant font-body-sm text-body-sm" placeholder="••••••••" type="password" required autocomplete="current-password"/>
<button class="absolute right-md top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors" type="button" onclick="togglePassword()">
<span class="material-symbols-outlined" id="togglePwdIcon">visibility</span>
</button>
</div>
</div>
<div class="flex items-center gap-sm px-xs">
<input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary/20 transition-all cursor-pointer" id="remember" name="remember" value="1" type="checkbox" <?= old('remember') ? 'checked' : '' ?>/>
<label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Ingat saya di perangkat ini</label>
</div>
<button class="w-full bg-secondary text-on-secondary font-label-md text-label-md py-md rounded-lg shadow-lg shadow-secondary/20 hover:bg-secondary-container hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-sm" type="submit">
Masuk Sekarang
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</button>
</form>
<div class="mt-xl pt-xl border-t border-outline-variant/50 flex flex-col gap-md">
<p class="text-center font-body-sm text-body-sm text-on-surface-variant">Belum berlangganan Anabie Net?</p>
<div class="grid grid-cols-2 gap-md">
<button type="button" class="flex items-center justify-center gap-sm py-sm px-md border border-outline-variant rounded-lg font-label-sm text-label-sm hover:bg-surface-container-low transition-colors text-on-surface" onclick="alert('Hubungi Anabie Net Warungasem untuk info paket WiFi.')">
<span class="material-symbols-outlined text-[18px]">info</span>
Cek Paket
</button>
<button type="button" class="flex items-center justify-center gap-sm py-sm px-md border border-outline-variant rounded-lg font-label-sm text-label-sm hover:bg-surface-container-low transition-colors text-on-surface" onclick="window.open('https://wa.me/<?= esc(preg_replace('/[^0-9]/', '', env('whatsapp.admin_number', '6281234567890'))) ?>','_blank')">
<span class="material-symbols-outlined text-[18px]">support_agent</span>
Bantuan
</button>
</div>
</div>
</div>
<div class="flex justify-center gap-xl opacity-60">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-surface-container-lowest">verified_user</span>
<span class="font-label-sm text-label-sm text-surface-container-lowest">Aman & Terenkripsi</span>
</div>
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-surface-container-lowest">speed</span>
<span class="font-label-sm text-label-sm text-surface-container-lowest">High Speed Auth</span>
</div>
</div>
</main>
<div class="fixed bottom-lg right-lg hidden md:block">
<div class="bg-surface-container-lowest/10 backdrop-blur-md border border-surface-container-lowest/20 p-md rounded-xl max-w-[280px]">
<div class="flex gap-md">
<div class="w-12 h-12 rounded-lg overflow-hidden shrink-0 bg-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-secondary text-3xl">router</span>
</div>
<div>
<p class="font-label-sm text-label-sm text-surface-container-lowest">Koneksi Stabil</p>
<p class="font-body-sm text-[12px] leading-snug text-on-primary-container/70">Nikmati kecepatan hingga 1Gbps dengan teknologi fiber terdepan.</p>
</div>
</div>
</div>
</div>
<script>
function togglePassword() {
  const input = document.getElementById('password');
  const icon = document.getElementById('togglePwdIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.textContent = 'visibility_off';
  } else {
    input.type = 'password';
    icon.textContent = 'visibility';
  }
}
</script>
</body>
</html>
