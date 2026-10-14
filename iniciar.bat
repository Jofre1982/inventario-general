@echo off
title Inventario General - NO CIERRE ESTA VENTANA
cd /d "%~dp0"
set "PHP=C:\xampp\php\php.exe"
set "MYSQL=C:\xampp\mysql\bin\mysql.exe"

"%MYSQL%" -u root -e "SELECT 1" >nul 2>&1
if errorlevel 1 (
    echo MySQL no esta encendido. Abra el XAMPP Control Panel y pulse Start en MySQL.
    pause
    exit /b
)

echo ============================================================
echo   Inventario General esta funcionando en http://localhost:8000
echo   Mientras esta ventana este abierta el sistema funciona.
echo   Para apagarlo, cierre esta ventana.
echo ============================================================
start "" cmd /c "timeout /t 3 >nul & start http://localhost:8000"
"%PHP%" artisan serve --port=8000
pause
