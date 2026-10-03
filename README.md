# 🦁 SIGEZOO

## Sistema Integral de Gestión del Zoológico “Mirada Salvaje”

**SIGEZOO** es un sistema web desarrollado para centralizar y facilitar la gestión de los principales procesos operativos y administrativos del zoológico **“Mirada Salvaje”**.

El sistema integra módulos de **limieza, alimentación e inventario, control clínico, entradas y promociones**, permitiendo mantener la información organizada y relacionada dentro de una misma plataforma.

> **Proyecto académico — Análisis de Sistemas II**

---

## 📋 Descripción del proyecto

SIGEZOO surge como una solución para sustituir el manejo separado de información dentro del zoológico por una plataforma centralizada.

El sistema permite administrar información relacionada con los **animales y sus hábitats**, así como las actividades de limpieza, alimentación, inventario y control clínico. Además, incorpora funcionalidades orientadas a los visitantes, como la consulta de promociones y la gestión de entradas.

El proyecto fue desarrollado como un **prototipo web funcional**, aplicando análisis de requerimientos, modelado UML, diseño de bases de datos, arquitectura de software, seguridad, desarrollo y pruebas funcionales.

---

## 🎯 Objetivo

Diseñar y desarrollar un sistema web que permita **centralizar la gestión de los principales procesos del zoológico “Mirada Salvaje”**, proporcionando una plataforma organizada, segura y conectada a una base de datos relacional.

---

## ⚙️ Funcionalidades principales

SIGEZOO integra las siguientes funcionalidades:

- 🧹 **Gestión de limpieza**
  - Registro de actividades de limpieza.
  - Control de áreas del zoológico.
  - Seguimiento del cumplimiento de tareas.

- 🍎 **Alimentación e inventario**
  - Administración de dietas.
  - Registro de horarios de alimentación.
  - Control de existencias de alimentos.
  - Descuento de inventario.
  - Alertas por niveles bajos de stock.

- 🩺 **Control clínico**
  - Registro de medicamentos.
  - Control de vacunas.
  - Registro de vitaminas.
  - Historial clínico de los animales.
  - Alertas relacionadas con vacunación.

- 🎟️ **Entradas y promociones**
  - Consulta de horarios.
  - Consulta de promociones.
  - Gestión de entradas.
  - Simulación del proceso de compra.

- 📊 **Reportes y alertas**
  - Reportes de cumplimiento de limpieza.
  - Reportes de consumo de alimentos.
  - Información del estado clínico.
  - Alertas de inventario y vacunas.

---

## 👥 Tipos de usuario

El sistema contempla tres tipos principales de usuario:

| Rol | Descripción |
|---|---|
| **Administrador** | Supervisa y administra las principales funcionalidades del sistema. |
| **Operativo** | Accede a los módulos internos relacionados con las actividades del zoológico. |
| **Visitante** | Accede a las funcionalidades públicas, promociones y entradas. |

El acceso a las funcionalidades se controla mediante **autenticación y autorización basada en roles**.

---

## 🏗️ Arquitectura del sistema

SIGEZOO utiliza una **arquitectura monolítica de tres capas**, implementada mediante el patrón:

### MVC — Modelo, Vista y Controlador

Las capas principales son:

1. **Capa de presentación**
   - Blade
   - Bootstrap
   - Tailwind CSS
   - Alpine.js

2. **Capa de lógica de negocio**
   - Laravel
   - Controladores
   - Modelos
   - Eloquent ORM

3. **Capa de datos**
   - MySQL / MariaDB
   - Esquema relacional normalizado

Esta arquitectura permite separar la interfaz, la lógica del sistema y el almacenamiento de información, facilitando el mantenimiento y organización del proyecto.

---

## 💻 Stack tecnológico

| Tecnología | Uso |
|---|---|
| **Laravel** | Framework principal y arquitectura MVC |
| **PHP** | Desarrollo del backend |
| **Blade** | Motor de plantillas |
| **MySQL / MariaDB** | Base de datos relacional |
| **Eloquent ORM** | Interacción entre Laravel y la base de datos |
| **Bootstrap** | Diseño de interfaces |
| **Tailwind CSS** | Estilos utilizados junto con Laravel Breeze |
| **Alpine.js** | Componentes interactivos |
| **Laravel Breeze** | Autenticación |
| **Node.js / npm** | Gestión y compilación de recursos frontend |
| **XAMPP / Laragon** | Entorno de desarrollo local |

