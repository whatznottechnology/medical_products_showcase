<?php
/**
 * File Upload Helper
 */

class FileUploader {
    private $uploadDir;
    private $maxFileSize;
    private $allowedTypes;
    
    public function __construct($uploadDir = 'uploads/') {
        $this->uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/p/' . $uploadDir;
        $this->maxFileSize = (int)($_ENV['MAX_FILE_SIZE'] ?? 2097152); // 2MB default
        $this->allowedTypes = explode(',', $_ENV['ALLOWED_IMAGE_TYPES'] ?? 'jpg,jpeg,png,webp');
        
        // Create upload directory if it doesn't exist
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    /**
     * Upload a single file
     */
    public function upload($file, $subfolder = '') {
        try {
            // Validate file
            $this->validateFile($file);
            
            // Generate unique filename
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = time() . '_' . uniqid() . '.' . $extension;
            
            // Set destination path
            $destinationDir = $this->uploadDir . $subfolder;
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            
            $destinationPath = $destinationDir . '/' . $filename;
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                // Return relative path from document root
                return str_replace($_SERVER['DOCUMENT_ROOT'] . '/p/', '', $destinationPath);
            }
            
            throw new Exception('Failed to move uploaded file');
            
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    /**
     * Upload multiple files
     */
    public function uploadMultiple($files, $subfolder = '') {
        $uploadedFiles = [];
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];
            
            $result = $this->upload($file, $subfolder);
            if (is_array($result) && isset($result['error'])) {
                $uploadedFiles[] = ['error' => $result['error'], 'name' => $file['name']];
            } else {
                $uploadedFiles[] = ['path' => $result, 'name' => $file['name']];
            }
        }
        
        return $uploadedFiles;
    }
    
    /**
     * Validate uploaded file
     */
    private function validateFile($file) {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $this->getUploadErrorMessage($file['error']));
        }
        
        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            $maxSizeMB = $this->maxFileSize / 1048576;
            throw new Exception("File size exceeds maximum allowed size of {$maxSizeMB}MB");
        }
        
        // Check file extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedTypes)) {
            $allowed = implode(', ', $this->allowedTypes);
            throw new Exception("Invalid file type. Allowed types: {$allowed}");
        }
        
        // Check if file is actually an image
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedMimes)) {
            throw new Exception('File must be a valid image');
        }
        
        return true;
    }
    
    /**
     * Get upload error message
     */
    private function getUploadErrorMessage($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        ];
        
        return $errors[$errorCode] ?? 'Unknown upload error';
    }
    
    /**
     * Get proper image path for display
     * Handles both localhost and production URLs
     */
    public static function getImagePath($filePath) {
        if (empty($filePath)) {
            return 'assets/images/placeholder.png';
        }
        
        // Clean up the path first
        $filePath = str_replace('\\', '/', $filePath);
        $filePath = str_replace('//', '/', $filePath);
        
        // Check if we're on localhost
        $isLocalhost = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || 
                       strpos($_SERVER['HTTP_HOST'] ?? '', '127.0.0.1') !== false;
        
        // Remove /p/ prefix if present
        $filePath = str_replace('/p/', '', $filePath);
        $filePath = str_replace('p/', '', $filePath);
        
        // Ensure clean path
        $filePath = str_replace('//', '/', $filePath);
        
        // Ensure it starts with /
        if (strpos($filePath, 'uploads/') === 0 || strpos($filePath, 'assets/') === 0) {
            $filePath = '/' . $filePath;
        }
        
        // Add /p prefix if on localhost
        if ($isLocalhost && strpos($filePath, '/p/') === false) {
            $filePath = '/p' . $filePath;
        }
        
        return $filePath;
    }
    
    /**
     * Delete an uploaded file
     */
    public function delete($filePath) {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/p/' . $filePath;
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
    
    /**
     * Resize image
     */
    public function resizeImage($sourcePath, $maxWidth = 1920, $maxHeight = 1080, $quality = 85) {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/p/' . $sourcePath;
        
        if (!file_exists($fullPath)) {
            return false;
        }
        
        list($width, $height, $type) = getimagesize($fullPath);
        
        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        if ($ratio >= 1) {
            return true; // Image is already smaller
        }
        
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);
        
        // Create new image
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }
        
        // Load source image
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($fullPath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($fullPath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($fullPath);
                break;
            default:
                return false;
        }
        
        // Resize
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save resized image
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $fullPath, $quality);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $fullPath, 9);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($newImage, $fullPath, $quality);
                break;
        }
        
        imagedestroy($source);
        imagedestroy($newImage);
        
        return true;
    }
}
