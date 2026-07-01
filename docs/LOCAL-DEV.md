# Local development

Sign-in uses the **same code path as production**: the browser calls `NEXT_PUBLIC_API_URL` directly with cookies. No Next.js proxy. Only env vars differ.

## Run (two terminals)

```bash
# Terminal 1 — Laravel API + admin (port 8000)
cd backend
php artisan serve

# Terminal 2 — Next.js public site incl. /media (port 9002)
cd studio
npm run dev
```

| URL | Purpose |
|-----|---------|
| http://localhost:9002 | Public site |
| http://localhost:9002/media | **Public video page** (not on port 8000) |
| http://localhost:8000/admin/media-videos | Admin video library |
| http://localhost:8000/admin/media-videos/create | Add by URL |

## Required env (already in `studio/.env.local` + `backend/.env`)

**studio/.env.local**

```env
NEXT_PUBLIC_API_URL=http://localhost:8000
NEXT_PUBLIC_ADMIN_URL=http://localhost:8000/admin
```

**backend/.env**

```env
APP_URL=http://localhost:8000
ADMIN_URL=http://localhost:8000/admin
FRONTEND_URL=http://localhost:9002
SESSION_DOMAIN=localhost
CORS_ALLOWED_ORIGINS=http://localhost:9002
```

`SESSION_DOMAIN=localhost` lets the CSRF cookie set by `:8000` be read on `:9002`.

## Production (for comparison)

| Variable | Production |
|----------|------------|
| `NEXT_PUBLIC_API_URL` | `https://api.indianopinions.com` |
| `NEXT_PUBLIC_ADMIN_URL` | `https://admin.indianopinions.com/admin` |
| `SESSION_DOMAIN` | `.indianopinions.com` |

Same `auth-api.ts` — no hostname checks, no rewrites.

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| “Cannot reach the API…” | Run `php artisan serve` in `backend/` |
| “CSRF cookie missing…” | Set `SESSION_DOMAIN=localhost` in `backend/.env`, then `php artisan config:clear` |
| Port 8000 wrong app | Stop other `php artisan serve` processes; only indianopinions backend on 8000 |
| Stale cookies | Clear site data for `localhost` in the browser |
