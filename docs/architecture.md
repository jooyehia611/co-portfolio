# Architecture

## Stack

| Layer | Tech |
|-------|------|
| API / Admin | Laravel 12, Blade, MySQL |
| Public site | React 19, Vite, TypeScript, Tailwind |
| i18n | EN / AR (API + admin + frontend) |

## Flow

```
Browser (React) ──REST──▶ Laravel API (/api/v1)
Browser (Admin) ──HTML──▶ Laravel Blade (/admin)
```

Content is managed in `/admin`, served to the site via JSON.

## Backend layout

- `routes/api.php` — public API
- `routes/admin.php` — admin CRUD
- `app/Http/Controllers` — API + Admin
- `app/Services` — business logic
- `app/Models` — Eloquent
- `resources/views/admin` — admin UI

## Frontend layout

- `src/pages` — routes/screens
- `src/features` — section UI
- `src/services` — API calls
- `src/api` — axios client + endpoints
- `src/i18n` — locale

## Conventions

- Bilingual fields stored as JSON (`en` / `ar`)
- Media via `MediaFile` + storage disk
- Keep backend/frontend changes scoped; prefer services over fat controllers
