<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Kamus Digital Indonesia-Tolaki') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-50 text-ink font-body">

<!-- ===================== HEADER ===================== -->
<header class="sticky top-0 z-50 bg-sand-50/90 backdrop-blur border-b border-sand-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
      <a href="#beranda" class="flex items-center gap-3 shrink-0">
        <div class="w-10 h-10 rounded-2xl bg-teal-700 flex items-center justify-center shadow-pin shrink-0">
          <svg class="w-5 h-5 text-sand-50" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="hidden sm:block h-9 w-px bg-sand-300"></div>
        <div class="hidden sm:block leading-tight">
          <p class="font-display font-semibold text-teal-800 text-sm">Kamus Digital</p>
          <p class="text-[11px] text-teal-600">Indonesia&ndash;Tolaki untuk Pelajar</p>
        </div>
      </a>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-1 font-medium text-sm text-teal-800">
        <a href="#beranda" class="px-4 py-2 rounded-full hover:bg-teal-50 hover:text-teal-700 transition">Beranda</a>
        <a href="#cari" class="px-4 py-2 rounded-full hover:bg-teal-50 hover:text-teal-700 transition">Cari</a>

        <div class="relative group">
          <button class="flex items-center gap-1 px-4 py-2 rounded-full hover:bg-teal-50 hover:text-teal-700 transition">
            Seputar Laman
            <svg class="w-3.5 h-3.5 mt-px transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <div class="absolute left-1/2 -translate-x-1/2 pt-3 w-56 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition duration-150">
            <div class="bg-white rounded-2xl shadow-pin ring-1 ring-sand-200 p-2">
              <a href="#tentang" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Tentang Kami</a>
              <a href="#tim" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Tim Penyusun</a>
              <a href="#statistik" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Statistik</a>
              <a href="#bantuan" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Bantuan (SSD)</a>
            </div>
          </div>
        </div>

        <a href="#kontak" class="px-4 py-2 rounded-full hover:bg-teal-50 hover:text-teal-700 transition">Kontak</a>
      </nav>

      <div class="hidden md:flex items-center gap-2">
        @auth
          @can('dashboard.read')
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-teal-800 hover:text-teal-900 text-sm font-semibold px-4 py-2.5 rounded-full transition">
              Panel Admin
            </a>
          @endcan
          <div class="relative group">
            <button class="flex items-center gap-2 bg-white ring-1 ring-sand-200 hover:ring-teal-300 text-sm font-semibold px-3 py-2 rounded-full transition">
              <span class="w-7 h-7 rounded-full bg-gold-500/20 text-gold-600 flex items-center justify-center font-display font-semibold text-xs">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
              <span class="text-teal-800">{{ Str::of(auth()->user()->name)->before(' ') }}</span>
              <svg class="w-3.5 h-3.5 text-teal-600 transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div class="absolute right-0 pt-3 w-48 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition duration-150">
              <div class="bg-white rounded-2xl shadow-pin ring-1 ring-sand-200 p-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Dasbor Saya</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-xl text-sm hover:bg-sand-100 text-ink">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-sm hover:bg-konawe-500/10 text-konawe-600">Keluar</button>
                </form>
              </div>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="text-teal-800 hover:text-teal-900 text-sm font-semibold px-4 py-2.5 rounded-full transition">Masuk</a>
          <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm">Daftar</a>
        @endauth
      </div>

      <!-- Mobile toggle -->
      <button id="menuBtn" class="md:hidden p-2 rounded-lg text-teal-800" aria-label="Buka menu">
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>
  </div>

  <!-- Mobile nav -->
  <div id="mobileMenu" class="hidden md:hidden border-t border-sand-200 bg-sand-50">
    <div class="px-4 py-3 flex flex-col gap-1 font-medium text-teal-800">
      <a href="#beranda" class="px-3 py-2.5 rounded-lg hover:bg-teal-50">Beranda</a>
      <a href="#cari" class="px-3 py-2.5 rounded-lg hover:bg-teal-50">Cari</a>
      <p class="px-3 pt-3 pb-1 text-xs uppercase tracking-wide text-teal-500">Seputar Laman</p>
      <a href="#tentang" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 pl-6">Tentang Kami</a>
      <a href="#tim" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 pl-6">Tim Penyusun</a>
      <a href="#statistik" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 pl-6">Statistik</a>
      <a href="#bantuan" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 pl-6">Bantuan (SSD)</a>
      <a href="#kontak" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 mt-2">Kontak</a>
      <div class="border-t border-sand-200 mt-3 pt-3 flex flex-col gap-2">
        @auth
          @can('dashboard.read')
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2.5 rounded-lg hover:bg-teal-50 font-semibold">Panel Admin</a>
          @endcan
          <a href="{{ route('dashboard') }}" class="px-3 py-2.5 rounded-lg hover:bg-teal-50">Dasbor Saya</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg hover:bg-konawe-500/10 text-konawe-600">Keluar</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="px-3 py-2.5 rounded-lg hover:bg-teal-50">Masuk</a>
          <a href="{{ route('register') }}" class="px-3 py-2.5 rounded-lg bg-teal-700 text-white text-center font-semibold">Daftar</a>
        @endauth
      </div>
    </div>
  </div>
