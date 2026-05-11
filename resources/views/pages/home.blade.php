@extends('root.app')

@section('title', 'YPTQ Asy-Syams')

@section('content')

<style>
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 1s cubic-bezier(0.5, 0, 0, 1);
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .fade-in-section {
        opacity: 1;
        transform: none;
    }
</style>

<!-- HERO SECTION -->
<section class="relative overflow-hidden bg-white text-white">

    <!-- MOBILE HERO -->
    <div class="block md:hidden bg-white">
        @if($bgUrl)
            <div class="w-full h-[300px] overflow-hidden bg-white">
                <img
                    src="{{ $bgUrl }}"
                    alt="Hero Background"
                    class="w-full h-full object-cover object-top"
                >
            </div>
        @else
            <div class="w-full h-[300px] bg-white"></div>
        @endif

        <!-- Button Mobile -->
        <div class="flex justify-center pt-3 pb-4 px-4">
            <a
                href="{{ route('register') }}"
                class="inline-block px-4 py-2 bg-orange-700 hover:bg-orange-800 text-white font-bold rounded-full shadow-lg transform transition hover:scale-105 text-xs tracking-wide"
            >
                DAFTAR SEKARANG
            </a>
        </div>
    </div>

    <!-- DESKTOP HERO -->
    <div class="hidden md:block relative min-h-screen bg-white">

        <!-- Background Image Desktop -->
        <div class="absolute inset-0 z-0 bg-white">
            @if($bgUrl)
                <img
                    src="{{ $bgUrl }}"
                    alt="Hero Background"
                    class="w-full h-full object-cover object-center"
                >
            @else
                <div class="w-full h-full bg-white"></div>
            @endif
        </div>

        <!-- Button Desktop -->
        <div class="relative z-30 min-h-screen flex items-end justify-center px-4 pb-28 lg:pb-32">
            <a
                href="{{ route('register') }}"
                class="inline-block px-5 py-2.5 bg-orange-700 hover:bg-orange-800 text-white font-bold rounded-full shadow-lg transform transition hover:scale-105 text-sm tracking-wide"
            >
                DAFTAR SEKARANG
            </a>
        </div>

    </div>

</section>

<!-- COUNTDOWN SECTION -->
<section class="bg-white border-b-4 border-emerald-700 shadow-lg relative z-20 mt-0 md:-mt-8 mx-3 md:mx-auto max-w-6xl rounded-xl p-4 md:p-10 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-8 fade-in-section">

    <div class="md:w-1/2">
        <p class="text-gray-600 leading-relaxed text-xs md:text-base text-center md:text-left">
            Bergabunglah bersama kami di
            <span class="font-bold text-emerald-700">YPTQ Asy-Syams</span>.
            Sistem Penerimaan Peserta Didik Baru (SPMB) kini telah dibuka. Dapatkan pendidikan berkualitas.
        </p>
    </div>

    <div
        class="md:w-1/2 w-full"
        x-data="initCountdown('{{ $deadlineISO }}')"
        x-init="startCountdown()"
    >
        <h3 class="text-sm md:text-lg font-bold text-gray-900 mb-2 md:mb-4 text-center md:text-left">
            SPMB Akan Berakhir Pada:
        </h3>

        <p class="text-[11px] md:text-xs text-gray-500 mb-2 text-center md:text-left">
            Batas Akhir: {{ \Carbon\Carbon::parse($deadline)->translatedFormat('d F Y, H:i') }} WIB
        </p>

        <div class="flex justify-center md:justify-start gap-2 md:gap-4 text-center">
            <div class="flex flex-col">
                <span class="text-2xl md:text-4xl font-mono font-bold text-gray-800" x-text="days">00</span>
                <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide">Hari</span>
            </div>

            <div class="text-xl md:text-2xl font-bold text-gray-300 self-start mt-0.5 md:mt-1">:</div>

            <div class="flex flex-col">
                <span class="text-2xl md:text-4xl font-mono font-bold text-gray-800" x-text="hours">00</span>
                <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide">Jam</span>
            </div>

            <div class="text-xl md:text-2xl font-bold text-gray-300 self-start mt-0.5 md:mt-1">:</div>

            <div class="flex flex-col">
                <span class="text-2xl md:text-4xl font-mono font-bold text-gray-800" x-text="minutes">00</span>
                <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide">Menit</span>
            </div>

            <div class="text-xl md:text-2xl font-bold text-gray-300 self-start mt-0.5 md:mt-1">:</div>

            <div class="flex flex-col">
                <span class="text-2xl md:text-4xl font-mono font-bold text-gray-800" x-text="seconds">00</span>
                <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide">Detik</span>
            </div>
        </div>
    </div>

