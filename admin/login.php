<?php
/**
 * Admin Login Page
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';

// Detect environment for base URL
$isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
$baseUrl = $isLocalhost ? '/p/' : '/';

// If already logged in, redirect to dashboard
if (Auth::check()) {
    header('Location: index.php');
    exit;
}

$error = '';
$timeout = isset($_GET['timeout']) ? true : false;

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $db = Database::getInstance();
        $admin = $db->fetchOne("SELECT * FROM admin WHERE email = ?", [$email]);
        
        if ($admin && password_verify($password, $admin['password'])) {
            Auth::login($admin);
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ZEGNEN</title>
    <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #FFC107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="<?php echo $baseUrl; ?>assets/images/zic_logo.png" alt="ZEGNEN Logo" style="max-width: 160px; height: auto; margin-bottom: 10px;">
            <p>Admin Panel Login</p>
        </div>
        <div class="login-body">
            <?php if ($timeout): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-clock-history"></i> Your session has expired. Please login again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-muted"></i>
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="admin@zegnen.com" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill text-muted"></i>
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Login to Dashboard
                </button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