</header>

<!-- ===================== HERO / BERANDA ===================== -->
<section id="beranda" class="relative overflow-hidden bg-teal-800 text-sand-50">
  <div class="absolute inset-0 opacity-10 paper-texture"></div>
  <div class="absolute -top-24 -right-24 w-96 h-96 bg-gold-500/20 rounded-full blur-3xl"></div>
  <div class="absolute -bottom-32 -left-16 w-80 h-80 bg-mekongga-500/20 rounded-full blur-3xl"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-20 sm:pt-20 sm:pb-28">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div class="fade-up">
        <span class="inline-flex items-center gap-2 bg-white/10 text-gold-400 text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full ring-1 ring-white/15">
          Balai Bahasa Provinsi Sulawesi Tenggara
        </span>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-[3.4rem] leading-[1.08] font-semibold mt-5">
          Kamus Digital<br/>
          <span class="text-gold-400">Indonesia&nbsp;&ndash;&nbsp;Tolaki</span><br/>
          untuk Pelajar
        </h1>
        <p class="mt-5 text-teal-100/90 text-base sm:text-lg max-w-md">
          Cari kosakata, dengarkan pelafalannya, dan kenali dua dialek utama bahasa Tolaki: <span class="text-konawe-500 bg-white/90 px-1.5 py-0.5 rounded font-semibold">Konawe</span> dan <span class="text-mekongga-500 bg-white/90 px-1.5 py-0.5 rounded font-semibold">Mekongga</span>.
        </p>

        <!-- legenda warna -->
        <div class="mt-6 flex flex-wrap gap-2.5 text-xs font-semibold">
          <span class="flex items-center gap-1.5 bg-white/95 text-ink px-3 py-1.5 rounded-full"><span class="w-2.5 h-2.5 rounded-full bg-ink"></span>Bahasa Indonesia</span>
          <span class="flex items-center gap-1.5 bg-white/95 text-konawe-600 px-3 py-1.5 rounded-full"><span class="w-2.5 h-2.5 rounded-full bg-konawe-500"></span>Dialek Konawe</span>
          <span class="flex items-center gap-1.5 bg-white/95 text-mekongga-600 px-3 py-1.5 rounded-full"><span class="w-2.5 h-2.5 rounded-full bg-mekongga-500"></span>Dialek Mekongga</span>
        </div>

        @guest
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-600 text-teal-950 font-semibold px-6 py-3 rounded-full transition shadow-pin">Daftar Gratis</a>
          <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/15 ring-1 ring-white/20 text-sand-50 font-semibold px-6 py-3 rounded-full transition">Masuk</a>
        </div>
        @endguest
      </div>

      <!-- Kartu pencarian -->
      <div id="cari" class="fade-up scroll-mt-28">
        <div class="bg-sand-50 text-ink rounded-3xl shadow-2xl p-5 sm:p-7">
          <p class="font-display font-semibold text-lg text-teal-800">Cari kosakata</p>
          <p class="text-sm text-ink/60 mt-1">Ketik kata dalam Bahasa Indonesia, atau gunakan suara. Tersedia {{ $totalWords }} kata dari {{ $totalCategories }} kategori.</p>

          <div class="mt-4 flex items-center gap-2 bg-white border-2 border-sand-200 focus-within:border-teal-500 rounded-2xl px-4 py-3 transition">
            <svg class="w-5 h-5 text-teal-600 shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input id="searchInput" type="text" placeholder="mis. lima, rumah, kepala…"
              class="flex-1 bg-transparent outline-none text-base placeholder:text-ink/35" />
            <button id="micBtn" title="Cari dengan suara" aria-label="Cari dengan suara"
              class="shrink-0 w-9 h-9 flex items-center justify-center rounded-full bg-teal-50 text-teal-700 hover:bg-teal-100 transition">
              <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 003-3V6a3 3 0 10-6 0v6a3 3 0 003 3z" stroke="currentColor" stroke-width="2"/><path d="M19 11a7 7 0 01-14 0M12 18v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
          </div>
          <p id="micStatus" class="text-xs text-teal-600 mt-2 h-4"></p>

          <div class="flex items-center justify-between mt-5">
            <p class="text-xs uppercase tracking-wide text-ink/40 font-semibold">Contoh data &middot; Angka</p>
            <p id="resultCount" class="text-xs text-ink/40 font-medium"></p>
          </div>

          <div id="wordGrid" class="mt-3 space-y-2.5 max-h-[26rem] overflow-y-auto pr-1 -mr-1"></div>
          <div id="emptyState" class="hidden text-center py-10">
            <svg class="w-9 h-9 mx-auto text-ink/20" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <p class="text-sm text-ink/50 mt-2">Kata tidak ditemukan pada kamus ini.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== TENTANG KAMI ===================== -->
