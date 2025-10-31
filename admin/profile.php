<?php
/**
 * Admin Profile Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';

// Require authentication
Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$success = '';
$error = '';

// Handle success messages from redirect
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'profile':
            $success = 'Profile updated successfully!';
            break;
        case 'profile_password':
            $success = 'Profile and password updated successfully!';
            break;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($name)) {
            $error = 'Name is required.';
        } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Valid email is required.';
        } else {
            // Check if email already exists for another admin
            $existingAdmin = $db->fetchOne(
                "SELECT id FROM admin WHERE email = ? AND id != ?",
                [$email, $user['id']]
            );
            
            if ($existingAdmin) {
                $error = 'This email is already in use.';
            } else {
                // If changing password, validate
                $updatePassword = false;
                if (!empty($new_password)) {
                    if (empty($current_password)) {
                        $error = 'Current password is required to set a new password.';
                    } elseif (!password_verify($current_password, $user['password'])) {
                        $error = 'Current password is incorrect.';
                    } elseif (strlen($new_password) < 6) {
                        $error = 'New password must be at least 6 characters.';
                    } elseif ($new_password !== $confirm_password) {
                        $error = 'New passwords do not match.';
                    } else {
                        $updatePassword = true;
                    }
                }
                
                // Update profile if no errors
                if (empty($error)) {
                    if ($updatePassword) {
                        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                        $db->query(
                            "UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?",
                            [$name, $email, $hashedPassword, $user['id']]
                        );
                        header('Location: profile.php?success=profile_password');
                        exit;
                    } else {
                        $db->query(
                            "UPDATE admin SET name = ?, email = ? WHERE id = ?",
                            [$name, $email, $user['id']]
                        );
                        header('Location: profile.php?success=profile');
                        exit;
                    }
                    
                    // Refresh user session
                    $_SESSION['admin_user'] = $db->fetchOne("SELECT * FROM admin WHERE id = ?", [$user['id']]);
                    $user = $_SESSION['admin_user'];
                }
            }
        }
    }
}

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - ZEGNEN Admin</title>
    <link rel="icon" type="image/png" href="../assets/images/zic_fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-person-circle"></i> Profile Settings
                </h1>
                <p class="text-muted">Manage your admin account details and password</p>
            </div>

            <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-badge"></i> Account Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>

                                <hr class="my-4">
                                
                                <h6 class="mb-3"><i class="bi bi-key"></i> Change Password (Optional)</h6>
                                <p class="text-muted small mb-3">Leave blank if you don't want to change your password</p>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                    <small class="text-muted">Required only if you want to change your password</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                        <small class="text-muted">Minimum 6 characters</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update Profile
                                    </button>
                                    <a href="index.php" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-info-circle"></i> Security Tips</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-success"></i> 
                                    Use a strong, unique password
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-success"></i> 
                                    Change password regularly
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-success"></i> 
                                    Don't share credentials
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-success"></i> 
                                    Log out after each session
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>
