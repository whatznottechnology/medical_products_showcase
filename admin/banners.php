<?php
/**
 * Banners Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle success messages from redirect
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'added':
            $message = 'Banner added successfully!';
            $messageType = 'success';
            break;
        case 'updated':
            $message = 'Banner updated successfully!';
            $messageType = 'success';
            break;
        case 'deleted':
            $message = 'Banner deleted successfully!';
            $messageType = 'success';
            break;
        case 'status':
            $message = 'Banner status updated!';
            $messageType = 'success';
            break;
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $bannerId = $_POST['banner_id'] ?? null;
        $page = $_POST['page'] ?? '';
        $title = $_POST['title'] ?? '';
        $status = $_POST['status'] ?? 'active';
        
        // Handle image upload
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/banners/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (!in_array($fileExt, $allowedExts)) {
                throw new Exception('Invalid file type. Only JPG, PNG, WEBP, and GIF allowed.');
            }
            
            $fileName = uniqid() . '_' . time() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($imagePath && file_exists('../' . $imagePath)) {
                    unlink('../' . $imagePath);
                }
                $imagePath = 'uploads/banners/' . $fileName;
            } else {
                throw new Exception('Failed to upload image');
            }
        }
        
        $bannerData = [
            'page' => $page,
            'title' => $title,
            'image_path' => $imagePath,
            'status' => $status
        ];
        
        if ($bannerId) {
            $db->query(
                "UPDATE banners SET page = ?, title = ?, image_path = ?, status = ? WHERE id = ?",
                [$page, $title, $imagePath, $status, (int)$bannerId]
            );
            header('Location: banners.php?success=updated');
            exit;
        } else {
            $db->insert('banners', $bannerData);
            header('Location: banners.php?success=added');
            exit;
        }
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $bannerId = (int)$_GET['delete'];
        $banner = $db->fetchOne("SELECT image_path FROM banners WHERE id = ?", [$bannerId]);
        
        if ($banner && $banner['image_path'] && file_exists('../' . $banner['image_path'])) {
            unlink('../' . $banner['image_path']);
        }
        
        $db->delete('banners', 'id = ?', [$bannerId]);
        header('Location: banners.php?success=deleted');
        exit;
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting banner: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Toggle Status
if (isset($_GET['toggle_status']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $bannerId = (int)$_GET['toggle_status'];
        $banner = $db->fetchOne("SELECT status FROM banners WHERE id = ?", [$bannerId]);
        if ($banner) {
            $newStatus = $banner['status'] === 'active' ? 'inactive' : 'active';
            $db->query("UPDATE banners SET status = ? WHERE id = ?", [$newStatus, $bannerId]);
            header('Location: banners.php?success=status');
            exit;
        }
    } catch (Exception $e) {
        $message = 'Error toggling status: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

$banners = $db->fetchAll("SELECT * FROM banners ORDER BY page, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banners - ZEGNEN Admin</title>
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
                    <i class="bi bi-images"></i> Banner Management
                </h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                    <i class="bi bi-plus-circle"></i> Add New Banner
                </button>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <!-- Banner Size Guide -->
            <div class="alert alert-info mb-4">
                <h5 class="alert-heading"><i class="bi bi-info-circle"></i> Recommended Banner Sizes</h5>
                <div class="row small">
                    <div class="col-md-6">
                        <strong>Homepage:</strong> 1920x1080px (16:9) - Full Screen<br>
                        <strong>Our Products:</strong> 1920x600px (3.2:1) - Banner
                    </div>
                    <div class="col-md-6">
                        <strong>Why ZEGNEN:</strong> 1920x1080px (16:9) - Full Screen<br>
                        <strong>About Us:</strong> 1920x800px (2.4:1) - 60vh Banner
                    </div>
                </div>
                <hr class="my-2">
                <small class="text-muted"><strong>Tips:</strong> Use JPG (max 500KB), 80-85% quality, keep important content centered</small>
            </div>

            <div class="row">
                <?php 
                $pages = ['home' => 'Homepage', 'our-products' => 'Our Products', 'why-zegnen' => 'Why ZEGNEN?', 'about' => 'About Us'];
                $bannerSizes = [
                    'home' => '1920x1080px',
                    'our-products' => '1920x600px', 
                    'why-zegnen' => '1920x1080px',
                    'about' => '1920x800px'
                ];
                foreach ($pages as $pageKey => $pageName):
                    $pageBanners = array_filter($banners, fn($b) => $b['page'] === $pageKey);
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-image"></i> <?php echo $pageName; ?></h5>
                            <small class="badge bg-light text-dark"><?php echo $bannerSizes[$pageKey]; ?></small>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pageBanners)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-image display-3 text-muted"></i>
                                    <p class="text-muted mt-2">No banner set for this page</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($pageBanners as $banner): ?>
                                <div class="banner-item mb-3">
                                    <div class="position-relative">
                                        <img src="../<?php echo htmlspecialchars($banner['image_path']); ?>" 
                                             alt="<?php echo htmlspecialchars($banner['title']); ?>" 
                                             class="img-fluid rounded" style="width: 100%; max-height: 200px; object-fit: cover;">
                                        <span class="badge bg-<?php echo $banner['status'] === 'active' ? 'success' : 'secondary'; ?> position-absolute top-0 end-0 m-2">
                                            <?php echo ucfirst($banner['status']); ?>
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <strong><?php echo htmlspecialchars($banner['title']); ?></strong>
                                        <div class="btn-group btn-group-sm float-end">
                                            <button class="btn btn-outline-primary edit-banner-btn" 
                                                    data-banner='<?php echo json_encode($banner); ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="?toggle_status=<?php echo $banner['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                               class="btn btn-outline-<?php echo $banner['status'] === 'active' ? 'warning' : 'success'; ?>">
                                                <i class="bi bi-toggle-<?php echo $banner['status'] === 'active' ? 'on' : 'off'; ?>"></i>
                                            </a>
                                            <a href="?delete=<?php echo $banner['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Delete this banner?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Page</label>
                            <select name="page" class="form-select" required>
                                <option value="">Select Page</option>
                                <option value="home">Homepage</option>
                                <option value="our-products">Our Products</option>
                                <option value="why-zegnen">Why ZEGNEN?</option>
                                <option value="about">About Us</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="title" class="form-control" 
                                   placeholder="Banner Title (leave blank if not needed)">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Banner Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Recommended size: 1920x600px. Formats: JPG, PNG, WEBP, GIF</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Banner Modal -->
    <div class="modal fade" id="editBannerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        <input type="hidden" name="banner_id" id="edit_banner_id">
                        <input type="hidden" name="existing_image" id="edit_existing_image">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Page</label>
                            <select name="page" id="edit_page" class="form-select" required>
                                <option value="home">Homepage</option>
                                <option value="our-products">Our Products</option>
                                <option value="why-zegnen">Why ZEGNEN?</option>
                                <option value="about">About Us</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image</label>
                            <div id="current_image_preview"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Replace Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
    // Edit banner functionality
    document.querySelectorAll('.edit-banner-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const banner = JSON.parse(this.getAttribute('data-banner'));
            
            // Populate form fields
            document.getElementById('edit_banner_id').value = banner.id;
            document.getElementById('edit_page').value = banner.page;
            document.getElementById('edit_title').value = banner.title;
            document.getElementById('edit_existing_image').value = banner.image_path;
            document.getElementById('edit_status').value = banner.status;
            
            // Show current image
            document.getElementById('current_image_preview').innerHTML = 
                `<img src="../${banner.image_path}" alt="${banner.title}" class="img-fluid rounded" style="max-height: 150px;">`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editBannerModal'));
            modal.show();
        });
    });
    </script>
</body>
</html>
