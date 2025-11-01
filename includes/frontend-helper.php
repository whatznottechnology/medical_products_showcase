<?php
/**
 * Frontend Helper Functions
 * Include this file in your frontend pages to fetch dynamic data
 */

require_once __DIR__ . '/../config/Database.php';

class FrontendHelper {
    private static $db;
    private static $settings;
    
    /**
     * Initialize database connection
     */
    private static function init() {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
    }
    
    /**
     * Get a specific setting value
     */
    public static function getSetting($key, $default = '') {
        self::init();
        
        if (!self::$settings) {
            $settingsArray = self::$db->fetchAll("SELECT * FROM settings");
            self::$settings = [];
            foreach ($settingsArray as $setting) {
                self::$settings[$setting['setting_key']] = $setting['setting_value'];
            }
        }
        
        return self::$settings[$key] ?? $default;
    }
    
    /**
     * Get all active products
     */
    public static function getProducts($limit = null, $category = null) {
        self::init();
        
        $sql = "SELECT * FROM products WHERE status = 'active'";
        $params = [];
        
        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }
        
        return self::$db->fetchAll($sql, $params);
    }
    
    /**
     * Get product by ID
     */
    public static function getProduct($id) {
        self::init();
        $product = self::$db->fetchOne("SELECT * FROM products WHERE id = ? AND status = 'active'", [$id]);
        
        if ($product) {
            // Fetch product images
            $product['images'] = self::$db->fetchAll(
                "SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order", 
                [$id]
            );
            
            // Decode JSON fields
            $product['instructions'] = json_decode($product['instructions'] ?? '[]', true);
            $product['features'] = json_decode($product['features'] ?? '[]', true);
            $product['specifications'] = json_decode($product['specifications'] ?? '[]', true);
        }
        
        return $product;
    }
    
    /**
     * Get active gallery images
     */
    public static function getGalleryImages($limit = null) {
        self::init();
        
        $sql = "SELECT * FROM gallery WHERE status = 'active' ORDER BY display_order, created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return self::$db->fetchAll($sql, [$limit]);
        }
        
        return self::$db->fetchAll($sql);
    }
    
    /**
     * Get active brands
     */
    public static function getBrands($limit = null) {
        self::init();
        
        $sql = "SELECT * FROM brands WHERE status = 'active' ORDER BY display_order, created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return self::$db->fetchAll($sql, [$limit]);
        }
        
        return self::$db->fetchAll($sql);
    }
    
    /**
     * Get active reviews
     */
    public static function getReviews($location = 'homepage', $productId = null, $limit = null) {
        self::init();
        
        $sql = "SELECT * FROM reviews WHERE status = 'active' AND (display_location = ? OR display_location = 'both')";
        $params = [$location];
        
        if ($productId) {
            $sql .= " AND (product_id = ? OR product_id IS NULL)";
            $params[] = $productId;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }
        
        return self::$db->fetchAll($sql, $params);
    }
    
    /**
     * Get popup configuration
     */
    public static function getPopup() {
        self::init();
        return self::$db->fetchOne("SELECT * FROM popup WHERE is_enabled = 1 ORDER BY id DESC LIMIT 1");
    }
    
    /**
     * Format phone number for WhatsApp link
     */
    public static function formatWhatsAppNumber($number) {
        return preg_replace('/[^0-9]/', '', $number);
    }
    
    /**
     * Generate star rating HTML
     */
    public static function generateStars($rating, $maxStars = 5) {
        $html = '';
        for ($i = 1; $i <= $maxStars; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="bi bi-star-fill text-warning"></i>';
            } else {
                $html .= '<i class="bi bi-star text-muted"></i>';
            }
        }
        return $html;
    }
}

// Convenience functions
function get_setting($key, $default = '') {
    return FrontendHelper::getSetting($key, $default);
}

function get_products($limit = null, $category = null) {
    return FrontendHelper::getProducts($limit, $category);
}

function get_product($id) {
    return FrontendHelper::getProduct($id);
}

function get_gallery_images($limit = null) {
    return FrontendHelper::getGalleryImages($limit);
}

function get_brands($limit = null) {
    return FrontendHelper::getBrands($limit);
}

function get_reviews($location = 'homepage', $productId = null, $limit = null) {
    return FrontendHelper::getReviews($location, $productId, $limit);
}

function get_popup() {
    return FrontendHelper::getPopup();
}