<section id="tentang" class="scroll-mt-24 py-20 sm:py-28 bg-sand-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-5 gap-12">
    <div class="lg:col-span-2">
      <span class="text-xs font-bold uppercase tracking-widest text-konawe-500">01 &middot; Tentang Kami</span>
      <h2 class="font-display text-3xl sm:text-4xl font-semibold text-teal-900 mt-3">Merawat bahasa Tolaki lewat layar pelajar</h2>
      <p class="mt-4 text-ink/70 leading-relaxed">
        Kamus Digital Indonesia&ndash;Tolaki untuk Pelajar disusun agar generasi muda Sulawesi Tenggara mengenal kembali kosakata
        daerahnya sendiri &mdash; lengkap dengan pelafalan suara dan padanan dua dialek utama, diadaptasi dari buku
        <i>Kamus Bergambar Bahasa Indonesia-Tolaki (Edisi Revisi 2022)</i>.
      </p>
    </div>
    <div class="lg:col-span-3 grid sm:grid-cols-2 gap-5">
      <div class="relative bg-white rounded-2xl p-6 ring-1 ring-sand-200">
        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 20l9-5-9-5-9 5 9 5z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M3 12v6M21 12v6" stroke="currentColor" stroke-width="2"/></svg>
        </div>
        <h3 class="font-display font-semibold text-lg text-ink">Untuk pelajar</h3>
        <p class="text-sm text-ink/60 mt-1.5">Tampilan sederhana, ramah untuk siswa SD&ndash;SMA yang baru mengenal bahasa daerah.</p>
      </div>
      <div class="relative bg-white rounded-2xl p-6 ring-1 ring-sand-200">
        <div class="w-10 h-10 rounded-xl bg-konawe-500/10 text-konawe-600 flex items-center justify-center mb-4">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 003-3V6a3 3 0 10-6 0v6a3 3 0 003 3z" stroke="currentColor" stroke-width="2"/><path d="M19 11a7 7 0 01-14 0M12 18v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 class="font-display font-semibold text-lg text-ink">Ada suara</h3>
        <p class="text-sm text-ink/60 mt-1.5">Setiap kata bisa didengarkan pelafalannya lewat tombol pengucapan.</p>
      </div>
      <div class="relative bg-white rounded-2xl p-6 ring-1 ring-sand-200">
        <div class="w-10 h-10 rounded-xl bg-mekongga-500/10 text-mekongga-600 flex items-center justify-center mb-4">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 class="font-display font-semibold text-lg text-ink">Dua dialek</h3>
        <p class="text-sm text-ink/60 mt-1.5">Padanan kata ditampilkan untuk dialek Konawe dan Mekongga sekaligus.</p>
      </div>
      <div class="relative bg-white rounded-2xl p-6 ring-1 ring-sand-200">
        <div class="w-10 h-10 rounded-xl bg-gold-500/15 text-gold-600 flex items-center justify-center mb-4">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 3l2.4 5.4L20 9l-4.2 3.8L17 19l-5-3.2L7 19l1.2-6.2L4 9l5.6-.6L12 3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-display font-semibold text-lg text-ink">Terbuka & gratis</h3>
        <p class="text-sm text-ink/60 mt-1.5">Dikembangkan Balai Bahasa Provinsi Sulawesi Tenggara bersama mitra kampus.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===================== TIM PENYUSUN ===================== -->
<section id="tim" class="scroll-mt-24 py-20 sm:py-28 bg-teal-900 text-sand-50 relative overflow-hidden">
  <div class="absolute inset-0 opacity-[0.06] paper-texture"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl">
      <span class="text-xs font-bold uppercase tracking-widest text-gold-400">02 &middot; Tim Penyusun</span>
      <h2 class="font-display text-3xl sm:text-4xl font-semibold mt-3">Kolaborasi BBST dan UMK</h2>
      <p class="mt-4 text-teal-100/80">Susunan penanggung jawab kamus digital ini melibatkan unsur pimpinan Balai Bahasa Provinsi Sulawesi Tenggara (BBST) dan Universitas Muhammadiyah Kendari (UMK).</p>
    </div>

    <div class="mt-12 grid md:grid-cols-2 gap-5">
      <div class="bg-white/5 ring-1 ring-white/10 rounded-2xl p-6">
        <p class="text-xs font-bold uppercase tracking-wide text-gold-400">Penanggung Jawab</p>
        <ul class="mt-4 space-y-4">
          <li class="flex items-start gap-3">
            <span class="mt-0.5 w-6 h-6 rounded-full bg-gold-500/20 text-gold-400 text-xs font-bold flex items-center justify-center shrink-0">1</span>
            <div><p class="font-semibold">Penanggung Jawab I</p><p class="text-sm text-teal-100/70">Unsur pimpinan Balai Bahasa Provinsi Sulawesi Tenggara</p></div>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-0.5 w-6 h-6 rounded-full bg-gold-500/20 text-gold-400 text-xs font-bold flex items-center justify-center shrink-0">2</span>
            <div><p class="font-semibold">Penanggung Jawab II</p><p class="text-sm text-teal-100/70">Unsur pimpinan Universitas Muhammadiyah Kendari (UMK)</p></div>
          </li>
        </ul>
      </div>

      <div class="bg-white/5 ring-1 ring-white/10 rounded-2xl p-6">
        <p class="text-xs font-bold uppercase tracking-wide text-gold-400">Wakil Penanggung Jawab</p>
        <ul class="mt-4 space-y-4">
          <li class="flex items-start gap-3">
            <span class="mt-0.5 w-2 h-2 rounded-full bg-mekongga-500 shrink-0 mt-2"></span>
            <div><p class="font-semibold">Pejabat UMK</p><p class="text-sm text-teal-100/70">Perwakilan struktural dari Universitas Muhammadiyah Kendari</p></div>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-0.5 w-2 h-2 rounded-full bg-mekongga-500 shrink-0 mt-2"></span>
            <div><p class="font-semibold">Koordinator / Ketua Tim UMK</p><p class="text-sm text-teal-100/70">Mengoordinasikan tim penyusun dari pihak kampus</p></div>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-0.5 w-2 h-2 rounded-full bg-mekongga-500 shrink-0 mt-2"></span>
            <div><p class="font-semibold">Kasubbag Umum BBST</p><p class="text-sm text-teal-100/70">Mengoordinasikan dukungan umum dari Balai Bahasa</p></div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ===================== STATISTIK ===================== -->
