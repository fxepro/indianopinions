# Indian Opinions — Laravel Backend

Headless CMS and PostgreSQL-backed publishing API for the Next.js editorial site in `../studio`.

Scaffolded from [SpaceGapsSite](https://github.com/xmash/spacegapssite) with articles, categories, tags, gallery, and newsletter support.

## Stack

- Laravel 13 + PHP 8.3
- PostgreSQL (production on Railway)
- SQLite (local dev default)
- Blade admin panel at `/admin`
- Read-only JSON API at `/api/*` for the Next.js frontend

## Local setup

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite   # if using SQLite
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

Admin login: **editor@indianopinions.com** / **password** (editor) or **writer@indianopinions.com** / **password** (writer). Change after first login.

## Editorial MVP

Two roles with a mandatory approval workflow:

| Role | Can do |
|------|--------|
| **Writer** | Create drafts, edit own drafts/revisions, submit for review |
| **Editor** | Everything writers can do, plus review queue, approve/publish, request changes, manage categories/tags/staff/gallery |

**Article statuses:** `draft` → `submitted` → `published` (or `changes_requested` → back to writer → resubmit).

Editors must approve via the **Review Queue** — writers cannot publish directly.

### Permissions matrix

Defined in `config/permissions.php`. Live view: **Admin → Permissions**.

| Area | Writer | Editor |
|------|--------|--------|
| Dashboard, own articles | Yes | Yes |
| Review queue, publish | — | Yes |
| Categories, tags, gallery, staff | — | Yes |
| Homepage & hub orchestration | — | Yes |

### Page orchestration

Editors curate slots at **Admin → Homepage** and **Admin → Hub Pages**. Empty slots fall back to latest published articles.

## API endpoints

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/articles` | Paginated published articles (`?category=politics&featured=1`) |
| GET | `/api/articles/{slug}` | Single article |
| GET | `/api/layout/homepage` | Resolved homepage layout |
| GET | `/api/layout/hubs/{slug}` | Resolved hub page layout |
| GET | `/api/categories` | All editorial hubs |
| GET | `/api/categories/{slug}` | Hub with its articles |
| POST | `/api/newsletter/subscribe` | `{ "email": "..." }` |

## Deployment (Railway)

1. Create a Railway project with PostgreSQL + web service from this `backend/` directory.
2. Set `APP_KEY` (`php artisan key:generate --show`).
3. Link Postgres — Railway injects `DATABASE_URL`.
4. Set `FRONTEND_URL` to your Netlify site URL for CORS.
5. Deploy — Docker runs migrations and seeds categories on boot.

## Next.js integration

In Netlify, set:

```
API_URL=https://your-backend.up.railway.app
```

Fetch layout from `${API_URL}/api/layout/homepage` and hub pages from `/api/layout/hubs/{slug}`.

## Editorial categories (seeded)

Politics, Economy, Foreign Affairs, Society, Technology, Diaspora, Opinion, Analysis