</section>

<!-- KARTU JENJANG SECTION -->
<section class="bg-gray-50 fade-in-section" id="jenjang">

    <!-- Header -->
    <div class="text-center px-4 pt-8 md:pt-10 md:mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-emerald-800">
            Daftar Pilihan Jenjang Pendidikan
        </h2>
        <div class="mt-3 w-20 md:w-24 h-1 bg-yellow-400 mx-auto rounded-full"></div>
    </div>

    <!-- Mobile: 1 card = 1 layar -->
    <div class="block md:hidden">

        <!-- RUMAH QURAN -->
        <div class="min-h-screen flex flex-col justify-center px-4 py-5">
            <div class="flex flex-col gap-3">
                <div class="h-[65vh] rounded-xl flex items-center justify-center shadow-lg relative overflow-hidden group bg-green-800">
                    <img
                        src="{{ asset('images/gambar RQ bg.png') }}"
                        onerror="this.onerror=null; this.src='https://placehold.co/400x600/166534/ffffff?text=RUMAH+QURAN'"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500"
                        alt="RUMAH QURAN"
                    >
                </div>

                <a
                    href="{{ url('/register?jenjang=RQ') }}"
                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded shadow text-center text-sm transition"
                >
                    DAFTAR RUMAH QURAN &rarr;
                </a>

                <a
                    href="#"
                    class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded shadow text-center text-sm transition"
                >
                    INFO PPDB RQ
                </a>
            </div>
        </div>

        <!-- TK -->
        <div class="min-h-screen flex flex-col justify-center px-4 py-5">
            <div class="flex flex-col gap-3">
                <div class="h-[74vh] rounded-xl flex items-center justify-center shadow-lg relative overflow-hidden group bg-purple-600">
                    <img
                        src="{{ asset('images/gambar TK, bg.png') }}"
                        onerror="this.onerror=null; this.src='https://placehold.co/400x600/6b21a8/ffffff?text=TK'"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500"
                        alt="TKIT"
                    >
                </div>

                <a
                    href="{{ url('/register?jenjang=TKIT') }}"
                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded shadow text-center text-sm transition"
                >
                    DAFTAR TK &rarr;
                </a>

                <a
                    href="#"
                    class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded shadow text-center text-sm transition"
                >
                    INFO PPDB TK
                </a>
            </div>
        </div>

    </div>

    <!-- Desktop: 2 card dalam 1 layar -->
    <div class="hidden md:flex min-h-screen items-center">
        <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 gap-8">

                <!-- TK -->
                <div class="flex flex-col gap-3">
                    <div class="h-[24rem] lg:h-[28rem] rounded-xl flex items-center justify-center shadow-lg relative overflow-hidden group bg-purple-600">
                        <img
                            src="{{ asset('images/gambar TK, bg.png') }}"
                            onerror="this.onerror=null; this.src='https://placehold.co/400x600/6b21a8/ffffff?text=TK'"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500"
                            alt="TKIT"
                        >
                    </div>

                    <a
                        href="{{ url('/register?jenjang=TKIT') }}"
                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded shadow text-center text-base transition"
                    >
                        DAFTAR TK &rarr;
                    </a>

                    <a
                        href="#"
                        class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded shadow text-center text-sm transition"
                    >
                        INFO PPDB TK
                    </a>
                </div>

                <!-- RUMAH QURAN -->
                <div class="flex flex-col gap-3">
                    <div class="h-[24rem] lg:h-[28rem] rounded-xl flex items-center justify-center shadow-lg relative overflow-hidden group bg-green-800">
                        <img
                            src="{{ asset('images/gambar RQ bg.png') }}"
                            onerror="this.onerror=null; this.src='https://placehold.co/400x600/166534/ffffff?text=RUMAH+QURAN'"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500"
                            alt="RUMAH QURAN"
                        >
                    </div>

                    <a
                        href="{{ url('/register?jenjang=RQ') }}"
                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded shadow text-center text-base transition"
                    >
                        DAFTAR RUMAH QURAN &rarr;
                    </a>

                    <a
                        href="#"
                        class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded shadow text-center text-sm transition"
                    >
                        INFO PPDB RQ
                    </a>
                </div>

            </div>
        </div>
    </div>