---

## 👨‍💻 Equipo de desarrollo

| Integrante | Carné | Rol asignado | Responsabilidad principal |
|---|---|---|---|
| **Saúl Estuardo De León Sarceño** | 0905-23-18205 | **Rol 1 – Analista de Requerimientos** | Levantamiento y organización de requerimientos, coordinación del equipo y apoyo en la elaboración de manuales. |
| **Leonel Andrés Guerra Godoy** | 0905-23-3939 | **Rol 2 – Arquitecto de Software** | Definición de la arquitectura, estructura tecnológica del sistema e integración general de sus componentes. |
| **Naser Daniel Martinez Morales** | 0905-23-3623 | **Rol 3 – Modelador UML / Diseñador de BD / Coordinador** | Elaboración de diagramas UML, diseño del modelo entidad-relación, estructura y documentación de la base de datos. |
| **Gabriel Enrique Villanueva Hernández** | 0905-23-21427 | **Rol 4 – Desarrollador Backend + BD** | Desarrollo de la lógica del sistema, operaciones backend, conexión y manejo de la base de datos. |
| **Franklin Boanerges López Chavarría** | 0905-23-4498 | **Rol 5 – Desarrollador Frontend + QA / Documentación Técnica** | Desarrollo de interfaces, integración visual, ejecución de pruebas funcionales y apoyo en documentación técnica. |

---

## 📅 Metodología de desarrollo

Para el desarrollo de SIGEZOO se utilizó la metodología ágil **Scrum**.

El trabajo fue organizado mediante **tres sprints principales y una etapa de cierre**, distribuyendo actividades de:

- Análisis de requerimientos.
- Diseño del sistema.
- Diseño de base de datos.
- Desarrollo frontend y backend.
- Integración.
- Pruebas.
- Documentación.

Esto permitió distribuir las responsabilidades del equipo y realizar un seguimiento progresivo del desarrollo.

---

# 🚀 Instalación

## Requisitos

Antes de ejecutar el proyecto se requiere:

- **PHP 8.2+**
  - Probado con PHP 8.3 y 8.4.
- **Composer**
- **MySQL / MariaDB**
- **Node.js**
- **npm**
- **XAMPP o Laragon**

---

## 1. Instalar dependencias

```bash
composer install
npm install
```

---

## 2. Configurar el entorno

Crear el archivo `.env` a partir del archivo de ejemplo:

```bash
cp .env.example .env
```

Generar la clave de Laravel:

```bash
php artisan key:generate
```

---

## 3. Crear la base de datos

Ejemplo utilizando MySQL con el usuario `root`:

```bash
mysql -u root -e "CREATE DATABASE sigezoo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Luego verificar la configuración de conexión dentro del archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigezoo
DB_USERNAME=root
DB_PASSWORD=
```

> Si tu instalación de MySQL utiliza otro usuario o contraseña, modifica los valores correspondientes.

---

## 4. Crear las tablas

Ejecutar las migraciones:

```bash
php artisan migrate
```

---

## 5. Cargar datos de prueba

SIGEZOO utiliza **seeders** para generar información de prueba y permitir la demostración de sus diferentes módulos.

```bash
php artisan db:seed
```

También puede ejecutarse:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ `migrate:fresh` elimina las tablas existentes antes de crearlas nuevamente. Utilízalo únicamente en un entorno de desarrollo.

---

## 6. Compilar recursos

```bash
npm run build
```

Para trabajar en modo desarrollo:

```bash
npm run dev
```

---

## 7. Ejecutar SIGEZOO

```bash
php artisan serve
```

Laravel iniciará el servidor local y mostrará la dirección desde la cual se puede acceder al sistema.

---

## 🔐 Usuarios de prueba

Los siguientes usuarios son creados mediante los seeders:

| Rol | Email | Contraseña |
|---|---|---|
| **Administrador** | `admin@miradasalvaje.test` | `password` |
| **Operativo** | `operativo@miradasalvaje.test` | `password` |
| **Visitante** | `visitante@miradasalvaje.test` | `password` |

