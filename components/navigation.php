<?php
function getNavigation() {
    // Include settings helper
    require_once __DIR__ . '/../config/settings.php';
    
    ob_start();
?>
<nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-sm bg-black/30 transition-all duration-300">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-12 py-4 transition-all duration-300" id="navContainer">
        <!-- Logo -->
        <div class="text-white">
            <a href="index" class="inline-flex items-center -space-x-4">
                <img src="<?php echo $baseUrl; ?>assets/images/zic_logo.png" alt="ZEGNEN Logo" class="h-8 sm:h-10 lg:h-12 w-auto transition-all duration-300" id="navLogoImg">
                <h1 class="text-lg sm:text-xl lg:text-3xl font-bold tracking-wide transition-all duration-300" id="navLogo">ZEGNEN</h1>
            </a>
        </div>

        <!-- Desktop Navigation Menu -->
        <div class="hidden lg:flex items-center space-x-6">
            <div class="flex items-center space-x-6 text-white">
                <a href="our-products" class="flex items-center space-x-2 hover:opacity-80 transition-opacity <?php echo (basename($_SERVER['PHP_SELF']) == 'our-products.php') ? 'opacity-100 border-b-2 border-yellow-500' : ''; ?>">
                    <span class="text-sm lg:text-base font-medium">Our Products</span>
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8zM9 8a3 3 0 0 1 6 0" />
                    </svg>
                </a>
                <a href="why-zegnen" class="text-sm lg:text-base font-medium hover:opacity-80 transition-opacity <?php echo (basename($_SERVER['PHP_SELF']) == 'why-zegnen.php') ? 'opacity-100 border-b-2 border-yellow-500 pb-1' : ''; ?>">Why ZEGNEN?</a>
                <a href="about" class="text-sm lg:text-base font-medium hover:opacity-80 transition-opacity <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'opacity-100 border-b-2 border-yellow-500 pb-1' : ''; ?>">About Us</a>
                <a href="contact-us" class="text-sm lg:text-base font-medium hover:opacity-80 transition-opacity <?php echo (basename($_SERVER['PHP_SELF']) == 'contact-us.php') ? 'opacity-100 border-b-2 border-yellow-500 pb-1' : ''; ?>">Contact Us</a>
            </div>
            
            <!-- Desktop Call Button - Yellow border design -->
            <div class="flex items-center">
                <a href="<?php echo getPhoneUrl(); ?>"
                    class="bg-transparent hover:bg-yellow-500 border-2 border-yellow-500 text-white hover:text-gray-900 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 flex items-center gap-2 whitespace-nowrap shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Call Now <?php echo htmlspecialchars(getSetting('call_number')); ?>
                </a>
            </div>
        </div>

        <!-- Mobile Menu Buttons -->
        <div class="lg:hidden flex items-center space-x-2">
            <!-- Mobile Our Products Button -->
            <a href="our-products" class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-3 py-1.5 rounded-full text-xs transition-all duration-300">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8zM9 8a3 3 0 0 1 6 0" />
                </svg>
                Our Products
            </a>
            
            <!-- Hamburger Menu Button -->
            <button id="mobileMenuBtn" class="text-white p-2 hover:bg-white/10 rounded-lg transition-all duration-300">
                <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div id="mobileDrawer" class="fixed inset-0 z-[60] lg:hidden pointer-events-none">
    <!-- Overlay -->
    <div id="drawerOverlay" class="absolute inset-0 bg-black/0 backdrop-blur-0 transition-all duration-300"></div>
    
    <!-- Drawer Panel -->
    <div id="drawerPanel" class="absolute top-0 right-0 h-full w-64 max-w-[75vw] bg-yellow-500 transform translate-x-full transition-transform duration-300 ease-out shadow-2xl">
        <div class="flex flex-col h-full">
            <!-- Close Button -->
            <div class="absolute top-4 right-4 z-10">
                <button id="drawerCloseBtn" class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-full transition-all duration-300 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Drawer Header -->
            <div class="px-5 pt-16 pb-4 border-b border-yellow-600">
                <div class="flex items-center gap-0.5 mb-2">
                    <img src="<?php echo $baseUrl; ?>assets/images/zic_logo_black.png" alt="ZEGNEN Logo" class="h-8 w-auto">
                    <h2 class="text-sm font-bold text-gray-900" style="font-family: 'Inter', sans-serif;">ZEGNEN</h2>
                </div>
                <p class="text-yellow-800 text-xs mt-0.5" style="font-family: 'Inter', sans-serif;">IT Research | Security | CSSD | Healthcare IT</p>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-4">
                <div class="px-3 space-y-1">
                    <a href="index" class="flex items-center justify-start px-3 py-2.5 text-gray-900 hover:bg-yellow-600 hover:text-white rounded-md transition-all duration-200 group <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'bg-yellow-600 text-white' : ''; ?>" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium text-left">Home</span>
                    </a>
                    
                    <a href="our-products" class="flex items-center justify-start px-3 py-2.5 text-gray-900 hover:bg-yellow-600 hover:text-white rounded-md transition-all duration-200 group <?php echo (basename($_SERVER['PHP_SELF']) == 'our-products.php') ? 'bg-yellow-600 text-white' : ''; ?>" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-sm font-medium text-left">Our Products</span>
                    </a>
                    
                    <a href="why-zegnen" class="flex items-center justify-start px-3 py-2.5 text-gray-900 hover:bg-yellow-600 hover:text-white rounded-md transition-all duration-200 group <?php echo (basename($_SERVER['PHP_SELF']) == 'why-zegnen.php') ? 'bg-yellow-600 text-white' : ''; ?>" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-left">Why ZEGNEN?</span>
                    </a>
                    
                    <a href="about" class="flex items-center justify-start px-3 py-2.5 text-gray-900 hover:bg-yellow-600 hover:text-white rounded-md transition-all duration-200 group <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'bg-yellow-600 text-white' : ''; ?>" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-left">About Us</span>
                    </a>
                    
                    <a href="contact-us" class="flex items-center justify-start px-3 py-2.5 text-gray-900 hover:bg-yellow-600 hover:text-white rounded-md transition-all duration-200 group <?php echo (basename($_SERVER['PHP_SELF']) == 'contact-us.php') ? 'bg-yellow-600 text-white' : ''; ?>" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-left">Contact Us</span>
                    </a>
                </div>

                <!-- Call Now Button -->
                <div class="px-3 mt-6 mb-4">
                    <a href="<?php echo getPhoneUrl(); ?>" class="flex items-center justify-center w-full bg-gray-900 hover:bg-black text-white font-bold px-4 py-3 rounded-full transition-all duration-300 shadow-lg text-sm border-2 border-gray-900 hover:border-black" style="font-family: 'Inter', sans-serif;">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-center">
                            <div class="font-bold text-sm">Call Now</div>
                            <div class="text-yellow-400 text-xs font-semibold"><?php echo htmlspecialchars(getSetting('call_number')); ?></div>
                        </span>
                    </a>
                </div>

                <!-- Company Information -->
                <div class="px-3 mt-6">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3 space-y-3">
                        <!-- Copyright & Developer -->
                        <div class="text-xs text-gray-800 leading-relaxed" style="font-family: 'Inter', sans-serif;">
                            <p class="font-semibold">©<?php echo date('Y'); ?> ZEGNEN</p>
                            <p class="mt-1">
                                Design and Develop by 
                                <a href="https://whatznot.com" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-gray-900 transition-colors">Whatznot</a>
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-yellow-400"></div>

                        <!-- Company Details -->
                        <div class="text-xs text-gray-800 leading-relaxed space-y-1" style="font-family: 'Inter', sans-serif;">
                            <p class="font-bold text-sm"><?php echo htmlspecialchars(getSetting('site_name')); ?></p>
                            <p class="font-semibold text-yellow-800">Registered Office</p>
                            <p class="font-medium"><?php echo htmlspecialchars(getSetting('site_name')); ?></p>
                            <p>Leading CSSD Products Manufacturer</p>
                            <p>Sterilization & Infection Control Solutions</p>
                            <?php if (getSetting('email')): ?>
                            <p class="mt-2">
                                <span class="font-semibold">Contact:</span> 
                                <a href="<?php echo getEmailUrl('Inquiry from Navigation'); ?>" class="hover:text-gray-900 transition-colors"><?php echo htmlspecialchars(getSetting('email')); ?></a>
                            </p>
                            <?php endif; ?>
                            <?php if (getSetting('call_number')): ?>
                            <p>
                                <span class="font-semibold">Phone:</span> 
                                <a href="<?php echo getPhoneUrl(); ?>" class="hover:text-gray-900 transition-colors"><?php echo htmlspecialchars(getSetting('call_number')); ?></a>
                            </p>
                            <?php endif; ?>
                            <p>
                                <span class="font-semibold">Compliance Officer:</span><br>
                                Quality Assurance Team
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="border-t border-yellow-600 px-5 py-4">
                <p class="text-yellow-800 text-xs font-medium mb-3" style="font-family: 'Inter', sans-serif;">Follow Us</p>
                <div class="flex items-center justify-between">
                    <?php if (hasSocialLink(getSetting('facebook_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if (hasSocialLink(getSetting('twitter_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo hasSocialLink(getSetting('instagram_url')) ? htmlspecialchars(getSetting('instagram_url')) : '#'; ?>" <?php if (hasSocialLink(getSetting('instagram_url'))): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="<?php echo hasSocialLink(getSetting('youtube_url')) ? htmlspecialchars(getSetting('youtube_url')) : '#'; ?>" <?php if (hasSocialLink(getSetting('youtube_url'))): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="<?php echo hasSocialLink(getSetting('linkedin_url')) ? htmlspecialchars(getSetting('linkedin_url')) : '#'; ?>" <?php if (hasSocialLink(getSetting('linkedin_url'))): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> class="flex items-center justify-center w-8 h-8 bg-gray-900 hover:bg-black text-white rounded-sm transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    // Get proper JS path
    $isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
    $baseUrl = $isLocalhost ? '/p/' : '/';
?>
<script src="<?php echo $baseUrl; ?>assets/js/navigation.js"></script>
<?php
    return ob_get_clean();
}
?>