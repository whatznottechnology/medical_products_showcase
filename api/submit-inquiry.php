<?php
/**
 * Submit Inquiry API Endpoint
 * Handles all inquiry form submissions (product details, contact us, popup)
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
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo json_encode([
            'success' => false, 
            'message' => 'Please fill in all required fields'
        ]);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            'success' => false, 
            'message' => 'Please enter a valid email address'
        ]);
        exit;
    }
    
    // Prepare inquiry data
    $inquiryData = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $_POST['subject'] ?? 'Product Inquiry',
        'message' => $message,
        'product_name' => $_POST['product_name'] ?? null,
        'source_page' => $_POST['source_page'] ?? 'Unknown',
        'source_url' => $_POST['source_url'] ?? $_SERVER['HTTP_REFERER'] ?? '',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'status' => 'new'
    ];
    
    // Insert into database
    $inquiryId = $db->insert('inquiries', $inquiryData);
    
    if ($inquiryId) {
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your inquiry! We will contact you within 24 hours.',
            'inquiry_id' => $inquiryId
        ]);
    } else {
        throw new Exception('Failed to save inquiry');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.',
        'error' => $e->getMessage()
    ]);
}
