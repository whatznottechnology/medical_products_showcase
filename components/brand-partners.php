<?php
function getBrandPartnersSection() {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../includes/frontend-helper.php';
    
    // Fetch active brands
    $db = Database::getInstance();
    $brands = $db->fetchAll("SELECT * FROM brands WHERE status = 'active' ORDER BY created_at DESC");
    
    // If no brands, return empty
    if (empty($brands)) {
        return '';
    }
    
    ob_start();
?>
<!-- Brand Partners Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                Trusted by Leading Healthcare Institutions
            </h2>
            <p class="text-gray-600 text-lg">
                Our products are used in top hospitals and healthcare facilities across India
            </p>
        </div>
        
        <!-- Brand Logos Slider -->
        <div class="brand-slider-container">
            <div class="brand-slider">
                <?php
                // Output brands twice for infinite scroll effect
                for ($i = 0; $i < 2; $i++) {
                    foreach ($brands as $brand) {
                        $logoPath = FrontendHelper::getImageUrl(str_replace('//', '/', $brand['logo_path']));
                        if (empty($logoPath)) continue;
                        echo '<div class="brand-item">
                                <div class="brand-logo">
                                    <img src="' . htmlspecialchars($logoPath) . '" 
                                         alt="' . htmlspecialchars($brand['name']) . '" 
                                         class="brand-image">
                                </div>
                                <div class="brand-name">
                                    ' . htmlspecialchars($brand['name']) . '
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/css/brand-partners.css">
<?php
    return ob_get_clean();
}
?>