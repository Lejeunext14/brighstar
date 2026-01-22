# NLLC - Interactive E-Learning Platform for Kindergarten

## 📚 Project Description

NLLC (New Language Learning Center) is an interactive e-learning platform designed specifically for kindergarten children to learn, play, and grow at their own pace. The platform provides an engaging environment with games, activities, and progress tracking for students, parents, teachers, and administrators.

## ✨ Features

- **Interactive Learning Activities**: Games, coloring activities, and educational content
- **Student Dashboard**: Track progress and manage learning activities
- **Parent Dashboard**: Monitor child's progress and activity
- **Teacher Dashboard**: Manage classrooms and track student progress
- **Admin Dashboard**: Manage users, view reports, and system settings
- **Progress Tracking**: Detailed lesson progress and learning analytics
- **Two-Factor Authentication**: Enhanced security for user accounts
- **Phone Verification**: Student verification system
- **Role-Based Access Control**: Different interfaces for students, parents, teachers, and admins

## 🛠️ Prerequisites

Before running this project, ensure you have the following installed:

- **PHP**: 8.1 or higher
- **Composer**: Latest version
- **Node.js**: 16.0 or higher
- **npm** or **Yarn**: For managing JavaScript dependencies
- **MySQL**: 5.7 or higher
- **Git**: For version control

## 📋 Installation

Follow these steps to set up the project:

### 1. Clone the Repository
```bash
git clone <repository-url>
cd brighstar
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
# or
yarn install
```

### 4. Copy Environment File
```bash
cp .env.example .env
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Configure Database
Edit the `.env` file and update your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nllc
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations
```bash
php artisan migrate
```

### 8. Seed the Database (Optional)
```bash
php artisan db:seed
```

### 9. Build Frontend Assets
```bash
npm run build
# or for development with hot reload
npm run dev
```

## 🚀 Running the Project

### Development Server

Start the Laravel development server:
```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

In a separate terminal, start the asset compilation watcher:
```bash
npm run dev
```

### Production Build

For production deployment:
```bash
npm run build
php artisan optimize
```

## 🔐 Default Users

The project includes seeded admin and test users. Check the `AdminUserSeeder` for default credentials.

## 📁 Project Structure

```
brighstar/
├── app/
│   ├── Actions/          # Business logic actions
│   ├── Http/
│   │   ├── Controllers/  # Route handlers
│   │   └── Middleware/   # HTTP middleware
│   ├── Models/           # Database models
│   ├── Providers/        # Service providers
│   └── Listeners/        # Event listeners
├── resources/
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── views/           # Blade templates
├── database/
│   ├── migrations/      # Database migrations
│   ├── factories/       # Model factories
│   └── seeders/         # Database seeders
├── routes/              # Route definitions
├── config/              # Configuration files
├── public/              # Public assets
└── tests/               # Test files
```

## 🔧 Key Configuration Files

- **`.env`**: Environment variables and database configuration
- **`config/app.php`**: Application configuration
- **`config/database.php`**: Database connection settings
- **`config/session.php`**: Session configuration (database driver)
- **`config/fortify.php`**: Authentication configuration
- **`routes/web.php`**: Web routes
- **`routes/settings.php`**: Settings routes

## 🧪 Testing

Run tests using:
```bash
php artisan test
```

For specific test file:
```bash
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

## 🌐 Available Routes

### Public Routes
- `/` - Home/Welcome page
- `/admin-login` - Admin login
- `/teachers-login` - Teacher login
- `/parents-login` - Parent login
- `/login` - Student login

### Protected Routes (Require Authentication)
- `/dashboard` - Student dashboard
- `/teacher/dashboard` - Teacher dashboard
- `/admin/dashboard` - Admin dashboard
- `/parent/dashboard` - Parent dashboard
- `/settings/*` - User settings

## 🛡️ Security Features

- CSRF token protection on all forms
- Session-based authentication
- Password hashing with bcrypt
- Two-factor authentication support
- Phone verification system
- Role-based middleware protection

## 🐛 Troubleshooting

### "419 Page Expired" Error
- Ensure sessions table exists: `php artisan migrate`
- Clear cache: `php artisan cache:clear`
- Verify `SESSION_DRIVER=database` in `.env`

### Database Connection Issues
- Check MySQL is running
- Verify database credentials in `.env`
- Ensure database exists: `CREATE DATABASE nllc;`

### Assets Not Loading
- Run `npm run build`
- Clear browser cache
- Check `public/build` directory exists

### Permission Issues
- Ensure `storage/` and `bootstrap/cache/` are writable
- Run: `chmod -R 755 storage bootstrap/cache`

## 📚 Learning Subjects

Students can learn through various subjects:
- 🔢 Mathematics
- 📖 Reading
- 🎨 Art
- 🎵 Music
- 🌍 Science
- 🧩 Logic

## 📞 Support

For issues or questions, please refer to the project documentation or contact the development team.

## 📄 License

This project is proprietary and all rights are reserved.

## 🙏 Credits

Created with Laravel, Livewire, and Flux UI components for an engaging educational experience.

---

**Happy Learning! 🎉**
