import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Tambahkan fungsi untuk menangani preloader
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        setTimeout(() => {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
        }, 500);
    }
});

Alpine.start();