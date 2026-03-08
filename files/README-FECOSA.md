# Terminal FECOSA – Laravel Full Stack

Sistema completo de horarios para la Terminal FECOSA, Alajuela, Costa Rica.

---

## 🚀 Instalación en 7 pasos

```bash
# 1. Crear proyecto Laravel
composer create-project laravel/laravel terminal-fecosa
cd terminal-fecosa

# 2. Copiar archivos (reemplazar los existentes)
#    Estructura detallada abajo

# 3. Configurar .env
cp .env.example .env
  php artisan key:generate
```

Editar `.env`:
```env
APP_URL=http://localhost:8000
APP_LOCALE=es
APP_TIMEZONE=America/Costa_Rica

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=terminal_fecosa
DB_USERNAME=root
DB_PASSWORD=tu_password
```

```bash
# 4. Crear base de datos
mysql -u root -p -e "CREATE DATABASE terminal_fecosa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Migrar y sembrar (incluye datos reales del SQL)
php artisan migrate --seed

# 6. Registrar middleware en bootstrap/app.php:
# $middleware->alias(['admin.auth' => \App\Http\Middleware\AdminAuthenticated::class]);

# 7. Levantar servidor
php artisan serve
```

| URL | Descripción |
|-----|-------------|
| `http://localhost:8000` | Sitio público |
| `http://localhost:8000/admin/login` | Panel admin |

**Credenciales admin:**
- Email: `admin@terminalfecosa.com`
- Password: `fecosa2025`

---

## 📁 Estructura de archivos

```
app/
  Http/
    Controllers/
      Admin/
        AuthController.php      ← Login/logout
        DashboardController.php ← Estadísticas
        RutaController.php      ← CRUD AJAX rutas
        HorarioController.php   ← CRUD + importación CSV
        FeatureController.php   ← CRUD features terminal
      Public/
        HomeController.php      ← Página principal
        RutaController.php      ← Detalle ruta + API search
    Middleware/
      AdminAuthenticated.php    ← Guard 'admin'
  Models/
    Ruta.php       ← nombreRuta, anden, slug, meta_description
    Horario.php    ← horarioSalidaTerminal, dia, accessors
    Feature.php    ← icono FontAwesome, nombre, orden
    Admin.php      ← Authenticatable

database/
  migrations/    ← 4 tablas: rutas, horarios, features, admins
  seeders/
    DatabaseSeeder.php  ← Datos reales del SQL original

resources/views/
  layouts/
    public.blade.php   ← Layout público (rojo/blanco/oscuro)
    admin.blade.php    ← Layout admin (sidebar oscuro)
  public/
    home/index.blade.php    ← Grilla de rutas + búsqueda + features
    rutas/show.blade.php    ← Detalle con horarios por grupo de días
  admin/
    auth/login.blade.php         ← Login moderno
    dashboard/index.blade.php    ← Stats + accesos rápidos
    rutas/index.blade.php        ← CRUD con DataTables + AJAX
    horarios/index.blade.php     ← CRUD + importación CSV
    features/index.blade.php     ← CRUD + selector de íconos FA

routes/web.php     ← Rutas públicas + admin protegidas
config/auth.php    ← Guard 'admin' con modelo Admin
```

---

## 🗄️ Base de datos

Mantiene la estructura original del SQL con mejoras:

| Tabla | Campos clave |
|-------|-------------|
| `rutas` | `nombreRuta`, `anden`, `slug` (único), `meta_description`, `activa` |
| `horarios` | `ruta_id`, `horarioSalidaTerminal` (texto CSV), `dia` (ej: "1,2,3,4,5") |
| `features` | `nombre`, `icono` (clase FA), `descripcion`, `orden`, `activo` |
| `admins` | `name`, `email`, `password` |

**Días:** 1=Lunes, 2=Martes, 3=Miércoles, 4=Jueves, 5=Viernes, 6=Sábado, 7=Domingo

---

## 📤 Importación CSV de horarios

Formato del archivo:
```csv
ruta_id,horas,dias
15,"04:45, 05:10, 05:30, 06:00","1,2,3,4,5"
cacao,"07:00, 09:00, 12:00","6"
atenas,"09:00, 11:00, 15:00, 17:00","7"
```

- La columna 1 acepta **ID numérico** o **slug** de la ruta
- Subir desde `Admin → Horarios → Importar CSV`

---

## 🎨 Stack / Librerías

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 11 + PHP 8.2 |
| Auth admin | Guard personalizado (`admin`) |
| Frontend público | Bootstrap 5.3 + FontAwesome 6 |
| Fuentes | Barlow Condensed (títulos) + Nunito (cuerpo) |
| Admin tables | DataTables 1.13 |
| Admin UX | SweetAlert2 + Toastr + Select2 |
| Ajax | jQuery 3.7 + Bootstrap modals |

---

## 🔧 Nota sobre middleware

Agregar en `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuthenticated::class,
    ]);
})
```

---

## 🚀 Próximos pasos sugeridos

- [ ] Importar las rutas restantes al SQL (solo 8 de 36 tienen horarios)
- [ ] PWA / Service Worker para uso offline
- [ ] Filtro por día de semana en tiempo real (ya preparado en el JS)
- [ ] API REST JSON para app móvil (`/api/v1/rutas`)
- [ ] Google Analytics / Search Console con los meta SEO ya implementados
- [ ] Sitemap.xml dinámico con todas las rutas para SEO
