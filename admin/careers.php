<?php
session_start();
require_once '../config/Database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$db = Database::getInstance();
$user = $_SESSION['admin_user'] ?? ['name' => 'Admin'];

// Handle success messages from redirect
$message = '';
$messageType = '';
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'updated':
            $message = 'Career application status updated successfully!';
            $messageType = 'success';
            break;
        case 'deleted':
            $message = 'Career application deleted successfully!';
            $messageType = 'success';
            break;
    }
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $applicationId = $_POST['application_id'];
    $status = $_POST['status'];
    $db->update('career_applications', ['status' => $status], 'id = ?', [$applicationId]);
    header('Location: careers.php?success=updated');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $applicationId = $_GET['delete'];
    // Delete associated resume file if exists
    $application = $db->fetchOne("SELECT resume_path FROM career_applications WHERE id = ?", [$applicationId]);
    if ($application && $application['resume_path'] && file_exists('../' . $application['resume_path'])) {
        unlink('../' . $application['resume_path']);
    }
    $db->delete('career_applications', 'id = ?', [$applicationId]);
    header('Location: careers.php?success=deleted');
    exit;
}

// Get filter parameters
$statusFilter = $_GET['status'] ?? '';
$positionFilter = $_GET['position'] ?? '';
$searchQuery = $_GET['search'] ?? '';

// Build query
$whereConditions = [];
$params = [];

if ($statusFilter) {
    $whereConditions[] = "status = ?";
    $params[] = $statusFilter;
}

if ($positionFilter) {
    $whereConditions[] = "position = ?";
    $params[] = $positionFilter;
}

if ($searchQuery) {
    $whereConditions[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$whereClause = $whereConditions ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Get applications
$applications = $db->fetchAll("SELECT * FROM career_applications $whereClause ORDER BY created_at DESC", $params);

// Get statistics
$totalApplications = $db->fetchOne("SELECT COUNT(*) as count FROM career_applications")['count'];
$newApplications = $db->fetchOne("SELECT COUNT(*) as count FROM career_applications WHERE status = 'new'")['count'];
$shortlisted = $db->fetchOne("SELECT COUNT(*) as count FROM career_applications WHERE status = 'shortlisted'")['count'];
$hired = $db->fetchOne("SELECT COUNT(*) as count FROM career_applications WHERE status = 'hired'")['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Applications - ZEGNEN Admin</title>
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
                    <i class="bi bi-briefcase"></i> Career Applications
                </h1>
                <button class="btn btn-secondary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

<div class="container-fluid px-4 py-3">

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applications</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalApplications; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-file-earmark-text fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">New Applications</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newApplications; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-star fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Shortlisted</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $shortlisted; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hired</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $hired; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="new" <?php echo $statusFilter === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="reviewed" <?php echo $statusFilter === 'reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                        <option value="shortlisted" <?php echo $statusFilter === 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                        <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        <option value="hired" <?php echo $statusFilter === 'hired' ? 'selected' : ''; ?>>Hired</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Position</label>
                    <select name="position" class="form-control">
                        <option value="">All Positions</option>
                        <option value="quality-control">Quality Control</option>
                        <option value="sales-representative">Sales Representative</option>
                        <option value="technical-support">Technical Support</option>
                        <option value="marketing-specialist">Marketing Specialist</option>
                        <option value="research-development">R&D Scientist</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, email, or phone..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Applications (<?php echo count($applications); ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Position</th>
                            <th>Experience</th>
                            <th>Resume</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($applications)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                                    No applications found
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td><?php echo $app['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($app['name']); ?></strong>
                                        <?php if ($app['status'] === 'new'): ?>
                                            <span class="badge badge-warning ml-2">New</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>" class="text-primary">
                                                <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($app['email']); ?>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="tel:<?php echo htmlspecialchars($app['phone']); ?>" class="text-success">
                                                <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($app['phone']); ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($app['position']); ?></td>
                                    <td><small><?php echo htmlspecialchars($app['experience'] ?: 'N/A'); ?></small></td>
                                    <td>
                                        <?php if ($app['resume_path']): ?>
                                            <a href="../<?php echo htmlspecialchars($app['resume_path']); ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-download"></i> View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="new" <?php echo $app['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                                <option value="reviewed" <?php echo $app['status'] === 'reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                                                <option value="shortlisted" <?php echo $app['status'] === 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                                                <option value="rejected" <?php echo $app['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="hired" <?php echo $app['status'] === 'hired' ? 'selected' : ''; ?>>Hired</option>
                                            </select>
                                            <input type="hidden" name="update_status" value="1">
                                        </form>
                                    </td>
                                    <td>
                                        <small><?php echo date('d M Y, h:i A', strtotime($app['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <?php if ($app['cover_letter']): ?>
                                            <button class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#coverLetterModal<?php echo $app['id']; ?>">
                                                <i class="bi bi-eye"></i> View Letter
                                            </button>
                                        <?php endif; ?>
                                        <a href="?delete=<?php echo $app['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this application?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        
                                        <!-- Cover Letter Modal -->
                                        <?php if ($app['cover_letter']): ?>
                                        <div class="modal fade" id="coverLetterModal<?php echo $app['id']; ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cover Letter - <?php echo htmlspecialchars($app['name']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><?php echo nl2br(htmlspecialchars($app['cover_letter'])); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/admin.js"></script>
</body>
</html>
