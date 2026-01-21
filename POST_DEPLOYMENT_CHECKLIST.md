# Post-Deployment Checklist - BrightStar

Use this checklist to verify your Vercel deployment is working correctly.

## ✅ Pre-Deployment (Local)

- [ ] Ran `deploy.bat` or `deploy.sh`
- [ ] No errors in deployment script output
- [ ] `composer.lock` updated
- [ ] `package-lock.json` updated
- [ ] `.env` file has APP_KEY generated
- [ ] Git history is clean (all changes committed)

## ✅ Vercel Configuration

- [ ] GitHub repository created and linked to Vercel
- [ ] Project imported successfully to Vercel
- [ ] Build command is set to: `composer install --no-dev && npm install && npm run build && php artisan config:cache && php artisan route:cache`
- [ ] Output directory is: `public`
- [ ] All environment variables added (see list below)
- [ ] First deployment completed without errors

### Required Environment Variables
- [ ] `APP_NAME=BrightStar`
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY=base64:...` (your generated key)
- [ ] `APP_URL=https://your-domain.vercel.app`
- [ ] `DB_HOST=...`
- [ ] `DB_PORT=3306`
- [ ] `DB_DATABASE=brighstar`
- [ ] `DB_USERNAME=...`
- [ ] `DB_PASSWORD=...`

## ✅ Database & Migrations

- [ ] Database provider chosen (PlanetScale, Railway, AWS, etc.)
- [ ] Database created with name `brighstar`
- [ ] Database credentials verified working locally
- [ ] Migrations executed on hosted database
- [ ] Tables created: `users`, `cache`, `jobs`, `lesson_progress`, `phone_verification_codes`
- [ ] Admin user seeded (email: `admin@gmail.com`, password: `Admin123`)

### How to verify migrations ran:
```bash
# Check if tables exist in your hosted database
mysql -h <DB_HOST> -u <DB_USER> -p <DB_NAME> -e "SHOW TABLES;"
```

## ✅ Application Loading

- [ ] Application loads at `https://your-domain.vercel.app`
- [ ] No 502 Bad Gateway errors
- [ ] Page loads completely (no missing assets)
- [ ] Tailwind CSS styling applied correctly
- [ ] Navigation menu visible and clickable
- [ ] No console errors in browser DevTools

## ✅ Authentication

- [ ] Can access login page
- [ ] Admin login works (email: `admin@gmail.com`, password: `Admin123`)
- [ ] Student login page displays
- [ ] Teacher login page displays
- [ ] Parent login page displays

### Test Credentials (if seeded):
- **Admin**: `admin@gmail.com` / `Admin123`
- Create test student/teacher/parent through admin panel

## ✅ Admin Panel - Dashboard

- [ ] Dashboard page loads without errors
- [ ] Total Users count displays (correct number)
- [ ] Total Students count displays (correct number)
- [ ] Total Teachers count displays (correct number)
- [ ] Total Parents count displays (correct number)
- [ ] Recent Users list shows last created users
- [ ] Admin action cards visible (Users, Settings, Reports, Logs)

## ✅ Admin Panel - User Management

- [ ] Users page loads
- [ ] Three tabs visible: Students, Teachers, Parents
- [ ] **Students Tab**:
  - [ ] User list displays with pagination
  - [ ] Columns: Name, Student ID, Email, Parent Name, Created, Actions
  - [ ] "Add New Student" button works
  - [ ] Can create new student
  - [ ] Parent Name field saves correctly
  - [ ] Edit button opens modal with pre-filled data
  - [ ] Can update student information
  - [ ] Can update student password
  - [ ] Delete button with confirmation works
  - [ ] Pagination works (next/previous pages)

- [ ] **Teachers Tab**:
  - [ ] User list displays with pagination
  - [ ] Columns: Name, Email, Created, Actions
  - [ ] "Add New Teacher" button works
  - [ ] Can create new teacher
  - [ ] Edit functionality works
  - [ ] Delete functionality works

- [ ] **Parents Tab**:
  - [ ] User list displays with pagination
  - [ ] Columns: Name, Email, Created, Actions
  - [ ] "Add New Parent" button works
  - [ ] Can create new parent
  - [ ] Edit functionality works
  - [ ] Delete functionality works

## ✅ Admin Panel - Settings

- [ ] Settings page loads at `/admin/settings`
- [ ] Configuration options display
- [ ] Page does not have errors

