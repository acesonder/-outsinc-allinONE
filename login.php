<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Outsinc AllInOne</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <?php
        require_once 'config/db.php';
        require_once 'includes/session.php';
        
        startSecureSession();
        
        // Redirect if already logged in
        if (validateSession()) {
            header('Location: dashboard.php');
            exit();
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $error = 'Username and password are required.';
            } else {
                $conn = getDBConnection();
                
                $stmt = $conn->prepare("SELECT id, username, password, role, status FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $username, $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 0) {
                    $error = 'Invalid username or password.';
                } else {
                    $user = $result->fetch_assoc();
                    
                    if (!password_verify($password, $user['password'])) {
                        $error = 'Invalid username or password.';
                    } elseif ($user['status'] !== 'active') {
                        if ($user['status'] === 'pending') {
                            $error = 'Your account is pending approval. Please wait for staff/admin approval.';
                        } else {
                            $error = 'Your account is inactive. Please contact administrator.';
                        }
                    } else {
                        // Create session
                        $sessionToken = createUserSession($user['id']);
                        
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['session_token'] = $sessionToken;
                        
                        header('Location: dashboard.php');
                        exit();
                    }
                }
                
                $stmt->close();
                closeDBConnection($conn);
            }
        }
        ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <div class="text-center mt-20">
            <p>Don't have an account? <a href="register.php">Register as Client</a></p>
        </div>
    </div>
</body>
</html>
