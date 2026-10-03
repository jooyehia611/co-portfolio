# Ytech Portfolio

Monorepo: Laravel API + admin panel, React public site.

```
portfolio/
├── backend/     # Laravel 12 (API + /admin)
├── frontend/    # React 19 + Vite
└── docs/        # architecture, api
```

## Requirements

- PHP 8.2+, Composer, MySQL
- Node 20+

## Setup

### Backend

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
# set DB_* in .env
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Admin: `http://localhost:8000/admin`

### Frontend

```bash
cd frontend
cp .env.example .env
npm install
npm run dev
```

Site: `http://localhost:5174`  
API base: `VITE_API_URL` → `http://localhost:8000/api/v1`

## Docs

- [Architecture](docs/architecture.md)
- [API](docs/api.md)
