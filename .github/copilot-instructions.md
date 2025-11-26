# Copilot Instructions for Bryanair

## Overview

Bryanair is a Laravel-based flight booking system using the TALL stack (Tailwind CSS, Alpine.js, Livewire, Laravel) with MySQL as the database. The project is structured as a typical Laravel app, with custom Python scripts for data generation and a modern frontend build process.

## Key Components

-   **Backend:** Laravel (see `app/`, `routes/`, `database/`)
-   **Frontend:** Tailwind CSS, Alpine.js, Livewire (see `resources/`, `app/Livewire/`)
-   **Database:** MySQL, migrations in `database/migrations/`, seeders/factories for test data
-   **Python Scripts:** `generaVoli.py`, `generaPosti.py` for generating flight/seat data

## Developer Workflows

-   **Install dependencies:** `npm install` and `composer install`
-   **Database setup:**
    -   Import `database/bryanair.sql` for initial data
    -   Run `php artisan migrate` (after deleting the `users` table if present)
-   **Start servers:**
    -   Backend: `php artisan serve`
    -   Frontend: `npm run dev` (or `npm run build` for production)
-   **Run Python scripts:**
    -   `py generaVoli.py` (generates flights)
    -   `py generaPosti.py` (generates seats)

## Project Conventions & Patterns

-   **Livewire components:** All interactive UI logic is in `app/Livewire/` (e.g., `Flight.php`, `Booking.php`).
-   **Controllers:** HTTP endpoints in `app/Http/Controllers/`.
-   **Models:** Eloquent models in `app/Models/`.
-   **Views:** Blade templates in `resources/views/`.
-   **Routes:**
    -   Web: `routes/web.php`
    -   API: `routes/api.php`
-   **Config:** All configuration in `config/`.
-   **Testing:** Tests in `tests/Feature/` and `tests/Unit/`.

## Integration Points

-   **Frontend/Backend:** Livewire bridges Blade views and PHP logic for reactivity.
-   **External:** Payment and authentication handled via Laravel packages (see `config/services.php`, `config/fortify.php`, `config/jetstream.php`).
-   **Python scripts:** Used for bulk data generation, not part of the main app runtime.

## Special Notes

-   Always run migrations after changing database structure.
-   Use two terminals for backend and frontend during development.
-   For production, use `npm run build` and a proper web server.
-   If you encounter issues with user authentication, check `app/Actions/Fortify/` and `app/Actions/Jetstream/`.

## Example: Adding a New Feature

1. Create a Livewire component in `app/Livewire/`.
2. Add routes in `routes/web.php`.
3. Update or create Blade views in `resources/views/`.
4. If needed, update migrations or models.
5. Test with `php artisan serve` and `npm run dev`.

---

For more details, see `README.md` and the `config/` directory.
