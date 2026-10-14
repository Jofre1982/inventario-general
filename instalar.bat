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
rem Se parte siempre del php.ini original (la copia se guarda la primera vez).
if exist "%PHPINI%.respaldo" (
    copy /y "%PHPINI%.respaldo" "%PHPINI%" >nul
) else (
    copy "%PHPINI%" "%PHPINI%.respaldo" >nul
)
powershell -NoProfile -ExecutionPolicy Bypass -Command "$f='%PHPINI%'; $c=[Collections.Generic.List[string]][IO.File]::ReadAllLines($f); foreach($e in 'intl','gd','zip','mbstring','fileinfo','pdo_mysql'){ $p='(php_)?'+$e+'(\.dll)?\s*$'; if(@($c | Where-Object { $_ -match ('^\s*extension\s*=\s*'+$p) }).Count -gt 0){ continue }; $i=-1; for($j=0; $j -lt $c.Count; $j++){ if($c[$j] -match ('^\s*;+\s*extension\s*=\s*'+$p)){ $i=$j; break } }; if($i -ge 0){ $c[$i]='extension='+$e } else { $c.Add('extension='+$e) } }; [IO.File]::WriteAllLines($f, $c)"
if errorlevel 1 (
    echo [ERROR] No pude modificar %PHPINI%.
    echo Cierre el XAMPP Control Panel y ejecute este archivo con clic derecho - Ejecutar como administrador.
    goto fin
)
"%PHP%" -r "exit(extension_loaded('intl') ? 0 : 1);" 2>nul
if errorlevel 1 (
    echo.
    echo [ERROR] La extension intl no carga. Este es el motivo que da PHP:
    echo ------------------------------------------------------------
    "%PHP%" -d display_startup_errors=1 -d error_reporting=-1 -r "echo extension_loaded('intl') ? 'intl OK' : 'intl NO cargada';"
    echo.
    echo extension_dir:
    "%PHP%" -r "echo ini_get('extension_dir');"
    echo.
    if exist "C:\xampp\php\ext\php_intl.dll" (echo php_intl.dll: existe) else (echo php_intl.dll: NO EXISTE en C:\xampp\php\ext)
    dir /b "C:\xampp\php\icu*.dll" 2>nul || echo Archivos icu*.dll: NO EXISTEN en C:\xampp\php
    echo ------------------------------------------------------------
    echo Copie todo este texto y envielo.
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
if not exist ".env" copy ".env.example" ".env" >nul
findstr /r /c:"^APP_KEY=base64:" ".env" >nul
if errorlevel 1 "%PHP%" artisan key:generate --force
"%PHP%" artisan config:clear >nul
echo.

echo [5/6] Creando las tablas...
"%PHP%" artisan migrate --seed --force
if errorlevel 1 (
    echo [ERROR] No se pudieron crear las tablas. Copie el mensaje de arriba y envielo.
    goto fin
)
echo.

echo [6/6] Datos de ejemplo
echo (Si ya los cargo antes, responda N para no duplicarlos)
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
