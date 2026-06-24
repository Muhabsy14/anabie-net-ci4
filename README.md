# Sistem Informasi Manajemen Layanan dan Pembayaran WiFi — Anabie Net

Studi kasus: **Anabie Net**, Kecamatan Warungasem, Kabupaten Batang.

Dibangun dengan **PHP 8** dan **CodeIgniter 4**, mengikuti desain UI/UX (tema biru tua `#0b1c30` / `#131b2e` dan oranye `#9d4300` / `#fd761a`).

## Fitur

### Owner
- Login / Logout
- Dashboard
- Kelola Admin
- Kelola Pelanggan
- Kelola Paket & Layanan
- Kelola Tagihan
- Kelola Pembayaran (pencatatan + upload bukti pembayaran)
- Kirim Notifikasi via WhatsApp
- Kelola Pengaduan
- Laporan resmi + **cetak PDF dengan kop surat & logo**
- Profil

### Admin
- Login / Logout
- Dashboard
- Kelola Pelanggan
- Profil
- Kelola Paket & Layanan
- Kelola Tagihan
- Kelola Pembayaran (pencatatan + upload bukti pembayaran)
- Kirim Notifikasi via WhatsApp (Cloud API + cadangan wa.me)
- Kelola Pengaduan
- Laporan operasional + **cetak PDF**

### Pelanggan
- Login / Logout
- Dashboard
- Profil
- Lihat Tagihan
- Riwayat Pembayaran
- Ajukan Pengaduan

## Instalasi

### 1. Persyaratan
- PHP 8.1+
- Composer
- MySQL / MariaDB
- Extension: `intl`, `mbstring`, `mysqli`

### 2. Database
Buat database MySQL:

```sql
CREATE DATABASE anabie_net CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Sesuaikan kredensial di file `.env` (salin dari `env` jika `.env` belum ada).

### 3. Migrasi & data contoh

```bash
cd anabie-net
composer install
php spark migrate
php spark db:seed AnabieNetSeeder
```

### 4. Jalankan server

```bash
php spark serve
```

Buka: http://localhost:8080

## Akun demo

| Role      | Username | Password        |
|-----------|----------|-----------------|
| Owner     | owner    | owner123        |
| Admin     | admin    | admin123        |
| Pelanggan | budi     | pelanggan123    |
| Pelanggan | siti     | pelanggan123    |

## Struktur folder

```
anabie-net/
├── app/
│   ├── Controllers/Admin|Pelanggan|AuthController.php
│   ├── Models/
│   ├── Views/          # Tampilan sesuai mockup UI
│   └── Database/Migrations|Seeds/
├── public/             # Document root
└── Desain UI asli ada di folder induk: Desain Ui_Ux/
```

## Cetak laporan PDF

1. Login sebagai admin → menu **Laporan**
2. Pilih bulan/tahun → klik **Cetak PDF**
3. File diunduh otomatis (Dompdf)

Route: `GET /admin/laporan/pdf?bulan=5&tahun=2026`

## WhatsApp Cloud API (resmi — Meta)

Sistem mendukung **[WhatsApp Business Cloud API](https://developers.facebook.com/docs/whatsapp/cloud-api)**:

1. Buat aplikasi di [Meta for Developers](https://developers.facebook.com/)
2. Tambahkan produk **WhatsApp** → dapatkan **Phone Number ID** dan **Access Token** (permanen)
3. Isi di `.env`:

```ini
whatsapp.cloud.enabled = true
whatsapp.cloud.access_token = EAAxxxxxxxx...
whatsapp.cloud.phone_number_id = 123456789012345
whatsapp.cloud.api_version = v21.0
whatsapp.fallback_wame = true
```

4. Jalankan migrasi tambahan (kolom riwayat API):

```bash
php spark migrate
```

5. Admin → **Notifikasi WhatsApp** → pilih metode:
   - **Otomatis**: API dulu, jika gagal buka wa.me
   - **Hanya API**: kirim langsung tanpa wa.me
   - **Hanya wa.me**: mode manual seperti sebelumnya

Nomor pelanggan harus format internasional (mis. `0812...` otomatis jadi `62812...`).

## Halaman login (pixel-perfect)

Halaman login (`app/Views/auth/login.php`) diselaraskan dengan `Desain Ui_Ux/login_anabie_net/code.html`: token Tailwind lengkap, tab Admin/Pelanggan, toggle password, checkbox ingat saya, tombol Cek Paket/Bantuan, badge keamanan, dan kartu promo fiber.

## Lisensi

Proyek skripsi — penggunaan akademik.
