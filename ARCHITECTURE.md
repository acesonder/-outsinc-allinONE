# System Architecture

## Overview Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                      Client Browser                          │
│  ┌─────────────┐  ┌─────────────┐  ┌──────────────────┐   │
│  │   HTML5     │  │    CSS3     │  │  JavaScript ES6+ │   │
│  │  (Pages)    │  │  (Styling)  │  │  (Validation)    │   │
│  └─────────────┘  └─────────────┘  └──────────────────┘   │
└────────────────────────┬────────────────────────────────────┘
                         │ HTTP/HTTPS
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                     Web Server                               │
│                  (Apache / Nginx)                            │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                    PHP 8.x Backend                           │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Application Layer                        │  │
│  │  ┌─────────────────┐  ┌──────────────────────────┐  │  │
│  │  │  Page Controllers│  │   Business Logic        │  │  │
│  │  │  - index.php     │  │   - Session Management  │  │  │
│  │  │  - login.php     │  │   - User Authentication │  │  │
│  │  │  - register.php  │  │   - Role Authorization  │  │  │
│  │  │  - dashboard.php │  │   - Account Creation    │  │  │
│  │  │  - manage_users  │  │   - Approval Workflow   │  │  │
│  │  └─────────────────┘  └──────────────────────────┘  │  │
│  └──────────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Configuration Layer                      │  │
│  │  - config/db.php (Database config)                   │  │
│  │  - includes/session.php (Session handling)           │  │
│  └──────────────────────────────────────────────────────┘  │
└────────────────────────┬────────────────────────────────────┘
                         │ MySQLi
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                   MySQL Database                             │
│                  (via phpMyAdmin)                            │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Tables:                                             │  │
│  │  ┌─────────────┐         ┌──────────────────┐      │  │
│  │  │   users     │◄────────│  user_sessions   │      │  │
│  │  │             │  FK     │                  │      │  │
│  │  │ - id        │         │ - id             │      │  │
│  │  │ - username  │         │ - user_id (FK)   │      │  │
│  │  │ - email     │         │ - session_token  │      │  │
│  │  │ - password  │         │ - ip_address     │      │  │
│  │  │ - full_name │         │ - user_agent     │      │  │
│  │  │ - role      │         │ - created_at     │      │  │
│  │  │ - status    │         │ - expires_at     │      │  │
│  │  │ - created_at│         └──────────────────┘      │  │
│  │  │ - updated_at│                                   │  │
│  │  │ - approved_by│                                  │  │
│  │  │ - approved_at│                                  │  │
│  │  └─────────────┘                                   │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## User Roles and Permissions

```
┌────────────────────────────────────────────────────────────┐
│                    Role Hierarchy                           │
│                                                             │
│  ┌──────────────┐                                          │
│  │    ADMIN     │                                          │
│  │  (Full Access)                                          │
│  └──────┬───────┘                                          │
│         │ Can manage everything                            │
│         ▼                                                   │
│  ┌──────────────┐                                          │
│  │    STAFF     │                                          │
│  │  (Limited Admin)                                        │
│  └──────┬───────┘                                          │
│         │ Can approve users, create staff                  │
│         ▼                                                   │
│  ┌──────────────┐                                          │
│  │    CLIENT    │                                          │
│  │  (Basic User)                                           │
│  └──────────────┘                                          │
│         │ Regular user access                              │
│         ▼                                                   │
└────────────────────────────────────────────────────────────┘
```

## Authentication Flow

```
┌────────────┐
│   User     │
└──────┬─────┘
       │
       ▼
┌──────────────────┐
│  Login Page      │
│  (login.php)     │
└──────┬───────────┘
       │ Submit credentials
       ▼
┌──────────────────────────────────┐
│  Validate Credentials            │
│  - Check username/email          │
│  - Verify password hash          │
│  - Check account status          │
└──────┬───────────────────────────┘
       │
       ├──── Invalid ──────────────────┐
       │                               ▼
       │                    ┌──────────────────┐
       │                    │  Show Error      │
       │                    │  Return to Login │
       │                    └──────────────────┘
       │
       └──── Valid ───────────────────┐
                                      ▼
                          ┌────────────────────────┐
                          │  Check Account Status  │
                          └───────┬────────────────┘
                                  │
                     ┌────────────┼────────────┐
                     │            │            │
                  Pending      Inactive     Active
                     │            │            │
                     ▼            ▼            ▼
              ┌──────────┐ ┌──────────┐ ┌──────────────────┐
              │  Deny    │ │  Deny    │ │ Create Session   │
              │  Access  │ │  Access  │ │ - Generate Token │
              └──────────┘ └──────────┘ │ - Store in DB    │
                                        │ - Set SESSION    │
                                        └────────┬─────────┘
                                                 │
                                                 ▼
                                        ┌──────────────────┐
                                        │  Redirect to     │
                                        │  Dashboard       │
                                        └──────────────────┘
```

