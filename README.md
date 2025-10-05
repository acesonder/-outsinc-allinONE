# Outsinc AllInOne - User Account Management System

A comprehensive web application for managing user accounts with role-based access control.

> 📚 **[View Complete Documentation Index](DOC_INDEX.md)** - Navigate all documentation files

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 8.x
- **Database**: MySQL managed via phpMyAdmin

## Features

### Core Functional Requirements

1. **User Account Management**
   - **Clients**: Self-registration with pending staff/admin approval
   - **Staff & Admin**: Instant account creation by authorized users
   - **Secure login/logout** with session handling

### User Roles

- **Client**: Regular users who must register and wait for approval
- **Staff**: Can approve client registrations and create staff accounts
- **Admin**: Full access including ability to create admin accounts

## Installation

### Prerequisites

- PHP 8.x or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- phpMyAdmin (recommended for database management)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/acesonder/-outsinc-allinONE.git
   cd -outsinc-allinONE
   ```

2. **Configure the database**
   - Open phpMyAdmin
   - Import the `database.sql` file to create the database and tables
   - Or run the SQL script manually:
     ```bash
     mysql -u root -p < database.sql
     ```

3. **Update database configuration**
   - Edit `config/db.php`
   - Update the database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'outsinc_allinone');
     ```

4. **Configure web server**
   - Point your web server document root to the project directory
   - Ensure PHP is properly configured
   - Enable required PHP extensions: mysqli, session

5. **Access the application**
   - Open your browser and navigate to your configured URL
   - Default admin credentials:
     - Username: `admin`
     - Password: `admin123`
     - **Important**: Change the default admin password after first login!

## Usage

### For Clients

1. Navigate to the registration page (`register.php`)
2. Fill out the registration form
3. Wait for staff/admin approval
4. Once approved, login with your credentials

### For Staff/Admin

1. Login with your credentials
2. Access the dashboard to:
   - View pending client registrations
   - Approve or reject client accounts
   - Create new staff/admin accounts (instant activation)
   - Manage user accounts

## File Structure

```
-outsinc-allinONE/
├── config/
│   └── db.php              # Database configuration
├── includes/
│   └── session.php         # Session management functions
├── css/
│   └── style.css           # Application styles
├── database.sql            # Database schema
├── index.php               # Entry point
├── login.php               # Login page
├── register.php            # Client registration page
├── logout.php              # Logout handler
├── dashboard.php           # User dashboard
├── manage_users.php        # User management (staff/admin)
├── create_account.php      # Create staff/admin accounts
└── README.md               # This file
```

## Security Features

- Password hashing using PHP's `password_hash()`
- Session token management
- SQL injection prevention using prepared statements
- XSS protection using `htmlspecialchars()`
- Role-based access control
- Session expiration (24 hours)

## Database Schema

### Users Table

- `id`: Primary key
- `username`: Unique username
- `email`: Unique email address
- `password`: Hashed password
- `full_name`: User's full name
- `role`: User role (client, staff, admin)
- `status`: Account status (pending, active, inactive)
- `created_at`: Account creation timestamp
- `updated_at`: Last update timestamp
- `approved_by`: ID of user who approved the account
- `approved_at`: Approval timestamp

### User Sessions Table

- `id`: Primary key
- `user_id`: Foreign key to users table
- `session_token`: Unique session token
- `ip_address`: Client IP address
- `user_agent`: Client user agent
- `created_at`: Session creation timestamp
- `expires_at`: Session expiration timestamp

## Future Enhancements

- Password reset functionality
- Email verification
- Two-factor authentication
- Activity logging
- User profile management
- API endpoints for mobile apps

## License

This project is part of the Outsinc AllInOne system.
