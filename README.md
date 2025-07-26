<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📦 REQUIREMENT

Sebelum memulai, pastikan Anda telah menginstal:

-   PHP >= 8.1
-   Composer
-   MySQL / mariadb

---

## ⚙️ INSTALATION

Ikuti langkah-langkah di bawah ini untuk mempersiapkan proyek:

### 1. Clone Proyek

```bash
git clone https://github.com/username/nama-proyek.git
cd nama-proyek
```

### 2. Salin File Environment

```bash
cp .env.example .env
```

### 3. Generate Key Aplikasi

```bash
php artisan key:generate
```

### 4. Install Dependensi PHP

```bash
composer install
```


### 5. Jalankan Server Laravel

```bash
php artisan serve
```

## 🧪 Migrasi & Seed Database (Opsional)

Jika proyek ini menggunakan database dan seeder, jalankan:

```bash
php artisan migrate --seed
```

---

## 🛠️ Struktur Umum Proyek

```bash
app/                # Kode utama backend (Controllers, Models, dll.)
  ├── Http/Controllers # Controller aplikasi
  ├── Models/          # model relational database
resources/
  ├── views/        # View Blade templates
     └── componenets/        # Component Blade templates
  └── css/          # Stylesheets
routes/             # File routing Laravel (web.php)
public/             # Aset publik
```

---

## 💡 Tips Pengembangan

-   Gunakan `php artisan route:list` untuk melihat semua rute.
-   Jika ada perubahan besar pada `.env`, jalankan `php artisan config:clear`.

---

## 📄 MIT LICENSE

Proyek ini menggunakan lisensi [MIT](LICENSE).
