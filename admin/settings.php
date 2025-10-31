<?php
/**
 * Website Settings Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle success message from redirect
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $message = 'Settings updated successfully!';
    $messageType = 'success';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        // Update each setting
        foreach ($_POST as $key => $value) {
            if ($key === 'csrf_token') continue;
            
            // Trim whitespace and convert empty strings to empty for optional fields
            $value = trim($value);
            
            // Remove default "#" values for social links - treat as empty
            if (in_array($key, ['facebook_url', 'instagram_url', 'youtube_url', 'linkedin_url', 'twitter_url'])) {
                if ($value === '#' || empty($value)) {
                    $value = '';
                }
            }
            
            $existing = $db->fetchOne("SELECT id FROM settings WHERE setting_key = ?", [$key]);
            
            if ($existing) {
                $db->query(
                    "UPDATE settings SET setting_value = ?, updated_at = NOW() WHERE id = ?",
                    [$value, $existing['id']]
                );
            } else {
                $db->insert('settings', [
                    'setting_key' => $key,
                    'setting_value' => $value
                ]);
            }
        }
        
        $message = 'Settings updated successfully!';
        $messageType = 'success';
        
        // Redirect to prevent double submission on refresh
        header('Location: settings.php?success=1');
        exit;
        
    } catch (Exception $e) {
        $message = 'Error updating settings: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Fetch all settings
$settingsArray = $db->fetchAll("SELECT * FROM settings");
$settings = [];
foreach ($settingsArray as $setting) {
    $settings[$setting['setting_key']] = $setting['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings - ZEGNEN Admin</title>
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
                    <i class="bi bi-gear"></i> Website Settings
                </h1>
                <p class="text-muted">Manage global website settings and contact information</p>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                
                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-telephone"></i> Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Call Number</label>
                                <input type="text" name="call_number" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['call_number'] ?? ''); ?>" 
                                       placeholder="+91 XXXXX XXXXX">
                                <small class="text-muted">This will reflect on all call buttons and topbar</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['whatsapp_number'] ?? ''); ?>" 
                                       placeholder="91XXXXXXXXXX (without +)">
                                <small class="text-muted">Without + symbol (e.g., 918902056626)</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>" 
                                       placeholder="info@zegnen.com">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-share"></i> Social Media Links (Optional)</h5>
                        <small class="text-muted">Leave blank to hide any social media icon on the website</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-facebook text-primary"></i> Facebook URL <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="url" name="facebook_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['facebook_url'] ?? ''); ?>" 
                                       placeholder="https://facebook.com/zegnen">
                                <small class="text-muted">Leave empty to hide Facebook icon</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-instagram text-danger"></i> Instagram URL <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="url" name="instagram_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>" 
                                       placeholder="https://instagram.com/zegnen">
                                <small class="text-muted">Leave empty to hide Instagram icon</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-youtube text-danger"></i> YouTube URL <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="url" name="youtube_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['youtube_url'] ?? ''); ?>" 
                                       placeholder="https://youtube.com/@zegnen">
                                <small class="text-muted">Leave empty to hide YouTube icon</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-linkedin text-primary"></i> LinkedIn URL <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="url" name="linkedin_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? ''); ?>" 
                                       placeholder="https://linkedin.com/company/zegnen">
                                <small class="text-muted">Leave empty to hide LinkedIn icon</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-twitter text-info"></i> Twitter URL <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="url" name="twitter_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>" 
                                       placeholder="https://twitter.com/zegnen">
                                <small class="text-muted">Leave empty to hide Twitter icon</small>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="bi bi-info-circle"></i> <strong>Note:</strong> Only social media links with URLs will be displayed on the website. Leave any field blank to hide that social media icon.
                        </div>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>
