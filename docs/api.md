# API

Base: `{APP_URL}/api/v1`  
Auth: none for public endpoints. Contact and voice review submissions are throttled; voice reviews require a private link.

Locale via `Accept-Language` or query where supported.

## Endpoints

| Method | Path | Notes |
|--------|------|--------|
| GET | `/home` | Homepage sections |
| GET | `/settings` | Site settings |
| GET | `/about` | About page |
| GET | `/services` | Services list |
| GET | `/services/{slug}` | Service detail |
| GET | `/projects` | Projects list |
| GET | `/projects/{slug}` | Project detail |
| GET | `/technologies` | Technologies |
| GET | `/testimonials` | Testimonials |
| GET | `/voice-reviews/{token}` | Validate a private, one-use voice review link |
| POST | `/voice-reviews/{token}` | Upload `multipart/form-data`: `client_name`, optional `client_title`, `client_company`, `audio_duration`, and `audio` (webm, ogg, mp3, mp4, m4a, or wav; max 10 MB) |
| GET | `/team` | Team list |
| GET | `/team/{slug}` | Team member |
| GET | `/contact/form-data` | Form options |
| POST | `/contact` | Submit lead |
| GET | `/pages/privacy` | Privacy page |
| GET | `/pages/terms` | Terms page |
| GET | `/seo/{key}` | Page SEO meta |

## Other

Create a voice review link from **Admin → Testimonials**. Links expire after 30 days and can be submitted once. Submissions enter as drafts; publish them from the same admin page to show them on the homepage. Public microphone recording requires HTTPS outside localhost. The Laravel public storage link must exist for playback.

| Path | Notes |
|------|--------|
| `/sitemap.xml` | SEO sitemap |
| `/robots.txt` | Robots |

## Example

```bash
curl http://localhost:8000/api/v1/home
curl -X POST http://localhost:8000/api/v1/contact \
  -H "Content-Type: application/json" \
  -d '{"name":"...","email":"...","message":"..."}'
```
