<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Outsinc AllInOne</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    require_once 'includes/session.php';
    require_once 'config/db.php';
    
    startSecureSession();
    
    // Require staff or admin role
    $currentUser = requireRole(['admin', 'staff']);
    
    $success = '';
    $error = '';
    
    // Handle user approval/rejection
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = intval($_POST['user_id'] ?? 0);
        $action = $_POST['action'] ?? '';
        
        if ($userId > 0 && in_array($action, ['approve', 'reject', 'deactivate'])) {
            $conn = getDBConnection();
            
            if ($action === 'approve') {
                $stmt = $conn->prepare("UPDATE users SET status = 'active', approved_by = ?, approved_at = NOW() WHERE id = ? AND status = 'pending'");
                $stmt->bind_param("ii", $currentUser['id'], $userId);
                
                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $success = 'User approved successfully!';
                } else {
                    $error = 'Failed to approve user or user is not pending.';
                }
            } elseif ($action === 'reject') {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND status = 'pending'");
                $stmt->bind_param("i", $userId);
                
                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $success = 'User registration rejected and deleted.';
                } else {
                    $error = 'Failed to reject user or user is not pending.';
                }
            } elseif ($action === 'deactivate') {
                $stmt = $conn->prepare("UPDATE users SET status = 'inactive' WHERE id = ? AND status = 'active'");
                $stmt->bind_param("i", $userId);
                
                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $success = 'User deactivated successfully!';
                } else {
                    $error = 'Failed to deactivate user.';
                }
            }
            
            $stmt->close();
            closeDBConnection($conn);
        }
    }
    
    // Get all users
    $conn = getDBConnection();
    $result = $conn->query("SELECT id, username, email, full_name, role, status, created_at FROM users ORDER BY created_at DESC");
    $users = $result->fetch_all(MYSQLI_ASSOC);
    closeDBConnection($conn);
    ?>
    
    <div class="dashboard-container">
        <div class="header">
            <div>
                <h1>Manage Users</h1>
            </div>
            <div class="user-info">
                <a href="dashboard.php">← Back to Dashboard</a> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <h2>All Users</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo htmlspecialchars($user['role']); ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo htmlspecialchars($user['status']); ?>">
                                <?php echo ucfirst($user['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                        <td>
                            <?php if ($user['status'] === 'pending'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-small">Approve</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('Are you sure you want to reject and delete this user?')">Reject</button>
                                </form>
                            <?php elseif ($user['status'] === 'active' && $user['id'] !== $currentUser['id']): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="action" value="deactivate">
                                    <button type="submit" class="btn btn-secondary btn-small">Deactivate</button>
                                </form>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
