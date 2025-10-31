<?php
/**
 * Reviews Management
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
            $message = 'Review added successfully!';
            $messageType = 'success';
            break;
        case 'updated':
            $message = 'Review updated successfully!';
            $messageType = 'success';
            break;
        case 'deleted':
            $message = 'Review deleted successfully!';
            $messageType = 'success';
            break;
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $reviewData = [
            'customer_name' => $_POST['customer_name'] ?? '',
            'customer_role' => $_POST['customer_role'] ?? '',
            'rating' => (int)($_POST['rating'] ?? 5),
            'comment' => $_POST['comment'] ?? '',
            'display_location' => $_POST['display_location'] ?? 'homepage',
            'status' => $_POST['status'] ?? 'active'
        ];
        
        if (isset($_POST['review_id']) && !empty($_POST['review_id'])) {
            $reviewId = (int)$_POST['review_id'];
            $db->query(
                "UPDATE reviews SET customer_name = ?, customer_role = ?, rating = ?, comment = ?, display_location = ?, status = ? WHERE id = ?",
                [
                    $reviewData['customer_name'],
                    $reviewData['customer_role'],
                    $reviewData['rating'],
                    $reviewData['comment'],
                    $reviewData['display_location'],
                    $reviewData['status'],
                    $reviewId
                ]
            );
            header('Location: reviews.php?success=updated');
            exit;
        } else {
            $db->insert('reviews', $reviewData);
            header('Location: reviews.php?success=added');
            exit;
        }
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Quick Status Toggle
if (isset($_GET['toggle_status']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $reviewId = (int)$_GET['toggle_status'];
        $currentReview = $db->fetchOne("SELECT status FROM reviews WHERE id = ?", [$reviewId]);
        if ($currentReview) {
            $newStatus = $currentReview['status'] === 'active' ? 'inactive' : 'active';
            $db->query("UPDATE reviews SET status = ? WHERE id = ?", [$newStatus, $reviewId]);
            $message = 'Review status toggled successfully!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error toggling status: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Homepage Display Toggle
if (isset($_GET['toggle_homepage']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $reviewId = (int)$_GET['toggle_homepage'];
        $currentReview = $db->fetchOne("SELECT display_location FROM reviews WHERE id = ?", [$reviewId]);
        if ($currentReview) {
            // Toggle between homepage and product
            $newLocation = ($currentReview['display_location'] === 'homepage' || $currentReview['display_location'] === 'both') ? 'product' : 'homepage';
            $db->query("UPDATE reviews SET display_location = ? WHERE id = ?", [$newLocation, $reviewId]);
            $message = 'Homepage display toggled successfully!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error toggling homepage display: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle Delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $db->delete('reviews', 'id = ?', [(int)$_GET['delete']]);
        $message = 'Review deleted successfully!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting review: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

$reviews = $db->fetchAll("SELECT * FROM reviews ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - ZEGNEN Admin</title>
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
                    <i class="bi bi-star"></i> Reviews Management
                </h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                    <i class="bi bi-plus-circle"></i> Add New Review
                </button>
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
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Show on Homepage</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reviews as $review): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($review['customer_name']); ?></strong>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($review['customer_role']); ?></small>
                                    </td>
                                    <td>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo $i <= $review['rating'] ? '-fill text-warning' : ' text-muted'; ?>"></i>
                                        <?php endfor; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars(substr($review['comment'], 0, 100)) . '...'; ?></td>
                                    <td><span class="badge bg-info"><?php echo ucfirst($review['display_location']); ?></span></td>
                                    <td>
                                        <span class="badge bg-<?php echo $review['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($review['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $isOnHomepage = in_array($review['display_location'], ['homepage', 'both']);
                                        $isActive = $review['status'] === 'active';
                                        ?>
                                        <a href="?toggle_homepage=<?php echo $review['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-<?php echo $isOnHomepage ? 'success' : 'outline-secondary'; ?>"
                                           title="<?php echo $isOnHomepage ? 'Hide from homepage' : 'Show on homepage'; ?>">
                                            <i class="bi bi-<?php echo $isOnHomepage ? 'check-circle-fill' : 'circle'; ?>"></i>
                                            <?php echo $isOnHomepage ? 'Showing' : 'Hidden'; ?>
                                        </a>
                                        <?php if ($isOnHomepage && !$isActive): ?>
                                        <br><small class="text-warning"><i class="bi bi-exclamation-triangle"></i> Review inactive</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-review-btn" 
                                                data-review='<?php echo json_encode($review); ?>'
                                                title="Edit Review">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="?toggle_status=<?php echo $review['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-outline-<?php echo $review['status'] === 'active' ? 'warning' : 'success'; ?>"
                                           title="Toggle Status">
                                            <i class="bi bi-toggle-<?php echo $review['status'] === 'active' ? 'on' : 'off'; ?>"></i>
                                        </a>
                                        <a href="?delete=<?php echo $review['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Delete this review?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($reviews)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-star display-1 text-muted"></i>
                                        <p class="text-muted mt-3">No reviews yet. Add your first review!</p>
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
    
    <!-- Add Review Modal -->
    <div class="modal fade" id="addReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" required 
                                       placeholder="Dr. John Smith">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Role/Title</label>
                                <input type="text" name="customer_role" class="form-control" 
                                       placeholder="CSSD Manager, Apollo Hospital">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rating</label>
                                <select name="rating" class="form-select" required>
                                    <option value="5" selected>⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3">⭐⭐⭐ (3 stars)</option>
                                    <option value="2">⭐⭐ (2 stars)</option>
                                    <option value="1">⭐ (1 star)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Display Location</label>
                                <select name="display_location" class="form-select">
                                    <option value="homepage">Homepage Only</option>
                                    <option value="product">All Product Pages</option>
                                    <option value="both">Homepage + All Product Pages</option>
                                </select>
                                <small class="text-muted">Reviews with "Product" or "Both" will show on all product detail pages</small>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Review Comment</label>
                                <textarea name="comment" class="form-control" rows="4" required 
                                          placeholder="Outstanding product quality..."></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        <input type="hidden" name="review_id" id="edit_review_id">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Name</label>
                                <input type="text" name="customer_name" id="edit_customer_name" class="form-control" required 
                                       placeholder="Dr. John Smith">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Role/Title</label>
                                <input type="text" name="customer_role" id="edit_customer_role" class="form-control" 
                                       placeholder="CSSD Manager, Apollo Hospital">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rating</label>
                                <select name="rating" id="edit_rating" class="form-select" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3">⭐⭐⭐ (3 stars)</option>
                                    <option value="2">⭐⭐ (2 stars)</option>
                                    <option value="1">⭐ (1 star)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Display Location</label>
                                <select name="display_location" id="edit_display_location" class="form-select">
                                    <option value="homepage">Homepage Only</option>
                                    <option value="product">All Product Pages</option>
                                    <option value="both">Homepage + All Product Pages</option>
                                </select>
                                <small class="text-muted">Reviews with "Product" or "Both" will show on all product detail pages</small>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Review Comment</label>
                                <textarea name="comment" id="edit_comment" class="form-control" rows="4" required 
                                          placeholder="Outstanding product quality..."></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="edit_status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
    // Edit review functionality
    document.querySelectorAll('.edit-review-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const review = JSON.parse(this.getAttribute('data-review'));
            
            // Populate form fields
            document.getElementById('edit_review_id').value = review.id;
            document.getElementById('edit_customer_name').value = review.customer_name;
            document.getElementById('edit_customer_role').value = review.customer_role || '';
            document.getElementById('edit_rating').value = review.rating;
            document.getElementById('edit_display_location').value = review.display_location;
            document.getElementById('edit_comment').value = review.comment;
            document.getElementById('edit_status').value = review.status;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            modal.show();
        });
    });
    </script>
</body>
</html>
