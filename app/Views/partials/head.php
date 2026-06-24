<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "secondary": "#9d4300",
        "secondary-container": "#fd761a",
        "on-secondary": "#ffffff",
        "on-secondary-container": "#5c2400",
        "primary-container": "#131b2e",
        "primary": "#0b1c30",
        "on-primary": "#ffffff",
        "on-primary-container": "#7c839b",
        "surface": "#f8f9ff",
        "background": "#f8f9ff",
        "on-background": "#0b1c30",
        "on-surface": "#0b1c30",
        "on-surface-variant": "#45464d",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#eff4ff",
        "surface-container": "#e5eeff",
        "surface-container-high": "#dce9ff",
        "outline-variant": "#c6c6cd",
        "outline": "#76777d",
        "error": "#ba1a1a",
        "primary-fixed": "#dae2fd",
        "primary-fixed-dim": "#bec6e0",
        "secondary-fixed": "#ffdbca",
        "secondary-fixed-dim": "#ffb690",
      },
      borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
      spacing: { sidebar_width: "280px", max_content_width: "1440px", xs: "4px", sm: "8px", md: "16px", lg: "24px", xl: "32px", xxl: "48px" },
      fontFamily: { sans: ["Inter", "sans-serif"] },
    },
  },
};
</script>
<style>
body { font-family: 'Inter', sans-serif; }
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
.bg-pattern {
  background-color: #0b1c30;
  background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
  background-size: 24px 24px;
}
.login-card-glow { box-shadow: 0 4px 20px -2px rgba(157,67,0,0.1), 0 8px 40px -4px rgba(11,28,48,0.2); }
.table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%; }
.table-responsive table { min-width: 560px; }
@media (max-width: 1023px) {
  .touch-target { min-height: 44px; min-width: 44px; }
}
</style>
<title><?= esc($title ?? 'Anabie Net') ?></title>
