<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Login - RBTGTech Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-rbtgtech.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#191b23",
                        "on-secondary-container": "#5e6570",
                        "tertiary-fixed-dim": "#c0c6d9",
                        "on-surface-variant": "#424654",
                        "on-error": "#ffffff",
                        "tertiary-container": "#6e7585",
                        "primary-fixed-dim": "#b0c6ff",
                        "inverse-surface": "#2e3038",
                        "on-tertiary-fixed-variant": "#404756",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#e1e2ec",
                        "on-secondary-fixed": "#151c25",
                        "primary-container": "#246fea",
                        "surface-variant": "#e1e2ec",
                        "on-secondary-fixed-variant": "#404051",
                        "primary-fixed": "#d9e2ff",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-primary-container": "#fefcff",
                        "tertiary-fixed": "#dce2f5",
                        "secondary-fixed": "#dce3f0",
                        "outline-variant": "#c2c6d6",
                        "background": "#faf8ff",
                        "on-primary-fixed-variant": "#00429b",
                        "surface-tint": "#0058ca",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#151c29",
                        "surface-bright": "#faf8ff",
                        "on-tertiary-container": "#fefcff",
                        "error": "#ba1a1a",
                        "inverse-on-surface": "#eff0fb",
                        "on-secondary": "#ffffff",
                        "tertiary": "#555c6c",
                        "surface-dim": "#d8d9e4",
                        "inverse-primary": "#b0c6ff",
                        "on-primary-fixed": "#001944",
                        "surface-container-low": "#f2f3fe",
                        "outline": "#727785",
                        "surface": "#faf8ff",
                        "primary": "#0056c5",
                        "secondary": "#585f6a",
                        "secondary-container": "#dce3f0",
                        "secondary-fixed-dim": "#c0c7d3",
                        "on-surface": "#191b23",
                        "surface-container": "#ecedf8",
                        "surface-container-high": "#e7e7f2"
                    },
                    "fontFamily": {
                        "body-lg": ["Manrope"],
                        "headline-lg": ["Hanken Grotesk"],
                        "headline-sm": ["Hanken Grotesk"],
                        "label-sm": ["Manrope"],
                        "label-md": ["Manrope"],
                        "headline-md": ["Hanken Grotesk"],
                        "body-md": ["Manrope"],
                    }
                }
            }
        }
    </script>
    <style>
        .soft-shadow {
            box-shadow: 0 4px 25px 0 rgba(0, 86, 197, 0.12);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex items-center justify-center p-4">
    @yield('content')
</body>
</html>
