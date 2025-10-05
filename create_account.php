<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Outsinc AllInOne</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js" defer></script>
</head>
<body>
    <?php
    require_once 'includes/session.php';
    require_once 'config/db.php';
    
    startSecureSession();
    
    // Require admin or staff role
    $currentUser = requireRole(['admin', 'staff']);
    
    $success = '';
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        $role = $_POST['role'] ?? '';
        
        // Validation
        if (empty($username) || empty($email) || empty($password) || empty($fullName) || empty($role)) {
            $error = 'All fields are required.';
        } elseif (!in_array($role, ['staff', 'admin'])) {
            $error = 'Invalid role selected.';
        } elseif ($role === 'admin' && $currentUser['role'] !== 'admin') {
            $error = 'Only admins can create admin accounts.';
        } elseif (strlen($username) < 3) {
            $error = 'Username must be at least 3 characters long.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } else {
            $conn = getDBConnection();
            
            // Check if username or email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $error = 'Username or email already exists.';
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user with active status (instant activation)
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, role, status, approved_by, approved_at) VALUES (?, ?, ?, ?, ?, 'active', ?, NOW())");
                $stmt->bind_param("sssssi", $username, $email, $hashedPassword, $fullName, $role, $currentUser['id']);
                
                if ($stmt->execute()) {
                    $success = ucfirst($role) . ' account created successfully! The account is instantly active.';
                    // Clear form
                    $_POST = array();
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
            
            $stmt->close();
            closeDBConnection($conn);
        }
    }
    ?>
    
    <div class="container">
        <div class="header">
            <div>
                <h1>Create Staff/Admin Account</h1>
            </div>
            <div class="user-info">
                <a href="dashboard.php">← Back to Dashboard</a>
            </div>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="alert alert-info">
            <strong>Note:</strong> Staff and Admin accounts are instantly activated upon creation.
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="staff" <?php echo (isset($_POST['role']) && $_POST['role'] === 'staff') ? 'selected' : ''; ?>>Staff</option>
                    <?php if ($currentUser['role'] === 'admin'): ?>
                        <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>
</body>
</html>
