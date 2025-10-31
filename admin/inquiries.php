<?php
/**
 * Inquiries Management Module
 * View, search, filter, and manage all form submissions
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle status update
if (isset($_POST['update_status']) && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $inquiryId = (int)$_POST['inquiry_id'];
        $status = $_POST['status'];
        
        $db->query(
            "UPDATE inquiries SET status = ? WHERE id = ?",
            [$status, $inquiryId]
        );
        $message = 'Inquiry status updated!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error updating status: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle delete
if (isset($_GET['delete']) && Auth::verifyToken($_GET['token'] ?? '')) {
    try {
        $db->delete('inquiries', 'id = ?', [(int)$_GET['delete']]);
        $message = 'Inquiry deleted successfully!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting inquiry: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Filters
$statusFilter = $_GET['status'] ?? '';
$searchQuery = $_GET['search'] ?? '';

// Build query
$sql = "SELECT * FROM inquiries WHERE 1=1";
$params = [];

if ($statusFilter) {
    $sql .= " AND status = ?";
    $params[] = $statusFilter;
}

if ($searchQuery) {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR product_name LIKE ?)";
    $searchTerm = "%{$searchQuery}%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$sql .= " ORDER BY created_at DESC";

$inquiries = $db->fetchAll($sql, $params);

// Statistics
$totalInquiries = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries")['count'] ?? 0;
$newCount = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries WHERE status = 'new'")['count'] ?? 0;
$readCount = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries WHERE status = 'read'")['count'] ?? 0;
$repliedCount = $db->fetchOne("SELECT COUNT(*) as count FROM inquiries WHERE status = 'replied'")['count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries - ZEGNEN Admin</title>
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
                    <i class="bi bi-envelope"></i> Inquiries Management
                </h1>
                <button class="btn btn-success" onclick="exportToCSV()">
                    <i class="bi bi-download"></i> Export to CSV
                </button>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <!-- Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-0"><?php echo $totalInquiries; ?></h3>
                            <p class="text-muted mb-0">Total Inquiries</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-warning">
                        <div class="card-body">
                            <h3 class="mb-0 text-warning"><?php echo $newCount; ?></h3>
                            <p class="text-muted mb-0">New</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-info">
                        <div class="card-body">
                            <h3 class="mb-0 text-info"><?php echo $readCount; ?></h3>
                            <p class="text-muted mb-0">Read</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h3 class="mb-0 text-success"><?php echo $repliedCount; ?></h3>
                            <p class="text-muted mb-0">Replied</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by name, email, phone..." 
                                   value="<?php echo htmlspecialchars($searchQuery); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="new" <?php echo $statusFilter === 'new' ? 'selected' : ''; ?>>New</option>
                                <option value="read" <?php echo $statusFilter === 'read' ? 'selected' : ''; ?>>Read</option>
                                <option value="replied" <?php echo $statusFilter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                <option value="archived" <?php echo $statusFilter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="inquiries.php" class="btn btn-secondary w-100">
                                <i class="bi bi-x-circle"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Inquiries Table -->
            <div class="card">
                <div class="card-body p-0">
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inquiries as $inquiry): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($inquiry['name']); ?></strong></td>
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
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="viewInquiry(<?php echo $inquiry['id']; ?>)" 
                                                title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="?delete=<?php echo $inquiry['id']; ?>&token=<?php echo Auth::generateToken(); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Delete this inquiry?')" 
                                           title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($inquiries)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox display-1 text-muted"></i>
                                        <p class="text-muted mt-3">No inquiries found</p>
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
    
    <!-- View Inquiry Modal -->
    <div class="modal fade" id="viewInquiryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-envelope-open"></i> Inquiry Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="inquiryDetails">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST" class="d-flex gap-2 w-100" id="statusUpdateForm">
                        <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                        <input type="hidden" name="inquiry_id" id="modalInquiryId">
                        <input type="hidden" name="update_status" value="1">
                        <select name="status" class="form-select" style="max-width: 200px;">
                            <option value="new">New</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                            <option value="archived">Archived</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Status
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
    const inquiriesData = <?php echo json_encode($inquiries); ?>;
    
    function exportToCSV() {
        let csv = 'Name,Email,Phone,Subject,Product,Message,Source,Date,Status\n';
        
        <?php foreach ($inquiries as $inquiry): ?>
        csv += '<?php echo addslashes($inquiry["name"]); ?>,'
            + '<?php echo addslashes($inquiry["email"] ?? ""); ?>,'
            + '<?php echo addslashes($inquiry["phone"] ?? ""); ?>,'
            + '<?php echo addslashes($inquiry["subject"] ?? ""); ?>,'
            + '<?php echo addslashes($inquiry["product_name"] ?? ""); ?>,'
            + '"<?php echo addslashes(str_replace(["\r", "\n"], " ", $inquiry["message"] ?? "")); ?>",'
            + '<?php echo addslashes($inquiry["source_page"] ?? ""); ?>,'
            + '<?php echo date("Y-m-d H:i:s", strtotime($inquiry["created_at"])); ?>,'
            + '<?php echo $inquiry["status"]; ?>\n';
        <?php endforeach; ?>
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'inquiries_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }
    
    function viewInquiry(id) {
        const inquiry = inquiriesData.find(i => i.id == id);
        if (!inquiry) return;
        
        const statusBadges = {
            'new': 'warning',
            'read': 'info',
            'replied': 'success',
            'archived': 'secondary'
        };
        
        const html = `
            <div class="row g-3">
                <div class="col-md-6">
                    <strong><i class="bi bi-person"></i> Name:</strong><br>
                    <span class="text-muted">${inquiry.name || 'N/A'}</span>
                </div>
                <div class="col-md-6">
                    <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                    <span class="text-muted">${inquiry.email || 'N/A'}</span>
                </div>
                <div class="col-md-6">
                    <strong><i class="bi bi-telephone"></i> Phone:</strong><br>
                    <span class="text-muted">${inquiry.phone || 'N/A'}</span>
                </div>
                <div class="col-md-6">
                    <strong><i class="bi bi-box"></i> Product:</strong><br>
                    <span class="text-muted">${inquiry.product_name || 'N/A'}</span>
                </div>
                <div class="col-md-6">
                    <strong><i class="bi bi-globe"></i> Source Page:</strong><br>
                    <span class="badge bg-info">${inquiry.source_page || 'Unknown'}</span>
                </div>
                <div class="col-md-6">
                    <strong><i class="bi bi-calendar"></i> Date:</strong><br>
                    <span class="text-muted">${new Date(inquiry.created_at).toLocaleString()}</span>
                </div>
                ${inquiry.subject ? `
                <div class="col-12">
                    <strong><i class="bi bi-chat-square-text"></i> Subject:</strong><br>
                    <span class="text-muted">${inquiry.subject}</span>
                </div>
                ` : ''}
                <div class="col-12">
                    <strong><i class="bi bi-chat-dots"></i> Message:</strong><br>
                    <div class="bg-light p-3 rounded mt-2">
                        <p class="mb-0">${inquiry.message || 'No message'}</p>
                    </div>
                </div>
                ${inquiry.ip_address ? `
                <div class="col-md-6">
                    <strong><i class="bi bi-router"></i> IP Address:</strong><br>
                    <span class="text-muted">${inquiry.ip_address}</span>
                </div>
                ` : ''}
                <div class="col-md-6">
                    <strong><i class="bi bi-tag"></i> Status:</strong><br>
                    <span class="badge bg-${statusBadges[inquiry.status] || 'secondary'}">${inquiry.status.toUpperCase()}</span>
                </div>
            </div>
        `;
        
        document.getElementById('inquiryDetails').innerHTML = html;
        document.getElementById('modalInquiryId').value = id;
        document.querySelector('#statusUpdateForm select[name="status"]').value = inquiry.status;
        
        const modal = new bootstrap.Modal(document.getElementById('viewInquiryModal'));
        modal.show();
    }
    </script>
</body>
</html>
