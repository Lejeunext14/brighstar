@echo off
REM BrightStar Installation Script for Windows
REM This script sets up BrightStar locally on Windows

title BrightStar Installation - Windows

echo.
echo ===============================================
echo       BrightStar Installation for Windows
echo ===============================================
echo.

REM Check if git is installed
git --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Git is not installed
    echo Please install Git from https://git-scm.com/download/win
    pause
    exit /b 1
)

REM Check if PHP is installed
php --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed
    echo Please install PHP from https://www.php.net/downloads
    pause
    exit /b 1
)

REM Check if Composer is installed
composer --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Composer is not installed
    echo Please install Composer from https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Check if Node.js is installed
node --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Node.js is not installed
    echo Please install Node.js from https://nodejs.org/
    pause
    exit /b 1
)

echo [OK] All prerequisites found
echo.

REM Clone repository if needed
if not exist ".git" (
    echo Cloning BrightStar repository...
    git clone https://github.com/Lejeunext14/brighstar.git
    cd brighstar
)

echo Installing dependencies...
echo.

REM Install PHP dependencies
echo [1/4] Installing PHP dependencies with Composer...
call composer install
if errorlevel 1 (
    echo [ERROR] Composer install failed
    pause
    exit /b 1
)

REM Install NPM dependencies
echo [2/4] Installing Node.js dependencies with NPM...
call npm install
if errorlevel 1 (
    echo [ERROR] NPM install failed
    pause
    exit /b 1
)

REM Generate APP_KEY
echo [3/4] Generating application key...
call php artisan key:generate
if errorlevel 1 (
    echo [ERROR] Key generation failed
    pause
    exit /b 1
)

REM Run migrations
echo [4/4] Setting up database...
call php artisan migrate
if errorlevel 1 (
    echo [WARNING] Migration failed - check database configuration in .env
    echo You may need to run this manually: php artisan migrate
)

echo.
echo ===============================================
echo       Installation Complete!
echo ===============================================
echo.
echo Next steps:
echo 1. Start the development server:
echo    php artisan serve
echo.
echo 2. In a new terminal, start the frontend:
echo    npm run dev
echo.
echo 3. Open http://localhost:8000 in your browser
echo.
echo 4. Login with:
echo    Email: admin@gmail.com
echo    Password: Admin123
echo.
echo ===============================================
echo.
pause
