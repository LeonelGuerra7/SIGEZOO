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

### Sprint 2
Wireframes de las pantallas principales

Como parte de la fase de diseño de interfaz, se elaboraron wireframes de baja fidelidad para las pantallas principales del sistema. El objetivo de estos bocetos es representar la estructura y organización de cada pantalla antes de su implementación, sin definir aún el estilo visual final (colores, tipografía, imágenes), de modo que el equipo pueda validar la disposición de los elementos y el flujo de navegación.

Se definieron las siguientes pantallas:

Login: acceso al sistema mediante correo y contraseña, punto de entrada común para los tres tipos de usuario (administrador, operativo, visitante).
Portal público (Entradas y promociones): vista de bienvenida para visitantes, con un banner principal y tarjetas de promociones o información destacada.
Limpieza: listado de tareas de limpieza por área, con filtros y acciones de edición.
Alimentación: listado de horarios y dietas, con indicador de alerta cuando el inventario de un alimento está bajo.
Control clínico — Medicamentos, vacunas y vitaminas: listado con búsqueda y filtro por tipo, acciones de crear, editar y eliminar, e indicador visual cuando el stock está por debajo del mínimo.
Control clínico — Procedimientos por animal: listado de procedimientos aplicados junto a un formulario para registrar uno nuevo, con selección de animal, medicamento y fechas de aplicación y próxima dosis.
Dashboard con alertas: panel de resumen con avisos de vacunas próximas a vencer y un reporte del estado clínico de los animales.

Cada pantalla mantiene una estructura común (barra de navegación superior, área de contenido y acciones visibles), lo que facilita que el usuario reconozca el mismo patrón de uso en los distintos módulos del sistema.

---

## Pendiente

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
