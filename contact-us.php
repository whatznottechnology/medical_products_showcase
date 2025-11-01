<?php
require_once 'config/production.php';
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';
require_once 'config/settings.php';

// Output the header and navigation
echo getHeader(
    'Contact Us - ZEGNEN International Company | Get CSSD Solutions',
    'Contact ZEGNEN for CSSD products, sterilization solutions, and infection control needs. 24/7 expert support, product consultations, and technical assistance. Contact us for healthcare sterilization solutions.',
    'contact ZEGNEN, CSSD support, sterilization help, infection control consultation, medical device inquiry, healthcare product support, sterilization consultation, CSSD technical support, medical equipment inquiry'
);
echo getNavigation();
?>

<main class="relative z-10">
    <!-- Hero Section -->
    <section class="relative overflow-hidden" style="height: 80vh;">
        <!-- Background Video -->
        <div class="absolute inset-0">
            <video 
                autoplay 
                loop 
                muted 
                playsinline
                class="w-full h-full object-cover object-[23.50%] lg:object-center"
                style="pointer-events: none;">
                <source src="assets/images/contact_us.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/70"></div>
        </div>
        
        <!-- Content -->
        <div class="relative h-full flex items-end justify-center lg:justify-end px-6 lg:px-12 pb-16">
            <div class="w-full lg:w-[35%] max-w-xl">
                <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">Get In Touch</h1>
                <p class="text-xl text-white/90 mb-8">
                    We're here to help with CSSD products, sterilization, and infection control solutions.
                </p>
                <div class="flex flex-wrap gap-4 text-yellow-400">
                    <?php if (getSetting('call_number')): ?>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="font-medium"><?php echo htmlspecialchars(getSetting('call_number')); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (getSetting('email')): ?>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium"><?php echo htmlspecialchars(getSetting('email')); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information & Form Section -->
    <section class="bg-gradient-to-b from-gray-50 to-white py-20">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Let's Connect</h2>
                <div class="w-24 h-1 bg-yellow-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Have questions about our CSSD solutions? Our team is here to help you find the right products for your facility.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-7xl mx-auto">
                <!-- Contact Information -->
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Our Address</h3>
                                <p class="text-gray-600 leading-relaxed">123 Healthcare Avenue, Medical District</p>
                                <p class="text-gray-600">New Delhi, 110001, India</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Phone</h3>
                                <?php if (getSetting('call_number')): ?>
                                <a href="<?php echo getPhoneUrl(); ?>" class="text-gray-600 hover:text-yellow-600 transition-colors block"><?php echo htmlspecialchars(getSetting('call_number')); ?></a>
                                <?php endif; ?>
                                <?php if (getSetting('whatsapp_number')): ?>
                                <a href="<?php echo getWhatsAppUrl('Hello! I would like to inquire about your CSSD products.'); ?>" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-yellow-600 transition-colors block flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                                <?php if (getSetting('email')): ?>
                                <a href="<?php echo getEmailUrl('Inquiry about ZEGNEN CSSD Products'); ?>" class="text-gray-600 hover:text-yellow-600 transition-colors block"><?php echo htmlspecialchars(getSetting('email')); ?></a>
                                <?php endif; ?>
                                <!-- Additional support email can be added here if needed -->
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Connect With Us</h3>
                        <div class="flex space-x-4">
                            <?php if (hasSocialLink(getSetting('facebook_url'))): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-lg text-white flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md" aria-label="Facebook">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if (hasSocialLink(getSetting('twitter_url'))): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-blue-400 hover:bg-blue-500 rounded-lg text-white flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md" aria-label="Twitter">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if (hasSocialLink(getSetting('youtube_url'))): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('youtube_url')); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-lg text-white flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md" aria-label="YouTube">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M21.593 7.203a2.506 2.506 0 00-1.762-1.766C18.265 5.007 12 5 12 5s-6.264-.007-7.831.44a2.56 2.56 0 00-1.766 1.778c-.44 1.61-.44 4.976-.44 4.976s0 3.366.44 4.976c.243.877.909 1.534 1.766 1.778 1.582.448 7.831.448 7.831.448s6.264 0 7.831-.448a2.51 2.51 0 001.767-1.778c.44-1.61.44-4.976.44-4.976s0-3.366-.44-4.976zM9.998 15.505V10.49l5.227 2.507-5.227 2.507z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if (hasSocialLink(getSetting('instagram_url'))): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('instagram_url')); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-pink-600 hover:bg-pink-700 rounded-lg text-white flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md" aria-label="Instagram">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (hasSocialLink(getSetting('linkedin_url'))): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('linkedin_url')); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-blue-700 hover:bg-blue-800 rounded-lg text-white flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md" aria-label="LinkedIn">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white p-8 lg:p-10 rounded-2xl shadow-xl border border-gray-100">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Send Us a Message</h2>
                    <form id="contactForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" required class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 outline-none" placeholder="John Doe">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 outline-none" placeholder="john@example.com">
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 outline-none" placeholder="+91 12345 67890">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 outline-none" placeholder="How can we help you?">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 outline-none resize-none" placeholder="Tell us more about your inquiry..."></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl shadow-lg flex items-center justify-center space-x-2">
                                <span>Send Message</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-6 lg:px-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Find Us</h2>
            <div class="rounded-xl overflow-hidden shadow-lg h-96">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.2536900776364!2d77.20659841508096!3d28.56325198244263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce26f903969d7%3A0x8f66310952faef77!2sAIIMS%20Delhi!5e0!3m2!1sen!2sin!4v1651900284446!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</main>

<script>
// Handle contact form submission
document.getElementById('contactForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Sending...';
    
    try {
        const formData = new FormData(this);
        
        // Add source tracking
        formData.append('source_page', 'contact-us');
        formData.append('source_url', window.location.href);
        
        const response = await fetch('api/submit-inquiry.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Redirect to thank you page
            window.location.href = 'thank-you.php?type=inquiry';
        } else {
            alert(result.message || 'Failed to submit inquiry. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    } catch (error) {
        console.error('Error submitting inquiry:', error);
        alert('An error occurred. Please try again later.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
});
</script>

<?php
// Output the footer
echo getFooter();
?>