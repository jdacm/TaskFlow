# Deploy TaskFlow to Railway.app

Railway is free for small apps and handles Laravel deployments automatically.

## Prerequisites
- GitHub account
- Railway account (railway.app)

## Steps

### 1. Push to GitHub (if not done)
```bash
git push origin main
```

### 2. Create Railway Project
1. Go to https://railway.app
2. Click "New Project"
3. Choose "Deploy from GitHub repo"
4. Connect your GitHub account
5. Select the TaskFlow repository

### 3. Configure Environment
Railway will auto-detect Laravel and set up:
- PHP environment
- Database (PostgreSQL by default)

### 4. Set Environment Variables
In Railway dashboard > Variables, add:
```
APP_NAME=TaskFlow
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-railway-url.up.railway.app

DB_CONNECTION=pgsql
DB_HOST=containers-us-west-1.railway.app
DB_PORT=your-db-port
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your-db-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME=TaskFlow
```

### 5. Database Setup
1. Railway provides PostgreSQL automatically
2. Copy the DATABASE_URL from Railway variables
3. Run migrations: `php artisan migrate`

### 6. Generate App Key
```bash
php artisan key:generate
```
Copy the generated key to APP_KEY variable.

### 7. Deploy
Railway deploys automatically on push. Or click "Deploy" manually.

## Alternative: Render.com

If you prefer Render:

1. Go to https://render.com
2. New > Web Service
3. Connect GitHub repo
4. Choose "Static Site" for frontend, "Web Service" for Laravel
5. Set build command: `npm run build && composer install`
6. Set start command: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Notes
- SQLite won't work on Railway/Render (ephemeral file system)
- Use PostgreSQL or MySQL
- For production, set APP_DEBUG=false
- Update APP_URL to your deployment URL