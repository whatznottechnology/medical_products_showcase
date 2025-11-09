<?php
function getHeader($title = "ZEGNEN.COM - Healthcare Excellence, Hello ZEGNEN", $description = "ZEGNEN - Leading manufacturer of CSSD products for sterilization & infection control in healthcare institutions worldwide", $keywords = "CSSD products, sterilization, infection control, healthcare, medical devices, autoclave tape, bowie dick test, sterilization indicators", $page = "home") {
    // Fetch banner from banners table based on page
    $banner = null;
    $heroBackground = 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80';
    
    try {
        require_once __DIR__ . '/../config/Database.php';
        $db = Database::getInstance();
        $banner = $db->fetchOne("SELECT image_path FROM banners WHERE page = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1", [$page]);
        
        // Use relative path (no leading slash) since site is in subdirectory
        if (!empty($banner['image_path'])) {
            $heroBackground = $banner['image_path'];
        }
    } catch (Exception $e) {
        // Fallback to default background if database error
        error_log("Header banner fetch error: " . $e->getMessage());
    }
    
    ob_start();
    
    // Detect environment for proper paths
    $isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
    $baseUrl = $isLocalhost ? '/p/' : '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
    <meta name="author" content="ZEGNEN International Company">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#ffcc09">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:image" content="<?php echo $baseUrl; ?>assets/images/zic_logo.png">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/'); ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="twitter:image" content="<?php echo $baseUrl; ?>assets/images/zic_logo.png">
    
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png?v=1.0">
    <link rel="shortcut icon" type="image/png" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png?v=1.0">
    <link rel="apple-touch-icon" href="<?php echo $baseUrl; ?>assets/images/zic_fav.png?v=1.0">
    <link rel="canonical" href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/'); ?>">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/tailwind-config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/mobile-optimizations.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/popup.css">
</head>
<body class="overflow-x-hidden">
<?php
    return ob_get_clean();
}
?>