# Inventario General

Sistema de inventario, compras y ventas para negocios desde una tienda de barrio hasta un supermercado. Hecho con **Laravel 9**, plantilla **Black Dashboard** y roles/permisos con **Shinobi**.

## Qué hace

- **Ventas (punto de venta):** se agregan productos con lector de código de barras o escribiendo el nombre, descuento por línea, impuesto, cálculo del cambio, ticket térmico y PDF.
- **Compras:** registra la mercancía que llega del proveedor y **suma al stock**. Se puede adjuntar la foto o PDF de la factura.
- **Inventario:** el stock se mueve solo con compras y ventas. Anular una venta devuelve el stock; anular una compra lo descuenta. Nunca queda en negativo.
- **Stock mínimo:** cada producto tiene un mínimo; el inicio y el listado de productos muestran los que están bajos.
- **Inicio:** ventas de hoy y del mes, compras del mes, gráfica de los últimos 14 días, stock bajo y últimas ventas.
- **Reportes:** del día y por rango de fechas, con los productos más vendidos.
- **Usuarios y roles:** cada usuario ve solo lo que su rol le permite. Vienen dos roles: **Admin** (acceso total) y **Cajero** (vender, imprimir, consultar).
- **Empresa e impresora:** nombre, NIT, logo y datos que salen en tickets y PDF; configuración de la impresora térmica.

## Requisitos

- PHP 8.0.2 o superior (probado con 8.3) con las extensiones `pdo_mysql`, `mbstring`, `gd`, `dom`, `zip`
- Composer
- MySQL / MariaDB (por ejemplo con XAMPP o Laragon)

## Instalación en Windows (para usted o para un cliente)

Funciona sin internet una vez instalado. Solo necesita **XAMPP** en `C:\xampp`.

1. Doble clic en **`instalar.bat`** (pide permiso de administrador solo). Activa las extensiones de PHP, enciende MySQL, crea la base de datos, instala las librerías si faltan, pregunta los datos del negocio y la contraseña del administrador, y crea el ícono **Inventario General** en el escritorio.
2. Para usarlo cada día: doble clic en el ícono del escritorio. Enciende MySQL y el sistema sin ventanas negras y lo abre como una ventana de programa (Edge o Chrome en modo aplicación).
3. Cada día que se abre, guarda una copia de la base de datos en `respaldos\` (se conservan 30).

### Llevarlo a un cliente

En su computador, con el sistema ya instalado, ejecute **`preparar-paquete.bat`**: deja en el escritorio `InventarioGeneral-cliente.zip` con las librerías incluidas y **sin** sus datos, su `.env`, sus imágenes ni sus respaldos. En el cliente: instalar XAMPP, descomprimir el .zip en `C:\` y ejecutar `C:\InventarioGeneral\instalar.bat`. Las instrucciones para el cliente están en `LEEME-INSTALACION.txt`.

| Archivo | Para qué |
|---|---|
| `instalar.bat` | Instalación completa (se puede repetir sin perder datos) |
| `Inventario.vbs` | Lo que abre el ícono del escritorio |
| `windows\arrancar.bat` | Enciende MySQL y el servidor ocultos, hace el respaldo del día |
| `windows\detener.bat` | Apaga todo (opcional) |
| `preparar-paquete.bat` | Arma el .zip para un cliente |

La instalación queda en modo producción (`APP_DEBUG=false`): los errores no se muestran en pantalla y quedan en `storage\logs\laravel.log`. Para ver los errores mientras programa, cambie `APP_DEBUG=true` en `.env`.

## Instalación manual

```bash
git clone https://github.com/Jofre1982/inventario-general.git
cd inventario-general
composer install
cp .env.example .env          # en Windows: copy .env.example .env
php artisan key:generate
```

Cree una base de datos vacía (por ejemplo `inventario_general`) y ponga sus datos en `.env`:

```
DB_DATABASE=inventario_general
DB_USERNAME=root
DB_PASSWORD=
```

Luego:

```bash
php artisan migrate --seed
php artisan serve
```

Entre a http://localhost:8000 con **admin@black.com** / **secret** y cambie la contraseña en *Principal → Perfil*.

¿Quiere probar con datos de ejemplo (12 productos, una compra y ventas de la última semana)?

```bash
php artisan db:seed --class=DemoSeeder
```

### Si ya tenía la base de datos de la versión anterior

```bash
php artisan migrate
php artisan db:seed
```

`migrate` solo agrega lo nuevo (stock mínimo, datos de impresora y montos más grandes); `db:seed` corrige los permisos con nombre equivocado, crea los roles que falten y le asigna el rol Admin al usuario administrador. Se puede ejecutar varias veces sin duplicar nada.

## Primeros pasos

1. *Administrar → Empresa*: nombre, NIT, dirección y logo.
2. *Administrar → Impresora*: tipo de conexión y prueba de impresión.
3. *Inventario → Categorías* y *Personas → Proveedores*.
4. *Inventario → Productos*: escanee el código de barras en el campo “Código de barras”.
5. *Transacciones → Compras*: registre la mercancía para que entre al stock.
6. *Transacciones → Nueva venta*: ¡a vender!
7. *Administrar → Usuarios*: cree los usuarios de los cajeros con el rol **Cajero**.

## Lector de código de barras

Cualquier lector USB que funcione como teclado sirve. En *Nueva venta* y *Nueva compra* el cursor queda en el campo de búsqueda: al escanear, el lector escribe el código y envía Enter, y el producto se agrega solo. Si se escanea dos veces, la cantidad sube a 2. También se puede escribir parte del nombre y elegir con las flechas y Enter.

## Impresora de tickets

Usa impresoras térmicas ESC/POS (Epson TM-T20 y similares). **La impresión la hace el servidor**, así que:

- **Sistema instalado en el mismo computador de la caja (XAMPP/Laragon):** comparta la impresora en Windows (Propiedades de la impresora → Compartir) y escriba ese nombre compartido en *Administrar → Impresora* con conexión *Windows*.
- **Sistema en un servidor o en otro computador:** use una impresora de red con IP fija y conexión *Impresora de red (IP)*, puerto 9100.
- **Linux o macOS:** conexión *CUPS* con el nombre de la impresora.

Use el botón *Imprimir página de prueba* para comprobar la configuración. Si no imprime, el sistema muestra el motivo en vez de fallar.

## Roles y permisos

Cada pantalla y botón exige un permiso (por ejemplo `sales.create` para vender o `change.status.sales` para anular ventas). En *Administrar → Roles* se crean roles marcando los permisos; un rol con *Acceso total* puede todo. Un usuario sin rol solo puede entrar al inicio y a su perfil.

El registro público está desactivado: los usuarios los crea un administrador.

## Pruebas automáticas

```bash
php artisan test
```

Cubren el movimiento de stock (compras, ventas, anulaciones, stock insuficiente, ventas a medias), permisos de cada rol, que todas las pantallas carguen, PDF y contenido del ticket.

## Estructura relevante

| Archivo | Para qué |
|---|---|
| `app/Services/InventoryService.php` | Todas las operaciones que mueven stock (con transacciones) |
| `app/Services/TicketPrinter.php` | Ticket térmico ESC/POS |
| `app/Http/Controllers/Controller.php` | `protectWithPermissions()`: une cada acción con su permiso |
| `database/seeders/PermissionsTableSeeder.php` | Lista de permisos y roles por defecto |
| `public/js/inventario.js` | Pantalla de venta/compra con lector de código de barras |
| `app/Models/Role.php`, `Permission.php` | Arreglo al error de caché de Shinobi |

## Licencia

MIT
