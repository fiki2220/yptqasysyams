<!-- Custom Loader CSS -->
<style>
    #preloader {
        position: fixed;
        top: 0; 
        left: 0;
        width: 100%; 
        height: 100vh;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .loader-hidden {
        opacity: 0;
        visibility: hidden;
    }

    /* Animasi Kustom Asy-Syams */
    .loader {
        position: relative;
        width: 2.5em;
        height: 2.5em;
        transform: rotate(165deg);
    }

    .loader:before, .loader:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        display: block;
        width: 0.5em;
        height: 0.5em;
        border-radius: 0.25em;
        transform: translate(-50%, -50%);
    }

    /* Durasi dipercepat ke 1.5s agar lebih responsif */
    .loader:before { animation: before8 1.5s infinite; }
    .loader:after { animation: after6 1.5s infinite; }

    @keyframes before8 {
        0% { 
            width: 0.5em; 
            box-shadow: 1em -0.5em rgba(24, 63, 59, 0.75), -1em 0.5em rgba(212, 175, 55, 0.75); 
        } /* Hijau & Emas */
        35% { 
            width: 2.5em; 
            box-shadow: 0 -0.5em rgba(24, 63, 59, 0.75), 0 0.5em rgba(212, 175, 55, 0.75); 
        }
        70% { 
            width: 0.5em; 
            box-shadow: -1em -0.5em rgba(24, 63, 59, 0.75), 1em 0.5em rgba(212, 175, 55, 0.75); 
        }
        100% { 
            box-shadow: 1em -0.5em rgba(24, 63, 59, 0.75), -1em 0.5em rgba(212, 175, 55, 0.75); 
        }
    }

    @keyframes after6 {
        0% { 
            height: 0.5em; 
            box-shadow: 0.5em 1em rgba(212, 175, 55, 0.75), -0.5em -1em rgba(24, 63, 59, 0.75); 
        } /* Emas & Hijau */
        35% { 
            height: 2.5em; 
            box-shadow: 0.5em 0 rgba(212, 175, 55, 0.75), -0.5em 0 rgba(24, 63, 59, 0.75); 
        }
        70% { 
            height: 0.5em; 
            box-shadow: 0.5em -1em rgba(212, 175, 55, 0.75), -0.5em 1em rgba(24, 63, 59, 0.75); 
        }
        100% { 
            box-shadow: 0.5em 1em rgba(212, 175, 55, 0.75), -0.5em -1em rgba(24, 63, 59, 0.75); 
        }
    }
</style>

<!-- Elemen Preloader -->
<div id="preloader">
    <div class="loader"></div>
</div>

<!-- Script untuk menyembunyikan loader -->
<script>
    (function() {
        function hideLoader() {
            const preloader = document.getElementById("preloader");
            if (preloader) {
                setTimeout(() => {
                    preloader.classList.add("loader-hidden");
                    preloader.style.opacity = '0';
                    preloader.style.visibility = 'hidden';
                }, 500); 
            }
        }

        // Jalankan segera jika dokumen sudah termuat
        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            // Tunggu hingga dokumen selesai termuat
            window.addEventListener("load", hideLoader);
        }

        // Dukungan untuk Livewire (Jika menggunakan wire:navigate)
        document.addEventListener('livewire:navigated', hideLoader);
    })();
</script>
