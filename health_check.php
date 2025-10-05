<?php
/**
 * System Health Check
 * 
 * This script checks if the system is properly configured
 * Run this file to verify your installation
 */

// Disable error reporting initially
error_reporting(E_ALL);
ini_set('display_errors', 1);

$checks = [];
$allPassed = true;

// Check PHP version
$phpVersion = phpversion();
$checks['PHP Version'] = [
    'status' => version_compare($phpVersion, '8.0.0', '>='),
    'message' => "PHP version: $phpVersion (Required: 8.0+)",
    'critical' => true
];

// Check required extensions
$requiredExtensions = ['mysqli', 'session', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $checks["Extension: $ext"] = [
        'status' => $loaded,
        'message' => $loaded ? "$ext extension is loaded" : "$ext extension is NOT loaded",
        'critical' => true
    ];
}

// Check if config file exists
$configExists = file_exists(__DIR__ . '/config/db.php');
$checks['Config File'] = [
    'status' => $configExists,
    'message' => $configExists ? "config/db.php exists" : "config/db.php NOT found",
    'critical' => true
];

// Check database connection
if ($configExists) {
    require_once __DIR__ . '/config/db.php';
    
    try {
        $conn = getDBConnection();
        $checks['Database Connection'] = [
            'status' => true,
            'message' => "Successfully connected to database",
            'critical' => true
        ];
        
        // Check if users table exists
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        $tableExists = $result->num_rows > 0;
        $checks['Users Table'] = [
            'status' => $tableExists,
            'message' => $tableExists ? "Users table exists" : "Users table NOT found - run database.sql",
            'critical' => true
        ];
        
        // Check if admin user exists
        if ($tableExists) {
            $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
            $row = $result->fetch_assoc();
            $adminExists = $row['count'] > 0;
            $checks['Admin User'] = [
                'status' => $adminExists,
                'message' => $adminExists ? "Admin user exists" : "No admin user found - run database.sql",
                'critical' => false
            ];
        }
        
        closeDBConnection($conn);
    } catch (Exception $e) {
        $checks['Database Connection'] = [
            'status' => false,
            'message' => "Database connection failed: " . $e->getMessage(),
            'critical' => true
        ];
    }
}

// Check file permissions
$writableCheck = is_writable(__DIR__);
$checks['Directory Writable'] = [
    'status' => $writableCheck,
    'message' => $writableCheck ? "Directory is writable" : "Directory is NOT writable",
    'critical' => false
];

// Check session functionality
session_start();
$_SESSION['test'] = 'value';
$sessionWorks = isset($_SESSION['test']) && $_SESSION['test'] === 'value';
unset($_SESSION['test']);
$checks['Session Support'] = [
    'status' => $sessionWorks,
    'message' => $sessionWorks ? "Sessions are working" : "Sessions are NOT working",
    'critical' => true
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Check</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .check-item.pass {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .check-item.fail {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .check-item .icon {
            font-size: 24px;
            font-weight: bold;
        }
        .check-item.pass .icon {
            color: #28a745;
        }
        .check-item.fail .icon {
            color: #dc3545;
        }
        .check-item .message {
            flex: 1;
            color: #333;
        }
        .summary {
            margin-top: 30px;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
        }
        .summary.all-pass {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        .summary.has-fail {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }
        .summary h2 {
            margin-bottom: 10px;
        }
        .next-steps {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 5px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 System Health Check</h1>
        
        <?php foreach ($checks as $name => $check): ?>
            <?php
            if (!$check['status'] && $check['critical']) {
                $allPassed = false;
            }
            ?>
            <div class="check-item <?php echo $check['status'] ? 'pass' : 'fail'; ?>">
                <div class="icon"><?php echo $check['status'] ? '✓' : '✗'; ?></div>
                <div class="message">
                    <strong><?php echo htmlspecialchars($name); ?>:</strong>
                    <?php echo htmlspecialchars($check['message']); ?>
                    <?php if (!$check['status'] && $check['critical']): ?>
                        <strong style="color: #dc3545;"> (Critical)</strong>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="summary <?php echo $allPassed ? 'all-pass' : 'has-fail'; ?>">
            <?php if ($allPassed): ?>
                <h2>✓ All Critical Checks Passed!</h2>
                <p>Your system is properly configured and ready to use.</p>
            <?php else: ?>
                <h2>✗ Some Critical Checks Failed</h2>
                <p>Please fix the critical issues above before proceeding.</p>
                <p style="margin-top: 10px;">Refer to the INSTALLATION.md guide for help.</p>
            <?php endif; ?>
        </div>
        
        <?php if ($allPassed): ?>
            <div class="next-steps">
                <h3 style="margin-bottom: 15px;">Next Steps:</h3>
                <a href="login.php" class="btn">Go to Login</a>
                <a href="register.php" class="btn">Register as Client</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
