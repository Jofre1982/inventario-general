@echo off
setlocal
title Instalar Inventario General
cd /d "%~dp0"

echo ============================================================
echo   INSTALADOR DE INVENTARIO GENERAL
echo ============================================================
echo.

set "PHP=C:\xampp\php\php.exe"
set "PHPINI=C:\xampp\php\php.ini"
set "MYSQL=C:\xampp\mysql\bin\mysql.exe"

if not exist "%PHP%" (
    echo [ERROR] No encontre PHP en %PHP%
    echo Instale XAMPP en C:\xampp desde https://www.apachefriends.org
    goto fin
)

echo [1/6] Activando extensiones de PHP (intl, gd, zip, mbstring, fileinfo, pdo_mysql)...
if not exist "%PHPINI%.respaldo" copy "%PHPINI%" "%PHPINI%.respaldo" >nul
powershell -NoProfile -ExecutionPolicy Bypass -Command "$f='%PHPINI%'; $c=Get-Content -LiteralPath $f; foreach($e in 'intl','gd','zip','mbstring','fileinfo','pdo_mysql','openssl'){ $c=$c -replace ('^\s*;\s*extension\s*=\s*(php_)?'+$e+'(\.dll)?\s*$'), ('extension='+$e) }; Set-Content -LiteralPath $f -Value $c"
if errorlevel 1 (
    echo [ERROR] No pude modificar %PHPINI%. Cierre XAMPP y ejecute este archivo con clic derecho - Ejecutar como administrador.
    goto fin
)
"%PHP%" -m | findstr /i /x "intl" >nul
if errorlevel 1 (
    echo [ERROR] La extension intl sigue sin activarse. Revise %PHPINI%
    goto fin
)
echo     Listo. Se guardo una copia en php.ini.respaldo
echo.

echo [2/6] Comprobando MySQL...
"%MYSQL%" -u root -e "SELECT 1" >nul 2>&1
if errorlevel 1 (
    echo.
    echo [ERROR] MySQL no esta encendido.
    echo Abra el XAMPP Control Panel, pulse Start en MySQL y vuelva a ejecutar este archivo.
    goto fin
)
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS inventario_general CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
echo     Base de datos inventario_general lista.
echo.

echo [3/6] Descargando librerias (puede tardar varios minutos)...
"%PHP%" composer.phar install --no-interaction
if errorlevel 1 (
    echo [ERROR] Fallo la instalacion de librerias. Copie el mensaje de arriba y envielo.
    goto fin
)
echo.

echo [4/6] Configurando...
if not exist ".env" (
    copy ".env.example" ".env" >nul
    "%PHP%" artisan key:generate --force
)
echo.

echo [5/6] Creando las tablas...
"%PHP%" artisan migrate --seed --force
if errorlevel 1 (
    echo [ERROR] No se pudieron crear las tablas. Copie el mensaje de arriba y envielo.
    goto fin
)
echo.

echo [6/6] Datos de ejemplo
choice /c SN /m "Desea cargar productos y ventas de ejemplo para probar"
if errorlevel 2 goto listo
"%PHP%" artisan db:seed --class=DemoSeeder --force

:listo
echo.
echo ============================================================
echo   INSTALACION TERMINADA
echo   Para abrir el sistema haga doble clic en  iniciar.bat
echo   Usuario: admin@black.com    Contrasena: secret
echo ============================================================
choice /c SN /m "Desea abrirlo ahora"
if errorlevel 2 goto fin
call "%~dp0iniciar.bat"

:fin
echo.
pause
