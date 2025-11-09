<?php
/**
 * Products List - Main View
 * Displays all products with links to add/edit individual pages
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

// Handle Delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $productId = (int)$_GET['delete'];
        
        // Get product with images
        $product = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$productId]);
        $productImages = $db->fetchAll("SELECT * FROM product_images WHERE product_id = ?", [$productId]);
        
        if ($product) {
            $uploader = new FileUploader();
            
            // Delete main image
            if ($product['main_image']) {
                $uploader->delete($product['main_image']);
            }
            
            // Delete parallax images
            foreach ($productImages as $img) {
                $uploader->delete($img['image_path']);
            }
            
            // Delete from database
            $db->delete('product_images', 'product_id = ?', [$productId]);
            $db->delete('products', 'id = ?', [$productId]);
            
            $message = 'Product deleted successfully!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error deleting product: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Fetch all products
$products = $db->fetchAll("SELECT * FROM products ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - ZEGNEN Admin</title>
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
                    <i class="bi bi-box-seam"></i> Products Management
                </h1>
                <a href="add-product.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Product
                </a>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price Range</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <?php if ($product['main_image']): ?>
                                        <img src="<?php echo FileUploader::getImagePath($product['main_image']); ?>" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                        <?php if ($product['subtitle']): ?>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($product['subtitle']); ?></small>
                                        <?php endif; ?>
                                        <?php if ($product['badge']): ?>
                                        <br><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($product['badge']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($product['price_min'] && $product['price_max']): ?>
                                        ₹<?php echo number_format($product['price_min']); ?> - 
                                        ₹<?php echo number_format($product['price_max']); ?>
                                        <?php elseif ($product['price_min']): ?>
                                        ₹<?php echo number_format($product['price_min']); ?>+
                                        <?php else: ?>
                                        <span class="text-muted">Contact</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $product['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($product['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                                    <td>
                                        <a href="edit-product.php?id=<?php echo $product['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit Product">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="?delete=<?php echo $product['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Delete this product and all its images? This cannot be undone!')" 
                                           title="Delete Product">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox display-1 text-muted"></i>
                                        <p class="text-muted mt-3 mb-2">No products yet</p>
                                        <a href="add-product.php" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Add Your First Product
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>admin/assets/js/admin.js"></script>
</body>
</html>
