# ⚡ QUICK START - Atur Deadline SPMB

## 🎯 Cara Cepat (60 detik)

### 1️⃣ Buka Filament Admin
```
Login → Pengaturan → Setting Website
```

### 2️⃣ Klik Tombol Hijau
Cari tombol **"⏱️ Atur Deadline SPMB"** di bagian atas halaman

### 3️⃣ Isi Form
```
Waktu Berakhir: Klik → Pilih Tanggal & Jam → Simpan
```

### 4️⃣ Cek Halaman Home
```
Buka website → Scroll ke section countdown → Lihat perubahan
```

---

## 🔧 Contoh Konfigurasi

### Contoh 1: SPMB Tutup Akhir Tahun
```
Tanggal: 31 Desember 2026
Jam: 23:59

Tampil sebagai:
"Batas Akhir: Kamis, 31 Desember 2026, 23:59 WIB"
```

### Contoh 2: SPMB Tutup Akhir Bulan
```
Tanggal: 28 Februari 2026
Jam: 17:00 (jam 5 sore)

Tampil sebagai:
"Batas Akhir: Jumat, 28 Februari 2026, 17:00 WIB"
```

---

## 📱 Tampilan di Home Page

Setelah disimpan, countdown akan muncul di section ini:

```
┌─────────────────────────────────────────┐
│  SPMB Akan Berakhir Pada:               │
│  Batas Akhir: Jumat, 28 Februari 2026   │
│             17:00 WIB                   │
│                                         │
│  100 : 05 : 30 : 45                     │
│  Hari  Jam  Menit  Detik                │
└─────────────────────────────────────────┘
```

Countdown akan terus berjalan dan update setiap detik.

---

## ❓ FAQ Cepat

**P: Bagaimana jika saya ingin edit ulang?**
A: Kembali ke halaman Setting Website, klik tombol "⏱️ Atur Deadline SPMB" lagi, ubah tanggal, simpan.

**P: Countdown tidak update di halaman?**
A: Refresh halaman (Ctrl+F5) atau clear cache: `php artisan cache:clear`

**P: Timezone yang digunakan?**
A: WIB (Waktu Indonesia Barat)

**P: Bisa set jam lebih spesifik?**
A: Ya, bisa pilih detik dengan mengedit manual di form (defaultnya tanpa detik)

**P: Data lama akan hilang?**
A: Tidak, data lama akan tertimpa dengan yang baru (updateOrCreate)

---

## 📞 Butuh Bantuan?

Lihat file lengkap:
- `DOKUMENTASI_SPMB_DEADLINE.md` - Panduan lengkap
- `SUMMARY_PERUBAHAN.md` - Detail technical perubahan

---

**💡 Tip:** Save halaman ini sebagai bookmark untuk referensi cepat!
