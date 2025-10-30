<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Output the header and navigation
echo getHeader('Contact Us - ZEGNEN');
echo getNavigation();
?>

<main class="relative z-10">
    <!-- Hero Section -->
    <section class="relative bg-[url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative container mx-auto px-6 lg:px-12 py-24 mt-16">
            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">Get In Touch</h1>
            <p class="text-lg text-white/90 max-w-2xl">
                We’re here to help with CSSD products, sterilization, and infection control solutions.
            </p>
        </div>
    </section>

    <!-- Contact Information & Form Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h2>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-yellow-500 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Our Address</h3>
                                <p class="text-gray-600 mt-1">123 Healthcare Avenue, Medical District</p>
                                <p class="text-gray-600">New Delhi, 110001, India</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-yellow-500 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Phone</h3>
                                <p class="text-gray-600 mt-1">+91 11 2345 6789</p>
                                <p class="text-gray-600">+91 98765 43210</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-yellow-500 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Email</h3>
                                <p class="text-gray-600 mt-1">info@zegnen.com</p>
                                <p class="text-gray-600">support@zegnen.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Connect With Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-600 p-3 rounded-full text-white hover:bg-blue-700 transition-colors" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="bg-blue-400 p-3 rounded-full text-white hover:bg-blue-500 transition-colors" aria-label="Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            <a href="#" class="bg-red-600 p-3 rounded-full text-white hover:bg-red-700 transition-colors" aria-label="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21.593 7.203a2.506 2.506 0 00-1.762-1.766C18.265 5.007 12 5 12 5s-6.264-.007-7.831.44a2.56 2.56 0 00-1.766 1.778c-.44 1.61-.44 4.976-.44 4.976s0 3.366.44 4.976c.243.877.909 1.534 1.766 1.778 1.582.448 7.831.448 7.831.448s6.264 0 7.831-.448a2.51 2.51 0 001.767-1.778c.44-1.61.44-4.976.44-4.976s0-3.366-.44-4.976zM9.998 15.505V10.49l5.227 2.507-5.227 2.507z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors" placeholder="Your name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors" placeholder="your.email@example.com">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors" placeholder="How can we help you?">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors" placeholder="Your message here..."></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-300 transform hover:scale-105">Send Message</button>
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

<?php
// Output the footer
echo getFooter();
?>