# 🔗 Laravel URL Shortener API

A clean and modular Laravel-based URL shortening service. Easily generate short links and handle redirection with scalable architecture.

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
- [ ] Implement caching for frequently accessed short links (e.g., via Redis)
- [ ] Support URL expiration
- [ ] Allow custom short codes
