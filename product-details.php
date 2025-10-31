<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Product data
$product = [
    'name' => 'Bowie-Dick Test Pack',
    'category' => 'Sterilization Monitoring Products',
    'image' => 'assets/images/Bowie-Dick test.png',
    'description' => 'A Bowie-Dick test is used in pre-vacuum type steam sterilizers to ensure that all air is removed and there are no air leaks. This test confirms proper air removal and steam penetration in the sterilization process.',
    'details' => 'The Bowie-Dick Test Pack is an essential quality control tool designed specifically for pre-vacuum steam sterilizers. It ensures complete air removal from the sterilization chamber, which is critical for effective sterilization. The test pack uses a chemical indicator that changes color uniformly when exposed to proper steam conditions, making it easy to verify sterilizer performance. Our test packs are manufactured according to ISO 11140 and EN 867 standards, ensuring reliable and consistent results. Each pack is individually wrapped and designed for single-use to maintain accuracy and prevent cross-contamination.',
    'instructions' => [
        'Single test use only',
        'Run a pre-vacuum cycle of 10 minutes at 121°C or 3.5 minutes at 134°C (ISO/EN standard)',
        'The paper materials can be discarded into a paper recycle bin',
        'PASS condition shows a uniform black/brown color pattern on the indicator sheet'
    ],
    'features' => [
        'ISO/EN compliant',
        'Reliable color change indicator',
        'Detects air leaks or steam penetration failure',
        'Eco-friendly paper materials'
    ],
    'specifications' => [
        ['label' => 'Test Type', 'value' => 'Bowie-Dick Air Removal Test'],
        ['label' => 'Sterilizer Type', 'value' => 'Pre-vacuum Steam Autoclave'],
        ['label' => 'Test Cycle', 'value' => '10 minutes at 121°C or 3.5 minutes at 134°C'],
        ['label' => 'Standard Compliance', 'value' => 'ISO 11140, EN 867'],
        ['label' => 'Indicator Type', 'value' => 'Chemical Indicator (Color Change)'],
        ['label' => 'Usage', 'value' => 'Single Use, Daily Test Recommended'],
        ['label' => 'Shelf Life', 'value' => '2-3 years from manufacture date'],
        ['label' => 'Storage', 'value' => 'Cool, dry place away from direct sunlight']
    ]
];

// Reviews data - Split into two rows
$reviewsRow1 = [
    ['name' => 'Dr. Sarah Johnson', 'role' => 'Hospital Manager', 'rating' => 5, 'comment' => 'Excellent quality test packs. We use them daily and they provide consistent, reliable results every time.'],
    ['name' => 'Michael Chen', 'role' => 'Lab Technician', 'rating' => 5, 'comment' => 'Easy to use and interpret. The color change is very clear and unmistakable. Highly recommend!'],
    ['name' => 'Dr. Priya Sharma', 'role' => 'Clinic Director', 'rating' => 5, 'comment' => 'ISO compliant and eco-friendly. Great product at a competitive price point.'],
    ['name' => 'James Anderson', 'role' => 'Quality Control Officer', 'rating' => 5, 'comment' => 'Been using these for 2 years now. Never had a false positive or negative. Very dependable.'],
    ['name' => 'Emma Thompson', 'role' => 'Sterilization Specialist', 'rating' => 5, 'comment' => 'The best Bowie-Dick packs we have tried. Clear instructions and excellent customer support.']
];

$reviewsRow2 = [
    ['name' => 'Dr. Robert Williams', 'role' => 'Medical Director', 'rating' => 5, 'comment' => 'Outstanding product quality. Helps us maintain the highest sterilization standards in our facility.'],
    ['name' => 'Lisa Martinez', 'role' => 'Lab Manager', 'rating' => 5, 'comment' => 'Reliable results every single time. Our team trusts this product completely.'],
    ['name' => 'David Lee', 'role' => 'Healthcare Professional', 'rating' => 5, 'comment' => 'Cost-effective solution without compromising on quality. Perfect for our needs.'],
    ['name' => 'Dr. Patricia Brown', 'role' => 'Surgery Department Head', 'rating' => 5, 'comment' => 'These test packs have become an essential part of our daily sterilization protocol.'],
    ['name' => 'Mark Thompson', 'role' => 'Quality Assurance Lead', 'rating' => 5, 'comment' => 'Consistent performance and easy to interpret results. Highly recommended for any facility.']
];

