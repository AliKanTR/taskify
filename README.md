# Taskify - Task App

This document explains how to set up and deploy Taskify application.

---

## 1. Requirements

Make sure the following are installed:

- PHP >= 8.1
- Composer
- NodeJS
- MySQL or MariaDB
- Web Server (Apache or Nginx)
- Git (optional)

---

## 2. Clone the Project

```bash
git clone https://github.com/your-repository.git
cd your-repository
```

---

## 3. Install Dependencies

```bash
composer install
npm install
npm run build
```

---

## 4. Configure Environment

Copy the `.env.example` file:

```bash
cp .env.example .env
```

Update the database values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Generate the application key:

```bash
php artisan key:generate
```

---

## 5. Run Migrations

```bash
php artisan migrate
```

---

## 6. Set File Permissions (Linux)

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 7. Serve the Application

### Development

```bash
php artisan serve
```

Open in browser:  
`http://127.0.0.1:8000`

### Production

Point your web server document root to the `public/` directory of the project.

---

## 8. Production Environment Settings

In `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

Then run:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Done

Your application should now be up and running.
