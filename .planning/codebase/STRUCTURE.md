---
last_mapped_commit: 7ce86622ef827d2759fb97a431d4b0edfe1bb2e7
last_mapped_at: 2026-10-06
---
# Directory Structure

**Analysis Date:** 2026-10-06

## Directory Layout

```
Antu -E-commerce/
├── app/                        # Application core business logic
│   ├── Http/
│   │   ├── Controllers/        # Route controllers
│   │   │   ├── Admin/          # Admin back-office controllers
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── SettingController.php
│   │   │   │   ├── SliderController.php
│   │   │   │   └── VoucherController.php
│   │   │   ├── Auth/           # Breeze authentication controllers
│   │   │   ├── AdminReviewController.php
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── ShopController.php
│   │   │   ├── UserController.php
│   │   │   └── WishlistController.php
│   │   └── Middleware/         # Custom & framework request filters
│   └── Models/                 # Eloquent ORM Active Record entities
│       ├── Category.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Product.php
│       ├── ProductAttribute.php
│       ├── Review.php
│       ├── ReviewImage.php
│       ├── Setting.php
│       ├── Slider.php
│       ├── User.php
│       └── Voucher.php
├── bootstrap/                  # Framework initialization and app configuration
│   └── app.php                 # Middleware, routing, and exception binding
├── config/                     # Application configuration files
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── session.php
├── database/                   # Migrations, seeders, and factories
│   ├── factories/              # Model test factories
│   ├── migrations/             # 27 database schema migration definitions
│   └── seeders/                # Database seed scripts (`DatabaseSeeder.php`)
├── public/                     # Web root directory served by HTTP server
│   ├── build/                  # Compiled Vite assets (CSS/JS)
│   ├── uploads/                # Direct file upload storage
│   ├── index.php               # Main web entry point
│   ├── robots.txt
│   └── storage                 # Symlink to storage/app/public
├── resources/                  # Uncompiled assets and presentation views
│   ├── css/                    # Tailwind CSS source files (`app.css`)
│   ├── js/                     # JavaScript sources (`app.js`, `bootstrap.js`)
│   └── views/                  # Blade templates
│       ├── admin/              # Admin CRUD and dashboard templates
│       ├── auth/               # Login, registration, password reset views
│       ├── components/         # Reusable Blade UI components
│       ├── layouts/            # Master layout wrappers
│       ├── profile/            # Customer profile views
│       ├── about.blade.php
│       ├── cart.blade.php
│       ├── checkout.blade.php
│       ├── dashboard.blade.php
│       ├── home.blade.php
│       ├── product.blade.php
│       ├── shop.blade.php
│       ├── welcome.blade.php
│       └── wishlist.blade.php
├── routes/                     # Application route definitions
│   ├── auth.php                # Authentication routes
│   ├── console.php             # Artisan console command routes
│   └── web.php                 # Public, customer, and admin web routes
├── storage/                    # Logs, file cache, and uploaded files
│   ├── app/public/             # Publicly accessible file storage
│   ├── framework/              # Sessions, cache, views cache
│   └── logs/                   # Application log files (`laravel.log`)
├── tests/                      # Automated test suite
│   ├── Feature/                # Feature integration tests
│   └── Unit/                   # Unit tests
├── .env                        # Local environment configuration
├── artisan                     # Artisan CLI runner
├── composer.json               # PHP dependencies and autoloading
├── package.json                # Node/NPM dependencies and build scripts
├── tailwind.config.js          # Tailwind CSS theme configuration
└── vite.config.js              # Vite asset bundler configuration
```

## Key Locations

| File / Folder | Responsibility |
| :--- | :--- |
| `routes/web.php` | Defines all public shop routes, guest checkout, and admin route prefix group |
| `app/Http/Controllers/` | Storefront operations (Cart, Wishlist, Checkout, Catalog) |
| `app/Http/Controllers/Admin/` | Back-office CRUD controllers |
| `app/Models/` | Eloquent models defining data attributes and relationships |
| `database/migrations/` | Database schema migrations |
| `resources/views/` | Blade template views and components |
| `public/uploads/` | Product and category images |
| `.env` | Environment variables (Database credentials, App configuration) |

## Naming Conventions

- **Controllers:** PascalCase with `Controller` suffix (e.g., `ProductController.php`)
- **Models:** Singular PascalCase matching table singular form (e.g., `Product.php`, `Order.php`)
- **Database Tables:** Plural snake_case (e.g., `products`, `order_items`, `product_attributes`)
- **Migrations:** Timestamps followed by snake_case action (e.g., `2026_03_23_143812_create_products_table.php`)
- **Blade Views:** kebab-case or snake_case with `.blade.php` extension (e.g., `checkout.blade.php`, `about.blade.php`)
- **Routes:** kebab-case named routes with dot notation grouping (e.g., `admin.products.index`, `cart.add`)

---

*Structure analysis: 2026-10-06*
*Update after directory reorganizations*
