# 🚀 Deploy BrightStar to Render (Free)

## Step 1: Push to GitHub

```bash
git add .
git commit -m "Ready for Render deployment"
git push origin main
```

## Step 2: Create Render Account

1. Go to [render.com](https://render.com)
2. Sign up with GitHub
3. Connect your GitHub account

## Step 3: Deploy on Render

1. Click **New +** → **Web Service**
2. Select your `brighstar` repository
3. Fill in settings:
   - **Name**: brighstar
   - **Runtime**: PHP
   - **Build Command**: `composer install --no-dev && npm install && npm run build`
   - **Start Command**: `php artisan serve --host 0.0.0.0 --port $PORT`

4. Click **Create Web Service**

## Step 4: Add Environment Variables

After deployment starts, add these environment variables in Render dashboard:

```
APP_NAME=BrightStar
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:2IrELRfnW5rFH/UDOZAewd99vb+kgC00VTse3qzGYC0=
APP_URL=https://your-render-url.onrender.com

DB_CONNECTION=mysql
DB_HOST=your-mysql-host
DB_PORT=3306
DB_DATABASE=brighstar
DB_USERNAME=root
DB_PASSWORD=your-password

SESSION_DRIVER=cookie
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

## Step 5: Add MySQL Database

Option A: Use Render's MySQL (Recommended)
1. Click **New +** → **MySQL**
2. Name: `brighstar-db`
3. Copy credentials to environment variables

Option B: Use External Database
- PlanetScale (Free)
- Railway (Free)
- AWS RDS Free Tier

## Step 6: Run Migrations

After database is connected:

```bash
# Via Render dashboard terminal or:
render logs -s brighstar
```

Then run migrations:
```bash
php artisan migrate --force
```

## Done! 🎉

Your app is live at: `https://your-app-name.onrender.com`

---

## Troubleshooting

**Build fails?**
- Check build logs in Render dashboard
- Verify composer.json syntax
- Ensure all dependencies are installed

**Database connection error?**
- Verify DB credentials in environment variables
- Check database is running
- Verify firewall allows connections

**App won't start?**
- Check start command is correct
- Verify APP_KEY is set
- Check application logs in Render
