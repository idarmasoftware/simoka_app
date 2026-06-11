# SIMONITA
**Sistem Informasi Monitoring Terapi Okupasi & Perkembangan Anak**

## 📝 Deskripsi Sistem
SIMONITA adalah platform digital yang dirancang untuk membantu terapis okupasi dan orang tua dalam memantau perkembangan anak secara terukur. Sistem ini fokus pada asesmen sensorik (seperti Sensory Short Profile - SSP) dan pelaporan perkembangan pasien secara real-time.

## 🚀 Tech Stack
- **Framework**: Laravel 13 (PHP 8.3+)
- **Styling**: Tailwind CSS v4 (Local)
- **Interactivity**: Alpine.js v3 (Local)
- **Dropdown/Search**: Tom Select (Local)
- **Database**: MySQL / PostgreSQL
- **Asset Manager**: Vite

## 👥 Role & Hak Akses
1. **Super Admin (Administrator)**
   - Akses penuh ke seluruh modul sistem.
   - Mengelola akun Terapis dan Admin lainnya.
   - Melihat laporan perkembangan global.
2. **Terapis (Occupational Therapist)**
   - Mengelola data Orang Tua dan Pasien (Anak).
   - Melakukan asesmen (SSP, dll) terhadap pasien.
   - Memberikan catatan medis dan rekomendasi terapi.
   - Melihat grafik perkembangan pasien yang ditangani.
3. **Orang Tua (Parent)**
   - Mendaftarkan diri secara mandiri (Self-Registration).
   - Mengelola profil anak (Pasien).
   - Mengisi kuesioner asesmen mandiri jika diminta.
   - Melihat hasil asesmen dan laporan perkembangan anak.

## 🔄 Alur Sistem (System Flow)
1. **Autentikasi**:
   - Login menggunakan **Username** dan Password.
   - Registrasi mandiri hanya tersedia untuk role **Orang Tua**.
   - Role **Terapis** hanya bisa dibuat oleh **Super Admin**.
2. **Manajemen Pasien**:
   - Orang Tua/Terapis menambahkan data Anak.
   - Setiap Anak (Pasien) dihubungkan dengan satu Orang Tua dan satu Terapis Penanggung Jawab.
3. **Asesmen SSP (Sensory Short Profile)**:
   - Terapis membuka form asesmen SSP untuk pasien tertentu.
   - Mengisi kuesioner Skala Likert (1-5) pada berbagai domain sensorik.
   - Sistem menghitung skor secara otomatis dan memberikan status (Typical/Probable/Definite Difference).
4. **Monitoring**:
   - Dashboard menampilkan ringkasan jumlah pasien, asesmen terbaru, dan status perkembangan.

## 📊 Progress Fitur
- [x] **Base Layout & Design System**: Tailwind v4 Integration.
- [x] **Auth System**: Login, Register (Parent), Logout, Profile Management.
- [x] **User Management**: CRUD User (Admin, Terapis, Orang Tua).
- [x] **Patient Management**: CRUD Pasien (Anak) dengan Searchable Dropdown.
- [x] **SSP UI**: Interface kuesioner SSP dengan Progress Tracking.
- [/] **SSP Logic**: Perhitungan skor otomatis (In Progress).
- [ ] **Reporting**: Export PDF & Grafik Perkembangan.
- [ ] **Medical Records**: Riwayat kunjungan dan terapi.

## 🗄️ Skema Database (Inti)

### Tabel `users`
- `name`, `email`, `phone_number`, `username`, `password`, `role`, `is_active`

### Tabel `children`
- `parent_id` (FK: users), `therapis_id` (FK: users), `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `catatan_medis`, `is_active`

---
*Terakhir diperbarui: 12 Mei 2026*
