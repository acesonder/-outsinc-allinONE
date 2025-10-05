<?php
/**
 * Index Page
 * 
 * Redirects to login page or dashboard based on session
 */

require_once 'includes/session.php';

startSecureSession();

// Check if user is already logged in
if (validateSession()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}

exit();
?>
