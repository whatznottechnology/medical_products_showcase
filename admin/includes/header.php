<!-- Top Header -->
<div class="top-header">
    <button class="btn btn-link text-dark d-lg-none" id="sidebarToggle">
        <i class="bi bi-list fs-4"></i>
    </button>
    
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-muted d-none d-md-inline">
            <i class="bi bi-calendar3"></i> <?php echo date('F d, Y'); ?>
        </span>
        
        <div class="dropdown">
            <button class="btn btn-link text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-5"></i>
                <span class="d-none d-md-inline ms-2"><?php echo htmlspecialchars($user['name'] ?? 'Admin'); ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> My Profile</a></li>
                <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear"></i> Website Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
