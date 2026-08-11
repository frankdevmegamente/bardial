<!DOCTYPE html>
<html class="light" lang="es">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo $pageTitle ?? 'Bardial Inmobiliaria | Inmobiliaria de Lujo'; ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:wght@400;700&amp;family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "surface": "#f9f9f7",
                "on-error-container": "#93000a",
                "error-container": "#ffdad6",
                "background": "#f9f9f7",
                "secondary-container": "#fec32c",
                "tertiary": "#000000",
                "surface-variant": "#e2e3e1",
                "on-tertiary-container": "#91807b",
                "on-primary-fixed-variant": "#374955",
                "inverse-surface": "#2f3130",
                "surface-container-lowest": "#ffffff",
                "primary-fixed": "#d1e5f5",
                "tertiary-fixed": "#f3ded7",
                "inverse-on-surface": "#f1f1ef",
                "surface-bright": "#f9f9f7",
                "tertiary-container": "#241915",
                "primary": "#000000",
                "on-secondary-fixed": "#261a00",
                "surface-container-low": "#f4f4f2",
                "on-secondary-container": "#6e5200",
                "inverse-primary": "#b5c9d8",
                "surface-container-high": "#e8e8e6",
                "surface-container": "#eeeeec",
                "primary-container": "#0a1e29",
                "on-secondary-fixed-variant": "#5b4300",
                "on-surface-variant": "#43474b",
                "primary-fixed-dim": "#b5c9d8",
                "tertiary-fixed-dim": "#d6c2bc",
                "on-error": "#ffffff",
                "on-primary-container": "#738694",
                "on-tertiary-fixed-variant": "#51443f",
                "surface-dim": "#dadad8",
                "secondary": "#795900",
                "on-surface": "#1a1c1b",
                "surface-tint": "#4e616e",
                "on-secondary": "#ffffff",
                "secondary-fixed-dim": "#f8be26",
                "on-tertiary": "#ffffff",
                "on-primary": "#ffffff",
                "on-background": "#1a1c1b",
                "error": "#ba1a1a",
                "on-primary-fixed": "#0a1e29",
                "surface-container-highest": "#e2e3e1",
                "outline-variant": "#c3c7cb",
                "outline": "#73787c",
                "on-tertiary-fixed": "#241915",
                "secondary-fixed": "#ffdf9e",
                "brand-navy": "#081C27",
                "brand-gold": "#F0B71D",
                "brand-brown": "#5C4E49"
            },
            "borderRadius": {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            "spacing": {
                "margin-mobile": "20px",
                "gutter": "32px",
                "container-max": "1280px",
                "margin-desktop": "64px",
                "unit": "8px",
                "section-gap": "120px"
            },
            "fontFamily": {
                "title-lg": ["Montserrat"],
                "headline-md": ["Libre Caslon Text"],
                "display-lg": ["Libre Caslon Text"],
                "headline-lg-mobile": ["Libre Caslon Text"],
                "headline-lg": ["Libre Caslon Text"],
                "body-lg": ["Montserrat"],
                "label-md": ["Montserrat"],
                "body-md": ["Montserrat"]
            },
            "fontSize": {
                "title-lg": ["20px", {"lineHeight": "28px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                "headline-md": ["32px", {"lineHeight": "40px", "fontWeight": "400"}],
                "display-lg": ["64px", {"lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "headline-lg-mobile": ["32px", {"lineHeight": "40px", "fontWeight": "700"}],
                "headline-lg": ["48px", {"lineHeight": "56px", "fontWeight": "400"}],
                "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.1em", "fontWeight": "600"}],
                "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
        }
    }
}
</script>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
    }
    .text-balance { text-wrap: balance; }
    html { scroll-behavior: smooth; }
    ::selection { background: #F0B71D; color: #081C27; }
    ::-moz-selection { background: #F0B71D; color: #081C27; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f9f9f7; }
    ::-webkit-scrollbar-thumb { background: #081C27; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #F8BE26; }
    * { scrollbar-width: thin; scrollbar-color: #081C27 #f9f9f7; }
    .luxury-border {
        border: 1px solid rgba(92, 78, 73, 0.15);
    }
    .hover-ambient-shadow:hover {
        box-shadow: 0 10px 20px -5px rgba(8, 28, 39, 0.15);
        transition: box-shadow 0.3s ease;
    }
    .input-line { border-bottom: 1px solid #c3c7cb; transition: border-color 0.3s ease; background: transparent; }
    .input-line:focus { border-bottom-color: #F8BE26; outline: none; }
    .dark .bg-surface-dark { background-color: #1a1c1b; }
    .dark .bg-surface-container-dark { background-color: #2f3130; }
    .dark .text-on-surface-variant-dark { color: #c3c7cb; }
    .dark .tonal-card { background-color: #2f3130; border-color: rgba(195,199,203,0.15); }
    .dark .tonal-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
    .dark .input-line { border-bottom-color: #73787c; color: #e2e3e1; }
    .dark .input-line:focus { border-bottom-color: #f8be26; }
    .dark .bg-white,
    .dark .bg-surface,
    .dark .bg-background { background-color: #1a1c1b; }
    .dark .border-outline-variant\/15,
    .dark .border-outline-variant\/30,
    .dark .border-outline-variant\/20 { border-color: rgba(195,199,203,0.15); }
    .dark .text-on-surface-variant { color: #c3c7cb; }
    .dark .text-primary { color: #e2e3e1; }
    .dark .hover-ambient-shadow:hover { box-shadow: 0 10px 20px -5px rgba(0,0,0,0.4); }
    .dark select option { background-color: #1a1c1b; color: #e2e3e1; }
    .dark .text-brand-navy { color: #e2e3e1; }
    .dark .bg-brand-navy { background-color: #2a2a2a; }
    .dark .border-brand-navy { border-color: #5C4E49; }
    .dark .hover\:bg-brand-navy:hover { background-color: #3a3a3a; }
    .dark .focus\:border-brand-navy:focus { border-color: #f8be26; }
    .dark .decoration-brand-navy { text-decoration-color: #5C4E49; }
    .dark .text-on-surface { color: #e2e3e1; }
    .dark .text-primary-container { color: #e2e3e1; }
</style>
</head>
<body class="bg-background text-on-surface antialiased flex flex-col min-h-screen font-body-md">
