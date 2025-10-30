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
require_once 'components/footer.php';

// Output the header (includes opening html and body tags)
echo getHeader();

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

// Output the footer (includes closing body and html tags)
echo getFooter();
?>

<script src="assets/js/hero-search.js"></script>
<script src="assets/js/product-slider.js"></script>