<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Output the header and navigation
echo getHeader('Careers - ZEGNEN CSSD Solutions');
echo getNavigation();
?>

<main class="relative min-h-screen mt-20">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-yellow-500 to-yellow-600">
        <div class="container mx-auto px-6 lg:px-12 py-12 sm:py-16">
            <div class="max-w-4xl">
                <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">Join Our Team</h1>
                <p class="text-lg text-white/90 mb-6">
                    Be part of a healthcare revolution. We're looking for passionate professionals
                    who share our commitment to excellence in sterilization and infection control.
                </p>
                <div class="flex items-center text-white">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">Currently hiring for multiple positions</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Us Section -->
    <section class="bg-white py-12 sm:py-16">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Why Join ZEGNEN?</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    We're more than just a company - we're innovators in healthcare safety,
                    committed to making a difference in medical sterilization worldwide.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Innovation</h3>
                    <p class="text-gray-600">Work on cutting-edge sterilization technologies that save lives every day.</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Team Spirit</h3>
                    <p class="text-gray-600">Join a collaborative environment where your ideas matter and growth is encouraged.</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Quality Focus</h3>
                    <p class="text-gray-600">Contribute to products that meet international standards and save countless lives.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form Section -->
    <section class="bg-gray-50 py-12 sm:py-16">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Apply Now</h2>
                        <p class="text-gray-600">
                            Fill out the form below and we'll get back to you with exciting opportunities.
                        </p>
                    </div>

                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- Position Applied For -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position Applied For *</label>
                            <select id="position" name="position" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                                <option value="">Select a position</option>
                                <option value="quality-control">Quality Control Specialist</option>
                                <option value="sales-representative">Sales Representative</option>
                                <option value="technical-support">Technical Support Engineer</option>
                                <option value="marketing-specialist">Marketing Specialist</option>
                                <option value="research-development">R&D Scientist</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                            <select id="experience" name="experience"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors">
                                <option value="">Select experience level</option>
                                <option value="entry">Entry Level (0-2 years)</option>
                                <option value="mid">Mid Level (3-5 years)</option>
                                <option value="senior">Senior Level (6-10 years)</option>
                                <option value="expert">Expert Level (10+ years)</option>
                            </select>
                        </div>

                        <!-- Resume Upload -->
                        <div>
                            <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">Resume/CV *</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-yellow-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-yellow-600 hover:text-yellow-500 focus-within:outline-none">
                                            <span>Upload your resume</span>
                                            <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" required class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        <div>
                            <label for="coverLetter" class="block text-sm font-medium text-gray-700 mb-2">Cover Letter (Optional)</label>
                            <textarea id="coverLetter" name="coverLetter" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors"
                                      placeholder="Tell us why you're interested in joining ZEGNEN..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Submit Application
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-500">
                        <p>By submitting this form, you agree to our <a href="privacy-policy" class="text-yellow-600 hover:text-yellow-700">Privacy Policy</a> and <a href="terms-and-conditions" class="text-yellow-600 hover:text-yellow-700">Terms & Conditions</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo getFooter(); ?>
