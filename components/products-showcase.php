<?php
function getProductsShowcase() {
    ob_start();
?>
<!-- Products Showcase Section -->
<section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-12 bg-white">
    <div class="max-w-full mx-auto">
        <!-- Section Header -->
        <div class="mb-8 sm:mb-12 max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 sm:mb-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-yellow-500 mb-2 sm:mb-3 md:mb-4">
                        Our Complete CSSD Product Range
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base lg:text-lg max-w-3xl">
                        Comprehensive portfolio of Central Sterile Supply Department essentials - from sterilization 
                        packaging materials to monitoring products, all meeting international quality standards like ISO, CE, and EN norms.
                    </p>
                </div>
                <a href="our-products" class="flex-shrink-0 inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 sm:px-6 py-2.5 sm:py-3 rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 text-sm sm:text-base">
                    <span>View All Products</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Products Slider Container -->
        <div class="relative max-w-7xl mx-auto">
            <!-- Left Arrow -->
            <button class="flex absolute left-0 top-1/2 transform -translate-y-1/2 sm:-translate-x-6 z-10 bg-yellow-500 hover:bg-yellow-600 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full items-center justify-center shadow-lg transition-all duration-300 hover:scale-110"
                onclick="slideLeft()">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button class="flex absolute right-0 top-1/2 transform -translate-y-1/2 sm:translate-x-6 z-10 bg-yellow-500 hover:bg-yellow-600 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full items-center justify-center shadow-lg transition-all duration-300 hover:scale-110"
                onclick="slideRight()">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Products Slider -->
            <div class="overflow-x-auto sm:overflow-hidden px-0 sm:px-12 lg:px-0 scrollbar-hide">
                <div id="productSlider" class="flex transition-transform duration-300 ease-in-out gap-3 sm:gap-4 md:gap-6 lg:gap-8">
                    <?php
                    // Fetch products from database
                    require_once __DIR__ . '/../config/Database.php';
                    require_once __DIR__ . '/../config/FileUploader.php';
                    
                    $db = Database::getInstance();
                    $products = $db->fetchAll("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT 6");
                    
                    // Check if there are any products
                    if (empty($products)) {
                        echo '<div class="w-full text-center py-12"><p class="text-gray-500 text-lg">No products available at the moment.</p></div>';
                    }

                    foreach ($products as $product):
                        // Get proper image path
                        $mainImage = FileUploader::getImagePath($product['main_image']);
                        $badge = !empty($product['badge']) ? $product['badge'] : 'ISO Certified';
                    ?>
                    <a href="product-details.php?id=<?php echo $product['id']; ?>" class="flex-shrink-0 w-72 sm:w-80 lg:w-96 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group block">
                        <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-4 sm:p-6 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($mainImage); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110"
                                 onerror="this.src='assets/images/placeholder.png'">
                            <div class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-yellow-500 text-white px-2 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs sm:text-sm font-semibold shadow-md">
                                <?php echo htmlspecialchars($badge); ?>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 lg:p-8">
                            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-2 sm:mb-3 group-hover:text-yellow-600 transition-colors duration-300"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <?php if (!empty($product['subtitle'])): ?>
                            <p class="text-gray-600 text-xs sm:text-sm lg:text-base mb-3 sm:mb-4 lg:mb-6 line-clamp-2"><?php echo htmlspecialchars($product['subtitle']); ?></p>
                            <?php endif; ?>
                            
                            <!-- Price Range -->
                            <?php if (!empty($product['price_min']) || !empty($product['price_max'])): ?>
                            <div class="mb-3 sm:mb-4 pb-3 sm:pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Price Range</p>
                                        <p class="text-base sm:text-lg lg:text-xl font-bold text-yellow-600">
                                            <?php if ($product['price_min'] && $product['price_max']): ?>
                                                ₹<?php echo number_format($product['price_min'], 0); ?> - ₹<?php echo number_format($product['price_max'], 0); ?>
                                            <?php elseif ($product['price_min']): ?>
                                                From ₹<?php echo number_format($product['price_min'], 0); ?>
                                            <?php else: ?>
                                                Contact for Price
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php if (!empty($product['price_unit'])): ?>
                                    <span class="text-xs text-gray-500">per <?php echo htmlspecialchars($product['price_unit']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- View Details Button -->
                            <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-2.5 sm:py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md text-sm sm:text-base">
                                View Details
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    // Get proper CSS path
    $isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
    $baseUrl = $isLocalhost ? '/p/' : '/';
?>
<link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/product-showcase.css">
<?php
    return ob_get_clean();
}
?>