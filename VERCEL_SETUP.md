# 🚀 Vercel Deployment Setup - BrightStar

This directory contains all the necessary configuration files for deploying BrightStar to Vercel.

## 📁 Files Included

| File | Purpose |
|------|---------|
| `vercel.json` | Vercel configuration for PHP 8.2 serverless environment |
| `api/index.php` | Entry point for serverless PHP functions |
| `DEPLOYMENT_GUIDE.md` | Comprehensive step-by-step deployment instructions |
| `.env.production` | Production environment variables template |
| `deploy.sh` | Automated deployment preparation script (Linux/Mac) |
| `deploy.bat` | Automated deployment preparation script (Windows) |

## 🚀 Quick Start (5 minutes)

### For Windows Users:
```bash
# 1. Run the deployment script
deploy.bat

# 2. Commit to GitHub
git add .
git commit -m "Prepare for Vercel deployment"
git push origin main

# 3. Go to vercel.com/new and import your repository
```

### For Mac/Linux Users:
```bash
# 1. Make script executable
chmod +x deploy.sh

# 2. Run the deployment script
./deploy.sh

# 3. Commit to GitHub
git add .
git commit -m "Prepare for Vercel deployment"
git push origin main

# 4. Go to vercel.com/new and import your repository
```

## 📋 What the Deploy Scripts Do

1. ✅ Verify Laravel installation
2. ✅ Install Composer dependencies (no dev)
3. ✅ Install NPM dependencies
4. ✅ Build frontend assets
5. ✅ Generate APP_KEY if needed
6. ✅ Cache configuration and routes
7. ✅ Show Git status

## 🗄️ Database Setup Required

Before deploying to Vercel, you must choose and set up a hosted database.

**Options:**
- **PlanetScale** (Recommended) - Free tier available
- **Railway** - $5/month minimum
- **AWS RDS** - Pay-per-use
- **Render** - Free tier available

See `DEPLOYMENT_GUIDE.md` for detailed setup instructions for each option.

## 🔐 Environment Variables

After importing to Vercel, you must add these environment variables:

### Required:
```
APP_KEY=your_generated_key_here
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-vercel-url.app

DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=brighstar
DB_USERNAME=database_user
DB_PASSWORD=database_password
```

See `.env.production` for a complete template.

## ✅ Deployment Checklist

- [ ] Run `deploy.bat` (or `deploy.sh`)
- [ ] All commands complete without errors
- [ ] Changes committed to GitHub
- [ ] Repository imported to Vercel
- [ ] Environment variables added to Vercel dashboard
- [ ] Database created and credentials ready
- [ ] Deployment triggered
- [ ] Application loads at Vercel URL
- [ ] Database migrations run
- [ ] Admin login works

## 📚 Next Steps

1. **Read** `DEPLOYMENT_GUIDE.md` for comprehensive instructions
2. **Set up** your database (PlanetScale, Railway, etc.)
3. **Commit** your code to GitHub
4. **Deploy** via Vercel dashboard
5. **Run** migrations on hosted database
6. **Test** admin panel and authentication

## 🆘 Need Help?

### Build Fails
- Check `composer.json` syntax
- Ensure all Laravel dependencies are installed
- Verify PHP 8.2 is available locally

### Database Connection Issues
- Verify database credentials in environment variables
- Check database hostname is correct
- Ensure Vercel IP ranges are whitelisted (if required)

### Application Won't Load
- Check Vercel function logs: `vercel logs --follow`
- Verify APP_KEY is set
- Check database migrations have run

For detailed troubleshooting, see `DEPLOYMENT_GUIDE.md`.

## 🔗 Resources

- [Vercel Documentation](https://vercel.com/docs)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [PlanetScale Docs](https://planetscale.com/docs)

## 📞 Support

For issues specific to this BrightStar deployment:
1. Check `DEPLOYMENT_GUIDE.md` troubleshooting section
2. Review Vercel logs: `vercel logs --follow`
3. Test database connection locally first

---

**Ready to deploy?** Start with the Quick Start section above! 🎉
