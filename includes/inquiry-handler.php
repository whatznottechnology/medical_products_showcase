<?php
/**
 * Inquiry Form Handler
 * Place this at the top of pages with forms
 */

require_once 'config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inquiry_submit'])) {
    $db = Database::getInstance();
    
    try {
        // Sanitize and validate input
        $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $phone = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING);
        $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);
        $productName = filter_var($_POST['product_name'] ?? '', FILTER_SANITIZE_STRING);
        
        // Validation
        $errors = [];
        if (empty($name)) $errors[] = 'Name is required';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
        if (empty($phone)) $errors[] = 'Phone is required';
        if (empty($message)) $errors[] = 'Message is required';
        
        if (empty($errors)) {
            // Insert inquiry
            $inquiryId = $db->insert('inquiries', [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message,
                'product_name' => $productName,
                'source_page' => basename($_SERVER['PHP_SELF']),
                'source_url' => $_SERVER['REQUEST_URI'] ?? '',
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'status' => 'new'
            ]);
            
            // Redirect to thank you page
            header('Location: thank-you.php');
            exit;
        }
    } catch (Exception $e) {
        $errors[] = 'An error occurred. Please try again.';
        error_log('Inquiry submission error: ' . $e->getMessage());
    }
}
?>
