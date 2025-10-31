<?php
require_once 'config/Database.php';
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';
require_once 'includes/frontend-helper.php';

// Fetch products from database
$db = Database::getInstance();
$products = $db->fetchAll("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC");

// Fetch banner from banners table
$banner = $db->fetchOne("SELECT * FROM banners WHERE page = 'our-products' AND status = 'active' LIMIT 1");
$bannerImage = !empty($banner['image_path']) ? FrontendHelper::getImageUrl($banner['image_path']) : '';
$bannerTitle = !empty($banner['title']) ? $banner['title'] : 'CSSD Product Solutions';

// Output the header and navigation
echo getHeader(
    'CSSD Products - Sterilization & Infection Control Solutions | ZEGNEN',
    'Explore ZEGNEN\'s comprehensive range of CSSD products: Sterilization packaging, autoclave tape, Bowie-Dick test, Type 6 indicators, chemical & biological indicators, enzymatic detergents, and sterilization containers. ISO certified, FDA approved, CE marked products.',
    'CSSD products, sterilization products, autoclave tape, bowie dick test, chemical indicators, biological indicators, type 6 indicators, sterilization pouches, sterilization packaging, enzymatic detergent, sterilization containers, medical device sterilization, infection control products',
    'our-products'
);
echo getNavigation();
?>

<main class="relative min-h-screen mt-20">
    <!-- Hero Section -->
    <?php if (!empty($bannerImage)): ?>
    <section class="relative bg-[url('<?php echo htmlspecialchars($bannerImage); ?>')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative container mx-auto px-6 lg:px-12 py-24">
            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4"><?php echo htmlspecialchars($bannerTitle); ?></h1>
            <p class="text-lg text-white/90 max-w-2xl">
                Comprehensive range of high-quality sterilization and infection control products designed for modern healthcare facilities.
            </p>
        </div>
    </section>
    <?php else: ?>
    <section class="bg-gradient-to-r from-yellow-500 to-yellow-600">
        <div class="container mx-auto px-6 lg:px-12 py-24">
            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4"><?php echo htmlspecialchars($bannerTitle); ?></h1>
            <p class="text-lg text-white/90 max-w-2xl">
                Comprehensive range of high-quality sterilization and infection control products designed for modern healthcare facilities.
            </p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Product Categories Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
                <?php foreach ($products as $product): 
                    // Use main_image (featured 1:1 image) for product cards
                    $mainImage = !empty($product['main_image']) 
                        ? FrontendHelper::getImageUrl(str_replace('//', '/', $product['main_image']))
                        : '';
                    
                    if (empty($mainImage)) continue; // Skip if no valid image
                    
                    // Get badge/certification
                    $badge = !empty($product['badge']) ? $product['badge'] : 'ISO Certified';
                    
                    // Create slug from product name or use existing slug
                    $slug = !empty($product['slug']) ? $product['slug'] : strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $product['name'])));
                ?>
                <div class="product-card">
                    <a href="product-details.php?slug=<?php echo urlencode($slug); ?>" class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group h-full flex flex-col block">
                        <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-6 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($mainImage); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                            <?php if (!empty($badge)): ?>
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-md">
                                <?php echo htmlspecialchars($badge); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6 sm:p-8 flex-grow flex flex-col">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600 transition-colors duration-300"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <?php if (!empty($product['subtitle'])): ?>
                            <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 line-clamp-2 flex-grow"><?php echo htmlspecialchars($product['subtitle']); ?></p>
                            <?php endif; ?>
                            
                            <!-- View Details Button -->
                            <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md">
                                View Details
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Product Request Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-2xl lg:text-3xl font-bold mb-4">Need a Custom Solution?</h2>
                    <p class="text-gray-600 mb-8">Contact our experts to discuss your specific CSSD requirements and get personalized product recommendations.</p>
                    <a href="contact-us" class="inline-flex items-center bg-yellow-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-yellow-600 transition-colors">
                        Request Consultation
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Output the footer
echo getFooter();
?>