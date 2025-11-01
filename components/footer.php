<?php
function getFooter() {
    // Include settings helper
    require_once __DIR__ . '/../config/settings.php';
    
    ob_start();
?>
<footer class="bg-yellow-500 py-12 sm:py-16 px-4 sm:px-6 lg:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 lg:gap-12 mb-8 sm:mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-3 sm:mb-4">
                    <img src="assets/images/zic_logo_black.png" alt="ZEGNEN Logo" class="h-8 sm:h-10 w-auto">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900"><?php echo htmlspecialchars(getSetting('site_name')); ?></h3>
                </div>
                <p class="text-gray-800 text-sm sm:text-base leading-relaxed mb-4 sm:mb-6">
                    Leading manufacturer of CSSD products for sterilization, infection control, and hospital hygiene solutions.
                </p>
                
                <!-- Contact Information -->
                <div class="space-y-3">
                    <!-- Mobile: Horizontal layout -->
                    <div class="block sm:hidden">
                        <div class="flex flex-col space-y-2">
                            <?php if (getSetting('call_number')): ?>
                            <a href="<?php echo getPhoneUrl(); ?>" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <span><?php echo htmlspecialchars(getSetting('call_number')); ?></span>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (getSetting('email')): ?>
                            <a href="<?php echo getEmailUrl('Inquiry about ZEGNEN Products'); ?>" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <span><?php echo htmlspecialchars(getSetting('email')); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Desktop/Tablet: Vertical layout -->
                    <div class="hidden sm:block space-y-3">
                        <?php if (getSetting('call_number')): ?>
                        <a href="<?php echo getPhoneUrl(); ?>" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <?php echo htmlspecialchars(getSetting('call_number')); ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (getSetting('email')): ?>
                        <a href="<?php echo getEmailUrl('Inquiry about ZEGNEN Products'); ?>" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <?php echo htmlspecialchars(getSetting('email')); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="lg:col-span-1">
                <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Why ZEGNEN?</h4>
                <ul class="space-y-2 sm:space-y-3">
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">High-Quality Certified Products</a></li>
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">International Standards</a></li>
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Sustainable Solutions</a></li>
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Expert Technical Support</a></li>
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Reliable After-Sales Service</a></li>
                    <li><a href="#" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Cost-Effective Solutions</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="lg:col-span-1">
                <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Quick Links</h4>
                <ul class="space-y-2 sm:space-y-3">
                    <li><a href="index" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Home</a></li>
                    <li><a href="about" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">About Us</a></li>
                    <li><a href="our-products" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Our Products</a></li>
                    <li><a href="why-zegnen" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Why ZEGNEN?</a></li>
                    <li><a href="contact-us" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Contact Us</a></li>
                    <li><a href="career" class="text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">Careers</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="lg:col-span-1">
                <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Follow Us</h4>
                
                <!-- Desktop View -->
                <div class="hidden sm:block space-y-3 sm:space-y-4">
                    <?php if (hasSocialLink(getSetting('instagram_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('instagram_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram
                    </a>
                    <?php endif; ?>
                    
                    <?php if (hasSocialLink(getSetting('twitter_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Twitter
                    </a>
                    <?php endif; ?>
                    
                    <?php if (hasSocialLink(getSetting('youtube_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('youtube_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        YouTube
                    </a>
                    <?php endif; ?>
                    
                    <?php if (hasSocialLink(getSetting('facebook_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    <?php endif; ?>
                    
                    <?php if (hasSocialLink(getSetting('linkedin_url'))): ?>
                    <a href="<?php echo htmlspecialchars(getSetting('linkedin_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-800 hover:text-gray-900 font-medium transition-colors duration-300 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Horizontal Scroll -->
                <div class="sm:hidden overflow-x-auto scrollbar-hide -mx-4 px-4">
                    <div class="flex gap-3 pb-2" style="scroll-snap-type: x mandatory;">
                        <?php if (hasSocialLink(getSetting('instagram_url'))): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('instagram_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl p-4 transition-all duration-300 flex-shrink-0" style="width: 80px; scroll-snap-align: start;">
                            <svg class="w-8 h-8 text-gray-900 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <span class="text-gray-900 text-xs font-semibold">Instagram</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (hasSocialLink(getSetting('twitter_url'))): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl p-4 transition-all duration-300 flex-shrink-0" style="width: 80px; scroll-snap-align: start;">
                            <svg class="w-8 h-8 text-gray-900 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            <span class="text-gray-900 text-xs font-semibold">Twitter</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (hasSocialLink(getSetting('youtube_url'))): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('youtube_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl p-4 transition-all duration-300 flex-shrink-0" style="width: 80px; scroll-snap-align: start;">
                            <svg class="w-8 h-8 text-gray-900 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            <span class="text-gray-900 text-xs font-semibold">YouTube</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (hasSocialLink(getSetting('facebook_url'))): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl p-4 transition-all duration-300 flex-shrink-0" style="width: 80px; scroll-snap-align: start;">
                            <svg class="w-8 h-8 text-gray-900 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="text-gray-900 text-xs font-semibold">Facebook</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (hasSocialLink(getSetting('linkedin_url'))): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('linkedin_url')); ?>" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl p-4 transition-all duration-300 flex-shrink-0" style="width: 80px; scroll-snap-align: start;">
                            <svg class="w-8 h-8 text-gray-900 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <span class="text-gray-900 text-xs font-semibold">LinkedIn</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating WhatsApp Button -->
        <?php if (getSetting('whatsapp_number')): ?>
        <a href="<?php echo getWhatsAppUrl('Hello! I am interested in your ZEGNEN products.'); ?>" 
           target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 p-4 rounded-full shadow-xl transition-all duration-300 transform hover:scale-110 z-50 group">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="absolute bottom-full right-0 mb-2 bg-gray-900 text-white text-xs px-3 py-2 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                Chat on WhatsApp
            </span>
        </a>
        <?php endif; ?>

        <!-- Bottom Footer -->
        <div class="border-t border-yellow-400 pt-6 sm:pt-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-6 lg:space-y-0">
                <!-- Copyright and Legal Links -->
                <div class="flex flex-col space-y-3 sm:space-y-4 w-full lg:w-auto">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <span class="text-gray-800 text-xs sm:text-sm">©<?php echo date('Y'); ?> ZEGNEN</span>
                        <span class="hidden sm:inline text-gray-700">|</span>
                        <span class="text-gray-800 text-xs sm:text-sm">
                            Design and Develop by 
                            <a href="https://whatznot.com" target="_blank" rel="noopener noreferrer" class="font-semibold hover:text-gray-900 transition-colors duration-300">Whatznot</a>
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                        <a href="terms-and-conditions" class="text-gray-800 hover:text-gray-900 transition-colors duration-300">Terms & Conditions</a>
                        <a href="privacy-policy" class="text-gray-800 hover:text-gray-900 transition-colors duration-300">Privacy Policy</a>
                    </div>
                </div>

                <!-- Company Registration -->
                <div class="w-full lg:w-auto lg:text-right">
                    <p class="text-gray-800 text-sm sm:text-base font-medium"><?php echo htmlspecialchars(getSetting('site_name', 'ZEGNEN International Company')); ?></p>
                    <div class="text-gray-700 text-xs mt-1 space-y-0.5">
                        <p><strong>Registered Office</strong></p>
                        <p><?php echo htmlspecialchars(getSetting('site_name', 'ZEGNEN INTERNATIONAL COMPANY')); ?></p>
                        <p>Leading CSSD Products Manufacturer</p>
                        <p>Sterilization & Infection Control Solutions</p>
                        <?php if (getSetting('email')): ?>
                        <p>Contact: <?php echo htmlspecialchars(getSetting('email')); ?></p>
                        <?php endif; ?>
                        <p>Compliance Officer: Quality Assurance Team</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<?php
    return ob_get_clean();
}
?>