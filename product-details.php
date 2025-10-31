<?php
require_once 'config/Database.php';
require_once 'config/settings.php';
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';
require_once 'includes/frontend-helper.php';

// Get product ID or slug from URL
$productIdentifier = $_GET['id'] ?? $_GET['slug'] ?? '';

if (empty($productIdentifier)) {
    header('Location: our-products.php');
    exit;
}

// Fetch product from database (support both ID and slug)
$db = Database::getInstance();

// Try to fetch by ID first (if it's numeric), otherwise by slug (if column exists)
if (is_numeric($productIdentifier)) {
    $product = $db->fetchOne("SELECT * FROM products WHERE id = ? AND status = 'active'", [(int)$productIdentifier]);
} else {
    // Try slug-based search
    try {
        $product = $db->fetchOne("SELECT * FROM products WHERE slug = ? AND status = 'active'", [$productIdentifier]);
    } catch (PDOException $e) {
        // Fall back to name-based matching
        $product = $db->fetchOne("SELECT * FROM products WHERE REPLACE(LOWER(name), ' ', '-') = ? AND status = 'active'", [$productIdentifier]);
    }
}

if (!$product) {
    header('Location: our-products.php');
    exit;
}

$productId = $product['id'];

// Fetch product images from product_images table
$productImages = $db->fetchAll(
    "SELECT image_path, image_type FROM product_images WHERE product_id = ? ORDER BY display_order ASC",
    [$productId]
);

// Separate images by type
$parallaxImages = [];
$galleryImages = [];
foreach ($productImages as $img) {
    $imageUrl = FrontendHelper::getImageUrl($img['image_path']);
    if (!empty($imageUrl)) {
        if ($img['image_type'] === 'parallax') {
            $parallaxImages[] = $imageUrl;
        } else {
            $galleryImages[] = $imageUrl;
        }
    }
}

// If no images in product_images table, use main_image
if (empty($parallaxImages) && !empty($product['main_image'])) {
    $mainImageUrl = FrontendHelper::getImageUrl($product['main_image']);
    if (!empty($mainImageUrl)) {
        $parallaxImages[] = $mainImageUrl;
    }
}

// Decode JSON fields
$product['instructions'] = !empty($product['instructions']) ? json_decode($product['instructions'], true) : [];
$product['features'] = !empty($product['features']) ? json_decode($product['features'], true) : [];
$product['specifications'] = !empty($product['specifications']) ? json_decode($product['specifications'], true) : [];

// Get first image for main display (database already has full path like uploads/products/image.png)
$firstImage = !empty($parallaxImages) ? $parallaxImages[0] : '';

// Fetch active reviews for this product (display_location can be 'product' or 'both')
$reviews = $db->fetchAll("SELECT * FROM reviews WHERE status = 'active' AND (display_location = 'product' OR display_location = 'both') ORDER BY created_at DESC LIMIT 10");

// Split reviews into two rows for carousel effect
$reviewsRow1 = array_slice($reviews, 0, 5);
$reviewsRow2 = array_slice($reviews, 5, 5);

// Output the header and navigation
echo getHeader(htmlspecialchars($product['name']) . ' - Product Details | ZEGNEN');
echo getNavigation();
?>

<link rel="stylesheet" href="assets/css/product-details.css">

