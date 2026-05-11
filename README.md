# Dokumentasi Sistem & Pengujian YPTQ Asy-Syams

## 1. Ikhtisar Sistem

**Asy-Syams** adalah sebuah platform berbasis web yang dikembangkan menggunakan **Laravel 12** dan **Filament v3** (TALL Stack) untuk mengelola operasional Yayasan Pendidikan Tilawah Qur'an. Sistem ini mencakup manajemen santri, penjadwalan kelas, rekap absensi, penilaian (Grade/Assessment), hingga integrasi pembayaran *online* dengan Midtrans.

Sistem dirancang mengadopsi prinsip **Clean Architecture** dengan memisahkan antarmuka (Controller/Livewire) dari logika bisnis utama (*Service Layer*), menjadikannya lebih *modular*, mudah diuji (*testable*), dan mudah dikembangkan di kemudian hari (*scalable*).

---

## 2. Arsitektur & Cara Kerja Sistem (Modul Utama)

### A. Autentikasi dan RBAC (Role-Based Access Control)

Sistem membedakan hak akses (*roles*) ke dalam tiga kategori: `superadmin`, `admin` (ustad/pengajar), dan `student` (santri).

- **Cara Kerja:** Model `User` mengimplementasikan fungsi kontrak `canAccessPanel(Panel $panel)` milik Filament. Hanya *user* dengan role `admin` atau `superadmin` yang diizinkan untuk masuk ke dasbor backend Filament (misal: `/admin`). Jika *student* memaksa masuk, sistem secara otomatis melemparkan HTTPException 403 (Forbidden) atau akan diarahkan keluar (*redirect*).
- **Proteksi Aktif:** Terdapat *Middleware* `EnsureUserIsActive` yang memastikan hanya *user* berstatus `is_active = true` yang bisa menavigasi ke fitur-fitur sensitif.

### B. Modul Registrasi (SPMB) & Tampilan Depan

- **Cara Kerja:** Pengunjung dapat melihat halaman *Home* dan form registrasi SPMB (*Seleksi Penerimaan Murid Baru*).
- **Refactoring:** Semua *logic* penarikan artikel berita, gambar *Hero Background*, dan hitung mundur kalender batas akhir pendaftaran dienkapsulasi di dalam `app/Services/HomeService.php`. Hal ini membuat rute `web.php` bebas dari injeksi kueri *Database* yang berat. `HomeController` hanya memanggil method dari service tersebut.

### C. Modul Akademik & Kehadiran (Attendance)

- **Cara Kerja:** Melalui panel Filament (contohnya `MeetingResource`), Ustad dapat membuat jadwal *Meeting* (pertemuan) untuk *Class Group* yang diajarnya.
- Begitu Ustad memilih *Class Group*, sebuah form dengan konsep *repeater* otomatis terisi oleh daftar santri dalam kelas tersebut.
- Ustad menetapkan presensi santri via tombol interaktif (*Toggle Buttons*) untuk status `present`, `sick`, `permission`, atau `alpha`. Data ini disimpan di tabel `attendances` dan terikat dengan ID pertemuan.

### D. Penilaian (Grades Calculation)

- **Cara Kerja:** Evaluasi nilai santri terbagi dalam format matriks `Assessment` (penilaian harian menggunakan string huruf L/C/TL) dan `Evaluation` (penilaian ujian berbasis poin persentase).
- Semua beban kalkulasi dan *parsing* JSON dikerjakan oleh **`GradeCalculationService`**.
- *Service* ini akan secara cermat mengalkulasi *Assessment Average* (contoh: L=100, C=75, TL=50) dan *Evaluation Average*, kemudian meleburkannya dalam bobot pembagian nilai akhir (contoh: 40% rata-rata Assessment + 60% rata-rata Evaluation).
- Disediakan proteksi dari *Division by Zero* (pembagian dengan angka 0) jika data *assessment* kosong.

### E. Integrasi Keuangan (Midtrans Payment Webhook)

- **Cara Kerja:** Santri dari *Dashboard* miliknya (`/dashboard`) akan melihat tombol "Bayar Sekarang" saat terdapat tagihan dengan status `pending`. Begitu ditekan, komponen *Snap* dari Midtrans akan meluncur di layar web (tanpa harus ke halaman eksternal).
- **Sistem Webhook:** Backend Laravel mendengarkan pemberitahuan asinkronus (callback) melalui route `/payment/webhook`.
- Route dilempar menuju **`MidtransService`**. Di sinilah validasi *Signature Key* dilakukan demi memverifikasi keaslian paket data dari *server* Midtrans.
- *Idempotent Update:* Kode kebal terhadap balapan pembaruan (*Race Condition*). Jika Midtrans tak sengaja mengirimkan webhook untuk order yang sudah lunas (status `paid` atau `success`), maka sistem tidak merespon/mencatat ulang.

---