</section>

<!-- KEUNGGULAN SECTION FINAL - WATERMARK VERSION -->
<section class="bg-white py-16 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#183F3B] inline-block relative">
                3 KEUNGGULAN RUMAH QUR'AN ASY-SYAMS !
                <span class="block h-1.5 w-24 bg-yellow-500 mx-auto mt-4 rounded-full shadow-sm"></span>
            </h2>
        </div>

        <div class="grid gap-8 grid-cols-1 md:grid-cols-3">

            <!-- CARD 01 -->
            <div class="group relative bg-[#F4F9F7] rounded-2xl p-8 border-l-[12px] border-[#183F3B] shadow-sm hover:shadow-2xl hover:bg-white transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <!-- Angka di Pojok Kanan Atas (Diperjelas) -->
                <span class="absolute top-4 right-6 text-7xl font-black text-[#183F3B] opacity-10 group-hover:opacity-20 transition-opacity duration-500 select-none pointer-events-none">01</span>
                
                <div class="relative z-10">
                    <!-- Icon Box -->
                    <div class="w-16 h-16 bg-[#183F3B] text-white rounded-2xl flex items-center justify-center mb-10 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-extrabold text-[#183F3B] mb-4 tracking-tight">Pembinaan</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Membina bacaan dan hafalan Al-Qur'an dari 
                        <span class="font-bold text-green-700">Nol sampai Berprestasi</span>.
                    </p>
                </div>
            </div>

            <!-- CARD 02 -->
            <div class="group relative bg-[#F4F9F7] rounded-2xl p-8 border-l-[12px] border-[#183F3B] shadow-sm hover:shadow-2xl hover:bg-white transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <!-- Angka di Pojok Kanan Atas (Diperjelas) -->
                <span class="absolute top-4 right-6 text-7xl font-black text-[#183F3B] opacity-10 group-hover:opacity-20 transition-opacity duration-500 select-none pointer-events-none">02</span>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-[#183F3B] text-white rounded-2xl flex items-center justify-center mb-10 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-extrabold text-[#183F3B] mb-4 tracking-tight">Pengajar</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Dibimbing langsung oleh para 
                        <span class="font-bold text-green-700">Juara MTQ & MHQ</span> 
                        tingkat Nasional & Internasional.
                    </p>
                </div>
            </div>

            <!-- CARD 03 -->
            <div class="group relative bg-[#F4F9F7] rounded-2xl p-8 border-l-[12px] border-[#183F3B] shadow-sm hover:shadow-2xl hover:bg-white transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <!-- Angka di Pojok Kanan Atas (Diperjelas) -->
                <span class="absolute top-4 right-6 text-7xl font-black text-[#183F3B] opacity-10 group-hover:opacity-20 transition-opacity duration-500 select-none pointer-events-none">03</span>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-[#183F3B] text-white rounded-2xl flex items-center justify-center mb-10 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-extrabold text-[#183F3B] mb-4 tracking-tight">Bersanad</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Ilmu Al-Qur'an yang diajarkan telah terverifikasi dan 
                        <span class="font-bold text-green-700">Memiliki Sanad</span> 
                        yang jelas.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SEJARAH YAYASAN & VIDEO -->
<section class="py-16 bg-white fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="space-y-6">
                <h2 class="text-3xl md:text-4xl font-bold text-emerald-800 leading-tight">
                    Rumah Qur'an Asy-Syams
                </h2>

                <p class="text-gray-600 text-justify leading-relaxed">
                    Rumah Qur’an Asy-Syams adalah sebuah fasilitator Pembelajaran yang berfokus pada pembinaan Tahsin, Tahfizh dan Seni Baca Al-Qur’an dengan 7 Irama Al-Qur’an, baik dengan Murottal dan Mujawwad. Serta mencetak kader-kader Juara MTQ & MHQ
                </p>
            </div>

            <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-2xl border-4 border-white ring-1 ring-gray-200">
                <iframe
                    class="absolute top-0 left-0 w-full h-full"
                    src="https://www.youtube.com/embed/ExTHDaHW9uw"
                    title="Profile Pondok As-Syams"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                ></iframe>
            </div>

        </div>
    </div>
</section>

<!-- KELAS SECTION DENGAN RE-ORDER IKON -->
<section class="py-16 bg-gray-50 fade-in-section" id="kelas">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Kelas di <span class="text-green-800">Rumah Qur'an Asy-Syams</span>
            </h2>
            <p class="mt-4 text-gray-500">
                Pilihan program pembelajaran Al-Qur'an sesuai kebutuhan Anda.
            </p>
            <div class="mt-4 w-24 h-1 bg-yellow-400 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- KELAS TAHSIN (Ikon Al-Qur'an) -->
            <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center group-hover:bg-green-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 ease-in-out shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-[#183F3B] mb-3 transition-colors group-hover:text-green-700">Kelas Tahsin</h3>
                <p class="text-gray-500 leading-relaxed text-sm">
                Program pembelajaran yang fokus pada memperbaiki cara membaca Al-Qur’an sesuai kaidah tajwid dan makharijul huruf agar bacaan menjadi fasih dan benar.
                </p>
            </div>

            <!-- KELAS MUROTTAL (Ikon Harmonisasi Suara) -->
            <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center group-hover:bg-yellow-500 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 ease-in-out shadow-inner">
                        <!-- Ikon Harmonisasi / Speaker Wave -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-[#183F3B] mb-3 transition-colors group-hover:text-yellow-600">Kelas Murottal</h3>
                <p class="text-gray-500 leading-relaxed text-sm">
                Kelas yang fokus pada melatih cara membaca Al-Qur’an dengan irama dan tartil yang indah sesuai kaidah tajwid.
                </p>
            </div>

            <!-- KELAS TILAWAH (Ikon Microphone) -->
            <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 ease-in-out shadow-inner">
                        <!-- Ikon Mic Tilawah -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-[#183F3B] mb-3 transition-colors group-hover:text-blue-700">Kelas Tilawah</h3>
                <p class="text-gray-500 leading-relaxed text-sm">
                    Pelajari seni lagu (Nagham) Kelas khusus ini mendalami berbagai jenis irama qira’ah dan seni baca Al-Qur'an secara profesional.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- NEWS & ARTICLE SECTION -->
<section class="py-16 bg-gray-50 fade-in-section" id="berita">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Berita & <span class="text-emerald-600">Artikel</span> Yayasan
            </h2>
            <p class="mt-4 text-gray-500">
                Informasi terbaru seputar kegiatan dan prestasi YPTQ Asy-Syams.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">

                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ asset('storage/' . str_replace('\\', '/', $post->image)) }}"
                            onerror="this.onerror=null; this.src='https://placehold.co/600x400/059669/white?text=Gambar+Berita'"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                        >

                        <div class="absolute top-4 left-4">
                            <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                {{ $post->category }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight mb-2 group-hover:text-emerald-600 transition">
                            <a href="{{ route('post.show', $post->slug) }}">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        </h3>

                        <div class="flex flex-wrap items-center text-sm text-gray-500 mt-4 gap-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $post->published_at ? $post->published_at->diffForHumans() : '-' }}
                            </div>

                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $post->author->name }}
                            </div>

                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $post->views }}
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="md:col-span-3 text-center py-10">
                    <p class="text-gray-500 italic">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>

        @if($posts->count() > 0)
            <div class="mt-10 text-center">
                <a href="#" class="inline-block bg-emerald-600 text-white font-bold py-3 px-8 rounded hover:bg-emerald-700 transition">
                    Load More News
                </a>
            </div>
        @endif

    </div>
