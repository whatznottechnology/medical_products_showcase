<?php
/**
 * Submit Lead API Endpoint
 * Handles popup lead form submissions (name + phone only)
 */

header('Content-Type: application/json');

require_once '../config/Database.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    $db = Database::getInstance();
    
    // Validate required fields
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    if (empty($name) || empty($phone)) {
        http_response_code(400);
        echo json_encode([
            'success' => false, 
            'message' => 'Please fill in all required fields'
        ]);
        exit;
    }
    
    // Prepare lead data
    $leadData = [
        'name' => $name,
        'phone' => $phone,
        'source_page' => $_POST['source_page'] ?? 'popup',
        'source_url' => $_POST['source_url'] ?? $_SERVER['HTTP_REFERER'] ?? '',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'status' => 'new'
    ];
    
    // Insert into database
    $leadId = $db->insert('leads', $leadData);
    
    if ($leadId) {
        echo json_encode([
            'success' => true,
            'message' => 'Thank you! Our team will contact you soon.',
            'lead_id' => $leadId
        ]);
    } else {
        throw new Exception('Failed to save lead');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.',
        'error' => $e->getMessage()
    ]);
}
