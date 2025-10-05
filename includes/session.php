<?php
/**
 * Session Management Functions
 * 
 * Handles secure session creation, validation, and destruction
 */

require_once __DIR__ . '/../config/db.php';

// Start secure session
function startSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        // Configure secure session parameters
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
        
        session_start();
    }
}

// Create user session in database
function createUserSession($userId) {
    $conn = getDBConnection();
    
    // Generate secure session token
    $sessionToken = bin2hex(random_bytes(32));
    
    // Get client information
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Set session expiry (24 hours)
    $expiresAt = date('Y-m-d H:i:s', time() + 86400);
    
    $stmt = $conn->prepare("INSERT INTO user_sessions (user_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $userId, $sessionToken, $ipAddress, $userAgent, $expiresAt);
    $stmt->execute();
    $stmt->close();
    
    closeDBConnection($conn);
    
    return $sessionToken;
}

// Validate session
function validateSession() {
    startSecureSession();
    
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
        return false;
    }
    
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT user_id FROM user_sessions WHERE user_id = ? AND session_token = ? AND expires_at > NOW()");
    $stmt->bind_param("is", $_SESSION['user_id'], $_SESSION['session_token']);
    $stmt->execute();
    $result = $stmt->get_result();
    $isValid = $result->num_rows > 0;
    
    $stmt->close();
    closeDBConnection($conn);
    
    return $isValid;
}

// Get current user information
function getCurrentUser() {
    if (!validateSession()) {
        return null;
    }
    
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, username, email, full_name, role, status FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $stmt->close();
    closeDBConnection($conn);
    
    return $user;
}

// Destroy session
function destroyUserSession() {
    startSecureSession();
    
    if (isset($_SESSION['session_token'])) {
        $conn = getDBConnection();
        
        $stmt = $conn->prepare("DELETE FROM user_sessions WHERE session_token = ?");
        $stmt->bind_param("s", $_SESSION['session_token']);
        $stmt->execute();
        $stmt->close();
        
        closeDBConnection($conn);
    }
    
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}

// Check if user has required role
function requireRole($allowedRoles) {
    $user = getCurrentUser();
    
    if (!$user || !in_array($user['role'], $allowedRoles)) {
        header('Location: /login.php');
        exit();
    }
    
    return $user;
}
?>
