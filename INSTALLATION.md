# Installation and Setup Guide

## Quick Start Guide

This guide will help you set up the Outsinc AllInOne User Account Management System.

## Prerequisites Check

Before you begin, ensure you have:

- [ ] PHP 8.0 or higher installed
- [ ] MySQL 5.7 or higher installed
- [ ] Web server (Apache or Nginx)
- [ ] phpMyAdmin (optional but recommended)

### Check PHP Version
```bash
php -v
```

### Check MySQL Version
```bash
mysql --version
```

## Step-by-Step Installation

### 1. Database Setup

#### Option A: Using phpMyAdmin (Recommended)

1. Open phpMyAdmin in your browser (usually `http://localhost/phpmyadmin`)
2. Click on "Import" tab
3. Click "Choose File" and select `database.sql` from the project root
4. Click "Go" to import
5. You should see "Import has been successfully finished"

#### Option B: Using Command Line

```bash
# Login to MySQL
mysql -u root -p

# Run the database script
source /path/to/project/database.sql

# Verify the database was created
SHOW DATABASES;
USE outsinc_allinone;
SHOW TABLES;
```

### 2. Configure Database Connection

1. Open `config/db.php` in a text editor
2. Update the database credentials:

```php
define('DB_HOST', 'localhost');     // Usually localhost
define('DB_USER', 'root');          // Your MySQL username
define('DB_PASS', '');              // Your MySQL password
define('DB_NAME', 'outsinc_allinone');
```

### 3. Web Server Configuration

#### For Apache with XAMPP/WAMP

1. Copy project folder to `htdocs` directory:
   - XAMPP: `C:\xampp\htdocs\outsinc-allinone`
   - WAMP: `C:\wamp64\www\outsinc-allinone`

2. Start Apache and MySQL from XAMPP/WAMP control panel

3. Access the application:
   - URL: `http://localhost/outsinc-allinone`

#### For Nginx

1. Copy project to web root (e.g., `/var/www/html/outsinc-allinone`)

2. Create Nginx configuration:

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/outsinc-allinone;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

3. Restart Nginx:
```bash
sudo systemctl restart nginx
```

### 4. File Permissions (Linux/Mac)

```bash
cd /path/to/project
chmod -R 755 .
chmod -R 777 tmp/ # If you have a tmp directory
```

### 5. Test the Installation

1. Open your browser and navigate to:
   - `http://localhost/outsinc-allinone` (for XAMPP/WAMP)
   - or your configured domain

2. You should be redirected to the login page

3. **Default Admin Login:**
   - Username: `admin`
   - Password: `admin123`

⚠️ **IMPORTANT**: Change the default admin password immediately after first login!

## Verification Steps

### Test Client Registration Flow

1. Navigate to registration page
2. Create a test client account
3. Login as admin
4. Go to "Manage Users"
5. Approve the test client account
6. Logout and login with client credentials

### Test Staff/Admin Account Creation

1. Login as admin
2. Go to "Create Staff/Admin Account"
3. Create a test staff account
4. Logout and login with staff credentials
5. Verify instant activation

## Common Issues and Solutions

### Issue: Database Connection Error

**Solution:**
- Verify MySQL is running
- Check database credentials in `config/db.php`
- Ensure database `outsinc_allinone` exists
- Test MySQL connection:
  ```bash
  mysql -u root -p
  USE outsinc_allinone;
  ```

### Issue: Blank Page or PHP Errors

**Solution:**
- Enable error reporting (for development only):
  ```php
  // Add to top of PHP files temporarily
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```
- Check PHP error log
- Verify PHP version is 8.0+

### Issue: Session Not Working

**Solution:**
- Ensure session directory is writable:
  ```bash
  chmod 777 /tmp
  ```
- Check PHP session configuration in `php.ini`

### Issue: Styles Not Loading

**Solution:**
- Verify the CSS file exists: `css/style.css`
- Check web server configuration for static files
- Clear browser cache

## Security Recommendations

### For Production Deployment

1. **Change Default Admin Password**
   - Login as admin
   - Navigate to user management
   - Update admin password

2. **Update Database Password**
   - Use a strong database password
   - Update `config/db.php` accordingly

3. **Enable HTTPS**
   - Obtain SSL certificate
   - Update session settings in `includes/session.php`:
     ```php
     ini_set('session.cookie_secure', 1); // Change to 1
     ```

4. **Disable Error Display**
   ```php
   // In production
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

5. **Regular Backups**
   ```bash
   # Backup database
   mysqldump -u root -p outsinc_allinone > backup_$(date +%Y%m%d).sql
   ```

## Testing Checklist

- [ ] Database created successfully
- [ ] Admin login works
- [ ] Client registration works
- [ ] Client approval workflow works
- [ ] Staff/Admin account creation works
- [ ] Logout functionality works
- [ ] Session management works
- [ ] All pages load correctly
- [ ] Styles are applied correctly

## Need Help?

If you encounter issues:

1. Check the error logs:
   - PHP error log
   - MySQL error log
   - Web server error log

2. Verify all prerequisites are met

3. Review this installation guide step by step

## Next Steps

After successful installation:

1. Change default admin password
2. Create additional admin/staff accounts
3. Configure email settings (future enhancement)
4. Customize branding and styles
5. Add additional features as needed

---

**Installation Complete!** 🎉

Your user account management system is now ready to use.
