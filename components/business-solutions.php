<?php
function getBusinessSolutionsSection() {
    ob_start();
?>
<!-- Business Solutions Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Healthcare Professionals & Hospitals -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-6">
                    <h3 class="text-2xl sm:text-2xl lg:text-3xl font-bold text-yellow-500 mb-3 sm:mb-4">
                        Hospitals, Clinics & Laboratories
                    </h3>
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6">
                        Serving healthcare institutions worldwide with comprehensive CSSD solutions designed for maximum safety and efficiency.
                    </p>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 sm:py-3 px-5 sm:px-6 rounded-lg transition-colors duration-300 text-sm sm:text-base">
                        Partner with us
                    </button>
                </div>
                
                <!-- Healthcare Building Illustration -->
                <div class="flex justify-center items-end h-40 sm:h-48 relative">
                    <div class="relative">
                        <div class="w-28 sm:w-32 h-36 sm:h-40 bg-gray-100 rounded-t-2xl border-2 border-gray-300 relative">
                            <div class="grid grid-cols-4 gap-1 p-2 mt-4">
                                <?php for($i = 0; $i < 8; $i++): ?>
                                <div class="w-3 h-3 sm:w-4 sm:h-4 bg-gray-300 rounded"></div>
                                <?php endfor; ?>
                            </div>
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-7 sm:w-8 h-10 sm:h-12 bg-yellow-400 rounded-t-lg border-2 border-yellow-500"></div>
                        </div>
                        <!-- Sun -->
                        <div class="absolute -top-8 -right-8 w-10 sm:w-12 h-10 sm:h-12 bg-yellow-400 rounded-full">
                            <div class="absolute inset-2 bg-yellow-300 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- International Quality Standards -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-6">
                    <h3 class="text-2xl sm:text-2xl lg:text-3xl font-bold text-yellow-500 mb-3 sm:mb-4">
                        International Quality Standards
                    </h3>
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6">
                        All products meet ISO, CE, and EN norms ensuring maximum compliance and safety in sterilization processes worldwide.
                    </p>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 sm:py-3 px-5 sm:px-6 rounded-lg transition-colors duration-300 text-sm sm:text-base">
                        Get certified
                    </button>
                </div>
                
                <!-- Office Setup Illustration -->
                <div class="flex justify-center items-end h-40 sm:h-48 relative">
                    <div class="relative">
                        <div class="w-32 sm:w-36 h-16 sm:h-20 bg-gray-200 rounded-lg border-2 border-gray-300 relative">
                            <!-- Illustrations -->
                            <div class="absolute -top-10 sm:-top-12 left-3 sm:left-4 w-14 sm:w-16 h-10 sm:h-12 bg-yellow-400 rounded border-2 border-yellow-500">
                                <div class="w-full h-6 sm:h-8 bg-yellow-300 rounded-t"></div>
                            </div>
                            <div class="absolute -top-2 left-6 sm:left-8 w-3 sm:w-4 h-3 sm:h-4 bg-gray-400 rounded"></div>
                            <div class="absolute -top-6 sm:-top-8 right-2 w-10 sm:w-12 h-12 sm:h-16 bg-gray-300 rounded-lg border-2 border-gray-400">
                                <div class="w-full h-6 sm:h-8 bg-gray-200 rounded-t"></div>
                                <div class="absolute bottom-2 w-full h-3 sm:h-4 bg-yellow-400 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Careers @ ZIC -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 md:col-span-2 lg:col-span-1">
                <div class="mb-6">
                    <h3 class="text-2xl sm:text-2xl lg:text-3xl font-bold text-yellow-500 mb-3 sm:mb-4">
                        Careers @ ZEGNEN
                    </h3>
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6">
                        Join our team dedicated to transforming healthcare through innovative CSSD solutions and infection prevention.
                    </p>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 sm:py-3 px-5 sm:px-6 rounded-lg transition-colors duration-300 text-sm sm:text-base">
                        Join us
                    </button>
                </div>
                
                <!-- Career/Growth Illustration -->
                <div class="flex justify-center items-end h-40 sm:h-48 relative">
                    <div class="relative">
                        <div class="flex items-end space-x-2">
                            <?php
                            $heights = [16, 20, 24, 28];
                            $colors = ['gray-300', 'gray-400', 'yellow-400', 'yellow-500'];
                            foreach ($heights as $i => $height): ?>
                                <div class="w-5 sm:w-6 h-<?php echo $height; ?> bg-<?php echo $colors[$i]; ?> rounded-t"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}
?>