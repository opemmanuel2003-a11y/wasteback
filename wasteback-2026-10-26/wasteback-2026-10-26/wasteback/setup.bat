@echo off
setlocal EnableExtensions
title WasteBack setup
cd /d "%~dp0"

echo.
echo  ==============================================
echo     WasteBack - first time setup
echo  ==============================================
echo.

rem ---- Find PHP (XAMPP first, then anything on PATH) ----
set "PHP="
if exist "C:\xampp\php\php.exe" set "PHP=C:\xampp\php\php.exe"
if not defined PHP (
    where php >nul 2>nul && set "PHP=php"
)
if not defined PHP (
    echo  [X] PHP was not found.
    echo      Install XAMPP 8.2 or newer from https://www.apachefriends.org
    echo      into C:\xampp and run this file again.
    goto :fail
)

"%PHP%" -r "exit(version_compare(PHP_VERSION, '8.2.0', '>=') ? 0 : 1);"
if errorlevel 1 (
    echo  [X] Your PHP is older than 8.2. Install a newer XAMPP ^(8.2 or later^).
    goto :fail
)
"%PHP%" -r "echo ' [OK] PHP '.PHP_VERSION.' found'.PHP_EOL;"

rem ---- Find MySQL client ----
set "MYSQL="
if exist "C:\xampp\mysql\bin\mysql.exe" set "MYSQL=C:\xampp\mysql\bin\mysql.exe"
if not defined MYSQL (
    where mysql >nul 2>nul && set "MYSQL=mysql"
)
if not defined MYSQL (
    echo  [X] MySQL was not found. Install XAMPP into C:\xampp.
    goto :fail
)

rem ---- Check MySQL is running ----
"%MYSQL%" -u root -e "SELECT 1" >nul 2>nul
if errorlevel 1 (
    echo  [X] Could not connect to MySQL.
    echo      Open the XAMPP Control Panel, click Start next to MySQL,
    echo      then run this file again.
    goto :fail
)
echo  [OK] MySQL is running

rem ---- Environment file ----
if not exist ".env" (
    copy /y ".env.example" ".env" >nul
    echo  [OK] Created .env
)
"%PHP%" artisan key:generate --force >nul
if errorlevel 1 goto :fail
echo  [OK] App key generated

rem ---- Database ----
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS wasteback CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 goto :fail
echo  [OK] Database "wasteback" ready

echo.
echo  Creating tables and demo data. Any old WasteBack data will be replaced...
"%PHP%" artisan migrate:fresh --seed --force
if errorlevel 1 goto :fail

"%PHP%" artisan optimize:clear >nul 2>nul

echo.
echo  ==============================================
echo     Setup complete.
echo     Double-click start.bat to open the website.
echo  ==============================================
echo.
echo   Demo logins (password for all: password)
echo     Household      household@wasteback.ug
echo     Field agent    agent@wasteback.ug
echo     Administrator  admin@wasteback.ug
echo.
pause
exit /b 0

:fail
echo.
echo  Setup stopped. Fix the problem above and run setup.bat again.
echo.
pause
exit /b 1
