<?php
/**
 * Database Installation Script
 * Creates all required tables automatically
 */

require_once __DIR__ . '/Database.php';

class DatabaseInstaller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Run installation
     */
    public function install() {
        try {
            $this->createAdminTable();
            $this->createSettingsTable();
            $this->createProductsTable();
            $this->createProductImagesTable();
            $this->createInquiriesTable();
            $this->createGalleryTable();
            $this->createBrandsTable();
            $this->createReviewsTable();
            $this->createPopupTable();
            $this->insertDefaultData();
            
            return ['success' => true, 'message' => 'Database tables created successfully!'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Installation failed: ' . $e->getMessage()];
        }
    }
    
    /**
     * Create admin table
     */
    private function createAdminTable() {
        $sql = "CREATE TABLE IF NOT EXISTS admin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(100) NOT NULL DEFAULT 'Admin',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create settings table
     */
    private function createSettingsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT,
            setting_type VARCHAR(50) DEFAULT 'text',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create products table
     */
    private function createProductsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255),
            category VARCHAR(100),
            description TEXT,
            details LONGTEXT,
            price_min DECIMAL(10,2),
            price_max DECIMAL(10,2),
            price_unit VARCHAR(50),
            badge VARCHAR(100),
            main_image VARCHAR(255),
            video_url VARCHAR(500),
            instructions TEXT,
            features TEXT,
            specifications TEXT,
            meta_title VARCHAR(255),
            meta_description TEXT,
            meta_keywords TEXT,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create product images table (for parallax images)
     */
    private function createProductImagesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS product_images (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            image_type ENUM('parallax', 'gallery') DEFAULT 'parallax',
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create inquiries table
     */
    private function createInquiriesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS inquiries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255),
            phone VARCHAR(20),
            subject VARCHAR(255),
            message TEXT,
            product_name VARCHAR(255),
            source_page VARCHAR(100),
            source_url VARCHAR(500),
            ip_address VARCHAR(45),
            user_agent TEXT,
            status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create gallery table
     */
    private function createGalleryTable() {
        $sql = "CREATE TABLE IF NOT EXISTS gallery (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_path VARCHAR(255) NOT NULL,
            image_type VARCHAR(50) DEFAULT 'landscape',
            alt_text VARCHAR(255) DEFAULT 'zegnen',
            display_order INT DEFAULT 0,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create brands table
     */
    private function createBrandsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS brands (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            logo_path VARCHAR(255) NOT NULL,
            display_order INT DEFAULT 0,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create reviews table
     */
    private function createReviewsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(100) NOT NULL,
            customer_role VARCHAR(100),
            rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
            comment TEXT NOT NULL,
            product_id INT NULL,
            display_location ENUM('homepage', 'product', 'both') DEFAULT 'homepage',
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Create popup table
     */
    private function createPopupTable() {
        $sql = "CREATE TABLE IF NOT EXISTS popup (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_path VARCHAR(255) NOT NULL,
            alt_text VARCHAR(255) DEFAULT 'zegnen',
            is_enabled BOOLEAN DEFAULT true,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->db->query($sql);
    }
    
    /**
     * Insert default data
     */
    private function insertDefaultData() {
        // Create default admin user
        $adminEmail = $_ENV['ADMIN_EMAIL'] ?? 'admin@zegnen.com';
        $adminPassword = password_hash($_ENV['ADMIN_PASSWORD'] ?? 'Admin@123', PASSWORD_DEFAULT);
        
        $existingAdmin = $this->db->fetchOne("SELECT id FROM admin WHERE email = ?", [$adminEmail]);
        if (!$existingAdmin) {
            $this->db->insert('admin', [
                'email' => $adminEmail,
                'password' => $adminPassword,
                'name' => 'Administrator'
            ]);
        }
        
        // Insert default settings
        $defaultSettings = [
            ['setting_key' => 'site_name', 'setting_value' => 'ZEGNEN', 'setting_type' => 'text'],
            ['setting_key' => 'call_number', 'setting_value' => '+91 89020 56626', 'setting_type' => 'text'],
            ['setting_key' => 'whatsapp_number', 'setting_value' => '918902056626', 'setting_type' => 'text'],
            ['setting_key' => 'email', 'setting_value' => 'info@zegnen.com', 'setting_type' => 'text'],
            ['setting_key' => 'banner_image', 'setting_value' => 'assets/images/banner.jpg', 'setting_type' => 'image'],
            ['setting_key' => 'facebook_url', 'setting_value' => '#', 'setting_type' => 'text'],
            ['setting_key' => 'instagram_url', 'setting_value' => '#', 'setting_type' => 'text'],
            ['setting_key' => 'youtube_url', 'setting_value' => '#', 'setting_type' => 'text'],
            ['setting_key' => 'linkedin_url', 'setting_value' => '#', 'setting_type' => 'text'],
            ['setting_key' => 'twitter_url', 'setting_value' => '#', 'setting_type' => 'text'],
        ];
        
        foreach ($defaultSettings as $setting) {
            $existing = $this->db->fetchOne(
                "SELECT id FROM settings WHERE setting_key = ?", 
                [$setting['setting_key']]
            );
            if (!$existing) {
                $this->db->insert('settings', $setting);
            }
        }
    }
}

// Auto-run installation if accessed directly
if (basename($_SERVER['PHP_SELF']) === 'install.php') {
    $installer = new DatabaseInstaller();
    $result = $installer->install();
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
