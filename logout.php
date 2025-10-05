<?php
/**
 * Logout Page
 * 
 * Destroys user session and redirects to login page
 */

require_once 'includes/session.php';

startSecureSession();

// Destroy the session
destroyUserSession();

// Redirect to login page
header('Location: login.php');
exit();
?>