<main class="relative z-10" style="font-family: 'Inter', sans-serif;">
    <!-- Breadcrumb Navigation -->
    <section class="bg-white border-b border-gray-200 py-3 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <nav class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="index.php" class="hover:text-yellow-500 transition-colors">Home</a>
                <span>/</span>
                <a href="our-products.php" class="hover:text-yellow-500 transition-colors">Products</a>
                <span>/</span>
                <span class="text-gray-900 font-medium">Product Details</span>
            </nav>
        </div>
    </section>

    <!-- Product Details Section -->
    <section class="bg-white py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Left: Product Image -->
                <div class="relative">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                        <img id="mainProductImage" 
                             src="<?php echo $firstImage; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <?php if (count($galleryImages) > 1): ?>
                    <div class="grid grid-cols-4 gap-2">
                        <?php foreach (array_slice($galleryImages, 0, 4) as $index => $image): ?>
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity border-2 border-transparent hover:border-yellow-500"
                             onclick="changeMainImage('<?php echo htmlspecialchars($image); ?>')">
                            <img src="<?php echo htmlspecialchars($image); ?>" 
                                 alt="Product view <?php echo $index + 1; ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- ISO Badge -->
                    <?php if (!empty($product['badge'])): ?>
                    <div class="absolute top-4 right-4 float-animation">
                        <span class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <?php echo htmlspecialchars($product['badge']); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Product Info & Overview -->
                <div class="space-y-6">
                    <!-- Category & Title -->
                    <div>
                        <span class="inline-block bg-gray-100 text-gray-700 px-4 py-1.5 rounded-full text-sm font-medium mb-3">
                            CSSD Products
                        </span>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h1>
                        <?php if (!empty($product['subtitle'])): ?>
                        <p class="text-xl text-gray-600 mb-4"><?php echo htmlspecialchars($product['subtitle']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Price Display (if available) -->
                    <?php if (!empty($product['price_min']) || !empty($product['price_max'])): ?>
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Price Range</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    <?php if ($product['price_min'] && $product['price_max']): ?>
                                        ₹<?php echo number_format($product['price_min'], 2); ?> - ₹<?php echo number_format($product['price_max'], 2); ?>
                                    <?php elseif ($product['price_min']): ?>
                                        Starting from ₹<?php echo number_format($product['price_min'], 2); ?>
                                    <?php elseif ($product['price_max']): ?>
                                        Up to ₹<?php echo number_format($product['price_max'], 2); ?>
                                    <?php endif; ?>
                                    <?php if (!empty($product['price_unit'])): ?>
                                    <span class="text-base font-normal text-gray-600">/ <?php echo htmlspecialchars($product['price_unit']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">* Prices may vary based on quantity and customization</p>
                    </div>
                    <?php endif; ?>

                    <!-- Product Overview -->
                    <div class="border-l-4 border-yellow-500 pl-4 py-2">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Product Overview</h2>
                        <p class="text-gray-700 leading-relaxed">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap gap-2 py-4">
                        <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                            ✓ Quality Assured
                        </span>
                        <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-200">
                            ✓ Fast Delivery
                        </span>
                        <span class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium border border-purple-200">
                            ✓ Expert Support
                        </span>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button onclick="scrollToInquiry()" 
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-6 py-3.5 rounded-lg transition-all duration-300 flex items-center justify-center shadow-md hover:shadow-lg transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Request Quote
                        </button>
                        <a href="<?php echo getPhoneUrl(); ?>" 
                           class="flex-1 bg-gray-900 hover:bg-black text-white font-semibold px-6 py-3.5 rounded-lg transition-all duration-300 flex items-center justify-center shadow-md hover:shadow-lg transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parallax Section with Fixed Image -->
    <?php if (!empty($parallaxImages)): ?>
    <section class="relative overflow-hidden parallax-section-mobile" style="height: 600px;">
        <!-- Full-width background image -->
        <div class="parallax-bg absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('<?php echo htmlspecialchars($parallaxImages[0]); ?>'); background-attachment: fixed;">
        </div>
    </section>
    <?php endif; ?>

    <!-- Tabbed Product Information Section -->
    <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 mb-8 desktop-tab-container">
                <nav class="flex gap-2 md:gap-4 -mb-px tab-navigation-mobile" aria-label="Tabs">
                    <button onclick="switchTab('details')" 
                            id="tab-details"
                            class="tab-button border-b-2 border-yellow-500 text-yellow-600 px-4 md:px-6 py-3 font-semibold text-sm md:text-base transition-all duration-300">
                        Product Details
                    </button>
                    <button onclick="switchTab('instructions')" 
                            id="tab-instructions"
                            class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 md:px-6 py-3 font-semibold text-sm md:text-base transition-all duration-300">
                        Instructions
                    </button>
                    <button onclick="switchTab('features')" 
                            id="tab-features"
                            class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 md:px-6 py-3 font-semibold text-sm md:text-base transition-all duration-300">
                        Features
                    </button>
                    <button onclick="switchTab('specifications')" 
                            id="tab-specifications"
                            class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 md:px-6 py-3 font-semibold text-sm md:text-base transition-all duration-300">
                        Specifications
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="tab-content-wrapper">
                <!-- Product Details Tab -->
                <div id="content-details" class="tab-content">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-7 h-7 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Detailed Product Information
                        </h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            <div class="text-base md:text-lg rich-text-content"><?php echo $product['details']; ?></div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
                                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Quality Assurance
                                    </h4>
                                    <p class="text-sm text-gray-700">Each batch is tested and certified to meet international standards for sterilization monitoring.</p>
                                </div>
                                
                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                        </svg>
                                        Environmental Care
                                    </h4>
                                    <p class="text-sm text-gray-700">Made with eco-friendly materials that can be safely recycled after use.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions Tab -->
                <div id="content-instructions" class="tab-content" style="display: none;">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Instructions for Use</h2>
                        </div>
                        
                        <!-- Side by side layout: Content 60% + Video 40% -->
                        <div class="instructions-video-layout">
                            <!-- Left: Instructions Content (60%) -->
                            <div>
                                <?php if (!empty($product['instructions'])): ?>
                                <ul class="space-y-4">
                                    <?php foreach ($product['instructions'] as $index => $instruction): 
                                        // Handle both old format (string) and new format (array with text/video_url)
                                        $text = is_array($instruction) ? ($instruction['text'] ?? '') : $instruction;
                                    ?>
                                    <li class="flex items-start text-gray-700 leading-relaxed p-4 bg-gray-50 rounded-lg hover:bg-yellow-50 transition-all duration-300" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-500 text-gray-900 rounded-full flex items-center justify-center font-bold mr-4 text-sm">
                                            <?php echo $index + 1; ?>
                                        </span>
                                        <span class="pt-1 flex-grow"><?php echo htmlspecialchars($text); ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <p class="text-gray-600">No instructions available for this product.</p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Right: Video (40%) -->
                            <?php if (!empty($product['instructions_video'])): ?>
                            <div class="sticky top-24">
                                <div class="bg-gradient-to-br from-red-50 to-yellow-50 rounded-xl border-2 border-red-100 overflow-hidden">
                                    <div class="p-4 bg-gradient-to-r from-red-500 to-yellow-500">
                                        <div class="flex items-center text-white">
                                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm3.5 10.5l-5 3A.5.5 0 018 13V7a.5.5 0 01.5-.5c.123 0 .247.046.342.134l5 3a.5.5 0 010 .732z"/>
                                            </svg>
                                            <span class="font-semibold">Video Tutorial</span>
                                        </div>
                                    </div>
                                    <div class="aspect-video bg-black">
                                        <?php
                                        // Extract YouTube video ID from URL
                                        $videoUrl = $product['instructions_video'];
                                        $videoId = '';
                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $videoUrl, $match)) {
                                            $videoId = $match[1];
                                        }
                                        ?>
                                        <?php if ($videoId): ?>
                                        <iframe 
                                            class="w-full h-full"
                                            src="https://www.youtube.com/embed/<?php echo $videoId; ?>?rel=0&modestbranding=1"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                        <?php else: ?>
                                        <iframe 
                                            class="w-full h-full"
                                            src="<?php echo htmlspecialchars($videoUrl); ?>"
                                            frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-3 bg-white">
                                        <a href="<?php echo htmlspecialchars($product['instructions_video']); ?>" 
                                           target="_blank" 
                                           class="text-sm text-red-600 hover:text-red-700 font-medium flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                            Watch in Full Screen
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Features Tab -->
                <div id="content-features" class="tab-content" style="display: none;">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Key Features</h2>
                        </div>
                        <?php if (!empty($product['features'])): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($product['features'] as $index => $feature): ?>
                            <div class="flex items-start text-gray-700 leading-relaxed p-5 bg-gradient-to-r from-green-50 to-transparent rounded-lg border border-green-100 hover:border-green-300 transition-all duration-300 transform hover:scale-105" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium"><?php echo htmlspecialchars($feature); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-600">No features listed for this product.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="content-specifications" class="tab-content" style="display: none;">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
                        <div class="p-6 md:p-8 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                <svg class="w-7 h-7 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Technical Specifications
                            </h2>
                        </div>
                        <?php if (!empty($product['specifications'])): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <?php 
                                    $index = 0;
                                    foreach ($product['specifications'] as $label => $value): 
                                    ?>
                                    <tr class="hover:bg-yellow-50 transition-colors duration-200" style="animation: fadeInUp 0.5s ease-out <?php echo $index * 0.05; ?>s both;">
                                        <td class="py-5 px-6 font-semibold text-gray-900 w-1/3 bg-gray-50">
                                            <?php echo htmlspecialchars($label); ?>
                                        </td>
                                        <td class="py-5 px-6 text-gray-700"><?php echo htmlspecialchars($value); ?></td>
                                    </tr>
                                    <?php 
                                    $index++;
                                    endforeach; 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="p-6">
                            <p class="text-gray-600">No specifications available for this product.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Player Section -->
    <?php if (!empty($product['video_url'])): ?>
    <section class="relative overflow-hidden video-section-mobile parallax-section-mobile" style="height: 600px; margin: 40px 0; padding: 20px 0;">
        <!-- Full-width background video with fixed attachment -->
        <div class="absolute inset-0" style="clip-path: inset(0);">
            <div style="position: fixed; width: 100%; height: 100vh; top: 0; left: 0;">
                <?php
                // Extract YouTube video ID from URL
                $videoUrl = $product['video_url'];
                $videoId = '';
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $videoUrl, $match)) {
                    $videoId = $match[1];
                }
                ?>
                <?php if ($videoId): ?>
                <iframe 
                    id="productVideo"
                    style="width: 100%; height: 100%; border: none; object-fit: cover;"
                    src="https://www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playlist=<?php echo $videoId; ?>"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
                <?php else: ?>
                <iframe 
                    id="productVideo"
                    style="width: 100%; height: 100%; border: none; object-fit: cover;"
                    src="<?php echo htmlspecialchars($videoUrl); ?>"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Reviews and Inquiry Section -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Reviews Slider (2/3 width) -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Customer Reviews</h2>
                            <p class="text-gray-600">What our clients say about this product</p>
                        </div>
                    </div>
                    
                    <?php if (!empty($reviews)): ?>
                    <!-- First Row - Scrolls Left to Right -->
                    <div id="reviewsSlider1" class="reviews-slider pb-4 mb-6">
                        <?php foreach ($reviewsRow1 as $review): ?>
                        <div class="review-card flex-shrink-0 w-80 md:w-96 bg-gradient-to-br from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    <?php echo strtoupper(substr($review['customer_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($review['customer_name']); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($review['customer_role']); ?></p>
                                </div>
                            </div>
                            <div class="star-rating mb-3">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <span class="star">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 leading-relaxed italic">"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Second Row - Scrolls Right to Left -->
                    <?php if (!empty($reviewsRow2)): ?>
                    <div id="reviewsSlider2" class="reviews-slider-reverse pb-4">
                        <?php foreach ($reviewsRow2 as $review): ?>
                        <div class="review-card flex-shrink-0 w-80 md:w-96 bg-gradient-to-br from-yellow-50 to-white p-6 rounded-2xl border border-yellow-200 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    <?php echo strtoupper(substr($review['customer_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($review['customer_name']); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($review['customer_role']); ?></p>
                                </div>
                            </div>
                            <div class="star-rating mb-3">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <span class="star">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 leading-relaxed italic">"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php else: ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <p class="text-gray-600">No reviews available yet. Be the first to share your experience!</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Quick Inquiry Form (1/3 width) -->
                <div class="lg:col-span-1" id="inquiryForm">
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 shadow-lg border-2 inquiry-form-highlight sticky top-24">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3 float-animation">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Quick Inquiry</h3>
                            <p class="text-sm text-gray-700">Get a response within 24 hours</p>
                        </div>

                        <form id="quickInquiryForm" class="space-y-4">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            
                            <div>
                                <input type="text" 
                                       name="name" 
                                       required
                                       placeholder="Your Name *"
                                       class="w-full px-4 py-3 bg-white border-2 border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                            </div>

                            <div>
                                <input type="email" 
                                       name="email" 
                                       required
                                       placeholder="Email Address *"
                                       class="w-full px-4 py-3 bg-white border-2 border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                            </div>

                            <div>
                                <input type="tel" 
                                       name="phone" 
                                       required
                                       placeholder="Phone Number *"
                                       class="w-full px-4 py-3 bg-white border-2 border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                            </div>

                            <div>
                                <textarea name="message" 
                                          required
                                          rows="3"
                                          placeholder="Your Message *"
                                          class="w-full px-4 py-3 bg-white border-2 border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all resize-none"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded-lg px-6 py-3 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Send Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="assets/js/product-details.js"></script>

<script>
// Change main product image when clicking thumbnails
function changeMainImage(imageSrc) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = imageSrc;
            mainImage.style.opacity = '1';
        }, 150);
    }
}

// Smooth scroll to inquiry form
function scrollToInquiry() {
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        inquiryForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Add pulse highlight effect
        inquiryForm.querySelector('.bg-gradient-to-br').classList.add('pulse-highlight');
        setTimeout(() => {
            inquiryForm.querySelector('.bg-gradient-to-br').classList.remove('pulse-highlight');
        }, 2000);
    }
}

// Handle inquiry form submission
document.getElementById('quickInquiryForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Sending...';
    
    try {
        const formData = new FormData(this);
        
        // Add source tracking
        formData.append('source_page', 'product-details');
        formData.append('source_url', window.location.href);
        formData.append('subject', 'Product Inquiry - ' + formData.get('product_name'));
        
        const response = await fetch('api/submit-inquiry.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Redirect to thank you page
            window.location.href = 'thank-you.php?type=inquiry';
        } else {
            alert(result.message || 'Failed to submit inquiry. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    } catch (error) {
        console.error('Error submitting inquiry:', error);
        alert('An error occurred. Please try again later.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
});
</script>

<?php
// Output the footer
echo getFooter();
?>
