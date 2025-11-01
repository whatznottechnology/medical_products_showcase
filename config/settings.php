<?php
/**
 * Settings Helper
 * Fetch and cache settings from database
 */

function getSettings() {
    static $settings = null;
    
    if ($settings === null) {
        try {
            require_once __DIR__ . '/Database.php';
            $db = Database::getInstance();
            
            // Fetch all settings as key-value pairs
            $settingsArray = $db->fetchAll("SELECT setting_key, setting_value FROM settings");
            $settings = [];
            
            foreach ($settingsArray as $setting) {
                $settings[$setting['setting_key']] = $setting['setting_value'];
            }
        } catch (Exception $e) {
            // Log error but don't provide fallback data
            error_log("Settings database error: " . $e->getMessage());
            $settings = [];
        }
    }
    
    return $settings;
}

/**
 * Get setting value by key
 */
function getSetting($key, $default = '') {
    $settings = getSettings();
    return isset($settings[$key]) && !empty($settings[$key]) ? $settings[$key] : $default;
}

/**
 * Check if social link is valid (not empty and not #)
 */
function hasSocialLink($link) {
    return !empty($link) && trim($link) !== '' && trim($link) !== '#';
}

/**
 * Get formatted WhatsApp URL
 */
function getWhatsAppUrl($message = 'Hello! I am interested in your products.') {
    $whatsapp = getSetting('whatsapp_number');
    if (empty($whatsapp)) {
        return '#';
    }
    
    // Remove any non-digit characters
    $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
    
    // Ensure it starts with country code
    if (!str_starts_with($whatsapp, '91') && strlen($whatsapp) === 10) {
        $whatsapp = '91' . $whatsapp;
    }
    
    return 'https://wa.me/' . $whatsapp . '?text=' . urlencode($message);
}

/**
 * Get formatted phone URL
 */
function getPhoneUrl() {
    $phone = getSetting('call_number');
    if (empty($phone)) {
        return '#';
    }
    
    return 'tel:' . $phone;
}

/**
 * Get formatted email URL
 */
function getEmailUrl($subject = 'Inquiry') {
    $email = getSetting('email');
    if (empty($email)) {
        return '#';
    }
    
    return 'mailto:' . $email . '?subject=' . urlencode($subject);
}
