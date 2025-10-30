<?php
function getWhyChooseSection() {
    ob_start();
?>
<!-- What Makes Us Special Section -->
<section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-12 bg-yellow-500">
    <div class="max-w-6xl mx-auto">
        <!-- Section Header -->
        <div class="mb-10 sm:mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 sm:mb-4">
                Why Choose ZEGNEN?
            </h2>
            <p class="text-yellow-100 text-base sm:text-lg lg:text-xl max-w-2xl">
                Empowering healthcare institutions with world-class CSSD solutions that ensure infection prevention, operational efficiency, and patient safety.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            <!-- Feature 1: Expert Guidance -->
            <div class="group cursor-pointer">
                <div class="bg-white bg-opacity-90 rounded-2xl sm:rounded-3xl overflow-hidden transform transition-all duration-500 group-hover:scale-105 group-hover:shadow-2xl group-hover:bg-opacity-100">
                    <div class="aspect-[5/4] relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Medical Expert Consulting"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-yellow-400 opacity-0 transition-opacity duration-500 group-hover:opacity-20">
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 transition-colors duration-300 group-hover:text-yellow-600">
                            High-Quality Certified Products
                        </h3>
                        <p class="text-gray-600 text-sm sm:text-base leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                            Every product is designed and tested to meet international quality standards such as ISO, CE, and EN norms, ensuring maximum safety, efficiency, and compliance in sterilization processes.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Precision Manufacturing -->
            <div class="group cursor-pointer">
                <div class="bg-white bg-opacity-90 rounded-2xl sm:rounded-3xl overflow-hidden transform transition-all duration-500 group-hover:scale-105 group-hover:shadow-2xl group-hover:bg-opacity-100">
                    <div class="aspect-[5/4] relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1582719471384-894fbb16e074?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Manufacturing Facility"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-yellow-400 opacity-0 transition-opacity duration-500 group-hover:opacity-20">
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 transition-colors duration-300 group-hover:text-yellow-600">
                            In-Depth CSSD Understanding
                        </h3>
                        <p class="text-gray-600 text-sm sm:text-base leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                            With years of experience in healthcare and medical device industry, we offer tailored solutions for hospitals and labs with reliable customer support and training.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Infection Control -->
            <div class="group cursor-pointer sm:col-span-2 md:col-span-1">
                <div class="bg-white bg-opacity-90 rounded-2xl sm:rounded-3xl overflow-hidden transform transition-all duration-500 group-hover:scale-105 group-hover:shadow-2xl group-hover:bg-opacity-100">
                    <div class="aspect-[5/4] relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1530026405186-ed1f139313f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Clean Hospital Environment"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-yellow-400 opacity-0 transition-opacity duration-500 group-hover:opacity-20">
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 transition-colors duration-300 group-hover:text-yellow-600">
                            Sustainable & Eco-Friendly Focus
                        </h3>
                        <p class="text-gray-600 text-sm sm:text-base leading-relaxed transition-colors duration-300 group-hover:text-gray-800">
                            Our commitment to sustainability and eco-friendly solutions ensures that healthcare facilities can maintain sterile environments while minimizing environmental impact.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Link -->
        <div class="mt-6 sm:mt-8 text-center sm:text-left">
            <a href="#" class="text-white hover:text-yellow-100 font-medium text-base sm:text-lg underline transition-colors duration-300">
                See what makes us special
            </a>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}
?>