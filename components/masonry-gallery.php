<?php
function getMasonryGallery() {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../config/FileUploader.php';
    
    // Fetch active gallery images
    $db = Database::getInstance();
    $galleryImages = $db->fetchAll("SELECT * FROM gallery WHERE status = 'active' ORDER BY created_at DESC");
    
    // If no images, return empty
    if (empty($galleryImages)) {
        return '';
    }
    
    ob_start();
?>
<!-- Masonry Gallery Section - Responsive Auto-Scroll -->
<section class="masonry-gallery-section">
    <div class="gallery-container">
        <div class="masonry-track">
            <?php 
            // Create 5 sets for seamless infinite scroll
            for ($set = 0; $set < 5; $set++): 
                // Pattern: Row 1 (3 images), Row 2 (2 images) - Total 5 images per column set
                $row1Images = array_slice($galleryImages, 0, 3);
                $row2Images = array_slice($galleryImages, 3, 2);
                
                // If not enough images, cycle through
                while (count($row1Images) < 3) {
                    $row1Images[] = $galleryImages[count($row1Images) % count($galleryImages)];
                }
                while (count($row2Images) < 2) {
                    $row2Images[] = $galleryImages[(3 + count($row2Images)) % count($galleryImages)];
                }
            ?>
            <!-- Column Set -->
            <div class="masonry-column">
                <!-- Row 1: 3 images -->
                <div class="masonry-row row-3">
                    <?php foreach ($row1Images as $image): 
                        $imagePath = FileUploader::getImagePath($image['image_path']);
                        $imageType = $image['image_type'] ?? 'portrait';
                    ?>
                    <div class="masonry-card <?php echo htmlspecialchars($imageType); ?>">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             alt="<?php echo htmlspecialchars($image['title'] ?? 'Gallery Image'); ?>" 
                             class="masonry-img"
                             loading="lazy"
                             onerror="this.parentElement.style.display='none'">
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Row 2: 2 images -->
                <div class="masonry-row row-2">
                    <?php foreach ($row2Images as $image): 
                        $imagePath = FileUploader::getImagePath($image['image_path']);
                        $imageType = $image['image_type'] ?? 'landscape';
                    ?>
                    <div class="masonry-card <?php echo htmlspecialchars($imageType); ?>">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             alt="<?php echo htmlspecialchars($image['title'] ?? 'Gallery Image'); ?>" 
                             class="masonry-img"
                             loading="lazy"
                             onerror="this.parentElement.style.display='none'">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php 
            endfor; 
            ?>
        </div>
    </div>
    
    <link rel="stylesheet" href="assets/css/masonry-gallery.css">
</section>
<?php
    return ob_get_clean();
}
?>