<section id="statistik" class="scroll-mt-24 py-20 sm:py-28 bg-sand-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <span class="text-xs font-bold uppercase tracking-widest text-konawe-500">03 &middot; Statistik</span>
    <h2 class="font-display text-3xl sm:text-4xl font-semibold text-teal-900 mt-3">Isi kamus saat ini</h2>
    <p class="mt-3 text-ink/60 max-w-xl">Data kosakata dan kategori diperbarui secara berkala oleh admin BBST dan UMK melalui panel admin.</p>

    <div class="mt-10 grid sm:grid-cols-3 gap-5">
      <div class="bg-white rounded-2xl p-7 ring-1 ring-sand-200">
        <p class="text-sm text-ink/50 font-medium">Total entri kosakata</p>
        <p class="font-display text-4xl font-semibold text-teal-800 mt-2" data-count="{{ $totalWords }}">0</p>
        <p class="text-xs text-konawe-600 font-semibold mt-2">Konawe &amp; Mekongga</p>
      </div>
      <div class="bg-white rounded-2xl p-7 ring-1 ring-sand-200">
        <p class="text-sm text-ink/50 font-medium">Kategori kosakata</p>
        <p class="font-display text-4xl font-semibold text-teal-800 mt-2" data-count="{{ $totalCategories }}">0</p>
        <p class="text-xs text-mekongga-600 font-semibold mt-2">dari Angka hingga Astronomi</p>
      </div>
      <div class="bg-white rounded-2xl p-7 ring-1 ring-sand-200">
        <p class="text-sm text-ink/50 font-medium">Pengguna terdaftar</p>
        <p class="font-display text-4xl font-semibold text-teal-800 mt-2" data-count="{{ $totalUsers }}">0</p>
        <p class="text-xs text-mekongga-600 font-semibold mt-2">&#9650; bertambah tiap pendaftaran</p>
      </div>
    </div>
  </div>
</section>

<!-- ===================== BANTUAN / SSD ===================== -->
<section id="bantuan" class="scroll-mt-24 py-20 sm:py-28 bg-white">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <span class="text-xs font-bold uppercase tracking-widest text-konawe-500">04 &middot; Bantuan</span>
    <h2 class="font-display text-3xl sm:text-4xl font-semibold text-teal-900 mt-3">Soal Sering Ditanya (SSD)</h2>

    <div class="mt-8 space-y-3">
      <details class="group bg-sand-50 rounded-2xl ring-1 ring-sand-200 open:ring-teal-300" open>
        <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer">
          <span class="font-semibold text-ink">Bagaimana cara mencari sebuah kata?</span>
          <svg class="chev w-5 h-5 text-teal-600 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </summary>
        <p class="px-5 pb-5 text-sm text-ink/65 leading-relaxed">Buka menu <b>Cari</b> di beranda, lalu ketik kata dalam Bahasa Indonesia. Kamu juga bisa menekan ikon mikrofon untuk mencari dengan suara.</p>
      </details>
      <details class="group bg-sand-50 rounded-2xl ring-1 ring-sand-200 open:ring-teal-300">
        <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer">
          <span class="font-semibold text-ink">Apa bedanya warna merah dan hijau pada kata?</span>
          <svg class="chev w-5 h-5 text-teal-600 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </summary>
        <p class="px-5 pb-5 text-sm text-ink/65 leading-relaxed">Warna hitam adalah Bahasa Indonesia, merah adalah padanan dalam dialek Konawe, dan hijau adalah padanan dalam dialek Mekongga.</p>
      </details>
      <details class="group bg-sand-50 rounded-2xl ring-1 ring-sand-200 open:ring-teal-300">
        <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer">
          <span class="font-semibold text-ink">Bagaimana cara mendengar pelafalan kata?</span>
          <svg class="chev w-5 h-5 text-teal-600 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </summary>
        <p class="px-5 pb-5 text-sm text-ink/65 leading-relaxed">Tekan ikon pengeras suara pada kartu kata untuk mendengarkan pelafalannya melalui perangkat kamu.</p>
      </details>
      <details class="group bg-sand-50 rounded-2xl ring-1 ring-sand-200 open:ring-teal-300">
        <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer">
          <span class="font-semibold text-ink">Apakah saya perlu akun untuk mencari kata?</span>
          <svg class="chev w-5 h-5 text-teal-600 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </summary>
        <p class="px-5 pb-5 text-sm text-ink/65 leading-relaxed">Tidak. Pencarian kamus terbuka untuk semua orang. Akun hanya diperlukan untuk fitur tambahan, seperti panel admin bagi pengelola kamus.</p>
      </details>
    </div>
  </div>
