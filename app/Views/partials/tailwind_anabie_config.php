<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "error-container": "#ffdad6",
        "on-secondary-container": "#5c2400",
        "on-secondary-fixed": "#341100",
        "surface-tint": "#565e74",
        "secondary": "#9d4300",
        "tertiary": "#000000",
        "on-tertiary": "#ffffff",
        "secondary-container": "#fd761a",
        "on-primary-container": "#7c839b",
        "tertiary-fixed-dim": "#7bd0ff",
        "on-surface": "#0b1c30",
        "on-tertiary-container": "#008ebf",
        "on-secondary-fixed-variant": "#783200",
        "on-primary-fixed-variant": "#3f465c",
        "surface-bright": "#f8f9ff",
        "surface-variant": "#d3e4fe",
        "surface-container-high": "#dce9ff",
        "surface-container-lowest": "#ffffff",
        "on-tertiary-fixed-variant": "#004c69",
        "primary-fixed-dim": "#bec6e0",
        "on-background": "#0b1c30",
        "on-tertiary-fixed": "#001e2c",
        "secondary-fixed": "#ffdbca",
        "inverse-primary": "#bec6e0",
        "outline": "#76777d",
        "on-primary-fixed": "#131b2e",
        "surface-container": "#e5eeff",
        "primary-fixed": "#dae2fd",
        "on-secondary": "#ffffff",
        "primary-container": "#131b2e",
        "surface": "#f8f9ff",
        "inverse-on-surface": "#eaf1ff",
        "on-error-container": "#93000a",
        "on-primary": "#ffffff",
        "outline-variant": "#c6c6cd",
        "on-surface-variant": "#45464d",
        "error": "#ba1a1a",
        "primary": "#0b1c30",
        "tertiary-fixed": "#c4e7ff",
        "surface-dim": "#cbdbf5",
        "on-error": "#ffffff",
        "surface-container-highest": "#d3e4fe",
        "surface-container-low": "#eff4ff",
        "secondary-fixed-dim": "#ffb690",
        "background": "#f8f9ff",
        "tertiary-container": "#001e2c",
        "inverse-surface": "#213145"
      },
      borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
      spacing: {
        sidebar_width: "280px", lg: "24px", xxl: "48px", sm: "8px",
        max_content_width: "1440px", md: "16px", base: "4px", xl: "32px", xs: "4px"
      },
      fontFamily: {
        "label-md": ["Inter"], "label-sm": ["Inter"], "body-md": ["Inter"],
        "h1": ["Inter"], "h2": ["Inter"], "body-sm": ["Inter"], "body-lg": ["Inter"], "h3": ["Inter"]
      },
      fontSize: {
        "label-md": ["14px", { lineHeight: "1.2", letterSpacing: "0.05em", fontWeight: "600" }],
        "label-sm": ["12px", { lineHeight: "1.2", fontWeight: "500" }],
        "body-md": ["16px", { lineHeight: "1.5", fontWeight: "400" }],
        "h1": ["36px", { lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "700" }],
        "h2": ["24px", { lineHeight: "1.3", letterSpacing: "-0.01em", fontWeight: "600" }],
        "body-sm": ["14px", { lineHeight: "1.5", fontWeight: "400" }],
        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
        "h3": ["20px", { lineHeight: "1.4", fontWeight: "600" }]
      }
    }
  }
};
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
.bg-pattern {
  background-color: #0b1c30;
  background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
  background-size: 24px 24px;
}
.login-card-glow {
  box-shadow: 0 4px 20px -2px rgba(157,67,0,0.1), 0 8px 40px -4px rgba(11,28,48,0.2);
}
</style>
