# Laravel Proper Kit

Laravel Proper Kit adalah starter kit atau boilerplate Laravel yang lengkap dengan autentikasi Breeze yang telah diubah menggunakan Bootstrap UI, bukan Tailwind CSS. Boilerplate ini dilengkapi dengan sistem manajemen pengguna, peran (role), izin (permission), menu dinamis, dan pengaturan situs (site setting) yang siap pakai.

## ✨ Fitur Utama

- **🔐 Autentikasi Breeze dengan Bootstrap** - Scaffolding autentikasi menggunakan Bootstrap UI
- **👥 Role & Permission Management** - Manajemen akses berbasis peran menggunakan package `spatie/laravel-permission`
- **🧭 Dynamic Menu System** - Sistem menu dinamis dengan kontrol akses berdasarkan role/permission
- **⚙️ Site Setting Management** - Pengaturan situs dinamis (logo, judul, URL) yang tersimpan di database
- **🎨 Bootstrap UI Components** - Menggunakan Bootstrap untuk styling dan komponen UI
- **📝 Blade Templates** - Menggunakan Blade templating engine dengan komponen

## 📦 Teknologi yang Digunakan

- **Framework:** [Laravel](https://laravel.com/)
- **Authentication:** Laravel Breeze dengan custom Bootstrap stack
- **Manajemen Role/Permission:** [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- **Frontend:** Bootstrap CSS Framework
- **Templating:** Blade Components
- **Database:** MySQL/PostgreSQL/SQLite

## 🚀 Instalasi dan Konfigurasi

### 1. Prasyarat
Pastikan server Anda memenuhi prasyarat Laravel:
- PHP 8.1+
- Composer
- Node.js & NPM

### 2. Install Laravel Project
```bash
composer create-project laravel/laravel laravel-proper-kit
cd laravel-proper-kit
```

### 3. Install dan Konfigurasi Breeze dengan Bootstrap
```bash
# Install Breeze
composer require laravel/breeze

# Install Breeze dengan stack Blade (akan kita custom dengan Bootstrap)
php artisan breeze:install blade
```

### 4. Replace Tailwind dengan Bootstrap
Berdasarkan pendekatan dari [paket laravel-breeze-bootstrap](https://gusiol.medium.com/laravel-breeze-with-bootstrap-45e5d6af76b3), lakukan customisasi:

**Install Bootstrap:**
```bash
npm install bootstrap @popperjs/core
```

**Hapus Tailwind dan tambahkan Bootstrap di `resources/css/app.css`:**
```css
@import 'bootstrap';
```

**Konfigurasi `vite.config.js`:**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
```

**Update `resources/js/app.js`:**
```javascript
import 'bootstrap';
```

### 5. Install dan Konfigurasi Package Pendukung

**Install Spatie Laravel Permission:**
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 6. Setup Database dan Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Konfigurasi database di .env
DB_DATABASE=nama_database_anda
DB_USERNAME=username_anda
DB_PASSWORD=password_anda

# Migrasi dan seeding
php artisan migrate --seed
```

### 7. Compile Assets
```bash
npm run build
```

### 8. Menjalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`
