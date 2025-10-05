# Quick Reference Guide

## Default Credentials

**Admin Account:**
- Username: `admin`
- Password: `admin123`
- ⚠️ **Change this password immediately after first login!**

## Page URLs

| Page | URL | Access |
|------|-----|--------|
| Home | `/index.php` | Public |
| Login | `/login.php` | Public |
| Client Registration | `/register.php` | Public |
| Dashboard | `/dashboard.php` | Authenticated users |
| Manage Users | `/manage_users.php` | Staff/Admin only |
| Create Account | `/create_account.php` | Staff/Admin only |
| Logout | `/logout.php` | Authenticated users |
| Health Check | `/health_check.php` | Public |

## User Roles

| Role | Description | Permissions |
|------|-------------|-------------|
| **Client** | Regular user | Access dashboard after approval |
| **Staff** | Support personnel | Approve clients, create staff accounts |
| **Admin** | Administrator | Full access, create admin accounts |

## User Status

| Status | Description | Can Login? |
|--------|-------------|------------|
| **Pending** | Awaiting approval | ❌ No |
| **Active** | Approved account | ✅ Yes |
| **Inactive** | Deactivated | ❌ No |

## Common Tasks

### Register New Client
1. Go to `/register.php`
2. Fill in required fields
3. Wait for staff/admin approval
4. Login after approval

### Approve Client Registration (Staff/Admin)
1. Login as staff or admin
2. Go to "Manage Users"
3. Find pending user
4. Click "Approve"

### Create Staff Account (Admin/Staff)
1. Login as admin or staff
2. Go to "Create Staff/Admin Account"
3. Fill in form
4. Select "Staff" role
5. Submit - account is instantly active

### Create Admin Account (Admin Only)
1. Login as admin
2. Go to "Create Staff/Admin Account"
3. Fill in form
4. Select "Admin" role
5. Submit - account is instantly active

### Deactivate User (Admin)
1. Login as admin
2. Go to "Manage Users"
3. Find active user
4. Click "Deactivate"

## Password Requirements

- Minimum 6 characters (8+ recommended)
- Must match confirmation field
- Case-sensitive
- Can include letters, numbers, special characters

## Database Tables

### users
- Stores all user accounts
- Primary key: `id`
- Unique fields: `username`, `email`

### user_sessions
- Stores active sessions
- Links to users table
- Expires after 24 hours

## Directory Structure

```
/
├── config/          - Configuration files
├── includes/        - PHP helper functions
├── css/             - Stylesheets
├── js/              - JavaScript files
├── *.php            - Page files
└── *.md             - Documentation
```

## Security Features

✅ Password hashing (bcrypt)
✅ SQL injection prevention (prepared statements)
✅ XSS protection (output escaping)
✅ Session token management
✅ Role-based access control
✅ Session expiration (24 hours)

## Troubleshooting

### Cannot login
- Check username/password
- Verify account is approved (for clients)
- Check account is active
- Clear browser cookies

### Registration fails
- Ensure all fields are filled
- Check username/email is unique
- Verify password meets requirements
- Passwords must match

### Database connection error
- Verify MySQL is running
- Check credentials in `config/db.php`
- Run `database.sql` to create tables
- Test with `health_check.php`

### Session not working
- Clear browser cookies
- Check session directory is writable
- Verify PHP session is enabled

## File Locations

| File | Purpose |
|------|---------|
| `config/db.php` | Database configuration |
| `includes/session.php` | Session management |
| `database.sql` | Database schema |
| `health_check.php` | System verification |

## Important Notes

⚠️ **Security:**
- Always use HTTPS in production
- Change default admin password
- Keep PHP and MySQL updated
- Regular database backups

⚠️ **Development:**
- Enable error reporting for debugging
- Disable in production
- Check error logs regularly

⚠️ **Maintenance:**
- Clean expired sessions periodically
- Monitor database size
- Review user accounts regularly

## Support Files

- `README.md` - Complete documentation
- `INSTALLATION.md` - Setup instructions
- `TESTING.md` - Testing procedures
- `ARCHITECTURE.md` - System design
- `API.md` - Future API specs

## Database Connection

Default configuration (`config/db.php`):
```php
DB_HOST: localhost
DB_USER: root
DB_PASS: (empty)
DB_NAME: outsinc_allinone
```

Update these values for your environment.

## Session Configuration

Default settings (`includes/session.php`):
- Session duration: 24 hours
- Cookie HttpOnly: Enabled
- Cookie Secure: Disabled (enable for HTTPS)

## Next Steps After Installation

1. ✅ Run health check
2. ✅ Login as admin
3. ✅ Change admin password
4. ✅ Create staff accounts
5. ✅ Test client registration
6. ✅ Configure for production

## Version Information

- PHP: 8.0+ required
- MySQL: 5.7+ required
- Technology: HTML5, CSS3, JavaScript ES6+

---

For detailed information, refer to:
- Installation: `INSTALLATION.md`
- Testing: `TESTING.md`
- Architecture: `ARCHITECTURE.md`
