# BrightStar Installation Guide

## Windows Installation

### Prerequisites
- Windows 10 or later
- Administrator privileges
- Internet connection

### Automatic Installation

1. **Download the installer**: `install-windows.bat`
2. **Right-click and select "Run as Administrator"**
3. **Follow the on-screen prompts**

The installer will automatically:
- ✅ Check for required dependencies
- ✅ Clone the repository
- ✅ Install PHP dependencies
- ✅ Install Node.js dependencies
- ✅ Generate application key
- ✅ Set up database

### Manual Installation

If automatic installation fails:

```bash
# 1. Install prerequisites from:
# - Git: https://git-scm.com/download/win
# - PHP: https://www.php.net/downloads
# - Composer: https://getcomposer.org/download/
# - Node.js: https://nodejs.org/

# 2. Clone the repository
git clone https://github.com/Lejeunext14/brighstar.git
cd brighstar

# 3. Install dependencies
composer install
npm install

# 4. Generate key
php artisan key:generate

# 5. Run migrations
php artisan migrate

# 6. Start development servers
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev

# 7. Open http://localhost:8000
```

### Troubleshooting Windows

**PHP not found:**
- Install from https://www.php.net/downloads
- Add PHP to system PATH

**Composer not found:**
- Install from https://getcomposer.org/download/
- Add to system PATH

**Port 8000 already in use:**
```bash
php artisan serve --port=8001
```

---

## Android Installation

### Prerequisites
- Android Studio (latest)
- Android SDK (API 21+)
- Node.js & npm
- Java JDK 11+
- 2GB free disk space

### Automatic Installation (Linux/Mac)

1. **Make script executable:**
   ```bash
   chmod +x install-android.sh
   ```

2. **Run the installer:**
   ```bash
   ./install-android.sh
   ```

3. **Follow the on-screen prompts**

### Manual Installation (Windows/Mac/Linux)

```bash
# 1. Install Node dependencies
npm install

# 2. Install Capacitor globally
npm install -g @capacitor/cli @capacitor/core

# 3. Build web assets
npm run build

# 4. Initialize Capacitor
npx cap init brighstar com.brighstar.app

# 5. Add Android platform
npx cap add android

# 6. Open Android Studio
npx cap open android

# 7. Build and run in Android Studio
```

### Build APK for Distribution

```bash
# 1. In Android Studio:
# - Build → Generate Signed Bundle/APK
# - Select APK
# - Create new keystore or use existing
# - Fill in signing information
# - Select Release build type

# 2. APK will be created in:
# app/release/app-release.apk

# 3. Install on device:
adb install app/release/app-release.apk
```

### Development Workflow

**For live development:**

Terminal 1 (Backend):
```bash
php artisan serve
```

Terminal 2 (Frontend):
```bash
npm run dev
```

Terminal 3 (Sync to Android):
```bash
npx cap sync
```

Then open Android Studio and run on emulator or device.

### Troubleshooting Android

**Android SDK not found:**
- Open Android Studio
- Go to Settings → SDK Manager
- Install required Android SDK versions

**Gradle build failed:**
```bash
cd android
./gradlew clean
./gradlew build
cd ..
```

**Capacitor sync issues:**
```bash
npx cap sync android
npx cap build android
```

---

## Login Credentials

After installation, use these to login:

**Admin Account:**
- Email: `admin@gmail.com`
- Password: `Admin123`

**Role:** Admin

---

## Default Database

The installation creates a SQLite database by default.

To switch to MySQL:
1. Update `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=brighstar
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. Create database:
   ```bash
   mysql -u root -e "CREATE DATABASE brighstar;"
   ```

3. Run migrations:
   ```bash
   php artisan migrate
   ```

---

## Features Included

✅ Multi-role authentication (Admin, Teacher, Student, Parent)  
✅ User management dashboard  
✅ Student ID login system  
✅ Teacher ID login system  
✅ Parent relationship management  
✅ Lesson progress tracking  
✅ Admin analytics & reporting  
✅ Dark mode support  
✅ Responsive design  
✅ Mobile-friendly interface  

---

## Next Steps

1. **For Web Development:**
   - Use any modern browser at `http://localhost:8000`
   - Edit files in your editor
   - Changes auto-reload with Vite

2. **For Mobile Development:**
   - Test on Android emulator or device
   - Use Chrome DevTools to debug: `chrome://inspect`

3. **For Production:**
   - See deployment guides in root directory
   - Consider paid hosting for reliability

---

## Support

For issues or questions:
- Check the repository: https://github.com/Lejeunext14/brighstar
- Review error logs in `storage/logs/`
- Test on a fresh installation

---

**Installation Version:** 1.0  
**Last Updated:** 2026-01-22  
**Status:** ✅ Ready to use
