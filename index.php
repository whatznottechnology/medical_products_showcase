<?php
require_once 'components/header.php';
require_once 'components/navigation.php';
require_once 'components/hero.php';
require_once 'components/cssd-solutions.php';
require_once 'components/products-showcase.php';
require_once 'components/why-choose-section.php';
require_once 'components/masonry-gallery.php';
require_once 'components/brand-partners.php';
require_once 'components/business-solutions.php';
require_once 'components/reviews.php';
require_once 'components/popup.php';
require_once 'components/footer.php';

// Output the header (includes opening html and body tags)
echo getHeader(
    "ZEGNEN - Leading CSSD Products Manufacturer | Sterilization & Infection Control",
    "ZEGNEN International Company - Leading manufacturer of CSSD products for sterilization & infection control. ISO certified medical devices, autoclave tape, bowie dick test, and sterilization indicators for healthcare facilities worldwide.",
    "CSSD products, sterilization, infection control, healthcare, medical devices, autoclave tape, bowie dick test, sterilization indicators, chemical indicators, biological indicators, medical sterilization, hospital hygiene, ISO 13485, CE marked products"
);

// Output the navigation
echo getNavigation();

// Output the hero section
echo getHeroSection();

// Output the CSSD Solutions section
echo getCssdSolutionsSection();

// Output the Products Showcase section
echo getProductsShowcase();

// Output the Why Choose section
echo getWhyChooseSection();

// Output the Masonry Gallery
echo getMasonryGallery();

// Output the Brand Partners section
echo getBrandPartnersSection();

// Output the Business Solutions section
echo getBusinessSolutionsSection();

// Output the reviews section
echo getReviewsSection();

// Output the popup
echo getLeadPopup();

// Output the footer (includes closing body and html tags)
echo getFooter();
?>

<script src="assets/js/hero-search.js"></script>
<script src="assets/js/product-slider.js"></script>
<script src="assets/js/popup.js"></script>