</section>

<!-- ===================== KONTAK ===================== -->
<section id="kontak" class="scroll-mt-24 py-20 sm:py-28 bg-sand-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <span class="text-xs font-bold uppercase tracking-widest text-konawe-500">05 &middot; Kontak</span>
    <h2 class="font-display text-3xl sm:text-4xl font-semibold text-teal-900 mt-3">Hubungi kami</h2>

    <div class="mt-10 grid md:grid-cols-2 gap-6">
      <div class="bg-white rounded-2xl p-7 ring-1 ring-sand-200">
        <h3 class="font-display font-semibold text-lg text-teal-800">Balai Bahasa Provinsi Sulawesi Tenggara</h3>
        <ul class="mt-4 space-y-3 text-sm text-ink/70">
          <li class="flex gap-3"><svg class="w-5 h-5 text-konawe-500 shrink-0" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.2 7-11.5A7 7 0 105 9.5C5 14.8 12 21 12 21z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="9.5" r="2.3" stroke="currentColor" stroke-width="1.8"/></svg>Jalan Haluoleo, Kompleks Bumi Praja Anduonohu, Kendari</li>
          <li class="flex gap-3"><svg class="w-5 h-5 text-konawe-500 shrink-0" viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.8"/></svg>email@bbst.kemendikdasmen.go.id</li>
          <li class="flex gap-3"><svg class="w-5 h-5 text-konawe-500 shrink-0" viewBox="0 0 24 24" fill="none"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6 19.8 19.8 0 01-3-8.7A2 2 0 014.1 2h3a2 2 0 012 1.7c.1 1 .3 2 .6 2.9a2 2 0 01-.5 2.1L8 10a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.5c.9.3 1.9.5 2.9.6a2 2 0 011.7 2.1z" stroke="currentColor" stroke-width="1.8"/></svg>Telepon admin BBST</li>
        </ul>
      </div>

      <div class="bg-white rounded-2xl p-7 ring-1 ring-sand-200">
        <h3 class="font-display font-semibold text-lg text-teal-800">Universitas Muhammadiyah Kendari</h3>
        <ul class="mt-4 space-y-3 text-sm text-ink/70">
          <li class="flex gap-3"><svg class="w-5 h-5 text-mekongga-500 shrink-0" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.2 7-11.5A7 7 0 105 9.5C5 14.8 12 21 12 21z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="9.5" r="2.3" stroke="currentColor" stroke-width="1.8"/></svg>Alamat kampus Universitas Muhammadiyah Kendari</li>
          <li class="flex gap-3"><svg class="w-5 h-5 text-mekongga-500 shrink-0" viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.8"/></svg>email@umkendari.ac.id</li>
          <li class="flex gap-3"><svg class="w-5 h-5 text-mekongga-500 shrink-0" viewBox="0 0 24 24" fill="none"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6 19.8 19.8 0 01-3-8.7A2 2 0 014.1 2h3a2 2 0 012 1.7c.1 1 .3 2 .6 2.9a2 2 0 01-.5 2.1L8 10a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.5c.9.3 1.9.5 2.9.6a2 2 0 011.7 2.1z" stroke="currentColor" stroke-width="1.8"/></svg>Telepon admin UMK</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="bg-teal-950 text-teal-100/70 py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center">
        <svg class="w-4 h-4 text-gold-400" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <p class="text-xs">&copy; <span id="year"></span> Balai Bahasa Provinsi Sulawesi Tenggara &amp; UMK</p>
    </div>
    <p class="text-xs">Kamus Digital Indonesia&ndash;Tolaki untuk Pelajar</p>
  </div>
</footer>

<!-- ===================== MODAL DETAIL KATA ===================== -->
<div id="wordModal" class="hidden fixed inset-0 z-[100] items-center justify-center p-4">
  <div id="wordModalBackdrop" class="absolute inset-0 bg-ink/60 backdrop-blur-sm"></div>

  <div class="relative bg-sand-50 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl">
    <button id="wordModalClose" type="button" aria-label="Tutup"
      class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-white/90 text-ink hover:bg-white shadow-sm transition">
      <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
    </button>

    <div class="grid sm:grid-cols-2">
      <div id="wordModalImageWrap" class="bg-teal-50 flex items-center justify-center p-8 sm:rounded-l-3xl">
        <img id="wordModalImage" src="" alt="" class="hidden w-full aspect-square object-cover rounded-2xl ring-1 ring-sand-200">
        <div id="wordModalImagePlaceholder" class="w-full aspect-square rounded-2xl bg-white ring-1 ring-sand-200 flex items-center justify-center text-teal-300">
          <svg class="w-16 h-16" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.4"/><circle cx="8.5" cy="9.5" r="1.5" stroke="currentColor" stroke-width="1.4"/><path d="M21 15l-5-5-9 9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
      </div>

      <div class="p-6 sm:p-8">
        <p id="wordModalCategory" class="text-xs font-bold uppercase tracking-widest text-konawe-500"></p>
        <div class="flex items-center gap-3 mt-2">
          <h3 id="wordModalTitle" class="font-display text-2xl sm:text-3xl font-semibold text-teal-900"></h3>
          <button id="wordModalSpeak" type="button"
            class="shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-full bg-sand-100 text-teal-700 hover:bg-teal-600 hover:text-white transition"
            title="Dengarkan (Bahasa Indonesia)" aria-label="Dengarkan pelafalan">
          </button>
        </div>
        <p class="text-xs text-ink/40 font-medium mt-1">Bahasa Indonesia</p>

        <div id="wordModalDialects" class="mt-5 space-y-3"></div>
      </div>
    </div>
  </div>
