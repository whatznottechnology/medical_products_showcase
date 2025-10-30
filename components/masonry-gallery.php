<?php
function getMasonryGallery() {
    // Gallery images with their aspect ratios
    $galleryImages = [
        // Row 1 - Mixed aspect ratios
        ['url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=600&fit=crop', 'type' => 'portrait'], // 2:3
        ['url' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        ['url' => 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=400&h=400&fit=crop', 'type' => 'square'], // 1:1
        ['url' => 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=400&h=550&fit=crop', 'type' => 'portrait'], // 2:3
        ['url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        
        // Row 2 - Mixed aspect ratios
        ['url' => 'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=400&h=400&fit=crop', 'type' => 'square'], // 1:1
        ['url' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&h=600&fit=crop', 'type' => 'portrait'], // 2:3
        ['url' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        ['url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=400&h=550&fit=crop', 'type' => 'portrait'], // 2:3
        ['url' => 'https://images.unsplash.com/photo-1581595220975-119360b2a0de?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        
        // Row 3 - Mixed aspect ratios
        ['url' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        ['url' => 'https://images.unsplash.com/photo-1504813184591-01572f98c85f?w=400&h=400&fit=crop', 'type' => 'square'], // 1:1
        ['url' => 'https://images.unsplash.com/photo-1581594549595-35f6edc7b762?w=400&h=600&fit=crop', 'type' => 'portrait'], // 2:3
        ['url' => 'https://images.unsplash.com/photo-1603398938378-e54eab446dde?w=500&h=300&fit=crop', 'type' => 'landscape'], // 5:3
        ['url' => 'https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?w=400&h=600&fit=crop', 'type' => 'portrait'], // 2:3
    ];
    
    ob_start();
?>
<!-- Masonry Gallery Section - Smart Auto-Adjusting Layout -->
<section class="masonry-gallery-section">
    <div class="gallery-container">
        <div class="masonry-track">
            <?php 
            // Create 3 sets for seamless infinite scroll
            for ($set = 0; $set < 3; $set++): 
                foreach ($galleryImages as $index => $image): 
            ?>
            <div class="masonry-card <?php echo $image['type']; ?>">
                <img src="<?php echo $image['url']; ?>" alt="Gallery Image" class="masonry-img">
            </div>
            <?php 
                endforeach;
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