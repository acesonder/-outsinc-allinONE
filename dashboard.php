<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Outsinc AllInOne</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    require_once 'includes/session.php';
    
    startSecureSession();
    
    // Validate session
    $user = getCurrentUser();
    if (!$user) {
        header('Location: login.php');
        exit();
    }
    ?>
    
    <div class="dashboard-container">
        <div class="header">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
            </div>
            <div class="user-info">
                <strong>Role:</strong> <?php echo ucfirst($user['role']); ?> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>
        
        <div class="nav">
            <?php if (in_array($user['role'], ['admin', 'staff'])): ?>
                <a href="manage_users.php">Manage Users</a>
                <a href="create_account.php">Create Staff/Admin Account</a>
            <?php endif; ?>
        </div>
        
        <div class="content">
            <h2>Dashboard</h2>
            
            <div class="alert alert-info">
                <p><strong>Account Status:</strong> <?php echo ucfirst($user['status']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            
            <?php if ($user['role'] === 'client'): ?>
                <div class="alert alert-success">
                    <h3>Welcome to Outsinc AllInOne!</h3>
                    <p>Your client account is active. You can now access all client features.</p>
                </div>
            <?php endif; ?>
            
            <?php if (in_array($user['role'], ['admin', 'staff'])): ?>
                <div class="alert alert-warning">
                    <h3>Staff/Admin Features</h3>
                    <p>You have access to:</p>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>User Management - Approve/Reject client registrations</li>
                        <li>Account Creation - Create staff and admin accounts instantly</li>
                        <li>System Administration</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
