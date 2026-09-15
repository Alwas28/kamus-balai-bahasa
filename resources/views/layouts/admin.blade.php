<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panel Admin' }} &middot; {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-ink antialiased bg-sand-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-teal-900 text-sand-50 transform transition-transform duration-200 lg:static lg:translate-x-0 flex flex-col"
        >
            <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10 shrink-0">
                <div class="w-10 h-10 rounded-2xl bg-gold-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-teal-900" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="leading-tight">
                    <p class="font-display font-semibold text-sm">Panel Admin</p>
                    <p class="text-[11px] text-teal-200">Kamus Tolaki</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M4 13h6V4H4v9zm0 7h6v-5H4v5zm10 0h6V11h-6v9zm0-16v5h6V4h-6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    Dasbor
                </a>

                @can('kategori.read')
                <p class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-teal-300/70">Konten Kamus</p>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Kategori
                </a>
                @endcan

                @can('kata.read')
                <a href="{{ route('admin.words.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.words.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Kosakata
                </a>
                @endcan

                @canany(['pengguna.read', 'role.read'])
                <p class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-teal-300/70">Akses & Pengguna</p>
                @endcanany

                @can('pengguna.read')
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.8"/><path d="M4.5 20a7.5 7.5 0 0115 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Pengguna
                </a>
                @endcan

                @can('role.read')
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.roles.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5' }}">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    Role & Hak Akses
                </a>
                @endcan
            </nav>

            <div class="p-3 border-t border-white/10 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-teal-100 hover:bg-white/5 transition">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Kembali ke Situs
                </a>
            </div>
        </aside>

        <div class="fixed inset-0 bg-ink/40 z-30 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>

        <!-- Main -->
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-20 bg-white border-b border-sand-200 flex items-center gap-4 px-4 sm:px-8 sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-teal-800">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>

                <div class="flex-1 min-w-0">
                    <h1 class="font-display font-semibold text-xl text-teal-900 truncate">{{ $title ?? 'Dasbor' }}</h1>
                    @isset($subtitle)
                        <p class="text-xs text-ink/50 mt-0.5">{{ $subtitle }}</p>
                    @endisset
                </div>

                <div class="relative group shrink-0">
                    <button class="flex items-center gap-2 bg-sand-50 ring-1 ring-sand-200 hover:ring-teal-300 text-sm font-semibold px-3 py-2 rounded-full transition">
                        <span class="w-7 h-7 rounded-full bg-gold-500/20 text-gold-600 flex items-center justify-center font-display font-semibold text-xs">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="text-teal-800 hidden sm:inline">{{ auth()->user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-teal-600 transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div class="absolute right-0 pt-3 w-48 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition duration-150">
                        <div class="bg-white rounded-2xl shadow-pin ring-1 ring-sand-200 p-2">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-sm hover:bg-konawe-500/10 text-konawe-600">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-8">
                @if (session('status'))
                    <div class="mb-6 flex items-center gap-3 bg-mekongga-500/10 text-mekongga-600 ring-1 ring-mekongga-500/20 rounded-xl px-4 py-3 text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M8.5 12.5l2.5 2.5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3 bg-konawe-500/10 text-konawe-600 ring-1 ring-konawe-500/20 rounded-xl px-4 py-3 text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 8v5M12 16h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
