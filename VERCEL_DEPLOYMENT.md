# Vercel Deployment Guide for BrightStar Laravel Application

## Prerequisites
- GitHub account with your repository pushed
- Vercel account (create at vercel.com)
- Database hosting (e.g., PlanetScale MySQL, AWS RDS, or Railway)

## Step 1: Prepare Your Repository
```bash
git add .
git commit -m "Add Vercel configuration"
git push origin main
```

## Step 2: Set Up Environment Variables

### Database Setup
You need to set up a managed MySQL database. Options:
- **PlanetScale** (Free tier available): https://planetscale.com
- **Railway** (Free credits): https://railway.app
- **AWS RDS** (Free tier available): https://aws.amazon.com/rds/
- **Render** (Free PostgreSQL): https://render.com

### Create Database
1. Create a new database in your chosen service
2. Get connection details (host, user, password, database name)

## Step 3: Deploy to Vercel

### Via GitHub (Recommended)
1. Go to https://vercel.com/new
2. Select "Import Git Repository"
3. Search for your GitHub repository
4. Click "Import"

### Configure Build Settings
- **Framework**: Leave blank (we configured in vercel.json)
- **Build Command**: `composer install && npm install && npm run build && php artisan config:cache && php artisan route:cache`
- **Output Directory**: `public`

### Set Environment Variables in Vercel
Go to Settings → Environment Variables and add:

```
APP_NAME=BrightStar
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-db-host.com
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

LOG_CHANNEL=single
CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Get APP_KEY
If you don't have an APP_KEY, run locally:
```bash
php artisan key:generate
# Copy the key from .env
```

## Step 4: Deploy Migrations

After first deployment, run migrations:

### Option A: SSH into Vercel (Limited)
Vercel doesn't provide SSH access. Use Option B instead.

### Option B: Create Artisan Command Route (Recommended)

Create file: `app/Http/Controllers/DeploymentController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class DeploymentController extends Controller
{
    public function migrate()
    {
        if (env('APP_ENV') !== 'production') {
            return 'Migrations only available in production';
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            return Artisan::output();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
```

Add route in `routes/web.php`:
```php
Route::get('/deploy/migrate', 'DeploymentController@migrate');
```

Then visit: `https://your-domain.vercel.app/deploy/migrate` once after deployment.

## Step 5: Custom Domain (Optional)

In Vercel Dashboard:
1. Go to your project → Settings → Domains
2. Add your custom domain
3. Update DNS records as shown in Vercel

## Step 6: Verify Deployment

Check your application at the provided Vercel URL:
- Admin Login: https://your-domain.vercel.app/admin-login
- Teachers Login: https://your-domain.vercel.app/teachers-login
- Parents Login: https://your-domain.vercel.app/parents-login
- Student Login: https://your-domain.vercel.app/login

## Troubleshooting

### Error: "No application encryption key has been specified"
- Generate key: `php artisan key:generate`
- Add APP_KEY to Vercel environment variables

### Error: "SQLSTATE[HY000]"
- Check database credentials in environment variables
- Verify database is accessible from Vercel
- Ensure database is created and migrations ran

### Error: "Storage not writable"
- Vercel has read-only filesystem outside `/tmp`
- Use S3 or other external storage for file uploads
- For now, storage is in-memory/temporary

### Assets not loading
- Run: `php artisan optimize`
- Check that CSS/JS files are in `public/build/`

## Database Backups

Set up automatic backups with your database provider (PlanetScale, Railway, etc. all have built-in backup features).

## Performance Tips

1. Enable query caching: Update `config/database.php`
2. Use Redis for sessions if available
3. Enable blade caching: Already configured in production
4. Use CDN for static assets

## Support

For more information:
- Vercel Docs: https://vercel.com/docs
- Laravel on Vercel: https://vercel.com/guides/deploying-laravel
