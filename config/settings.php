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
            
            // If no settings found, return defaults
            if (empty($settings)) {
                $settings = [
                    'site_name' => 'ZEGNEN',
                    'email' => 'info@zegnen.com',
                    'call_number' => '+91 89020 56626',
                    'whatsapp_number' => '918902056626',
                    'address' => 'India',
                    'facebook_url' => '',
                    'instagram_url' => '',
                    'twitter_url' => '',
                    'youtube_url' => '',
                    'linkedin_url' => ''
                ];
            }
        } catch (Exception $e) {
            // Fallback to defaults if database error
            error_log("Settings database error: " . $e->getMessage());
            $settings = [
                'site_name' => 'ZEGNEN',
                'email' => 'info@zegnen.com',
                'call_number' => '+91 89020 56626',
                'whatsapp_number' => '918902056626',
                'address' => 'India',
                'facebook_url' => '',
                'instagram_url' => '',
                'twitter_url' => '',
                'youtube_url' => '',
                'linkedin_url' => ''
            ];
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