## Client Registration and Approval Workflow

```
┌──────────────┐
│ New Client   │
└──────┬───────┘
       │
       ▼
┌─────────────────────┐
│ Registration Form   │
│ (register.php)      │
└──────┬──────────────┘
       │ Submit form
       ▼
┌─────────────────────────────┐
│ Validate Input              │
│ - Check required fields     │
│ - Validate email format     │
│ - Check password strength   │
│ - Verify uniqueness         │
└──────┬──────────────────────┘
       │
       ├──── Invalid ─────────────────┐
       │                              ▼
       │                   ┌──────────────────┐
       │                   │  Show Errors     │
       │                   │  Return to Form  │
       │                   └──────────────────┘
       │
       └──── Valid ──────────────────┐
                                     ▼
                         ┌────────────────────────┐
                         │ Create User Account    │
                         │ - Hash password        │
                         │ - Set status='pending' │
                         │ - Set role='client'    │
                         └────────┬───────────────┘
                                  │
                                  ▼
                         ┌────────────────────────┐
                         │ Show Success Message   │
                         │ "Awaiting Approval"    │
                         └────────────────────────┘
                                  │
                                  │
      ┌───────────────────────────┴────────────────────────┐
      │                                                     │
      ▼                                                     │
┌──────────────┐                                          │
│ Staff/Admin  │                                          │
└──────┬───────┘                                          │
       │                                                   │
       ▼                                                   │
┌─────────────────────┐                                   │
│ Manage Users Page   │                                   │
│ (manage_users.php)  │                                   │
└──────┬──────────────┘                                   │
       │                                                   │
       ├──── Approve ─────┐                               │
       │                  ▼                               │
       │      ┌────────────────────────┐                  │
       │      │ Update User            │                  │
       │      │ - Set status='active'  │                  │
       │      │ - Set approved_by      │                  │
       │      │ - Set approved_at      │                  │
       │      └────────┬───────────────┘                  │
       │               │                                  │
       │               ▼                                  │
       │      ┌────────────────────────┐                  │
       │      │ Client Can Now Login   │                  │
       │      └────────────────────────┘                  │
       │                                                   │
       └──── Reject ──────┐                               │
                          ▼                               │
              ┌────────────────────────┐                  │
              │ Delete User Account    │                  │
              │ (Permanent)            │                  │
              └────────────────────────┘                  │
                                                          │
                                                          │
                          Client waits for approval ◄─────┘
```

## Staff/Admin Account Creation Flow

```
┌──────────────┐
│ Admin/Staff  │
└──────┬───────┘
       │
       ▼
┌─────────────────────────┐
│ Create Account Form     │
│ (create_account.php)    │
└──────┬──────────────────┘
       │ Submit form
       ▼
┌─────────────────────────────┐
│ Validate Input              │
│ - Check permissions         │
│ - Validate email format     │
│ - Check password strength   │
│ - Verify role permissions   │
└──────┬──────────────────────┘
       │
       ├──── Admin creating Admin ──┐
       │                            │
       ├──── Admin creating Staff ──┤
       │                            │
       ├──── Staff creating Staff ──┤
       │                            │
       └──── Staff creating Admin ──┘
                    │                └─── DENIED
                    │                     (Show Error)
                    │
                    ▼
         ┌────────────────────────┐
         │ Create User Account    │
         │ - Hash password        │
         │ - Set status='active'  │◄──── INSTANT ACTIVATION
         │ - Set approved_by      │
         │ - Set approved_at=NOW  │
         └────────┬───────────────┘
                  │
                  ▼
         ┌────────────────────────┐
         │ Account Ready          │
         │ Can Login Immediately  │
         └────────────────────────┘
```

## Session Management

```
┌─────────────────┐
│ Successful Login│
└────────┬────────┘
         │
         ▼
┌──────────────────────────────┐
│ Create Session               │
│ - Generate unique token      │
│ - Store user_id, token in DB │
│ - Store IP, User-Agent       │
│ - Set expiry (24 hours)      │
│ - Set PHP session variables  │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│ Each Request                 │
│ - Check session exists       │
│ - Validate session token     │
│ - Check expiry               │
│ - Verify IP/User-Agent       │
└────────┬─────────────────────┘
         │
         ├──── Valid ───────┐
         │                  ▼
         │         ┌──────────────────┐
         │         │ Allow Access     │
         │         │ Continue Request │
         │         └──────────────────┘
         │
         └──── Invalid ─────┐
                           ▼
                  ┌──────────────────┐
                  │ Redirect to Login│
                  │ Clear Session    │
                  └──────────────────┘
```

