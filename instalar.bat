@echo off
setlocal
title Instalar Inventario General
cd /d "%~dp0"

rem ---- Pedir permisos de administrador automaticamente ----
net session >nul 2>&1
if errorlevel 1 (
    echo Solicitando permisos de administrador...
    powershell -NoProfile -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
    exit /b
)
cd /d "%~dp0"

echo ============================================================
echo   INSTALADOR DE INVENTARIO GENERAL
echo ============================================================
echo.

set "XAMPP=C:\xampp"
set "PHP=%XAMPP%\php\php.exe"
set "PHPINI=%XAMPP%\php\php.ini"
set "MYSQL=%XAMPP%\mysql\bin\mysql.exe"

if not exist "%PHP%" goto sin_xampp
if not exist "%MYSQL%" goto sin_xampp

rem ------------------------------------------------------------------
echo [1/8] Activando extensiones de PHP...
rem Se parte siempre del php.ini original (la copia se guarda la primera vez).
if exist "%PHPINI%.respaldo" (
    copy /y "%PHPINI%.respaldo" "%PHPINI%" >nul
) else (
    copy "%PHPINI%" "%PHPINI%.respaldo" >nul
)
powershell -NoProfile -ExecutionPolicy Bypass -Command "$f='%PHPINI%'; $c=[Collections.Generic.List[string]][IO.File]::ReadAllLines($f); foreach($e in 'intl','gd','zip','mbstring','fileinfo','pdo_mysql'){ $p='(php_)?'+$e+'(\.dll)?\s*$'; if(@($c | Where-Object { $_ -match ('^\s*extension\s*=\s*'+$p) }).Count -gt 0){ continue }; $i=-1; for($j=0; $j -lt $c.Count; $j++){ if($c[$j] -match ('^\s*;+\s*extension\s*=\s*'+$p)){ $i=$j; break } }; if($i -ge 0){ $c[$i]='extension='+$e } else { $c.Add('extension='+$e) } }; [IO.File]::WriteAllLines($f, $c)"
if errorlevel 1 (
    echo [ERROR] No pude modificar %PHPINI%. Cierre el XAMPP Control Panel e intente de nuevo.
    goto fin
)
"%PHP%" -r "exit(extension_loaded('intl') ? 0 : 1);" 2>nul
if errorlevel 1 (
    echo.
    echo [ERROR] La extension intl no carga. Este es el motivo que da PHP:
    "%PHP%" -d display_startup_errors=1 -d error_reporting=-1 -r "echo extension_loaded('intl') ? 'intl OK' : 'intl NO cargada';"
    echo.
    echo Copie este texto y envielo a soporte.
    goto fin
)
echo     Listo.
echo.

rem ------------------------------------------------------------------
echo [2/8] Encendiendo la base de datos...
call "%~dp0windows\arrancar.bat" solo-mysql
set "RC=%errorlevel%"
cd /d "%~dp0"
if not "%RC%"=="0" (
    echo [ERROR] No se pudo encender MySQL.
    echo Abra el XAMPP Control Panel, pulse Start en MySQL para ver el error y vuelva a ejecutar este instalador.
    goto fin
)
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS inventario_general CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
if errorlevel 1 (
    echo [ERROR] No se pudo crear la base de datos inventario_general.
    goto fin
)
echo     Base de datos inventario_general lista.
echo.

rem ------------------------------------------------------------------
echo [3/8] Librerias del sistema...
if exist "vendor\autoload.php" (
    echo     Ya estan incluidas.
) else (
    echo     Descargando de internet, puede tardar varios minutos...
    "%PHP%" composer.phar install --no-dev --optimize-autoloader --no-interaction
    if errorlevel 1 (
        echo [ERROR] Fallo la descarga de librerias. Revise la conexion a internet.
        goto fin
    )
)
echo.

rem ------------------------------------------------------------------
echo [4/8] Configurando...
if not exist ".env" copy ".env.example" ".env" >nul
rem Modo produccion: los errores no se muestran en pantalla, quedan en storage\logs\laravel.log
powershell -NoProfile -ExecutionPolicy Bypass -Command "$f='.env'; $c=Get-Content -LiteralPath $f; $set=@{'APP_ENV'='production';'APP_DEBUG'='false';'APP_URL'='http://127.0.0.1:8000'}; foreach($k in @($set.Keys)){ if($c -match ('^'+$k+'=')){ $c=$c -replace ('^'+$k+'=.*$'), ($k+'='+$set[$k]) } else { $c += ($k+'='+$set[$k]) } }; Set-Content -LiteralPath $f -Value $c"
findstr /r /c:"^APP_KEY=base64:" ".env" >nul
if errorlevel 1 "%PHP%" artisan key:generate --force
"%PHP%" artisan config:clear >nul
echo.

rem ------------------------------------------------------------------
echo [5/8] Creando las tablas...
"%PHP%" artisan migrate --seed --force
if errorlevel 1 (
    echo [ERROR] No se pudieron crear las tablas. Copie el mensaje de arriba y envielo a soporte.
    goto fin
)
echo.

rem ------------------------------------------------------------------
echo [6/8] Datos de ejemplo
echo     Para un cliente real responda N. Si ya los cargo antes, responda N.
choice /c SN /n /m "    Cargar productos y ventas de ejemplo? [S/N] "
if errorlevel 2 goto configurar
"%PHP%" artisan db:seed --class=DemoSeeder --force

:configurar
echo.
rem ------------------------------------------------------------------
echo [7/8] Datos del negocio y del administrador
"%PHP%" artisan inventario:configurar
echo.

rem ------------------------------------------------------------------
echo [8/8] Creando el acceso directo en el escritorio...
powershell -NoProfile -ExecutionPolicy Bypass -Command "$d=[Environment]::GetFolderPath('CommonDesktopDirectory'); if(-not $d -or -not (Test-Path $d)){ $d=[Environment]::GetFolderPath('Desktop') }; $w=New-Object -ComObject WScript.Shell; $s=$w.CreateShortcut((Join-Path $d 'Inventario General.lnk')); $s.TargetPath=(Join-Path $env:WINDIR 'System32\wscript.exe'); $s.Arguments='\"%~dp0Inventario.vbs\"'; $s.WorkingDirectory='%~dp0'; $s.IconLocation='%~dp0windows\inventario.ico'; $s.Description='Abrir Inventario General'; $s.Save()"
if errorlevel 1 (
    echo     No se pudo crear el acceso directo. Puede abrir el sistema con Inventario.vbs de esta carpeta.
) else (
    echo     Listo: icono "Inventario General" en el escritorio.
)

echo.
echo ============================================================
echo   INSTALACION TERMINADA
echo.
echo   Para usar el sistema: doble clic en el icono
echo   "Inventario General" del escritorio.
echo.
echo   Las copias de seguridad se guardan solas cada dia en:
echo   %~dp0respaldos
echo ============================================================
echo.
choice /c SN /n /m "Abrir Inventario General ahora? [S/N] "
if errorlevel 2 goto fin
rem Se abre a traves del Explorador para que el navegador no corra como administrador.
explorer.exe "%~dp0Inventario.vbs"
goto fin

:sin_xampp
echo [ERROR] No se encontro XAMPP en %XAMPP%.
echo Instale XAMPP en C:\xampp desde https://www.apachefriends.org y vuelva a ejecutar este instalador.

:fin
echo.
pause