</section>

<!-- CONTACT SECTION -->
<section id="contact" class="py-20 bg-gray-50 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Hubungi <span class="text-emerald-600">Kami</span>
            </h2>
            <p class="mt-4 text-gray-500 text-lg">
                Punya pertanyaan seputar pendaftaran atau program Rumah Qur'an Asy-Syams?
                <br>
                Silakan datang langsung atau kirim pesan kepada kami.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <div class="space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600 hover:shadow-md transition">
                        <div class="flex items-center mb-3">
                            <div class="p-2 bg-green-100 rounded-lg text-green-600 mr-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800">Alamat Kantor</h4>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Alamat : Jl. Tegal Sari <br>
                            Gg. Kemuning No. 9 kel. Umban sari Kec. Rumbai kota Pekanbaru
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600 hover:shadow-md transition">
                        <div class="flex items-center mb-3">
                            <div class="p-2 bg-green-100 rounded-lg text-green-600 mr-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800">Layanan Informasi</h4>
                        </div>
                        <p class="text-gray-600 text-sm">
                            <span class="block mb-1">WA: +62 853-7637-4040</span>
                        </p>
                    </div>

                </div>

                <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 h-80 relative overflow-hidden group">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127643.57373716064!2d101.36690262797602!3d0.5262668730479014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5abb7e269c709%3A0x184054230052062c!2sPekanbaru%2C%20Kota%20Pekanbaru%2C%20Riau!5e0!3m2!1sid!2sid!4v1698765432100!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-lg grayscale group-hover:grayscale-0 transition duration-500"
                    ></iframe>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border-t-4 border-orange-700 relative overflow-hidden">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-100 border border-emerald-400 text-emerald-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                placeholder="Contoh: Abdullah"
                            >
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                    placeholder="email@contoh.com"
                                >
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                                <input
                                    type="number"
                                    name="phone"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                    placeholder="0812xxx"
                                >
                                @error('phone')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pesan</label>
                            <textarea
                                name="message"
                                rows="4"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                placeholder="Tulis pertanyaan Anda di sini..."
                            ></textarea>
                            @error('message')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-orange-700 text-white font-bold py-3 px-6 rounded-lg hover:bg-orange-800 transition transform hover:-translate-y-1 shadow-lg flex justify-center items-center gap-2"
                        >
                            <span>Kirim Pesan Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>

                    </div>
                </form>

                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-yellow-100 rounded-full blur-2xl opacity-50 pointer-events-none"></div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('initCountdown', (expiryStr) => ({
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            expiryTime: 0,

            startCountdown() {
                try {
                    this.expiryTime = new Date(expiryStr).getTime();

                    if (isNaN(this.expiryTime)) {
                        this.expiryTime = new Date(expiryStr.replace(' ', 'T')).getTime();
                    }
                } catch (error) {
                    console.error('Error parsing date:', error);
                }

                this.updateCountdown();

                setInterval(() => {
                    this.updateCountdown();
                }, 1000);
            },

            updateCountdown() {
                const now = new Date().getTime();
                const diff = this.expiryTime - now;

                if (diff > 0) {
                    this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                    this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                    this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
                } else {
                    this.days = '00';
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                }
            }
        }));
    });
</script>

@endsection