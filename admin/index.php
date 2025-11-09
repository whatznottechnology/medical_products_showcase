<?php
/**
 * Admin Dashboard - Main Entry Point
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/install.php';

// Detect environment for base URL
$isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
$baseUrl = $isLocalhost ? '/p/' : '/';

// Require authentication
Auth::require();

// Auto-install database if needed
$db = Database::getInstance();
if (!$db->tableExists('admin')) {
    $installer = new DatabaseInstaller();
    $installer->install();
}

// Get dashboard statistics
$totalProducts = $db->fetchOne("SELECT COUNT(*) as count FROM products")['count'] ?? 0;
$totalInquiries = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries")['count'] ?? 0;
$newInquiries = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries WHERE status = 'new'")['count'] ?? 0;
$totalGallery = $db->fetchOne("SELECT COUNT(*) as count FROM gallery")['count'] ?? 0;
$latestInquiries = $db->fetchAll("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5");

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ZEGNEN Admin</title>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </h1>
                <p class="text-muted">Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</p>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-primary">
                        <div class="stat-card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Total Products</p>
                                    <h3 class="stat-value"><?php echo $totalProducts; ?></h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            </div>
                        </div>
                        <a href="products.php" class="stat-card-footer">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Total Inquiries</p>
                                    <h3 class="stat-value"><?php echo $totalInquiries; ?></h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                        </div>
                        <a href="inquiries.php" class="stat-card-footer">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-warning">
                        <div class="stat-card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">New Leads</p>
                                    <h3 class="stat-value"><?php echo $newInquiries; ?></h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>
                        </div>
                        <a href="inquiries.php?status=new" class="stat-card-footer">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-info">
                        <div class="stat-card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Gallery Images</p>
                                    <h3 class="stat-value"><?php echo $totalGallery; ?></h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-images"></i>
                                </div>
                            </div>
                        </div>
                        <a href="gallery.php" class="stat-card-footer">
                            Manage Gallery <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Latest Inquiries -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-envelope-open"></i> Latest Inquiries
                    </h5>
                    <a href="inquiries.php" class="btn btn-sm btn-primary">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($latestInquiries)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No inquiries yet</p>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Product</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestInquiries as $inquiry): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($inquiry['phone']): ?>
                                        <small class="d-block"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($inquiry['phone']); ?></small>
                                        <?php endif; ?>
                                        <?php if ($inquiry['email']): ?>
                                        <small class="text-muted"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($inquiry['email']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($inquiry['product_name'] ?? 'N/A'); ?></td>
                                    <td><span class="badge bg-info"><?php echo htmlspecialchars($inquiry['source_page'] ?? 'Unknown'); ?></span></td>
                                    <td><small><?php echo date('M d, Y H:i', strtotime($inquiry['created_at'])); ?></small></td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'new' => 'warning',
                                            'read' => 'info',
                                            'replied' => 'success',
                                            'archived' => 'secondary'
                                        ][$inquiry['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $statusClass; ?>"><?php echo ucfirst($inquiry['status']); ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewInquiry(<?php echo $inquiry['id']; ?>)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
