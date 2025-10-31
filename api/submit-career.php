<?php
/**
 * Submit Career Application API Endpoint
 * Handles career application form submissions with file upload
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
    $position = trim($_POST['position'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $coverLetter = trim($_POST['cover_letter'] ?? '');
    
    if (empty($name) || empty($email) || empty($phone) || empty($position)) {
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
    
    // Handle resume file upload
    $resumePath = null;
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/resumes/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Only PDF, DOC, and DOCX files are allowed for resume'
            ]);
            exit;
        }
        
        // Check file size (max 5MB)
        if ($_FILES['resume']['size'] > 5 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Resume file size must be less than 5MB'
            ]);
            exit;
        }
        
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['resume']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
            $resumePath = 'uploads/resumes/' . $fileName;
        }
    }
    
    // Prepare application data
    $applicationData = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'position' => $position,
        'experience' => $experience,
        'resume_path' => $resumePath,
        'cover_letter' => $coverLetter,
        'source_url' => $_POST['source_url'] ?? $_SERVER['HTTP_REFERER'] ?? '',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'status' => 'new'
    ];
    
    // Insert into database
    $applicationId = $db->insert('career_applications', $applicationData);
    
    if ($applicationId) {
        echo json_encode([
            'success' => true,
            'message' => 'Your application has been submitted successfully!',
            'application_id' => $applicationId
        ]);
    } else {
        throw new Exception('Failed to save application');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.',
        'error' => $e->getMessage()
    ]);
}
