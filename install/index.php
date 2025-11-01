<?php
/**
 * Production Installer for ZEGNEN Medical Products Showcase
 * This script handles initial setup, database creation, and configuration
 */

session_start();

// Check if already installed
if (file_exists(__DIR__ . '/../config/.installed')) {
    header('Location: ../admin/');
    exit;
}

// Initialize variables
$errors = [];
$success = [];
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : [];
unset($_SESSION['errors'], $_SESSION['success']);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 1) {
        // Validate basic information
        $site_name = trim($_POST['site_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        
        if (empty($site_name)) {
            $errors[] = 'Site name is required';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if (empty($errors)) {
            $_SESSION['setup'] = [
                'site_name' => $site_name,
                'email' => $email,
                'phone' => $phone
            ];
            $_SESSION['success'][] = 'Basic information saved successfully';
            header('Location: ?step=2');
            exit;
        }
        $_SESSION['errors'] = $errors;
        header('Location: ?step=1');
        exit;
    }
    
    elseif ($step === 2) {
        // Validate database information
        $db_host = trim($_POST['db_host'] ?? 'localhost');
        $db_name = trim($_POST['db_name'] ?? '');
        $db_user = trim($_POST['db_user'] ?? 'root');
        $db_password = trim($_POST['db_password'] ?? '');
        
        if (empty($db_name)) {
            $errors[] = 'Database name is required';
        }
        
        // Test database connection
        if (empty($errors)) {
            try {
                $pdo = new PDO(
                    "mysql:host=$db_host",
                    $db_user,
                    $db_password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                // Create database if not exists
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $_SESSION['success'][] = 'Database connection successful';
            } catch (Exception $e) {
                $errors[] = 'Database connection failed: ' . $e->getMessage();
            }
        }
        
        if (empty($errors)) {
            $_SESSION['setup']['db_host'] = $db_host;
            $_SESSION['setup']['db_name'] = $db_name;
            $_SESSION['setup']['db_user'] = $db_user;
            $_SESSION['setup']['db_password'] = $db_password;
            $_SESSION['success'][] = 'Database information saved';
            header('Location: ?step=3');
            exit;
        }
        $_SESSION['errors'] = $errors;
        header('Location: ?step=2');
        exit;
    }
    
    elseif ($step === 3) {
        // Validate admin information
        $admin_email = trim($_POST['admin_email'] ?? '');
        $admin_password = trim($_POST['admin_password'] ?? '');
        $admin_password_confirm = trim($_POST['admin_password_confirm'] ?? '');
        
        if (empty($admin_email) || !filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid admin email is required';
        }
        if (empty($admin_password) || strlen($admin_password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }
        if ($admin_password !== $admin_password_confirm) {
            $errors[] = 'Passwords do not match';
        }
        
        if (empty($errors)) {
            $_SESSION['setup']['admin_email'] = $admin_email;
            $_SESSION['setup']['admin_password'] = $admin_password;
            $_SESSION['success'][] = 'Admin information saved';
            header('Location: ?step=4');
            exit;
        }
        $_SESSION['errors'] = $errors;
        header('Location: ?step=3');
        exit;
    }
    
    elseif ($step === 4) {
        // Final installation
        $setup = $_SESSION['setup'] ?? [];
        
        if (empty($setup)) {
            $errors[] = 'Setup data missing. Please start from the beginning.';
            $_SESSION['errors'] = $errors;
            header('Location: ?step=1');
            exit;
        }
        
        try {
            // Connect to database
            $pdo = new PDO(
                "mysql:host={$setup['db_host']};dbname={$setup['db_name']}",
                $setup['db_user'],
                $setup['db_password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            // Create tables
            $sql = file_get_contents(__DIR__ . '/../zic.sql');
            $pdo->exec($sql);
            
            // Create .env file
            $env_content = <<<ENV
APP_NAME={$setup['site_name']}
DB_HOST={$setup['db_host']}
DB_NAME={$setup['db_name']}
DB_USER={$setup['db_user']}
DB_PASSWORD={$setup['db_password']}
ADMIN_EMAIL={$setup['admin_email']}
ADMIN_PASSWORD={$setup['admin_password']}
APP_ENV=production
DEBUG=false
ENV;
            file_put_contents(__DIR__ . '/../.env', $env_content);
            
            // Insert default admin user
            $admin_password_hash = password_hash($setup['admin_password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (email, password, name) VALUES (?, ?, ?)");
            $stmt->execute([$setup['admin_email'], $admin_password_hash, 'Administrator']);
            
            // Insert default settings
            $default_settings = [
                ['site_name', $setup['site_name']],
                ['email', $setup['email']],
                ['call_number', $setup['phone']],
                ['whatsapp_number', preg_replace('/[^0-9]/', '', $setup['phone'])],
                ['facebook_url', ''],
                ['instagram_url', ''],
                ['twitter_url', ''],
                ['youtube_url', ''],
                ['linkedin_url', ''],
            ];
            
            $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, setting_type) VALUES (?, ?, 'text')");
            foreach ($default_settings as [$key, $value]) {
                $stmt->execute([$key, $value]);
            }
            
            // Create installation marker
            if (!is_dir(__DIR__ . '/../config')) {
                mkdir(__DIR__ . '/../config', 0755, true);
            }
            touch(__DIR__ . '/../config/.installed');
            
            $_SESSION['success'][] = 'Installation completed successfully!';
            header('Location: ?step=5');
            exit;
        } catch (Exception $e) {
            $errors[] = 'Installation failed: ' . $e->getMessage();
            $_SESSION['errors'] = $errors;
            header('Location: ?step=4');
            exit;
        }
    }
}

// Get session data
$setup = $_SESSION['setup'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEGNEN - Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .step-active { @apply text-yellow-600 font-bold; }
        .step-completed { @apply text-green-600; }
        .progress-bar { 
            background: linear-gradient(to right, #fbbf24 0%, #fbbf24 var(--progress), #e5e7eb var(--progress), #e5e7eb 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-yellow-50 to-white">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">ZEGNEN Installation Wizard</h1>
                <p class="text-gray-600">Welcome to the ZEGNEN Medical Products Showcase setup</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between text-sm mb-4">
                    <div class="<?php echo $step >= 1 ? 'step-active' : ''; ?>">Step 1: Site Info</div>
                    <div class="<?php echo $step >= 2 ? ($step > 2 ? 'step-completed' : 'step-active') : ''; ?>">Step 2: Database</div>
                    <div class="<?php echo $step >= 3 ? ($step > 3 ? 'step-completed' : 'step-active') : ''; ?>">Step 3: Admin</div>
                    <div class="<?php echo $step >= 4 ? ($step > 4 ? 'step-completed' : 'step-active') : ''; ?>">Step 4: Install</div>
                    <div class="<?php echo $step >= 5 ? 'step-completed' : ''; ?>">Step 5: Complete</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden" style="--progress: <?php echo ($step / 5) * 100; ?>%">
                    <div class="progress-bar h-full transition-all duration-300"></div>
                </div>
            </div>

            <!-- Messages -->
            <?php if (!empty($errors)): ?>
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <?php foreach ($errors as $error): ?>
                <div class="text-red-700 text-sm mb-2">✗ <?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <?php foreach ($success as $msg): ?>
                <div class="text-green-700 text-sm mb-2">✓ <?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Step Content -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <?php if ($step === 1): ?>
                    <!-- Step 1: Site Information -->
                    <form method="POST">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900">Site Information</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Name *</label>
                            <input type="text" name="site_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="e.g., ZEGNEN International" value="<?php echo htmlspecialchars($setup['site_name'] ?? ''); ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="info@example.com" value="<?php echo htmlspecialchars($setup['email'] ?? ''); ?>">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="+91 12345 67890" value="<?php echo htmlspecialchars($setup['phone'] ?? ''); ?>">
                        </div>

                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition-colors">
                            Next: Database Setup →
                        </button>
                    </form>

                <?php elseif ($step === 2): ?>
                    <!-- Step 2: Database Configuration -->
                    <form method="POST">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900">Database Configuration</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Database Host *</label>
                            <input type="text" name="db_host" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="localhost" value="<?php echo htmlspecialchars($setup['db_host'] ?? 'localhost'); ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Database Name *</label>
                            <input type="text" name="db_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="zegnen_db" value="<?php echo htmlspecialchars($setup['db_name'] ?? ''); ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Database User *</label>
                            <input type="text" name="db_user" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="root" value="<?php echo htmlspecialchars($setup['db_user'] ?? 'root'); ?>">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Database Password</label>
                            <input type="password" name="db_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Leave empty if no password">
                        </div>

                        <div class="flex gap-4">
                            <a href="?step=1" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-3 rounded-lg transition-colors text-center">
                                ← Back
                            </a>
                            <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition-colors">
                                Next: Admin Setup →
                            </button>
                        </div>
                    </form>

                <?php elseif ($step === 3): ?>
                    <!-- Step 3: Admin Configuration -->
                    <form method="POST">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900">Admin Account Setup</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Email *</label>
                            <input type="email" name="admin_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="admin@example.com" value="<?php echo htmlspecialchars($setup['admin_email'] ?? ''); ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password (Minimum 8 characters) *</label>
                            <input type="password" name="admin_password" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Create a strong password">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                            <input type="password" name="admin_password_confirm" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Confirm password">
                        </div>

                        <div class="flex gap-4">
                            <a href="?step=2" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-3 rounded-lg transition-colors text-center">
                                ← Back
                            </a>
                            <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition-colors">
                                Next: Review & Install →
                            </button>
                        </div>
                    </form>

                <?php elseif ($step === 4): ?>
                    <!-- Step 4: Review and Install -->
                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Ready to Install</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="font-bold text-gray-900 mb-4">Installation Summary:</h3>
                        <div class="space-y-3 text-sm">
                            <div><strong>Site Name:</strong> <?php echo htmlspecialchars($setup['site_name'] ?? ''); ?></div>
                            <div><strong>Email:</strong> <?php echo htmlspecialchars($setup['email'] ?? ''); ?></div>
                            <div><strong>Phone:</strong> <?php echo htmlspecialchars($setup['phone'] ?? ''); ?></div>
                            <div><strong>Database:</strong> <?php echo htmlspecialchars($setup['db_name'] ?? ''); ?> @ <?php echo htmlspecialchars($setup['db_host'] ?? ''); ?></div>
                            <div><strong>Admin Email:</strong> <?php echo htmlspecialchars($setup['admin_email'] ?? ''); ?></div>
                        </div>
                    </div>

                    <form method="POST">
                        <div class="flex gap-4">
                            <a href="?step=3" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-3 rounded-lg transition-colors text-center">
                                ← Back
                            </a>
                            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition-colors">
                                ✓ Install Now
                            </button>
                        </div>
                    </form>

                <?php elseif ($step === 5): ?>
                    <!-- Step 5: Complete -->
                    <div class="text-center">
                        <div class="mb-6 flex justify-center">
                            <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Installation Complete!</h2>
                        <p class="text-gray-600 mb-8 text-lg">Your ZEGNEN installation is ready to use. Please log in to the admin panel to complete your setup.</p>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8 text-left text-sm">
                            <h3 class="font-bold text-gray-900 mb-3">Next Steps:</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li>✓ Log in to admin panel</li>
                                <li>✓ Add your company logo and banner images</li>
                                <li>✓ Add your products and product images</li>
                                <li>✓ Configure social media links</li>
                                <li>✓ Set up testimonials and reviews</li>
                                <li>✓ Launch your website</li>
                            </ul>
                        </div>

                        <div class="flex gap-4">
                            <a href="../admin/" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition-colors">
                                Go to Admin Panel →
                            </a>
                            <a href="../" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-3 rounded-lg transition-colors">
                                View Website
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-600 text-sm mt-8">
                <p>ZEGNEN Medical Products Showcase © 2025 | Developed by Whatznot</p>
            </div>
        </div>
    </div>
</body>
</html>