## ✅ Admin Panel - Reports

- [ ] Reports page loads at `/admin/reports`
- [ ] User statistics display (total by role)
- [ ] System health status shows
- [ ] All metrics calculate correctly

## ✅ Admin Panel - Logs

- [ ] Logs page loads at `/admin/logs`
- [ ] System logs display (if available)
- [ ] No permission errors

## ✅ Authentication Flows

### Student Login (if test student created)
- [ ] Navigate to `/login`
- [ ] Enter Student ID and password
- [ ] Login succeeds
- [ ] Redirected to student dashboard or home
- [ ] Session maintained

### Teacher Login (if test teacher created)
- [ ] Navigate to `/teachers-login`
- [ ] Enter Teacher ID and password
- [ ] Login succeeds
- [ ] Redirected to teacher dashboard
- [ ] Session maintained

### Parent Login (if test parent created)
- [ ] Navigate to `/login` (parent login route)
- [ ] Enter email and password
- [ ] Login succeeds
- [ ] Can access parent dashboard

## ✅ Database Operations

- [ ] Creating user saves to database
- [ ] Updating user updates in database
- [ ] Deleting user removes from database
- [ ] Parent name saves for students
- [ ] Relationships work correctly (can query by role)

## ✅ Assets & Static Files

- [ ] CSS loads (page is styled)
- [ ] Images load (if any in public folder)
- [ ] Build directory exists at `public/build`
- [ ] All CSS classes work (.dark mode, Tailwind, etc.)

## ✅ Performance

- [ ] Page loads in under 3 seconds
- [ ] No 429 Too Many Requests errors
- [ ] Database queries are reasonable (check logs)

## ✅ Error Handling

- [ ] 404 page shows for invalid routes
- [ ] Form validation works (empty fields rejected)
- [ ] Helpful error messages display
- [ ] No raw PHP errors visible

## ✅ Security

- [ ] `APP_DEBUG=false` in production
- [ ] Passwords are hashed (verify in DB)
- [ ] CSRF tokens on forms
- [ ] Authentication enforced on admin routes
- [ ] No sensitive data in logs or visible to users

## ✅ Logs & Monitoring

- [ ] Application logs are writable (check `/storage/logs/`)
- [ ] View Vercel logs: `vercel logs --follow`
- [ ] Monitor Vercel dashboard for errors
- [ ] Check function duration (should be < 30s)

## 🐛 Common Issues & Solutions

### Issue: "502 Bad Gateway"
- [ ] Check Vercel function logs
- [ ] Verify database connection
- [ ] Ensure all migrations ran

### Issue: "Table doesn't exist"
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Or use deployment endpoint if configured

### Issue: "Blank page loading"
- [ ] Check browser console for errors
- [ ] Verify APP_KEY is set
- [ ] Check Vercel Function logs

### Issue: "Login not working"
- [ ] Verify database connection
- [ ] Check admin user exists in DB
- [ ] Verify password is hashed
- [ ] Clear browser cookies

### Issue: "Assets not loading (no CSS)"
- [ ] Check `public/build` folder exists
- [ ] Verify build command ran successfully
- [ ] Check `VITE_API_BASE_URL` environment variable

## 📞 Next Steps After Verification

1. **Monitor**: Watch Vercel dashboard for 24-48 hours
2. **Backup**: Set up automated database backups
3. **Domain**: Set up custom domain (optional)
4. **Email**: Configure email service for password resets
5. **Users**: Start creating actual users in admin panel
6. **Security**: Review security settings and configurations

## 📊 Performance Optimization (After Verification)

- [ ] Enable query caching
- [ ] Set up Redis for sessions/cache (optional)
- [ ] Configure S3 for file uploads (if needed)
- [ ] Enable HTTP/2 Server Push (automatic on Vercel)
- [ ] Set up CDN for static assets (automatic on Vercel)

## ✨ Success!

If all checkboxes above are checked, your BrightStar application is successfully deployed to Vercel! 🎉

**Congratulations on going live!**

---

### Support Resources

- **Vercel Logs**: `vercel logs --follow`
- **Database Check**: `mysql -h <host> -u <user> -p <db> -e "SHOW TABLES;"`
- **Laravel Tinker**: `php artisan tinker` (after connecting to production)
- **Documentation**: See `DEPLOYMENT_GUIDE.md`

### Questions?

Check the deployment guide or Vercel documentation for answers to common questions.
