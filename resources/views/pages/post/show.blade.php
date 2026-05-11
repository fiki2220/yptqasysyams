@extends('root.app')

@section('title', $post->title . ' - YPTQ Asy-Syams')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- KOLOM KIRI: KONTEN BERITA -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Image -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
                    @if($post->image_caption)
                        <div class="p-3 bg-gray-100 text-gray-500 text-sm italic text-center border-t border-gray-200">
                            {{ $post->image_caption }}
                        </div>
                    @endif
                </div>

                <!-- Title & Meta -->
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded uppercase">
                            {{ $post->category }}
                        </span>
                        <span class="text-gray-400 text-sm">•</span>
                        <span class="text-gray-500 text-sm">{{ $post->published_at->format('d F Y') }}</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-6">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                {{ substr($post->author->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $post->author->name }}</p>
                                <p class="text-xs text-gray-500">Penulis / Admin</p>
                            </div>
                        </div>
                        
                        <!-- View Count -->
                        <div class="flex items-center text-gray-400 text-sm">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ number_format($post->views) }} Views
                        </div>
                    </div>

                    <!-- Article Body (Rich Text) -->
                    <div class="prose prose-lg prose-green max-w-none text-gray-700">
                        {!! $post->content !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="mt-10 pt-8 border-t border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Bagikan Artikel Ini:</h4>
                        <div class="flex gap-2">
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition flex items-center text-sm font-bold">
                                WhatsApp
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center text-sm font-bold">
                                Facebook
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin!')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition flex items-center text-sm font-bold">
                                Copy Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: SIDEBAR (RECENT POSTS) -->
            <div class="lg:col-span-1 space-y-8">
                
                <!-- Search (Visual Only) -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Cari Berita</h3>
                    <div class="relative">
                        <input type="text" placeholder="Ketik kata kunci..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Recent Posts Widget -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-green-500 pl-3">Berita Terbaru</h3>
                    <div class="space-y-5">
                        @foreach($recentPosts as $recent)
                            <div class="flex gap-4 group">
                                <a href="{{ route('post.show', $recent->slug) }}" class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $recent->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" alt="thumb">
                                </a>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 leading-snug mb-1 group-hover:text-green-600 transition">
                                        <a href="{{ route('post.show', $recent->slug) }}">
                                            {{ Str::limit($recent->title, 45) }}
                                        </a>
                                    </h4>
                                    <span class="text-xs text-gray-400">{{ $recent->published_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Banner/Ads Placeholder -->
                <div class="bg-green-700 rounded-xl p-6 text-center text-white">
                    <h3 class="text-xl font-bold mb-2">Pendaftaran Dibuka!</h3>
                    <p class="text-sm text-green-100 mb-4">Segera daftarkan putra-putri Anda untuk tahun ajaran baru.</p>
                    <a href="{{ route('register') }}" class="inline-block bg-yellow-400 text-green-900 font-bold px-6 py-2 rounded-full hover:bg-yellow-300 transition">Daftar Sekarang</a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection