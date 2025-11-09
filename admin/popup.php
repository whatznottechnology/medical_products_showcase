<?php
/**
 * Popup Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

// Detect environment for base URL
$isLocalhost = (strpos(<?php
/**
 * Popup Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle success messages from redirect
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'updated':
            $message = 'Popup updated successfully!';
            $messageType = 'success';
            break;
        case 'status':
            $message = 'Popup status updated!';
            $messageType = 'success';
            break;
    }
}

// Handle Upload/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/popup/');
        
        $popupData = [
            'is_enabled' => isset($_POST['is_enabled']) ? 1 : 0,
            'alt_text' => 'zegnen'
        ];
        
        // Upload image
        if (isset($_FILES['popup_image']) && $_FILES['popup_image']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->upload($_FILES['popup_image']);
            if (!isset($result['error'])) {
                $popupData['image_path'] = $result;
                
                // Delete old popup
                $db->query("DELETE FROM popup");
                
                // Insert new popup
                $db->insert('popup', $popupData);
                header('Location: popup.php?success=updated');
                exit;
            }
        } else {
            // Just update enable/disable status
            $db->query("UPDATE popup SET is_enabled = ?", [$popupData['is_enabled']]);
            header('Location: popup.php?success=status');
            exit;
        }
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Get current popup
$currentPopup = $db->fetchOne("SELECT * FROM popup ORDER BY id DESC LIMIT 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup - ZEGNEN Admin</title>
    <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>admin/assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-window-fullscreen"></i> Popup Management
                </h1>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <div class="row">
                <!-- Upload Form -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-image"></i> Popup Configuration</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Popup Image</label>
                                    <input type="file" name="popup_image" class="form-control" accept="image/*">
                                    <small class="text-muted">
                                        Upload popup image (JPG, PNG, WEBP). Recommended size: 600x800px. Max 2MB. 
                                        Alt text will be auto-set to "zegnen".
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="is_enabled" 
                                               class="form-check-input" 
                                               id="popupEnabled" 
                                               <?php echo ($currentPopup && $currentPopup['is_enabled']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-semibold" for="popupEnabled">
                                            Enable Popup Display
                                        </label>
                                    </div>
                                    <small class="text-muted">
                                        When enabled, the popup will appear on the homepage after a few seconds.
                                    </small>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Note:</strong> The popup will display globally on the homepage. 
                                    Visitors can close it, and it won't show again in the same session.
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Save Popup Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Preview -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-eye"></i> Current Popup Preview</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($currentPopup && $currentPopup['image_path']): ?>
                            <div class="text-center">
                                <img src="<?php echo FileUploader::getImagePath($currentPopup['image_path']); ?>" 
                                     alt="<?php echo $currentPopup['alt_text']; ?>" 
                                     class="img-fluid rounded shadow-lg" 
                                     style="max-height: 500px;">
                                
                                <div class="mt-3">
                                    <span class="badge bg-<?php echo $currentPopup['is_enabled'] ? 'success' : 'secondary'; ?> fs-6">
                                        <?php echo $currentPopup['is_enabled'] ? 'ENABLED' : 'DISABLED'; ?>
                                    </span>
                                </div>
                                
                                <p class="text-muted mt-2">
                                    <small>Uploaded: <?php echo date('M d, Y H:i', strtotime($currentPopup['created_at'])); ?></small>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-window-fullscreen display-1 text-muted"></i>
                                <p class="text-muted mt-3">No popup configured yet</p>
                                <p class="text-muted">Upload an image to get started!</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>admin/assets/js/admin.js"></script>
</body>
</html>
SERVER['HTTP_HOST'], 'localhost') !== false);
$baseUrl = $isLocalhost ? '/p/' : '/';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle success messages from redirect
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'updated':
            $message = 'Popup updated successfully!';
            $messageType = 'success';
            break;
        case 'status':
            $message = 'Popup status updated!';
            $messageType = 'success';
            break;
    }
}

// Handle Upload/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/popup/');
        
        $popupData = [
            'is_enabled' => isset($_POST['is_enabled']) ? 1 : 0,
            'alt_text' => 'zegnen'
        ];
        
        // Upload image
        if (isset($_FILES['popup_image']) && $_FILES['popup_image']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->upload($_FILES['popup_image']);
            if (!isset($result['error'])) {
                $popupData['image_path'] = $result;
                
                // Delete old popup
                $db->query("DELETE FROM popup");
                
                // Insert new popup
                $db->insert('popup', $popupData);
                header('Location: popup.php?success=updated');
                exit;
            }
        } else {
            // Just update enable/disable status
            $db->query("UPDATE popup SET is_enabled = ?", [$popupData['is_enabled']]);
            header('Location: popup.php?success=status');
            exit;
        }
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Get current popup
$currentPopup = $db->fetchOne("SELECT * FROM popup ORDER BY id DESC LIMIT 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup - ZEGNEN Admin</title>
    <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>admin/assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-window-fullscreen"></i> Popup Management
                </h1>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <div class="row">
                <!-- Upload Form -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-image"></i> Popup Configuration</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Popup Image</label>
                                    <input type="file" name="popup_image" class="form-control" accept="image/*">
                                    <small class="text-muted">
                                        Upload popup image (JPG, PNG, WEBP). Recommended size: 600x800px. Max 2MB. 
                                        Alt text will be auto-set to "zegnen".
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="is_enabled" 
                                               class="form-check-input" 
                                               id="popupEnabled" 
                                               <?php echo ($currentPopup && $currentPopup['is_enabled']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-semibold" for="popupEnabled">
                                            Enable Popup Display
                                        </label>
                                    </div>
                                    <small class="text-muted">
                                        When enabled, the popup will appear on the homepage after a few seconds.
                                    </small>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Note:</strong> The popup will display globally on the homepage. 
                                    Visitors can close it, and it won't show again in the same session.
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Save Popup Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Preview -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-eye"></i> Current Popup Preview</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($currentPopup && $currentPopup['image_path']): ?>
                            <div class="text-center">
                                <img src="<?php echo FileUploader::getImagePath($currentPopup['image_path']); ?>" 
                                     alt="<?php echo $currentPopup['alt_text']; ?>" 
                                     class="img-fluid rounded shadow-lg" 
                                     style="max-height: 500px;">
                                
                                <div class="mt-3">
                                    <span class="badge bg-<?php echo $currentPopup['is_enabled'] ? 'success' : 'secondary'; ?> fs-6">
                                        <?php echo $currentPopup['is_enabled'] ? 'ENABLED' : 'DISABLED'; ?>
                                    </span>
                                </div>
                                
                                <p class="text-muted mt-2">
                                    <small>Uploaded: <?php echo date('M d, Y H:i', strtotime($currentPopup['created_at'])); ?></small>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-window-fullscreen display-1 text-muted"></i>
                                <p class="text-muted mt-3">No popup configured yet</p>
                                <p class="text-muted">Upload an image to get started!</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>admin/assets/js/admin.js"></script>
</body>
</html>
