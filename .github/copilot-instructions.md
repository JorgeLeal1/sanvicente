# San Vicente Project Guidelines

## Code Style

**PHP**: Follow PSR-12 standard. Use type hints, readonly properties, and modern PHP 8.3 features (attributes, match expressions, nullsafe operator).

**Laravel Conventions**:
- **Models**: Place in `app/Models/`, use singular class names. Use Fillable/Hidden attributes instead of properties for flexibility. Example: [app/Models/User.php](app/Models/User.php)
- **Controllers**: Place in `app/Http/Controllers/`, use ResourceController pattern for standard CRUD. Thin controllers—move logic to models or services.
- **Routes**: Define in `routes/web.php` for web routes, `routes/api.php` for APIs. Use route model binding for automatic dependency injection.
- **Migrations**: Use Eloquent schema builder, not raw SQL. Timestamp migrations properly. See [database/migrations/](database/migrations/)
- **Blade Templates**: Use in `resources/views/`. Prefer `@forelse` over `@foreach`, use slots and components for reusable UI.

**Frontend**: Tailwind CSS v4 + Vite with Laravel plugin. Distribute component CSS alongside Blade templates where possible. Use Tailwind utilities instead of custom CSS when feasible.

## Architecture

Standard Laravel structure with clear separation:
- **Routes** (`routes/`) → HTTP entry points
- **Controllers** (`app/Http/Controllers/`) → Request handlers
- **Models** (`app/Models/`) → Database representations + business logic
- **Views** (`resources/views/`) → Blade templates
- **Database** (`database/`) → Migrations, seeders, factories
- **Tests** (`tests/`) → Unit and Feature tests

Database uses SQLite for testing (`:memory:`), configurable for production via `.env`. Queue jobs use sync driver in testing.

## Build and Test

**Setup** (first run):
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

**Development** (multiple services concurrently):
```bash
npm run dev
```
Runs: Laravel server (port 8000), queue listener, log tail (pail), Vite dev server.

**Testing**:
```bash
composer test
```
Runs PHPUnit, clears config cache before each run. Uses in-memory SQLite + array session/cache.

**Code Quality**:
```bash
./vendor/bin/pint          # Format code (Laravel Pint)
composer test              # Run tests
```

**Artisan Commands** (essential):
```bash
php artisan migrate        # Run migrations
php artisan tinker         # Interactive shell
php artisan make:model     # Generate model (with -m for migration, -c for controller)
php artisan make:migration # Generate migration
php artisan make:test      # Generate test (Unit or Feature)
```

## Conventions

1. **Dependencies**: `composer require` for PHP packages, `npm install` for Node. Committed `composer.lock` and `package-lock.json`.

2. **Environment**: See `.env.example`. Key variables: `APP_ENV`, `DB_CONNECTION`, `MAIL_MAILER`, `CACHE_STORE`.

3. **Testing**: 
   - Unit tests in `tests/Unit/` for business logic (models, utilities)
   - Feature tests in `tests/Feature/` for HTTP routes and integration
   - Use factories (Database\\Factories\\UserFactory) for test data. See [database/factories/UserFactory.php](database/factories/UserFactory.php)

4. **Database**: 
   - Migrations are timestamped, run in order
   - Models use `use Illuminate\Database\Eloquent\Factories\HasFactory` for factory integration
   - Use Fillable attributes to list mass-assignable columns for security

5. **Frontend-Backend Bridge**:
   - Vite compiles `resources/css/app.css` and `resources/js/app.js`
   - Blade `@vite()` directive loads compiled assets automatically
   - API responses typically return JSON; use Route::prefix('api') for namespacing

## Common Gotchas

- **Mass Assignment**: Models only accept fields in `Fillable` attribute. Without it, `create()` / `update()` silently ignores fields.
- **Type Hints in Models**: Verify PHP 8.3 property types are declared; Eloquent uses them for casting.
- **Test Database**: Uses in-memory SQLite—no persistence between test runs. Mock external services; keep tests fast.
- **Queue**: Testing environment uses sync driver (executes immediately). Set `QUEUE_CONNECTION=database` or `redis` for production.

## Links

- [Laravel Documentation](https://laravel.com/docs) — official reference
- [Laracasts](https://laracasts.com) — video tutorials on Laravel fundamentals and patterns
- [Tailwind CSS Docs](https://tailwindcss.com/docs) — utility-first CSS framework
