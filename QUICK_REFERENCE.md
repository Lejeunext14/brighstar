# Quick Reference Card - BrightStar Vercel Deployment

## 🚀 30-Second Setup

```bash
# Windows
deploy.bat

# Mac/Linux
chmod +x deploy.sh && ./deploy.sh
```

Then push to GitHub and import to Vercel.

---

## 📋 Essential Commands

| Task | Command |
|------|---------|
| Prepare for deployment | `deploy.bat` (Windows) or `./deploy.sh` (Mac/Linux) |
| Generate APP_KEY | `php artisan key:generate` |
| Run migrations locally | `php artisan migrate` |
| Run migrations production | `php artisan migrate --force` |
| Clear cache | `php artisan config:clear` |
| View Vercel logs | `vercel logs --follow` |
| Check database tables | `mysql -h HOST -u USER -p DB -e "SHOW TABLES;"` |

---

## 🔑 Required Environment Variables

```
APP_NAME=BrightStar
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://your-domain.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-host.com
DB_PORT=3306
DB_DATABASE=brighstar
DB_USERNAME=user
DB_PASSWORD=password
```

---

## 📂 Key Files

| File | Purpose |
|------|---------|
| `vercel.json` | Vercel config |
| `api/index.php` | Serverless entry point |
| `.env.production` | Env template |
| `DEPLOYMENT_GUIDE.md` | Full guide |
| `POST_DEPLOYMENT_CHECKLIST.md` | Verification |

---

## 🗄️ Database Providers

| Provider | Price | Notes |
|----------|-------|-------|
| PlanetScale | Free | Recommended |
| Railway | $5/mo | Simple |
| AWS RDS | Variable | Customizable |
| Render | Free | Backups included |

---

## ✅ Deployment Steps

1. Run `deploy.bat`
2. Push to GitHub
3. Import to Vercel
4. Add environment variables
5. Deploy
6. Run migrations
7. Test admin login

---

## 🔗 Useful Links

- Vercel: [vercel.com](https://vercel.com)
- PlanetScale: [planetscale.com](https://planetscale.com)
- Laravel: [laravel.com/docs](https://laravel.com/docs)

---

## 🆘 Common Issues

| Issue | Fix |
|-------|-----|
| 502 Bad Gateway | Check logs: `vercel logs --follow` |
| Table doesn't exist | Run: `php artisan migrate --force` |
| No CSS/assets | Rebuild: `npm run build` |
| DB connection error | Verify credentials in env vars |

---

## 📞 Need Help?

1. Read `DEPLOYMENT_GUIDE.md`
2. Check `POST_DEPLOYMENT_CHECKLIST.md`
3. View Vercel logs: `vercel logs --follow`
4. Verify database connection locally first

---

## ✨ Status

✅ **All deployment files created and ready**  
✅ **Database configuration templates ready**  
✅ **Documentation complete**  
✅ **Scripts automated**  

**Ready to deploy!** 🚀
