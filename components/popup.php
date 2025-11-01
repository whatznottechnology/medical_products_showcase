<?php
function getLeadPopup() {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../config/FileUploader.php';
    
    // Fetch active popup
    $db = Database::getInstance();
    $popup = $db->fetchOne("SELECT * FROM popup WHERE is_enabled = 1 ORDER BY id DESC LIMIT 1");
    
    // If no popup, return empty
    if (!$popup) {
        return '';
    }
    
    // Use FileUploader helper to normalize image paths
    $imagePath = !empty($popup['image_path']) ? FileUploader::getImagePath($popup['image_path']) : '';
    
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

            <!-- Form Content -->
            <div id="popupFormContent" class="p-6">
                <!-- Product Image - Extra Large Banner Style -->
                <div class="flex justify-center mb-8">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($popup['alt_text'] ?? 'Popup'); ?>" class="w-full h-80 object-contain rounded-xl shadow-lg bg-gradient-to-r from-yellow-50 to-yellow-100 p-4 border border-yellow-200">
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

            <!-- Thank You Message (Hidden by default) -->
            <div id="popupThankYou" class="p-6 hidden">
                <div class="text-center py-12">
                    <!-- Success Icon -->
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                        <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <!-- Thank You Text -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Thank You!</h3>
                    <p class="text-gray-600 mb-2">Your request has been submitted successfully.</p>
                    <p class="text-sm text-gray-500">Our team will contact you shortly.</p>
                    
                    <!-- Auto-close indicator -->
                    <p class="text-xs text-gray-400 mt-6">This window will close automatically...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const leadForm = document.getElementById('leadForm');
    const popupFormContent = document.getElementById('popupFormContent');
    const popupThankYou = document.getElementById('popupThankYou');
    const leadPopup = document.getElementById('leadPopup');

    if (leadForm) {
        leadForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(leadForm);
            formData.append('source_page', 'popup');
            formData.append('source_url', window.location.href);

            try {
                const response = await fetch('api/submit-lead.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Hide form, show thank you message
                    popupFormContent.classList.add('hidden');
                    popupThankYou.classList.remove('hidden');

                    // Auto-close after 3 seconds
                    setTimeout(() => {
                        if (window.closeLeadPopup) {
                            window.closeLeadPopup();
                        } else {
                            leadPopup.classList.add('hidden');
                        }
                        
                        // Reset for next time
                        setTimeout(() => {
                            popupFormContent.classList.remove('hidden');
                            popupThankYou.classList.add('hidden');
                            leadForm.reset();
                        }, 500);
                    }, 3000);
                } else {
                    alert(result.message || 'Something went wrong. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            }
        });
    }
});
</script>
<?php
    return ob_get_clean();
}
?>