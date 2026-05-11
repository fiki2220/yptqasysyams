@extends('root.app')

@section('title', 'Akses Tidak Diizinkan')

@section('content')
@php
    $user = auth()->user();
    $fallback = $user?->getFirstAllowedFilamentRoute();

    if ($user?->role === 'superadmin') {
        $buttonLabel = 'Kembali ke Admin Panel';
        $buttonUrl = url('/admin');
    } elseif ($user?->role === 'student') {
        $buttonLabel = 'Kembali ke Dashboard';
        $buttonUrl = route('dashboard');
    } else {
        $buttonLabel = 'Kembali ke Halaman yang Tersedia';
        $buttonUrl = $fallback ?: route('dashboard');
    }
@endphp

<main class="min-h-[70vh] bg-gray-50 flex items-center justify-center px-4 py-12">
    <section class="w-full max-w-lg bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-700" aria-hidden="true">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 text-balance">Akses Tidak Diizinkan</h1>
        <p class="mt-3 text-sm leading-6 text-gray-600">
            Hak akses Anda telah berubah atau Anda tidak memiliki izin membuka halaman ini.
        </p>

        <a
            href="{{ $buttonUrl }}"
            class="mt-8 inline-flex min-h-11 items-center justify-center rounded-md bg-green-700 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-green-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-700 focus-visible:ring-offset-2"
        >
            {{ $buttonLabel }}
        </a>
    </section>
</main>
@endsection
