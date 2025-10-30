<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Output the header and navigation
echo getHeader('Why Choose ZEGNEN - Leading CSSD Solutions Provider');
echo getNavigation();
?>

<main class="relative">
    <!-- Hero Section with Forest Background -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-[url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8 mt-20 sm:mt-24 lg:mt-32">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-4 sm:mb-6 lg:mb-8 transform transition-all duration-700 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                Why Choose ZEGNEN?
            </h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto mb-8 sm:mb-10 lg:mb-12 transform transition-all duration-700 delay-300 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                Setting the standard in CSSD excellence through innovation,
                quality, and unwavering commitment to patient safety
            </p>
            <div class="transform transition-all duration-700 delay-500 translate-y-20 opacity-0" data-scroll="fadeUp">
                <a href="#explore" class="inline-flex items-center space-x-2 sm:space-x-3 text-sm sm:text-base lg:text-lg group border-2 border-white rounded-full px-6 sm:px-8 py-2.5 sm:py-3 hover:bg-white hover:text-gray-900 transition-all duration-300" style="font-family: 'Inter', sans-serif;">
                    <span>Explore Our Excellence</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Quality Standards Section -->
    <section id="explore" class="relative py-12 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center space-y-8 lg:space-y-0">
                <div class="relative" data-scroll-section>
                    <div class="aspect-w-16 aspect-h-9 rounded-2xl overflow-hidden shadow-2xl transform transition-all duration-700 translate-x-0 lg:translate-x-[-100px] opacity-0" data-scroll="slideRight">
                        <img src="https://images.unsplash.com/photo-1583912086096-8c60d75a53f9?auto=format&fit=crop&w=1600&q=80" 
                             alt="CSSD Quality Standards" class="object-cover w-full h-64 sm:h-80 lg:h-96">
                    </div>
                </div>
                <div class="mt-8 lg:mt-0" data-scroll-section>
                    <div class="text-base max-w-prose mx-auto lg:max-w-none">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-6 sm:mb-8 transform transition-all duration-700 translate-x-0 lg:translate-x-[100px] opacity-0" data-scroll="slideLeft" style="font-family: 'Inter', sans-serif;">
                            Uncompromising Quality Standards
                        </h2>
                        <div class="space-y-4 sm:space-y-6 transform transition-all duration-700 delay-300 translate-x-0 lg:translate-x-[100px] opacity-0" data-scroll="slideLeft" style="font-family: 'Inter', sans-serif;">
                            <p class="text-base sm:text-lg text-gray-600">Every ZEGNEN product undergoes rigorous testing and validation to ensure compliance with international standards:</p>
                            <ul class="space-y-3 sm:space-y-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="ml-3 text-sm sm:text-base">ISO 13485:2016 Medical Devices Quality Management</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="ml-3 text-sm sm:text-base">CE Marking for European Compliance</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="ml-3 text-sm sm:text-base">EN ISO 11607 Sterilization Packaging Standards</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovation Timeline -->
    <section class="relative py-12 sm:py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center mb-8 sm:mb-12 lg:mb-16 transform transition-all duration-700 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                Our Journey of Innovation
            </h2>
            <div class="relative">
                <!-- Timeline Line - Hidden on mobile -->
                <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-yellow-500"></div>
                
                <!-- Timeline Items -->
                <div class="space-y-12 sm:space-y-16 lg:space-y-24">
                    <!-- Item 1 -->
                    <div class="relative" data-scroll-section>
                        <div class="hidden lg:flex items-center justify-center mb-8">
                            <div class="w-4 h-4 rounded-full bg-yellow-500 shadow-lg"></div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-16 items-center">
                            <div class="order-2 lg:order-1 transform transition-all duration-700 translate-x-0 lg:translate-x-[-100px] opacity-0" data-scroll="slideRight">
                                <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4" style="font-family: 'Inter', sans-serif;">Advanced Sterilization Monitoring</h3>
                                <p class="text-sm sm:text-base text-gray-600" style="font-family: 'Inter', sans-serif;">Pioneering digital integration in sterilization monitoring systems, ensuring real-time tracking and validation of every cycle.</p>
                            </div>
                            <div class="order-1 lg:order-2 transform transition-all duration-700 translate-x-0 lg:translate-x-[100px] opacity-0" data-scroll="slideLeft">
                                <div class="rounded-xl overflow-hidden shadow-lg">
                                    <img src="https://images.unsplash.com/photo-1581093458791-8a1462c5af0c?auto=format&fit=crop&w=1600&q=80" 
                                         alt="Sterilization Innovation" class="w-full h-48 sm:h-56 lg:h-64 object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="relative" data-scroll-section>
                        <div class="hidden lg:flex items-center justify-center mb-8">
                            <div class="w-4 h-4 rounded-full bg-yellow-500 shadow-lg"></div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-16 items-center">
                            <div class="order-1 transform transition-all duration-700 translate-x-0 lg:translate-x-[-100px] opacity-0" data-scroll="slideRight">
                                <div class="rounded-xl overflow-hidden shadow-lg">
                                    <img src="https://images.unsplash.com/photo-1579154204845-5d37f57827b3?auto=format&fit=crop&w=1600&q=80" 
                                         alt="Eco-friendly Solutions" class="w-full h-48 sm:h-56 lg:h-64 object-cover">
                                </div>
                            </div>
                            <div class="order-2 transform transition-all duration-700 translate-x-0 lg:translate-x-[100px] opacity-0" data-scroll="slideLeft">
                                <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4" style="font-family: 'Inter', sans-serif;">Eco-friendly CSSD Solutions</h3>
                                <p class="text-sm sm:text-base text-gray-600" style="font-family: 'Inter', sans-serif;">Developing sustainable sterilization practices with reduced environmental impact while maintaining the highest safety standards.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="relative py-12 sm:py-16 lg:py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center mb-8 sm:mb-12 lg:mb-16 transform transition-all duration-700 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                What Sets Us Apart
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" data-scroll-section>
                <!-- Feature 1 -->
                <div class="group" data-scroll="fadeIn">
                    <div class="relative p-6 sm:p-8 bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 mb-3 sm:mb-4 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3" style="font-family: 'Inter', sans-serif;">Rapid Response</h3>
                            <p class="text-sm sm:text-base text-gray-600" style="font-family: 'Inter', sans-serif;">24/7 technical support and fastest industry response times for critical CSSD operations.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group" data-scroll="fadeIn">
                    <div class="relative p-6 sm:p-8 bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 mb-3 sm:mb-4 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3" style="font-family: 'Inter', sans-serif;">Expert Training</h3>
                            <p class="text-sm sm:text-base text-gray-600" style="font-family: 'Inter', sans-serif;">Comprehensive CSSD staff training programs and continuous education support.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group" data-scroll="fadeIn">
                    <div class="relative p-6 sm:p-8 bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 mb-3 sm:mb-4 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3" style="font-family: 'Inter', sans-serif;">Safety Guaranteed</h3>
                            <p class="text-sm sm:text-base text-gray-600" style="font-family: 'Inter', sans-serif;">Triple-validation process ensuring 100% compliance with safety standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="relative py-12 sm:py-16 lg:py-24 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=2070&q=80" 
                 alt="CSSD Background" class="w-full h-full object-cover opacity-10">
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6 lg:mb-8 transform transition-all duration-700 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                Ready to Elevate Your CSSD Standards?
            </h2>
            <p class="text-base sm:text-lg lg:text-xl mb-8 sm:mb-10 lg:mb-12 max-w-2xl mx-auto transform transition-all duration-700 delay-300 translate-y-20 opacity-0" data-scroll="fadeUp" style="font-family: 'Inter', sans-serif;">
                Join leading healthcare institutions that trust ZEGNEN for their critical sterilization needs.
            </p>
            <div class="transform transition-all duration-700 delay-500 translate-y-20 opacity-0" data-scroll="fadeUp">
                <a href="mailto:info@zegnen.com" class="inline-flex items-center bg-yellow-500 text-gray-900 px-6 sm:px-8 py-3 sm:py-4 rounded-xl text-sm sm:text-base font-medium transition-all duration-300 hover:bg-yellow-600 hover:scale-105" style="font-family: 'Inter', sans-serif;">
                    <span>Schedule a Consultation</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</main>

<link rel="stylesheet" href="assets/css/scroll-animations.css">
<script src="assets/js/scroll-animations.js"></script>

<?php
// Output the footer
echo getFooter();
?>