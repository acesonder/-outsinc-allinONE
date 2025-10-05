# Testing Guide

This document provides comprehensive testing procedures for the Outsinc AllInOne User Account Management System.

## Pre-Testing Setup

Before running tests, ensure:
1. Database is set up correctly (run `database.sql`)
2. Web server is running (Apache/Nginx)
3. PHP 8.0+ is installed
4. MySQL is running

## Health Check

Run the health check script first:

```
http://localhost/outsinc-allinone/health_check.php
```

Verify all critical checks pass before proceeding.

## Manual Testing Procedures

### 1. Client Registration Flow

**Objective:** Test that clients can register and their accounts are pending approval

**Steps:**
1. Navigate to `http://localhost/outsinc-allinone/register.php`
2. Fill in registration form:
   - Username: `testclient1`
   - Email: `client1@test.com`
   - Full Name: `Test Client One`
   - Password: `password123`
   - Confirm Password: `password123`
3. Click "Register"

**Expected Result:**
- ✓ Success message: "Registration successful! Your account is pending approval..."
- ✓ User record created in database with status='pending'
- ✓ Form validation works (try submitting with mismatched passwords)

**Database Verification:**
```sql
SELECT * FROM users WHERE username = 'testclient1';
-- Should show: status='pending', role='client'
```

### 2. Admin Login

**Objective:** Test admin can login successfully

**Steps:**
1. Navigate to `http://localhost/outsinc-allinone/login.php`
2. Enter credentials:
   - Username: `admin`
   - Password: `admin123`
3. Click "Login"

**Expected Result:**
- ✓ Redirected to dashboard
- ✓ Welcome message shows admin name
- ✓ Navigation shows "Manage Users" and "Create Staff/Admin Account"
- ✓ Session is created in user_sessions table

**Database Verification:**
```sql
SELECT * FROM user_sessions WHERE user_id = 1 ORDER BY created_at DESC LIMIT 1;
-- Should show active session
```

### 3. Client Approval Workflow

**Objective:** Test that staff/admin can approve pending client registrations

**Steps:**
1. While logged in as admin, navigate to "Manage Users"
2. Find the pending user `testclient1`
3. Click "Approve" button

**Expected Result:**
- ✓ Success message: "User approved successfully!"
- ✓ User status changes from 'pending' to 'active'
- ✓ Approval timestamp and approver recorded

**Database Verification:**
```sql
SELECT status, approved_by, approved_at FROM users WHERE username = 'testclient1';
-- Should show: status='active', approved_by=1 (admin's id), approved_at=timestamp
```

### 4. Client Login After Approval

**Objective:** Test that approved client can login

**Steps:**
1. Logout from admin account
2. Navigate to login page
3. Enter client credentials:
   - Username: `testclient1`
   - Password: `password123`
4. Click "Login"

**Expected Result:**
- ✓ Successfully logged in
- ✓ Redirected to dashboard
- ✓ Dashboard shows client information
- ✓ No admin/staff menu items visible

### 5. Client Login Before Approval (Negative Test)

**Objective:** Test that pending clients cannot login

**Steps:**
1. Register another client: `testclient2`
2. Try to login before approval

**Expected Result:**
- ✗ Login fails
- ✓ Error message: "Your account is pending approval..."
- ✗ Should not create session
- ✗ Should not access dashboard

### 6. Staff Account Creation

**Objective:** Test instant staff account creation

**Steps:**
1. Login as admin
2. Navigate to "Create Staff/Admin Account"
3. Fill in form:
   - Username: `staffuser1`
   - Email: `staff1@test.com`
   - Full Name: `Staff User One`
   - Role: `staff`
   - Password: `password123`
   - Confirm Password: `password123`
4. Click "Create Account"

**Expected Result:**
- ✓ Success message showing instant activation
- ✓ Account created with status='active'
- ✓ No approval needed

**Database Verification:**
```sql
SELECT username, role, status, approved_by FROM users WHERE username = 'staffuser1';
-- Should show: role='staff', status='active', approved_by=1 (admin's id)
```

### 7. Staff Login and Permissions

**Objective:** Test staff account has correct permissions

**Steps:**
1. Logout from admin
2. Login as staff:
   - Username: `staffuser1`
   - Password: `password123`
3. Explore available features

**Expected Result:**
- ✓ Can access "Manage Users"
- ✓ Can approve/reject client registrations
- ✓ Can create staff accounts
- ✗ Cannot create admin accounts (only see staff option in dropdown)

### 8. Admin Account Creation

**Objective:** Test that only admins can create admin accounts

**Steps:**
1. Login as admin
2. Navigate to "Create Staff/Admin Account"
3. Create admin account:
   - Username: `admin2`
   - Email: `admin2@test.com`
   - Full Name: `Admin User Two`
   - Role: `admin`
   - Password: `password123`
4. Try same as staff user

**Expected Result:**
- ✓ Admin can create admin accounts
- ✓ Admin role visible in dropdown for admin
- ✗ Staff cannot see admin role option
- ✓ Validation prevents staff from creating admins

### 9. Session Management

