# Módulo de Control Clínico — SIGEZOO (Rol 5)

**Proyecto:** SIGEZOO · Análisis de Sistemas II · Universidad Mariano Gálvez
**Responsable:** Rol 5 (Frontend + QA / Documentación)
**Última actualización:** 21/09/2026
**Entrega final:** 26/09/2026

---

## Stack

Laravel · Blade · Tailwind CSS (Breeze) · Alpine.js · MySQL (XAMPP)

> La guía del proyecto menciona Bootstrap, pero el scaffolding de Breeze y las vistas existentes usan Tailwind. Las vistas de este módulo se escriben con Tailwind y con los componentes de Breeze. La documentación del stack debe actualizarse.

---

## Puesta en marcha local

En la raíz del proyecto:

1. `composer install`
2. `copy .env.example .env` y revisar las variables `DB_` (MySQL de XAMPP)
3. `php artisan key:generate`
4. Crear la base de datos vacía en phpMyAdmin (mismo nombre que `DB_DATABASE`)
5. `git pull origin develop` y luego `php artisan migrate` (o `--seed` si hay seeders)
6. `npm install`
7. `npm run dev` (dejar corriendo)
8. `php artisan serve` (en otra terminal) y abrir `http://localhost:8000`

Notas:
- `http://localhost:5173` es solo el servidor de Vite, no la aplicación.
- Si `composer` o `npm` fallan por extensiones o versiones, revisar `php -m`, `node -v` y `npm -v` (Vite requiere Node 18 o superior).
- Los avisos "Deprecated" de PHP 8.5 en `vendor/` no afectan el funcionamiento.

---

## Hecho

### Modelos (`app/Models/`)
- **`Medicamento`**: tabla `medicamentos`, llave `id_medicamento`. Constante `TIPOS` (medicamento, vacuna, vitamina). Relaciones: `procedimientos()` (hasMany) y `proveedor()` (belongsTo).
- **`ProcedimientoClinico`**: relaciones belongsTo hacia `Animal`, `Medicamento` y `User`. Casts de `fecha_aplicacion` (datetime) y `fecha_proxima` (date).

### CRUD de medicamentos, vacunas y vitaminas (SCRUM-18, parte 1)
Estado: implementado, en pruebas.

| Archivo | Contenido |
|---|---|
| `app/Http/Controllers/ControlClinico/MedicamentoController.php` | `index`, `store`, `update`, `destroy`, validaciones y proveedores |
| `resources/views/control-clinico/medicamentos/index.blade.php` | Listado, filtros, tabla y modal único para crear y editar |
| `routes/web.php` | `Route::resource('medicamentos', ...)` dentro de `control-clinico`, sin `show`, `create` ni `edit` |

Funcionalidades:
- Listado paginado con búsqueda por nombre y filtro por tipo.
- Crear y editar en un mismo modal (Alpine + componente `x-modal` de Breeze). Si falla la validación, el modal se reabre con los datos y los errores.
- Validaciones espejo de la migración (longitudes, tipo permitido, stock no negativo).
- Eliminación bloqueada si el registro tiene procedimientos clínicos asociados, con mensaje de aviso. Segunda capa: la llave foránea de la BD.
- Stock por debajo del mínimo resaltado en rojo.

### Decisiones tomadas
- El modal reemplaza las páginas `create` y `edit` separadas.
- Un medicamento en uso no se puede eliminar.
- Sistema general, sin sobreingeniería, para que todo el equipo pueda extenderlo.

---

## Pendiente

### SCRUM-18 (en curso)
- CRUD de procedimientos clínicos (aplicación por animal)

### Sprint 2
- Wireframes de las pantallas principales

### Sprint 3
- Alerta automática de vacunas próximas a vencer
- Reporte de estado clínico de los animales
- Navegación unificada entre los cuatro módulos
- Pruebas funcionales (resultado esperado vs. obtenido)

### Cierre
- Manual de usuario por tipo de actor
- Manual técnico (confirmar quién lo redacta: Rol 4 o Rol 5)

### Dependencias con otros roles
- Modelo `Animal` (Rol 3)
- Modelo `Proveedor`
- Migración de `procedimientos_clinicos`
- Seeders con datos de prueba (animales, proveedores, usuarios)
- Nombres de rutas y menú con los Roles 1 y 4
- Usuario de prueba con rol administrador u operativo
- Actualizar la documentación del stack (Bootstrap → Tailwind)
