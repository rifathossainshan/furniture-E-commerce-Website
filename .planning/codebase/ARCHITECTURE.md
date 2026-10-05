---
last_mapped_commit: 7ce86622ef827d2759fb97a431d4b0edfe1bb2e7
last_mapped_at: 2026-10-06
---
# Architecture

**Analysis Date:** 2026-10-06

## Pattern Overview

**Overall:** Full-stack MVC (Model-View-Controller) E-Commerce Web Application

**Key Characteristics:**
- Monolithic server-side rendered application with Laravel 11
- Relational data model managed via Eloquent Active Record
- Dynamic frontend enhancements using Alpine.js and Tailwind CSS
- Two distinct application contexts: Public Customer Storefront and Administrative Control Panel

## Layers

**Routing Layer:**
- Purpose: Map incoming HTTP requests to corresponding controller actions and apply middleware pipelines
- Contains: `routes/web.php` (Public, customer, checkout, and admin routes), `routes/auth.php` (Authentication endpoints)
- Depends on: Middleware (`auth`, `admin`, `web`) and Controllers
- Used by: HTTP kernel entry point

**Controller Layer (Application Logic):**
- Purpose: Handle request validation, coordinate business logic, invoke models, and return Blade views or redirects
- Storefront Controllers:
  - `HomeController` - Homepage banner sliders, featured collections, and new arrivals
  - `ShopController` - Catalog browsing, category filtering, search, and product details
  - `CartController` - Session-based cart additions, quantity updates, and removals
  - `WishlistController` - Wishlist item management
  - `CheckoutController` - Guest/user checkout, voucher discount application, order placement
  - `ReviewController` - Customer product ratings, reviews, and image uploads
  - `UserController` - Customer dashboard and order invoice retrieval
- Admin Controllers (`app/Http/Controllers/Admin/`):
  - `DashboardController` - Overview statistics and admin credentials management
  - `CategoryController` - Category creation, hierarchy, styles, and asset management
  - `ProductController` - Product CRUD, multi-image uploads, attributes, and stock
  - `OrderController` - Order lifecycle tracking, status transitions, and customer details
  - `SliderController` - Homepage banner slider management
  - `VoucherController` - Discount code configuration
  - `SettingController` - Global store settings (branding, contact details, announcement bar)
  - `AdminReviewController` - Review moderation (approve, reject, reply, delete)

**Model & Data Layer:**
- Purpose: Encapsulate database tables, relationships, accessors, and business rules
- Key Models:
  - `User` - Authentication, customer details, and admin flag (`is_admin`)
  - `Product` - Catalog entries, prices, attributes, stock, category relation, and images
  - `Category` - Classification groupings and custom styling options
  - `Order` & `OrderItem` - Transaction records, snapshot of purchased items, pricing, and shipping
  - `Voucher` - Coupon rules, percentage/fixed calculations, and expiration
  - `Review` & `ReviewImage` - Customer feedback, ratings, and media
  - `Slider` - Marketing banners and call-to-action buttons
  - `Setting` - Key-value pair configuration store

**View & Presentation Layer:**
- Purpose: Render user interfaces to the browser
- Contains:
  - Layouts: `resources/views/layouts/` (Storefront master layout, guest layout, admin layout)
  - Storefront Views: `resources/views/home.blade.php`, `shop.blade.php`, `product.blade.php`, `cart.blade.php`, `checkout.blade.php`, `wishlist.blade.php`, `about.blade.php`
  - Admin Views: `resources/views/admin/` (CRUD views for products, orders, categories, sliders, settings, reviews)

## Data Flow

**1. Customer Storefront Browsing:**
`Browser Request` ➔ `routes/web.php` ➔ `ShopController::index` ➔ `Product::where('status', true)->get()` ➔ `resources/views/shop.blade.php` ➔ `HTML Response`

**2. Order Placement Flow:**
1. Customer adds items to cart (`CartController::add`) stored in session
2. Customer navigates to `/checkout` (`CheckoutController::index`)
3. Optional voucher applied via AJAX/POST (`CheckoutController::applyVoucher`)
4. Customer submits details (`CheckoutController::store`)
5. Transaction created in `orders` and `order_items` tables
6. Session cart cleared and invoice generated (`UserController::invoice`)

**3. Administrative Management Flow:**
1. Administrator accesses `/admin/*` protected by `auth` and `admin` middleware
2. Request routed to Admin Controller (e.g., `ProductController::store`)
3. Request validated; files uploaded to `public/uploads` or storage disk
4. Model created/updated; redirected back with session flash status message

## Entry Points

**Web HTTP Entry Point:**
- Location: `public/index.php`
- Triggers: All inbound web server HTTP requests
- Responsibilities: Bootstraps Composer autoloader, initializes Laravel application container, handles HTTP request through kernel

**Console CLI Entry Point:**
- Location: `artisan`
- Triggers: Terminal commands (e.g. `php artisan serve`, `php artisan migrate`)
- Responsibilities: Loads Artisan console kernel, registers custom and vendor console commands

## Error Handling & Cross-Cutting Concerns

**Error Handling:**
- Global exception handling configured in `bootstrap/app.php`
- HTTP validation exceptions automatically redirect back with error bag and input repopulation

**Security & Protection:**
- CSRF token verification middleware on all web form submissions
- Session fixation protection and password bcrypt hashing
- SQL injection prevention via PDO prepared statements within Eloquent ORM

---

*Architecture analysis: 2026-10-06*
*Update when major patterns change*
