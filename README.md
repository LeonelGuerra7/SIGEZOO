# SIGEZOO

Sistema Integral de Gestión del Zoológico "Mirada Salvaje". Laravel + MySQL.

## Requisitos

- PHP 8.2+ (probado con 8.3 y 8.4), Composer
- MySQL (Laragon recomendado)
- Node.js + npm

## Instalación

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Crear la base de datos (por defecto usa Laragon con root sin contraseña):

```bash
mysql -u root -e "CREATE DATABASE sigezoo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Revisa `.env` y ajusta `DB_*` si tu MySQL usa otro usuario/contraseña.

```bash
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

> Si `composer install` falla por advisories de seguridad en `laravel/framework`
> (dependencia bloqueada por PHP < 8.4), corre una sola vez:
> `composer config --global policy.advisories.block false`

## Usuarios de prueba (creados por el seeder)

| Rol           | Email                   | Password |
|---------------|--------------------------|----------|
| administrador | admin@sigezoo.test       | password |
| operativo     | operativo@sigezoo.test   | password |
| visitante     | visitante@sigezoo.test   | password |

## Roles y autenticación

- Autenticación con Laravel Breeze (login, registro, recuperación de contraseña).
- Los roles viven en la tabla `roles` (`id_rol`, `rol_nombre`, `rol_descripcion`);
  cada usuario tiene un `id_rol` (FK) en `users`.
- El registro público siempre asigna el rol `visitante`.
- Los roles `administrador` y `operativo` se asignan manualmente (BD o seeder).
- Middleware `role` disponible para proteger rutas por rol, ej:

```php
Route::middleware(['auth', 'role:administrador,operativo'])->group(function () {
    // rutas de los módulos internos (limpieza, alimentación, control clínico)
});
```

`$user->role` (relación), `$user->hasRole('operativo')`, `$user->isAdministrador()`,
`$user->isOperativo()`, `$user->isVisitante()` están disponibles en el modelo `User`.

## Estructura de módulos

- `app/Http/Controllers/{Limpieza,Alimentacion,ControlClinico,Entradas}` — un controlador por módulo.
- `resources/views/{limpieza,alimentacion,control-clinico,entradas}` — vistas por módulo.
- `database/migrations` y `database/seeders` — esquema físico de BD (Rol 3: modelo hábitat/animal).
