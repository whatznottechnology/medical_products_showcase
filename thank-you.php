<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';
require_once 'config/settings.php';

// Output the header and navigation
echo getHeader('Thank You - ' . getSetting('site_name'));
echo getNavigation();
?>

<main class="relative z-10">
    <!-- Thank You Section -->
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-50 via-white to-yellow-50 py-20 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-2xl animate-pulse">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <!-- Decorative circles -->
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full animate-bounce"></div>
                    <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                </div>
            </div>

            <!-- Message -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                Thank You!
            </h1>
            <p class="text-xl sm:text-2xl text-yellow-600 font-semibold mb-6">
                Your Message Has Been Sent Successfully
            </p>
            <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto">
                We appreciate you reaching out to ZEGNEN. Our team will review your inquiry and get back to you as soon as possible, typically within 24 hours.
            </p>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10 max-w-xl mx-auto">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-yellow-100">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Check Your Email</h3>
                    <p class="text-sm text-gray-600">You'll receive a confirmation email shortly</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-yellow-100">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Quick Response</h3>
                    <p class="text-sm text-gray-600">We respond within 24 business hours</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="index" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-8 py-4 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Back to Home
                </a>

                <a href="our-products" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-900 font-semibold px-8 py-4 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-yellow-500 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    View Products
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-4">Need immediate assistance?</p>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <?php if (getSetting('call_number')): ?>
                    <a href="<?php echo getPhoneUrl(); ?>" class="flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <?php echo htmlspecialchars(getSetting('call_number')); ?>
                    </a>
                    <?php endif; ?>
                    <?php if (getSetting('email')): ?>
                    <a href="<?php echo getEmailUrl('Thank you message'); ?>" class="flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo htmlspecialchars(getSetting('email')); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Output the footer
echo getFooter();
?>
