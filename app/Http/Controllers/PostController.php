<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Halaman Detail Berita
    public function show($slug)
    {
        // Cari berita berdasarkan slug
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Fitur: Tambah View Count setiap kali dibuka
        $post->increment('views');

        // Fitur: Recent Posts (Berita Terbaru Lainnya)
        // Ambil 5 berita terbaru, KECUALI berita yang sedang dibuka ini
        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id) 
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pages.post.show', compact('post', 'recentPosts'));
    }
}