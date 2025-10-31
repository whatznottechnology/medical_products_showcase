<?php
function getLeadPopup() {
    ob_start();
?>
<!-- Lead Capture Popup -->
<div id="leadPopup" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
            <!-- Close Button -->
            <button id="closePopup" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Content -->
            <div class="p-6">
                <!-- Product Image - Extra Large Banner Style -->
                <div class="flex justify-center mb-8">
                    <img src="assets/images/Bowie-Dick test.png" alt="CSSD Products" class="w-full h-80 object-contain rounded-xl shadow-lg bg-gradient-to-r from-yellow-50 to-yellow-100 p-4 border border-yellow-200">
                </div>

                <!-- Form -->
                <form id="leadForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="popupName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="popupName" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors"
                                   placeholder="Enter your full name">
                        </div>

                        <div>
                            <label for="popupPhone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="popupPhone" name="phone" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors"
                                   placeholder="+91 XXXXX XXXXX">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-6 rounded-xl transition-colors duration-300 flex items-center justify-center">
                        <span>Get Free Quote</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </button>
                </form>

                <!-- Footer Text -->
                <p class="text-xs text-gray-500 text-center mt-4">
                    We respect your privacy. No spam, only relevant updates.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    return ob_get_clean();
}
?>