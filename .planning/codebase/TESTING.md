---
last_mapped_commit: 9ee3c4fa3ef39d47742ee0b7615dfffb996c4cf5
last_mapped_at: 2026-10-06
---
# Testing Strategy & Patterns

**Analysis Date:** 2026-10-06

## Test Frameworks & Tooling

**Core Test Runner:**
- PHPUnit 10.5+ / 11.0+ (`phpunit/phpunit`)
- Laravel Test Runner wrapper: `php artisan test`
- Configuration file: `phpunit.xml`

**Mocking & Assertions:**
- Mockery 1.6 (`mockery/mockery`)
- Laravel built-in HTTP and model testing assertions (`$response->assertStatus(200)`, `$this->assertDatabaseHas(...)`)

## Test Organization & Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   └── RegistrationTest.php
│   ├── ExampleTest.php
│   └── ProfileTest.php
├── Unit/
│   └── ExampleTest.php
├── CreatesApplication.php
└── TestCase.php
```

## How to Execute Tests

**Run full test suite:**

```bash
php artisan test
```

**Run a single test class:**

```bash
php artisan test tests/Feature/ProfileTest.php
```

**Run with PHPUnit directly:**

```bash
./vendor/bin/phpunit
```

## Database Environment in Tests

**Test Database:**
- Environment variables configured in `phpunit.xml`:
  - `APP_ENV=testing`
  - In-memory SQLite or dedicated MySQL test database
- Use `RefreshDatabase` trait in test classes to reset database schema between runs.

## Current Test Coverage & Gaps

**Existing Coverage:**
- Standard Breeze authentication tests (registration, login, password resets, email verification)
- Profile management and deletion tests

**Identified Testing Gaps:**
- Cart operations (`CartController` session lifecycle)
- Checkout and Order placement logic (`CheckoutController`)
- Voucher discount calculation and validation rules (`VoucherController`, `CheckoutController`)
- Product multi-image upload and attribute management
- Admin permission restrictions and access control checks

---

*Testing analysis: 2026-10-06*
*Update when test tooling or test suites change*