## Database Entity Relationship

```
┌─────────────────────┐
│       users         │
│─────────────────────│
│ PK  id (INT)        │
│ UQ  username        │
│ UQ  email           │
│     password (hash) │
│     full_name       │
│     role (ENUM)     │───┐
│     status (ENUM)   │   │
│     created_at      │   │
│     updated_at      │   │
│ FK  approved_by     │───┘ Self-referencing FK
│     approved_at     │
└──────────┬──────────┘
           │
           │ One-to-Many
           │
           ▼
┌─────────────────────┐
│   user_sessions     │
│─────────────────────│
│ PK  id (INT)        │
│ FK  user_id         │──────┐
│ UQ  session_token   │      │
│     ip_address      │      │
│     user_agent      │      │
│     created_at      │      │
│     expires_at      │      │
└─────────────────────┘      │
                             │
                             └──── References users(id)
```

## Security Layers

```
┌────────────────────────────────────────────────────────┐
│                   Security Stack                        │
├────────────────────────────────────────────────────────┤
│  Layer 1: Input Validation                             │
│  - Required field checks                               │
│  - Format validation (email, length)                   │
│  - Type validation                                     │
├────────────────────────────────────────────────────────┤
│  Layer 2: SQL Injection Prevention                     │
│  - Prepared statements (mysqli)                        │
│  - Parameterized queries                               │
│  - No direct SQL concatenation                         │
├────────────────────────────────────────────────────────┤
│  Layer 3: XSS Prevention                               │
│  - htmlspecialchars() on all output                    │
│  - Content Security Policy (recommended)               │
├────────────────────────────────────────────────────────┤
│  Layer 4: Password Security                            │
│  - bcrypt hashing (password_hash)                      │
│  - Minimum length requirements                         │
│  - Strength validation                                 │
├────────────────────────────────────────────────────────┤
│  Layer 5: Session Security                             │
│  - Secure session tokens (random_bytes)                │
│  - HttpOnly cookies                                    │
│  - Session expiration (24 hours)                       │
│  - IP & User-Agent validation                          │
├────────────────────────────────────────────────────────┤
│  Layer 6: Access Control                               │
│  - Role-based permissions                              │
│  - Status-based access (pending/active/inactive)       │
│  - Function-level authorization                        │
└────────────────────────────────────────────────────────┘
```

## Technology Stack Details

```
Frontend Layer:
├── HTML5
│   ├── Semantic markup
│   └── Form elements
├── CSS3
│   ├── Flexbox layout
│   ├── Gradients
│   ├── Transitions
│   └── Responsive design
└── JavaScript ES6+
    ├── Arrow functions
    ├── Template literals
    ├── Promises
    ├── Modules (export/import)
    └── Event listeners

Backend Layer:
└── PHP 8.x
    ├── Object-Oriented features
    ├── Type declarations
    ├── Error handling
    └── Security functions

Database Layer:
└── MySQL
    ├── InnoDB engine
    ├── Foreign keys
    ├── Indexes
    ├── Triggers (future)
    └── Stored procedures (future)

Tools:
└── phpMyAdmin
    ├── Database management
    ├── Query execution
    └── Import/Export
```

## File Organization

```
Project Root
│
├── config/              # Configuration files
│   └── db.php           # Database connection
│
├── includes/            # Reusable PHP modules
│   └── session.php      # Session management
│
├── css/                 # Stylesheets
│   └── style.css        # Main stylesheet
│
├── js/                  # JavaScript files
│   └── app.js           # Form validation & UI
│
├── Pages/               # (Root level)
│   ├── index.php        # Entry point
│   ├── login.php        # Login page
│   ├── register.php     # Client registration
│   ├── dashboard.php    # User dashboard
│   ├── manage_users.php # User management
│   ├── create_account.php # Staff/Admin creation
│   ├── logout.php       # Logout handler
│   └── health_check.php # System verification
│
├── Documentation/       # (Root level)
│   ├── README.md        # Main documentation
│   ├── INSTALLATION.md  # Setup guide
│   ├── TESTING.md       # Testing procedures
│   └── API.md           # Future API specs
│
└── database.sql         # Database schema
```

This architecture provides a solid foundation for a secure, role-based user account management system with clear separation of concerns and scalability for future enhancements.
