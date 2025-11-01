<?php
/**
 * Brands Management
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/brands/');
        
        $brandData = [
            'name' => $_POST['name'] ?? '',
            'display_order' => $_POST['display_order'] ?? 0,
            'status' => $_POST['status'] ?? 'active'
        ];
        
        // Upload logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->upload($_FILES['logo']);
            if (!isset($result['error'])) {
                $brandData['logo_path'] = $result;
            }
        }
        
        if (isset($_POST['brand_id']) && !empty($_POST['brand_id'])) {
            $brandId = (int)$_POST['brand_id'];
            $db->update('brands', $brandData, 'id = :id', ['id' => $brandId]);
            $message = 'Brand updated successfully!';
        } else {
            if (!isset($brandData['logo_path'])) {
                throw new Exception('Logo is required');
            }
            $db->insert('brands', $brandData);
            $message = 'Brand added successfully!';
        }
        
        $messageType = 'success';
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $brandId = (int)$_GET['delete'];
        $brand = $db->fetchOne("SELECT * FROM brands WHERE id = ?", [$brandId]);
        
        if ($brand) {
            $uploader = new FileUploader();
            $uploader->delete($brand['logo_path']);
            $db->delete('brands', 'id = ?', [$brandId]);
            
            $message = 'Brand deleted successfully!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error deleting brand: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

$brands = $db->fetchAll("SELECT * FROM brands ORDER BY display_order, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands - ZEGNEN Admin</title>
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
                    <i class="bi bi-award"></i> Brands Management
                </h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                    <i class="bi bi-plus-circle"></i> Add New Brand
                </button>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <?php if (empty($brands)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-award display-1 text-muted"></i>
                        <p class="text-muted mt-3">No brands yet. Add your first brand partner!</p>
                    </div>
                    <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($brands as $brand): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <img src="<?php echo FileUploader::getImagePath($brand['logo_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($brand['name']); ?>" 
                                         class="img-fluid mb-3" 
                                         style="max-height: 100px; object-fit: contain;">
                                    <h6 class="mb-2"><?php echo htmlspecialchars($brand['name']); ?></h6>
                                    <span class="badge bg-<?php echo $brand['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($brand['status']); ?>
                                    </span>
                                    <div class="mt-3 d-flex gap-1">
                                        <a href="?delete=<?php echo $brand['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-danger w-100" 
                                           onclick="return confirm('Delete this brand?')">
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
    
    <!-- Add Brand Modal -->
    <div class="modal fade" id="addBrandModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Brand Name</label>
                            <input type="text" name="name" class="form-control" required 
                                   placeholder="e.g., Fortis Healthcare">
                            <small class="text-muted">This will be used as alt text for the logo</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Brand Logo</label>
                            <input type="file" name="logo" class="form-control" accept="image/*" required>
                            <small class="text-muted">Upload 1:1 ratio logo (square). Max 2MB.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Display Order</label>
                            <input type="number" name="display_order" class="form-control" 
                                   value="0" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
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
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>
