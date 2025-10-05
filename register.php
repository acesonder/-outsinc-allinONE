<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration - Outsinc AllInOne</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Client Registration</h1>
        
        <?php
        require_once 'config/db.php';
        
        $success = '';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $fullName = trim($_POST['full_name'] ?? '');
            
            // Validation
            if (empty($username) || empty($email) || empty($password) || empty($fullName)) {
                $error = 'All fields are required.';
            } elseif (strlen($username) < 3) {
                $error = 'Username must be at least 3 characters long.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email address.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } else {
                // Check if username or email already exists
                $conn = getDBConnection();
                
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $error = 'Username or email already exists.';
                } else {
                    // Hash password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Insert new user with pending status
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, 'client', 'pending')");
                    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $fullName);
                    
                    if ($stmt->execute()) {
                        $success = 'Registration successful! Your account is pending approval by staff/admin.';
                    } else {
                        $error = 'Registration failed. Please try again.';
                    }
                }
                
                $stmt->close();
                closeDBConnection($conn);
            }
        }
        ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
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
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <div class="text-center mt-20">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
