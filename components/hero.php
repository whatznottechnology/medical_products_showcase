<?php
function getHeroSection() {
    // Fetch banner from database
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../includes/frontend-helper.php';
    $db = Database::getInstance();
    $banner = $db->fetchOne("SELECT image_path FROM banners WHERE page = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1", ['home']);
    
    $heroBannerPath = !empty($banner['image_path']) 
        ? FrontendHelper::getImageUrl($banner['image_path'])
        : '';
    
    ob_start();
?>
<!-- Hero Section with Background -->
<div class="relative min-h-screen" style="background-image: url('<?php echo htmlspecialchars($heroBannerPath); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <!-- Dark overlay for better text readability -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>
    
    <main class="relative z-10 min-h-screen flex flex-col justify-center px-4 sm:px-6 lg:px-12 pt-24 sm:pt-20 pb-8 md:pt-20">
    <div class="max-w-6xl">
        <!-- Main Heading -->
        <h1 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-light leading-tight mb-2 sm:mb-3">
            Healthcare Excellence,
        </h1>
        <h2 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-4 sm:mb-6 md:mb-8">
            Hello ZEGNEN.
        </h2>

        <!-- Subtitle -->
        <div class="text-white text-sm sm:text-base lg:text-lg font-light space-y-0.5 sm:space-y-1 mb-6 sm:mb-8 md:mb-6 max-w-2xl">
            <p class="leading-relaxed">
                ZEGNEN INTERNATIONAL COMPANY - Leading manufacturer of CSSD products
            </p>
            <p class="leading-relaxed">
                for sterilization & infection control, ensuring safety and compliance worldwide.
            </p>
        </div>

        <!-- Search Section -->
        <div class="max-w-2xl">
            <!-- Search Bar -->
            <form action="search-results" method="GET" id="heroSearchForm">
                <div class="bg-white/95 backdrop-blur-sm rounded-full shadow-lg overflow-hidden mb-3 sm:mb-4">
                    <div class="flex items-center px-4 sm:px-6 py-3 sm:py-4">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <div class="flex-1 relative">
                            <input type="text" id="searchInput" name="q"
                                class="w-full text-sm sm:text-base lg:text-lg text-gray-800 outline-none font-medium bg-transparent placeholder-gray-400"
                                placeholder=""
                                autocomplete="off">
                            <div class="absolute top-0 left-0 text-sm sm:text-base lg:text-lg font-medium pointer-events-none" id="placeholder">
                                <span class="text-gray-400">Search </span>
                                <span class="text-yellow-500 font-semibold">Sterilization</span>
                                <span class="text-gray-400"> Products</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Quality Assurance Text -->
            <div class="flex items-center text-white">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-xs sm:text-sm lg:text-base font-medium">ISO Certified Quality & International Standards!</span>
            </div>
        </div>
    </div>
</main>
</div>
<?php
    return ob_get_clean();
}
?>