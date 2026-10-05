---
last_mapped_commit: 9ee3c4fa3ef39d47742ee0b7615dfffb996c4cf5
last_mapped_at: 2026-10-06
---
# External Integrations

**Analysis Date:** 2026-10-06

## Database Systems

**Primary Relational Database:**
- Engine: MySQL / MariaDB
- Connection: PDO via Laravel Eloquent ORM
- Configuration: Host `127.0.0.1:3306`, Database `shuvo`, User `root`
- Migrations: 27 schema migrations managing users, categories, products, sliders, vouchers, orders, order items, reviews, and settings

## Authentication & Authorization

**Authentication Mechanism:**
- Laravel Breeze session-based stateful cookie authentication
- Guard: `web` guard using `App\Models\User` with Eloquent user provider
- Passwords hashed via Bcrypt (cost factor 12)

**Authorization & Roles:**
- Role differentiation via boolean column `is_admin` in `users` table
- Route middleware: `auth`, `verified`, and custom `admin` middleware protecting the `/admin/*` route group

## Session & State Management

**Session Storage:**
- Driver: `file` driver (`SESSION_DRIVER=file`)
- Storage Path: `storage/framework/sessions`
- Session Lifetime: 120 minutes with standard CSRF protection on all mutating POST/PUT/PATCH/DELETE requests

**Caching:**
- Driver: `file` cache (`CACHE_STORE=file`)
- Storage Path: `storage/framework/cache/data`

## File Storage & Media Handling

**Storage Drivers:**
- Local filesystem storage (`FILESYSTEM_DISK=local`)
- Public file storage linked to `public/storage` via `php artisan storage:link`
- Direct upload directory for product/category/slider images in `public/uploads/` and `storage/app/public/`
- Image deletion handled through admin controllers (`ProductController::destroyImage`, etc.)

## Messaging & Communication

**Mail Service:**
- Mailer Driver: `log` (`MAIL_MAILER=log`)
- Outgoing emails logged to `storage/logs/laravel.log` during local development
- Ready for SMTP integration (e.g. Mailtrap, SendGrid, Gmail SMTP)

**Customer Communication:**
- Direct WhatsApp Ordering: Integration via `whatsapp_number` configured per product/setting, allowing customers to initiate direct order discussions on WhatsApp

## Payment & Checkout Integrations

**Payment Options:**
- Cash on Delivery (COD): Standard order placement without third-party gateway friction
- Guest Checkout: Supported without mandatory prior registration
- Voucher / Coupon System: Percentage and fixed amount discounts evaluated server-side during checkout via `Voucher` model

---

*Integrations analysis: 2026-10-06*
*Update when external services or APIs change*