</div>

<script>
  // ---------- Data kamus (dimuat dari database) ----------
  const WORDS = @json($words);

  const grid = document.getElementById('wordGrid');
  const emptyState = document.getElementById('emptyState');
  const resultCount = document.getElementById('resultCount');
  const speakerSVGLg = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="currentColor"/><path d="M17 8.5a5 5 0 010 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>`;
  const speakerSVG = `<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="currentColor"/><path d="M17 8.5a5 5 0 010 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>`;

  let availableVoices = [];
  function loadVoices(){ availableVoices = window.speechSynthesis ? window.speechSynthesis.getVoices() : []; }
  loadVoices();
  if('speechSynthesis' in window){
    window.speechSynthesis.addEventListener('voiceschanged', loadVoices);
  }

  // Voice names carrying a gender hint. Word-boundary matched so "male" never
  // accidentally matches inside "female". Includes common Indonesian neural
  // voice names (Edge/Azure: Ardi = male, Gadis = female).
  const FEMALE_HINTS = /\bfemale\b|wanita|perempuan|\bzira\b|\bsamantha\b|\bgadis\b/i;
  const MALE_HINTS = /\bmale\b|\blaki\b|\bpria\b|\bdavid\b|\bardi\b/i;

  function pickVoice(lang, gender){
    const candidates = availableVoices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang.split('-')[0]));
    const pool = candidates.length ? candidates : availableVoices;
    if(!pool.length) return null;

    const wanted = gender === 'female' ? FEMALE_HINTS : MALE_HINTS;
    const other = gender === 'female' ? MALE_HINTS : FEMALE_HINTS;

    const byName = pool.find(v => wanted.test(v.name));
    if(byName) return byName;

    // No voice explicitly named for this gender. If there's more than one voice
    // for the language, deterministically split the pool so switching gender at
    // least picks a different voice instead of always the same one.
    const neutral = pool.filter(v => !other.test(v.name));
    if(neutral.length > 1){
      const idx = gender === 'female' ? neutral.length - 1 : 0;
      return neutral[idx];
    }

    return pool[0];
  }

  function speak(text, lang, btn, gender, audioUrl){
    if(!text && !audioUrl) return;

    if(audioUrl){
      const audio = new Audio(audioUrl);
      if(btn){
        btn.classList.add('scale-110');
        audio.addEventListener('ended', () => btn.classList.remove('scale-110'));
      }
      audio.play().catch(() => {});
      return;
    }

    if(!('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = lang || 'id-ID';
    u.rate = 0.9;
    const voice = pickVoice(u.lang, gender || 'male');
    if(voice) u.voice = voice;
    // Even when the platform only ships one voice for the language (common for
    // id-ID), nudge pitch so "perempuan" is still audibly distinct from "laki-laki".
    const voiceNameMatchesGender = voice && (gender === 'female' ? FEMALE_HINTS : MALE_HINTS).test(voice.name);
    if(!voiceNameMatchesGender){
      u.pitch = gender === 'female' ? 1.35 : 0.9;
    }
    if(btn){
      btn.classList.add('scale-110');
      u.onend = () => btn.classList.remove('scale-110');
    }
    window.speechSynthesis.speak(u);
  }

  function escapeHtml(str){
    return String(str).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
  }

  function highlight(text, q){
    if(!text) return '';
    if(!q) return escapeHtml(text);
    const i = text.toLowerCase().indexOf(q.toLowerCase());
    if(i === -1) return escapeHtml(text);
    return `${escapeHtml(text.slice(0,i))}<mark class="bg-gold-400/70 text-ink rounded px-0.5">${escapeHtml(text.slice(i,i+q.length))}</mark>${escapeHtml(text.slice(i+q.length))}`;
  }

  function renderWords(list, q=''){
    grid.innerHTML = '';
    emptyState.classList.toggle('hidden', list.length !== 0);
    resultCount.textContent = list.length ? `${list.length} kata ditemukan` : '';

    list.slice(0, 100).forEach(w => {
      const card = document.createElement('div');
      card.className = 'group bg-white rounded-2xl ring-1 ring-sand-200 hover:ring-teal-300 hover:shadow-md transition p-4 flex gap-4 items-start cursor-pointer';
      card.setAttribute('role', 'button');
      card.setAttribute('tabindex', '0');
      const thumb = w.image
        ? `<img src="${escapeHtml(w.image)}" alt="${escapeHtml(w.id ?? '')}" class="shrink-0 w-11 h-11 rounded-xl object-cover ring-1 ring-sand-200">`
        : `<div class="shrink-0 w-11 h-11 rounded-xl bg-teal-50 text-teal-700 font-display font-bold flex items-center justify-center text-[11px] text-center leading-tight px-1">${escapeHtml(w.category ?? '')}</div>`;

      card.innerHTML = `
        ${thumb}

        <div class="flex-1 min-w-0">
          <div class="flex items-center justify-between gap-2">
            <p class="font-display font-semibold text-ink text-lg leading-tight truncate">${highlight(w.id, q)}</p>
            <button data-text="${escapeHtml(w.id ?? '')}" data-lang="id-ID" data-voice="${escapeHtml(w.voice ?? 'male')}" data-audio="${escapeHtml(w.audio ?? '')}"
              class="speak-btn shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-sand-100 text-teal-700 hover:bg-teal-600 hover:text-white transition"
              title="Dengarkan (Bahasa Indonesia)" aria-label="Dengarkan pelafalan ${escapeHtml(w.id ?? '')}">${speakerSVGLg}</button>
          </div>
          <p class="text-[11px] text-ink/40 font-medium mt-0.5">Bahasa Indonesia &middot; ${escapeHtml(w.category ?? '')}</p>

          <div class="mt-3 flex flex-wrap gap-2">
            ${w.konawe ? `
            <div class="flex items-center gap-1.5 bg-konawe-500/10 rounded-full pl-1 pr-1.5 py-1">
              <span class="text-[10px] font-bold uppercase tracking-wide text-konawe-600 bg-white/70 rounded-full px-2 py-1">Konawe</span>
              <span class="text-sm font-semibold text-konawe-600">${highlight(w.konawe, q)}</span>
              <button data-text="${escapeHtml(w.konawe)}" data-lang="id-ID" data-voice="${escapeHtml(w.voice ?? 'male')}"
                class="speak-btn shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full text-konawe-600 hover:bg-konawe-500 hover:text-white transition"
                title="Dengarkan (dialek Konawe)" aria-label="Dengarkan pelafalan dialek Konawe">${speakerSVG}</button>
            </div>` : ''}
            ${w.mekongga ? `
            <div class="flex items-center gap-1.5 bg-mekongga-500/10 rounded-full pl-1 pr-1.5 py-1">
              <span class="text-[10px] font-bold uppercase tracking-wide text-mekongga-600 bg-white/70 rounded-full px-2 py-1">Mekongga</span>
              <span class="text-sm font-semibold text-mekongga-600">${highlight(w.mekongga, q)}</span>
              <button data-text="${escapeHtml(w.mekongga)}" data-lang="id-ID" data-voice="${escapeHtml(w.voice ?? 'male')}"
                class="speak-btn shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full text-mekongga-600 hover:bg-mekongga-500 hover:text-white transition"
                title="Dengarkan (dialek Mekongga)" aria-label="Dengarkan pelafalan dialek Mekongga">${speakerSVG}</button>
            </div>` : ''}
          </div>
        </div>`;
      card.addEventListener('click', () => openWordModal(w));
      card.addEventListener('keydown', (e) => {
        if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); openWordModal(w); }
      });
      grid.appendChild(card);
    });

    grid.querySelectorAll('.speak-btn').forEach(btn=>{
      btn.addEventListener('click', (e)=>{
        e.stopPropagation();
        speak(btn.dataset.text, btn.dataset.lang, btn, btn.dataset.voice, btn.dataset.audio || null);
      });
    });
  }

  // ---------- Modal detail kata ----------
  const wordModal = document.getElementById('wordModal');
  const wordModalBackdrop = document.getElementById('wordModalBackdrop');
  const wordModalClose = document.getElementById('wordModalClose');
  const wordModalImage = document.getElementById('wordModalImage');
  const wordModalImagePlaceholder = document.getElementById('wordModalImagePlaceholder');
  const wordModalCategory = document.getElementById('wordModalCategory');
  const wordModalTitle = document.getElementById('wordModalTitle');
  const wordModalSpeak = document.getElementById('wordModalSpeak');
  const wordModalDialects = document.getElementById('wordModalDialects');

  function dialectBlock(label, text, colorClasses, dataText, voice){
    if(!text) return '';
    return `
      <div class="flex items-center gap-3 ${colorClasses.bg} rounded-2xl pl-3 pr-2 py-2.5">
        <span class="text-[11px] font-bold uppercase tracking-wide ${colorClasses.text} bg-white/70 rounded-full px-2.5 py-1 shrink-0">${label}</span>
        <span class="flex-1 text-base font-semibold ${colorClasses.text}">${escapeHtml(text)}</span>
        <button data-text="${escapeHtml(dataText)}" data-lang="id-ID" data-voice="${escapeHtml(voice ?? 'male')}"
          class="speak-btn shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full ${colorClasses.text} hover:${colorClasses.hoverBg} hover:text-white transition"
          title="Dengarkan" aria-label="Dengarkan ${escapeHtml(label)}">${speakerSVGLg}</button>
      </div>`;
  }

  function openWordModal(w){
    if(w.image){
      wordModalImage.src = w.image;
      wordModalImage.alt = w.id ?? '';
      wordModalImage.classList.remove('hidden');
      wordModalImagePlaceholder.classList.add('hidden');
    } else {
      wordModalImage.classList.add('hidden');
      wordModalImagePlaceholder.classList.remove('hidden');
    }

    wordModalCategory.textContent = w.category ?? '';
    wordModalTitle.textContent = w.id ?? '';
    wordModalSpeak.innerHTML = speakerSVGLg;
    wordModalSpeak.onclick = () => speak(w.id, 'id-ID', wordModalSpeak, w.voice, w.audio || null);

    wordModalDialects.innerHTML = [
      dialectBlock('Konawe', w.konawe, { bg: 'bg-konawe-500/10', text: 'text-konawe-600', hoverBg: 'bg-konawe-500' }, w.konawe, w.voice),
      dialectBlock('Mekongga', w.mekongga, { bg: 'bg-mekongga-500/10', text: 'text-mekongga-600', hoverBg: 'bg-mekongga-500' }, w.mekongga, w.voice),
    ].join('');

    wordModalDialects.querySelectorAll('.speak-btn').forEach(btn=>{
      btn.addEventListener('click', (e)=>{
        e.stopPropagation();
        speak(btn.dataset.text, btn.dataset.lang, btn, btn.dataset.voice);
      });
    });

    wordModal.classList.remove('hidden');
    wordModal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }

  function closeWordModal(){
    wordModal.classList.add('hidden');
    wordModal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    if('speechSynthesis' in window) window.speechSynthesis.cancel();
  }

  wordModalBackdrop.addEventListener('click', closeWordModal);
  wordModalClose.addEventListener('click', closeWordModal);
  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape' && !wordModal.classList.contains('hidden')) closeWordModal();
  });

  const initial = WORDS.filter(w => w.category === 'Angka');
  renderWords(initial.length ? initial : WORDS.slice(0, 20));

  // ---------- Pencarian teks ----------
  const searchInput = document.getElementById('searchInput');
  searchInput.addEventListener('input', ()=>{
    const raw = searchInput.value.trim();
    const q = raw.toLowerCase();
    if(!q){ renderWords(initial.length ? initial : WORDS.slice(0, 20)); return; }
    const filtered = WORDS.filter(w =>
      (w.id && w.id.toLowerCase().includes(q)) ||
      (w.konawe && w.konawe.toLowerCase().includes(q)) ||
      (w.mekongga && w.mekongga.toLowerCase().includes(q)) ||
      (w.category && w.category.toLowerCase().includes(q))
    );
    renderWords(filtered, raw);
  });

  // ---------- Pencarian suara (mic) ----------
  const micBtn = document.getElementById('micBtn');
  const micStatus = document.getElementById('micStatus');
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

  if(SpeechRecognition){
    const recognition = new SpeechRecognition();
    recognition.lang = 'id-ID';
    recognition.interimResults = false;

    micBtn.addEventListener('click', ()=>{
      micStatus.textContent = 'Mendengarkan… silakan ucapkan kata.';
      micBtn.classList.add('bg-konawe-500/20','text-konawe-600');
      try { recognition.start(); } catch(e) {}
    });
    recognition.addEventListener('result', (e)=>{
      const text = e.results[0][0].transcript;
      searchInput.value = text;
      searchInput.dispatchEvent(new Event('input'));
      micStatus.textContent = `Hasil suara: "${text}"`;
    });
    recognition.addEventListener('end', ()=>{
      micBtn.classList.remove('bg-konawe-500/20','text-konawe-600');
    });
    recognition.addEventListener('error', ()=>{
      micStatus.textContent = 'Suara tidak terdengar jelas, coba lagi.';
      micBtn.classList.remove('bg-konawe-500/20','text-konawe-600');
    });
  } else {
    micBtn.addEventListener('click', ()=>{
      micStatus.textContent = 'Pencarian suara tidak didukung pada peramban ini.';
    });
  }

  // ---------- Mobile menu ----------
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  menuBtn.addEventListener('click', ()=> mobileMenu.classList.toggle('hidden'));
  mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', ()=> mobileMenu.classList.add('hidden')));

  // ---------- Animasi angka statistik ----------
  const counters = document.querySelectorAll('[data-count]');
  const animateCount = (el) => {
    const target = parseInt(el.dataset.count, 10);
    const duration = 1200;
    const start = performance.now();
    function tick(now){
      const progress = Math.min((now - start) / duration, 1);
      el.textContent = Math.floor(progress * target).toLocaleString('id-ID');
      if(progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  };
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){ animateCount(entry.target); io.unobserve(entry.target); }
    });
  }, {threshold: 0.5});
  counters.forEach(c => io.observe(c));

  document.getElementById('year').textContent = new Date().getFullYear();
</script>
</body>
</html>
