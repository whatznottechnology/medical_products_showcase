<?php
function getMasonryGallery() {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../config/FileUploader.php';
    
    // Fetch active gallery images
    try {
        $db = Database::getInstance();
        $galleryImages = $db->fetchAll("SELECT * FROM gallery WHERE status = 'active' ORDER BY display_order ASC, created_at DESC");
    } catch (Exception $e) {
        error_log("Gallery fetch error: " . $e->getMessage());
        return '<div class="text-center py-12"><p class="text-gray-500">Unable to load gallery at this time.</p></div>';
    }
    
    // If no images, return empty
    if (empty($galleryImages)) {
        return '<div class="text-center py-12"><p class="text-gray-500">No gallery images available yet. Check back soon!</p></div>';
    }
    
    // Distribute images into 3 columns for variety
    $columns = [[], [], []];
    foreach ($galleryImages as $index => $image) {
        $columns[$index % 3][] = $image;
    }
    
    // Limit each column to maximum 3 images and shuffle for random order
    foreach ($columns as &$column) {
        $column = array_slice($column, 0, 3);
        shuffle($column); // Randomize image order in each column
    }
    unset($column);
    
    ob_start();
    
    // Get proper CSS path
    $isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
    $baseUrl = $isLocalhost ? '/p/' : '/';
?>
<!-- Masonry Gallery Section - Responsive Auto-Scroll -->
<section class="masonry-gallery-section">
    <div class="gallery-container">
        <div class="masonry-track">
            <?php 
            // Create multiple sets for seamless infinite scroll (6 sets for smoother loop)
            for ($set = 0; $set < 6; $set++): 
                foreach ($columns as $columnIndex => $columnImages):
                    if (empty($columnImages)) continue;
            ?>
            <!-- Column <?php echo $columnIndex + 1; ?> -->
            <div class="masonry-column">
                <?php foreach ($columnImages as $image): 
                    $imagePath = FileUploader::getImagePath($image['image_path']);
                    $imageType = !empty($image['image_type']) ? $image['image_type'] : 'portrait';
                    $altText = !empty($image['alt_text']) ? $image['alt_text'] : (!empty($image['title']) ? $image['title'] : 'Gallery Image');
                ?>
                <div class="masonry-card <?php echo htmlspecialchars($imageType); ?>">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                         alt="<?php echo htmlspecialchars($altText); ?>" 
                         class="masonry-img"
                         loading="lazy"
                         onerror="this.parentElement.style.display='none'">
                </div>
                <?php endforeach; ?>
            </div>
            <?php 
                endforeach;
            endfor; 
            ?>
        </div>
    </div>
    
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/masonry-gallery.css">
</section>
<?php
    return ob_get_clean();
}
?>