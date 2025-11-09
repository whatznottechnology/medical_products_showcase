<?php
/**
 * Gallery Management
 * Template structure for multiple image upload and management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

// Detect environment for base URL
$isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
$baseUrl = $isLocalhost ? '/p/' : '/';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle multiple image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gallery_images']) && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/gallery/');
        $results = $uploader->uploadMultiple($_FILES['gallery_images']);
        
        $successCount = 0;
        foreach ($results as $result) {
            if (!isset($result['error'])) {
                // Auto-detect image type based on dimensions
                $uploadedPath = __DIR__ . '/../' . $result['path'];
                $imageInfo = getimagesize($uploadedPath);
                
                if ($imageInfo) {
                    $width = $imageInfo[0];
                    $height = $imageInfo[1];
                    
                    // Determine image type based on aspect ratio
                    $aspectRatio = $width / $height;
                    
                    if ($aspectRatio > 1.3) {
                        $imageType = 'landscape'; // Wide images (5:3, 16:9, etc.)
                    } elseif ($aspectRatio < 0.8) {
                        $imageType = 'portrait'; // Tall images (2:3, 9:16, etc.)
                    } else {
                        $imageType = 'square'; // Nearly square images (1:1)
                    }
                } else {
                    $imageType = 'landscape'; // Default fallback
                }
                
                $db->insert('gallery', [
                    'image_path' => $result['path'],
                    'image_type' => $imageType,
                    'alt_text' => 'zegnen',
                    'display_order' => 0,
                    'status' => 'active'
                ]);
                $successCount++;
            }
        }
        
        $message = "{$successCount} image(s) uploaded successfully with auto-detected types!";
        $messageType = 'success';
        
    } catch (Exception $e) {
        $message = 'Error uploading images: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $imageId = (int)$_GET['delete'];
        $image = $db->fetchOne("SELECT * FROM gallery WHERE id = ?", [$imageId]);
        
        if ($image) {
            $uploader = new FileUploader();
            $uploader->delete($image['image_path']);
            $db->delete('gallery', 'id = ?', [$imageId]);
            
            $message = 'Image deleted successfully!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error deleting image: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Fetch all gallery images
$images = $db->fetchAll("SELECT * FROM gallery ORDER BY display_order, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - ZEGNEN Admin</title>
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
                    <i class="bi bi-images"></i> Gallery Management
                </h1>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <!-- Upload Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Upload Images</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Select Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" 
                                       accept="image/*" multiple required>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Select multiple images (JPG, PNG, WEBP). Max 2MB each. 
                                    <strong>Image type will be auto-detected</strong> based on dimensions:
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Landscape:</strong> Wide images (aspect ratio > 1.3)</li>
                                        <li><strong>Portrait:</strong> Tall images (aspect ratio < 0.8)</li>
                                        <li><strong>Square:</strong> Nearly square images (aspect ratio ≈ 1.0)</li>
                                    </ul>
                                </small>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cloud-upload"></i> Upload Images (Auto-Detect Type)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Gallery Grid -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gallery Images (<?php echo count($images); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($images)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-images display-1 text-muted"></i>
                        <p class="text-muted mt-3">No images yet. Upload your first images!</p>
                    </div>
                    <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($images as $image): ?>
                        <?php
                            // Get image dimensions
                            $imagePath = __DIR__ . '/../' . $image['image_path'];
                            $dimensions = '';
                            if (file_exists($imagePath)) {
                                $imageInfo = getimagesize($imagePath);
                                if ($imageInfo) {
                                    $dimensions = $imageInfo[0] . ' × ' . $imageInfo[1];
                                }
                            }
                        ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <img src="<?php echo FileUploader::getImagePath($image['image_path']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $image['alt_text']; ?>" 
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-<?php echo $image['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($image['status']); ?>
                                        </span>
                                        <span class="badge bg-info">
                                            <i class="bi bi-aspect-ratio"></i> <?php echo ucfirst($image['image_type']); ?>
                                        </span>
                                    </div>
                                    <?php if ($dimensions): ?>
                                    <small class="text-muted d-block mb-2">
                                        <i class="bi bi-image"></i> <?php echo $dimensions; ?>px
                                    </small>
                                    <?php endif; ?>
                                    <div class="d-flex gap-1">
                                        <a href="?delete=<?php echo $image['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-danger w-100" 
                                           onclick="return confirm('Delete this image?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>admin/assets/js/admin.js"></script>
</body>
</html>