// Output the header and navigation
echo getHeader('Product Details - Bowie-Dick Test Pack | ZEGNEN');
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
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden">
                        <img src="<?php echo $product['image']; ?>?auto=format&fit=crop&w=800&q=80" 
                             alt="<?php echo $product['name']; ?>" 
                             class="w-full h-full object-cover">
                    </div>
                    <!-- ISO Badge -->
                    <div class="absolute top-4 right-4 float-animation">
                        <span class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            ISO/EN Certified
                        </span>
                    </div>
                </div>

                <!-- Right: Product Info & Overview -->
                <div class="space-y-6">
                    <!-- Category & Title -->
                    <div>
                        <span class="inline-block bg-gray-100 text-gray-700 px-4 py-1.5 rounded-full text-sm font-medium mb-3">
                            <?php echo $product['category']; ?>
                        </span>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
                            <?php echo $product['name']; ?>
                        </h1>
                    </div>

                    <!-- Product Overview -->
                    <div class="border-l-4 border-yellow-500 pl-4 py-2">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Product Overview</h2>
                        <p class="text-gray-700 leading-relaxed">
                            <?php echo $product['description']; ?>
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
                        <a href="tel:+918902056626" 
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
    <section class="relative overflow-hidden parallax-section-mobile" style="height: 600px;">
        <!-- Full-width background image -->
        <div class="parallax-bg absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('assets/images/Group 2.png'); background-attachment: fixed;">
        </div>
    </section>

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
                            <p class="text-base md:text-lg"><?php echo $product['details']; ?></p>
                            
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
                <div id="content-instructions" class="tab-content hidden">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Instructions for Use</h2>
                        </div>
                        
                        <!-- 60/40 Layout: Content and Video -->
                        <div class="instructions-video-layout">
                            <!-- 60% Content Area -->
                            <div>
                                <ul class="space-y-4">
                                    <?php foreach ($product['instructions'] as $index => $instruction): ?>
                                    <li class="flex items-start text-gray-700 leading-relaxed p-4 bg-gray-50 rounded-lg hover:bg-yellow-50 transition-all duration-300 transform hover:translate-x-2" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-500 text-gray-900 rounded-full flex items-center justify-center font-bold mr-4 text-sm">
                                            <?php echo $index + 1; ?>
                                        </span>
                                        <span class="pt-1"><?php echo $instruction; ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <!-- 40% Video Area -->
                            <div class="sticky top-24">
                                <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-lg">
                                    <div class="relative" style="padding-bottom: 56.25%; /* 16:9 aspect ratio */">
                                        <iframe 
                                            class="absolute top-0 left-0 w-full h-full"
                                            src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="p-4 bg-gray-800">
                                        <h3 class="text-white font-semibold text-sm">How to Use Bowie-Dick Test Pack</h3>
                                        <p class="text-gray-400 text-xs mt-1">Watch this tutorial for step-by-step guidance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Tab -->
                <div id="content-features" class="tab-content hidden">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Key Features</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($product['features'] as $index => $feature): ?>
                            <div class="flex items-start text-gray-700 leading-relaxed p-5 bg-gradient-to-r from-green-50 to-transparent rounded-lg border border-green-100 hover:border-green-300 transition-all duration-300 transform hover:scale-105" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium"><?php echo $feature; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="content-specifications" class="tab-content hidden">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
                        <div class="p-6 md:p-8 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                <svg class="w-7 h-7 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Technical Specifications
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($product['specifications'] as $index => $spec): ?>
                                    <tr class="hover:bg-yellow-50 transition-colors duration-200" style="animation: fadeInUp 0.5s ease-out <?php echo $index * 0.05; ?>s both;">
                                        <td class="py-5 px-6 font-semibold text-gray-900 w-1/3 bg-gray-50">
                                            <?php echo $spec['label']; ?>
                                        </td>
                                        <td class="py-5 px-6 text-gray-700"><?php echo $spec['value']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Player Section -->
    <section class="relative overflow-hidden video-section-mobile parallax-section-mobile" style="height: 600px; margin: 40px 0; padding: 20px 0;">
        <!-- Full-width background video with fixed attachment -->
        <div class="absolute inset-0" style="clip-path: inset(0);">
            <div style="position: fixed; width: 100%; height: 100vh; top: 0; left: 0;">
                <iframe 
                    id="productVideo"
                    style="width: 100%; height: 100%; border: none; object-fit: cover;"
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playlist=dQw4w9WgXcQ"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

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
                    
                    <!-- First Row - Scrolls Left to Right -->
                    <div id="reviewsSlider1" class="reviews-slider pb-4 mb-6">
                        <?php foreach ($reviewsRow1 as $review): ?>
                        <div class="review-card flex-shrink-0 w-80 md:w-96 bg-gradient-to-br from-gray-50 to-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    <?php echo substr($review['name'], 0, 1); ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo $review['name']; ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo $review['role']; ?></p>
                                </div>
                            </div>
                            <div class="star-rating mb-3">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <span class="star">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 leading-relaxed italic">"<?php echo $review['comment']; ?>"</p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Second Row - Scrolls Right to Left -->
                    <div id="reviewsSlider2" class="reviews-slider-reverse pb-4">
                        <?php foreach ($reviewsRow2 as $review): ?>
                        <div class="review-card flex-shrink-0 w-80 md:w-96 bg-gradient-to-br from-yellow-50 to-white p-6 rounded-2xl border border-yellow-200 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    <?php echo substr($review['name'], 0, 1); ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo $review['name']; ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo $review['role']; ?></p>
                                </div>
                            </div>
                            <div class="star-rating mb-3">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <span class="star">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 leading-relaxed italic">"<?php echo $review['comment']; ?>"</p>
                        </div>
                        <?php endforeach; ?>
                    </div>
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
                            <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                            
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

<?php
// Output the footer
echo getFooter();
?>
