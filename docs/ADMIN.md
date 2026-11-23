# FMB website – admin panel

The whole website (projects, homepage banners, pages, menus, contact details, SEO, testimonials, FAQs)
is managed at **/admin**. Changes appear on the website as soon as you save.

## First-time setup (local or live server)

```bash
php artisan migrate --force        # create the database tables
php artisan db:seed --force        # import the current website content (safe to run again)
php artisan admin:create           # create your admin login (asks for email and password)
```

Then make sure the web server can write to `public/uploads/` (all uploaded images and PDFs are stored there).

`.env` on the live server should contain at least:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://fmbgroupbd.com
DB_DATABASE=…  DB_USERNAME=…  DB_PASSWORD=…
CACHE_STORE=file
MAIL_MAILER=smtp   (plus MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD) – needed to email enquiries
```

Forgot the password? Run `php artisan admin:create --email=you@example.com` again to set a new one.

## What is where

| Admin menu | Controls on the website |
|---|---|
| Dashboard | Overview: projects, new enquiries, recent changes |
| Enquiries | Contact, site-visit and landowner forms (also emailed). Export to CSV. |
| Projects | Project list, project pages, featured projects (★) on the homepage. Each project has gallery, floor plans, unit types & prices, amenities, “at a glance” facts, video, brochure, map and SEO. Deleted projects go to Trash first. |
| Home banners | The homepage slider |
| Homepage & settings | “Who we are” text and photo, call-to-action, section on/off switches, phone numbers, WhatsApp, emails, address, office hours, social links, default SEO and sharing image, footer text |
| Pages | About Us, the text above the contact form, and any new page (published at /page/your-slug) |
| Testimonials / FAQs | Shown on the homepage, project pages, Real Estate, Landowners and Garments services pages – hidden while empty |
| Menus | Header menu (with sub-menus) and footer quick links |
| Media library | Every uploaded file; upload images to use inside page text |

Every text field has an optional **(বাংলা)** version. If it is left empty, the English text is shown to Bangla visitors.

## For developers

- Run the tests with `php vendor/bin/pest` (uses the `fmbgroup_test` database, see `phpunit.xml`).
- Public content is cached; every admin save clears the cache automatically (`App\Support\SiteCache`).
- Uploaded files are deleted only when no record uses them any more (`App\Support\Uploads`).
- Rich-text fields are sanitised on save (`App\Support\Html`).
- The garments collection pages (`/collection/*`, `/garments/services`, `/our-management`) are still Blade templates.
