# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Brazilian Instagram growth service platform built with Laravel 12, Vue 3, and Filament 5. Users link Instagram profiles, purchase service packages (followers, likes, etc.), and pay via PIX. Background jobs handle Instagram syncing and order fulfillment through external providers.

## Common Commands

```bash
# Initial setup
composer run setup

# Development (runs Laravel serve, Vite dev, queue worker, and logs concurrently)
composer run dev

# Run tests (Pest)
composer run test

# Run a single test file
./vendor/bin/pest tests/Feature/ExampleTest.php

# Run a single test by name
./vendor/bin/pest --filter="test name here"

# Frontend build
npm run build

# Frontend dev server only
npm run dev
```

## Architecture

### Backend (Laravel 12, PHP 8.2+)

- **Models** (`app/Models/`): User, Order, Package, InstagramProfile, InstagramPost, Provider, Service, ProviderOrder, UserCreditBalance, PaymentGateway, BlogPost
- **Services** (`app/Services/`):
  - `InstagramSyncService` — syncs Instagram profile data and posts via HikerAPI
  - `HikerApiClient` — HTTP client for HikerAPI v2 (Instagram scraping)
  - `ExpayService` — PIX payment gateway integration (Brazilian payments)
  - `ProviderService` — manages external social media service providers
  - `UserCreditService` — user credit balance management
  - `PerfectPanelClient` — HTTP client for PerfectPanel provider API
- **Jobs** (`app/Jobs/`): `SyncInstagramProfileJob`, `SendOrderToProviderJob`, `UpdateProviderOrderStatusJob`
- **Enums** (`app/Enums/`): `OrderStatus`, `ProviderOrderStatus`, `PaymentGatewayType`
- **Helpers** (`app/Helpers/`): `helpers.php` (auto-loaded), `ImageHelper.php`
- **Admin Panel**: Filament 5 at `/admin`, restricted to users with `is_admin` flag

### Frontend (Vue 3 + TypeScript + Inertia.js)

- **Rendering**: Hybrid approach — public pages use Blade, authenticated pages use Inertia/Vue
- **Entry points**: `resources/js/app.ts` (Inertia), `resources/js/app.js` (legacy)
- **Pages** (`resources/js/Pages/`): Dashboard, Auth views, Profile
- **Layouts** (`resources/js/Layouts/`): AuthenticatedLayout, GuestLayout
- **Styling**: Tailwind CSS 4.1
- **Routing in JS**: Ziggy provides Laravel route() helper in Vue components

### Routes

- **Public** (`routes/web.php`): `/`, `/pacotes`, `/checkout/*`, `/instagram/lookup`, `/blog/*`
- **Auth** (`routes/auth.php`): Standard Laravel Breeze auth routes
- **Protected** (auth + verified middleware): `/dashboard`, `/profile`
- **Webhook**: `/api/webhooks/expay` (CSRF-exempt)

### Database

- MySQL in development, in-memory SQLite for tests
- Queue, cache, and sessions use database driver
- Key relationships: User → InstagramProfiles → InstagramPosts; Order → Package, User, InstagramProfile → ProviderOrders

### Testing

- **Framework**: Pest 4.3
- **Config**: `phpunit.xml` — SQLite in-memory database
- Tests in `tests/Feature/` use `RefreshDatabase` trait
