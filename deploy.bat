@echo off
REM BrightStar Deployment Quick Start Script (Windows)
REM This script prepares your application for Vercel deployment

echo.
echo 🚀 BrightStar Deployment Preparation
echo ======================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: artisan file not found. Please run this from the BrightStar root directory.
    pause
    exit /b 1
)

echo ✓ Found Laravel installation
echo.

REM Step 1: Install dependencies
echo 📦 Step 1: Installing Composer dependencies...
call composer install --no-dev

if errorlevel 1 (
    echo ❌ Composer install failed
    pause
    exit /b 1
)
echo ✓ Composer dependencies installed
echo.

REM Step 2: Install npm dependencies
echo 📦 Step 2: Installing NPM dependencies...
call npm install

if errorlevel 1 (
    echo ❌ NPM install failed
    pause
    exit /b 1
)
echo ✓ NPM dependencies installed
echo.

REM Step 3: Build assets
echo 🏗️ Step 3: Building frontend assets...
call npm run build

if errorlevel 1 (
    echo ❌ NPM build failed
    pause
    exit /b 1
)
echo ✓ Assets built successfully
echo.

REM Step 4: Generate APP_KEY if needed
echo 🔑 Step 4: Checking APP_KEY...
if not exist ".env" (
    echo    Creating .env file from .env.example...
    copy .env.example .env
)
call php artisan key:generate
echo ✓ APP_KEY ready
echo.

REM Step 5: Cache configuration
echo ⚙️ Step 5: Caching configuration...
call php artisan config:cache
call php artisan route:cache
echo ✓ Configuration cached
echo.

REM Step 6: Git status
echo 📝 Step 6: Checking Git status...
if exist ".git" (
    echo ✓ Git repository found
    echo.
    echo Changes to commit:
    call git status --short
    echo.
    echo To deploy, run:
    echo   git add .
    echo   git commit -m "Prepare for Vercel deployment"
    echo   git push origin main
) else (
    echo ⚠️ Not a Git repository. Initialize with: git init
    pause
    exit /b 1
)

echo.
echo ✅ Deployment preparation complete!
echo.
echo Next steps:
echo 1. Commit your changes to GitHub
echo 2. Go to vercel.com/new and import this repository
echo 3. Add environment variables for your database
echo 4. Deploy!
echo.
echo For detailed instructions, see DEPLOYMENT_GUIDE.md
echo.
pause
