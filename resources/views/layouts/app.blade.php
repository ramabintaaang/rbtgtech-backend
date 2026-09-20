<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RBTGTech Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-rbtgtech.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        "on-secondary-fixed-variant": "#404751",
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
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xxl": "48px",
                        "xs": "4px",
                        "xl": "32px",
                        "sm": "8px",
                        "margin-desktop": "40px",
                        "lg": "24px",
                        "base": "4px",
                        "md": "16px",
                        "margin-mobile": "16px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "body-lg": ["Manrope"],
                        "headline-lg": ["Hanken Grotesk"],
                        "headline-sm": ["Hanken Grotesk"],
                        "label-sm": ["Manrope"],
                        "label-md": ["Manrope"],
                        "headline-md": ["Hanken Grotesk"],
                        "body-md": ["Manrope"],
                        "headline-lg-mobile": ["Hanken Grotesk"]
                    },
                    "fontSize": {
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-sm": ["18px", { "lineHeight": "24px", "fontWeight": "600" }],
                        "label-sm": ["11px", { "lineHeight": "14px", "fontWeight": "500" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-lg-mobile": ["26px", { "lineHeight": "32px", "fontWeight": "700" }]
                    }
                }
            }
        }
    </script>
    <style>
        .pattern-diagonal {
            background-image: repeating-linear-gradient(45deg, transparent, transparent 4px, rgba(255,255,255,0.15) 4px, rgba(255,255,255,0.15) 8px);
        }
        .pattern-diagonal-blue {
            background-image: repeating-linear-gradient(45deg, transparent, transparent 4px, rgba(0,86,197,0.15) 4px, rgba(0,86,197,0.15) 8px);
        }
        .soft-shadow {
            box-shadow: 0 4px 20px 0 rgba(0, 86, 197, 0.1);
        }
    </style>
    @stack('head')
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col">

    <!-- TopNavBar -->
    <nav class="bg-surface/80 dark:bg-surface/80 backdrop-blur-md flex justify-between items-center w-full px-margin-desktop py-md max-w-full docked full-width top-0 sticky z-50 border-b border-outline-variant/30">
        <div class="flex items-center gap-xl">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo-rbtgtech.png') }}" alt="RBTG Tech Logo" class="h-9 w-auto object-contain"/>
                <span class="text-headline-md font-headline-md font-bold text-primary dark:text-primary-fixed-dim">RBTGTech</span>
            </div>
            <div class="hidden md:flex items-center gap-sm">
                <a class="px-4 py-2 text-label-md font-label-md transition-all rounded-full {{ request()->routeIs('dashboard') ? 'text-on-primary-container bg-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}" href="{{ route('dashboard') }}">Dashboard</a>

                <!-- Dropdown Kelola Konten -->
                <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                    <button 
                        @click="open = !open" 
                        type="button"
                        class="px-4 py-2 text-label-md font-label-md transition-all rounded-full flex items-center gap-1.5 {{ (request()->routeIs('admin.products.*') || request()->routeIs('admin.articles.*') || request()->routeIs('admin.portfolio.*') || request()->routeIs('admin.categories.*')) ? 'text-on-primary-container bg-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}"
                    >
                        <span>Kelola Konten</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute left-0 mt-2 w-56 rounded-2xl bg-surface/95 dark:bg-surface-container-high/90 backdrop-blur-lg border border-outline-variant/30 shadow-xl py-2 z-50 overflow-hidden"
                        style="display: none;"
                    >
                        <a 
                            href="{{ route('admin.products.index') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-label-md font-medium transition-colors hover:bg-primary-container/10 hover:text-primary {{ request()->routeIs('admin.products.*') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface' }}"
                        >
                            <span class="material-symbols-outlined text-[20px] text-primary">inventory_2</span>
                            <span>Produk Digital & Solusi</span>
                        </a>
                        <a 
                            href="{{ route('admin.articles.index') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-label-md font-medium transition-colors hover:bg-primary-container/10 hover:text-primary {{ request()->routeIs('admin.articles.*') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface' }}"
                        >
                            <span class="material-symbols-outlined text-[20px] text-primary">article</span>
                            <span>Artikel & Blog</span>
                        </a>
                        <a 
                            href="{{ route('admin.portfolio.index') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-label-md font-medium transition-colors hover:bg-primary-container/10 hover:text-primary {{ request()->routeIs('admin.portfolio.*') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface' }}"
                        >
                            <span class="material-symbols-outlined text-[20px] text-primary">work</span>
                            <span>Portofolio Proyek</span>
                        </a>
                        <div class="my-1 border-t border-outline-variant/20"></div>
                        <a 
                            href="{{ route('admin.categories.index') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-label-md font-medium transition-colors hover:bg-primary-container/10 hover:text-primary {{ request()->routeIs('admin.categories.*') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface' }}"
                        >
                            <span class="material-symbols-outlined text-[20px] text-primary">category</span>
                            <span>Master Kategori</span>
                        </a>
                    </div>
                </div>

                <a class="px-4 py-2 text-label-md font-label-md transition-all rounded-full {{ request()->routeIs('admin.inquiries.*') ? 'text-on-primary-container bg-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}" href="{{ route('admin.inquiries.index') }}">Pesan Masuk</a>
                <a class="px-4 py-2 text-label-md font-label-md transition-all rounded-full {{ request()->routeIs('admin.leads.*') ? 'text-on-primary-container bg-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}" href="{{ route('admin.leads.index') }}">Prospecting Leads</a>
                <a class="px-4 py-2 text-label-md font-label-md transition-all rounded-full {{ request()->routeIs('admin.invoices.*') ? 'text-on-primary-container bg-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}" href="{{ route('admin.invoices.index') }}">Nota / Invoice</a>
            </div>
        </div>
        <div class="flex items-center gap-md">
            <button class="p-2 text-on-surface-variant hover:text-primary transition-colors relative">
                <span class="material-symbols-outlined">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <div class="flex items-center gap-sm ml-sm pl-md border-l border-outline-variant">
                <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-label-md">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="hidden sm:block">
                    <p class="text-label-md font-label-md text-on-surface font-bold">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-label-sm font-label-sm text-on-surface-variant">{{ Auth::user()->email ?? 'admin@rbtgtech.com' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <button type="submit" class="p-1.5 text-on-surface-variant hover:text-error transition-colors flex items-center rounded-lg hover:bg-error-container/20" title="Logout">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global DataTable Sorter & Paginator Helper -->
    <script>
    window.rbtgTable = {
        sort(items, column, direction) {
            if (!column) return items;
            return [...items].sort((a, b) => {
                let valA = a[column];
                let valB = b[column];
                
                // Case-insensitive string sorting
                if (typeof valA === 'string') valA = valA.trim().toLowerCase();
                if (typeof valB === 'string') valB = valB.trim().toLowerCase();
                
                if (valA === null || valA === undefined || valA === '') return direction === 'asc' ? 1 : -1;
                if (valB === null || valB === undefined || valB === '') return direction === 'asc' ? -1 : 1;
                
                if (valA < valB) return direction === 'asc' ? -1 : 1;
                if (valA > valB) return direction === 'asc' ? 1 : -1;
                return 0;
            });
        },

        paginate(items, page, perPage) {
            if (perPage === 'all') return items;
            const limit = parseInt(perPage) || 10;
            const offset = (page - 1) * limit;
            return items.slice(offset, offset + limit);
        },

        renderPagination(containerId, totalItems, currentPage, perPage, onPageChangeFunctionName) {
            const container = document.getElementById(containerId);
            if (!container) return;

            if (totalItems === 0) {
                container.innerHTML = '';
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            const limit = perPage === 'all' ? totalItems : parseInt(perPage) || 10;
            const totalPages = Math.ceil(totalItems / limit) || 1;
            const from = totalItems === 0 ? 0 : (currentPage - 1) * limit + 1;
            const to = Math.min(currentPage * limit, totalItems);

            let pagesHtml = '';
            
            // Prev button
            pagesHtml += `
                <button 
                    type="button" 
                    onclick="${onPageChangeFunctionName}(${currentPage - 1})"
                    ${currentPage === 1 ? 'disabled class="p-1.5 rounded-lg text-on-surface-variant/30 cursor-not-allowed"' : 'class="p-1.5 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors cursor-pointer"'}
                >
                    <span class="material-symbols-outlined text-[20px] block">chevron_left</span>
                </button>
            `;

            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);
            if (endPage - startPage < maxVisible - 1) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            for (let p = startPage; p <= endPage; p++) {
                pagesHtml += `
                    <button 
                        type="button" 
                        onclick="${onPageChangeFunctionName}(${p})"
                        class="w-8 h-8 rounded-lg text-label-md font-bold transition-all cursor-pointer ${p === currentPage ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary'}"
                    >
                        ${p}
                    </button>
                `;
            }

            // Next button
            pagesHtml += `
                <button 
                    type="button" 
                    onclick="${onPageChangeFunctionName}(${currentPage + 1})"
                    ${currentPage === totalPages ? 'disabled class="p-1.5 rounded-lg text-on-surface-variant/30 cursor-not-allowed"' : 'class="p-1.5 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors cursor-pointer"'}
                >
                    <span class="material-symbols-outlined text-[20px] block">chevron_right</span>
                </button>
            `;

            container.innerHTML = `
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full text-body-md text-on-surface-variant p-4 border-t border-outline-variant/30 bg-surface-container-low/40">
                    <div>
                        Menampilkan <span class="font-bold text-on-surface">${from}</span> - <span class="font-bold text-on-surface">${to}</span> dari <span class="font-bold text-on-surface">${totalItems}</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        ${pagesHtml}
                    </div>
                </div>
            `;
        }
    };
    </script>
</body>
</html>