> Estas credenciales están destinadas exclusivamente al entorno de desarrollo y demostración del prototipo.

---

## 🔒 Roles y autenticación

La autenticación se implementa utilizando **Laravel Breeze**.

Los roles se almacenan en la tabla:

```text
roles
```

Cada usuario posee un `id_rol` como llave foránea dentro de la tabla `users`.

El registro público asigna automáticamente el rol:

```text
visitante
```

Los roles de **administrador** y **operativo** deben asignarse mediante los seeders o directamente desde la administración correspondiente.

El middleware `role` permite proteger las rutas según el tipo de usuario:

```php
Route::middleware(['auth', 'role:administrador,operativo'])->group(function () {
    // Rutas correspondientes a los módulos internos
});
```

El modelo `User` también proporciona métodos auxiliares:

```php
$user->role;

$user->hasRole('operativo');

$user->isAdministrador();

$user->isOperativo();

$user->isVisitante();
```

---

## 📁 Estructura de módulos

Los controladores principales se encuentran organizados por módulo:

```text
app/
└── Http/
    └── Controllers/
        ├── Limpieza/
        ├── Alimentacion/
        ├── ControlClinico/
        └── Entradas/
```

Las vistas se encuentran en:

```text
resources/
└── views/
    ├── limpieza/
    ├── alimentacion/
    ├── control-clinico/
    └── entradas/
```

La estructura de la base de datos se administra mediante:

```text
database/
├── migrations/
└── seeders/
```

---

## 🗄️ Base de datos

SIGEZOO utiliza una base de datos relacional **MySQL/MariaDB**, diseñada para relacionar la información correspondiente a:

- Usuarios y roles.
- Animales.
- Hábitats.
- Limpieza.
- Alimentación.
- Dietas.
- Inventario.
- Medicamentos.
- Vacunas.
- Vitaminas.
- Entradas.
- Promociones.

El diseño busca mantener la **integridad, organización y reducción de redundancia de los datos** mediante un modelo relacional normalizado.

---

## ⚠️ Nota sobre Composer

Si `composer install` presenta problemas debido a *security advisories* relacionados con `laravel/framework` y la versión de PHP utilizada, puede ejecutarse:

```bash
composer config --global policy.advisories.block false
```

> Se recomienda utilizar esta configuración únicamente cuando sea necesario en el entorno de desarrollo y revisar las dependencias afectadas antes de utilizar el proyecto en un entorno de producción.

---

## 📌 Alcance del prototipo

SIGEZOO fue desarrollado como un **proyecto académico**, por lo que algunas funcionalidades representan una simulación del funcionamiento que tendría un sistema implementado en un entorno real.

El alcance actual **no contempla**:

- Integración con pasarelas de pago reales.
- Aplicación móvil nativa.
- Sistemas externos de facturación.
- Migración de información histórica real del zoológico.
- Despliegue definitivo en un servidor de producción.

Los datos utilizados para las pruebas y demostraciones son generados mediante **seeders**.

---

## 📚 Documentación

Como parte del proyecto se contempla documentación relacionada con:

- Requerimientos funcionales y no funcionales.
- Diagramas UML.
- Casos de uso.
- Diagramas de secuencia.
- Diagrama de clases.
- Modelo entidad-relación.
- Diccionario de datos.
- Arquitectura del software.
- Pruebas funcionales.
- Manual técnico.
- Manual de usuario.

---

## 📝 Conclusión

El desarrollo de **SIGEZOO** permitió aplicar de manera práctica los conocimientos adquiridos en **Análisis de Sistemas II**, integrando análisis, diseño, base de datos y desarrollo en un prototipo web funcional.

Mediante **Scrum y una adecuada distribución de responsabilidades**, se logró construir una solución que centraliza los principales procesos del zoológico **“Mirada Salvaje”**, demostrando la importancia de la planificación, comunicación e integración durante el desarrollo de un sistema.

---

### 🦁 SIGEZOO — Sistema Integral de Gestión del Zoológico

**Proyecto académico | Análisis de Sistemas II | 2026**
