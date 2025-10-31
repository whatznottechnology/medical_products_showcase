<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Get search query
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

// Define all products with categories and keywords
$allProducts = [
    [
        'name' => 'Bowie-Dick Test',
        'description' => 'Premium quality air removal test for steam sterilization validation and performance monitoring.',
        'price_min' => '2,450',
        'price_max' => '3,500',
        'unit' => 'pack',
        'image' => 'assets/images/Bowie-Dick test.png',
        'badge' => 'ISO Certified',
        'category' => 'monitoring',
        'keywords' => ['bowie', 'dick', 'test', 'air', 'removal', 'steam', 'sterilization', 'validation', 'monitoring', 'cssd', 'equipment', 'medical', 'devices']
    ],
    [
        'name' => 'ZIC Autoclave Tape',
        'description' => 'High-quality steam sterilization indicator tape for medical instruments and packaging.',
        'price_min' => '1,200',
        'price_max' => '1,800',
        'unit' => 'roll',
        'image' => 'assets/images/ZIC_Autoclave_Tape.png',
        'badge' => 'FDA Approved',
        'category' => 'sterilization',
        'keywords' => ['autoclave', 'tape', 'indicator', 'steam', 'sterilization', 'medical', 'instruments', 'packaging', 'cssd', 'equipment', 'devices', 'infection', 'control']
    ],
    [
        'name' => 'Type 6 Emulating Indicator',
        'description' => 'Advanced chemical indicator for sterilization process monitoring and validation.',
        'price_min' => '3,200',
        'price_max' => '4,500',
        'unit' => 'box',
        'image' => 'assets/images/ZIC Type_6 –Emulating_Indicator.png',
        'badge' => 'CE Marked',
        'category' => 'monitoring',
        'keywords' => ['type', '6', 'emulating', 'indicator', 'chemical', 'sterilization', 'monitoring', 'validation', 'cssd', 'equipment', 'medical', 'devices']
    ],
];

// Filter products based on search query
$filteredProducts = [];
if (!empty($searchQuery)) {
    $searchLower = strtolower($searchQuery);
    
    foreach ($allProducts as $product) {
        // Check if search query matches name, description, category, or keywords
        $nameMatch = stripos($product['name'], $searchQuery) !== false;
        $descriptionMatch = stripos($product['description'], $searchQuery) !== false;
        $categoryMatch = stripos($product['category'], $searchQuery) !== false;
        
        // Check keywords
        $keywordMatch = false;
        foreach ($product['keywords'] as $keyword) {
            if (stripos($keyword, $searchQuery) !== false || stripos($searchQuery, $keyword) !== false) {
                $keywordMatch = true;
                break;
            }
        }
        
        if ($nameMatch || $descriptionMatch || $categoryMatch || $keywordMatch) {
            $filteredProducts[] = $product;
        }
    }
}

// Output the header and navigation
echo getHeader('Search Results - ZEGNEN CSSD Solutions');
echo getNavigation();
?>

<main class="relative min-h-screen mt-20">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-yellow-500 to-yellow-600">
        <div class="container mx-auto px-6 lg:px-12 py-12 sm:py-16">
            <div class="max-w-4xl">
                <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">Search Results</h1>
                <?php if (!empty($searchQuery)): ?>
                    <p class="text-lg text-white/90">
                        Showing results for: <span class="font-semibold">"<?php echo htmlspecialchars($searchQuery); ?>"</span>
                    </p>
                    <p class="text-base text-white/80 mt-2">
                        Found <?php echo count($filteredProducts); ?> product<?php echo count($filteredProducts) !== 1 ? 's' : ''; ?>
                    </p>
                <?php else: ?>
                    <p class="text-lg text-white/90">
                        Please enter a search term to find products.
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Search Bar -->
            <div class="mt-6 sm:mt-8 max-w-2xl">
                <form action="search-results" method="GET" class="bg-white/95 backdrop-blur-sm rounded-full shadow-lg overflow-hidden">
                    <div class="flex items-center px-4 sm:px-6 py-3 sm:py-4">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="<?php echo htmlspecialchars($searchQuery); ?>"
                            class="w-full text-sm sm:text-base lg:text-lg text-gray-800 outline-none font-medium bg-transparent placeholder-gray-400"
                            placeholder="Search for products, categories, or keywords..."
                            autocomplete="off">
                        <button type="submit" class="ml-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 sm:px-6 py-2 rounded-full transition-all duration-300 text-sm sm:text-base flex-shrink-0">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <?php if (empty($searchQuery)): ?>
                <!-- Empty Search State -->
                <div class="text-center py-12 sm:py-16">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">Start Your Search</h2>
                    <p class="text-gray-600 text-base sm:text-lg mb-6 max-w-md mx-auto">
                        Enter keywords like "sterilization", "autoclave", or "indicator" to find products.
                    </p>
                    <a href="our-products" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                        <span>Browse All Products</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php elseif (empty($filteredProducts)): ?>
                <!-- No Results State -->
                <div class="text-center py-12 sm:py-16">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">No Products Found</h2>
                    <p class="text-gray-600 text-base sm:text-lg mb-6 max-w-md mx-auto">
                        We couldn't find any products matching "<span class="font-semibold"><?php echo htmlspecialchars($searchQuery); ?></span>".
                        Try different keywords or browse all products.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                        <a href="our-products" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            <span>Browse All Products</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="contact-us" class="inline-flex items-center gap-2 border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-50 font-semibold px-6 py-3 rounded-full transition-all duration-300">
                            <span>Contact Support</span>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <?php foreach ($filteredProducts as $product): ?>
                        <div class="product-card">
                            <a href="product-details" class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group h-full flex flex-col block">
                                <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-6 overflow-hidden">
                                    <img src="<?php echo $product['image']; ?>" 
                                         alt="<?php echo $product['name']; ?>" 
                                         class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                                    <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-md">
                                        <?php echo $product['badge']; ?>
                                    </div>
                                </div>
                                <div class="p-6 sm:p-8 flex-grow flex flex-col">
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600 transition-colors duration-300">
                                        <?php echo $product['name']; ?>
                                    </h3>
                                    <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 line-clamp-2 flex-grow">
                                        <?php echo $product['description']; ?>
                                    </p>
                                    
                                    <!-- Category Badge -->
                                    <div class="mb-4">
                                        <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                            <?php echo ucfirst($product['category']); ?>
                                        </span>
                                    </div>
                                    
                                    <!-- Price Range -->
                                    <div class="mb-4 pb-4 border-b border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Price Range</p>
                                                <p class="text-lg sm:text-xl font-bold text-yellow-600">
                                                    ₹<?php echo $product['price_min']; ?> - ₹<?php echo $product['price_max']; ?>
                                                </p>
                                            </div>
                                            <span class="text-xs text-gray-500">per <?php echo $product['unit']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <!-- View Details Button -->
                                    <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md">
                                        View Details
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php echo getFooter(); ?>
