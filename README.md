# ALPHA VENUS

Plataforma web y sistema administrativo para gimnasio funcional orientado a control de miembros, asistencias, pagos, administración y experiencia digital.

![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![Status](https://img.shields.io/badge/status-production-success)

---

## 🚀 Demo

🌐 Sitio oficial:

👉 [https://alphavenus.mx/](https://alphavenus.mx/)

---

# 📋 Descripción

ALPHA VENUS es una plataforma desarrollada para la administración integral de un gimnasio de entrenamiento funcional.

El sistema permite gestionar miembros, pagos, vigencias, asistencias, administración operativa y herramientas de control interno, además de ofrecer una experiencia digital para clientes y administradores.

El proyecto fue diseñado con enfoque en:

* Velocidad
* Escalabilidad
* Facilidad de uso
* Automatización operativa
* Control administrativo
* Experiencia visual moderna

---

# ⚙️ Tecnologías Utilizadas

## Backend

* PHP 8.2
* Laravel 10
* MySQL
* Eloquent ORM
* Blade

## Frontend

* HTML5
* CSS3
* Bootstrap 5
* JavaScript
* Font Awesome

## Herramientas

* Git
* GitHub
* Composer
* NPM
* Vite

---

# ✨ Funcionalidades

## 👥 Gestión de Miembros

* Registro de usuarios
* Control de vigencias
* Administración de membresías
* Validación de pagos
* Historial de usuarios

## ✅ Control de Asistencias

* Registro diario de asistencia
* Validación de membresía activa
* Panel de métricas
* Visualización de miembros presentes
* Reportes de asistencia

## 💳 Gestión de Pagos

* Control de vencimientos
* Penalizaciones automáticas
* Seguimiento de pagos pendientes
* Validación administrativa

## 📊 Dashboard Administrativo

* Estadísticas generales
* Usuarios activos
* Miembros vencidos
* Métricas operativas
* Panel administrativo interno

## 📱 Experiencia Web

* Sitio responsive
* Diseño moderno
* Optimizado para móviles
* Identidad visual personalizada

---

# 🧩 Estructura del Proyecto

```bash
alpha_venus/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env
├── artisan
├── composer.json
└── package.json
```

---

# ⚡ Instalación Local

## 1. Clonar repositorio

```bash
git clone https://github.com/dAlvarezDev/alpha_venus.git
```

## 2. Entrar al proyecto

```bash
cd alpha_venus
```

## 3. Instalar dependencias PHP

```bash
composer install
```

## 4. Instalar dependencias Node

```bash
npm install
```

## 5. Configurar archivo .env

```bash
cp .env.example .env
```

## 6. Generar APP_KEY

```bash
php artisan key:generate
```

## 7. Configurar base de datos

Editar variables en `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alpha_venus
DB_USERNAME=root
DB_PASSWORD=
```

## 8. Ejecutar migraciones

```bash
php artisan migrate
```

## 9. Ejecutar Vite

```bash
npm run dev
```

## 10. Iniciar servidor

```bash
php artisan serve
```

---

# 🔐 Variables de Entorno

Ejemplo básico:

```env
APP_NAME="Alpha Venus"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alpha_venus
DB_USERNAME=root
DB_PASSWORD=
```

---

# 📷 Capturas

## Página Principal

Agregar screenshot:

```bash
/public/screenshots/home.jpg
```

## Panel Administrativo

Agregar screenshot:

```bash
/public/screenshots/dashboard.jpg
```

## Control de Asistencias

Agregar screenshot:

```bash
/public/screenshots/asistencias.jpg
```

---

# 🛡️ Seguridad

El sistema implementa:

* Protección CSRF
* Validaciones backend
* Middleware de autenticación
* Protección de rutas administrativas
* Manejo seguro de sesiones

---

# 📈 Roadmap

## Próximas mejoras

* Integración con pagos en línea
* Aplicación móvil
* QR Check-In
* Reportes avanzados
* Dashboard financiero
* Sistema de notificaciones
* Integración WhatsApp
* Reservación de clases

---

# 🤝 Contribuciones

Actualmente el proyecto es privado y mantenido por el equipo de desarrollo.

Si deseas colaborar o implementar una solución similar:

📩 Contacto:

🌐 [https://bht.mx/](https://bht.mx/)

---

# 👨‍💻 Autor

## Daniel Alvarez

Director & Full Stack Developer

### Black Horse Technologies

🌐 [https://bht.mx/](https://bht.mx/)

---

# 📄 Licencia

Proyecto desarrollado para uso privado y comercial.

Todos los derechos reservados © Alpha Venus / Black Horse Technologies.
