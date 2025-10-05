<?php
/**
 * Database Configuration
 * 
 * This file contains the database connection settings
 * Update these values according to your phpMyAdmin/MySQL setup
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'outsinc_allinone');

// Create database connection
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to utf8mb4
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        error_log("Database connection error: " . $e->getMessage());
        die("Database connection error. Please try again later.");
    }
}

// Close database connection
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>
