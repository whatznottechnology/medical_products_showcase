<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Output the header and navigation
echo getHeader('Our Products - ZEGNEN CSSD Solutions');
echo getNavigation();
?>

<main class="relative min-h-screen">
    <!-- Hero Section -->
    <section class="relative bg-[url('https://images.unsplash.com/photo-1581093458791-8a1462c5af0c?auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative container mx-auto px-6 lg:px-12 py-24 mt-16">
            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">CSSD Product Solutions</h1>
            <p class="text-lg text-white/90 max-w-2xl">
                Comprehensive range of high-quality sterilization and infection control products designed for modern healthcare facilities.
            </p>
        </div>
    </section>

    <!-- Product Categories Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Category Filters -->
            <div class="flex flex-wrap gap-4 mb-8" id="categoryFilters">
                <button class="category-btn active" data-category="all">
                    All Products
                </button>
                <button class="category-btn" data-category="sterilization">
                    Sterilization Packaging
                </button>
                <button class="category-btn" data-category="monitoring">
                    Monitoring Products
                </button>
                <button class="category-btn" data-category="cleaning">
                    Instrument Care
                </button>
                <button class="category-btn" data-category="accessories">
                    CSSD Accessories
                </button>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
                <!-- Sterilization Packaging -->
                <div class="product-card" data-category="sterilization">
                    <a href="product-details.php" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-64">
                                <img src="https://images.unsplash.com/photo-1603165781687-92df129820a5?auto=format&fit=crop&w=800&q=80" 
                                     alt="Sterilization Pouches" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white text-xl font-semibold">Sterilization Pouches</h3>
                                    <p class="text-white/90 text-sm mt-1">Medical-grade material, multiple sizes available</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">ISO 11607</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">CE Certified</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Self-sealing sterilization pouches with chemical indicators for steam, EO, and plasma sterilization.</p>
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

                <!-- Monitoring Products -->
                <div class="product-card" data-category="monitoring">
                    <a href="product-details.php" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-64">
                                <img src="https://images.unsplash.com/photo-1579154204845-5d37f57827b3?auto=format&fit=crop&w=800&q=80" 
                                     alt="Chemical Indicators" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white text-xl font-semibold">Chemical Indicators</h3>
                                    <p class="text-white/90 text-sm mt-1">Process monitoring solutions</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">ISO 11140</span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Class 4</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Multi-parameter indicators for monitoring critical sterilization parameters.</p>
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

                <!-- Instrument Care -->
                <div class="product-card" data-category="cleaning">
                    <a href="product-details.php" class="block">
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
                    <a href="product-details.php" class="block">
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