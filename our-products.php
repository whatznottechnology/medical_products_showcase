<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Output the header and navigation
echo getHeader(
    'CSSD Products - Sterilization & Infection Control Solutions | ZEGNEN',
    'Explore ZEGNEN\'s comprehensive range of CSSD products: Sterilization packaging, autoclave tape, Bowie-Dick test, Type 6 indicators, chemical & biological indicators, enzymatic detergents, and sterilization containers. ISO certified, FDA approved, CE marked products.',
    'CSSD products, sterilization products, autoclave tape, bowie dick test, chemical indicators, biological indicators, type 6 indicators, sterilization pouches, sterilization packaging, enzymatic detergent, sterilization containers, medical device sterilization, infection control products'
);
echo getNavigation();
?>

<main class="relative min-h-screen mt-20">
    <!-- Hero Section -->
    <section class="relative bg-[url('https://images.unsplash.com/photo-1581093458791-8a1462c5af0c?auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative container mx-auto px-6 lg:px-12 py-24">
            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">CSSD Product Solutions</h1>
            <p class="text-lg text-white/90 max-w-2xl">
                Comprehensive range of high-quality sterilization and infection control products designed for modern healthcare facilities.
            </p>
        </div>
    </section>

    <!-- Product Categories Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Category Filters - Scrollable on Mobile -->
            <div class="mb-8 relative">
                <!-- Scroll Indicator (Mobile Only) -->
                <div class="md:hidden absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent pointer-events-none z-10 flex items-center justify-end pr-2">
                    <svg class="w-5 h-5 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                
                <div class="overflow-x-auto scrollbar-hide -mx-2 px-2" id="categoryFilters" style="scroll-snap-type: x mandatory;">
                    <div class="flex gap-3 md:flex-wrap min-w-max md:min-w-0">
                        <button class="category-btn active flex-shrink-0" data-category="all" style="scroll-snap-align: start;">
                            All Products
                        </button>
                        <button class="category-btn flex-shrink-0" data-category="sterilization" style="scroll-snap-align: start;">
                            Sterilization Packaging
                        </button>
                        <button class="category-btn flex-shrink-0" data-category="monitoring" style="scroll-snap-align: start;">
                            Monitoring Products
                        </button>
                        <button class="category-btn flex-shrink-0" data-category="cleaning" style="scroll-snap-align: start;">
                            Instrument Care
                        </button>
                        <button class="category-btn flex-shrink-0" data-category="accessories" style="scroll-snap-align: start;">
                            CSSD Accessories
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
                <!-- Bowie-Dick Test -->
                <div class="product-card" data-category="monitoring">
                    <a href="product-details" class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group h-full flex flex-col block">
                        <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-6 overflow-hidden">
                            <img src="assets/images/Bowie-Dick test.png" 
                                 alt="Bowie-Dick Test" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-md">
                                ISO Certified
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 flex-grow flex flex-col">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600 transition-colors duration-300">Bowie-Dick Test</h3>
                            <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 line-clamp-2 flex-grow">Premium quality air removal test for steam sterilization validation and performance monitoring.</p>
                            
                            <!-- Price Range -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Price Range</p>
                                        <p class="text-lg sm:text-xl font-bold text-yellow-600">₹2,450 - ₹3,500</p>
                                    </div>
                                    <span class="text-xs text-gray-500">Order Now</span>
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md">
                                View Details
                            </div>
                        </div>
                    </a>
                </div>

                <!-- ZIC Autoclave Tape -->
                <div class="product-card" data-category="sterilization">
                    <a href="product-details" class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group h-full flex flex-col block">
                        <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-6 overflow-hidden">
                            <img src="assets/images/ZIC_Autoclave_Tape.png" 
                                 alt="ZIC Autoclave Tape" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-md">
                                FDA Approved
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 flex-grow flex flex-col">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600 transition-colors duration-300">ZIC Autoclave Tape</h3>
                            <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 line-clamp-2 flex-grow">High-quality steam sterilization indicator tape for medical instruments and packaging.</p>
                            
                            <!-- Price Range -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Price Range</p>
                                        <p class="text-lg sm:text-xl font-bold text-yellow-600">₹1,200 - ₹1,800</p>
                                    </div>
                                    <span class="text-xs text-gray-500">Order Now</span>
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md">
                                View Details
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Type 6 Emulating Indicator -->
                <div class="product-card" data-category="monitoring">
                    <a href="product-details" class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 group h-full flex flex-col block">
                        <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative p-6 overflow-hidden">
                            <img src="assets/images/ZIC Type_6 –Emulating_Indicator.png" 
                                 alt="Type 6 Emulating Indicator" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-md">
                                CE Marked
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 flex-grow flex flex-col">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600 transition-colors duration-300">Type 6 Emulating Indicator</h3>
                            <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 line-clamp-2 flex-grow">Advanced chemical indicator for sterilization process monitoring and validation.</p>
                            
                            <!-- Price Range -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Price Range</p>
                                        <p class="text-lg sm:text-xl font-bold text-yellow-600">₹3,200 - ₹4,500</p>
                                    </div>
                                    <span class="text-xs text-gray-500">Order Now</span>
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <div class="w-full bg-yellow-500 group-hover:bg-yellow-600 text-white font-semibold text-center py-3 rounded-lg transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-md">
                                View Details
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Sterilization Pouches (keeping one generic product) -->
                <div class="product-card" data-category="cleaning">
                    <a href="product-details" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-64">
                                <img src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=800&q=80" 
                                     alt="Enzymatic Detergent" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white text-xl font-semibold">Enzymatic Detergent</h3>
                                    <p class="text-white/90 text-sm mt-1">Advanced cleaning formulation</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Biodegradable</span>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">pH Neutral</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Multi-enzymatic formulation for effective removal of organic matter from surgical instruments.</p>
                                <span class="inline-flex items-center text-yellow-500 hover:text-yellow-600 font-medium">
                                    Learn More
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- CSSD Accessories -->
                <div class="product-card" data-category="accessories">
                    <a href="product-details" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-64">
                                <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80" 
                                     alt="Sterilization Containers" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white text-xl font-semibold">Sterilization Containers</h3>
                                    <p class="text-white/90 text-sm mt-1">Durable aluminum construction</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">ISO 13485</span>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Autoclavable</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Reusable sterilization containers with validated sterility maintenance.</p>
                                <span class="inline-flex items-center text-yellow-500 hover:text-yellow-600 font-medium">
                                    Learn More
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
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
                    <a href="mailto:info@zegnen.com" class="inline-flex items-center bg-yellow-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-yellow-600 transition-colors">
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

<link rel="stylesheet" href="assets/css/product-filter.css">
<script src="assets/js/product-filter.js"></script>

<?php
// Output the footer
echo getFooter();
?>