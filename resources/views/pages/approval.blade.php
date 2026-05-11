@extends('root.app')

@section('title', 'Menunggu Verifikasi')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border-t-4 border-yellow-500 text-center">
        
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-4">
            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">
                Pendaftaran Berhasil!
            </h2>
            <p class="mt-4 text-lg text-gray-600">
                Halo, <span class="font-bold text-gray-800">{{ Auth::user()->name }}</span>.
            </p>
            <p class="mt-2 text-gray-500">
                Akun Anda sedang dalam proses verifikasi oleh Admin Rumah Qur'an. <br>
                Silakan tunggu informasi kelulusan atau aktivasi akun.
            </p>
            <p class="mt-4 text-sm text-yellow-600 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                Status: <strong>MENUNGGU VERIFIKASI</strong>
            </p>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-400 mb-4">Ingin cek lagi nanti?</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none transition">
                    Keluar (Logout)
                </button>
            </form>
        </div>

    </div>
</div>
@endsection