## 3. Dokumentasi Pengujian Sistem (Test Suite)

Kerangka kerja tes dijalankan murni dengan **PHPUnit** (`phpunit.xml`) memanfaatkan *database* isolasi in-memory (`sqlite:memory`) sehingga pengujian tidak menyentuh database produksi.

Sistem saat ini dalam keadaan **100% PASS (Zero Bugs)** pada 6 ruang lingkup skenario berikut:

### 1. `SpmbRegistrationTest` (Feature Test)

*Menguji visibilitas sistem pada tamu/public.*

- **`test_home_page_returns_a_successful_response`**: Menyimulasikan *GET Request* ke URL `/`. **Hasil: PASS** (HTTP 200).
- **`test_registration_page_returns_a_successful_response`**: Menyimulasikan akses form `/register`. **Hasil: PASS** (HTTP 200).

### 2. `RbacTest` (Feature Test)

*Menguji keamanan pintu masuk administrasi Filament (RBAC).*

- **`test_santri_cannot_access_admin_panel`**: *User* `student` diotentikasi lalu meretas akses masuk ke `/admin/meetings`. **Hasil: PASS**. *Middleware Filament melempar 403 Forbidden dengan tepat.*
- **`test_ustad_can_access_admin_panel`**: *User* `admin` diotentikasi lalu masuk ke menu administrasi yang sama. **Hasil: PASS**. *(Akses diizinkan dengan HTTP 200).*

### 3. `GradeCalculationTest` (Unit Test)

*Menguji akurasi kalkulasi matematika internal milik `GradeCalculationService` tanpa perlu melibatkan Database/Browser.*

- **`test_calculate_assessment_average_perfect_score`**: Input nilai rata 'L'. **Hasil: PASS** (Akurasi Rata-rata: 100.0).
- **`test_calculate_assessment_average_mixed_scores`**: Input kombinasi huruf mutu ('L', 'C', 'TL'). **Hasil: PASS** (Dapat dikonversi dan dikalkulasi sempurna).
- **`test_calculate_assessment_average_division_by_zero`**: Input array kosong untuk menyimulasikan kelalaian penginputan Ustad. **Hasil: PASS** (Dikembalikan sebagai angka `0.0`, error *fatal* terhindari).
- **`test_calculate_evaluation_average_decimal_scores`**: Menyimulasikan ujian dengan poin riil bertipe Desimal/Float. **Hasil: PASS**.
- **`test_calculate_final_grade`**: Memasukkan bobot ganda untuk tes output akumulasi rapor (40% dan 60%). **Hasil: PASS** (Akurasi output presisi tinggi sesuai kalkulator).

### 4. `AttendanceTest` (Feature Test / Livewire Filament)

*Menguji fungsionalitas UI komponen Livewire `CreateMeeting` di panel Filament.*

- **`test_ustad_can_create_meeting_and_save_attendance`**:

  1. Sistem secara virtual *mock* kelas, mata pelajaran, dan relasi santri.
  2. Menyimulasikan ketikan/input data absen dari *form* Livewire/Filament Ustad.
  3. Pengecekan pada database.

  - **Hasil: PASS**. Kolom kehadiran pada tabel `attendances` berhasil disimpan dan direlasikan ke id santri, id *meeting*, secara utuh.

### 5. `MidtransWebhookTest` (Feature Test)

*Skenario vital untuk proteksi celah peretasan dari simulasi IP di luar aplikasi.*

- **`test_webhook_can_update_payment_status_to_paid_on_settlement`**: Mendorong paket JSON webhook berisi instruksi *settlement* Midtrans dilengkapi `signature_key` akurat (enkripsi SHA512). **Hasil: PASS**. Webhook me-respons 200 dan baris `status` tagihan berubah menjadi `paid`.
- **`test_webhook_rejects_invalid_signature`**: Mendorong perintah mutasi saldo secara ilegal menggunakan *Signature Key* bohongan. **Hasil: PASS**. Webhook menolak *(HTTP 403)*, tagihan diamankan dan status tidak tertimpa (*tetap `pending`*).

### 6. `StudentDashboardPaymentTest` (Feature Test / UI Assertion)

*Mengecek render logika Tampilan Blade dari sisi Santri.*

- **`test_pay_button_is_visible_when_status_is_pending`**: Status dummy disetel ke `pending`. **Hasil: PASS**. Assertions mendeteksi keberadaan tag HTML tombol *Bayar* secara utuh dan teks peringatan "MENUNGGU PEMBAYARAN".
- **`test_pay_button_is_disabled_and_shows_lunas_when_status_is_paid`**: Status di database di-mock menjadi `paid`. **Hasil: PASS**. Tombol *Bayar* lenyap total dari DOM UI, lalu pesan keterangan berhasil diganti menjadi tulisan "Sudah Lunas" dan UI menampilkan tulisan "LUNAS".
