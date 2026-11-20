@echo off
setlocal EnableExtensions
title WasteBack - keep this window open
cd /d "%~dp0"

set "PHP="
if exist "C:\xampp\php\php.exe" set "PHP=C:\xampp\php\php.exe"
if not defined PHP (
    where php >nul 2>nul && set "PHP=php"
)
if not defined PHP (
    echo PHP was not found. Install XAMPP into C:\xampp first.
    pause
    exit /b 1
)

if not exist ".env" (
    echo WasteBack is not set up yet. Run setup.bat first.
    pause
    exit /b 1
)

echo.
echo  WasteBack is running at http://127.0.0.1:8000
echo  Make sure MySQL is started in the XAMPP Control Panel.
echo  Keep this window open while you use the site. Close it to stop.
echo.
start "" "http://127.0.0.1:8000"
"%PHP%" artisan serve --host=127.0.0.1 --port=8000
pause
