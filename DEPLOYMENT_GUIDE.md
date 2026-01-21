# BrightStar Laravel Deployment Guide

## Overview
This guide helps you deploy the BrightStar application to Vercel using serverless PHP.

---

## Prerequisites

- [Node.js](https://nodejs.org/) (v16 or higher)
- [Vercel Account](https://vercel.com)
- [GitHub Account](https://github.com)
- [Git](https://git-scm.com/)
- Composer already configured locally

---

## Step 1: Prepare for Deployment

### 1.1 Install Dependencies
```bash
cd c:\Users\Lejeune Daseco\brighstar
composer install --no-dev
npm install
npm run build
```

### 1.2 Generate Application Key
```bash
php artisan key:generate
```

### 1.3 Verify vercel.json Exists
Check that `vercel.json` exists in the root directory with PHP 8.2 configuration.

---

## Step 2: Choose a Database Provider

You need a hosted MySQL database. Choose one:

### Option A: PlanetScale (Recommended - Free tier available)
1. Go to [PlanetScale](https://planetscale.com)
2. Create account and new database
3. Get connection credentials:
   - Host: `*.planetscale.com`
   - Username: `root`
   - Password: (generated on setup)
   - Database name: `brighstar` (or your chosen name)

### Option B: Railway (Simple - Pay as you go)
1. Go to [Railway](https://railway.app)
2. Create new project → Add MySQL plugin
3. Get connection credentials from service variables

### Option C: AWS RDS
1. Create RDS instance (MySQL 8.0+)
2. Configure security groups to allow Vercel IPs
3. Get JDBC connection string

### Option D: Render
1. Go to [Render](https://render.com)
2. Create MySQL database
3. Get connection credentials

**Save your credentials somewhere safe - you'll need them for environment variables.**

---

## Step 3: Set Up GitHub Repository

### 3.1 Initialize Git (if not already done)
```bash
git init
git add .
git commit -m "Initial commit - ready for Vercel deployment"
```

### 3.2 Create GitHub Repository
1. Go to [github.com/new](https://github.com/new)
2. Create new repository (name: `brighstar` or similar)
3. Push your code:
```bash
git remote add origin https://github.com/YOUR_USERNAME/brighstar.git
git branch -M main
git push -u origin main
```

---

## Step 4: Deploy to Vercel

### 4.1 Import Project to Vercel
1. Go to [vercel.com/new](https://vercel.com/new)
2. Click "Import Git Repository"
3. Select your `brighstar` repository from GitHub
4. Click "Import"

### 4.2 Configure Environment Variables

On the Vercel import screen, add these environment variables:

```
APP_NAME=BrightStar
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.vercel.app
APP_KEY=<paste your APP_KEY from local .env>

DB_CONNECTION=mysql
DB_HOST=<your-database-host>
DB_PORT=3306
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-user>
DB_PASSWORD=<your-database-password>

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Example for PlanetScale:**
```
DB_HOST=pscale_abc123xyz.*.planetscale.com
DB_USERNAME=root
DB_PASSWORD=pscale_pw_abc123xyz
DB_DATABASE=brighstar
```

### 4.3 Configure Build Settings

Make sure build command is set to:
```bash
composer install --no-dev && npm install && npm run build && php artisan config:cache && php artisan route:cache
```

Output directory should be: `public`

### 4.4 Deploy
Click "Deploy" and wait for the build to complete.

---

## Step 5: Run Database Migrations

After deployment succeeds, you need to migrate your database.

### Option A: Using Artisan on Vercel CLI (Recommended)

```bash
# Install Vercel CLI
npm i -g vercel

# Connect to your Vercel project
vercel link

# Run migrations
vercel env pull  # Get environment variables locally
php artisan migrate --force
```

### Option B: Manual Database Setup

1. Connect to your hosted database using MySQL client:
```bash
mysql -h <DB_HOST> -u <DB_USER> -p <DB_PASSWORD> <DB_NAME>
```

2. Run migration SQL files from `database/migrations/` manually (advanced)

### Option C: Create Deployment Endpoint

Create a route to run migrations (for testing only, disable after):

Add this to `routes/web.php`:
```php
Route::get('/deploy/migrate', function () {
    if (app()->environment('production')) {
        // Extra security: verify API key or source IP
        \Artisan::call('migrate', ['--force' => true]);
        return response('Migrations completed', 200);
    }
    return response('Not available', 403);
});
```

Then visit: `https://your-domain.vercel.app/deploy/migrate`

---

## Step 6: Verify Deployment

### 6.1 Check Application
Visit your Vercel URL and verify:
- ✓ Application loads
- ✓ Login pages are accessible
- ✓ Student can login with Student ID
- ✓ Teacher can login with Teacher ID
- ✓ Admin can access dashboard

### 6.2 Test Admin Panel
1. Login as admin (email: `admin@gmail.com`, password: `Admin123`)
2. Navigate to "Manage Users"
3. Verify database tables are created and accessible
4. Test creating a new user
5. Check Admin Dashboard statistics

### 6.3 Test Authentication
- ✓ Student login with Student ID
- ✓ Teacher login with Teacher ID
- ✓ Parent login with email
- ✓ Password reset functionality

---

## Environment Variables Reference

| Variable | Purpose | Example |
|----------|---------|---------|
| APP_KEY | Laravel encryption key | base64:abc123... |
| APP_ENV | Environment | production |
| APP_DEBUG | Debug mode | false |
| APP_URL | Application URL | https://app.vercel.app |
| DB_HOST | Database host | pscale_*.planetscale.com |
| DB_PORT | Database port | 3306 |
| DB_DATABASE | Database name | brighstar |
| DB_USERNAME | Database user | root |
| DB_PASSWORD | Database password | xyz123 |

---

## Troubleshooting

### Build Fails: "Composer install failed"
- **Solution**: Check `composer.json` is valid
- Ensure PHP version in `vercel.json` is 8.2 or higher

### "502 Bad Gateway" Error
- **Solution**: Check Vercel Function logs
- Run: `vercel logs --follow`
- Verify database connection string is correct

### "Table 'brighstar.users' doesn't exist"
- **Solution**: Run migrations
- Use one of the migration methods above
- Check DB_DATABASE environment variable

### "CORS errors"
- **Solution**: Update `config/cors.php` to allow Vercel domain
- Set `'allowed_origins' => [env('APP_URL')]`

### "File uploads not working"
- **Solution**: Use S3 or similar cloud storage
- Vercel's `/tmp` is read-only outside of execution
- Configure AWS S3 in `config/filesystems.php`

### "Session/Cache not working"
- **Solution**: These are set to `file` driver
- For distributed deployments, switch to Redis
- Currently using `CACHE_DRIVER=file` and `SESSION_DRIVER=file`

---

## Performance Optimization

### Enable Query Caching
Update `config/cache.php`:
```php
'default' => env('CACHE_DRIVER', 'file'),
```

### Enable Config Caching (Already in build)
Already included in build command:
```bash
php artisan config:cache
php artisan route:cache
```

### Use Asset CDN
Update `vite.config.js` to use asset URL:
```javascript
export default defineConfig({
    plugins: [laravel()],
    build: {
        outDir: 'public/build',
    }
});
```

---

## Post-Deployment Checklist

- [ ] Application loads at Vercel URL
- [ ] Database migrations completed successfully
- [ ] Admin login works
- [ ] User management page accessible
- [ ] Can create new users
- [ ] Student login with Student ID works
- [ ] Teacher login with Teacher ID works
- [ ] Admin dashboard shows correct statistics
- [ ] Edit user functionality works
- [ ] Delete user functionality works
- [ ] Pagination works on user tables
- [ ] Settings page loads
- [ ] Reports page loads
- [ ] Logs page loads

---

## Maintenance

### Regular Backups
```bash
# Download database backup
mysqldump -h <HOST> -u <USER> -p <DB_NAME> > backup.sql
```

### Update Dependencies
```bash
composer update
npm update
npm run build
git commit -am "Update dependencies"
git push
# Vercel automatically redeploys on push
```

### Monitor Logs
```bash
vercel logs --follow
```

### Scale Database Connections
If using PlanetScale, monitor connection limit at dashboard.

---

## Custom Domain Setup

1. Go to Vercel Project Settings → Domains
2. Add your custom domain
3. Update DNS records at your domain provider
4. SSL certificate auto-generated by Vercel

---

## Rollback in Case of Issues

```bash
# View deployment history
vercel deployments list

# Revert to previous version
vercel rollback <deployment-id>
```

---

## Next Steps

1. ✅ Follow steps 1-6 above
2. 🚀 Monitor application in production
3. 📊 Check Vercel dashboard for performance metrics
4. 🔒 Set up custom domain (optional)
5. 📧 Configure email service for password resets
6. 🗄️ Set up automated database backups

---

## Support

For issues:
- Check Vercel logs: `vercel logs --follow`
- Review Laravel logs: Database table or file
- Verify environment variables are set correctly
- Test locally: `php artisan serve`

---

**Deployment Date**: 2025-01-22  
**Laravel Version**: 11.x  
**PHP Version**: 8.2  
**Node Version**: 18+
