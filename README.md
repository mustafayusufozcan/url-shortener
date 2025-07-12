# 🔗 Laravel URL Shortener API

A clean and modular Laravel-based URL shortening service. Easily generate short links and handle redirection with scalable architecture.

---

## 🚀 Features

- Shorten any valid URL
- Redirect to original URL
- Validation via Form Requests
- Separation of concerns using Service, DTO, and Resource layers
- Supports MySQL, PostgreSQL, SQLite
- Redis integration for caching and performance
- Ready for future features like analytics, expiration, and rate limiting

---

## 🛠️ Tech Stack

- Laravel 12+
- PHP 8.2+
- MySQL / SQLite
- Redis (for caching, optional but recommended)

---

## 📦 Installation

```bash
git clone https://github.com/mustafayusufozcan/url-shortener.git
cd url-shortener
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## 🧭 Roadmap

- [ ] Write automated tests
