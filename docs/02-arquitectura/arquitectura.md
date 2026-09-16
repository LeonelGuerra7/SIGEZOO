# Arquitectura del sistema — SIGEZOO

**Rol 2 — Arquitecto de Software**

## 1. Elección y justificación del stack tecnológico

| Componente | Elección | Justificación |
|---|---|---|
| Sistema operativo (desarrollo) | Windows + Laragon | Entorno que ya usa el equipo; Laragon integra Apache, MySQL y PHP sin configuración manual, lo que agiliza el desarrollo del prototipo. |
| Sistema operativo (producción recomendado) | Linux (Ubuntu Server) | Es el estándar de facto para hosting de aplicaciones PHP/MySQL: menor costo de licenciamiento, mejor soporte de la comunidad Laravel y mayor estabilidad para procesos de larga duración. |
| Servidor web | Apache HTTP Server | Incluido en Laragon, config por `.htaccess` ya soportada por Laravel out-of-the-box (`public/.htaccess`), y es el servidor con el que el equipo tiene más experiencia. |
| Servidor de aplicaciones | PHP 8.3 (mod_php en desarrollo) | Motor de ejecución de Laravel. En un despliegue de producción se recomienda migrar a **PHP-FPM** detrás de Nginx o Apache, ya que maneja mejor la concurrencia de múltiples usuarios que mod_php. |
| Base de datos | MySQL 8.4 | Motor relacional, gratuito, con amplio soporte y documentación. El dominio del problema (hábitat → animal → limpieza/alimentación/clínico) tiene relaciones claras y consultas cruzadas (reportes), lo que encaja naturalmente con un modelo relacional normalizado en 3FN. Además Laravel (Eloquent ORM) tiene soporte de primera clase para MySQL. |
| Framework | Laravel 11 (PHP) | Provee routing, ORM, autenticación, validación y protección CSRF integradas, reduciendo el código de infraestructura que el equipo tendría que escribir a mano para cumplir el requisito de "aspectos básicos de seguridad" del enunciado. |

## 2. Estilo arquitectónico

**Monolito en capas (MVC), con separación de módulos por dominio.**

Se descartó una arquitectura de microservicios porque:
- El equipo es de 5 personas con un plazo corto (entrega 26/09/2026); microservicios añadirían complejidad de despliegue (orquestación, comunicación entre servicios) que no aporta valor a un prototipo académico.
- El sistema es de uso interno de un solo zoológico, sin necesidad de escalar módulos de forma independiente.

Dentro del monolito, el código se organiza en capas:

```
Petición HTTP
   │
   ▼
Rutas (routes/web.php)
   │
   ▼
Middleware (auth, role:administrador,operativo, verified)
   │
   ▼
Controladores (app/Http/Controllers/{Limpieza,Alimentacion,ControlClinico,Entradas,Auth})
   │
   ▼
Modelos / Eloquent ORM (app/Models)
   │
   ▼
Base de datos MySQL (tablas: roles, users, animales, areas, dietas,
alimentos, medicamentos, tareas_limpieza, procedimientos_clinicos,
registros_alimentacion, entradas, promociones, tipos_entrada, proveedores)
```

Cada módulo funcional (Limpieza, Alimentación, Control Clínico, Entradas) vive en su propia carpeta de controladores y vistas, lo que permite que cada integrante del equipo trabaje su módulo sin pisar el código de los demás, aunque todos corran sobre la misma aplicación Laravel.

## 3. Diagrama general de arquitectura

Ver diagrama adjunto (`arquitectura-diagrama.svg` / imagen entregada aparte). Componentes:

- **Cliente (navegador):** consume la interfaz Blade renderizada por el servidor. Sin SPA/API separada — server-side rendering clásico de Laravel.
- **Servidor web (Apache):** recibe las peticiones HTTP y las enruta al front controller de Laravel (`public/index.php`).
- **Aplicación Laravel (PHP):**
  - *Middleware de autenticación y roles*: primer filtro de seguridad antes de llegar a cualquier controlador de módulo.
  - *Controladores por módulo*: lógica de negocio de cada área (limpieza, alimentación, control clínico, entradas).
  - *Eloquent ORM*: capa de acceso a datos, traduce modelos PHP a consultas SQL.
- **Base de datos MySQL:** persistencia de todas las entidades del sistema, con el hábitat/animal como eje central del modelo (según el modelo entidad-relación del Rol 3).

## 4. Por qué se eligió esta arquitectura

- **Simplicidad sobre el requisito real:** el enunciado pide "un sistema simple y funcional" con conexión a BD, seguridad básica y reportes — un monolito en capas cubre esto sin sobre-ingeniería.
- **Curva de aprendizaje del equipo:** Laravel resuelve routing, autenticación, ORM y protección CSRF de fábrica, dejando que el equipo se enfoque en la lógica de negocio de cada módulo en vez de reconstruir infraestructura.
- **Desarrollo distribuido sin bloqueos:** al separar los módulos por carpetas de controladores/vistas y dejar el entorno base (conexión a BD, autenticación, roles) montado desde el inicio, cada integrante pudo empezar su CRUD sin esperar a que otro terminara el suyo.
- **Costo y despliegue:** PHP + MySQL + Apache es una de las combinaciones de hosting más económicas y ampliamente disponibles, adecuada para un prototipo académico que eventualmente podría desplegarse en un hosting compartido o una VPS pequeña.

## 5. Consideraciones de seguridad básica

- **Autenticación:** Laravel Breeze (login, registro, recuperación de contraseña) usando sesiones de servidor y contraseñas con hash `bcrypt` (nunca en texto plano).
- **Control de roles:** tabla `roles` (`administrador`, `operativo`, `visitante`) relacionada a `users` vía `id_rol`. Middleware `role:administrador,operativo` protege las rutas de los módulos internos; un visitante autenticado no puede acceder a limpieza, alimentación ni control clínico.
- **Prevención de escalación de privilegios:** el formulario de registro público **siempre** asigna el rol `visitante` en el servidor — el rol nunca se toma de un campo del formulario ni de un parámetro de la petición.
- **CSRF:** todos los formularios usan el token CSRF integrado de Laravel (`@csrf`).
- **Validación de entradas:** cada `Request` de Laravel valida tipo, longitud y formato antes de tocar la base de datos (p. ej. `Rules\Password::defaults()` en el registro).
- **Secretos fuera del control de versiones:** credenciales de BD y `APP_KEY` viven únicamente en `.env`, excluido en `.gitignore`; el repositorio solo versiona `.env.example` sin valores sensibles.
- **Autorización de acceso HTTP 403:** cualquier intento de acceder a una ruta sin el rol adecuado responde con `403 Forbidden` en vez de exponer contenido o redirigir silenciosamente.
