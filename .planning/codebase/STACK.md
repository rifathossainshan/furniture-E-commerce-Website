---
last_mapped_commit: 9ee3c4fa3ef39d47742ee0b7615dfffb996c4cf5
last_mapped_at: 2026-10-06
---
# Technology Stack

**Analysis Date:** 2026-10-06

## Languages

**Primary:**
- PHP ^8.2 - All backend application logic, routing, models, controllers, and database migrations
- Blade Template Engine - View layer with embedded HTML and directives
- JavaScript (ES Modules) - Client-side reactivity, Alpine.js interactions, and AJAX calls

**Secondary:**
- CSS - Styling via Tailwind CSS utility classes and custom stylesheets
- SQL - MySQL / MariaDB relational database queries via Eloquent ORM

## Runtime

**Environment:**
- PHP ^8.2 (Tested on PHP 8.2+ CLI / Web server)
- Node.js (for asset compilation via Vite)
- Relational Database Engine: MySQL / MariaDB (e.g. via XAMPP)

**Package Manager:**
- Composer 2.x - PHP dependency management (`composer.lock` present)
- npm - Node package management (`package-lock.json` present)

## Frameworks

**Core:**
- Laravel Framework 11.x (`11.54.0`) - Full-stack MVC framework powering backend APIs, web routes, authentication, and database migrations
- Tailwind CSS 3.x / 4.x - Utility-first styling framework
- Alpine.js 3.x - Lightweight reactive JavaScript framework for UI dropdowns, modals, and dynamic toggles

**Testing:**
- PHPUnit 10.5 / 11.0 - Automated backend feature and unit testing
- Mockery 1.6 - Object mocking for tests

**Build/Dev:**
- Vite 8.x - Modern frontend build tool and module bundler
- `laravel-vite-plugin` 3.x - Official Laravel Vite integration plugin
- PostCSS 8.x & Autoprefixer 10.x - CSS post-processing pipeline
- Laravel Breeze 2.0 - Lightweight authentication scaffolding
- Laravel Pint 1.13 - PHP code style fixer

## Key Dependencies

**Critical:**
- `laravel/framework` (^11.0) - Core Laravel application architecture and Eloquent ORM
- `doctrine/dbal` (^3.0|^4.0) - Database schema introspection and migration column modifications
- `laravel/breeze` (^2.0) - Session-based user authentication and dashboard scaffolding
- `laravel/tinker` (^2.9) - REPL interactive shell for Laravel debugging

**Frontend Utilities:**
- `alpinejs` (^3.4.2) - Client-side state handling without heavy SPA overhead
- `axios` (^1.11.0) - HTTP client for API requests and asynchronous cart/review actions
- `@tailwindcss/forms` (^0.5.2) - Form control resets and styling

## Configuration

**Environment:**
- Managed via root `.env` file (copied from `.env.example`)
- Key parameters: `APP_NAME`, `APP_KEY`, `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Production fallback config files in `config/` directory (`app.php`, `database.php`, `session.php`, `auth.php`, etc.)

**Build:**
- `vite.config.js` - Vite bundling configuration for CSS and JS assets
- `tailwind.config.js` - Tailwind content paths and theme extension
- `postcss.config.js` - PostCSS plugins registration

## Platform Requirements

**Development:**
- Windows / Linux / macOS with PHP 8.2+, Composer, Node.js, and MySQL / MariaDB (e.g. XAMPP)
- Development server launched via `php artisan serve` and `npm run dev`

**Production:**
- Standard LEMP/LAMP stack (Nginx/Apache + PHP-FPM + MySQL) or Shared Hosting with public root pointing to `public/`
- Production assets built via `npm run build`

---

*Stack analysis: 2026-10-06*
*Update after major dependency changes*
