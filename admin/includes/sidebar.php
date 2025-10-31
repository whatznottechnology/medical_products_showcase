<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="../assets/images/zic_logo.png" alt="ZEGNEN Logo" class="sidebar-logo">
        </div>
        <div class="admin-badge">
            <i class="bi bi-shield-check"></i>
            <span>Admin Panel</span>
        </div>
    </div>
    
    <div class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-section-title">Main Menu</div>
            
            <a href="index.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <span class="link-text">Dashboard</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="products.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' || basename($_SERVER['PHP_SELF']) === 'add-product.php' || basename($_SERVER['PHP_SELF']) === 'edit-product.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <span class="link-text">Products</span>
                <?php if (in_array(basename($_SERVER['PHP_SELF']), ['products.php', 'add-product.php', 'edit-product.php'])): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="inquiries.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'inquiries.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <span class="link-text">Inquiries</span>
                <?php if (isset($newInquiries) && $newInquiries > 0): ?>
                <span class="notification-badge"><?php echo $newInquiries; ?></span>
                <?php endif; ?>
                <?php if (basename($_SERVER['PHP_SELF']) === 'inquiries.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="leads.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'leads.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-people"></i>
                </div>
                <span class="link-text">Leads (Popup)</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'leads.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="careers.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'careers.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <span class="link-text">Career Applications</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'careers.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
        </div>
        
        <div class="menu-section">
            <div class="menu-section-title">Content</div>
            
            <a href="gallery.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'gallery.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-images"></i>
                </div>
                <span class="link-text">Gallery</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'gallery.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="brands.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'brands.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-award"></i>
                </div>
                <span class="link-text">Brands</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'brands.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="reviews.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'reviews.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-star"></i>
                </div>
                <span class="link-text">Reviews</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'reviews.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="banners.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'banners.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-image"></i>
                </div>
                <span class="link-text">Page Banners</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'banners.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="popup.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'popup.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-window-fullscreen"></i>
                </div>
                <span class="link-text">Popup Banner</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'popup.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
        </div>
        
        <div class="menu-section">
            <div class="menu-section-title">Settings</div>
            
            <a href="settings.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-gear"></i>
                </div>
                <span class="link-text">Website Settings</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
            
            <a href="profile.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : ''; ?>">
                <div class="link-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <span class="link-text">My Profile</span>
                <?php if (basename($_SERVER['PHP_SELF']) === 'profile.php'): ?>
                <div class="active-indicator"></div>
                <?php endif; ?>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-link logout-link">
                <div class="link-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <span class="link-text">Logout</span>
            </a>
        </div>
    </div>
</div>
