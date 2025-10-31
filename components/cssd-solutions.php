<?php
function getCssdSolutionsSection() {
    ob_start();
?>
<section class="bg-gray-50 py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-12">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-8 sm:gap-12">
        <!-- Left Content -->
        <div class="flex-1 w-full">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold text-yellow-500 leading-tight mb-4 sm:mb-6">
                The more you sterilize,<br>
                <span class="text-yellow-600">the safer you stay.</span>
            </h2>

            <div class="flex items-center mb-4 sm:mb-6">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-600 font-semibold text-base sm:text-lg">Get up to 30% off on bulk orders!</span>
            </div>

            <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-6 sm:mb-8 max-w-lg">
                Finally a CSSD Solution Provider that just works. ZEGNEN offers 
                innovative, reliable, and cost-effective solutions with years of 
                experience in healthcare and medical device industry.
            </p>
        </div>

        <!-- Right Content - Product Showcase -->
        <div class="flex-1 flex justify-center w-full">
            <div class="relative w-full max-w-md">
                <!-- Main Card -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-yellow-400 p-6 sm:p-8">
                    <div class="text-center mb-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">ZEGNEN</h3>
                        <div class="flex justify-center items-center mb-4">
                            <div class="flex text-yellow-400">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">4.9</span>
                        </div>
                    </div>

                    <!-- Medical Equipment Icons -->
                    <div class="grid grid-cols-4 gap-3 sm:gap-4 mb-6">
                        <!-- Icons grid here... -->
                    </div>

                    <!-- CTA Button -->
                    <a href="our-products" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-xl transition-colors duration-300 flex items-center justify-center text-sm sm:text-base">
                        <span>Explore Our  Products</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}
?>