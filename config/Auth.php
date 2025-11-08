<?php
/**
 * Session and Authentication Helper
 */

class Auth {
    
    /**
     * Start session if not already started
     */
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Check if user is authenticated
     */
    public static function check() {
        self::init();
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    /**
     * Login user
     */
    public static function login($adminData) {
        self::init();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $adminData['id'];
        $_SESSION['admin_email'] = $adminData['email'];
        $_SESSION['admin_name'] = $adminData['name'];
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        self::init();
        session_destroy();
        session_unset();
    }
    
    /**
     * Get logged in admin data
     */
    public static function user() {
        self::init();
        if (self::check()) {
            return [
                'id' => $_SESSION['admin_id'] ?? null,
                'email' => $_SESSION['admin_email'] ?? null,
                'name' => $_SESSION['admin_name'] ?? null,
            ];
        }
        return null;
    }
    
    /**
     * Require authentication (redirect to login if not authenticated)
     */
    public static function require() {
        if (!self::check()) {
            $baseUrl = self::getBaseUrl();
            header('Location: ' . $baseUrl . '/admin/login.php');
            exit;
        }
        
        // Check session timeout (30 minutes)
        $timeout = 1800;
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            self::logout();
            $baseUrl = self::getBaseUrl();
            header('Location: ' . $baseUrl . '/admin/login.php?timeout=1');
            exit;
        }
        
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Get base URL (with /p for localhost, without for production)
     */
    private static function getBaseUrl() {
        $isLocalhost = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || 
                       strpos($_SERVER['HTTP_HOST'] ?? '', '127.0.0.1') !== false;
        return $isLocalhost ? '/p' : '';
    }
    
    /**
     * Generate CSRF token
     */
    public static function generateToken() {
        self::init();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyToken($token) {
        self::init();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
