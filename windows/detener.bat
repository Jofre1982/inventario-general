@echo off
rem Apaga el servidor del sistema y la base de datos (no es necesario usarlo a diario).
setlocal
set "XAMPP=C:\xampp"
set "PORT=8000"
for /f "tokens=5" %%p in ('netstat -ano ^| findstr /r /c:"127\.0\.0\.1:%PORT% .*LISTENING"') do taskkill /pid %%p /f >nul 2>&1
"%XAMPP%\mysql\bin\mysqladmin.exe" -u root shutdown >nul 2>&1
echo Inventario General se apago.
ping -n 3 127.0.0.1 >nul
