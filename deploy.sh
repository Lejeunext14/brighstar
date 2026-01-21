#!/bin/bash
# BrightStar Deployment Quick Start Script
# This script prepares your application for Vercel deployment

echo "🚀 BrightStar Deployment Preparation"
echo "======================================"
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this from the BrightStar root directory."
    exit 1
fi

echo "✓ Found Laravel installation"
echo ""

# Step 1: Install dependencies
echo "📦 Step 1: Installing Composer dependencies..."
composer install --no-dev

if [ $? -ne 0 ]; then
    echo "❌ Composer install failed"
    exit 1
fi
echo "✓ Composer dependencies installed"
echo ""

# Step 2: Install npm dependencies
echo "📦 Step 2: Installing NPM dependencies..."
npm install

if [ $? -ne 0 ]; then
    echo "❌ NPM install failed"
    exit 1
fi
echo "✓ NPM dependencies installed"
echo ""

# Step 3: Build assets
echo "🏗️ Step 3: Building frontend assets..."
npm run build

if [ $? -ne 0 ]; then
    echo "❌ NPM build failed"
    exit 1
fi
echo "✓ Assets built successfully"
echo ""

# Step 4: Generate APP_KEY if needed
echo "🔑 Step 4: Checking APP_KEY..."
if grep -q "^APP_KEY=$" .env 2>/dev/null || [ ! -f ".env" ]; then
    echo "   Generating new APP_KEY..."
    php artisan key:generate
    echo "✓ APP_KEY generated"
else
    echo "✓ APP_KEY already exists"
fi
echo ""

# Step 5: Cache configuration
echo "⚙️ Step 5: Caching configuration..."
php artisan config:cache
php artisan route:cache
echo "✓ Configuration cached"
echo ""

# Step 6: Git status
echo "📝 Step 6: Checking Git status..."
if [ -d ".git" ]; then
    echo "✓ Git repository found"
    echo ""
    echo "Changes to commit:"
    git status --short
    echo ""
    echo "To deploy, run:"
    echo "  git add ."
    echo "  git commit -m 'Prepare for Vercel deployment'"
    echo "  git push origin main"
else
    echo "⚠️ Not a Git repository. Initialize with: git init"
    exit 1
fi

echo ""
echo "✅ Deployment preparation complete!"
echo ""
echo "Next steps:"
echo "1. Commit your changes to GitHub"
echo "2. Go to vercel.com/new and import this repository"
echo "3. Add environment variables for your database"
echo "4. Deploy!"
echo ""
echo "For detailed instructions, see DEPLOYMENT_GUIDE.md"
