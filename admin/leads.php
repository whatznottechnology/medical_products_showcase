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
            $message = 'Lead status updated successfully!';
            $messageType = 'success';
            break;
        case 'deleted':
            $message = 'Lead deleted successfully!';
            $messageType = 'success';
            break;
    }
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $leadId = $_POST['lead_id'];
    $status = $_POST['status'];
    $db->update('leads', ['status' => $status], 'id = ?', [$leadId]);
    header('Location: leads.php?success=updated');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $leadId = $_GET['delete'];
    $db->delete('leads', 'id = ?', [$leadId]);
    header('Location: leads.php?success=deleted');
    exit;
}

// Get filter parameters
$statusFilter = $_GET['status'] ?? '';
$searchQuery = $_GET['search'] ?? '';

// Build query
$whereConditions = [];
$params = [];

if ($statusFilter) {
    $whereConditions[] = "status = ?";
    $params[] = $statusFilter;
}

if ($searchQuery) {
    $whereConditions[] = "(name LIKE ? OR phone LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$whereClause = $whereConditions ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Get leads
$leads = $db->fetchAll("SELECT * FROM leads $whereClause ORDER BY created_at DESC", $params);

// Get statistics
$totalLeads = $db->fetchOne("SELECT COUNT(*) as count FROM leads")['count'];
$newLeads = $db->fetchOne("SELECT COUNT(*) as count FROM leads WHERE status = 'new'")['count'];
$contactedLeads = $db->fetchOne("SELECT COUNT(*) as count FROM leads WHERE status = 'contacted'")['count'];
$convertedLeads = $db->fetchOne("SELECT COUNT(*) as count FROM leads WHERE status = 'converted'")['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Management - ZEGNEN Admin</title>
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
                    <i class="bi bi-people"></i> Leads Management
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Leads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalLeads; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">New Leads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newLeads; ?></div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Contacted</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contactedLeads; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-telephone fs-2 text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Converted</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $convertedLeads; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-gray-300"></i>
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
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control form-select">
                        <option value="">All Statuses</option>
                        <option value="new" <?php echo $statusFilter === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="contacted" <?php echo $statusFilter === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                        <option value="converted" <?php echo $statusFilter === 'converted' ? 'selected' : ''; ?>>Converted</option>
                        <option value="not_interested" <?php echo $statusFilter === 'not_interested' ? 'selected' : ''; ?>>Not Interested</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="<?php echo htmlspecialchars($searchQuery); ?>">
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

    <!-- Leads Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Leads (<?php echo count($leads); ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Source Page</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                                    No leads found
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($leads as $lead): ?>
                                <tr>
                                    <td><?php echo $lead['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($lead['name']); ?></strong>
                                        <?php if ($lead['status'] === 'new'): ?>
                                            <span class="badge badge-warning ml-2">New</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="tel:<?php echo htmlspecialchars($lead['phone']); ?>" class="text-primary">
                                            <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($lead['phone']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo htmlspecialchars($lead['source_page']); ?></small>
                                    </td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="new" <?php echo $lead['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                                <option value="contacted" <?php echo $lead['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                                <option value="converted" <?php echo $lead['status'] === 'converted' ? 'selected' : ''; ?>>Converted</option>
                                                <option value="not_interested" <?php echo $lead['status'] === 'not_interested' ? 'selected' : ''; ?>>Not Interested</option>
                                            </select>
                                            <input type="hidden" name="update_status" value="1">
                                        </form>
                                    </td>
                                    <td>
                                        <small><?php echo date('d M Y, h:i A', strtotime($lead['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <a href="?delete=<?php echo $lead['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this lead?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
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
