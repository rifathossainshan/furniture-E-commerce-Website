---
last_mapped_commit: 9ee3c4fa3ef39d47742ee0b7615dfffb996c4cf5
last_mapped_at: 2026-10-06
---
# Coding Conventions

**Analysis Date:** 2026-10-06

## Architecture & Code Style

**PHP Standards:**
- Code strictly follows PSR-12 coding standard and modern PHP 8.2 features (typed properties, return types, match expressions).
- Formatting managed and audited via Laravel Pint (`./vendor/bin/pint`).

**Class & Method Conventions:**
- Controllers use Resourceful actions (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) whenever handling entity lifecycles.
- Single responsibility principles: controllers handle request orchestration; Eloquent models encapsulate relationships and attributes.

## Naming Standards

**Backend (PHP):**
- Classes, Traits, Interfaces: `PascalCase` (e.g., `ProductController`, `DatabaseSeeder`)
- Methods and Functions: `camelCase` (e.g., `applyVoucher`, `destroyImage`, `store`)
- Variables and Model Attributes: `snake_case` (e.g., `$category_id`, `$order_items`, `$is_admin`)
- Database Columns: `snake_case` (e.g., `delivery_charge`, `selected_attributes`, `button_type`)

**Frontend (Blade, CSS, JS):**
- Blade templates: `kebab-case.blade.php` (e.g., `product.blade.php`, `about.blade.php`)
- CSS Styling: Tailwind CSS utility classes directly within Blade template elements.
- JavaScript variables: `camelCase` (e.g., `cartTotal`, `selectedAttributes`).

## Request Validation Patterns

**Form Validation:**
- Server-side validation executed in Controller methods using `$request->validate([...])`:
  ```php
  $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'category_id' => 'required|exists:categories,id',
      'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
  ]);
  ```
- Validation failures automatically redirect back to previous page with `$errors` bag and old input values.

## Database & Model Practices

**Eloquent ORM:**
- Mass assignment guarded using `$fillable` or `$guarded = []`.
- Relationships explicitly defined with return types:
  ```php
  public function category(): BelongsTo
  {
      return $this->belongsTo(Category::class);
  }
  ```
- Attribute casting specified via `protected function casts(): array` or `$casts` property (e.g., for JSON arrays, booleans, and decimals).

## Frontend & View Patterns

**Blade & Tailwind:**
- Component-driven layout inheritance using `@extends('layouts.app')` or custom component tags.
- Alpine.js `x-data`, `x-show`, and `@click` for local interactivity without heavyweight external state libraries.
- Responsive breakpoints leveraging Tailwind's `sm:`, `md:`, `lg:`, `xl:` prefixes.

---

*Conventions analysis: 2026-10-06*
*Update when coding standards change*
