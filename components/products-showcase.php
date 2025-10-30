<?php
function getProductsShowcase() {
    ob_start();
?>
<!-- Products Showcase Section -->
<section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-12 bg-white">
    <div class="max-w-6xl mx-auto">
        <!-- Section Header -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-yellow-500 mb-3 sm:mb-4">
                Our Complete CSSD Product Range
            </h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-3xl">
                Comprehensive portfolio of Central Sterile Supply Department essentials - from sterilization 
                packaging materials to monitoring products, all meeting international quality standards like ISO, CE, and EN norms.
            </p>
        </div>

        <!-- Products Slider Container -->
        <div class="relative">
            <!-- Left Arrow - Hidden on mobile -->
            <button class="hidden sm:flex absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 hover:bg-yellow-600 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full items-center justify-center shadow-lg transition-colors duration-300"
                onclick="slideLeft()">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow - Hidden on mobile -->
            <button class="hidden sm:flex absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 hover:bg-yellow-600 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full items-center justify-center shadow-lg transition-colors duration-300"
                onclick="slideRight()">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Products Slider -->
            <div class="overflow-x-auto sm:overflow-hidden sm:mx-12 -mx-4 px-4 sm:px-0 scrollbar-hide">
                <div id="productSlider" class="flex transition-transform duration-300 ease-in-out gap-4 sm:gap-6">
                    <?php
                    $products = [
                        [
                            'name' => 'Sterilization Packaging',
                            'description' => 'Premium quality pouches, reels, wraps and indicator tapes for medical instruments',
                            'price' => '2,450',
                            'unit' => 'pack',
                            'emoji' => '📦',
                            'gradient' => 'from-blue-100 to-blue-200',
                            'badge' => 'ISO Certified'
                        ],
                        [
                            'name' => 'Sterilization Monitoring',
                            'description' => 'Biological and chemical indicators, integrators and test packs for validation',
                            'price' => '3,200',
                            'unit' => 'box',
                            'emoji' => '🧪',
                            'gradient' => 'from-green-100 to-green-200',
                            'badge' => 'FDA Approved'
                        ],
                        // Add more products here...
                    ];

                    foreach ($products as $product):
                    ?>
                    <div class="flex-shrink-0 w-72 sm:w-80 bg-white rounded-2xl shadow-lg overflow-hidden border hover:shadow-xl transition-shadow duration-300">
                        <div class="h-40 sm:h-48 bg-gradient-to-br <?php echo $product['gradient']; ?> flex items-center justify-center relative">
                            <div class="text-5xl sm:text-6xl"><?php echo $product['emoji']; ?></div>
                            <div class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-yellow-500 text-white px-2 py-1 sm:px-3 rounded-full text-xs sm:text-sm font-semibold">
                                <?php echo $product['badge']; ?>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2"><?php echo $product['name']; ?></h3>
                            <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4"><?php echo $product['description']; ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-green-600 font-bold text-base sm:text-lg">From ₹<?php echo $product['price']; ?></span>
                                <span class="text-gray-500 text-xs sm:text-sm">per <?php echo $product['unit']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/css/product-showcase.css">
<?php
    return ob_get_clean();
}
?>