**Objective:** Test secure session handling

**Steps:**
1. Login as any user
2. Copy session cookie value
3. Logout
4. Try to access dashboard directly
5. Try to manually set cookie

**Expected Result:**
- ✓ Logout destroys session
- ✓ After logout, redirected to login page
- ✓ Cannot access dashboard without valid session
- ✓ Session expires after 24 hours

### 10. User Deactivation

**Objective:** Test that admin can deactivate users

**Steps:**
1. Login as admin
2. Go to "Manage Users"
3. Find an active user
4. Click "Deactivate"
5. Logout and try to login as deactivated user

**Expected Result:**
- ✓ User status changes to 'inactive'
- ✗ Deactivated user cannot login
- ✓ Error message shown for inactive account

### 11. Client Rejection

**Objective:** Test rejecting pending registrations

**Steps:**
1. Register new client: `testclient3`
2. Login as admin
3. Go to "Manage Users"
4. Click "Reject" on pending user
5. Confirm deletion

**Expected Result:**
- ✓ Confirmation dialog appears
- ✓ User record completely deleted
- ✗ User cannot login
- ✗ User not visible in user list

### 12. Form Validation

**Objective:** Test all form validations work

**Registration Page Tests:**
- ✗ Empty fields should show error
- ✗ Username < 3 characters should fail
- ✗ Invalid email format should fail
- ✗ Password < 6 characters should fail
- ✗ Mismatched passwords should fail
- ✗ Duplicate username should fail
- ✗ Duplicate email should fail

**Login Page Tests:**
- ✗ Empty credentials should fail
- ✗ Invalid credentials should fail
- ✓ Valid credentials should succeed

### 13. JavaScript Enhancements

**Objective:** Test JavaScript features work

**Steps:**
1. Go to registration page
2. Enter password in both fields (different values)
3. Observe password matching indicator
4. Submit form with weak password

**Expected Result:**
- ✓ Confirm password field turns red when not matching
- ✓ Confirm password field turns green when matching
- ✓ Alert dismisses after 5 seconds
- ✓ Weak password shows confirmation dialog

### 14. Cross-Browser Testing

**Browsers to Test:**
- Chrome/Chromium
- Firefox
- Safari (if available)
- Edge

**Verify:**
- ✓ Styles render correctly
- ✓ Forms work properly
- ✓ Session handling works
- ✓ JavaScript functions work

### 15. Security Testing

**SQL Injection Tests:**
```
Username: admin' OR '1'='1
Password: anything
```
**Expected:** ✗ Login should fail (prepared statements prevent injection)

**XSS Tests:**
```
Username: <script>alert('XSS')</script>
Full Name: <img src=x onerror=alert('XSS')>
```
**Expected:** ✓ HTML is escaped and displayed as text

**Session Hijacking Test:**
- Copy session cookie from one browser
- Try to use in different browser
**Expected:** ✓ Session validates user_agent and IP

## Test Coverage Checklist

### Authentication
- [x] Admin can login
- [x] Staff can login
- [x] Approved client can login
- [x] Pending client cannot login
- [x] Inactive user cannot login
- [x] Invalid credentials rejected
- [x] Logout works correctly

### Registration
- [x] Client registration creates pending account
- [x] Form validation works
- [x] Duplicate prevention works
- [x] Password requirements enforced

### User Management
- [x] Admin can approve clients
- [x] Admin can reject clients
- [x] Admin can deactivate users
- [x] Staff can approve clients
- [x] Staff can reject clients

### Account Creation
- [x] Admin can create staff accounts
- [x] Admin can create admin accounts
- [x] Staff can create staff accounts
- [x] Staff cannot create admin accounts
- [x] Instant activation works

### Session Management
- [x] Session created on login
- [x] Session destroyed on logout
- [x] Session validates correctly
- [x] Session expires after timeout

### Security
- [x] Passwords are hashed
- [x] SQL injection prevented
- [x] XSS prevented
- [x] CSRF tokens (to be added)
- [x] Session hijacking prevented

## Automated Testing (Future)

For future implementation, consider:

### PHPUnit Tests
```php
// tests/AuthenticationTest.php
class AuthenticationTest extends TestCase {
    public function testAdminCanLogin() { }
    public function testPendingClientCannotLogin() { }
    public function testInvalidCredentialsRejected() { }
}
```

### Selenium Tests
```javascript
// tests/e2e/registration.test.js
describe('Client Registration', () => {
    it('should allow client to register', () => {
        // Selenium WebDriver code
    });
});
```

## Bug Reporting

If you find bugs during testing, report them with:
1. Steps to reproduce
2. Expected behavior
3. Actual behavior
4. Screenshots (if applicable)
5. Browser/environment details

## Performance Testing

### Load Testing
- Test with 100+ concurrent users
- Monitor database connection pool
- Check session table cleanup
- Monitor memory usage

### Recommended Tools
- Apache JMeter for load testing
- Chrome DevTools for performance profiling
- MySQL slow query log

## Conclusion

Complete all manual tests before deploying to production. Automated tests should be added for continuous integration in future iterations.
