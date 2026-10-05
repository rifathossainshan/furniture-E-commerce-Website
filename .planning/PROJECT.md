# Top 1 Furniture / Royal Creations E-Commerce

## What This Is

A full-stack Laravel e-commerce platform built for online retail (Furniture & Lifestyle products). It features a customer-facing storefront with catalog browsing, shopping cart, wishlist, voucher discounts, direct WhatsApp order routing, and Cash on Delivery (COD) checkout, alongside an administrative control panel for store and catalog management.

## Core Value

Enable customers to seamlessly browse products, place orders online via Cash on Delivery or WhatsApp, while providing administrators with complete control over inventory, orders, reviews, and store settings.

## Business Context

- **Customer:** Online retail shoppers looking for quality furniture, lifestyle goods, and home essentials.
- **Revenue Model:** Direct product sales with Cash on Delivery (COD) and delivery fee calculation.
- **Success Metric:** Smooth order conversion rate, fast page load speeds, and zero order placement drop-offs.

## Architecture & Technology Foundation

- **Backend:** Laravel 11.x on PHP ^8.2 with Eloquent ORM
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js, Vite
- **Database:** MySQL / MariaDB (managed via 27 schema migrations)
- **Authentication:** Laravel Breeze session authentication with role-based admin access (`is_admin`)

## Active Scope & Features

- [x] Product catalog with categories, sub-attributes, and multi-image galleries
- [x] Session-based Shopping Cart & Wishlist
- [x] Cash on Delivery (COD) checkout with guest-checkout support
- [x] Voucher & coupon discount application
- [x] WhatsApp direct order messaging integration
- [x] Customer dashboard & printable order invoice generation
- [x] Customer product reviews with moderation & image attachment
- [x] Admin management dashboard (Products, Categories, Orders, Sliders, Settings, Reviews, Vouchers)

## Key Technical Debt & Security Priorities

- Secure or remove unprotected `/migrate-db` route in `routes/web.php`
- Add automated feature tests for Cart, Checkout, and Voucher logic
- Standardize media uploads and storage symlinks across all controllers
- Configure transactional email service for order receipts
