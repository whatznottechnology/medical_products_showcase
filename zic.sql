-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2025 at 09:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin@zegnen.com', '$2y$10$qO5rhwpJtHliBCIVEBdCcOtWkbi.GKz9IeL.d4b2d/ujMSllwgEJW', 'Administrator', '2025-10-31 01:44:34', '2025-10-31 01:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `page`, `title`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'home', 'title', 'uploads/banners/69043583244c8_1761883523.png', 'active', '2025-10-31 04:05:23', '2025-10-31 04:05:23'),
(2, 'our-products', 'product', 'uploads/banners/69043d888c7d6_1761885576.png', 'active', '2025-10-31 04:39:36', '2025-10-31 06:08:10'),
(4, 'why-zegnen', 'Why Choice Us ?', 'uploads/banners/690458ecb5f58_1761892588.png', 'active', '2025-10-31 04:40:33', '2025-10-31 06:36:28'),
(5, 'about', 'About Us', 'uploads/banners/69044c0d8062a_1761889293.png', 'active', '2025-10-31 05:41:33', '2025-10-31 05:42:47'),
(6, 'about', 'About Us', 'uploads/banners/69044c3dbee58_1761889341.png', 'active', '2025-10-31 05:42:21', '2025-10-31 05:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo_path`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Zegnen', 'uploads/brands//1761878679_69042297e8265.png', 0, 'active', '2025-10-31 02:44:39', '2025-10-31 02:44:39'),
(3, 'Whatznot', 'uploads/brands//1761882286_690430ae0aa85.png', 0, 'active', '2025-10-31 03:44:46', '2025-10-31 03:44:46'),
(4, 'subha craft', 'uploads/brands//1761882302_690430be7926b.png', 0, 'active', '2025-10-31 03:45:02', '2025-10-31 03:45:02'),
(5, 'Pulkart', 'uploads/brands//1761882348_690430ec2db6a.png', 0, 'active', '2025-10-31 03:45:48', '2025-10-31 03:45:48'),
(7, 'chabighar', 'uploads/brands//1761882729_69043269a4f86.png', 0, 'active', '2025-10-31 03:52:09', '2025-10-31 03:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `career_applications`
--

CREATE TABLE `career_applications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `resume_path` varchar(500) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `status` enum('new','reviewed','shortlisted','rejected','hired') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sterilization Equipment', 'sterilization-equipment', 'Autoclaves, sterilizers, and related equipment', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(2, 'CSSD Solutions', 'cssd-solutions', 'Central Sterile Supply Department solutions', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(3, 'Surgical Instruments', 'surgical-instruments', 'High-quality surgical tools and instruments', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(4, 'Diagnostic Equipment', 'diagnostic-equipment', 'Medical diagnostic devices', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(5, 'OT Equipment', 'ot-equipment', 'Operation Theatre equipment and supplies', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(6, 'Hospital Furniture', 'hospital-furniture', 'Hospital beds, tables, and furniture', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(7, 'Laboratory Equipment', 'laboratory-equipment', 'Lab instruments and equipment', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15'),
(8, 'Patient Monitoring', 'patient-monitoring', 'Vital signs monitors and patient monitoring systems', 'active', '2025-10-31 02:10:15', '2025-10-31 02:10:15');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` varchar(50) DEFAULT 'landscape',
  `alt_text` varchar(255) DEFAULT 'zegnen',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_path`, `image_type`, `alt_text`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(21, 'uploads/gallery//1761878650_6904227ac593a.png', 'square', 'zegnen', 0, 'active', '2025-10-31 02:44:10', '2025-10-31 02:44:10'),
(22, 'uploads/gallery//1761878650_6904227ac6b36.png', 'square', 'zegnen', 0, 'active', '2025-10-31 02:44:10', '2025-10-31 02:44:10'),
(23, 'uploads/gallery//1761878650_6904227ac8a21.jpeg', 'landscape', 'zegnen', 0, 'active', '2025-10-31 02:44:10', '2025-10-31 02:44:10'),
(24, 'uploads/gallery//1761878650_6904227ac90fe.jpeg', 'landscape', 'zegnen', 0, 'active', '2025-10-31 02:44:10', '2025-10-31 02:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `source_page` varchar(100) DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `source_page` varchar(100) DEFAULT 'popup',
  `source_url` varchar(500) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `status` enum('new','contacted','converted','not_interested') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popup`
--

CREATE TABLE `popup` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('enabled','disabled') DEFAULT 'enabled',
  `alt_text` varchar(255) DEFAULT 'zegnen',
  `is_enabled` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popup`
--

INSERT INTO `popup` (`id`, `image_path`, `status`, `alt_text`, `is_enabled`, `created_at`, `updated_at`) VALUES
(2, 'uploads/popup//1761878758_690422e61cd96.png', 'enabled', 'zegnen', 0, '2025-10-31 02:45:58', '2025-10-31 06:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `categories` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `details` longtext DEFAULT NULL,
  `price_min` decimal(10,2) DEFAULT NULL,
  `price_max` decimal(10,2) DEFAULT NULL,
  `price_unit` varchar(50) DEFAULT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `instructions_video` text DEFAULT NULL COMMENT 'YouTube video URL for usage instructions',
  `features` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `subtitle`, `category`, `categories`, `description`, `details`, `price_min`, `price_max`, `price_unit`, `badge`, `main_image`, `og_image`, `video_url`, `instructions`, `instructions_video`, `features`, `specifications`, `meta_title`, `meta_description`, `meta_keywords`, `tags`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bowie-Dick Test Pack', 'bowie-dick-test-pack', 'Steam Sterilizer Validation Tool', NULL, NULL, 'High-quality Bowie-Dick test pack for steam sterilizer validation', '<h3>Product Overview</h3><p>The Bowie-Dick Test Pack is an essential tool for validating the performance of pre-vacuum steam sterilizers. This test ensures proper air removal and steam penetration throughout the sterilization chamber.</p><h3>Key Benefits</h3><ul><li>Ensures sterilizer efficiency</li><li>Validates air removal performance</li><li>Easy to use and interpret</li><li>Complies with international standards</li></ul>', 45.00, 50.00, 'per pack', 'Featured', 'uploads/products//1762024499_69065c336b70a.png', NULL, 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Place test pack in empty sterilizer chamber\",\"Run standard Bowie-Dick test cycle at 134\\u00b0C for 3.5 minutes\",\"Remove and examine indicator sheet immediately\",\"Check for uniform color change across entire sheet\",\"Record results in sterilization log\"]', 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Chemical indicator sheet\",\"Pre-assembled test pack\",\"Single-use disposable\",\"Clear pass\\/fail indication\",\"ISO 11140-1 compliant\"]', '{\"1\":\"Exposure Time: 3.5 minutes\",\"2\":\"Pack Size: 25cm x 30cm\",\"3\":\"Shelf Life: 24 months\",\"4\":\"Storage: Cool, dry place\"}', '', '', '', NULL, 'active', '2025-10-31 02:39:28', '2025-11-01 19:14:59'),
(2, 'Type 6 Emulating Indicator', 'type-6-emulating-indicator', 'Multi-Parameter Chemical Indicator', NULL, NULL, 'Advanced multi-parameter chemical indicator for sterilization monitoring', '<h3>Advanced Sterilization Monitoring</h3><p>Type 6 Emulating Indicators provide comprehensive monitoring of critical sterilization parameters including time, temperature, and steam quality.</p><h3>Technical Details</h3><p>These indicators respond to all critical parameters and are designed to react at stated values of the chosen variables. They provide a precise indication of sterilization process effectiveness.</p>', 85.00, 95.00, 'per box', 'Best Seller', 'uploads/products//1761878543_6904220f4fa2d.png', NULL, 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Place indicator inside sterilization load\",\"Ensure indicator is visible after sterilization\",\"Run sterilization cycle as per protocol\",\"Check color change from pink to brown\",\"Verify complete color transition before accepting load\"]', 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Emulates biological indicators\",\"Multi-parameter monitoring\",\"Rapid color change response\",\"Self-adhesive backing\",\"Lot-specific performance data\"]', '{\"1\":\"Sterilization Method: Steam\",\"2\":\"Response Time: Process dependent\",\"3\":\"Dimensions: 50mm x 10mm\",\"4\":\"Packaging: 250 strips per box\"}', '', '', '', NULL, 'active', '2025-10-31 02:39:28', '2025-10-31 05:05:55'),
(3, 'ZIC Autoclave Tape', 'zic-autoclave-tape', 'Steam Sterilization Indicator Tape', NULL, NULL, 'Steam sterilization indicator tape for secure package sealing', '<h3>Professional Grade Indicator Tape</h3><p>ZIC Autoclave Tape serves dual purposes: securing sterilization packages and providing immediate visual confirmation of steam exposure.</p><h3>Superior Performance</h3><p>Our autoclave tape features strong adhesive properties that maintain seal integrity throughout the sterilization process while providing clear, unmistakable color change indicators.</p>', 12.00, 15.00, 'per roll', '', 'uploads/products//1761878572_6904222c7b948.png', NULL, 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Seal sterilization pouches or wraps with tape\",\"Ensure tape adheres completely to package\",\"Place packaged items in sterilizer\",\"After sterilization, check for diagonal stripe appearance\",\"Do not use packages if tape shows no color change\"]', 'https://www.youtube.com/watch?v=GVxj46J_KKM', '[\"Lead-free chemical indicator\",\"Strong adhesive for reliable sealing\",\"Clear color change verification\",\"Resistant to moisture and heat\",\"Easy to tear and apply\"]', '{\"1\":\"Length: 50 meters per roll\",\"2\":\"Indicator Type: Class 1\",\"3\":\"Adhesive: Pressure-sensitive\",\"4\":\"Color Change: Beige to Brown with stripes\"}', '', '', '', NULL, 'active', '2025-10-31 02:39:28', '2025-10-31 05:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` enum('parallax','gallery') DEFAULT 'parallax',
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `image_type`, `display_order`, `created_at`) VALUES
(2, 2, 'uploads/products/parallax/1761878543_6904220f50d35.png', 'parallax', 0, '2025-10-31 02:42:23'),
(3, 3, 'uploads/products/parallax/1761878572_6904222c7cb6f.png', 'parallax', 0, '2025-10-31 02:42:52'),
(4, 1, 'uploads/products/parallax/1761880717_69042a8d618af.png', 'parallax', 1, '2025-10-31 03:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_role` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `display_location` enum('homepage','product','both') DEFAULT 'homepage',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_name`, `customer_role`, `rating`, `comment`, `product_id`, `display_location`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Sarah Johnson', 'Head of Sterilization, City Hospital', 5, 'ZEGNEN products have significantly improved our sterilization quality control. The indicators are reliable and easy to use.', 1, 'both', 'active', '2025-10-31 02:39:28', '2025-10-31 04:37:48'),
(2, 'Michael Chen', 'CSSD Manager, Medical Center', 5, 'Excellent quality products with consistent performance. Their Bowie-Dick tests have never failed us.', 2, 'both', 'active', '2025-10-31 02:39:28', '2025-10-31 03:58:56'),
(3, 'Dr. Priya Patel', 'Infection Control Officer', 5, 'Professional grade sterilization monitoring solutions. Highly recommended for healthcare facilities.', 3, 'both', 'active', '2025-10-31 02:39:28', '2025-10-31 03:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'ZEGNEN International', 'text', '2025-10-31 01:44:34', '2025-10-31 02:36:56'),
(2, 'call_number', '+91 89020 56626', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(3, 'whatsapp_number', '918902056626', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(4, 'email', 'info@zegnen.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(5, 'banner_image', 'uploads/settings//1761880409_69042959a45b9.png', 'image', '2025-10-31 01:44:34', '2025-10-31 03:13:29'),
(6, 'facebook_url', 'https://facebook.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(7, 'instagram_url', 'https://instagram.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(8, 'youtube_url', 'https://youtube.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(9, 'linkedin_url', 'https://linkedIn.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(10, 'twitter_url', 'https://x.com', 'text', '2025-10-31 01:44:34', '2025-11-01 19:16:07'),
(11, 'site_email', 'info@zegnen.com', 'text', '2025-10-31 02:36:56', '2025-10-31 02:36:56'),
(12, 'site_phone', '+1-234-567-8900', 'text', '2025-10-31 02:36:56', '2025-10-31 02:36:56'),
(13, 'site_address', '123 Medical Plaza, Healthcare District, City 12345', 'text', '2025-10-31 02:36:56', '2025-10-31 02:36:56'),
(14, 'footer_text', '© 2025 ZEGNEN International. All rights reserved. Professional CSSD Solutions.', 'text', '2025-10-31 02:36:56', '2025-10-31 02:36:56'),
(15, 'products_banner_image', '', 'file', '2025-10-31 03:09:36', '2025-10-31 03:09:36'),
(16, 'why_zegnen_banner_image', '', 'file', '2025-10-31 03:09:36', '2025-10-31 03:09:36'),
(17, 'about_banner_image', '', 'file', '2025-10-31 03:09:36', '2025-10-31 03:09:36'),
(18, 'hero_title_line1', 'Healthcare Excellence,', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(19, 'hero_title_line2', 'Hello ZEGNEN.', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(20, 'hero_subtitle_line1', 'ZEGNEN INTERNATIONAL COMPANY - Leading manufacturer of CSSD products', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(21, 'hero_subtitle_line2', 'for sterilization & infection control, ensuring safety and compliance worldwide.', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(22, 'hero_search_placeholder', 'Search Sterilization Products', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(23, 'hero_badge_text', 'ISO Certified Quality & International Standards!', 'text', '2025-10-31 03:30:34', '2025-10-31 03:30:34'),
(24, 'hero_banner_image', 'uploads/settings//1761882752_6904328086c7e.png', 'file', '2025-10-31 03:45:18', '2025-10-31 03:52:32'),
(25, 'phone_number', '+91 89020 56626', 'text', '2025-10-31 07:33:07', '2025-10-31 07:33:07'),
(26, 'address', 'Healthcare Avenue, Medical District, New Delhi, 110001, India', 'text', '2025-10-31 07:33:07', '2025-10-31 07:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'phone_primary', '+91 8763514999', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(2, 'phone_secondary', '+91 89020 56626', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(3, 'email_primary', 'sales@zegnen.com', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(4, 'email_secondary', 'info@zegnen.com', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(5, 'whatsapp_number', '+918763514999', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(6, 'address', 'Kolkata, West Bengal, India', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(7, 'facebook_url', 'https://facebook.com/zegnen', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(8, 'twitter_url', 'https://twitter.com/zegnen', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(9, 'linkedin_url', 'https://linkedin.com/company/zegnen', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(10, 'instagram_url', 'https://instagram.com/zegnen', '2025-10-31 05:45:08', '2025-10-31 05:45:08'),
(11, 'youtube_url', 'https://youtube.com/@zegnen', '2025-10-31 05:45:08', '2025-10-31 05:45:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_page` (`page`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_applications`
--
ALTER TABLE `career_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `popup`
--
ALTER TABLE `popup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_slug` (`slug`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `career_applications`
--
ALTER TABLE `career_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `popup`
--
ALTER TABLE `popup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
