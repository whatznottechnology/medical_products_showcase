<?php
require_once 'config/Database.php';
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/footer.php';

// Fetch banner from banners table
$db = Database::getInstance();
$banner = $db->fetchOne("SELECT * FROM banners WHERE page = 'about' AND status = 'active' LIMIT 1");
$bannerImage = !empty($banner['image_path']) ? $banner['image_path'] : '';
$bannerTitle = !empty($banner['title']) ? $banner['title'] : 'About ZEGNEN International Company';

// Output the header and navigation
echo getHeader(
    'About Us - ZEGNEN International Company | CSSD Solutions Provider',
    'Learn about ZEGNEN International Company - A global leader in CSSD products manufacturing. ISO 13485 certified, CE marked products. Delivering sterilization packaging, monitoring solutions, instrument care & infection control products to healthcare facilities worldwide.',
    'about ZEGNEN, CSSD manufacturer, sterilization company, medical device manufacturer, ISO 13485, CE certification, healthcare solutions, infection control company, sterilization packaging manufacturer, CSSD solutions provider',
    'about'
);
echo getNavigation();

?>

<main class="relative z-10 mt-16">
    <!-- Intro Parallax - Dynamic Banner -->
    <?php if (!empty($bannerImage)): ?>
    <section class="parallax hero-overlay flex items-center" style="min-height:60vh; background-image: url('<?php echo htmlspecialchars($bannerImage); ?>'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="max-w-6xl mx-auto px-6 lg:px-12 py-24 text-white">
            <h2 class="text-4xl lg:text-5xl font-semibold mb-4"><?php echo htmlspecialchars($bannerTitle); ?></h2>
            <p class="text-lg lg:text-xl max-w-3xl leading-relaxed">
                ZEGNEN INTERNATIONAL COMPANY is a global manufacturer and supplier of Central Sterile Supply Department (CSSD)
                products. We design and deliver sterilization packaging, monitoring solutions, instrument care, accessories,
                and personal protection equipment that meet international standards and help healthcare providers maintain
                the highest levels of patient safety and infection control.
            </p>
        </div>
    </section>
    <?php else: ?>
    <section class="flex items-center bg-gradient-to-r from-yellow-500 to-yellow-600" style="min-height:60vh;">
        <div class="max-w-6xl mx-auto px-6 lg:px-12 py-24 text-white">
            <h2 class="text-4xl lg:text-5xl font-semibold mb-4"><?php echo htmlspecialchars($bannerTitle); ?></h2>
            <p class="text-lg lg:text-xl max-w-3xl leading-relaxed">
                ZEGNEN INTERNATIONAL COMPANY is a global manufacturer and supplier of Central Sterile Supply Department (CSSD)
                products. We design and deliver sterilization packaging, monitoring solutions, instrument care, accessories,
                and personal protection equipment that meet international standards and help healthcare providers maintain
                the highest levels of patient safety and infection control.
            </p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Mission & Values -->
    <section class="bg-white py-16 px-6 lg:px-12">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="reveal">
                <h3 class="text-3xl font-semibold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-gray-700 leading-relaxed mb-6">To empower hospitals and laboratories with world-class CSSD
                    solutions that ensure infection prevention, operational efficiency, and patient safety through continuous
                    innovation and rigorous quality controls.</p>

                <h4 class="text-xl font-medium text-gray-900 mb-3">What guides us</h4>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Strict compliance to ISO, CE and EN standards</li>
                    <li>Design for durability, efficiency and ease of use</li>
                    <li>Local service, global quality</li>
                </ul>
            </div>

            <div class="reveal">
                <div class="rounded-lg overflow-hidden transform hover:scale-[1.02] transition-transform duration-500">
                    <img src="<?php echo $baseUrl; ?>assets/images/zicabout.png" alt="Modern CSSD facility"
                         class="w-full object-cover h-80">
                </div>
            </div>
        </div>
    </section>

    <!-- Product Range Parallax -->
    <section class="parallax parallax-2 hero-overlay flex items-center" style="min-height:50vh;">
        <div class="max-w-6xl mx-auto px-6 lg:px-12 py-20 text-white">
            <h3 class="text-3xl lg:text-4xl font-semibold mb-4">Our Product Range</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="feature-card p-6 rounded-lg reveal">
                    <h5 class="font-semibold mb-2">Sterilization Packaging</h5>
                    <p class="text-sm">Pouches, reels, wraps and indicator tapes engineered for secure sterilization.</p>
                </div>
                <div class="feature-card p-6 rounded-lg reveal">
                    <h5 class="font-semibold mb-2">Monitoring Products</h5>
                    <p class="text-sm">Biological & chemical indicators, integrators, and test packs for process validation.</p>
                </div>
                <div class="feature-card p-6 rounded-lg reveal">
                    <h5 class="font-semibold mb-2">Instrument Care</h5>
                    <p class="text-sm">Enzymatic detergents, brushes and lubricants to extend instrument life.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-gradient-to-b from-gray-50 to-white py-16 px-6 lg:px-12">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-3xl font-semibold text-gray-900 mb-8 text-center reveal">Why Choose ZEGNEN</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="reveal group">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-12 h-12 mb-4 rounded-full bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h5 class="font-semibold text-lg mb-3">Certified Quality</h5>
                            <p class="text-gray-600 leading-relaxed">Products designed and tested to ISO, CE and EN norms, ensuring the highest standards of safety and reliability.</p>
                        </div>
                    </div>
                </div>
                <div class="reveal group">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-12 h-12 mb-4 rounded-full bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                </svg>
                            </div>
                            <h5 class="font-semibold text-lg mb-3">Tailored Solutions</h5>
                            <p class="text-gray-600 leading-relaxed">Customizable options for hospitals, clinics and labs, designed to meet your specific CSSD requirements.</p>
                        </div>
                    </div>
                </div>
                <div class="reveal group">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500 transform -skew-x-12"></div>
                        <div class="relative">
                            <div class="w-12 h-12 mb-4 rounded-full bg-yellow-500/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h5 class="font-semibold text-lg mb-3">Reliable Support</h5>
                            <p class="text-gray-600 leading-relaxed">24/7 technical assistance, training programs, and on-time delivery to ensure optimal CSSD workflows.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 px-6 lg:px-12 bg-gradient-to-br from-yellow-500/10 to-transparent">
        <div class="max-w-6xl mx-auto text-center">
            <div class="bg-white rounded-2xl shadow-xl p-12 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600"></div>
                <h4 class="text-3xl font-semibold mb-4 reveal">Ready to improve your sterilization workflow?</h4>
                <p class="text-gray-600 text-lg mb-8 reveal">Contact our sales team to discuss solutions tailored to your facility.</p>
                <div class="reveal">
                    <a href="contact-us" class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-4 rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg group">
                        <span>Contact Sales</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Get proper asset paths
$isLocalhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
$baseUrl = $isLocalhost ? '/p/' : '/';
?>
<link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/about-page.css">
<script src="<?php echo $baseUrl; ?>assets/js/scroll-reveal.js"></script>

<?php
// Output the footer
echo getFooter();
?>