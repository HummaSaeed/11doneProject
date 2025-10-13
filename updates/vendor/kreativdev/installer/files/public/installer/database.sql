-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2024 at 01:29 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookapp_installable`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_section_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `language_id`, `title`, `subtitle`, `text`, `button_text`, `button_url`, `about_section_image`, `features_title`, `created_at`, `updated_at`) VALUES
(8, 20, 'Why choose us?', 'Trusted, Convenient, and Secure Service Booking.', '<p>&nbsp;Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum aspernatur minus exercitationem vero, repudiandae ducimus ut beatae, sit, dolor laudantium culpa ullam itaque consequatur incidunt distinctio deserunt expedita quae sequi iure. Ipsam pariatur corporis ullam, quos est.</p>\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum aspernatur minus exercitationem vero, repudiandae ducimus ut beatae, sit, dolor laudantium culpa ullam itaque consequatur incidunt distinctio deserunt expedita quae sequi iure. Ipsam pariatur corporis ullam, quos est.&nbsp;</p>', 'Explore Now', 'https://example.com/', '66e149ff4c9fc.png', 'Our Top Features', NULL, '2024-09-11 03:47:54'),
(9, 21, 'لماذا تختارنا؟', 'ابحث عن أي شيء من أقرب موقع لإجراء الحجز', '<p>الشركة نفسها هي شركة ناجحة جدا. إن ممارسة هؤلاء أقل قسوة، ولكننا ندينهم بالإنكار ليتباركوا. إنه نفس الجسد مثل أي واحد منهم.</p>\r\n<p>الشركة نفسها هي شركة ناجحة جدا. إن ممارسة هؤلاء أقل قسوة، ولكننا ندينهم بالإنكار ليتباركوا. إنه نفس الجسد مثل أي واحد منهم.</p>', 'استكشف الآن', 'https://example.com/', '66e14a07216f8.png', 'أهم مميزاتنا', '2024-03-14 01:15:10', '2024-09-11 03:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `first_name`, `last_name`, `image`, `username`, `email`, `password`, `address`, `details`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Leonard', 'Bourne', '66d2fa86e75bb.png', 'admin', NULL, '$2y$10$7rcuMv8LG9adF09JnRjt.O35YL/3dkFWA7EBhBT.LOZvS07OaeDFm', 'House no 32, Road 3, sector 11, Uttara, Dhaka, Bangladesh', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae blanditiis minus tempora quibusdam quas quo magni, repellat sit? Adipisci accusantium quasi autem tempora nemo aspernatur tenetur repellat numquam sed cupiditate.', 1, NULL, '2024-08-31 05:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `admin_global_days`
--

CREATE TABLE `admin_global_days` (
  `id` bigint UNSIGNED NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_weekend` tinyint NOT NULL,
  `indx` int NOT NULL,
  `vendor_id` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_global_days`
--

INSERT INTO `admin_global_days` (`id`, `day`, `is_weekend`, `indx`, `vendor_id`, `created_at`, `updated_at`) VALUES
(1, 'Sunday', 1, 0, 0, '2024-03-02 09:31:59', '2024-08-26 22:23:28'),
(2, 'Monday', 0, 1, 0, NULL, '2024-03-08 21:35:29'),
(3, 'Tuesday', 0, 2, 0, NULL, '2024-08-26 22:34:37'),
(4, 'Wednesday', 0, 3, 0, NULL, NULL),
(5, 'Thursday', 0, 4, 0, NULL, NULL),
(6, 'Friday', 0, 5, 0, NULL, '2024-08-26 22:34:15'),
(7, 'Saturday', 0, 6, 0, NULL, '2024-08-26 22:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint UNSIGNED NOT NULL,
  `ad_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `resolution_type` smallint UNSIGNED NOT NULL COMMENT '1 => 300 x 250, 2 => 300 x 600, 3 => 728 x 90',
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `slot` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `ad_type`, `resolution_type`, `image`, `url`, `slot`, `views`, `created_at`, `updated_at`) VALUES
(14, 'banner', 2, '66cee90408478.png', 'http://example.com', NULL, 0, '2024-08-28 03:08:20', '2024-08-28 03:08:20'),
(15, 'banner', 2, '66cee953df90c.jpg', 'http://example.com', NULL, 0, '2024-08-28 03:09:39', '2024-08-28 03:09:39'),
(16, 'banner', 3, '66cee976d1631.png', 'http://example.com', NULL, 0, '2024-08-28 03:10:14', '2024-08-28 03:10:14'),
(17, 'banner', 3, '66cee983e4ae6.png', 'http://example.com', NULL, 2, '2024-08-28 03:10:27', '2024-09-02 13:53:40'),
(18, 'banner', 1, '66cee996dc831.png', 'http://example.com', NULL, 0, '2024-08-28 03:10:46', '2024-08-28 03:10:46'),
(19, 'banner', 1, '66cee9a25332f.png', 'http://example.com', NULL, 0, '2024-08-28 03:10:58', '2024-08-28 03:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `serial_number` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `language_id`, `image`, `url`, `title`, `serial_number`, `created_at`, `updated_at`) VALUES
(18, '20', '66cee7901cab7.png', 'https://example.com/', 'Are You Looking For a Plumber ?', 1, '2024-08-28 03:02:08', '2024-09-04 00:09:45'),
(19, '21', '66cee7d195476.png', 'https://example.com/', 'هل تبحث عن سباك؟', 1, '2024-08-28 03:03:13', '2024-09-04 00:09:56'),
(20, '20', '66cee88aa0682.png', 'https://example.com/', 'Are You Looking For a Doctor?', 2, '2024-08-28 03:06:18', '2024-09-04 00:09:40'),
(21, '21', '66cee8a2be915.png', 'https://example.com/', 'هل تبحث عن طبيب؟', 2, '2024-08-28 03:06:42', '2024-09-04 00:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE `basic_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `uniqid` int UNSIGNED NOT NULL DEFAULT '12345',
  `favicon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo_two` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `website_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `theme_version` smallint UNSIGNED NOT NULL,
  `base_currency_symbol` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `base_currency_symbol_position` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `base_currency_text` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `base_currency_text_position` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `base_currency_rate` decimal(8,2) DEFAULT NULL,
  `primary_color` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_status` tinyint DEFAULT NULL,
  `smtp_host` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_port` int DEFAULT NULL,
  `encryption` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `from_mail` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `to_mail` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `breadcrumb` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `disqus_status` tinyint UNSIGNED DEFAULT NULL,
  `disqus_short_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `google_recaptcha_status` tinyint DEFAULT NULL,
  `google_recaptcha_site_key` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `whatsapp_status` tinyint UNSIGNED DEFAULT NULL,
  `whatsapp_number` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `whatsapp_header_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `whatsapp_popup_status` tinyint UNSIGNED DEFAULT NULL,
  `whatsapp_popup_message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `maintenance_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `maintenance_status` tinyint DEFAULT NULL,
  `maintenance_msg` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `bypass_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `footer_background_image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `admin_theme_version` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'light',
  `google_adsense_publisher_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `equipment_tax_amount` decimal(5,2) UNSIGNED DEFAULT NULL,
  `product_tax_amount` decimal(5,2) UNSIGNED DEFAULT NULL,
  `self_pickup_status` tinyint UNSIGNED DEFAULT NULL,
  `two_way_delivery_status` tinyint UNSIGNED DEFAULT NULL,
  `guest_checkout_status` tinyint UNSIGNED NOT NULL,
  `shop_status` int DEFAULT '1',
  `facebook_login_status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 -> enable, 0 -> disable',
  `facebook_app_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `facebook_app_secret` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `google_login_status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 -> enable, 0 -> disable',
  `google_client_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `google_client_secret` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tawkto_status` tinyint UNSIGNED NOT NULL COMMENT '1 -> enable, 0 -> disable',
  `tawkto_direct_chat_link` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vendor_admin_approval` int NOT NULL DEFAULT '0' COMMENT '1 active, 2 deactive',
  `vendor_email_verification` int NOT NULL DEFAULT '0' COMMENT '1 active, 2 deactive',
  `admin_approval_notice` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `expiration_reminder` int DEFAULT '3',
  `timezone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `time_format` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '12',
  `hero_section_video_url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `contact_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `contact_subtile` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `contact_details` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `latitude` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zoom_account_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zoom_client_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zoom_client_secret` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `google_calendar` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `calender_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `preloader_status` int DEFAULT '1',
  `preloader` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `admin_profit` decimal(16,2) DEFAULT '0.00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`id`, `uniqid`, `favicon`, `logo`, `logo_two`, `website_title`, `email_address`, `contact_number`, `address`, `theme_version`, `base_currency_symbol`, `base_currency_symbol_position`, `base_currency_text`, `base_currency_text_position`, `base_currency_rate`, `primary_color`, `secondary_color`, `smtp_status`, `smtp_host`, `smtp_port`, `encryption`, `smtp_username`, `smtp_password`, `from_mail`, `from_name`, `to_mail`, `breadcrumb`, `disqus_status`, `disqus_short_name`, `google_recaptcha_status`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `whatsapp_status`, `whatsapp_number`, `whatsapp_header_title`, `whatsapp_popup_status`, `whatsapp_popup_message`, `maintenance_img`, `maintenance_status`, `maintenance_msg`, `bypass_token`, `footer_logo`, `footer_background_image`, `admin_theme_version`, `google_adsense_publisher_id`, `equipment_tax_amount`, `product_tax_amount`, `self_pickup_status`, `two_way_delivery_status`, `guest_checkout_status`, `shop_status`, `facebook_login_status`, `facebook_app_id`, `facebook_app_secret`, `google_login_status`, `google_client_id`, `google_client_secret`, `tawkto_status`, `tawkto_direct_chat_link`, `vendor_admin_approval`, `vendor_email_verification`, `admin_approval_notice`, `expiration_reminder`, `timezone`, `time_format`, `hero_section_video_url`, `contact_title`, `contact_subtile`, `contact_details`, `latitude`, `longitude`, `zoom_account_id`, `zoom_client_id`, `zoom_client_secret`, `google_calendar`, `calender_id`, `preloader_status`, `preloader`, `admin_profit`, `updated_at`) VALUES
(2, 12345, '66c5b482acc73.png', '66c5b482ab59f.png', '64ed7071b1844.png', 'Bookapp', 'bookapp@example.com', '+701 - 1111 - 2222 - 3333', '450 Young Road, New York, USA', 1, '$', 'left', 'INR', 'right', 80.00, 'FF0037', 'FF4870', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Bookapp', NULL, '66d7d6c8f348a.png', 0, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '664d8c21dcf58.png', 0, 'We are upgrading our site. We will come back soon. \r\nPlease stay with us.\r\nThank you.', '-1', '66d7d7c6ee07b.png', '638db9bf3f92a.jpg', 'dark', NULL, 5.00, 5.00, 1, 1, 0, 1, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 1, 1, 'Your account is deactive or pending now please contact with admin.', 3, 'Asia/Dhaka', '24', 'https://www.youtube.com/watch?v=9l6RywtDlKA', 'Get Connected', 'How Can We Help You?', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.', '23.87', '90.3925747', NULL, NULL, NULL, NULL, NULL, 1, '665d847dd0147.gif', 17007.25, '2024-08-20 05:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `serial_number` mediumint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `image`, `serial_number`, `created_at`, `updated_at`) VALUES
(27, '66cdbe1dd05dd.png', 1, '2024-08-27 05:53:01', '2024-08-27 05:53:01'),
(28, '66cdc0b22b8b4.png', 2, '2024-08-27 06:04:02', '2024-08-27 06:04:02'),
(29, '66cdc1bf97d3c.png', 3, '2024-08-27 06:08:31', '2024-08-27 06:08:31'),
(30, '66cdc26a608f3.png', 4, '2024-08-27 06:11:22', '2024-08-27 06:11:22'),
(31, '66cdc34246fa3.png', 5, '2024-08-27 06:14:58', '2024-08-27 06:14:58'),
(32, '66cdc3c8a52b4.png', 6, '2024-08-27 06:17:12', '2024-08-27 06:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `serial_number` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `language_id`, `name`, `slug`, `status`, `serial_number`, `created_at`, `updated_at`) VALUES
(51, 20, 'Health & Wellness', 'health-&-wellness', 1, 1, '2024-08-27 05:46:14', '2024-08-27 05:46:14'),
(52, 20, 'Education & Learning', 'education-&-learning', 1, 2, '2024-08-27 05:46:30', '2024-08-27 05:46:30'),
(53, 20, 'Technology & Tools', 'technology-&-tools', 1, 3, '2024-08-27 05:46:46', '2024-08-27 05:46:46'),
(54, 20, 'Career Tips & Advice', 'career-tips-&-advice', 1, 4, '2024-08-27 05:47:03', '2024-08-27 06:23:02'),
(55, 21, 'الصحة والعافية', 'الصحة-والعافية', 1, 1, '2024-08-27 05:47:24', '2024-08-27 05:47:24'),
(56, 21, 'التعليم والتعلم', 'التعليم-والتعلم', 1, 2, '2024-08-27 05:47:45', '2024-08-27 05:47:45'),
(57, 21, 'التكنولوجيا والأدوات', 'التكنولوجيا-والأدوات', 1, 3, '2024-08-27 05:47:58', '2024-08-27 05:47:58'),
(58, 21, 'نصائح وإرشادات مهنية', 'نصائح-وإرشادات-مهنية', 1, 4, '2024-08-27 05:48:12', '2024-08-27 05:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `blog_informations`
--

CREATE TABLE `blog_informations` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `blog_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` blob NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `blog_informations`
--

INSERT INTO `blog_informations` (`id`, `language_id`, `blog_category_id`, `blog_id`, `title`, `slug`, `author`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(49, 20, 51, 27, 'The Critical Importance of Regular Health Check-Ups:', 'the-critical-importance-of-regular-health-check-ups:', 'Jane', 0x3c703e4d656e74616c206865616c7468206973206a75737420617320696d706f7274616e7420617320706879736963616c206865616c74682c207965742069742773206f6674656e206f7665726c6f6f6b65642e20446576656c6f70696e67207374726f6e67206d656e74616c206865616c7468206861626974732063616e2068656c7020796f7520636f70652077697468207374726573732c206275696c6420726573696c69656e63652c20616e64206d61696e7461696e206120706f736974697665206f75746c6f6f6b206f6e206c6966652e205374617274206279207072696f726974697a696e6720736c6565702c20617320616465717561746520726573742069732074686520666f756e646174696f6e206f6620676f6f64206d656e74616c206865616c74682e20526567756c617220657865726369736520697320616e6f74686572206b6579206861626974e28094706879736963616c2061637469766974792072656c656173657320656e646f727068696e732c20776869636820696d70726f7665206d6f6f6420616e642072656475636520616e78696574792e204e7574726974696f6e20706c6179732061207369676e69666963616e7420726f6c6520746f6f3b20612062616c616e6365642064696574207269636820696e20766974616d696e7320616e64206d696e6572616c7320737570706f72747320627261696e2066756e6374696f6e20616e6420656d6f74696f6e616c2073746162696c6974792e205072616374696365206d696e6466756c6e6573732062792064656469636174696e672074696d6520656163682064617920746f206d656469746174696f6e206f72206465657020627265617468696e67206578657263697365732c2068656c70696e6720796f7520737461792067726f756e64656420696e207468652070726573656e74206d6f6d656e742e20536f6369616c20636f6e6e656374696f6e7320617265206372756369616c2061732077656c6ce280946e7572747572696e672072656c6174696f6e736869707320776974682066616d696c7920616e6420667269656e64732070726f7669646573206120737570706f72742073797374656d20746861742063616e2068656c7020796f75207468726f75676820746f7567682074696d65732e204164646974696f6e616c6c792c20646f6ee280997420686573697461746520746f207365656b2070726f66657373696f6e616c2068656c70207768656e206e65656465643b2074686572617079206f7220636f756e73656c696e672063616e206f666665722076616c7561626c6520746f6f6c7320616e64207065727370656374697665732e204c6173746c792c206d616e616765207374726573732062792073657474696e67207265616c697374696320676f616c7320616e6420626f756e6461726965732c20656e737572696e6720796f7520646f6ee28099742074616b65206f6e206d6f7265207468616e20796f752063616e2068616e646c652e2042792061646f7074696e6720746865736520736576656e206861626974732c20796f752063616e20666f737465722061206865616c7468696572206d696e6420616e642061206d6f72652062616c616e636564206c6966653c2f703e, NULL, NULL, '2024-08-27 05:53:03', '2024-08-29 05:19:41'),
(50, 21, 55, 27, 'الأهمية البالغة لإجراء فحوصات طبية دورية:', 'الأهمية-البالغة-لإجراء-فحوصات-طبية-دورية:', 'جين', 0x3c703ed8a7d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a920d985d987d985d8a920d8a8d982d8afd8b120d8a7d984d8b5d8add8a920d8a7d984d8acd8b3d8afd98ad8a9d88c20d8a5d984d8a720d8a3d986d987d8a720d8bad8a7d984d8a8d98bd8a720d985d8a720d98ad8aad98520d8aad8acd8a7d987d984d987d8a72e20d98ad985d983d98620d8a3d98620d98ad8b3d8a7d8b9d8afd98320d8aad8b7d988d98ad8b120d8b9d8a7d8afd8a7d8aa20d8a7d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a920d8a7d984d982d988d98ad8a920d981d98a20d8a7d984d8aad8b9d8a7d985d98420d985d8b920d8a7d984d8aad988d8aad8b120d988d8a8d986d8a7d8a120d8a7d984d985d8b1d988d986d8a920d988d8a7d984d8add981d8a7d8b820d8b9d984d98920d986d8b8d8b1d8a920d8a5d98ad8acd8a7d8a8d98ad8a920d984d984d8add98ad8a7d8a92e20d8a7d8a8d8afd8a320d8a8d8a5d8b9d8b7d8a7d8a120d8a7d984d8a3d988d984d988d98ad8a920d984d984d986d988d985d88c20d8add98ad8ab20d8a3d98620d8a7d984d8b1d8a7d8add8a920d8a7d984d983d8a7d981d98ad8a920d987d98a20d8a3d8b3d8a7d8b320d8a7d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a920d8a7d984d8acd98ad8afd8a92e20d98ad8b9d8af20d8a7d984d8aad985d8b1d98ad98620d8a7d984d985d986d8aad8b8d98520d8b9d8a7d8afd8a920d8a3d8b3d8a7d8b3d98ad8a920d8a3d8aed8b1d989202d20d8add98ad8ab20d98ad981d8b1d8b220d8a7d984d986d8b4d8a7d8b720d8a7d984d8a8d8afd986d98a20d8a7d984d8a5d986d8afd988d8b1d981d98ad986d88c20d985d985d8a720d98ad8add8b3d98620d8a7d984d8add8a7d984d8a920d8a7d984d985d8b2d8a7d8acd98ad8a920d988d98ad982d984d98420d985d98620d8a7d984d982d984d9822e20d8aad984d8b9d8a820d8a7d984d8aad8bad8b0d98ad8a920d8afd988d8b1d98bd8a720d985d987d985d98bd8a720d8a3d98ad8b6d98bd8a7d89b20d98ad8afd8b9d98520d8a7d984d986d8b8d8a7d98520d8a7d984d8bad8b0d8a7d8a6d98a20d8a7d984d985d8aad988d8a7d8b2d98620d8a7d984d8bad986d98a20d8a8d8a7d984d981d98ad8aad8a7d985d98ad986d8a7d8aa20d988d8a7d984d985d8b9d8a7d8afd98620d988d8b8d8a7d8a6d98120d8a7d984d985d8ae20d988d8a7d984d8a7d8b3d8aad982d8b1d8a7d8b120d8a7d984d8b9d8a7d8b7d981d98a2e20d985d8a7d8b1d8b320d8a7d984d98ad982d8b8d8a920d985d98620d8aed984d8a7d98420d8aad8aed8b5d98ad8b520d988d982d8aa20d983d98420d98ad988d98520d984d984d8aad8a3d985d98420d8a3d98820d8aad985d8a7d8b1d98ad98620d8a7d984d8aad986d981d8b320d8a7d984d8b9d985d98ad982d88c20d985d985d8a720d98ad8b3d8a7d8b9d8afd98320d8b9d984d98920d8a7d984d8a8d982d8a7d8a120d8b9d984d98920d8a7d984d8a3d8b1d8b620d981d98a20d8a7d984d984d8add8b8d8a920d8a7d984d8add8a7d984d98ad8a92e20d8aad8b9d8aad8a8d8b120d8a7d984d8b1d988d8a7d8a8d8b720d8a7d984d8a7d8acd8aad985d8a7d8b9d98ad8a920d8a3d985d8b1d98bd8a720d8a8d8a7d984d8ba20d8a7d984d8a3d987d985d98ad8a920d8a3d98ad8b6d98bd8a7202d20d8add98ad8ab20d8aad988d981d8b120d8b1d8b9d8a7d98ad8a920d8a7d984d8b9d984d8a7d982d8a7d8aa20d985d8b920d8a7d984d8b9d8a7d8a6d984d8a920d988d8a7d984d8a3d8b5d8afd982d8a7d8a120d986d8b8d8a7d98520d8afd8b9d98520d98ad985d983d98620d8a3d98620d98ad8b3d8a7d8b9d8afd98320d981d98a20d8a7d984d8a3d988d982d8a7d8aa20d8a7d984d8b5d8b9d8a8d8a92e20d8a8d8a7d984d8a5d8b6d8a7d981d8a920d8a5d984d98920d8b0d984d983d88c20d984d8a720d8aad8aad8b1d8afd8af20d981d98a20d8b7d984d8a820d8a7d984d985d8b3d8a7d8b9d8afd8a920d8a7d984d985d987d986d98ad8a920d8b9d986d8af20d8a7d984d8add8a7d8acd8a9d89b20d98ad985d983d98620d8a3d98620d98ad988d981d8b120d8a7d984d8b9d984d8a7d8ac20d8a3d98820d8a7d984d8a7d8b3d8aad8b4d8a7d8b1d8a920d8a3d8afd988d8a7d8aa20d988d988d8acd987d8a7d8aa20d986d8b8d8b120d982d98ad985d8a92e20d8a3d8aed98ad8b1d98bd8a7d88c20d982d98520d8a8d8a5d8afd8a7d8b1d8a920d8a7d984d8aad988d8aad8b120d985d98620d8aed984d8a7d98420d8aad8add8afd98ad8af20d8a3d987d8afd8a7d98120d988d8add8afd988d8af20d988d8a7d982d8b9d98ad8a9d88c20d988d8a7d984d8aad8a3d983d8af20d985d98620d8b9d8afd98520d8aad8add985d98420d8a3d983d8abd8b120d985d985d8a720d98ad985d983d986d98320d8a7d984d8aad8b9d8a7d985d98420d985d8b9d9872e20d985d98620d8aed984d8a7d98420d8aad8a8d986d98a20d987d8b0d98720d8a7d984d8b9d8a7d8afd8a7d8aa20d8a7d984d8b3d8a8d8b9d88c20d98ad985d983d986d98320d8aad8b9d8b2d98ad8b220d8b9d982d98420d8a3d983d8abd8b120d8b5d8add8a920d988d8add98ad8a7d8a920d8a3d983d8abd8b120d8aad988d8a7d8b2d986d8a7d98b3c2f703e, NULL, NULL, '2024-08-27 05:53:03', '2024-08-29 05:19:41'),
(51, 20, 53, 28, 'Top 5 Tools Every Small Business Should Be Using', 'top-5-tools-every-small-business-should-be-using', 'Andrews', 0x3c703e496e20746f646179277320666173742d706163656420776f726c642c20736d616c6c20627573696e6573736573206e65656420746f206c6576657261676520746563686e6f6c6f677920746f207374617920636f6d706574697469766520616e642067726f7720656666696369656e746c792e205768657468657220796f75277265206d616e6167696e672061207365727669636520626f6f6b696e672077656273697465206c696b6520426f6f6b417070206f722072756e6e696e672061206c6f63616c2073686f702c2074686520726967687420746f6f6c732063616e2073747265616d6c696e65206f7065726174696f6e732c20696d70726f766520637573746f6d657220657870657269656e63652c20616e6420626f6f73742070726f6475637469766974792e2048657265206172652074686520746f70206669766520746f6f6c73207468617420657665727920736d616c6c20627573696e6573732073686f756c6420636f6e736964657220696e746567726174696e6720696e746f207468656972206461696c79206f7065726174696f6e732e3c2f703e0d0a3c68343e312e203c7374726f6e673e50726f6a656374204d616e6167656d656e7420536f6674776172653a205472656c6c6f3c2f7374726f6e673e3c2f68343e0d0a3c703e5472656c6c6f206973206120757365722d667269656e646c792070726f6a656374206d616e6167656d656e7420746f6f6c20746861742068656c707320796f75206f7267616e697a65207461736b732c2073657420646561646c696e65732c20616e6420636f6c6c61626f72617465207769746820796f7572207465616d2e2057697468206974732076697375616c20626f617264732c206c697374732c20616e642063617264732c205472656c6c6f206d616b6573206974206561737920746f20747261636b2070726f677265737320616e6420656e737572652074686174206e6f7468696e672066616c6c73207468726f7567682074686520637261636b732e205768657468657220796f7527726520706c616e6e696e672061206d61726b6574696e672063616d706169676e206f72206d616e6167696e6720636c69656e74206170706f696e746d656e74732c205472656c6c6f206b656570732065766572797468696e6720696e206f6e6520706c6163652c20616c6c6f77696e6720666f72207365616d6c65737320636f6d6d756e69636174696f6e20616e6420656666696369656e63792e3c2f703e0d0a3c68343e322e203c7374726f6e673e4163636f756e74696e6720536f6674776172653a20517569636b426f6f6b733c2f7374726f6e673e3c2f68343e0d0a3c703e4d616e6167696e672066696e616e6365732063616e206265206f7665727768656c6d696e672c20657370656369616c6c7920666f7220736d616c6c20627573696e65737365732077697468206c696d69746564207265736f75726365732e20517569636b426f6f6b732073696d706c6966696573206163636f756e74696e67206279206175746f6d6174696e6720696e766f6963696e672c20657870656e736520747261636b696e672c20616e642066696e616e6369616c207265706f7274696e672e2049747320696e7475697469766520696e7465726661636520616c6c6f777320796f7520746f206d6f6e69746f72206361736820666c6f772c206d616e61676520706179726f6c6c2c20616e64206576656e207072657061726520666f722074617820736561736f6e20776974686f757420746865206e65656420666f7220616e206163636f756e74696e67206465677265652e20517569636b426f6f6b7320616c736f20696e7465677261746573207769746820766172696f7573207061796d656e742067617465776179732c206d616b696e67206974206120766572736174696c6520746f6f6c20666f7220627573696e6573736573206f6620616c6c2073697a65732e3c2f703e0d0a3c68343e332e203c7374726f6e673e437573746f6d65722052656c6174696f6e73686970204d616e6167656d656e74202843524d293a2048756253706f743c2f7374726f6e673e3c2f68343e0d0a3c703e4275696c64696e6720616e64206d61696e7461696e696e67207374726f6e6720637573746f6d65722072656c6174696f6e7368697073206973206372756369616c20666f7220627573696e65737320737563636573732e2048756253706f74277320667265652043524d20706c6174666f726d206f6666657273206120636f6d70726568656e7369766520736f6c7574696f6e20666f72206d616e6167696e6720636f6e74616374732c20747261636b696e6720637573746f6d657220696e746572616374696f6e732c20616e64206175746f6d6174696e67206d61726b6574696e67206566666f7274732e204279206b656570696e6720616c6c20637573746f6d6572206461746120696e206f6e6520706c6163652c2048756253706f7420656e61626c657320796f7520746f2070726f7669646520706572736f6e616c697a656420736572766963652c20696d70726f766520637573746f6d657220726574656e74696f6e2c20616e6420756c74696d6174656c792064726976652073616c65732067726f7774682e3c2f703e0d0a3c68343e342e203c7374726f6e673e536f6369616c204d65646961204d616e6167656d656e743a204275666665723c2f7374726f6e673e3c2f68343e0d0a3c703e496e20746865206469676974616c206167652c20686176696e672061207374726f6e67206f6e6c696e652070726573656e6365206973206e6f6e2d6e65676f746961626c652e204275666665722073696d706c696669657320736f6369616c206d65646961206d616e6167656d656e7420627920616c6c6f77696e6720796f7520746f207363686564756c6520706f7374732c20747261636b20656e676167656d656e742c20616e6420616e616c797a6520706572666f726d616e6365206163726f7373206d756c7469706c6520706c6174666f726d732e2057697468204275666665722c20796f752063616e20706c616e20616e64206175746f6d61746520796f757220736f6369616c206d656469612073747261746567792c2066726565696e672075702074696d6520746f20666f637573206f6e206f746865722061737065637473206f6620796f757220627573696e6573732e2049747320616e616c7974696373206665617475726520616c736f2070726f76696465732076616c7561626c6520696e73696768747320696e746f207768617420636f6e74656e74207265736f6e61746573207769746820796f75722061756469656e63652e3c2f703e0d0a3c68343e352e203c7374726f6e673e436f6d6d756e69636174696f6e20546f6f6c3a20536c61636b3c2f7374726f6e673e3c2f68343e0d0a3c703e45666665637469766520636f6d6d756e69636174696f6e20697320746865206261636b626f6e65206f6620616e79207375636365737366756c20627573696e6573732e20536c61636b206973206120706f77657266756c206d6573736167696e6720706c6174666f726d2074686174206272696e6773207465616d20636f6d6d756e69636174696f6e20746f67657468657220696e206f6e6520706c6163652e2057697468206665617475726573206c696b65206368616e6e656c732c20646972656374206d6573736167696e672c20616e6420696e746567726174696f6e732077697468206f7468657220746f6f6c732c20536c61636b2073747265616d6c696e657320696e7465726e616c20636f6d6d756e69636174696f6e2c207265647563657320656d61696c20636c75747465722c20616e6420666f7374657273206120636f6c6c61626f72617469766520776f726b20656e7669726f6e6d656e742e205768657468657220796f7527726520636f6f7264696e6174696e6720776974682072656d6f746520776f726b657273206f722064697363757373696e672070726f6a6563742064657461696c732c20536c61636b206b656570732065766572796f6e6520636f6e6e656374656420616e64206f6e207468652073616d6520706167652e3c2f703e0d0a3c68333e3c7374726f6e673e436f6e636c7573696f6e3c2f7374726f6e673e3c2f68333e0d0a3c703e41646f7074696e672074686520726967687420746563686e6f6c6f677920616e6420746f6f6c732063616e206d616b652061207369676e69666963616e7420646966666572656e636520696e20686f7720656666696369656e746c7920796f757220736d616c6c20627573696e657373206f706572617465732e2046726f6d206d616e6167696e672070726f6a6563747320616e642066696e616e63657320746f206275696c64696e6720637573746f6d65722072656c6174696f6e736869707320616e6420656e68616e63696e67206f6e6c696e652070726573656e63652c20746865736520746f6f6c732070726f766964652074686520666f756e646174696f6e20796f75206e65656420746f2074687269766520696e206120636f6d7065746974697665206d61726b65742e20427920696e746567726174696e6720746865736520746563686e6f6c6f6769657320696e746f20796f7572206461696c79206f7065726174696f6e732c20796f75276c6c2062652077656c6c2d657175697070656420746f207461636b6c65206368616c6c656e6765732c207365697a65206f70706f7274756e69746965732c20616e642064726976652067726f77746820666f7220796f757220627573696e6573732e3c2f703e, NULL, NULL, '2024-08-27 06:04:02', '2024-08-29 05:09:39'),
(52, 21, 57, 28, 'أفضل 5 أدوات يجب على كل عمل صغير استخدامها', 'أفضل-5-أدوات-يجب-على-كل-عمل-صغير-استخدامها', 'أندروز', 0x3c703ed981d98a20d8b9d8a7d984d98520d8a7d984d98ad988d98520d8a7d984d8b3d8b1d98ad8b9d88c20d8aad8add8aad8a7d8ac20d8a7d984d8b4d8b1d983d8a7d8aa20d8a7d984d8b5d8bad98ad8b1d8a920d8a5d984d98920d8a7d984d8a7d8b3d8aad981d8a7d8afd8a920d985d98620d8a7d984d8aad983d986d988d984d988d8acd98ad8a720d984d984d8a8d982d8a7d8a120d8aad986d8a7d981d8b3d98ad8a920d988d8a7d984d986d985d98820d8a8d983d981d8a7d8a1d8a92e20d8b3d988d8a7d8a120d983d986d8aa20d8aad8afd98ad8b120d985d988d982d8b9d98bd8a720d984d8add8acd8b220d8a7d984d8aed8afd985d8a7d8aa20d985d8abd98420426f6f6b41707020d8a3d98820d8aad8afd98ad8b120d985d8aad8acd8b1d98bd8a720d985d8add984d98ad98bd8a7d88c20d981d8a5d98620d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d985d986d8a7d8b3d8a8d8a920d98ad985d983d98620d8a3d98620d8aad8a8d8b3d8b720d8a7d984d8b9d985d984d98ad8a7d8aad88c20d8aad8add8b3d98620d8aad8acd8b1d8a8d8a920d8a7d984d8b9d985d984d8a7d8a1d88c20d988d8aad8b9d8b2d8b220d8a7d984d8a5d986d8aad8a7d8acd98ad8a92e20d981d98ad985d8a720d98ad984d98a20d8a3d981d8b6d98420d8aed985d8b320d8a3d8afd988d8a7d8aa20d98ad8acd8a820d8a3d98620d8aad981d983d8b120d983d98420d8b4d8b1d983d8a920d8b5d8bad98ad8b1d8a920d981d98a20d8afd985d8acd987d8a720d981d98a20d8b9d985d984d98ad8a7d8aad987d8a720d8a7d984d98ad988d985d98ad8a92e3c2f703e0d0a3c68343e312e203c7374726f6e673ed8a8d8b1d986d8a7d985d8ac20d8a5d8afd8a7d8b1d8a920d8a7d984d985d8b4d8a7d8b1d98ad8b93a205472656c6c6f3c2f7374726f6e673e3c2f68343e0d0a3c703e5472656c6c6f20d987d98820d8a3d8afd8a7d8a920d8b3d987d984d8a920d8a7d984d8a7d8b3d8aad8aed8afd8a7d98520d984d8a5d8afd8a7d8b1d8a920d8a7d984d985d8b4d8a7d8b1d98ad8b920d8aad8b3d8a7d8b9d8afd98320d981d98a20d8aad986d8b8d98ad98520d8a7d984d985d987d8a7d985d88c20d8aad8b9d98ad98ad98620d8a7d984d985d988d8a7d8b9d98ad8af20d8a7d984d986d987d8a7d8a6d98ad8a9d88c20d988d8a7d984d8aad8b9d8a7d988d98620d985d8b920d981d8b1d98ad982d9832e20d985d98620d8aed984d8a7d98420d984d988d8add8a7d8aad98720d8a7d984d985d8b1d8a6d98ad8a9d88c20d8a7d984d982d988d8a7d8a6d985d88c20d988d8a7d984d8a8d8b7d8a7d982d8a7d8aad88c20d98ad8acd8b9d984205472656c6c6f20d985d98620d8a7d984d8b3d987d98420d8aad8aad8a8d8b920d8a7d984d8aad982d8afd98520d988d8b6d985d8a7d98620d8b9d8afd98520d8aad981d988d98ad8aa20d8a3d98a20d8b4d98ad8a12e20d8b3d988d8a7d8a120d983d986d8aa20d8aad8aed8b7d8b720d984d8add985d984d8a920d8aad8b3d988d98ad982d98ad8a920d8a3d98820d8aad8afd98ad8b120d985d988d8a7d8b9d98ad8af20d8a7d984d8b9d985d984d8a7d8a1d88c20d98ad8add8aad981d8b8205472656c6c6f20d8a8d983d98420d8b4d98ad8a120d981d98a20d985d983d8a7d98620d988d8a7d8add8afd88c20d985d985d8a720d98ad8aad98ad8ad20d8a7d984d8aad988d8a7d8b5d98420d8a7d984d8b3d984d8b320d988d8a7d984d983d981d8a7d8a1d8a92e3c2f703e0d0a3c68343e322e203c7374726f6e673ed8a8d8b1d986d8a7d985d8ac20d8a7d984d985d8add8a7d8b3d8a8d8a93a20517569636b426f6f6b733c2f7374726f6e673e3c2f68343e0d0a3c703ed8a5d8afd8a7d8b1d8a920d8a7d984d985d8a7d984d98ad8a920d98ad985d983d98620d8a3d98620d8aad983d988d98620d985d8b1d987d982d8a9d88c20d8aed8a7d8b5d8a9d98b20d984d984d8b4d8b1d983d8a7d8aa20d8a7d984d8b5d8bad98ad8b1d8a920d8a7d984d8aad98a20d984d8afd98ad987d8a720d985d988d8a7d8b1d8af20d985d8add8afd988d8afd8a92e20517569636b426f6f6b7320d98ad8a8d8b3d8b720d8a7d984d985d8add8a7d8b3d8a8d8a920d985d98620d8aed984d8a7d98420d8a3d8aad985d8aad8a920d8a7d984d981d988d8a7d8aad98ad8b1d88c20d8aad8aad8a8d8b920d8a7d984d986d981d982d8a7d8aad88c20d988d8a5d8b9d8afd8a7d8af20d8a7d984d8aad982d8a7d8b1d98ad8b120d8a7d984d985d8a7d984d98ad8a92e20d988d8a7d8acd987d8aad98720d8a7d984d8a8d8b3d98ad8b7d8a920d8aad8b3d985d8ad20d984d98320d8a8d985d8b1d8a7d982d8a8d8a920d8aad8afd981d98220d8a7d984d8a3d985d988d8a7d984d88c20d8a5d8afd8a7d8b1d8a920d8a7d984d8b1d988d8a7d8aad8a8d88c20d988d8add8aad98920d8a7d984d8aad8add8b6d98ad8b120d984d985d988d8b3d98520d8a7d984d8b6d8b1d8a7d8a6d8a820d8afd988d98620d8a7d984d8add8a7d8acd8a920d8a5d984d98920d8b4d987d8a7d8afd8a920d985d8add8a7d8b3d8a8d8a92e20517569636b426f6f6b7320d8a3d98ad8b6d98bd8a720d98ad8aad983d8a7d985d98420d985d8b920d8a8d988d8a7d8a8d8a7d8aa20d8a7d984d8afd981d8b920d8a7d984d985d8aed8aad984d981d8a9d88c20d985d985d8a720d98ad8acd8b9d984d98720d8a3d8afd8a7d8a920d985d8aad8b9d8afd8afd8a920d8a7d984d8a7d8b3d8aad8aed8afd8a7d985d8a7d8aa20d984d984d8b4d8b1d983d8a7d8aa20d985d98620d8acd985d98ad8b920d8a7d984d8a3d8add8acd8a7d9852e3c2f703e0d0a3c68343e332e203c7374726f6e673ed8a5d8afd8a7d8b1d8a920d8b9d984d8a7d982d8a7d8aa20d8a7d984d8b9d985d984d8a7d8a1202843524d293a2048756253706f743c2f7374726f6e673e3c2f68343e0d0a3c703ed8a8d986d8a7d8a120d988d8a7d984d8add981d8a7d8b820d8b9d984d98920d8b9d984d8a7d982d8a7d8aa20d982d988d98ad8a920d985d8b920d8a7d984d8b9d985d984d8a7d8a120d8a3d985d8b120d8b6d8b1d988d8b1d98a20d984d986d8acd8a7d8ad20d8a7d984d8a3d8b9d985d8a7d9842e20d98ad988d981d8b120d985d986d8b5d8a92048756253706f7420d8a7d984d985d8acd8a7d986d98ad8a920d984d8a5d8afd8a7d8b1d8a920d8b9d984d8a7d982d8a7d8aa20d8a7d984d8b9d985d984d8a7d8a120d8add984d8a7d98b20d8b4d8a7d985d984d8a7d98b20d984d8a5d8afd8a7d8b1d8a920d8acd987d8a7d8aa20d8a7d984d8a7d8aad8b5d8a7d984d88c20d8aad8aad8a8d8b920d8aad981d8a7d8b9d984d8a7d8aa20d8a7d984d8b9d985d984d8a7d8a1d88c20d988d8a3d8aad985d8aad8a920d8a7d984d8acd987d988d8af20d8a7d984d8aad8b3d988d98ad982d98ad8a92e20d985d98620d8aed984d8a7d98420d8a7d984d8a7d8add8aad981d8a7d8b820d8a8d8acd985d98ad8b920d8a8d98ad8a7d986d8a7d8aa20d8a7d984d8b9d985d984d8a7d8a120d981d98a20d985d983d8a7d98620d988d8a7d8add8afd88c20d98ad8aad98ad8ad20d984d9832048756253706f7420d8aad982d8afd98ad98520d8aed8afd985d8a920d985d8aed8b5d8b5d8a9d88c20d8aad8add8b3d98ad98620d8a7d984d8a7d8add8aad981d8a7d8b820d8a8d8a7d984d8b9d985d984d8a7d8a1d88c20d988d981d98a20d8a7d984d986d987d8a7d98ad8a920d8afd981d8b920d986d985d98820d8a7d984d985d8a8d98ad8b9d8a7d8aa2e3c2f703e0d0a3c68343e342e203c7374726f6e673ed8a5d8afd8a7d8b1d8a920d988d8b3d8a7d8a6d98420d8a7d984d8aad988d8a7d8b5d98420d8a7d984d8a7d8acd8aad985d8a7d8b9d98a3a204275666665723c2f7374726f6e673e3c2f68343e0d0a3c703ed981d98a20d8a7d984d8b9d8b5d8b120d8a7d984d8b1d982d985d98ad88c20d984d8a720d98ad985d983d98620d8a7d984d8aad981d8a7d988d8b620d8b9d984d98920d988d8acd988d8af20d982d988d98a20d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa2e2042756666657220d98ad8a8d8b3d8b720d8a5d8afd8a7d8b1d8a920d988d8b3d8a7d8a6d98420d8a7d984d8aad988d8a7d8b5d98420d8a7d984d8a7d8acd8aad985d8a7d8b9d98a20d985d98620d8aed984d8a7d98420d8a7d984d8b3d985d8a7d8ad20d984d98320d8a8d8acd8afd988d984d8a920d8a7d984d985d986d8b4d988d8b1d8a7d8aad88c20d8aad8aad8a8d8b920d8a7d984d8aad981d8a7d8b9d984d88c20d988d8aad8add984d98ad98420d8a7d984d8a3d8afd8a7d8a120d8b9d8a8d8b120d985d986d8b5d8a7d8aa20d985d8aad8b9d8afd8afd8a92e20d985d8b920427566666572d88c20d98ad985d983d986d98320d8aad8aed8b7d98ad8b720d988d8a3d8aad985d8aad8a920d8a7d8b3d8aad8b1d8a7d8aad98ad8acd98ad8aad98320d8b9d984d98920d988d8b3d8a7d8a6d98420d8a7d984d8aad988d8a7d8b5d98420d8a7d984d8a7d8acd8aad985d8a7d8b9d98ad88c20d985d985d8a720d98ad8aad98ad8ad20d984d98320d8a7d984d988d982d8aa20d984d984d8aad8b1d983d98ad8b220d8b9d984d98920d8acd988d8a7d986d8a820d8a3d8aed8b1d98920d985d98620d8b9d985d984d9832e20d8aad988d981d8b120d985d98ad8b2d8a920d8a7d984d8aad8add984d98ad984d8a7d8aa20d8a3d98ad8b6d98bd8a720d8b1d8a4d98920d982d98ad985d8a920d8add988d98420d8a7d984d985d8add8aad988d98920d8a7d984d8b0d98a20d98ad984d982d98920d8a7d8b3d8aad8add8b3d8a7d98620d8acd985d987d988d8b1d9832e3c2f703e0d0a3c68343e352e203c7374726f6e673ed8a3d8afd8a7d8a920d8a7d984d8a7d8aad8b5d8a7d9843a20536c61636b3c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8a7d8aad8b5d8a7d98420d8a7d984d981d8b9d8a7d98420d987d98820d8a7d984d8b9d985d988d8af20d8a7d984d981d982d8b1d98a20d984d8a3d98a20d8b9d985d98420d986d8a7d8acd8ad2e20536c61636b20d987d98820d985d986d8b5d8a920d8b1d8b3d8a7d8a6d98420d982d988d98ad8a920d8aad8acd985d8b920d8a7d984d8a7d8aad8b5d8a7d98420d8a7d984d8acd985d8a7d8b9d98a20d981d98a20d985d983d8a7d98620d988d8a7d8add8af2e20d985d8b920d985d98ad8b2d8a7d8aa20d985d8abd98420d8a7d984d982d986d988d8a7d8aad88c20d8a7d984d8b1d8b3d8a7d8a6d98420d8a7d984d985d8a8d8a7d8b4d8b1d8a9d88c20d988d8a7d984d8aad983d8a7d985d98420d985d8b920d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d8a3d8aed8b1d989d88c20d98ad8a8d8b3d8b720536c61636b20d8a7d984d8a7d8aad8b5d8a7d984d8a7d8aa20d8a7d984d8afd8a7d8aed984d98ad8a9d88c20d98ad982d984d98420d985d98620d981d988d8b6d98920d8a7d984d8a8d8b1d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98ad88c20d988d98ad8b9d8b2d8b220d8a8d98ad8a6d8a920d8b9d985d98420d8aad8b9d8a7d988d986d98ad8a92e20d8b3d988d8a7d8a120d983d986d8aa20d8aad8aad8b9d8a7d988d98620d985d8b920d8b9d985d8a7d98420d8b9d98620d8a8d8b9d8af20d8a3d98820d8aad986d8a7d982d8b420d8aad981d8a7d8b5d98ad98420d8a7d984d985d8b4d8b1d988d8b9d88c20d98ad8a8d982d98a20536c61636b20d8a7d984d8acd985d98ad8b920d985d8aad8b5d984d98ad98620d988d8b9d984d98920d986d981d8b320d8a7d984d8b5d981d8add8a92e3c2f703e0d0a3c68333e3c7374726f6e673ed8a7d984d8aed8a7d8aad985d8a93c2f7374726f6e673e3c2f68333e0d0a3c703ed8a7d8b9d8aad985d8a7d8af20d8a7d984d8aad983d986d988d984d988d8acd98ad8a720d988d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d8b5d8add98ad8add8a920d98ad985d983d98620d8a3d98620d98ad8add8afd8ab20d981d8b1d982d98bd8a720d983d8a8d98ad8b1d98bd8a720d981d98a20d983d98ad981d98ad8a920d983d981d8a7d8a1d8a920d8b9d985d984d98320d8a7d984d8b5d8bad98ad8b12e20d985d98620d8a5d8afd8a7d8b1d8a920d8a7d984d985d8b4d8a7d8b1d98ad8b920d988d8a7d984d985d8a7d984d98ad8a920d8a5d984d98920d8a8d986d8a7d8a120d8b9d984d8a7d982d8a7d8aa20d8a7d984d8b9d985d984d8a7d8a120d988d8aad8b9d8b2d98ad8b220d8a7d984d8add8b6d988d8b120d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aad88c20d8aad988d981d8b120d987d8b0d98720d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d8a3d8b3d8a7d8b320d8a7d984d8b0d98a20d8aad8add8aad8a7d8acd98720d984d984d986d8acd8a7d8ad20d981d98a20d8b3d988d98220d8aad986d8a7d981d8b3d98a2e20d985d98620d8aed984d8a7d98420d8afd985d8ac20d987d8b0d98720d8a7d984d8aad982d986d98ad8a7d8aa20d981d98a20d8b9d985d984d98ad8a7d8aad98320d8a7d984d98ad988d985d98ad8a9d88c20d8b3d8aad983d988d98620d985d8acd987d8b2d98bd8a720d8acd98ad8afd98bd8a720d984d985d988d8a7d8acd987d8a920d8a7d984d8aad8add8afd98ad8a7d8aad88c20d8a7d8bad8aad986d8a7d98520d8a7d984d981d8b1d8b5d88c20d988d8aad8add982d98ad98220d8a7d984d986d985d98820d984d8b9d985d984d9832e3c2f703e, NULL, NULL, '2024-08-27 06:04:02', '2024-08-29 05:09:39'),
(53, 20, 52, 29, 'Essential Tools and Guides for Success and Growth', 'essential-tools-and-guides-for-success-and-growth', 'Miller', 0x3c703e496e20616e20696e6372656173696e676c79206469676974616c20776f726c642c206f6e6c696e65206c6561726e696e6720686173206265636f6d65206120706f77657266756c20746f6f6c20666f722073747564656e747320616e642070726f66657373696f6e616c7320616c696b652e205768657468657220796f75e280997265206c6f6f6b696e6720746f20616476616e636520796f7572206361726565722c207069636b2075702061206e657720736b696c6c2c206f72206578706c6f72652061206e6577206669656c64206f662073747564792c20746865207765616c7468206f66206f6e6c696e65207265736f757263657320617661696c61626c652063616e2068656c7020796f75206163686965766520796f757220656475636174696f6e616c20676f616c732e20486572652061726520736f6d6520746f70206f6e6c696e65206c6561726e696e6720706c6174666f726d7320616e64207265736f7572636573207468617420617265207472616e73666f726d696e672074686520776179207765206c6561726e2e3c2f703e0d0a3c68343e312e203c7374726f6e673e436f7572736572613c2f7374726f6e673e3c2f68343e0d0a3c703e436f757273657261206f666665727320636f75727365732066726f6d20746f7020756e6976657273697469657320616e6420696e737469747574696f6e732061726f756e642074686520776f726c642e205769746820612076617374206172726179206f6620746f706963732072616e67696e672066726f6d206461746120736369656e636520746f2068756d616e69746965732c20436f7572736572612070726f766964657320686967682d7175616c69747920656475636174696f6e2074686174206669747320696e746f20796f7572207363686564756c652e204d616e7920636f757273657320617265206672656520746f2061756469742c20616e6420796f752063616e206561726e2063657274696669636174657320666f722061206665652e2049747320737472756374757265642070726f6772616d7320616e6420706172746e657273686970732077697468206c656164696e6720756e69766572736974696573206d616b6520697420616e20657863656c6c656e74207265736f7572636520666f7220626f746820666f756e646174696f6e616c206b6e6f776c6564676520616e6420616476616e6365642073747564792e3c2f703e0d0a3c68343e322e203c7374726f6e673e5564656d793c2f7374726f6e673e3c2f68343e0d0a3c703e5564656d79206973206120706f70756c617220706c6174666f726d20746861742070726f7669646573206120776964652076617269657479206f6620636f7572736573206f6e206e6561726c79206576657279207375626a65637420696d6167696e61626c652e2046726f6d2070726f6772616d6d696e6720616e6420627573696e65737320746f20706572736f6e616c20646576656c6f706d656e7420616e6420637265617469766520736b696c6c732c205564656d79e280997320636f757273657320617265206372656174656420627920696e647573747279206578706572747320616e64206172652064657369676e656420746f2062652061636365737369626c6520746f206c6561726e65727320617420616c6c206c6576656c732e2057697468206672657175656e7420646973636f756e747320616e64206c69666574696d652061636365737320746f20636f75727365206d6174657269616c732c205564656d79206973206120636f73742d656666656374697665206f7074696f6e20666f7220616371756972696e67206e657720736b696c6c732e3c2f703e0d0a3c68343e332e203c7374726f6e673e4b68616e2041636164656d793c2f7374726f6e673e3c2f68343e0d0a3c703e4b68616e2041636164656d792069732061206672656520656475636174696f6e616c207265736f75726365207468617420666f6375736573206f6e2070726f766964696e67206120636f6d70726568656e7369766520637572726963756c756d20666f722073747564656e7473206f6620616c6c20616765732e204974206f666665727320696e746572616374697665206c6573736f6e7320696e207375626a65637473206c696b65206d6174682c20736369656e63652c20616e642065636f6e6f6d6963732c20616c6f6e6720776974682070726163746963652065786572636973657320616e6420696e737472756374696f6e616c20766964656f732e204b68616e2041636164656d79e280997320706572736f6e616c697a6564206c6561726e696e672064617368626f6172642068656c70732073747564656e747320747261636b2074686569722070726f677265737320616e642073746179206d6f746976617465642c206d616b696e6720697420616e20696e76616c7561626c6520746f6f6c20666f7220626f7468207363686f6f6c20616e642073656c662d6469726563746564206c6561726e696e672e3c2f703e0d0a3c68343e342e203c7374726f6e673e4c696e6b6564496e204c6561726e696e673c2f7374726f6e673e3c2f68343e0d0a3c703e4c696e6b6564496e204c6561726e696e672c20666f726d65726c79206b6e6f776e206173204c796e64612e636f6d2c2070726f766964657320612076617374206c696272617279206f6620766964656f20636f75727365732074617567687420627920696e6475737472792070726f66657373696f6e616c732e2054686520706c6174666f726d20666f6375736573206f6e2070726163746963616c20736b696c6c7320616e642070726f66657373696f6e616c20646576656c6f706d656e742c207769746820636f757273657320636f766572696e6720746f7069637320737563682061732070726f6a656374206d616e6167656d656e742c20736f66747761726520646576656c6f706d656e742c20616e64206c6561646572736869702e204c696e6b6564496e204c6561726e696e6720616c736f20696e7465677261746573207769746820796f7572204c696e6b6564496e2070726f66696c652c20616c6c6f77696e6720796f7520746f2073686f776361736520796f7572206e65776c7920616371756972656420736b696c6c7320616e642063657274696669636174696f6e7320746f20706f74656e7469616c20656d706c6f796572732e3c2f703e0d0a3c68343e352e203c7374726f6e673e6564583c2f7374726f6e673e3c2f68343e0d0a3c703e65645820697320616e6f7468657220746f7020706c6174666f726d2074686174206f666665727320636f757273657320616e642070726f6772616d732066726f6d206c656164696e6720756e6976657273697469657320616e6420696e737469747574696f6e732e2049742070726f766964657320612072616e6765206f66206c6561726e696e67206f70706f7274756e69746965732c2066726f6d20696e646976696475616c20636f757273657320746f2066756c6c206465677265652070726f6772616d732e20656458206973206b6e6f776e20666f7220697473207269676f726f75732061636164656d6963207374616e646172647320616e642069747320636f6d6d69746d656e7420746f2070726f766964696e672061636365737369626c6520656475636174696f6e20746f206c6561726e6572732061726f756e642074686520676c6f62652e2057697468206f7074696f6e7320666f7220626f7468206672656520616e64207061696420636f75727365732c206564582063617465727320746f20612076617269657479206f66206c6561726e696e67206e656564732e3c2f703e0d0a3c68333e3c7374726f6e673e436f6e636c7573696f6e3c2f7374726f6e673e3c2f68333e0d0a3c703e4f6e6c696e65206c6561726e696e6720686173207265766f6c7574696f6e697a656420656475636174696f6e206279206d616b696e6720686967682d7175616c697479207265736f75726365732061636365737369626c6520746f20616e796f6e65207769746820616e20696e7465726e657420636f6e6e656374696f6e2e205768657468657220796f75e28099726520612073747564656e742061696d696e6720746f20657863656c20696e20796f75722073747564696573206f7220612070726f66657373696f6e616c206c6f6f6b696e6720746f20656e68616e636520796f757220736b696c6c732c20706c6174666f726d73206c696b6520436f7572736572612c205564656d792c204b68616e2041636164656d792c204c696e6b6564496e204c6561726e696e672c20616e6420656458206f666665722076616c7561626c65206f70706f7274756e697469657320666f722067726f77746820616e6420646576656c6f706d656e742e20456d62726163652074686520706f776572206f66206f6e6c696e65206c6561726e696e6720616e642074616b6520746865206e657874207374657020696e20796f757220656475636174696f6e616c206a6f75726e6579207769746820746865736520746f70207265736f75726365732e3c2f703e, NULL, NULL, '2024-08-27 06:08:31', '2024-08-29 05:20:47'),
(54, 21, 56, 29, 'أدوات وإرشادات أساسية لتحقيق النجاح والنمو', 'أدوات-وإرشادات-أساسية-لتحقيق-النجاح-والنمو', 'ميلر', 0x3c703ed981d98a20d8b9d8a7d984d985d986d8a720d8a7d984d8b1d982d985d98a20d8a7d984d985d8aad8b2d8a7d98ad8afd88c20d8a3d8b5d8a8d8ad20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa20d8a3d8afd8a7d8a920d982d988d98ad8a920d984d984d8b7d984d8a7d8a820d988d8a7d984d985d8add8aad8b1d981d98ad98620d8b9d984d98920d8add8af20d8b3d988d8a7d8a12e20d8b3d988d8a7d8a120d983d986d8aa20d8aad8b3d8b9d98920d984d8aad8b7d988d98ad8b120d985d8b3d98ad8b1d8aad98320d8a7d984d985d987d986d98ad8a9d88c20d8a7d983d8aad8b3d8a7d8a820d985d987d8a7d8b1d8a920d8acd8afd98ad8afd8a9d88c20d8a3d98820d8a7d8b3d8aad983d8b4d8a7d98120d985d8acd8a7d98420d8afd8b1d8a7d8b3d98a20d8acd8afd98ad8afd88c20d981d8a5d98620d8abd8b1d988d8a920d8a7d984d985d988d8a7d8b1d8af20d8a7d984d985d8aad8a7d8add8a920d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d98ad985d983d98620d8a3d98620d8aad8b3d8a7d8b9d8afd98320d981d98a20d8aad8add982d98ad98220d8a3d987d8afd8a7d981d98320d8a7d984d8aad8b9d984d98ad985d98ad8a92e20d981d98ad985d8a720d98ad984d98a20d8a8d8b9d8b620d8a7d984d985d986d8b5d8a7d8aa20d988d8a7d984d985d988d8a7d8b1d8af20d8a7d984d8aad8b9d984d98ad985d98ad8a920d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa20d8a7d984d8aad98a20d8aad8bad98ad8b120d8b7d8b1d98ad982d8a920d8aad8b9d984d985d986d8a72e3c2f703e0d0a3c68343e312e20d983d988d8b1d8b3d98ad8b1d8a73c2f68343e0d0a3c703ed8aad982d8afd98520d983d988d8b1d8b3d98ad8b1d8a7d8afd988d8b1d8a7d8aa20d985d98620d8a3d981d8b6d98420d8a7d984d8acd8a7d985d8b9d8a7d8aa20d988d8a7d984d985d8a4d8b3d8b3d8a7d8aa20d981d98a20d8acd985d98ad8b920d8a3d986d8add8a7d8a120d8a7d984d8b9d8a7d984d9852e20d985d8b920d985d8acd985d988d8b9d8a920d988d8a7d8b3d8b9d8a920d985d98620d8a7d984d985d988d8a7d8b6d98ad8b920d8aad8aad8b1d8a7d988d8ad20d8a8d98ad98620d8b9d984d98520d8a7d984d8a8d98ad8a7d986d8a7d8aa20d988d8a7d984d8a5d986d8b3d8a7d986d98ad8a7d8aad88c20d8aad988d981d8b120d983d988d8b1d8b3d98ad8b1d8a7d8aad8b9d984d98ad985d98bd8a720d8b9d8a7d984d98a20d8a7d984d8acd988d8afd8a920d98ad8aad986d8a7d8b3d8a820d985d8b920d8acd8afd988d984d98320d8a7d984d8b2d985d986d98a2e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d985d8acd8a7d986d98ad8a920d984d984d8aad8afd982d98ad982d88c20d988d98ad985d983d986d98320d8a7d984d8add8b5d988d98420d8b9d984d98920d8b4d987d8a7d8afd8a7d8aa20d985d982d8a7d8a8d98420d8b1d8b3d988d9852e20d8a8d8b1d8a7d985d8acd987d8a720d8a7d984d985d986d8b8d985d8a920d988d8b4d8b1d8a7d983d8a7d8aad987d8a720d985d8b920d8a7d984d8acd8a7d985d8b9d8a7d8aa20d8a7d984d8b1d8a7d8a6d8afd8a920d8aad8acd8b9d984d987d8a720d985d8b5d8afd8b1d98bd8a720d985d985d8aad8a7d8b2d98bd8a720d984d984d985d8b9d8b1d981d8a920d8a7d984d8a3d8b3d8a7d8b3d98ad8a920d988d8a7d984d8afd8b1d8a7d8b3d8a7d8aa20d8a7d984d985d8aad982d8afd985d8a92e3c2f703e0d0a3c68343e322e20d98ad988d8afd98ad985d98a3c2f68343e0d0a3c703ed98ad988d8afd98ad985d98ad987d98a20d985d986d8b5d8a920d8b4d987d98ad8b1d8a920d8aad982d8afd98520d985d8acd985d988d8b9d8a920d985d8aad986d988d8b9d8a920d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d981d98a20d983d98420d985d988d8b6d988d8b920d98ad985d983d98620d8aad8aed98ad984d98720d8aad982d8b1d98ad8a8d98bd8a72e20d985d98620d8a7d984d8a8d8b1d985d8acd8a920d988d8a7d984d8a3d8b9d985d8a7d98420d8a5d984d98920d8a7d984d8aad986d985d98ad8a920d8a7d984d8b4d8aed8b5d98ad8a920d988d8a7d984d985d987d8a7d8b1d8a7d8aa20d8a7d984d8a5d8a8d8afd8a7d8b9d98ad8a9d88c20d8aad98fd8b5d986d8b920d8afd988d8b1d8a7d8aa20d98ad988d8afd98ad985d98ad8a8d988d8a7d8b3d8b7d8a920d8aed8a8d8b1d8a7d8a120d8a7d984d8b5d986d8a7d8b9d8a920d988d8b5d985d985d8aa20d984d8aad983d988d98620d985d8aad8a7d8add8a920d984d984d985d8aad8b9d984d985d98ad98620d8b9d984d98920d8acd985d98ad8b920d8a7d984d985d8b3d8aad988d98ad8a7d8aa2e20d985d8b920d8a7d984d8aed8b5d988d985d8a7d8aa20d8a7d984d985d8aad983d8b1d8b1d8a920d988d8a7d984d988d8b5d988d98420d985d8afd98920d8a7d984d8add98ad8a7d8a920d8a5d984d98920d985d988d8a7d8af20d8a7d984d8afd988d8b1d8a9d88c20d8aad8b9d8aad8a8d8b120d98ad988d8afd98ad985d98ad8aed98ad8a7d8b1d98bd8a720d8a7d982d8aad8b5d8a7d8afd98ad98bd8a720d984d8a7d983d8aad8b3d8a7d8a820d985d987d8a7d8b1d8a7d8aa20d8acd8afd98ad8afd8a92e3c2f703e0d0a3c68343e332e20d8a3d983d8a7d8afd98ad985d98ad8a920d8aed8a7d9863c2f68343e0d0a3c703ed8a3d983d8a7d8afd98ad985d98ad8a920d8aed8a7d986d987d98a20d985d988d8b1d8af20d8aad8b9d984d98ad985d98a20d985d8acd8a7d986d98a20d98ad8b1d983d8b220d8b9d984d98920d8aad982d8afd98ad98520d985d986d987d8ac20d8b4d8a7d985d98420d984d984d8b7d984d8a7d8a820d985d98620d8acd985d98ad8b920d8a7d984d8a3d8b9d985d8a7d8b12e20d8aad988d981d8b120d8afd8b1d988d8b3d98bd8a720d8aad981d8a7d8b9d984d98ad8a920d981d98a20d985d988d8a7d8b6d98ad8b920d985d8abd98420d8a7d984d8b1d98ad8a7d8b6d98ad8a7d8aa20d988d8a7d984d8b9d984d988d98520d988d8a7d984d8a7d982d8aad8b5d8a7d8afd88c20d8a8d8a7d984d8a5d8b6d8a7d981d8a920d8a5d984d98920d8aad985d8a7d8b1d98ad98620d8b9d985d984d98ad8a920d988d981d98ad8afd98ad988d987d8a7d8aa20d8aad8b9d984d98ad985d98ad8a92e20d98ad8b3d8a7d8b9d8af20d984d988d8add8a920d8a7d984d8aad8add983d98520d8a7d984d8aad8b9d984d98ad985d98ad8a920d8a7d984d8b4d8aed8b5d98ad8a920d981d98a20d8a3d983d8a7d8afd98ad985d98ad8a920d8aed8a7d98620d8a7d984d8b7d984d8a7d8a820d8b9d984d98920d8aad8aad8a8d8b920d8aad982d8afd985d987d98520d988d8a7d984d8a8d982d8a7d8a120d985d8aad8add985d8b3d98ad986d88c20d985d985d8a720d98ad8acd8b9d984d987d8a720d8a3d8afd8a7d8a920d982d98ad985d8a920d984d983d98420d985d98620d8a7d984d8afd8b1d8a7d8b3d8a920d8a7d984d985d8afd8b1d8b3d98ad8a920d988d8a7d984d8aad8b9d984d98520d8a7d984d8b0d8a7d8aad98a2e3c2f703e0d0a3c68343e342e20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d984d98ad986d983d8afd8a5d9863c2f68343e0d0a3c703e4c696e6b6564496e204c6561726e696e67d88c20d8a7d984d985d8b9d8b1d988d98120d8b3d8a7d8a8d982d98bd8a720d8a8d8a7d8b3d985204c796e64612e636f6dd88c20d98ad982d8afd98520d985d983d8aad8a8d8a920d8b6d8aed985d8a920d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d8a7d984d8aad8b9d984d98ad985d98ad8a920d8a8d8a7d984d981d98ad8afd98ad98820d8a7d984d8aad98a20d98ad982d988d8afd987d8a720d985d8add8aad8b1d981d988d98620d981d98a20d8a7d984d8b5d986d8a7d8b9d8a92e20d8aad8b1d983d8b220d8a7d984d985d986d8b5d8a920d8b9d984d98920d8a7d984d985d987d8a7d8b1d8a7d8aa20d8a7d984d8b9d985d984d98ad8a920d988d8aad8b7d988d98ad8b120d8a7d984d985d987d8a7d8b1d8a7d8aa20d8a7d984d985d987d986d98ad8a9d88c20d985d8b920d8afd988d8b1d8a7d8aa20d8aad8bad8b7d98a20d985d988d8a7d8b6d98ad8b920d985d8abd98420d8a5d8afd8a7d8b1d8a920d8a7d984d985d8b4d8a7d8b1d98ad8b9d88c20d8aad8b7d988d98ad8b120d8a7d984d8a8d8b1d985d8acd98ad8a7d8aad88c20d988d8a7d984d982d98ad8a7d8afd8a92e20d98ad8aad983d8a7d985d984204c696e6b6564496e204c6561726e696e6720d8a3d98ad8b6d98bd8a720d985d8b920d985d984d981d98320d8a7d984d8b4d8aed8b5d98a20d8b9d984d989204c696e6b6564496ed88c20d985d985d8a720d98ad8aad98ad8ad20d984d98320d8b9d8b1d8b620d985d987d8a7d8b1d8a7d8aad98320d8a7d984d8acd8afd98ad8afd8a920d988d8b4d987d8a7d8afd8a7d8aad98320d984d8a3d8b1d8a8d8a7d8a820d8a7d984d8b9d985d98420d8a7d984d985d8add8aad985d984d98ad9862e3c2f703e0d0a3c68343e352e203c7374726f6e673e6564583c2f7374726f6e673e3c2f68343e0d0a3c703e65645820d987d98a20d985d986d8b5d8a920d8b1d8a7d8a6d8afd8a920d8a3d8aed8b1d98920d8aad982d8afd98520d8afd988d8b1d8a7d8aa20d988d8a8d8b1d8a7d985d8ac20d985d98620d8a7d984d8acd8a7d985d8b9d8a7d8aa20d988d8a7d984d985d8a4d8b3d8b3d8a7d8aa20d8a7d984d8b1d8a7d8a6d8afd8a92e20d8aad988d981d8b120d985d8acd985d988d8b9d8a920d985d98620d8a7d984d981d8b1d8b520d8a7d984d8aad8b9d984d98ad985d98ad8a9d88c20d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d8a7d984d981d8b1d8afd98ad8a920d8a5d984d98920d8a7d984d8a8d8b1d8a7d985d8ac20d8a7d984d8afd8b1d8a7d8b3d98ad8a920d8a7d984d983d8a7d985d984d8a92e20d8aad8b4d8aad987d8b12065645820d8a8d985d8b9d8a7d98ad98ad8b1d987d8a720d8a7d984d8a3d983d8a7d8afd98ad985d98ad8a920d8a7d984d8b5d8a7d8b1d985d8a920d988d8a7d987d8aad985d8a7d985d987d8a720d8a8d8aad988d981d98ad8b120d8a7d984d8aad8b9d984d98ad98520d8a7d984d985d8aad8a7d8ad20d984d984d985d8aad8b9d984d985d98ad98620d8add988d98420d8a7d984d8b9d8a7d984d9852e20d985d8b920d8aed98ad8a7d8b1d8a7d8aa20d984d984d8afd988d8b1d8a7d8aa20d8a7d984d985d8acd8a7d986d98ad8a920d988d8a7d984d985d8afd981d988d8b9d8a9d88c20d8aad986d8a7d8b3d8a82065645820d985d8acd985d988d8b9d8a920d985d8aad986d988d8b9d8a920d985d98620d8a7d8add8aad98ad8a7d8acd8a7d8aa20d8a7d984d8aad8b9d984d9852e3c2f703e0d0a3c68333e3c7374726f6e673ed8a7d984d8aed8a7d8aad985d8a93c2f7374726f6e673e3c2f68333e0d0a3c703ed984d982d8af20d8a3d8add8afd8ab20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa20d8abd988d8b1d8a920d981d98a20d8a7d984d8aad8b9d984d98ad98520d985d98620d8aed984d8a7d98420d8acd8b9d98420d8a7d984d985d988d8a7d8b1d8af20d8b9d8a7d984d98ad8a920d8a7d984d8acd988d8afd8a920d985d8aad8a7d8add8a920d984d8a3d98a20d8b4d8aed8b520d984d8afd98ad98720d8a7d8aad8b5d8a7d98420d8a8d8a7d984d8a5d986d8aad8b1d986d8aa2e20d8b3d988d8a7d8a120d983d986d8aa20d8b7d8a7d984d8a8d98bd8a720d8aad8b3d8b9d98920d984d984d8aad981d988d98220d981d98a20d8afd8b1d8a7d8b3d8aad98320d8a3d98820d985d8add8aad8b1d981d98bd8a720d98ad8aad8b7d984d8b920d8a5d984d98920d8aad8b9d8b2d98ad8b220d985d987d8a7d8b1d8a7d8aad987d88c20d8aad988d981d8b120d985d986d8b5d8a7d8aa20d985d8abd98420436f75727365726120d9885564656d7920d9884b68616e2041636164656d7920d9884c696e6b6564496e204c6561726e696e6720d98865645820d981d8b1d8b5d98bd8a720d982d98ad985d8a920d984d984d986d985d98820d988d8a7d984d8aad8b7d988d8b12e20d8a7d8b3d8aad8bad98420d982d988d8a920d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa20d988d8a7d8aad8aed8b020d8a7d984d8aed8b7d988d8a920d8a7d984d8aad8a7d984d98ad8a920d981d98a20d8b1d8add984d8aad98320d8a7d984d8aad8b9d984d98ad985d98ad8a920d985d8b920d987d8b0d98720d8a7d984d985d988d8a7d8b1d8af20d8a7d984d8b1d8a7d8a6d8afd8a92e3c2f703e, NULL, NULL, '2024-08-27 06:08:31', '2024-08-29 05:20:47'),
(55, 20, 54, 30, 'Essential Tips and Strategies for Achieving Success and Advancing Your Career', 'essential-tips-and-strategies-for-achieving-success-and-advancing-your-career', 'Tom', 0x3c703e496e20746f646179277320636f6d7065746974697665206a6f62206d61726b65742c207374616e64696e67206f757420616e6420616476616e63696e6720696e20796f757220636172656572207265717569726573206d6f7265207468616e206a757374206861726420776f726b2e20497420696e766f6c7665732073747261746567696320706c616e6e696e672c20636f6e74696e756f7573206c6561726e696e672c20616e6420656666656374697665206e6574776f726b696e672e205768657468657220796f75277265206a757374207374617274696e67206f7574206f72206c6f6f6b696e6720746f20636c696d6220746865206c61646465722c20686572652061726520736f6d6520657373656e7469616c207469707320666f7220616368696576696e672070726f66657373696f6e616c207375636365737320616e64207265616368696e6720796f75722063617265657220676f616c732e3c2f703e0d0a3c68343e312e203c7374726f6e673e53657420436c6561722043617265657220476f616c733c2f7374726f6e673e3c2f68343e0d0a3c703e546f206163686965766520737563636573732c20796f75206e656564206120726f61646d61702e2053657474696e6720636c6561722c2061636869657661626c652063617265657220676f616c732068656c707320796f7520666f63757320796f7572206566666f72747320616e64206d65617375726520796f75722070726f67726573732e20537461727420627920646566696e696e6720626f74682073686f72742d7465726d20616e64206c6f6e672d7465726d206f626a656374697665732e20427265616b207468656d20646f776e20696e746f20616374696f6e61626c6520737465707320616e6420726567756c61726c792072657669657720616e642061646a75737420796f757220676f616c73206173206e65656465642e205468697320617070726f616368206b6565707320796f75206d6f7469766174656420616e64206f6e20747261636b20746f206163686965766520796f7572206361726565722061737069726174696f6e732e3c2f703e0d0a3c68343e322e203c7374726f6e673e436f6e74696e756f75736c7920496d70726f766520596f757220536b696c6c733c2f7374726f6e673e3c2f68343e0d0a3c703e546865206a6f62206d61726b657420697320636f6e7374616e746c792065766f6c76696e672c20616e6420736f2073686f756c6420796f757220736b696c6c7365742e20496e7665737420696e206f6e676f696e6720656475636174696f6e20616e642070726f66657373696f6e616c20646576656c6f706d656e7420746f20737461792072656c6576616e7420696e20796f7572206669656c642e2054616b6520616476616e74616765206f66206f6e6c696e6520636f75727365732c20776f726b73686f70732c20616e642063657274696669636174696f6e73207468617420656e68616e636520796f7572206b6e6f776c6564676520616e6420736b696c6c732e2053746179696e672075706461746564207769746820696e647573747279207472656e647320616e6420616371756972696e67206e657720636f6d706574656e636965732077696c6c206d616b6520796f75206d6f72652076616c7561626c6520746f20656d706c6f7965727320616e64206f70656e207570206e6577206f70706f7274756e69746965732e3c2f703e0d0a3c68343e332e203c7374726f6e673e4275696c642061205374726f6e672050726f66657373696f6e616c204e6574776f726b3c2f7374726f6e673e3c2f68343e0d0a3c703e4e6574776f726b696e67206973206372756369616c20666f722063617265657220616476616e63656d656e742e204275696c6420616e64206d61696e7461696e2072656c6174696f6e7368697073207769746820636f6c6c6561677565732c206d656e746f72732c20616e6420696e6475737472792070726f66657373696f6e616c732e20417474656e6420696e647573747279206576656e74732c206a6f696e2070726f66657373696f6e616c206f7267616e697a6174696f6e732c20616e6420656e67616765206f6e20706c6174666f726d73206c696b65204c696e6b6564496e2e2041207374726f6e67206e6574776f726b2063616e2070726f766964652076616c7561626c65206164766963652c206a6f62206c656164732c20616e6420636172656572206f70706f7274756e69746965732c20616e6420616c736f206b65657020796f7520696e666f726d65642061626f757420696e647573747279207472656e647320616e64206368616e6765732e3c2f703e0d0a3c68343e342e203c7374726f6e673e5365656b20466565646261636b20616e6420416374206f6e2049743c2f7374726f6e673e3c2f68343e0d0a3c703e436f6e73747275637469766520666565646261636b20697320657373656e7469616c20666f722067726f7774682e20526567756c61726c79207365656b20666565646261636b2066726f6d2073757065727669736f72732c2070656572732c20616e64206d656e746f727320746f20756e6465727374616e6420796f757220737472656e6774687320616e6420617265617320666f7220696d70726f76656d656e742e20557365207468697320666565646261636b20746f206d616b65206e65636573736172792061646a7573746d656e747320616e6420696d70726f766520796f757220706572666f726d616e63652e2044656d6f6e7374726174696e6720612077696c6c696e676e65737320746f206c6561726e20616e642067726f772066726f6d20666565646261636b2073686f777320796f757220636f6d6d69746d656e7420746f20706572736f6e616c20616e642070726f66657373696f6e616c20646576656c6f706d656e742e3c2f703e0d0a3c68343e352e203c7374726f6e673e4d61696e7461696e206120576f726b2d4c6966652042616c616e63653c2f7374726f6e673e3c2f68343e0d0a3c703e41207375636365737366756c206361726565722073686f756c64206e6f7420636f6d652061742074686520657870656e7365206f6620796f75722077656c6c2d6265696e672e2053747269766520746f206d61696e7461696e2061206865616c74687920776f726b2d6c6966652062616c616e63652062792073657474696e6720626f756e646172696573206265747765656e20776f726b20616e6420706572736f6e616c206c6966652e205072696f726974697a652073656c662d636172652c206d616e61676520737472657373206566666563746976656c792c20616e64206d616b652074696d6520666f72206163746976697469657320796f7520656e6a6f792e20412062616c616e636564206c69666520656e68616e6365732070726f6475637469766974792c206a6f6220736174697366616374696f6e2c20616e64206f766572616c6c2068617070696e6573732e3c2f703e0d0a3c68343e362e203c7374726f6e673e446576656c6f70205374726f6e6720436f6d6d756e69636174696f6e20536b696c6c733c2f7374726f6e673e3c2f68343e0d0a3c703e45666665637469766520636f6d6d756e69636174696f6e206973206b657920746f2070726f66657373696f6e616c20737563636573732e20576f726b206f6e20696d70726f76696e6720626f746820796f75722076657262616c20616e64207772697474656e20636f6d6d756e69636174696f6e20736b696c6c732e204265696e672061626c6520746f20636c6561726c79206578707265737320796f75722069646561732c206c697374656e206163746976656c792c20616e6420636f6c6c61626f726174652077697468206f74686572732077696c6c20656e68616e636520796f7572206162696c69747920746f20776f726b206566666563746976656c7920696e207465616d7320616e64206275696c64207374726f6e672070726f66657373696f6e616c2072656c6174696f6e73686970732e3c2f703e0d0a3c68343e372e203c7374726f6e673e42652050726f61637469766520616e642054616b6520496e69746961746976653c2f7374726f6e673e3c2f68343e0d0a3c703e446f6ee2809974207761697420666f72206f70706f7274756e697469657320746f20636f6d6520746f20796f75e28094637265617465207468656d2e2042652070726f61637469766520696e207365656b696e67206f7574206e65772070726f6a656374732c2070726f706f73696e6720696d70726f76656d656e74732c20616e6420766f6c756e74656572696e6720666f72206164646974696f6e616c20726573706f6e736962696c69746965732e2054616b696e6720696e69746961746976652064656d6f6e7374726174657320796f757220636f6d6d69746d656e742c20616d626974696f6e2c20616e642072656164696e65737320746f20636f6e7472696275746520746f20796f7572206f7267616e697a6174696f6ee280997320737563636573732e3c2f703e0d0a3c68333e3c7374726f6e673e436f6e636c7573696f6e3c2f7374726f6e673e3c2f68333e0d0a3c703e416368696576696e67206361726565722073756363657373207265717569726573206120636f6d62696e6174696f6e206f662073747261746567696320706c616e6e696e672c20636f6e74696e756f757320696d70726f76656d656e742c20616e6420656666656374697665206e6574776f726b696e672e2042792073657474696e6720636c65617220676f616c732c20696d70726f76696e6720796f757220736b696c6c732c206275696c64696e672061207374726f6e67206e6574776f726b2c207365656b696e6720666565646261636b2c206d61696e7461696e696e672062616c616e63652c20646576656c6f70696e6720636f6d6d756e69636174696f6e20736b696c6c732c20616e642074616b696e6720696e69746961746976652c20796f752063616e2070617665207468652077617920666f722070726f66657373696f6e616c2067726f77746820616e6420726561636820796f7572206361726565722061737069726174696f6e732e20456d6272616365207468657365207469707320616e642074616b6520636861726765206f6620796f757220636172656572206a6f75726e657920746f20756e6c6f636b20796f75722066756c6c20706f74656e7469616c2e3c2f703e, NULL, NULL, '2024-08-27 06:11:22', '2024-08-29 05:15:02');
INSERT INTO `blog_informations` (`id`, `language_id`, `blog_category_id`, `blog_id`, `title`, `slug`, `author`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(56, 21, 58, 30, 'نصائح واستراتيجيات أساسية لتحقيق النجاح والتقدم في حياتك المهنية', 'نصائح-واستراتيجيات-أساسية-لتحقيق-النجاح-والتقدم-في-حياتك-المهنية', 'توم', 0x3c703ed981d98a20d8b3d988d98220d8a7d984d8b9d985d98420d8a7d984d8aad986d8a7d981d8b3d98a20d8a7d984d98ad988d985d88c20d98ad8aad8b7d984d8a820d8a7d984d8aad985d98ad8b220d988d8a7d984d8aad982d8afd98520d981d98a20d985d8b3d98ad8b1d8aad98320d8a7d984d985d987d986d98ad8a920d8a3d983d8abd8b120d985d98620d985d8acd8b1d8af20d8a7d984d8b9d985d98420d8a7d984d8acd8a7d8af2e20d98ad8aad8b6d985d98620d8b0d984d98320d8a7d984d8aad8aed8b7d98ad8b720d8a7d984d8a7d8b3d8aad8b1d8a7d8aad98ad8acd98ad88c20d8a7d984d8aad8b9d984d98520d8a7d984d985d8b3d8aad985d8b1d88c20d988d8a7d984d8aad988d8a7d8b5d98420d8a7d984d981d8b9d8a7d9842e20d8b3d988d8a7d8a120d983d986d8aa20d981d98a20d8a8d8afd8a7d98ad8a920d985d8b4d988d8a7d8b1d98320d8a3d98820d8aad8b3d8b9d98920d984d984d8aad8b1d982d98ad88c20d8a5d984d98ad98320d8a8d8b9d8b620d8a7d984d986d8b5d8a7d8a6d8ad20d8a7d984d8a3d8b3d8a7d8b3d98ad8a920d984d8aad8add982d98ad98220d8a7d984d986d8acd8a7d8ad20d8a7d984d985d987d986d98a20d988d8a7d984d988d8b5d988d98420d8a5d984d98920d8a3d987d8afd8a7d981d98320d8a7d984d985d987d986d98ad8a92e3c2f703e0d0a3c68343e312e203c7374726f6e673ed8add8afd8af20d8a3d987d8afd8a7d981d98bd8a720d985d987d986d98ad8a920d988d8a7d8b6d8add8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed984d8aad8add982d98ad98220d8a7d984d986d8acd8a7d8add88c20d8aad8add8aad8a7d8ac20d8a5d984d98920d8aed8b1d98ad8b7d8a920d8b7d8b1d98ad9822e20d98ad8b3d8a7d8b9d8afd98320d8aad8add8afd98ad8af20d8a3d987d8afd8a7d98120d985d987d986d98ad8a920d988d8a7d8b6d8add8a920d988d982d8a7d8a8d984d8a920d984d984d8aad8add982d98ad98220d8b9d984d98920d8aad8b1d983d98ad8b220d8acd987d988d8afd98320d988d982d98ad8a7d8b320d8aad982d8afd985d9832e20d8a7d8a8d8afd8a320d8a8d8aad8b9d8b1d98ad98120d8a7d984d8a3d987d8afd8a7d98120d8a7d984d982d8b5d98ad8b1d8a920d988d8a7d984d8b7d988d98ad984d8a920d8a7d984d8a3d8acd9842e20d982d98520d8a8d8aad982d8b3d98ad985d987d8a720d8a5d984d98920d8aed8b7d988d8a7d8aa20d8b9d985d984d98ad8a920d988d8b1d8a7d8acd8b920d8a3d987d8afd8a7d981d98320d8a8d8a7d986d8aad8b8d8a7d98520d988d982d98520d8a8d8aad8b9d8afd98ad984d987d8a720d8add8b3d8a820d8a7d984d8add8a7d8acd8a92e20d98ad8b3d8a7d8b9d8afd98320d987d8b0d8a720d8a7d984d986d987d8ac20d8b9d984d98920d8a7d984d8a8d982d8a7d8a120d985d8aad8add981d8b2d98bd8a720d988d8b9d984d98920d8a7d984d985d8b3d8a7d8b120d8a7d984d8b5d8add98ad8ad20d984d8aad8add982d98ad98220d8b7d985d988d8add8a7d8aad98320d8a7d984d985d987d986d98ad8a92e3c2f703e0d0a3c68343e322e203c7374726f6e673ed8add8b3d98620d985d987d8a7d8b1d8a7d8aad98320d8a8d8a7d8b3d8aad985d8b1d8a7d8b13c2f7374726f6e673e3c2f68343e0d0a3c703ed8b3d988d98220d8a7d984d8b9d985d98420d98ad8aad8b7d988d8b120d8a8d8a7d8b3d8aad985d8b1d8a7d8b1d88c20d988d98ad986d8a8d8bad98a20d8a3d98620d8aad8aad8b7d988d8b120d985d987d8a7d8b1d8a7d8aad98320d8a3d98ad8b6d98bd8a72e20d8a7d8b3d8aad8abd985d8b120d981d98a20d8a7d984d8aad8b9d984d98ad98520d988d8a7d984d8aad8b7d988d98ad8b120d8a7d984d985d987d986d98a20d8a7d984d985d8b3d8aad985d8b120d984d984d8a8d982d8a7d8a120d8b9d984d98920d8b5d984d8a920d8a8d985d8acd8a7d984d9832e20d8a7d8b3d8aad981d8af20d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d8a7d984d8aad8afd8b1d98ad8a8d98ad8a920d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aad88c20d988d988d8b1d8b420d8a7d984d8b9d985d984d88c20d988d8a7d984d8b4d987d8a7d8afd8a7d8aa20d8a7d984d8aad98a20d8aad8b9d8b2d8b220d985d8b9d8b1d981d8aad98320d988d985d987d8a7d8b1d8a7d8aad9832e20d8a7d984d8a8d982d8a7d8a120d8b9d984d98920d8a7d8b7d984d8a7d8b920d8a8d8a7d8aad8acd8a7d987d8a7d8aa20d8a7d984d8b5d986d8a7d8b9d8a920d988d8a7d983d8aad8b3d8a7d8a820d985d987d8a7d8b1d8a7d8aa20d8acd8afd98ad8afd8a920d8b3d98ad8acd8b9d98420d985d986d98320d982d98ad985d8a920d985d8b6d8a7d981d8a920d984d8a3d8b5d8add8a7d8a820d8a7d984d8b9d985d98420d988d98ad981d8aad8ad20d984d98320d8a3d8a8d988d8a7d8a820d8a7d984d981d8b1d8b520d8a7d984d8acd8afd98ad8afd8a92e3c2f703e0d0a3c68343e332e203c7374726f6e673ed8a8d986d8a7d8a120d8b4d8a8d983d8a920d985d987d986d98ad8a920d982d988d98ad8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8aad988d8a7d8b5d98420d8a3d985d8b120d8add8a7d8b3d98520d984d984d8aad982d8afd98520d8a7d984d985d987d986d98a2e20d982d98520d8a8d8a8d986d8a7d8a120d988d8a7d984d8add981d8a7d8b820d8b9d984d98920d8b9d984d8a7d982d8a7d8aa20d985d8b920d8a7d984d8b2d985d984d8a7d8a1d88c20d988d8a7d984d985d8b1d8b4d8afd98ad986d88c20d988d8a7d984d985d8add8aad8b1d981d98ad98620d981d98a20d985d8acd8a7d984d9832e20d8a7d8add8b6d8b120d8a7d984d981d8b9d8a7d984d98ad8a7d8aa20d8a7d984d8b5d986d8a7d8b9d98ad8a9d88c20d988d8a7d986d8b6d98520d8a5d984d98920d8a7d984d985d986d8b8d985d8a7d8aa20d8a7d984d985d987d986d98ad8a9d88c20d988d8b4d8a7d8b1d98320d8b9d984d98920d985d986d8b5d8a7d8aa20d985d8abd984204c696e6b6564496e2e20d98ad985d983d98620d8a3d98620d8aad988d981d8b120d984d98320d8b4d8a8d983d8a920d982d988d98ad8a920d986d8b5d8a7d8a6d8ad20d982d98ad985d8a9d88c20d988d981d8b1d8b520d8b9d985d984d88c20d988d8a7d8b7d984d8a7d8b920d8b9d984d98920d8a7d8aad8acd8a7d987d8a7d8aa20d988d8aad8bad98ad8b1d8a7d8aa20d8a7d984d8b5d986d8a7d8b9d8a92e3c2f703e0d0a3c68343e342e203c7374726f6e673ed8a7d8b7d984d8a820d8a7d984d8aad8b9d984d98ad982d8a7d8aa20d988d8a7d8a8d8afd8a320d981d98a20d8a7d984d8b9d985d98420d8a8d987d8a73c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8aad8b9d984d98ad982d8a7d8aa20d8a7d984d8a8d986d8a7d8a1d8a920d8a3d8b3d8a7d8b3d98ad8a920d984d984d986d985d9882e20d8a7d8b7d984d8a820d8a8d8a7d986d8aad8b8d8a7d98520d8aad8b9d984d98ad982d8a7d8aa20d985d98620d8a7d984d985d8b4d8b1d981d98ad986d88c20d988d8a7d984d8b2d985d984d8a7d8a1d88c20d988d8a7d984d985d8b1d8b4d8afd98ad98620d984d981d987d98520d986d982d8a7d8b720d982d988d8aad98320d988d985d8acd8a7d984d8a7d8aa20d8aad8add8b3d98ad986d9832e20d8a7d8b3d8aad8aed8afd98520d987d8b0d98720d8a7d984d8aad8b9d984d98ad982d8a7d8aa20d984d8a5d8acd8b1d8a7d8a120d8a7d984d8aad8b9d8afd98ad984d8a7d8aa20d8a7d984d984d8a7d8b2d985d8a920d988d8aad8add8b3d98ad98620d8a3d8afd8a7d8a6d9832e20d8a5d8b8d987d8a7d8b120d8a7d984d8a7d8b3d8aad8b9d8afd8a7d8af20d984d984d8aad8b9d984d98520d988d8a7d984d986d985d98820d985d98620d8a7d984d8aad8b9d984d98ad982d8a7d8aa20d98ad8b8d987d8b120d8a7d984d8aad8b2d8a7d985d98320d8a8d8a7d984d8aad8b7d988d8b120d8a7d984d8b4d8aed8b5d98a20d988d8a7d984d985d987d986d98a2e3c2f703e0d0a3c68343e352e203c7374726f6e673ed8add8a7d981d8b820d8b9d984d98920d8aad988d8a7d8b2d98620d8a8d98ad98620d8a7d984d8b9d985d98420d988d8a7d984d8add98ad8a7d8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed98ad8acd8a820d8a3d984d8a720d98ad8a3d8aad98a20d8a7d984d986d8acd8a7d8ad20d8a7d984d985d987d986d98a20d8b9d984d98920d8add8b3d8a7d8a820d8b1d981d8a7d987d98ad8aad9832e20d8add8a7d988d98420d8a7d984d8add981d8a7d8b820d8b9d984d98920d8aad988d8a7d8b2d98620d8b5d8add98a20d8a8d98ad98620d8a7d984d8b9d985d98420d988d8a7d984d8add98ad8a7d8a920d8a7d984d8b4d8aed8b5d98ad8a920d985d98620d8aed984d8a7d98420d988d8b6d8b920d8add8afd988d8af20d8a8d98ad98620d8a7d984d8b9d985d98420d988d8a7d984d8add98ad8a7d8a920d8a7d984d8b4d8aed8b5d98ad8a92e20d982d98520d8a8d8a5d8b9d8b7d8a7d8a120d8a7d984d8a3d988d984d988d98ad8a920d984d984d8b9d986d8a7d98ad8a920d8a7d984d8b0d8a7d8aad98ad8a9d88c20d8a5d8afd8a7d8b1d8a920d8a7d984d8aad988d8aad8b120d8a8d981d8b9d8a7d984d98ad8a9d88c20d988d8aad8aed8b5d98ad8b520d988d982d8aa20d984d984d8a3d986d8b4d8b7d8a920d8a7d984d8aad98a20d8aad8b3d8aad985d8aad8b920d8a8d987d8a72e20d8a7d984d8add98ad8a7d8a920d8a7d984d985d8aad988d8a7d8b2d986d8a920d8aad8b9d8b2d8b220d8a7d984d8a5d986d8aad8a7d8acd98ad8a9d88c20d988d8b1d8b6d8a720d8a7d984d8b9d985d984d88c20d988d8a7d984d8b3d8b9d8a7d8afd8a920d8a7d984d8b9d8a7d985d8a92e3c2f703e0d0a3c68343e362e203c7374726f6e673ed8b7d988d8b120d985d987d8a7d8b1d8a7d8aad98320d981d98a20d8a7d984d8aad988d8a7d8b5d9843c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8aad988d8a7d8b5d98420d8a7d984d981d8b9d8a7d98420d987d98820d985d981d8aad8a7d8ad20d8a7d984d986d8acd8a7d8ad20d8a7d984d985d987d986d98a2e20d8a7d8b9d985d98420d8b9d984d98920d8aad8add8b3d98ad98620d985d987d8a7d8b1d8a7d8aad98320d981d98a20d8a7d984d8aad988d8a7d8b5d98420d8a7d984d984d981d8b8d98a20d988d8a7d984d983d8aad8a7d8a8d98a2e20d8a7d984d982d8afd8b1d8a920d8b9d984d98920d8a7d984d8aad8b9d8a8d98ad8b120d8a8d988d8b6d988d8ad20d8b9d98620d8a3d981d983d8a7d8b1d983d88c20d8a7d984d8a7d8b3d8aad985d8a7d8b920d8a7d984d986d8b4d8b7d88c20d988d8a7d984d8aad8b9d8a7d988d98620d985d8b920d8a7d984d8a2d8aed8b1d98ad98620d8b3d8aad8add8b3d98620d982d8afd8b1d8aad98320d8b9d984d98920d8a7d984d8b9d985d98420d8a8d981d8b9d8a7d984d98ad8a920d981d98a20d8a7d984d981d8b1d98220d988d8a8d986d8a7d8a120d8b9d984d8a7d982d8a7d8aa20d985d987d986d98ad8a920d982d988d98ad8a92e3c2f703e0d0a3c68343e372e203c7374726f6e673ed983d98620d985d8a8d8a7d8afd8b1d98bd8a720d988d8a7d8a8d8afd8a320d8a8d8a7d984d8aad8add8b1d9833c2f7374726f6e673e3c2f68343e0d0a3c703ed984d8a720d8aad986d8aad8b8d8b120d8a7d984d981d8b1d8b520d984d8aad8a3d8aad98a20d8a5d984d98ad983e28094d982d98520d8a8d8a5d986d8b4d8a7d8a6d987d8a72e20d983d98620d985d8a8d8a7d8afd8b1d98bd8a720d981d98a20d8a7d984d8a8d8add8ab20d8b9d98620d985d8b4d8a7d8b1d98ad8b920d8acd8afd98ad8afd8a9d88c20d988d8a7d982d8aad8b1d8ad20d8aad8add8b3d98ad986d8a7d8aad88c20d988d8aad8b7d988d8b920d984d985d987d8a7d98520d8a5d8b6d8a7d981d98ad8a92e20d98ad8b8d987d8b120d8a7d8aad8aed8a7d8b020d8a7d984d985d8a8d8a7d8afd8b1d8a920d8a7d984d8aad8b2d8a7d985d98320d988d8b7d985d988d8add98320d988d8a7d8b3d8aad8b9d8afd8a7d8afd98320d984d984d985d8b3d8a7d987d985d8a920d981d98a20d986d8acd8a7d8ad20d985d8a4d8b3d8b3d8aad9832e3c2f703e0d0a3c68333e3c7374726f6e673ed8a7d984d8aed8a7d8aad985d8a93c2f7374726f6e673e3c2f68333e0d0a3c703ed98ad8aad8b7d984d8a820d8aad8add982d98ad98220d8a7d984d986d8acd8a7d8ad20d8a7d984d985d987d986d98a20d985d8b2d98ad8acd98bd8a720d985d98620d8a7d984d8aad8aed8b7d98ad8b720d8a7d984d8a7d8b3d8aad8b1d8a7d8aad98ad8acd98ad88c20d8a7d984d8aad8add8b3d98ad98620d8a7d984d985d8b3d8aad985d8b1d88c20d988d8a7d984d8aad988d8a7d8b5d98420d8a7d984d981d8b9d8a7d9842e20d985d98620d8aed984d8a7d98420d8aad8add8afd98ad8af20d8a3d987d8afd8a7d98120d988d8a7d8b6d8add8a9d88c20d8aad8add8b3d98ad98620d985d987d8a7d8b1d8a7d8aad983d88c20d8a8d986d8a7d8a120d8b4d8a8d983d8a920d982d988d98ad8a9d88c20d8b7d984d8a820d8a7d984d8aad8b9d984d98ad982d8a7d8aad88c20d8a7d984d8add981d8a7d8b820d8b9d984d98920d8a7d984d8aad988d8a7d8b2d986d88c20d8aad8b7d988d98ad8b120d985d987d8a7d8b1d8a7d8aa20d8a7d984d8aad988d8a7d8b5d984d88c20d988d8a7d8aad8aed8a7d8b020d8a7d984d985d8a8d8a7d8afd8b1d8a9d88c20d98ad985d983d986d98320d8aad985d987d98ad8af20d8a7d984d8b7d8b1d98ad98220d984d984d986d985d98820d8a7d984d985d987d986d98a20d988d8a7d984d988d8b5d988d98420d8a5d984d98920d8b7d985d988d8add8a7d8aad98320d8a7d984d985d987d986d98ad8a92e20d8a7d8add8aad8b6d98620d987d8b0d98720d8a7d984d986d8b5d8a7d8a6d8ad20d988d983d98620d982d8a7d8a6d8afd98bd8a720d981d98a20d8b1d8add984d8aad98320d8a7d984d985d987d986d98ad8a920d984d981d8aad8ad20d8a5d985d983d8a7d986d98ad8a7d8aad98320d8a8d8a7d984d983d8a7d985d9842e3c2f703e, NULL, NULL, '2024-08-27 06:11:22', '2024-08-29 05:15:02'),
(57, 20, 51, 31, 'Unlocking the Secrets to a Balanced and Healthy Lifestyle: A Comprehensive Guide to Achieving Harmony and Wellness in Your Daily Life', 'unlocking-the-secrets-to-a-balanced-and-healthy-lifestyle:-a-comprehensive-guide-to-achieving-harmony-and-wellness-in-your-daily-life', 'Tom', 0x3c703e4d61696e7461696e696e672061206865616c746879206c6966657374796c65206973206372756369616c20666f7220626f746820706879736963616c20616e64206d656e74616c2077656c6c2d6265696e672e2057697468207468652064656d616e6473206f66206d6f6465726e206c6966652c2069742773206561737920746f206f7665726c6f6f6b206f7572206865616c74682c20627574206d616b696e6720736d616c6c2c20636f6e73697374656e74206368616e6765732063616e206c65616420746f207369676e69666963616e7420696d70726f76656d656e74732e20486572652061726520736f6d6520657373656e7469616c207469707320746f2068656c7020796f75207072696f726974697a6520796f75722077656c6c2d6265696e6720616e64206c6976652061206865616c74686965722c206d6f72652062616c616e636564206c6966652e3c2f703e0d0a3c68343e312e203c7374726f6e673e537461792048796472617465643c2f7374726f6e673e3c2f68343e0d0a3c703e576174657220697320766974616c20666f72206d61696e7461696e696e6720626f64696c792066756e6374696f6e7320616e64206f766572616c6c206865616c74682e2041696d20746f206472696e6b206174206c65617374203820676c6173736573206f6620776174657220612064617920746f206b6565702068796472617465642e2050726f70657220687964726174696f6e20737570706f72747320646967657374696f6e2c20696d70726f76657320736b696e206865616c74682c20616e6420626f6f73747320656e65726779206c6576656c732e2043617272792061207265757361626c6520776174657220626f74746c65207769746820796f7520746f20656e7375726520796f752073746179206879647261746564207468726f7567686f757420746865206461792e3c2f703e0d0a3c68343e322e203c7374726f6e673e45617420612042616c616e63656420446965743c2f7374726f6e673e3c2f68343e0d0a3c703e41206e7574726974696f757320646965742069732074686520666f756e646174696f6e206f6620676f6f64206865616c74682e20466f637573206f6e20656174696e6720612076617269657479206f66206672756974732c20766567657461626c65732c2077686f6c6520677261696e732c206c65616e2070726f7465696e732c20616e64206865616c74687920666174732e2041766f69642065786365737369766520636f6e73756d7074696f6e206f662070726f63657373656420666f6f64732c2073756761727920736e61636b732c20616e6420686967682d666174206d65616c732e2042616c616e63656420656174696e672070726f76696465732074686520657373656e7469616c206e75747269656e747320796f757220626f6479206e6565647320746f2066756e6374696f6e206f7074696d616c6c7920616e642068656c70732070726576656e74206368726f6e69632064697365617365732e3c2f703e0d0a3c68343e332e203c7374726f6e673e47657420526567756c61722045786572636973653c2f7374726f6e673e3c2f68343e0d0a3c703e506879736963616c206163746976697479206973206372756369616c20666f72206d61696e7461696e696e672061206865616c74687920626f647920616e64206d696e642e2041696d20666f72206174206c6561737420313530206d696e75746573206f66206d6f6465726174652d696e74656e7369747920657865726369736520706572207765656b2c207375636820617320627269736b2077616c6b696e672c206379636c696e672c206f72207377696d6d696e672e20526567756c61722065786572636973652068656c7073206d616e616765207765696768742c20696d70726f76652063617264696f76617363756c6172206865616c74682c20616e6420626f6f7374206d656e74616c2077656c6c2d6265696e672e2046696e6420616e20616374697669747920796f7520656e6a6f7920616e64206d616b65206974206120726567756c61722070617274206f6620796f757220726f7574696e652e3c2f703e0d0a3c68343e342e203c7374726f6e673e5072696f726974697a65204d656e74616c204865616c74683c2f7374726f6e673e3c2f68343e0d0a3c703e4d656e74616c2077656c6c2d6265696e67206973206a75737420617320696d706f7274616e7420617320706879736963616c206865616c74682e20507261637469636520737472657373206d616e6167656d656e7420746563686e69717565732073756368206173206d696e6466756c6e6573732c206d656469746174696f6e2c20616e64206465657020627265617468696e67206578657263697365732e2054616b652074696d6520746f2072656c61782c20656e6761676520696e20686f62626965732c20616e64207370656e64207175616c6974792074696d652077697468206c6f766564206f6e65732e20496620796f75277265207374727567676c696e672077697468206d656e74616c206865616c7468206973737565732c207365656b20737570706f72742066726f6d2061206d656e74616c206865616c74682070726f66657373696f6e616c2e3c2f703e0d0a3c68343e352e203c7374726f6e673e47657420456e6f75676820536c6565703c2f7374726f6e673e3c2f68343e0d0a3c703e416465717561746520736c65657020697320657373656e7469616c20666f72206f766572616c6c206865616c746820616e642077656c6c2d6265696e672e2041696d20666f7220372d3920686f757273206f66207175616c69747920736c65657020706572206e696768742e204372656174652061207265737466756c20656e7669726f6e6d656e74206279206b656570696e6720796f757220626564726f6f6d20636f6f6c2c206461726b2c20616e642071756965742e2045737461626c697368206120726567756c617220736c656570207363686564756c6520616e642061766f69642073637265656e73206265666f72652062656474696d6520746f20696d70726f766520736c656570207175616c6974792e3c2f703e0d0a3c68343e362e203c7374726f6e673e507261637469636520476f6f642048796769656e653c2f7374726f6e673e3c2f68343e0d0a3c703e4d61696e7461696e696e6720676f6f642068796769656e6520697320766974616c20666f722070726576656e74696e6720696c6c6e65737320616e642070726f6d6f74696e67206865616c74682e205761736820796f75722068616e647320726567756c61726c792c20627275736820616e6420666c6f737320796f7572207465657468206461696c792c20616e64206b65657020796f7572206c6976696e6720656e7669726f6e6d656e7420636c65616e2e20476f6f642068796769656e65207072616374696365732072656475636520746865207269736b206f6620696e66656374696f6e7320616e6420636f6e7472696275746520746f206f766572616c6c2077656c6c2d6265696e672e3c2f703e0d0a3c68343e372e203c7374726f6e673e5374617920436f6e6e65637465643c2f7374726f6e673e3c2f68343e0d0a3c703e536f6369616c20636f6e6e656374696f6e7320706c61792061207369676e69666963616e7420726f6c6520696e206d61696e7461696e696e67206d656e74616c206865616c746820616e64206f766572616c6c2068617070696e6573732e204d616b6520616e206566666f727420746f207374617920636f6e6e6563746564207769746820667269656e647320616e642066616d696c792c206576656e2069662069742773207468726f756768207669727475616c206d65616e732e204275696c64696e6720616e64206e7572747572696e672072656c6174696f6e73686970732070726f7669646520656d6f74696f6e616c20737570706f727420616e6420636f6e7472696275746520746f20612073656e7365206f662062656c6f6e67696e672e3c2f703e0d0a3c68333e3c7374726f6e673e436f6e636c7573696f6e3c2f7374726f6e673e3c2f68333e0d0a3c703e5072696f726974697a696e6720796f75722077656c6c2d6265696e6720696e766f6c7665732074616b696e672063617265206f6620626f746820796f757220706879736963616c20616e64206d656e74616c206865616c74682e2042792073746179696e672068796472617465642c20656174696e6720612062616c616e63656420646965742c2067657474696e6720726567756c61722065786572636973652c206d616e6167696e67207374726573732c2067657474696e6720656e6f75676820736c6565702c2070726163746963696e6720676f6f642068796769656e652c20616e642073746179696e6720636f6e6e65637465642077697468206f74686572732c20796f752063616e206c6561642061206865616c74686965722c206d6f72652066756c66696c6c696e67206c6966652e204d616b6520746865736520746970732070617274206f6620796f7572206461696c7920726f7574696e6520616e6420657870657269656e63652074686520706f73697469766520696d70616374206f6e20796f7572206f766572616c6c2077656c6c2d6265696e672e3c2f703e, NULL, NULL, '2024-08-27 06:14:58', '2024-08-29 05:14:21'),
(58, 21, 55, 31, 'اكتشاف أسرار أسلوب حياة متوازن وصحي: دليل شامل لتحقيق الانسجام والعافية في حياتك اليومية', 'اكتشاف-أسرار-أسلوب-حياة-متوازن-وصحي:-دليل-شامل-لتحقيق-الانسجام-والعافية-في-حياتك-اليومية', 'توم', 0x3c703ed8a7d984d8add981d8a7d8b820d8b9d984d98920d986d985d8b720d8add98ad8a7d8a920d8b5d8add98a20d8a3d985d8b120d8add8a7d8b3d98520d984d984d8b5d8add8a920d8a7d984d8a8d8afd986d98ad8a920d988d8a7d984d8b9d982d984d98ad8a92e20d985d8b920d985d8aad8b7d984d8a8d8a7d8aa20d8a7d984d8add98ad8a7d8a920d8a7d984d8b9d8b5d8b1d98ad8a9d88c20d985d98620d8a7d984d8b3d987d98420d8aad8acd8a7d987d98420d8b5d8add8aad986d8a7d88c20d984d983d98620d8a5d8acd8b1d8a7d8a120d8aad8bad98ad98ad8b1d8a7d8aa20d8b5d8bad98ad8b1d8a920d988d985d8aad8b3d982d8a920d98ad985d983d98620d8a3d98620d98ad8a4d8afd98a20d8a5d984d98920d8aad8add8b3d98ad986d8a7d8aa20d983d8a8d98ad8b1d8a92e20d8a5d984d98ad98320d8a8d8b9d8b620d8a7d984d986d8b5d8a7d8a6d8ad20d8a7d984d8a3d8b3d8a7d8b3d98ad8a920d984d985d8b3d8a7d8b9d8afd8aad98320d8b9d984d98920d8a7d984d8a7d8b9d8aad986d8a7d8a120d8a8d8b5d8add8aad98320d988d8a7d984d8b9d98ad8b420d8a8d8a3d8b3d984d988d8a820d8add98ad8a7d8a920d8a3d983d8abd8b120d8aad988d8a7d8b2d986d98bd8a720d988d8b5d8add8a92e3c2f703e0d0a3c68343e312e203c7374726f6e673ed8a7d8b4d8b1d8a820d8a7d984d985d8a7d8a120d8a8d8a7d986d8aad8b8d8a7d9853c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d985d8a7d8a120d8a3d8b3d8a7d8b3d98a20d984d984d8add981d8a7d8b820d8b9d984d98920d988d8b8d8a7d8a6d98120d8a7d984d8acd8b3d98520d988d8b5d8add8aad98320d8a7d984d8b9d8a7d985d8a92e20d8add8a7d988d98420d8b4d8b1d8a820d985d8a720d984d8a720d98ad982d98420d8b9d986203820d8a3d983d988d8a7d8a820d985d98620d8a7d984d985d8a7d8a120d98ad988d985d98ad98bd8a720d984d984d8add981d8a7d8b820d8b9d984d98920d8aad8b1d8b7d98ad8a820d8acd8b3d985d9832e20d8a7d984d8aad8b1d8b7d98ad8a820d8a7d984d8acd98ad8af20d98ad8afd8b9d98520d8a7d984d987d8b6d985d88c20d98ad8add8b3d98620d8b5d8add8a920d8a7d984d8acd984d8afd88c20d988d98ad8b2d98ad8af20d985d98620d985d8b3d8aad988d98ad8a7d8aa20d8a7d984d8b7d8a7d982d8a92e20d8a7d8add985d98420d8b2d8acd8a7d8acd8a920d985d8a7d8a120d982d8a7d8a8d984d8a920d984d8a5d8b9d8a7d8afd8a920d8a7d984d8a7d8b3d8aad8aed8afd8a7d98520d985d8b9d98320d984d8b6d985d8a7d98620d8a8d982d8a7d8a1d98320d985d8b1d8b7d8a8d98bd8a720d8b7d988d8a7d98420d8a7d984d98ad988d9852e3c2f703e0d0a3c68343e322e203c7374726f6e673ed8aad986d8a7d988d98420d986d8b8d8a7d98520d8bad8b0d8a7d8a6d98a20d985d8aad988d8a7d8b2d9863c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d986d8b8d8a7d98520d8a7d984d8bad8b0d8a7d8a6d98a20d8a7d984d985d8bad8b0d98a20d987d98820d8a3d8b3d8a7d8b320d8a7d984d8b5d8add8a920d8a7d984d8acd98ad8afd8a92e20d8b1d983d8b220d8b9d984d98920d8aad986d8a7d988d98420d985d8acd985d988d8b9d8a920d985d8aad986d988d8b9d8a920d985d98620d8a7d984d981d988d8a7d983d98720d988d8a7d984d8aed8b6d8b1d988d8a7d8aa20d988d8a7d984d8add8a8d988d8a820d8a7d984d983d8a7d985d984d8a920d988d8a7d984d8a8d8b1d988d8aad98ad986d8a7d8aa20d8a7d984d8aed8a7d984d98ad8a920d985d98620d8a7d984d8afd987d988d98620d988d8a7d984d8afd987d988d98620d8a7d984d8b5d8add98ad8a92e20d8aad8acd986d8a820d8a7d984d8a7d8b3d8aad987d984d8a7d98320d8a7d984d985d981d8b1d8b720d984d984d8a3d8b7d8b9d985d8a920d8a7d984d985d8b5d986d8b9d8a9d88c20d988d8a7d984d988d8acd8a8d8a7d8aa20d8a7d984d8b3d983d8b1d98ad8a9d88c20d988d8a7d984d988d8acd8a8d8a7d8aa20d8b9d8a7d984d98ad8a920d8a7d984d8afd987d988d9862e20d8a7d984d8a3d983d98420d8a7d984d985d8aad988d8a7d8b2d98620d98ad988d981d8b120d8a7d984d8b9d986d8a7d8b5d8b120d8a7d984d8bad8b0d8a7d8a6d98ad8a920d8a7d984d8a3d8b3d8a7d8b3d98ad8a920d8a7d984d8aad98a20d98ad8add8aad8a7d8acd987d8a720d8acd8b3d985d98320d984d98ad8b9d985d98420d8a8d8b4d983d98420d985d8abd8a7d984d98a20d988d98ad8b3d8a7d8b9d8af20d981d98a20d8a7d984d988d982d8a7d98ad8a920d985d98620d8a7d984d8a3d985d8b1d8a7d8b620d8a7d984d985d8b2d985d986d8a92e3c2f703e0d0a3c68343e332e203c7374726f6e673ed985d8a7d8b1d8b320d8a7d984d8aad985d8a7d8b1d98ad98620d8a7d984d8b1d98ad8a7d8b6d98ad8a920d8a8d8a7d986d8aad8b8d8a7d9853c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d986d8b4d8a7d8b720d8a7d984d8a8d8afd986d98a20d8a3d8b3d8a7d8b3d98a20d984d984d8add981d8a7d8b820d8b9d984d98920d8acd8b3d98520d988d8b9d982d98420d8b5d8add98ad98ad9862e20d8add8a7d988d98420d985d985d8a7d8b1d8b3d8a920d8a7d984d8aad985d8a7d8b1d98ad98620d8a7d984d8b1d98ad8a7d8b6d98ad8a920d8a7d984d985d8b9d8aad8afd984d8a920d984d985d8afd8a92031353020d8afd982d98ad982d8a920d8b9d984d98920d8a7d984d8a3d982d98420d8a3d8b3d8a8d988d8b9d98ad98bd8a7d88c20d985d8abd98420d8a7d984d985d8b4d98a20d8a7d984d8b3d8b1d98ad8b9d88c20d8a3d98820d8b1d983d988d8a820d8a7d984d8afd8b1d8a7d8acd8a7d8aad88c20d8a3d98820d8a7d984d8b3d8a8d8a7d8add8a92e20d8a7d984d8aad985d8a7d8b1d98ad98620d8a7d984d8b1d98ad8a7d8b6d98ad8a920d8a7d984d985d986d8aad8b8d985d8a920d8aad8b3d8a7d8b9d8af20d981d98a20d8a5d8afd8a7d8b1d8a920d8a7d984d988d8b2d986d88c20d8aad8add8b3d98ad98620d8b5d8add8a920d8a7d984d982d984d8a820d988d8a7d984d8a3d988d8b9d98ad8a920d8a7d984d8afd985d988d98ad8a9d88c20d988d8aad8b9d8b2d98ad8b220d8a7d984d8b1d981d8a7d987d98ad8a920d8a7d984d8b9d982d984d98ad8a92e20d8a7d8a8d8add8ab20d8b9d98620d986d8b4d8a7d8b720d8aad8b3d8aad985d8aad8b920d8a8d98720d988d8a7d8acd8b9d984d98720d8acd8b2d8a1d98bd8a720d985d986d8aad8b8d985d98bd8a720d985d98620d8b1d988d8aad98ad986d9832e3c2f703e0d0a3c68343e342e203c7374726f6e673ed8a3d8b9d8b7d99020d8a7d984d8a3d988d984d988d98ad8a920d984d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8b1d981d8a7d987d98ad8a920d8a7d984d8b9d982d984d98ad8a920d985d987d985d8a920d8aad985d8a7d985d98bd8a720d985d8abd98420d8a7d984d8b5d8add8a920d8a7d984d8a8d8afd986d98ad8a92e20d985d8a7d8b1d8b320d8aad982d986d98ad8a7d8aa20d8a5d8afd8a7d8b1d8a920d8a7d984d8aad988d8aad8b120d985d8abd98420d8a7d984d98ad982d8b8d8a9d88c20d988d8a7d984d8aad8a3d985d984d88c20d988d8aad985d8a7d8b1d98ad98620d8a7d984d8aad986d981d8b320d8a7d984d8b9d985d98ad9822e20d8aed8b5d8b520d988d982d8aad98bd8a720d984d984d8a7d8b3d8aad8b1d8aed8a7d8a1d88c20d988d8b4d8a7d8b1d98320d981d98a20d987d988d8a7d98ad8a7d8aad88c20d988d982d8b6d99020d988d982d8aad98bd8a720d985d985d8aad8b9d98bd8a720d985d8b920d8a3d8add8a8d8a7d8a6d9832e20d8a5d8b0d8a720d983d986d8aa20d8aad8b9d8a7d986d98a20d985d98620d985d8b4d8a7d983d98420d8b5d8add98ad8a920d8b9d982d984d98ad8a9d88c20d8a7d8b7d984d8a820d8a7d984d8afd8b9d98520d985d98620d985d8aad8aed8b5d8b520d981d98a20d8a7d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a92e3c2f703e0d0a3c68343e352e203c7374726f6e673ed8a7d8add8b5d98420d8b9d984d98920d982d8b3d8b720d983d8a7d981d98d20d985d98620d8a7d984d986d988d9853c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d986d988d98520d8a7d984d8acd98ad8af20d8a3d8b3d8a7d8b3d98a20d984d984d8b5d8add8a920d8a7d984d8b9d8a7d985d8a920d988d8a7d984d8b1d981d8a7d987d98ad8a92e20d8add8a7d988d98420d8a7d984d8add8b5d988d98420d8b9d984d98920372d3920d8b3d8a7d8b9d8a7d8aa20d985d98620d8a7d984d986d988d98520d8a7d984d8acd98ad8af20d983d98420d984d98ad984d8a92e20d8a3d986d8b4d8a620d8a8d98ad8a6d8a920d987d8a7d8afd8a6d8a920d988d985d8b1d98ad8add8a920d981d98a20d8bad8b1d981d8a920d986d988d985d98320d985d98620d8aed984d8a7d98420d8a7d984d8add981d8a7d8b820d8b9d984d98920d8afd8b1d8acd8a920d8add8b1d8a7d8b1d8a920d985d986d8aed981d8b6d8a9d88c20d988d8a7d984d8b8d984d8a7d985d88c20d988d8a7d984d987d8afd988d8a12e20d8add8afd8af20d8acd8afd988d984d98bd8a720d985d986d8aad8b8d985d98bd8a720d984d984d986d988d98520d988d8aad8acd986d8a820d8a7d984d8b4d8a7d8b4d8a7d8aa20d982d8a8d98420d8a7d984d986d988d98520d984d8aad8add8b3d98ad98620d8acd988d8afd8a920d8a7d984d986d988d9852e3c2f703e0d0a3c68343e362e203c7374726f6e673ed985d8a7d8b1d8b320d8a7d984d986d8b8d8a7d981d8a920d8a7d984d8b4d8aed8b5d98ad8a920d8a7d984d8acd98ad8afd8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed8a7d984d8add981d8a7d8b820d8b9d984d98920d8a7d984d986d8b8d8a7d981d8a920d8a7d984d8b4d8aed8b5d98ad8a920d8a3d985d8b120d8add98ad988d98a20d984d984d988d982d8a7d98ad8a920d985d98620d8a7d984d8a3d985d8b1d8a7d8b620d988d8aad8b9d8b2d98ad8b220d8a7d984d8b5d8add8a92e20d8a7d8bad8b3d98420d98ad8afd98ad98320d8a8d8a7d986d8aad8b8d8a7d985d88c20d986d8b8d98120d8a3d8b3d986d8a7d986d98320d8a8d8a7d984d981d8b1d8b4d8a7d8a920d988d8a7d984d8aed98ad8b720d98ad988d985d98ad98bd8a7d88c20d988d8a7d8add8aad981d8b820d8a8d8a8d98ad8a6d8a920d8a7d984d985d8b9d98ad8b4d8a920d986d8b8d98ad981d8a92e20d8aad982d984d98420d8a7d984d985d985d8a7d8b1d8b3d8a7d8aa20d8a7d984d8acd98ad8afd8a920d984d984d986d8b8d8a7d981d8a920d985d98620d985d8aed8a7d8b7d8b120d8a7d984d8a5d8b5d8a7d8a8d8a920d8a8d8a7d984d8b9d8afd988d98920d988d8aad8b3d8a7d987d98520d981d98a20d8a7d984d8b1d981d8a7d987d98ad8a920d8a7d984d8b9d8a7d985d8a92e3c2f703e0d0a3c68343e372e203c7374726f6e673ed8a7d8a8d982d98e20d8b9d984d98920d8a7d8aad8b5d8a7d9843c2f7374726f6e673e3c2f68343e0d0a3c703ed8aad984d8b9d8a820d8a7d984d8b9d984d8a7d982d8a7d8aa20d8a7d984d8a7d8acd8aad985d8a7d8b9d98ad8a920d8afd988d8b1d98bd8a720d983d8a8d98ad8b1d98bd8a720d981d98a20d8a7d984d8add981d8a7d8b820d8b9d984d98920d8a7d984d8b5d8add8a920d8a7d984d8b9d982d984d98ad8a920d988d8a7d984d8b3d8b9d8a7d8afd8a920d8a7d984d8b9d8a7d985d8a92e20d8a8d8b0d98420d8acd987d8af20d984d984d8a8d982d8a7d8a120d8b9d984d98920d8a7d8aad8b5d8a7d98420d985d8b920d8a7d984d8a3d8b5d8afd982d8a7d8a120d988d8a7d984d8b9d8a7d8a6d984d8a9d88c20d8add8aad98920d984d98820d983d8a7d98620d8b0d984d98320d8b9d8a8d8b120d8a7d984d988d8b3d8a7d8a6d98420d8a7d984d8a7d981d8aad8b1d8a7d8b6d98ad8a92e20d8a8d986d8a7d8a120d988d8b1d8b9d8a7d98ad8a920d8a7d984d8b9d984d8a7d982d8a7d8aa20d8aad988d981d8b120d8a7d984d8afd8b9d98520d8a7d984d8b9d8a7d8b7d981d98a20d988d8aad8b3d8a7d987d98520d981d98a20d8a7d984d8b4d8b9d988d8b120d8a8d8a7d984d8a7d986d8aad985d8a7d8a12e3c2f703e0d0a3c68333e3c7374726f6e673ed8a7d984d8aed8a7d8aad985d8a93c2f7374726f6e673e3c2f68333e0d0a3c703ed8a7d984d8a7d8b9d8aad986d8a7d8a120d8a8d8b5d8add8aad98320d98ad8aad8b6d985d98620d8a7d984d8a7d987d8aad985d8a7d98520d8a8d8b5d8add8aad98320d8a7d984d8a8d8afd986d98ad8a920d988d8a7d984d8b9d982d984d98ad8a92e20d985d98620d8aed984d8a7d98420d8b4d8b1d8a820d8a7d984d985d8a7d8a120d8a8d8a7d986d8aad8b8d8a7d985d88c20d8aad986d8a7d988d98420d986d8b8d8a7d98520d8bad8b0d8a7d8a6d98a20d985d8aad988d8a7d8b2d986d88c20d985d985d8a7d8b1d8b3d8a920d8a7d984d8aad985d8a7d8b1d98ad98620d8a7d984d8b1d98ad8a7d8b6d98ad8a920d8a8d8a7d986d8aad8b8d8a7d985d88c20d8a5d8afd8a7d8b1d8a920d8a7d984d8aad988d8aad8b1d88c20d8a7d984d8add8b5d988d98420d8b9d984d98920d986d988d98520d983d8a7d981d98dd88c20d985d985d8a7d8b1d8b3d8a920d8a7d984d986d8b8d8a7d981d8a920d8a7d984d8b4d8aed8b5d98ad8a920d8a7d984d8acd98ad8afd8a9d88c20d988d8a7d984d8a8d982d8a7d8a120d8b9d984d98920d8a7d8aad8b5d8a7d98420d985d8b920d8a7d984d8a2d8aed8b1d98ad986d88c20d98ad985d983d986d98320d8b9d98ad8b420d8add98ad8a7d8a920d8a3d983d8abd8b120d8b5d8add8a920d988d8b1d8b6d8a72e20d8a7d8acd8b9d98420d987d8b0d98720d8a7d984d986d8b5d8a7d8a6d8ad20d8acd8b2d8a1d98bd8a720d985d98620d8b1d988d8aad98ad986d98320d8a7d984d98ad988d985d98a20d988d983d98620d8b4d8a7d987d8afd98bd8a720d8b9d984d98920d8a7d984d8aad8a3d8abd98ad8b120d8a7d984d8a5d98ad8acd8a7d8a8d98a20d8b9d984d98920d8b1d981d8a7d987d98ad8aad98320d8a7d984d8b9d8a7d985d8a92e3c2f703e, NULL, NULL, '2024-08-27 06:14:58', '2024-08-29 05:14:21'),
(59, 20, 52, 32, 'Embracing and Advancing Innovative Educational Approaches for a Modern Learning Experience', 'embracing-and-advancing-innovative-educational-approaches-for-a-modern-learning-experience', 'Jane', 0x3c703e496e20616e20657261206f6620726170696420746563686e6f6c6f676963616c20616476616e63656d656e747320616e64207368696674696e6720656475636174696f6e616c20706172616469676d732c20746865206c616e647363617065206f66206c6561726e696e672069732065766f6c76696e6720666173746572207468616e20657665722e20456d62726163696e6720696e6e6f76617469766520656475636174696f6e616c20617070726f616368657320697320657373656e7469616c20666f722073746179696e6720616865616420616e6420616368696576696e672061636164656d696320616e642070726f66657373696f6e616c20737563636573732e2048657265e280997320686f7720796f752063616e20616461707420746f20616e642062656e656669742066726f6d207468657365206d6f6465726e206c6561726e696e6720737472617465676965732e3c2f703e0d0a3c68343e312e203c7374726f6e673e4c65766572616765204f6e6c696e65204c6561726e696e6720506c6174666f726d733c2f7374726f6e673e3c2f68343e0d0a3c703e4f6e6c696e65206c6561726e696e6720706c6174666f726d732068617665207265766f6c7574696f6e697a656420656475636174696f6e206279206d616b696e6720686967682d7175616c69747920636f75727365732061636365737369626c6520746f2065766572796f6e652c20616e7977686572652e20506c6174666f726d73206c696b6520436f7572736572612c206564582c20616e64204b68616e2041636164656d79206f66666572206120776964652072616e6765206f6620636f7572736573206163726f737320766172696f7573206669656c64732e2054616b6520616476616e74616765206f66207468657365207265736f757263657320746f20656e68616e636520796f7572206b6e6f776c656467652c2061637175697265206e657720736b696c6c732c20616e64207075727375652063657274696669636174696f6e7320746861742063616e20626f6f737420796f7572206361726565722070726f7370656374732e3c2f703e0d0a3c68343e322e203c7374726f6e673e41646f707420426c656e646564204c6561726e696e67204d6f64656c733c2f7374726f6e673e3c2f68343e0d0a3c703e426c656e646564206c6561726e696e6720636f6d62696e657320747261646974696f6e616c20636c617373726f6f6d20696e737472756374696f6e2077697468206f6e6c696e65206163746976697469657320616e64207265736f75726365732e205468697320617070726f6163682070726f766964657320666c65786962696c69747920616e6420706572736f6e616c697a6174696f6e2c20616c6c6f77696e672073747564656e747320746f206c6561726e206174207468656972206f776e2070616365207768696c652062656e65666974696e672066726f6d20666163652d746f2d6661636520696e746572616374696f6e732e20496e636f72706f7261746520626c656e646564206c6561726e696e6720696e746f20796f757220737475647920726f7574696e6520746f20656e68616e636520636f6d70726568656e73696f6e20616e642072657461696e20696e666f726d6174696f6e206d6f7265206566666563746976656c792e3c2f703e0d0a3c68343e332e203c7374726f6e673e5574696c697a6520496e746572616374697665204c6561726e696e6720546f6f6c733c2f7374726f6e673e3c2f68343e0d0a3c703e496e746572616374697665206c6561726e696e6720746f6f6c732c207375636820617320656475636174696f6e616c20617070732c2073696d756c6174696f6e732c20616e64207669727475616c206c6162732c206d616b65206c6561726e696e6720656e676167696e6720616e642068616e64732d6f6e2e20546865736520746f6f6c7320616c6c6f772073747564656e747320746f206578706c6f726520636f6e6365707473207468726f7567682070726163746963616c206170706c69636174696f6e20616e64207265616c2d74696d6520666565646261636b2e20496e7465677261746520696e74657261637469766520746f6f6c7320696e746f20796f7572206c6561726e696e672070726f6365737320746f206d616b65207374756479696e67206d6f72652064796e616d696320616e6420656e6a6f7961626c652e3c2f703e0d0a3c68343e342e203c7374726f6e673e456d6272616365204c6966656c6f6e67204c6561726e696e673c2f7374726f6e673e3c2f68343e0d0a3c703e496e20746f646179e280997320666173742d706163656420776f726c642c20636f6e74696e756f7573206c6561726e696e67206973206b657920746f2073746179696e672072656c6576616e7420616e6420636f6d70657469746976652e20436f6d6d697420746f206c6966656c6f6e67206c6561726e696e67206279207365656b696e67206f7574206e6577206b6e6f776c6564676520616e6420736b696c6c73206265796f6e6420666f726d616c20656475636174696f6e2e20417474656e6420776f726b73686f70732c20776562696e6172732c20616e6420636f6e666572656e6365732c20616e64207265616420626f6f6b7320616e642061727469636c65732072656c6174656420746f20796f7572206669656c642e204c6966656c6f6e67206c6561726e696e67206e6f74206f6e6c79206b6565707320796f7520757064617465642062757420616c736f20666f737465727320706572736f6e616c20616e642070726f66657373696f6e616c2067726f7774682e3c2f703e0d0a3c68343e352e203c7374726f6e673e466f7374657220436f6c6c61626f726174697665204c6561726e696e673c2f7374726f6e673e3c2f68343e0d0a3c703e436f6c6c61626f726174697665206c6561726e696e6720656e636f7572616765732073747564656e747320746f20776f726b20746f6765746865722c2073686172652069646561732c20616e6420736f6c76652070726f626c656d7320636f6c6c6563746976656c792e2047726f75702070726f6a656374732c2064697363757373696f6e20666f72756d732c20616e6420706565722d746f2d70656572207465616368696e6720656e68616e636520637269746963616c207468696e6b696e6720616e6420636f6d6d756e69636174696f6e20736b696c6c732e20456e6761676520696e20636f6c6c61626f726174697665206c6561726e696e67206f70706f7274756e697469657320746f206761696e20646976657273652070657273706563746976657320616e6420696d70726f766520796f7572207465616d776f726b206162696c69746965732e3c2f703e0d0a3c68343e362e203c7374726f6e673e496e636f72706f726174652047616d696669636174696f6e3c2f7374726f6e673e3c2f68343e0d0a3c703e47616d696669636174696f6e20696e766f6c766573207573696e672067616d652d6c696b6520656c656d656e74732c207375636820617320706f696e74732c206261646765732c20616e64206c6561646572626f617264732c20746f206d6f74697661746520616e6420656e67616765206c6561726e6572732e20456475636174696f6e616c2067616d657320616e642067616d69666965642061737369676e6d656e74732063616e206d616b65206c6561726e696e67206d6f726520696e74657261637469766520616e6420656e6a6f7961626c652e20496e746567726174652067616d696669636174696f6e20746563686e697175657320696e746f20796f757220737475647920726f7574696e6520746f20696e637265617365206d6f7469766174696f6e20616e6420656e68616e6365206c6561726e696e67206f7574636f6d65732e3c2f703e0d0a3c68343e372e203c7374726f6e673e5072696f726974697a6520506572736f6e616c697a6564204c6561726e696e673c2f7374726f6e673e3c2f68343e0d0a3c703e506572736f6e616c697a6564206c6561726e696e67207461696c6f727320656475636174696f6e616c20657870657269656e63657320746f20696e646976696475616c206e656564732c20707265666572656e6365732c20616e64206c6561726e696e67207374796c65732e205574696c697a65206164617074697665206c6561726e696e6720746563686e6f6c6f6769657320616e6420746f6f6c7320746861742061646a75737420636f6e74656e7420616e642070616365206261736564206f6e20796f75722070726f67726573732e20506572736f6e616c697a6564206c6561726e696e6720656e7375726573207468617420796f75207265636569766520696e737472756374696f6e20746861742069732072656c6576616e7420616e64206566666563746976652c206c656164696e6720746f206265747465722061636164656d696320706572666f726d616e636520616e6420756e6465727374616e64696e672e3c2f703e0d0a3c68333e3c7374726f6e673e436f6e636c7573696f6e3c2f7374726f6e673e3c2f68333e0d0a3c703e54686520667574757265206f6620656475636174696f6e2069732073686170656420627920696e6e6f76617469766520617070726f6163686573207468617420656e68616e6365206c6561726e696e6720657870657269656e63657320616e64206f7574636f6d65732e204279206c657665726167696e67206f6e6c696e65206c6561726e696e6720706c6174666f726d732c2061646f7074696e6720626c656e646564206c6561726e696e67206d6f64656c732c207574696c697a696e6720696e74657261637469766520746f6f6c732c20656d62726163696e67206c6966656c6f6e67206c6561726e696e672c20666f73746572696e6720636f6c6c61626f726174696f6e2c20696e636f72706f726174696e672067616d696669636174696f6e2c20616e64207072696f726974697a696e6720706572736f6e616c697a6174696f6e2c20796f752063616e207374617920616865616420696e20796f757220656475636174696f6e616c206a6f75726e657920616e64206163686965766520796f75722061636164656d696320616e642070726f66657373696f6e616c20676f616c732e20456d6272616365207468657365207374726174656769657320746f20756e6c6f636b20796f75722066756c6c20706f74656e7469616c20616e642074687269766520696e207468652065766f6c76696e6720776f726c64206f66206c6561726e696e672e3c2f703e, NULL, NULL, '2024-08-27 06:17:12', '2024-08-29 05:12:57'),
(60, 21, 56, 32, 'تبني وتعزيز المناهج التعليمية المبتكرة من أجل تجربة تعليمية حديثة', 'تبني-وتعزيز-المناهج-التعليمية-المبتكرة-من-أجل-تجربة-تعليمية-حديثة', 'جين', 0x3c703ed981d98a20d8b9d8b5d8b120d8a7d984d8aad982d8afd98520d8a7d984d8aad983d986d988d984d988d8acd98a20d8a7d984d8b3d8b1d98ad8b920d988d8aad8bad98ad8b120706172616469676d7320d8a7d984d8aad8b9d984d98ad985d98ad8a9d88c20d8aad8aad8b7d988d8b120d985d8b4d987d8af20d8a7d984d8aad8b9d984d98520d8a3d8b3d8b1d8b920d985d98620d8a3d98a20d988d982d8aa20d985d8b6d9892e20d985d98620d8a7d984d8b6d8b1d988d8b1d98a20d8aad8a8d986d98a20d8a7d984d8a3d8b3d8a7d984d98ad8a820d8a7d984d8aad8b9d984d98ad985d98ad8a920d8a7d984d985d8a8d8aad983d8b1d8a920d984d984d8a8d982d8a7d8a120d981d98a20d8a7d984d985d982d8afd985d8a920d988d8aad8add982d98ad98220d8a7d984d986d8acd8a7d8ad20d8a7d984d8a3d983d8a7d8afd98ad985d98a20d988d8a7d984d985d987d986d98a2e20d8a5d984d98ad98320d983d98ad98120d98ad985d983d986d98320d8a7d984d8aad983d98ad98120d985d8b920d987d8b0d98720d8a7d984d8a7d8b3d8aad8b1d8a7d8aad98ad8acd98ad8a7d8aa20d8a7d984d8add8afd98ad8abd8a920d988d8a7d984d8a7d8b3d8aad981d8a7d8afd8a920d985d986d987d8a72e3c2f703e0d0a3c68343e312e203c7374726f6e673ed8a7d8b3d8aad981d8af20d985d98620d985d986d8b5d8a7d8aa20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa3c2f7374726f6e673e3c2f68343e0d0a3c703ed8a3d8add8afd8abd8aa20d985d986d8b5d8a7d8aa20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa20d8abd988d8b1d8a920d981d98a20d8a7d984d8aad8b9d984d98ad98520d985d98620d8aed984d8a7d98420d8acd8b9d98420d8a7d984d8afd988d8b1d8a7d8aa20d8a7d984d8afd8b1d8a7d8b3d98ad8a920d8b9d8a7d984d98ad8a920d8a7d984d8acd988d8afd8a920d985d8aad8a7d8add8a920d984d984d8acd985d98ad8b9d88c20d981d98a20d8a3d98a20d985d983d8a7d9862e20d8aad982d8afd98520d985d986d8b5d8a7d8aa20d985d8abd98420436f75727365726120d98865645820d9884b68616e2041636164656d7920d985d8acd985d988d8b9d8a920d988d8a7d8b3d8b9d8a920d985d98620d8a7d984d8afd988d8b1d8a7d8aa20d981d98a20d985d8acd8a7d984d8a7d8aa20d985d8aed8aad984d981d8a92e20d8a7d8b3d8aad981d8af20d985d98620d987d8b0d98720d8a7d984d985d988d8a7d8b1d8af20d984d8aad8b9d8b2d98ad8b220d985d8b9d8b1d981d8aad983d88c20d988d8a7d983d8aad8b3d8a7d8a820d985d987d8a7d8b1d8a7d8aa20d8acd8afd98ad8afd8a9d88c20d988d8a7d984d8add8b5d988d98420d8b9d984d98920d8b4d987d8a7d8afd8a7d8aa20d982d8af20d8aad8b9d8b2d8b220d8a2d981d8a7d982d98320d8a7d984d985d987d986d98ad8a92e3c2f703e0d0a3c68343e322e203c7374726f6e673ed8a7d8b9d8aad985d8af20d986d985d8a7d8b0d8ac20d8a7d984d8aad8b9d984d98520d8a7d984d985d8afd985d8ac3c2f7374726f6e673e3c2f68343e0d0a3c703ed98ad8acd985d8b920d8a7d984d8aad8b9d984d98520d8a7d984d985d8afd985d8ac20d8a8d98ad98620d8a7d984d8aad8b9d984d98ad98520d8a7d984d8aad982d984d98ad8afd98a20d981d98a20d8a7d984d981d8b5d98420d8a7d984d8afd8b1d8a7d8b3d98a20d988d8a7d984d986d8b4d8a7d8b7d8a7d8aa20d988d8a7d984d985d988d8a7d8b1d8af20d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aa2e20d98ad988d981d8b120d987d8b0d8a720d8a7d984d986d987d8ac20d8a7d984d985d8b1d988d986d8a920d988d8a7d984d8aad8aed8b5d98ad8b5d88c20d985d985d8a720d98ad8b3d985d8ad20d984d984d8b7d984d8a7d8a820d8a8d8a7d984d8aad8b9d984d98520d988d981d982d98bd8a720d984d8b3d8b1d8b9d8aad987d98520d8a7d984d8aed8a7d8b5d8a920d985d8b920d8a7d984d8a7d8b3d8aad981d8a7d8afd8a920d985d98620d8a7d984d8aad981d8a7d8b9d984d8a7d8aa20d988d8acd987d98bd8a720d984d988d8acd9872e20d8afd985d8ac20d8a7d984d8aad8b9d984d98520d8a7d984d985d8afd985d8ac20d981d98a20d8b1d988d8aad98ad98620d8afd8b1d8a7d8b3d8aad98320d984d8aad8add8b3d98ad98620d8a7d984d981d987d98520d988d8a7d984d8a7d8add8aad981d8a7d8b820d8a8d8a7d984d985d8b9d984d988d985d8a7d8aa20d8a8d8b4d983d98420d8a3d983d8abd8b120d981d8b9d8a7d984d98ad8a92e3c2f703e0d0a3c68343e332e203c7374726f6e673ed8a7d8b3d8aad8aed8afd98520d8a3d8afd988d8a7d8aa20d8a7d984d8aad8b9d984d98520d8a7d984d8aad981d8a7d8b9d984d98ad8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed8aad8acd8b9d98420d8a3d8afd988d8a7d8aa20d8a7d984d8aad8b9d984d98520d8a7d984d8aad981d8a7d8b9d984d98ad8a9d88c20d985d8abd98420d8a7d984d8aad8b7d8a8d98ad982d8a7d8aa20d8a7d984d8aad8b9d984d98ad985d98ad8a9d88c20d988d8a7d984d985d8add8a7d983d98ad8a7d8aad88c20d988d8a7d984d985d8aed8aad8a8d8b1d8a7d8aa20d8a7d984d8a7d981d8aad8b1d8a7d8b6d98ad8a9d88c20d8a7d984d8aad8b9d984d98520d985d985d8aad8b9d98bd8a720d988d8b9d985d984d98ad98bd8a72e20d8aad8aad98ad8ad20d987d8b0d98720d8a7d984d8a3d8afd988d8a7d8aa20d984d984d8b7d984d8a7d8a820d8a7d8b3d8aad983d8b4d8a7d98120d8a7d984d985d981d8a7d987d98ad98520d985d98620d8aed984d8a7d98420d8a7d984d8aad8b7d8a8d98ad98220d8a7d984d8b9d985d984d98a20d988d8a7d984d8aad8bad8b0d98ad8a920d8a7d984d8b1d8a7d8acd8b9d8a920d8a7d984d981d988d8b1d98ad8a92e20d8afd985d8ac20d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d8aad981d8a7d8b9d984d98ad8a920d981d98a20d8b9d985d984d98ad8a920d8a7d984d8aad8b9d984d98520d984d8acd8b9d98420d8a7d984d8afd8b1d8a7d8b3d8a920d8a3d983d8abd8b120d8afd98ad986d8a7d985d98ad983d98ad8a920d988d985d8aad8b9d8a92e3c2f703e0d0a3c68343e342e203c7374726f6e673ed8a7d8add8aad8b6d8a7d98620d8a7d984d8aad8b9d984d98520d985d8afd98920d8a7d984d8add98ad8a7d8a93c2f7374726f6e673e3c2f68343e0d0a3c703ed981d98a20d8b9d8a7d984d985d986d8a720d8a7d984d8b3d8b1d98ad8b9d88c20d98ad8b9d8af20d8a7d984d8aad8b9d984d98520d8a7d984d985d8b3d8aad985d8b120d985d981d8aad8a7d8add98bd8a720d984d984d8a8d982d8a7d8a120d8b0d98a20d8b5d984d8a920d988d985d986d8a7d981d8b3d98bd8a72e20d8a7d984d8aad8b2d98520d8a8d8a7d984d8aad8b9d984d98520d985d8afd98920d8a7d984d8add98ad8a7d8a920d985d98620d8aed984d8a7d98420d8a7d984d8a8d8add8ab20d8b9d98620d985d8b9d8b1d981d8a920d988d985d987d8a7d8b1d8a7d8aa20d8acd8afd98ad8afd8a920d8a5d984d98920d8acd8a7d986d8a820d8a7d984d8aad8b9d984d98ad98520d8a7d984d8b1d8b3d985d98a2e20d8a7d8add8b6d8b120d988d8b1d8b420d8a7d984d8b9d985d984d88c20d988d8a7d984d986d8afd988d8a7d8aad88c20d988d8a7d984d985d8a4d8aad985d8b1d8a7d8aad88c20d988d8a7d982d8b1d8a320d8a7d984d983d8aad8a820d988d8a7d984d985d982d8a7d984d8a7d8aa20d8a7d984d985d8aad8b9d984d982d8a920d8a8d985d8acd8a7d984d9832e20d98ad8b6d985d98620d8a7d984d8aad8b9d984d98520d985d8afd98920d8a7d984d8add98ad8a7d8a920d8a3d986d98320d8aad8a8d982d98920d985d8add8afd8abd98bd8a720d988d98ad8b9d8b2d8b220d8a7d984d986d985d98820d8a7d984d8b4d8aed8b5d98a20d988d8a7d984d985d987d986d98a2e3c2f703e0d0a3c68343e352e203c7374726f6e673ed8aad8b4d8acd98ad8b920d8a7d984d8aad8b9d984d98520d8a7d984d8aad8b9d8a7d988d986d98a3c2f7374726f6e673e3c2f68343e0d0a3c703ed98ad8b4d8acd8b920d8a7d984d8aad8b9d984d98520d8a7d984d8aad8b9d8a7d988d986d98a20d8a7d984d8b7d984d8a7d8a820d8b9d984d98920d8a7d984d8b9d985d98420d985d8b9d98bd8a7d88c20d988d985d8b4d8a7d8b1d983d8a920d8a7d984d8a3d981d983d8a7d8b1d88c20d988d8add98420d8a7d984d985d8b4d983d984d8a7d8aa20d8a8d8b4d983d98420d8acd985d8a7d8b9d98a2e20d8aad8b9d8b2d8b220d8a7d984d985d8b4d8a7d8b1d98ad8b920d8a7d984d8acd985d8a7d8b9d98ad8a9d88c20d988d985d986d8aad8afd98ad8a7d8aa20d8a7d984d986d982d8a7d8b4d88c20d988d8a7d984d8aad8afd8b1d98ad8b320d985d98620d982d8a8d98420d8a7d984d8a3d982d8b1d8a7d98620d8a7d984d8aad981d983d98ad8b120d8a7d984d986d982d8afd98a20d988d985d987d8a7d8b1d8a7d8aa20d8a7d984d8aad988d8a7d8b5d9842e20d8b4d8a7d8b1d98320d981d98a20d981d8b1d8b520d8a7d984d8aad8b9d984d98520d8a7d984d8aad8b9d8a7d988d986d98a20d984d984d8add8b5d988d98420d8b9d984d98920d988d8acd987d8a7d8aa20d986d8b8d8b120d985d8aad986d988d8b9d8a920d988d8aad8add8b3d98ad98620d982d8afd8b1d8a7d8aad98320d8b9d984d98920d8a7d984d8b9d985d98420d8a7d984d8acd985d8a7d8b9d98a2e3c2f703e0d0a3c68343e362e203c7374726f6e673ed8afd985d8ac20d8a3d8b3d984d988d8a820d8a7d984d984d8b9d8a83c2f7374726f6e673e3c2f68343e0d0a3c703ed98ad8b4d985d98420d8a3d8b3d984d988d8a820d8a7d984d984d8b9d8a820d8a7d8b3d8aad8aed8afd8a7d98520d8b9d986d8a7d8b5d8b120d8aad8b4d8a8d98720d8a7d984d8a3d984d8b9d8a7d8a8d88c20d985d8abd98420d8a7d984d986d982d8a7d8b7d88c20d988d8a7d984d8b4d8a7d8b1d8a7d8aad88c20d988d984d988d8add8a7d8aa20d8a7d984d982d8a7d8afd8a9d88c20d984d8aad8add981d98ad8b220d988d8aad8add981d98ad8b220d8a7d984d985d8aad8b9d984d985d98ad9862e20d98ad985d983d98620d8a3d98620d8aad8acd8b9d98420d8a7d984d8a3d984d8b9d8a7d8a820d8a7d984d8aad8b9d984d98ad985d98ad8a920d988d8a7d984d985d987d8a7d98520d8a7d984d8aad98a20d8aad8b9d8aad985d8af20d8b9d984d98920d8a3d8b3d984d988d8a820d8a7d984d984d8b9d8a820d8a7d984d8aad8b9d984d98520d8a3d983d8abd8b120d8aad981d8a7d8b9d984d98ad8a920d988d985d8aad8b9d8a92e20d8afd985d8ac20d8aad982d986d98ad8a7d8aa20d8a3d8b3d984d988d8a820d8a7d984d984d8b9d8a820d981d98a20d8b1d988d8aad98ad98620d8afd8b1d8a7d8b3d8aad98320d984d8b2d98ad8a7d8afd8a920d8a7d984d8aad8add981d98ad8b220d988d8aad8b9d8b2d98ad8b220d986d8aad8a7d8a6d8ac20d8a7d984d8aad8b9d984d9852e3c2f703e0d0a3c68343e372e203c7374726f6e673ed8a3d8b9d8b7d99020d8a7d984d8a3d988d984d988d98ad8a920d984d984d8aad8b9d984d98520d8a7d984d985d8aed8b5d8b53c2f7374726f6e673e3c2f68343e0d0a3c703ed98ad8aed8b5d8b520d8a7d984d8aad8b9d984d98520d8a7d984d985d8aed8b5d8b520d8a7d984d8aad8acd8a7d8b1d8a820d8a7d984d8aad8b9d984d98ad985d98ad8a920d984d8aad984d8a8d98ad8a920d8a7d8add8aad98ad8a7d8acd8a7d8aa20d8a7d984d8a3d981d8b1d8a7d8af20d988d8aad981d8b6d98ad984d8a7d8aad987d98520d988d8a3d986d985d8a7d8b720d8a7d984d8aad8b9d984d98520d8a7d984d8aed8a7d8b5d8a920d8a8d987d9852e20d8a7d8b3d8aad8aed8afd98520d8aad982d986d98ad8a7d8aa20d988d8a3d8afd988d8a7d8aa20d8a7d984d8aad8b9d984d98520d8a7d984d8aad983d98ad981d98ad8a920d8a7d984d8aad98a20d8aad8b9d8afd98420d8a7d984d985d8add8aad988d98920d988d8a7d984d8b3d8b1d8b9d8a920d8a8d986d8a7d8a1d98b20d8b9d984d98920d8aad982d8afd985d9832e20d98ad8b6d985d98620d8a7d984d8aad8b9d984d98520d8a7d984d985d8aed8b5d8b520d8aad984d982d98ad98320d8aad8b9d984d98ad985d98bd8a720d8b0d8a720d8b5d984d8a920d988d981d8b9d8a7d984d98bd8a7d88c20d985d985d8a720d98ad8a4d8afd98a20d8a5d984d98920d8aad8add8b3d98ad98620d8a7d984d8a3d8afd8a7d8a120d8a7d984d8a3d983d8a7d8afd98ad985d98a20d988d8a7d984d981d987d9852e3c2f703e0d0a3c68333e3c7374726f6e673ed8a7d984d8aed8a7d8aad985d8a93c2f7374726f6e673e3c2f68333e0d0a3c703ed98ad8aad98520d8aad8b4d983d98ad98420d985d8b3d8aad982d8a8d98420d8a7d984d8aad8b9d984d98ad98520d985d98620d8aed984d8a7d98420d8a7d984d8a3d8b3d8a7d984d98ad8a820d8a7d984d985d8a8d8aad983d8b1d8a920d8a7d984d8aad98a20d8aad8b9d8b2d8b220d8aad8acd8a7d8b1d8a820d988d986d8aad8a7d8a6d8ac20d8a7d984d8aad8b9d984d9852e20d985d98620d8aed984d8a7d98420d8a7d984d8a7d8b3d8aad981d8a7d8afd8a920d985d98620d985d986d8b5d8a7d8aa20d8a7d984d8aad8b9d984d98520d8b9d8a8d8b120d8a7d984d8a5d986d8aad8b1d986d8aad88c20d988d8aad8a8d986d98a20d986d985d8a7d8b0d8ac20d8a7d984d8aad8b9d984d98520d8a7d984d985d8afd985d8acd88c20d988d8a7d8b3d8aad8aed8afd8a7d98520d8a7d984d8a3d8afd988d8a7d8aa20d8a7d984d8aad981d8a7d8b9d984d98ad8a9d88c20d988d8a7d8add8aad8b6d8a7d98620d8a7d984d8aad8b9d984d98520d985d8afd98920d8a7d984d8add98ad8a7d8a9d88c20d988d8aad8b4d8acd98ad8b920d8a7d984d8aad8b9d8a7d988d986d88c20d988d8afd985d8ac20d8a3d8b3d984d988d8a820d8a7d984d984d8b9d8a8d88c20d988d8a5d8b9d8b7d8a7d8a120d8a7d984d8a3d988d984d988d98ad8a920d984d984d8aad8aed8b5d98ad8b5d88c20d98ad985d983d986d98320d8a7d984d8a8d982d8a7d8a120d981d98a20d8a7d984d985d982d8afd985d8a920d981d98a20d8b1d8add984d8aad98320d8a7d984d8aad8b9d984d98ad985d98ad8a920d988d8aad8add982d98ad98220d8a3d987d8afd8a7d981d98320d8a7d984d8a3d983d8a7d8afd98ad985d98ad8a920d988d8a7d984d985d987d986d98ad8a92e20d8aad8a8d986d991d98ed98920d987d8b0d98720d8a7d984d8a7d8b3d8aad8b1d8a7d8aad98ad8acd98ad8a7d8aa20d984d8a7d8b3d8aad983d8b4d8a7d98120d8a5d985d983d8a7d986d98ad8a7d8aad98320d8a8d8a7d984d983d8a7d985d98420d988d8a7d984d8a7d8b2d8afd987d8a7d8b120d981d98a20d8b9d8a7d984d98520d8a7d984d8aad8b9d984d98520d8a7d984d985d8aad8b7d988d8b12e3c2f703e, NULL, NULL, '2024-08-27 06:17:12', '2024-08-29 05:12:57');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `type` tinyint DEFAULT NULL COMMENT '1=user, 2=admin, 3=vendor',
  `support_ticket_id` int DEFAULT NULL,
  `reply` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `cookie_alerts`
--

CREATE TABLE `cookie_alerts` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `cookie_alert_status` tinyint UNSIGNED NOT NULL,
  `cookie_alert_btn_text` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cookie_alert_text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `cookie_alerts`
--

INSERT INTO `cookie_alerts` (`id`, `language_id`, `cookie_alert_status`, `cookie_alert_btn_text`, `cookie_alert_text`, `created_at`, `updated_at`) VALUES
(3, 20, 1, 'I Agree', 'We use cookies to give you the best online experience.\r\nBy continuing to browse the site you are agreeing to our use of cookies.', '2023-08-29 02:35:44', '2023-08-29 02:37:13'),
(4, 21, 1, 'أنا موافق', 'نحن نستخدم ملفات تعريف الارتباط لنمنحك أفضل تجربة عبر الإنترنت. من خلال الاستمرار في تصفح الموقع فإنك توافق على استخدامنا لملفات تعريف الارتباط.', '2023-08-29 02:36:53', '2023-08-29 02:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `custom_sections`
--

CREATE TABLE `custom_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_section_contents`
--

CREATE TABLE `custom_section_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint NOT NULL,
  `custom_section_id` bigint NOT NULL,
  `section_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `serial_number` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `language_id`, `question`, `answer`, `serial_number`, `created_at`, `updated_at`) VALUES
(38, 20, 'What is BookApp?', 'BookApp is a comprehensive service booking platform that connects you with various professionals across different categories like Doctors, Plumbers, Gym Centers, Cleaning, Electrical, Barber Shop, and Education. You can book appointments, schedule services, and even access some services online via Zoom.', 1, '2024-08-27 23:23:53', '2024-08-27 23:23:53'),
(39, 21, 'ما هو تطبيق الكتاب؟', 'تطبيق الكتابعبارة عن منصة شاملة لحجز الخدمات تربطك بمختلف المتخصصين في مختلف الفئات مثل الأطباء والسباكين ومراكز اللياقة البدنية والتنظيف والكهرباء وصالون الحلاقة والتعليم. يمكنك حجز المواعيد وجدولة الخدمات وحتى الوصول إلى بعض الخدمات عبر الإنترنت عبر تكبير.', 1, '2024-08-27 23:24:40', '2024-08-27 23:24:40'),
(40, 20, 'What payment methods are available?', 'BookApp supports multiple payment methods, including credit/debit cards, PayPal, and other secure online payment gateways. You can choose the payment method that suits you best at checkout.', 2, '2024-08-27 23:27:29', '2024-08-27 23:27:29'),
(41, 21, 'ما هي طرق الدفع المتاحة؟', 'يدعم تطبيق تطبيق الكتابطرق دفع متعددة، بما في ذلك بطاقات الائتمان/الخصم، وPayPal، وبوابات الدفع الآمنة الأخرى عبر الإنترنت. يمكنك اختيار طريقة الدفع التي تناسبك بشكل أفضل عند إتمام عملية الشراء.', 2, '2024-08-27 23:28:00', '2024-08-27 23:28:00'),
(42, 20, 'Are online services available?', 'Yes, some services on BookApp are available online and can be conducted via Zoom. You can see the availability of online services when booking.', 3, '2024-08-27 23:28:39', '2024-08-27 23:28:39'),
(43, 21, 'هل الخدمات متاحة عبر الإنترنت؟', 'نعم، بعض الخدمات على تطبيق الكتابمتاحة عبر الإنترنت ويمكن إجراؤها عبر Zoom. يمكنك معرفة مدى توفر الخدمات عبر الإنترنت عند الحجز.', 3, '2024-08-27 23:29:12', '2024-08-27 23:29:12'),
(44, 20, 'How to Debug this App?', 'It\'s important to provide detailed information such as the make, model, year, mileage, condition, features, and any history of accidents or repairs. The more details you provide, the better your chances of attracting potential buyers.', 4, '2024-08-27 23:30:36', '2024-08-27 23:30:36'),
(45, 21, 'كيفية تصحيح أخطاء هذا التطبيق؟', 'من المهم تقديم معلومات تفصيلية مثل الماركة والطراز والسنة وعدد الأميال والحالة والميزات وأي تاريخ للحوادث أو الإصلاحات. كلما قدمت المزيد من التفاصيل، زادت فرصك في جذب المشترين المحتملين.', 4, '2024-08-27 23:31:03', '2024-08-27 23:31:03'),
(46, 20, 'How do I know the service provider is reliable?', 'All service providers on BookApp are vetted and verified for their qualifications and experience. You can also read reviews from other customers to ensure you’re choosing the right professional for your needs.', 5, '2024-08-27 23:36:27', '2024-08-27 23:38:00'),
(47, 21, 'كيف أعرف أن مقدم الخدمة موثوق؟', 'يتم فحص جميع مقدمي الخدمات على تطبيق الكتابوالتحقق من مؤهلاتهم وخبراتهم. يمكنك أيضًا قراءة تقييمات العملاء الآخرين للتأكد من اختيارك للمتخصص المناسب لاحتياجاتك.', 5, '2024-08-27 23:37:52', '2024-08-27 23:37:52'),
(48, 20, 'How do I sign up as a service provider on BookApp?', 'If you’re a professional looking to offer your services through BookApp, you can sign up by clicking on the “Become a Service Provider” link on our homepage. Fill out the registration form, and our team will guide you through the verification process.', 6, '2024-08-27 23:38:31', '2024-08-27 23:38:31'),
(49, 21, 'كيف أقوم بالتسجيل كمقدم خدمة على تطبيق الكتاب؟', 'إذا كنت محترفًا وترغب في تقديم خدماتك عبر تطبيق الكتاب، فيمكنك التسجيل بالنقر فوق رابط \"كن مقدم خدمة\" على صفحتنا الرئيسية. املأ نموذج التسجيل، وسيقوم فريقنا بإرشادك خلال عملية التحقق.', 6, '2024-08-27 23:39:05', '2024-08-27 23:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `featured_service_charges`
--

CREATE TABLE `featured_service_charges` (
  `id` bigint UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `day` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `language_id`, `title`, `text`, `icon`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 20, 'Trusted Providers', 'Book with confidence from our verified and reliable vendors.', 'fas fa-user-shield', 1, '2024-08-23 23:04:30', '2024-08-23 23:09:42'),
(2, 20, 'Zoom Consultations', 'Access online services via Zoom for remote convenience.', 'fas fa-video', 2, '2024-08-23 23:10:19', '2024-08-23 23:10:19'),
(3, 20, 'Multiple Payment', 'Pay securely with cards, PayPal, or mobile wallets.', 'fas fa-credit-card', 3, '2024-08-23 23:10:51', '2024-09-11 03:30:42'),
(4, 20, 'Google Calendar Sync', 'Auto-add bookings to your Google Calendar.', 'fas fa-calendar-alt', 4, '2024-08-23 23:12:07', '2024-09-11 03:30:17'),
(6, 21, 'مقدمي الخدمات الموثوق بهم', 'احجز بثقة من البائعين الموثوقين لدينا.', 'fas fa-user-shield', 1, '2024-08-23 23:15:33', '2024-08-23 23:15:33'),
(7, 21, 'استشارات زووم', 'يمكنك الوصول إلى الخدمات عبر الإنترنت عبر تطبيق تكبيرلتوفير الراحة عن بعد.', 'fas fa-video', 2, '2024-08-23 23:16:16', '2024-08-23 23:16:16'),
(8, 21, 'الدفع المتعدد', 'ادفع بأمان باستخدام البطاقات أو باي بالأو المحافظ الإلكترونية.', 'fas fa-credit-card', 3, '2024-08-23 23:17:27', '2024-08-23 23:17:27'),
(9, 21, 'مزامنة تقويم جوجل', 'إضافة الحجوزات تلقائيًا إلى تقويم جوجلالخاص بك.', 'fas fa-calendar-alt', 4, '2024-08-23 23:18:09', '2024-08-23 23:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `footer_contents`
--

CREATE TABLE `footer_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `about_company` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `copyright_text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `footer_contents`
--

INSERT INTO `footer_contents` (`id`, `language_id`, `about_company`, `copyright_text`, `created_at`, `updated_at`) VALUES
(5, 20, 'At Carlist, we offer a wide selection of top-quality pre-owned vehicles to meet your driving needs and budget. With years of experience in the automotive industry.', '<p>Copyright ©2024. All Rights Reserved</p>', '2023-08-19 23:40:53', '2024-08-28 05:28:02'),
(6, 21, 'في قائمة سيارة ، نقدم مجموعة واسعة من السيارات المستعملة عالية الجودة لتلبية احتياجات قيادتك وميزانيتك. مع سنوات من الخبرة في صناعة السيارات ، نفخر بتقديم خدمة عملاء استثنائية والتأكد من أن كل سيارة في قطعتنا تلبي معاييرنا الصارمة للجودة والموثوقية.', '<div class=\"tw-ta-container F0azHf tw-lfl\">\r\n<pre class=\"tw-data-text tw-text-large tw-ta\" dir=\"rtl\"><span class=\"Y2IQFc\" lang=\"ar\" xml:lang=\"ar\">حقوق النشر © 2023. كل الحقوق محفوظة.</span></pre>\r\n</div>\r\n<div class=\"tw-target-rmn tw-ta-container F0azHf tw-nfl\"> </div>', '2023-08-19 23:43:21', '2023-08-28 03:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `hero_sections`
--

CREATE TABLE `hero_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_sections`
--

INSERT INTO `hero_sections` (`id`, `language_id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, 20, 'Find Anything From Nearest Location To Make A Booking', 'Link Build is an advanced and modern-looking directory script with rich SEO features where you can create your.', '2023-11-03 23:04:12', '2024-08-07 00:19:09'),
(2, 21, 'ابحث عن أي شيء من أقرب موقع لإجراء الحجز', 'Link Build هو برنامج نصي للدليل متقدم وحديث المظهر مع ميزات SEO غنية حيث يمكنك إنشاء دليلك الخاص.', '2023-11-05 04:06:46', '2024-08-07 00:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `inqury_messages`
--

CREATE TABLE `inqury_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint NOT NULL,
  `service_id` bigint NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `code` char(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `direction` tinyint NOT NULL,
  `is_default` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `direction`, `is_default`, `created_at`, `updated_at`) VALUES
(20, 'English', 'en', 0, 1, '2023-08-17 03:19:12', '2024-08-19 04:33:35'),
(21, 'عربي', 'ar', 1, 0, '2023-08-17 03:19:32', '2024-08-19 04:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int NOT NULL,
  `mail_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mail_subject` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mail_body` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `mail_type`, `mail_subject`, `mail_body`) VALUES
(1, 'verify_email', 'Verify Your Email Address', 0x3c703e44656172203c7374726f6e673e7b757365726e616d657d3c2f7374726f6e673e2c3c2f703e0d0a3c703e5765206a757374206e65656420746f2076657269667920796f757220656d61696c2061646472657373206265666f726520796f752063616e2061636365737320746f20796f75722064617368626f6172642e3c2f703e0d0a3c703e56657269667920796f757220656d61696c20616464726573732c207b766572696669636174696f6e5f6c696e6b7d2e3c2f703e0d0a3c703e5468616e6b20796f752e3c62723e7b776562736974655f7469746c657d3c2f703e),
(2, 'reset_password', 'Recover Password of Your Account', 0x3c703e4869207b637573746f6d65725f6e616d657d2c3c2f703e3c703e576520686176652072656365697665642061207265717565737420746f20726573657420796f75722070617373776f72642e20496620796f7520646964206e6f74206d616b652074686520726571756573742c2069676e6f7265207468697320656d61696c2e204f74686572776973652c20796f752063616e20726573657420796f75722070617373776f7264207573696e67207468652062656c6f77206c696e6b2e3c2f703e3c703e7b70617373776f72645f72657365745f6c696e6b7d3c2f703e3c703e5468616e6b732c3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(3, 'product_order', 'Product Order Has Been Placed', 0x3c703e4869c2a07b637573746f6d65725f6e616d657d2c3c2f703e0d0a3c703e596f7572206f7264657220686173206265656e20706c61636564207375636365737366756c6c792e205765206861766520617474616368656420616e20696e766f69636520696e2074686973206d61696c2e3c6272202f3e4f72646572204e6f3a20237b6f726465725f6e756d6265727d3c2f703e0d0a3c703e7b6f726465725f6c696e6b7d3c2f703e0d0a3c703e4265737420726567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(4, 'package_purchase', 'Package purchase successfull', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e54686973206973206120636f6e6669726d6174696f6e206d61696c2066726f6d2075732e3c6272202f3e596f7572207061796d656e7420686173206265656e2061636365707465642026616d703b20796f7572206d656d6265727368697020697320657874656e6465642e3c6272202f3e3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e0d0a3c703e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(5, 'membership_expiry_reminder', 'Your membership will be expired soon', 0x4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a596f7572206d656d626572736869702077696c6c206265206578706972656420736f6f6e2e3c6272202f3e0d0a596f7572206d656d626572736869702069732076616c69642074696c6c203c7374726f6e673e7b6c6173745f6461795f6f665f6d656d626572736869707d3c2f7374726f6e673e3c6272202f3e0d0a506c6561736520636c69636b2068657265202d207b6c6f67696e5f6c696e6b7d20746f206c6f6720696e746f207468652064617368626f61726420746f2070757263686173652061206e6577207061636b616765202f20657874656e64207468652063757272656e74207061636b61676520746f20657874656e6420796f7572206d656d626572736869702e3c6272202f3e3c6272202f3e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e),
(6, 'membership_expired', 'Your membership is expired', 0x4869207b757365726e616d657d2c3c62723e3c62723e0d0a0d0a596f7572206d656d6265727368697020697320657870697265642e3c62723e0d0a506c6561736520636c69636b2068657265202d207b6c6f67696e5f6c696e6b7d20746f206c6f6720696e746f207468652064617368626f61726420746f2070757263686173652061206e6577207061636b616765202f20657874656e64207468652063757272656e74207061636b61676520746f20636f6e74696e756520746865206d656d626572736869702e3c62723e3c62723e0d0a0d0a4265737420526567617264732c3c62723e0d0a7b776562736974655f7469746c657d2e),
(7, 'package_purchase_membership_accepted', 'package purchase membership accepted', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e54686973206973206120636f6e6669726d6174696f6e206d61696c2066726f6d2075732e3c6272202f3e596f7572207061796d656e7420686173206265656e2061636365707465642026616d703b20796f7572206d656d6265727368697020697320657874656e6465642e3c6272202f3e3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e0d0a3c703e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(8, 'package_purchase_membership_rejected', 'package purchase membership rejected', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e57652061726520736f72727920746f20696e666f726d20796f75207468617420796f7572207061796d656e7420686173206265656e2072656a65637465643c6272202f3e3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(9, 'admin_changed_current_package', 'Admin has changed your current package', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e20686173206368616e67656420796f75722063757272656e74207061636b616765203c623e287b7265706c616365645f7061636b6167657d293c2f623e3c2f703e0d0a3c703e3c623e4e6577205061636b61676520496e666f726d6174696f6e3a3c2f623e3c2f703e0d0a3c703e0d0a3c7374726f6e673e5061636b6167653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e0d0a3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e0d0a3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e0d0a3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e3c703e3c6272202f3e3c2f703e3c703e5765206861766520617474616368656420616e20696e766f69636520776974682074686973206d61696c2e3c6272202f3e0d0a5468616e6b20796f7520666f7220796f75722070757263686173652e3c2f703e3c703e3c6272202f3e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e3c2f703e),
(10, 'admin_added_current_package', 'Admin has added current package for you', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e206861732061646465642063757272656e74207061636b61676520666f7220796f753c2f703e3c703e3c623e3c7370616e207374796c653d22666f6e742d73697a653a313870783b223e43757272656e74204d656d6265727368697020496e666f726d6174696f6e3a3c2f7370616e3e3c2f623e3c6272202f3e0d0a3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e0d0a3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e0d0a3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e0d0a3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e3c703e3c6272202f3e3c2f703e3c703e5765206861766520617474616368656420616e20696e766f69636520776974682074686973206d61696c2e3c6272202f3e0d0a5468616e6b20796f7520666f7220796f75722070757263686173652e3c2f703e3c703e3c6272202f3e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e3c2f703e),
(11, 'admin_changed_next_package', 'Admin has changed your next package', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e20686173206368616e67656420796f7572206e657874207061636b616765203c623e287b7265706c616365645f7061636b6167657d293c2f623e3c2f703e3c703e3c623e3c7370616e207374796c653d22666f6e742d73697a653a313870783b223e4e657874204d656d6265727368697020496e666f726d6174696f6e3a3c2f7370616e3e3c2f623e3c6272202f3e0d0a3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e0d0a3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e0d0a3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e0d0a3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e3c703e3c6272202f3e3c2f703e3c703e5765206861766520617474616368656420616e20696e766f69636520776974682074686973206d61696c2e3c6272202f3e0d0a5468616e6b20796f7520666f7220796f75722070757263686173652e3c2f703e3c703e3c6272202f3e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e3c2f703e),
(12, 'admin_added_next_package', 'Admin has added next package for you', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e20686173206164646564206e657874207061636b61676520666f7220796f753c2f703e3c703e3c623e3c7370616e207374796c653d22666f6e742d73697a653a313870783b223e4e657874204d656d6265727368697020496e666f726d6174696f6e3a3c2f7370616e3e3c2f623e3c6272202f3e0d0a3c7374726f6e673e5061636b616765205469746c653a3c2f7374726f6e673e207b7061636b6167655f7469746c657d3c6272202f3e0d0a3c7374726f6e673e5061636b6167652050726963653a3c2f7374726f6e673e207b7061636b6167655f70726963657d3c6272202f3e0d0a3c7374726f6e673e41637469766174696f6e20446174653a3c2f7374726f6e673e207b61637469766174696f6e5f646174657d3c6272202f3e0d0a3c7374726f6e673e45787069726520446174653a3c2f7374726f6e673e207b6578706972655f646174657d3c2f703e3c703e3c6272202f3e3c2f703e3c703e5765206861766520617474616368656420616e20696e766f69636520776974682074686973206d61696c2e3c6272202f3e0d0a5468616e6b20796f7520666f7220796f75722070757263686173652e3c2f703e3c703e3c6272202f3e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e3c2f703e),
(13, 'admin_removed_current_package', 'Admin has removed current package for you', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e206861732072656d6f7665642063757272656e74207061636b616765202d203c7374726f6e673e7b72656d6f7665645f7061636b6167655f7469746c657d3c2f7374726f6e673e3c62723e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e),
(14, 'admin_removed_next_package', 'Admin has removed next package for you', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e0d0a0d0a41646d696e206861732072656d6f766564206e657874207061636b616765202d203c7374726f6e673e7b72656d6f7665645f7061636b6167655f7469746c657d3c2f7374726f6e673e3c62723e0d0a0d0a4265737420526567617264732c3c6272202f3e0d0a7b776562736974655f7469746c657d2e3c6272202f3e),
(15, 'service_payment_rejected', 'Your payment is rejected', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e57652072656772657420746f20696e666f726d20796f75207468617420796f757220626f6f6b696e672072657175657374207061796d656e7420686173206265656e2072656a65637465642e3c2f703e0d0a3c64697620636c6173733d22666c657820666c65782d67726f7720666c65782d636f6c206d61782d772d66756c6c223e0d0a3c64697620636c6173733d226d696e2d682d5b323070785d20746578742d6d65737361676520666c657820666c65782d636f6c206974656d732d7374617274206761702d3320776869746573706163652d7072652d7772617020627265616b2d776f726473205b2e746578742d6d6573736167652b26616d703b5d3a6d742d35206f766572666c6f772d782d6175746f223e0d0a3c64697620636c6173733d226d61726b646f776e2070726f736520772d66756c6c20627265616b2d776f726473206461726b3a70726f73652d696e76657274206461726b223e0d0a3c703e3c7374726f6e673e53657276696365204e616d653a3c2f7374726f6e673e207b736572766963655f6e616d657d3c6272202f3e3c7374726f6e673e4f72656465722050726963653a3c2f7374726f6e673e207b70726963657d3c2f703e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c703e3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(16, 'service_payment_approved', 'Your payment is approved', 0x3c703e4869207b637573746f6d65725f6e616d657d2c3c6272202f3e57652072656772657420746f20696e666f726d20796f75207468617420796f757220626f6f6b696e672072657175657374207061796d656e7420686173206265656e20617070726f7665642ec2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0205761697420666f722074686520626f6f6b696e6720636f6e6669726d6174696f6e206d61696c2e3c2f703e0d0a3c64697620636c6173733d22666c657820666c65782d67726f7720666c65782d636f6c206d61782d772d66756c6c223e0d0a3c64697620636c6173733d226d696e2d682d5b323070785d20746578742d6d65737361676520666c657820666c65782d636f6c206974656d732d7374617274206761702d3320776869746573706163652d7072652d7772617020627265616b2d776f726473205b2e746578742d6d6573736167652b26616d703b5d3a6d742d35206f766572666c6f772d782d6175746f223e0d0a3c64697620636c6173733d226d61726b646f776e2070726f736520772d66756c6c20627265616b2d776f726473206461726b3a70726f73652d696e76657274206461726b223e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e53657276696365205469746c653c7374726f6e673e3a3c2f7374726f6e673e207b736572766963655f7469746c657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e50726963653c7374726f6e673e3a3c2f7374726f6e673e207b70726963657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e426f6f6b696e6720446174653a207b626f6f6b696e675f646174657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e4170706f696e746d656e7420446174653a207b6170706f696e746d656e745f646174657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e4170706f696e746d656e742054696d653a207b6170706f696e746d656e745f74696d657d3c2f703e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c703e3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(18, 'service_booking_accepted', 'Your appointment is accepted', 0x3c703e4869c2a07b637573746f6d65725f6e616d657d2c3c2f703e0d0a3c703e596f7572206170706f696e746d656e7420686173206265656e2061636365707465642e205765206861766520617474616368656420616e20696e766f69636520746f2074686973206d61696c2e3c6272202f3e426f6f6b696e67204e6f3a20237b626f6f6b696e675f6e756d6265727d3c2f703e0d0a3c703e53657276696365205469746c653a207b736572766963655f7469746c657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e7b6f726465725f6c696e6b7d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e7b7a6f6f6d5f6c696e6b7d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e7b7a6f6f6d5f70617373776f72647d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e426f6f6b696e6720446174653a207b626f6f6b696e675f646174657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e4170706f696e746d656e7420446174653a207b6170706f696e746d656e745f646174657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e4170706f696e746d656e742054696d653a207b6170706f696e746d656e745f74696d657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223ec2a03c2f703e0d0a3c703e4265737420726567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(19, 'service_booking_rejected', 'Your appointment is rejected', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e57652072656772657420746f20696e666f726d20796f75207468617420796f757220616170706f696e746d656e74207265717565737420686173206265656e2072656a65637465642e3c2f703e0d0a3c64697620636c6173733d22666c657820666c65782d67726f7720666c65782d636f6c206d61782d772d66756c6c223e0d0a3c64697620636c6173733d226d696e2d682d5b323070785d20746578742d6d65737361676520666c657820666c65782d636f6c206974656d732d7374617274206761702d3320776869746573706163652d7072652d7772617020627265616b2d776f726473205b2e746578742d6d6573736167652b26616d703b5d3a6d742d35206f766572666c6f772d782d6175746f223e0d0a3c64697620636c6173733d226d61726b646f776e2070726f736520772d66756c6c20627265616b2d776f726473206461726b3a70726f73652d696e76657274206461726b223e0d0a3c703e3c7374726f6e673e53657276696365204e616d653a3c2f7374726f6e673e207b736572766963655f6e616d657d3c6272202f3e3c7374726f6e673e4f72656465722050726963653a3c2f7374726f6e673e207b70726963657d3c2f703e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c703e3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(20, 'featured_request_send', 'Your payment for featured service is accepted', 0x3c703e4869207b757365726e616d657d2c3c2f703e0d0a3c703e546869732069732061207061796d656e7420636f6e6669726d6174696f6e206d61696c2066726f6d2075732e3c6272202f3e5761697420666f7220746865206f7264657220636f6e6669726d6174696f6e206d61696c2e3c2f703e0d0a3c703e3c7374726f6e673e53657276696365205469746c653a3c2f7374726f6e673e207b736572766963655f7469746c657d3c6272202f3e3c7374726f6e673e4f7264657220416d6f756e743a3c2f7374726f6e673e207b616d6f756e747d3c2f703e0d0a3c703e4265737420726567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(21, 'featured_request_payment_approved', 'Your payment for the featured service is approved', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e57652072656772657420746f20696e666f726d20796f75207468617420796f757220626f6f6b696e672072657175657374207061796d656e7420686173206265656e20617070726f7665642ec2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0c2a0205761697420666f7220746865206f7264657220636f6e6669726d6174696f6e206d61696c2e3c2f703e0d0a3c64697620636c6173733d22666c657820666c65782d67726f7720666c65782d636f6c206d61782d772d66756c6c223e0d0a3c64697620636c6173733d226d696e2d682d5b323070785d20746578742d6d65737361676520666c657820666c65782d636f6c206974656d732d7374617274206761702d3320776869746573706163652d7072652d7772617020627265616b2d776f726473205b2e746578742d6d6573736167652b26616d703b5d3a6d742d35206f766572666c6f772d782d6175746f223e0d0a3c64697620636c6173733d226d61726b646f776e2070726f736520772d66756c6c20627265616b2d776f726473206461726b3a70726f73652d696e76657274206461726b223e0d0a3c703e3c7374726f6e673e53657276696365205469746c653a3c2f7374726f6e673e207b736572766963655f7469746c657d3c6272202f3e3c7374726f6e673e4f7264657220416d6f756e743a3c2f7374726f6e673e207b616d6f756e747d3c2f703e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c703e3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(22, 'featured_request_payment_rejected', 'Your payment for featured service is reject', 0x3c70207374796c653d226c696e652d6865696768743a312e323b223e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e57652061726520736f72727920746f20696e666f726d20796f75207468617420796f7572207061796d656e7420686173206265656e2072656a65637465642e3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a312e323b223e3c7374726f6e673e53657276696365205469746c653a3c2f7374726f6e673e207b736572766963655f7469746c657d3c6272202f3e3c7374726f6e673e4f7264657220416d6f756e743a3c2f7374726f6e673e207b616d6f756e747d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a312e323b223e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(23, 'featured_request_approved', 'Your request to feature service is approved', 0x3c70207374796c653d226c696e652d6865696768743a313b223e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e5765206861766520617070726f76656420796f757220726571756573742e3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e596f7572207365727669636520697320666561747572656420666f72207b6461797d20646179732e20c2a03c2f703e0d0a3c703e3c7374726f6e673e3c7370616e207374796c653d22666f6e742d73697a653a313870783b223e4f7264657220496e666f726d6174696f6e3a3c2f7370616e3e3c2f7374726f6e673e3c6272202f3e3c7374726f6e673e53657276696365205469746c653a3c2f7374726f6e673e207b736572766963655f7469746c657d3c6272202f3e3c7374726f6e673e537461727420446174653a3c2f7374726f6e673e207b73746172745f646174657d3c6272202f3e3c7374726f6e673e456e6420446174653a3c2f7374726f6e673e207b656e645f646174657d3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e5468616e6b20796f7520666f7220796f75722070757263686173652e3c2f703e0d0a3c70207374796c653d226c696e652d6865696768743a313b223e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(24, 'featured_request_rejected', 'Your request to feature service is rejected', 0x3c703e4869207b757365726e616d657d2c3c6272202f3e3c6272202f3e57652061726520736f72727920746f20696e666f726d20796f75207468617420796f75722066656174757265642073657276696365207265717565737420686173206265656e2072656a65637465642e3c6272202f3e3c7374726f6e673e53657276696365205469746c65203a3c2f7374726f6e673e207b736572766963655f7469746c657d3c6272202f3e3c7374726f6e673e4f7264657220416d6f756e74203a3c2f7374726f6e673e207b616d6f756e747d3c2f703e0d0a3c703e3c6272202f3e4265737420526567617264732c3c6272202f3e7b776562736974655f7469746c657d2e3c2f703e),
(32, 'withdraw_approved', 'Confirmation of Withdraw Approved', 0x3c70207374796c653d22666f6e742d66616d696c793a4c61746f2c2073616e732d73657269663b666f6e742d73697a653a313470783b6c696e652d6865696768743a312e38323b636f6c6f723a72676228302c302c30293b666f6e742d7374796c653a6e6f726d616c3b666f6e742d7765696768743a3430303b746578742d616c69676e3a6c6566743b223e4869207b757365726e616d657d2c3c2f703e0d0a3c70207374796c653d22666f6e742d66616d696c793a4c61746f2c2073616e732d73657269663b666f6e742d73697a653a313470783b6c696e652d6865696768743a312e38323b636f6c6f723a72676228302c302c30293b666f6e742d7374796c653a6e6f726d616c3b666f6e742d7765696768743a3430303b746578742d616c69676e3a6c6566743b223e5468697320656d61696c20636f6e6669726d73207468617420796f7572207769746864726177616c2072657175657374c2a0207b77697468647261775f69647d20697320617070726f7665642ec2a03c2f703e0d0a3c70207374796c653d22666f6e742d66616d696c793a4c61746f2c2073616e732d73657269663b666f6e742d73697a653a313470783b6c696e652d6865696768743a312e38323b636f6c6f723a72676228302c302c30293b666f6e742d7374796c653a6e6f726d616c3b666f6e742d7765696768743a3430303b746578742d616c69676e3a6c6566743b223e596f75722063757272656e742062616c616e6365206973207b63757272656e745f62616c616e63657d2c20776974686472617720616d6f756e74207b77697468647261775f616d6f756e747d2c20636861726765203a207b6368617267657d2c70617961626c6520616d6f756e74207b70617961626c655f616d6f756e747d3c2f703e0d0a3c70207374796c653d22666f6e742d66616d696c793a4c61746f2c2073616e732d73657269663b666f6e742d73697a653a313470783b6c696e652d6865696768743a312e38323b636f6c6f723a72676228302c302c30293b666f6e742d7374796c653a6e6f726d616c3b666f6e742d7765696768743a3430303b746578742d616c69676e3a6c6566743b223e4265737420526567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(33, 'withdraw_declined', 'Withdraw Request Rejected', 0x3c703e4869207b757365726e616d657d2c3c2f703e0d0a3c703e5468697320656d61696c20636f6e6669726d73207468617420796f7572207769746864726177616c2072657175657374c2a0207b77697468647261775f69647d2069732072656a656374656420616e64207468652062616c616e636520616464656420746f20796f7572206163636f756e742ec2a03c2f703e0d0a3c703e596f75722063757272656e742062616c616e6365206973207b63757272656e745f62616c616e63657d3c2f703e0d0a3c703e4265737420526567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(34, 'balance_added', 'Balance Added', 0x3c703e4869207b757365726e616d657d3c2f703e0d0a3c703e7b616d6f756e747d20616464656420746f20796f7572206163636f756e742e3c2f703e0d0a3c703e596f75722063757272656e742062616c616e6365206973207b63757272656e745f62616c616e63657d2e3c2f703e0d0a3c703e546865207472616e73616374696f6e206964206973207b7472616e73616374696f6e5f69647d2e3c2f703e0d0a3c703ec2a03c2f703e0d0a3c703e4265737420526567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e0d0a3c703ec2a03c2f703e),
(35, 'balance_subtracted', 'Balance Subtract', 0x3c703e4869207b757365726e616d657d3c2f703e0d0a3c703e7b616d6f756e747d2073756274726163742066726f6d20796f7572206163636f756e742e3c2f703e0d0a3c703e596f75722063757272656e742062616c616e6365206973207b63757272656e745f62616c616e63657d2e3c2f703e0d0a3c703e546865207472616e73616374696f6e206964206973207b7472616e73616374696f6e5f69647d2e3c2f703e0d0a3c703e4265737420526567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e),
(41, 'service_inquery', 'Inquiry About Service', 0x3c64697620636c6173733d22223e0d0a3c64697620636c6173733d226969206774223e0d0a3c64697620636c6173733d226133732061694c223e0d0a3c703ec2a03c2f703e0d0a3c646976207374796c653d226d617267696e3a20303b20626f782d73697a696e673a20626f726465722d626f783b20636f6c6f723a20233061306130613b20666f6e742d66616d696c793a205461686f6d612c274c7563696461204772616e6465272c274c75636964612053616e73272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a20313670783b20666f6e742d7765696768743a206e6f726d616c3b206c696e652d6865696768743a20313970783b206d696e2d77696474683a20313030253b2070616464696e673a20303b20746578742d616c69676e3a206c6566743b2077696474683a203130302521696d706f7274616e743b223e0d0a3c7461626c65207374796c653d226d617267696e3a20303b206261636b67726f756e643a20236633663566383b20626f726465722d636f6c6c617073653a20636f6c6c617073653b20626f726465722d73706163696e673a20303b20636f6c6f723a20233061306130613b20666f6e742d66616d696c793a205461686f6d612c274c7563696461204772616e6465272c274c75636964612053616e73272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a20313670783b20666f6e742d7765696768743a206e6f726d616c3b206865696768743a20313030253b206c696e652d6865696768743a20313970783b2070616464696e673a20303b20746578742d616c69676e3a206c6566743b20766572746963616c2d616c69676e3a20746f703b2077696474683a20313030253b223e0d0a3c74626f64793e0d0a3c7472207374796c653d2270616464696e673a303b746578742d616c69676e3a6c6566743b223e0d0a3c7464207374796c653d226d617267696e3a20303b20626f726465722d636f6c6c617073653a20636f6c6c6170736521696d706f7274616e743b20636f6c6f723a20233061306130613b20666f6e742d66616d696c793a205461686f6d612c274c7563696461204772616e6465272c274c75636964612053616e73272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a20313670783b20666f6e742d7765696768743a206e6f726d616c3b206c696e652d6865696768743a20313970783b2070616464696e673a20303b20746578742d616c69676e3a206c6566743b20766572746963616c2d616c69676e3a20746f703b20776f72642d777261703a20627265616b2d776f72643b223e0d0a3c646976207374796c653d2270616464696e672d6c6566743a203136707821696d706f7274616e743b2070616464696e672d72696768743a203136707821696d706f7274616e743b223e3c6272202f3ec2a020c2a020c2a020c2a020c2a020c2a020c2a0c2a03c6272202f3ec2a020c2a020c2a020c2a020c2a020c2a020c2a00d0a3c7461626c65207374796c653d226d617267696e3a2030206175746f3b206261636b67726f756e643a20236635663566663b20626f726465723a2031707820736f6c696420236434646365323b20626f726465722d636f6c6c617073653a20636f6c6c617073653b20626f726465722d73706163696e673a20303b206d696e2d77696474683a2035303070783b2070616464696e673a20303b20746578742d616c69676e3a20696e68657269743b20766572746963616c2d616c69676e3a20746f703b2077696474683a2035383070783b223e0d0a3c74626f64793e0d0a3c7472207374796c653d2270616464696e673a303b746578742d616c69676e3a6c6566743b223e0d0a3c7464207374796c653d226d617267696e3a20303b20626f726465722d636f6c6c617073653a20636f6c6c6170736521696d706f7274616e743b20636f6c6f723a20233061306130613b20666f6e742d66616d696c793a205461686f6d612c274c7563696461204772616e6465272c274c75636964612053616e73272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a20313670783b20666f6e742d7765696768743a206e6f726d616c3b206c696e652d6865696768743a20313970783b2070616464696e673a20303b20746578742d616c69676e3a206c6566743b20766572746963616c2d616c69676e3a20746f703b20776f72642d777261703a20627265616b2d776f72643b223e3c6272202f3e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e44656172207b757365726e616d657d2c3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e5468697320656d61696c20696e666f726d7320796f75207468617420616e20656e71756972657220697320747279696e6720746f20636f6e7461637420796f752e20486572652069732074686520696e666f726d6174696f6e2061626f75742074686520656e7175697265722e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e53657276696365204e616d653a207b736572766963655f6e616d657d2e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e456e717569726572204e616d653a207b656e7175697265725f6e616d657d2e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e456e71756972657220456d61696c3a207b656e7175697265725f656d61696c7d2e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e4d6573736167653a3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e7b656e7175697265725f6d6573736167657d2e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223ec2a03c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a343070783b223e4265737420526567617264732e3c6272202f3e7b776562736974655f7469746c657d3c2f703e0d0ac2a03c6272202f3ec2a020c2a020c2a020c2a020c2a020c2a020c2a020c2a03c6272202f3ec2a020c2a020c2a020c2a020c2a020c2a020c2a03c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0ac2a03c2f6469763e0d0ac2a020c2a020c2a020c2a03c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c703ec2a03c2f703e);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `price` double DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `is_trial` tinyint NOT NULL DEFAULT '0',
  `trial_days` int NOT NULL DEFAULT '0',
  `receipt` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `transaction_details` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `settings` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `package_id` bigint DEFAULT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `modified` tinyint DEFAULT NULL COMMENT '1 - modified by Admin, 0 - not modified by Admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `price`, `currency`, `currency_symbol`, `payment_method`, `transaction_id`, `status`, `is_trial`, `trial_days`, `receipt`, `transaction_details`, `settings`, `package_id`, `vendor_id`, `start_date`, `expire_date`, `modified`, `created_at`, `updated_at`) VALUES
(1, 999, 'NGN', '$', 'PayPal', '001e8f29', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-M3CH7ZQ6F953851PE266524L\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"18X13481H3043332U\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"12.49\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"12.49\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"12.49\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"1HE76796D53431257\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"12.49\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"12.49\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"0.93\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-M3CH7ZQ6F953851PE266524L\",\n                        \"create_time\": \"2024-08-20T11:37:26Z\",\n                        \"update_time\": \"2024-08-20T11:37:26Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/1HE76796D53431257\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/1HE76796D53431257/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CH7ZQ6F953851PE266524L\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://bookapp.test/vendor/membership/paypal/success?paymentId=PAYID-M3CH7ZQ6F953851PE266524L\",\n        \"cancel_url\": \"https://bookapp.test/vendor/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2024-08-20T11:37:10Z\",\n    \"update_time\": \"2024-08-20T11:37:26Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CH7ZQ6F953851PE266524L\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"NGN\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"1099.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 1, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:37:27', '2024-08-20 05:37:27'),
(2, 999, 'NGN', '$', 'Paystack', 'c53a0500', 1, 0, 0, NULL, '\"vz9ip90o4r\"', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"NGN\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"2098.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 2, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:51:58', '2024-08-20 05:51:58'),
(3, 999, 'USD', '$', 'Stripe', '29f7b91e', 1, 0, 0, NULL, '{\"id\":\"ch_3PpqclJlIV5dN9n71AlIznla\",\"object\":\"charge\",\"amount\":99900,\"amount_captured\":99900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PpqclJlIV5dN9n71ssJuXZN\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1724154799,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are extending your membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"customer_name\":\"PipeMaster Pro\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":2,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PpqcjJlIV5dN9n7SJL4Qb8u\",\"payment_method_details\":{\"card\":{\"amount_authorized\":99900,\"authorization_code\":null,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":4,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":99900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"pipemasterpro@example.com\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KLCHkrYGMgbJEy0EvdY6LBYS9Bo4UnAMelO3L_pv3EkCrnRWnCHy1dLBdTSCp-yU8KUKohMOZW-OCiD7\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3PpqclJlIV5dN9n71AlIznla\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PpqcjJlIV5dN9n7SJL4Qb8u\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"3097.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 3, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:53:20', '2024-08-20 05:53:20'),
(4, 999, 'USD', '$', 'PayPal', 'a42b17e6', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-M3CIHTI97L38581MG7801942\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"8AS932715D074043G\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"999.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"999.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"999.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"04C98365C0246884B\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"999.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"999.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"35.36\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-M3CIHTI97L38581MG7801942\",\n                        \"create_time\": \"2024-08-20T11:54:08Z\",\n                        \"update_time\": \"2024-08-20T11:54:08Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/04C98365C0246884B\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/04C98365C0246884B/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIHTI97L38581MG7801942\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://bookapp.test/vendor/membership/paypal/success?paymentId=PAYID-M3CIHTI97L38581MG7801942\",\n        \"cancel_url\": \"https://bookapp.test/vendor/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2024-08-20T11:53:49Z\",\n    \"update_time\": \"2024-08-20T11:54:08Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIHTI97L38581MG7801942\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"4096.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 4, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:54:10', '2024-08-20 05:54:10'),
(5, 999, 'USD', '$', 'PayPal', '0635de1a', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-M3CIIBQ5YT54580CG105411W\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"80D15997HE147123C\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"999.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"999.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"999.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"02S72871Y9490274S\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"999.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"999.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"35.36\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-M3CIIBQ5YT54580CG105411W\",\n                        \"create_time\": \"2024-08-20T11:55:00Z\",\n                        \"update_time\": \"2024-08-20T11:55:00Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/02S72871Y9490274S\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/02S72871Y9490274S/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIIBQ5YT54580CG105411W\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://bookapp.test/vendor/membership/paypal/success?paymentId=PAYID-M3CIIBQ5YT54580CG105411W\",\n        \"cancel_url\": \"https://bookapp.test/vendor/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2024-08-20T11:54:46Z\",\n    \"update_time\": \"2024-08-20T11:55:00Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIIBQ5YT54580CG105411W\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"5095.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 5, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:55:01', '2024-08-20 05:55:01'),
(6, 999, 'USD', '$', 'Stripe', '19f230c7', 1, 0, 0, NULL, '{\"id\":\"ch_3PpqewJlIV5dN9n71GZGGPu3\",\"object\":\"charge\",\"amount\":99900,\"amount_captured\":99900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PpqewJlIV5dN9n71KyOVLkw\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1724154934,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are extending your membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"customer_name\":\"Style Sharp\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":53,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PpqevJlIV5dN9n7OMzibK7G\",\"payment_method_details\":{\"card\":{\"amount_authorized\":99900,\"authorization_code\":null,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":4,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":99900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"stylesharp@example.com\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KLeIkrYGMga04cgamj06LBY3AaT-ptdw3xsLbh6yUnwY8a1W7vjModwOOuQBV-1m3xmjJ-WC63x3L3vK\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3PpqewJlIV5dN9n71GZGGPu3\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PpqevJlIV5dN9n7OMzibK7G\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"6094.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 7, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:55:36', '2024-08-20 05:55:36');
INSERT INTO `memberships` (`id`, `price`, `currency`, `currency_symbol`, `payment_method`, `transaction_id`, `status`, `is_trial`, `trial_days`, `receipt`, `transaction_details`, `settings`, `package_id`, `vendor_id`, `start_date`, `expire_date`, `modified`, `created_at`, `updated_at`) VALUES
(7, 999, 'USD', '$', 'PayPal', '4fef321a', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-M3CIIXA2SM928108R824184K\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"6JG75032KG060130N\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"999.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"999.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"999.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"2U5579854H435645J\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"999.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"999.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"35.36\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-M3CIIXA2SM928108R824184K\",\n                        \"create_time\": \"2024-08-20T11:56:22Z\",\n                        \"update_time\": \"2024-08-20T11:56:22Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/2U5579854H435645J\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/2U5579854H435645J/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIIXA2SM928108R824184K\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://bookapp.test/vendor/membership/paypal/success?paymentId=PAYID-M3CIIXA2SM928108R824184K\",\n        \"cancel_url\": \"https://bookapp.test/vendor/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2024-08-20T11:56:12Z\",\n    \"update_time\": \"2024-08-20T11:56:22Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-M3CIIXA2SM928108R824184K\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":2,\"uniqid\":12345,\"favicon\":\"665ad358a5c93.png\",\"logo\":\"665ad34ec51e8.png\",\"logo_two\":\"64ed7071b1844.png\",\"website_title\":\"Bookapp\",\"email_address\":\"masud.cst0@gmail.com\",\"contact_number\":\"+701 - 1111 - 2222 - 3333\",\"address\":\"450 Young Road, New York, USA\",\"theme_version\":1,\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"80.00\",\"primary_color\":\"16FB75\",\"smtp_status\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":587,\"encryption\":\"TLS\",\"smtp_username\":\"ranaahmed269205@gmail.com\",\"smtp_password\":\"uvan rtvs rzmk zqnp\",\"from_mail\":\"ranaahmed269205@gmail.com\",\"from_name\":\"Bookapp\",\"to_mail\":\"ranaahmed269205@gmail.com\",\"breadcrumb\":\"665c0113e4305.png\",\"disqus_status\":1,\"disqus_short_name\":\"Hello there\",\"google_recaptcha_status\":0,\"google_recaptcha_site_key\":\"6Lf3bOgpAAAAAOqUfSMooqy7VUzWpFk_F15Aiemv\",\"google_recaptcha_secret_key\":\"6Lf3bOgpAAAAAHvJ1IPC-44LgGiTP0a3LUhVupAK\",\"whatsapp_status\":1,\"whatsapp_number\":\"+8801306084771\",\"whatsapp_header_title\":\"Hi, there!\",\"whatsapp_popup_status\":1,\"whatsapp_popup_message\":\"If you have any issues, let us know.\",\"maintenance_img\":\"664d8c21dcf58.png\",\"maintenance_status\":0,\"maintenance_msg\":\"We are upgrading our site. We will come back soon. \\r\\nPlease stay with us.\\r\\nThank you.\",\"bypass_token\":\"-1\",\"footer_logo\":\"66c432d5bfd73.png\",\"footer_background_image\":\"638db9bf3f92a.jpg\",\"admin_theme_version\":\"dark\",\"call_to_action_section_image\":\"666920a95f5aa.png\",\"call_to_action_section_inner_image\":\"665ad21ebc3c4.png\",\"testimonial_section_image\":\"665eaa85d2f29.png\",\"category_section_background\":\"6652b9c7cd0fe.png\",\"google_adsense_publisher_id\":null,\"equipment_tax_amount\":\"5.00\",\"product_tax_amount\":\"5.00\",\"self_pickup_status\":1,\"two_way_delivery_status\":1,\"guest_checkout_status\":0,\"shop_status\":1,\"facebook_login_status\":1,\"facebook_app_id\":\"882678273570258\",\"facebook_app_secret\":\"bb014c58bd4e278315db8b39703dc23e\",\"google_login_status\":1,\"google_client_id\":\"839746240383-1dhilrs0dpqsjel8bas6og7fmusoqm8s.apps.googleusercontent.com\",\"google_client_secret\":\"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\",\"tawkto_status\":0,\"tawkto_direct_chat_link\":\"fsfs\",\"vendor_admin_approval\":1,\"vendor_email_verification\":1,\"admin_approval_notice\":\"Your account is deactive or pending now please contact with admin.\",\"expiration_reminder\":3,\"timezone\":\"Asia\\/Dhaka\",\"time_format\":\"12\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=9l6RywtDlKA\",\"work_process_background_img\":\"\",\"hero_section_background_img\":\"66c43390d7955.png\",\"contact_title\":\"Get Connected\",\"contact_subtile\":\"How Can We Help You?\",\"contact_details\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores pariatur a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat veritatis architecto. Aliquid doloremque nesciunt nobis, debitis, quas veniam.\\r\\n\\r\\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores a ea similique quod dicta ipsa vel quidem repellendus, beatae nulla veniam, quaerat.\",\"latitude\":\"23.87\",\"longitude\":\"90.3925747\",\"zoom_account_id\":\"DJdOgRA0Qeu_fmTaZs2jgQ\",\"about_section_image\":\"665eea3b8fdc6.jpg\",\"zoom_client_id\":\"o5WOMDggROmTRnLX1Ujh_Q\",\"zoom_client_secret\":\"tKjLoIyqeQAzhXvqTAZqqtZ28P2v43KL\",\"google_calendar\":\"66bb195d5c6dd.json\",\"calender_id\":\"e1f4099b68a8314464ed4aab960fe0f8100473c829e9ec8a54f90552014fff85@group.calendar.google.com\",\"preloader_status\":1,\"preloader\":\"665d847dd0147.gif\",\"admin_profit\":\"7093.00\",\"google_map_api_key\":\"AIzaSyD52gXImf3sVNUbqmhy1DqaLHyQMb41-P0\",\"updated_at\":\"2024-08-20T11:33:38.000000Z\"}', 9, 6, '2024-08-20', '9999-12-31', NULL, '2024-08-20 05:56:23', '2024-08-20 05:56:23');

-- --------------------------------------------------------

--
-- Table structure for table `menu_builders`
--

CREATE TABLE `menu_builders` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `menus` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `menu_builders`
--

INSERT INTO `menu_builders` (`id`, `language_id`, `menus`, `created_at`, `updated_at`) VALUES
(7, 20, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Services\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"services\"},{\"text\":\"Pricing\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"pricing\"},{\"text\":\"Vendors\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"vendors\"},{\"text\":\"Shop\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"Products\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"shop\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"}]},{\"text\":\"Pages\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"},{\"text\":\"About Us\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"about-us\"}]},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-08-17 03:19:12', '2024-09-08 01:06:57'),
(8, 21, '[{\"text\":\"بيت\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"خدمات\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"services\"},{\"text\":\"التسعير\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"pricing\"},{\"text\":\"الباعة\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"vendors\"},{\"text\":\"محل\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"محل\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"shop\"},{\"text\":\"عربة التسوق\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"الدفع\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"}]},{\"text\":\"الصفحات\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"type\":\"blog\",\"text\":\"مدونة\",\"target\":\"_self\"},{\"text\":\"التعليمات\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"},{\"type\":\"about-us\",\"text\":\"معلومات عنا\",\"target\":\"_self\"},{\"text\":\"سياسة الخصوصية\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"سياسة-الخصوصية\"},{\"text\":\"الأحكام والشروط\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"الأحكام-والشروط\"}]},{\"text\":\"اتصال\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-08-17 03:19:32', '2024-09-01 00:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2022_12_03_045612_create_categories_table', 1),
(4, '2022_12_03_052255_create_car_conditions_table', 2),
(5, '2022_12_03_054801_create_brands_table', 3),
(7, '2022_12_03_060847_create_car_models_table', 4),
(8, '2022_12_03_064939_create_body_types_table', 5),
(9, '2022_12_03_070920_create_fuel_types_table', 6),
(10, '2022_12_03_072332_create_transmission_types_table', 7),
(13, '2022_12_03_091043_create_cars_table', 8),
(14, '2022_12_03_092034_create_car_contents_table', 8),
(15, '2022_12_03_092907_create_car_images_table', 8),
(17, '2022_12_05_105806_create_packages_table', 9),
(18, '2022_12_05_120323_create_memberships_table', 10),
(19, '2023_01_19_100849_create_counter_sections_table', 11),
(20, '2023_01_19_105743_create_category_sections_table', 12),
(22, '2023_01_19_113013_create_banners_table', 13),
(23, '2023_07_12_050445_create_contact_page_contents_table', 14),
(28, '2023_07_20_065153_create_car_specifications_table', 15),
(29, '2023_07_20_082448_create_car_specification_contents_table', 15),
(32, '2023_08_05_061440_create_visitors_table', 16),
(33, '2023_08_08_044236_add_columns_to_users_table', 17),
(34, '2023_11_04_044919_create_hero_sections_table', 18),
(36, '2023_11_04_111921_create_latest_services_table', 19),
(37, '2023_11_05_043623_create_vendor_sections_table', 20),
(40, '2023_11_19_052234_create_services_table', 21),
(41, '2023_11_20_063140_create_services_categories_table', 22),
(42, '2023_11_27_044259_add_user_id_to_services_table', 23),
(43, '2023_11_28_033707_create_service_contents_table', 23),
(44, '2023_11_28_044448_create_staff_table', 24),
(45, '2023_11_28_064419_create_user_locations_table', 24),
(46, '2023_11_29_055140_create_staff_locations_table', 25),
(51, '2023_11_29_092515_create_staff_table', 26),
(52, '2023_11_30_070508_create_staff_services_table', 27),
(53, '2023_12_04_031237_create_staff_contents_table', 28),
(54, '2024_01_02_060416_create_staff_holidays_table', 29),
(55, '2024_01_02_062015_create_staff_global_days_table', 30),
(56, '2024_01_02_102711_create_stff_global_service_houres_table', 31),
(57, '2024_01_03_041815_create_staff_service_hours_table', 32),
(58, '2024_01_03_072233_create_staff_days_table', 33),
(59, '2024_01_08_053338_create_staff_global_days_table', 34),
(60, '2024_01_19_140547_create_service_bookings_table', 35),
(61, '2024_01_25_152902_create_staff_global_hours_table', 36),
(62, '2024_01_26_045624_create_staff_global_holidays_table', 37),
(63, '2024_01_27_081022_create_service_images_table', 38),
(64, '2024_01_28_084403_create_booking_messages_table', 39),
(65, '2024_02_01_081311_create_service_reviews_table', 40),
(66, '2024_02_05_055704_create_featured_service_charges_table', 41),
(67, '2024_02_05_084907_create_service_promotions_table', 42),
(68, '2024_02_11_040710_create_plugins_table', 43),
(69, '2024_02_11_042133_create_vendor_plugins_table', 44),
(70, '2024_02_17_053530_create_transactions_table', 45),
(71, '2024_02_17_150005_create_withdraw_payments_table', 46),
(72, '2024_02_18_033137_create_withdraw_method_inputs_table', 47),
(73, '2024_02_18_034732_create_withdraw_method_options_table', 48),
(74, '2024_02_18_043547_create_withdraws_table', 49),
(75, '2024_02_18_062618_create_withdraw_payment_methods_table', 50),
(76, '2024_03_02_092701_create_admin_global_times_table', 51),
(77, '2024_03_02_093040_create_admin_global_days_table', 52),
(78, '2024_03_14_054209_create_about_us_table', 53),
(79, '2024_03_23_050231_create_features_table', 54),
(80, '2024_03_23_050542_create_features_sections_table', 54),
(81, '2024_03_30_042716_create_staff_plugins_table', 55),
(82, '2024_05_06_095659_add_role_to_staff_table', 56),
(83, '2024_05_09_043354_add_refund_amount_to_transactions_table', 57),
(86, '2024_05_11_054010_add_status_columns_to_staff_table', 58),
(88, '2024_05_23_111438_add_background_color_to_categories_table', 59),
(89, '2024_05_23_113231_add_background_color_to_service_categories_table', 60),
(90, '2024_05_29_085429_add_meta_columns_to_seos_table', 61),
(91, '2024_05_29_092442_create_package_sections_table', 62),
(92, '2024_05_30_040047_drop_login_image_from_basic_settings_table', 63),
(93, '2024_06_03_112454_add_icon_to_call_to_action_section_table', 64),
(94, '2024_06_04_043653_drop_package_sections_table', 65),
(95, '2024_06_04_050506_add_serial_number_to_banners_table', 66),
(96, '2024_06_04_071819_add_total_appointment_collumn_to_vendors_table', 67),
(97, '2024_06_05_110656_add_icon_column_to_work_process_sections', 68),
(98, '2024_06_11_061945_add_time_format_to_basic_settings_talbe', 69),
(100, '2024_06_23_105120_add_meta_keywords_staff_login_page_to_seos_table', 70),
(101, '2024_06_29_110336_add_vendor_id_to_wishlists_table', 71),
(102, '2024_08_17_092247_create_jobs_table', 72),
(103, '2024_08_17_094646_create_failed_jobs_table', 73),
(104, '2024_09_12_075823_create_custom_sections_table', 74),
(105, '2024_09_12_075838_create_custom_section_contents_table', 74);

-- --------------------------------------------------------

--
-- Table structure for table `offline_gateways`
--

CREATE TABLE `offline_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `short_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `instructions` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 -> gateway is deactive, 1 -> gateway is active.',
  `has_attachment` tinyint(1) NOT NULL COMMENT '0 -> do not need attachment, 1 -> need attachment.',
  `serial_number` mediumint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_gateways`
--

CREATE TABLE `online_gateways` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `information` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `online_gateways`
--

INSERT INTO `online_gateways` (`id`, `name`, `keyword`, `information`, `status`) VALUES
(1, 'PayPal', 'paypal', '{\"sandbox_status\":\"0\",\"client_id\":\"\",\"client_secret\":\"\"}', 0),
(2, 'Instamojo', 'instamojo', '{\"sandbox_status\":\"0\",\"key\":\"\",\"token\":\"\"}', 0),
(3, 'Paystack', 'paystack', '{\"key\":\"\"}', 0),
(4, 'Flutterwave', 'flutterwave', '{\"public_key\":\"\",\"secret_key\":\"\"}', 0),
(5, 'Razorpay', 'razorpay', '{\"key\":\"\",\"secret\":\"\"}', 0),
(6, 'MercadoPago', 'mercadopago', '{\"sandbox_status\":\"0\",\"token\":\"\"}', 0),
(7, 'Mollie', 'mollie', '{\"key\":\"\"}', 0),
(10, 'Stripe', 'stripe', '{\"key\":\"\",\"secret\":\"\"}', 0),
(11, 'Paytm', 'paytm', '{\"environment\":\"local\",\"merchant_key\":\"\",\"merchant_mid\":\"\",\"merchant_website\":\"\",\"industry_type\":\"Retail\"}', 0),
(21, 'Authorize.net', 'authorize.net', '{\"login_id\":\"\",\"transaction_key\":\"\",\"public_key\":\"\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Authorize.net account.\"}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `term` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `number_of_service_add` int DEFAULT '0',
  `number_of_service_image` int DEFAULT '0',
  `number_of_appointment` int DEFAULT '0',
  `staff_limit` int DEFAULT NULL,
  `is_trial` int DEFAULT NULL,
  `trial_days` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `support_ticket_status` int DEFAULT NULL,
  `recommended` int NOT NULL DEFAULT '0',
  `zoom_meeting_status` int DEFAULT '0',
  `calendar_status` tinyint NOT NULL DEFAULT '0',
  `custom_features` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `price`, `term`, `icon`, `number_of_service_add`, `number_of_service_image`, `number_of_appointment`, `staff_limit`, `is_trial`, `trial_days`, `status`, `support_ticket_status`, `recommended`, `zoom_meeting_status`, `calendar_status`, `custom_features`, `created_at`, `updated_at`) VALUES
(1, 'Silver', 9, 'monthly', 'fas fa-gift iconpicker-component', 3, 3, 3, 3, 0, 0, 1, 1, 0, 0, 0, NULL, '2024-08-20 03:47:44', '2024-08-20 05:30:38'),
(2, 'Gold', 19.99, 'monthly', 'fas fa-gift iconpicker-component', 5, 5, 5, 5, 0, 0, 1, 1, 1, 1, 0, NULL, '2024-08-20 03:49:42', '2024-08-20 05:28:02'),
(3, 'Platinum', 29.99, 'monthly', 'fas fa-gift', 10, 10, 10, 10, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-08-20 05:24:42', '2024-08-20 05:24:42'),
(4, 'Silver', 99, 'yearly', 'fas fa-gift iconpicker-component', 3, 3, 3, 3, 0, 0, 1, 1, 0, 0, 0, NULL, '2024-08-20 05:26:04', '2024-08-20 05:30:56'),
(5, 'Gold', 199, 'yearly', 'fas fa-gift iconpicker-component', 5, 5, 5, 5, 0, 0, 1, 1, 1, 1, 0, NULL, '2024-08-20 05:26:36', '2024-08-20 05:31:05'),
(6, 'Platinum', 299, 'yearly', 'fas fa-gift', 10, 10, 10, 10, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-08-20 05:27:08', '2024-08-20 05:27:08'),
(7, 'Silver', 399, 'lifetime', 'fas fa-gift', 3, 3, 3, 3, NULL, NULL, 1, 1, 0, 0, 0, NULL, '2024-08-20 05:29:33', '2024-08-20 05:29:33'),
(8, 'Gold', 699, 'lifetime', 'fas fa-gift', 5, 5, 5, 5, NULL, NULL, 1, 1, 1, 1, 0, NULL, '2024-08-20 05:32:44', '2024-08-20 05:32:44'),
(9, 'Platinum', 999, 'lifetime', 'fa fa-fw fa-heart iconpicker-component', 10, 10, 10, 10, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-08-20 05:33:11', '2024-08-20 05:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_contents`
--

CREATE TABLE `page_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `page_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` blob NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_headings`
--

CREATE TABLE `page_headings` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `service_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `blog_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `contact_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `products_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `error_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `faq_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `forget_password_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vendor_forget_password_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `login_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pricing_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `signup_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `staff_login_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vendor_login_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vendor_signup_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cart_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `checkout_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vendor_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `about_us_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `wishlist_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dashboard_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `orders_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `appointment_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `change_password_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `edit_profile_page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `custom_page_heading` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `page_headings`
--

INSERT INTO `page_headings` (`id`, `language_id`, `service_page_title`, `blog_page_title`, `contact_page_title`, `products_page_title`, `error_page_title`, `faq_page_title`, `forget_password_page_title`, `vendor_forget_password_page_title`, `login_page_title`, `pricing_page_title`, `signup_page_title`, `staff_login_page_title`, `vendor_login_page_title`, `vendor_signup_page_title`, `cart_page_title`, `checkout_page_title`, `vendor_page_title`, `about_us_title`, `wishlist_page_title`, `dashboard_page_title`, `orders_page_title`, `appointment_page_title`, `change_password_page_title`, `edit_profile_page_title`, `custom_page_heading`, `created_at`, `updated_at`) VALUES
(9, 20, 'Services', 'Blog', 'Contact', 'Products', '404', 'FAQ', 'Forget Password', 'Forget Password', 'Login', 'Pricing', 'Signup', 'Staff Login', 'Vendor Login', 'Vendor Signup', 'Cart', 'Checkout', 'Vendors', 'About Us', 'Wishlist', 'Dashboard', 'Orders', 'Appointments', 'Change Password', 'Edit Profile', '[]', '2023-08-27 01:23:22', '2024-09-08 01:06:43'),
(10, 21, 'خدمات', 'مدونة', 'اتصال', 'منتجات', '404', 'التعليمات', 'نسيت كلمة المرور', 'نسيت كلمة المرور', 'تسجيل الدخول', 'التسعير', 'اشتراك', 'تسجيل دخول الموظفين', 'تسجيل دخول البائع', 'تسجيل البائع', 'عربة التسوق', 'الدفع', 'الباعة', 'معلومات عنا', 'قوائم الامنيات', 'لوحة القيادة', 'طلبات', 'تعيينات', 'تغيير كلمة المرور', 'تعديل الملف الشخصي', NULL, '2024-06-23 03:50:56', '2024-07-06 22:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popups`
--

CREATE TABLE `popups` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `type` smallint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `background_color` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `background_color_opacity` decimal(3,2) UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `button_text` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `button_color` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `delay` int UNSIGNED NOT NULL COMMENT 'value will be in milliseconds',
  `serial_number` mediumint UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 => deactive, 1 => active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `popups`
--

INSERT INTO `popups` (`id`, `language_id`, `type`, `image`, `name`, `background_color`, `background_color_opacity`, `title`, `text`, `button_text`, `button_color`, `button_url`, `end_date`, `end_time`, `delay`, `serial_number`, `status`, `created_at`, `updated_at`) VALUES
(31, 20, 4, '66d44cf0a4c08.png', 'Immaculate Clean', NULL, NULL, 'Premium Home Cleaning Service', 'Elevate your home with our premium cleaning services. Our experts use advanced techniques for a spotless result. Book now for a cleaner, more comfortable space.', 'Book Now', 'FF1313', 'http://example.com/', NULL, NULL, 2000, 2, 0, '2024-09-01 05:16:00', '2024-09-03 04:11:26'),
(32, 20, 2, '66d45009d629f.png', 'Discount Offer', '451D53', 0.90, 'SAVE 20%  ON DOCTOR VISITS !', 'Don’t miss out on our special offer for new patients! Enjoy a 20% discount on your first consultation with our experienced doctors. Book your appointment today and receive top-quality care at a reduced rate.', 'Book Now', '451D53', 'http://example.com/', NULL, NULL, 2000, 1, 0, '2024-09-01 05:29:13', '2024-09-03 04:08:15'),
(33, 20, 7, '66d4520be8e82.png', 'Course Enrollment Discount', '930077', NULL, 'Get 15% Off All Courses – Limited Time Offer!', 'Take advantage of our limited-time offer! Enjoy a 15% discount on all courses when you enroll today. Book Now to secure your spot!', 'Book Now', 'FA00CA', 'http://example.com/', '2029-11-29', '12:30:00', 2000, 3, 1, '2024-09-01 05:37:47', '2024-09-03 04:11:24'),
(35, 20, 3, '66d54d8736b49.png', 'Newletter', '5CC2C7', 0.90, 'Newsletter', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'Subscribe', '5CC2C7', NULL, NULL, NULL, 2000, 4, 0, '2024-09-01 23:30:47', '2024-09-03 04:08:10'),
(36, 21, 2, '66d59db3def56.png', 'عرض خصم', '451D53', 0.90, 'وفر 20% على زيارات الطبيب!', 'لا تفوت عرضنا الخاص للمرضى الجدد! استمتع بخصم 20% على استشارتك الأولى مع أطبائنا ذوي الخبرة. احجز موعدك اليوم واحصل على رعاية عالية الجودة بسعر مخفض.', 'احجز الآن', '451D53', 'http://example.com/', NULL, NULL, 2000, 1, 0, '2024-09-02 09:12:51', '2024-09-03 06:57:19'),
(37, 21, 4, '66d59e1e76784.png', 'نظيف بلا عيب', NULL, NULL, 'خدمة تنظيف المنازل المتميزة', 'ارتقِ بمنزلك إلى مستوى جديد من خلال خدمات التنظيف المتميزة لدينا. يستخدم خبراؤنا تقنيات متقدمة للحصول على نتائج لا تشوبها شائبة. احجز الآن لتحصل على مساحة أكثر نظافة وراحة.', 'احجز الآن', 'FF1313', 'http://example.com/', NULL, NULL, 2000, 2, 0, '2024-09-02 09:14:38', '2024-09-03 06:57:17'),
(38, 21, 7, '66d59e9f2afed.png', 'خصم على تسجيل الدورة', '930077', NULL, 'احصل على خصم 15% على جميع الدورات – عرض لفترة محدودة!', 'اغتنم فرصة الاستفادة من عرضنا المحدود الوقت! استمتع بخصم 15% على جميع الدورات عند التسجيل اليوم. احجز الآن لتأمين مكانك!', 'احجز الآن', 'FA00CA', 'http://example.com/', '2029-11-29', '12:30:00', 2000, 3, 1, '2024-09-02 09:16:47', '2024-09-02 09:16:47'),
(39, 21, 3, '66d59ef4e1476.png', 'النشرة الإخبارية', '5CC2C7', 0.90, 'النشرة الإخبارية', 'ليكن الألم نفسه عظيمًا، وليستقر اللتر الصادق؛', 'يشترك', '5CC2C7', NULL, NULL, NULL, 2000, 4, 0, '2024-09-02 09:18:12', '2024-09-03 06:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `product_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slider_images` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `input_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `stock` int UNSIGNED DEFAULT NULL,
  `sku` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `current_price` decimal(8,2) UNSIGNED NOT NULL,
  `previous_price` decimal(8,2) UNSIGNED DEFAULT NULL,
  `average_rating` decimal(4,2) UNSIGNED DEFAULT '0.00',
  `is_featured` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `vendor_id`, `product_type`, `featured_image`, `slider_images`, `status`, `input_type`, `file`, `link`, `stock`, `sku`, `current_price`, `previous_price`, `average_rating`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, NULL, 'physical', '66c97ad80e995.png', '[\"66c97a1f37fb5.png\",\"66c97a213ddc7.png\",\"66c97a23b2e16.png\",\"66c97a25e6944.png\"]', 'show', NULL, NULL, NULL, 18, NULL, 19.99, 24.99, 0.00, 'no', '2024-08-24 00:16:56', '2024-08-25 05:25:43'),
(3, NULL, 'physical', '66c982bbd51f8.png', '[\"66c982ab8a04b.png\",\"66c982adbfb4c.png\",\"66c982afc6b2e.png\",\"66c982b2811b2.png\"]', 'show', NULL, NULL, NULL, 200, NULL, 120.00, 150.00, 0.00, 'no', '2024-08-24 00:50:35', '2024-08-24 00:50:35'),
(4, NULL, 'physical', '66c98c3958236.png', '[\"66c98b3e708be.png\",\"66c98b44714b3.png\",\"66c98b4661e3c.png\",\"66c98b544b159.png\"]', 'show', NULL, NULL, NULL, 20, NULL, 300.00, 350.00, 0.00, 'no', '2024-08-24 00:16:56', '2024-08-24 01:31:05'),
(5, NULL, 'physical', '66c9a0a32690e.png', '[\"66c99fc3c5af3.png\",\"66c99fc60691b.png\",\"66c99fc8101f6.png\",\"66c99fca8058b.png\"]', 'show', NULL, NULL, NULL, 30, NULL, 59.99, 79.99, 0.00, 'no', '2024-08-24 02:58:11', '2024-08-24 02:58:11'),
(6, NULL, 'physical', '66c9a296dbce6.png', '[\"66c9a0c6defd9.png\",\"66c9a0c8f22f3.png\",\"66c9a0cacdf12.png\",\"66c9a0cd4df55.png\"]', 'show', NULL, NULL, NULL, 10, NULL, 4999.99, 5499.99, 4.00, 'no', '2024-08-24 03:06:30', '2024-08-25 05:37:03'),
(7, NULL, 'digital', '66c9abcc981b3.png', '[\"66c9a9da0f3c8.png\",\"66c9a9dbbe19b.png\",\"66c9a9ddb986d.png\"]', 'show', 'link', NULL, 'https://www.example.com', NULL, NULL, 29.99, 34.99, 3.00, 'no', '2024-08-24 03:45:48', '2024-08-25 05:37:27'),
(8, NULL, 'physical', '66c9aede4418e.png', '[\"66c9ac69388af.png\",\"66c9ae4134cb0.png\",\"66c9ae4355947.png\",\"66c9ae45de127.png\"]', 'show', NULL, NULL, NULL, 10, NULL, 39.99, 49.99, 0.00, 'no', '2024-08-24 03:58:54', '2024-08-24 03:58:54'),
(9, NULL, 'physical', '66c9b2e0dd24f.png', '[\"66c9b279d1de4.png\",\"66c9b27ddb241.png\",\"66c9b2804b104.png\",\"66c9b281ee99c.png\"]', 'show', NULL, NULL, NULL, 20, NULL, 250.00, 270.00, 0.00, 'no', '2024-08-24 04:16:00', '2024-08-24 04:16:00'),
(10, NULL, 'physical', '66caf27e7f354.jpg', '[\"66caf8892ad4d.png\",\"66caf88b63bd2.png\",\"66caf89288494.png\"]', 'show', NULL, NULL, NULL, 10, NULL, 12.99, 18.99, 0.00, 'no', '2024-08-25 02:59:42', '2024-08-25 03:25:49'),
(11, NULL, 'physical', '66caf56c35b87.png', '[\"66caf4ab94240.png\",\"66caf4ad5451d.png\",\"66caf4af6b153.png\",\"66caf4b18309e.png\"]', 'show', NULL, NULL, NULL, 20, NULL, 129.99, 199.99, 0.00, 'no', '2024-08-25 03:12:12', '2024-08-25 03:12:12'),
(12, NULL, 'physical', '66cafa2b494bd.png', '[\"66cafa0a58ce8.png\",\"66cafa0ce24b7.png\",\"66cafa0ebf413.png\",\"66cafa1104f31.png\"]', 'show', NULL, NULL, NULL, 20, NULL, 149.99, 179.99, 0.00, 'no', '2024-08-25 03:32:27', '2024-08-25 03:32:27'),
(13, NULL, 'physical', '66cafc6aaf4c0.png', '[\"66cafc474a42e.png\",\"66cafc4aaab52.png\",\"66cafc4ea119c.png\",\"66cafc5326345.png\"]', 'show', NULL, NULL, NULL, 10, NULL, 229.99, 279.99, 0.00, 'no', '2024-08-25 03:42:02', '2024-08-25 03:42:02'),
(14, NULL, 'physical', '66caff0a9db2a.png', '[\"66cafe6d86f03.png\",\"66cafe6f8b41b.png\",\"66cafe7246ac2.png\",\"66cafe743f9de.png\"]', 'show', NULL, NULL, NULL, 9, NULL, 79.99, 99.99, 4.00, 'no', '2024-08-25 03:52:18', '2024-08-25 05:40:28'),
(15, NULL, 'physical', '66cb03dac9254.png', '[\"66cb03c51b5bc.png\",\"66cb03c9e251b.png\",\"66cb03cc33549.png\",\"66cb03d3ee4a7.png\"]', 'show', NULL, NULL, NULL, 9, NULL, 14.99, 19.99, 0.00, 'no', '2024-08-25 04:00:22', '2024-08-25 05:30:08'),
(16, NULL, 'digital', '66cb06d1790df.png', '[\"66cb065426cb3.png\",\"66cb0657efe78.png\",\"66cb065a68c78.png\",\"66cb065e8f598.png\"]', 'show', 'link', '66cb06d1794d8.zip', 'https://example.com/', NULL, NULL, 12.99, 15.99, 5.00, 'no', '2024-08-25 04:26:25', '2024-09-04 23:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `serial_number` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `language_id`, `name`, `slug`, `status`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 20, 'Medical Equipment', 'medical-equipment', 1, 1, '2024-08-23 23:43:48', '2024-08-23 23:43:48'),
(2, 21, 'المعدات الطبية', 'المعدات-الطبية', 1, 1, '2024-08-23 23:44:28', '2024-08-23 23:44:28'),
(3, 20, 'Saloon Equipment', 'saloon-equipment', 1, 2, '2024-08-24 00:13:28', '2024-08-24 01:37:19'),
(4, 21, 'معدات الصالون', 'معدات-الصالون', 1, 2, '2024-08-24 00:13:41', '2024-08-24 01:37:32'),
(5, 20, 'Creative & Academic Tools', 'creative-&-academic-tools', 1, 3, '2024-08-24 00:31:46', '2024-08-25 04:07:52'),
(6, 21, 'الأدوات الإبداعية والأكاديمية', 'الأدوات-الإبداعية-والأكاديمية', 1, 3, '2024-08-24 00:32:03', '2024-08-25 04:07:26'),
(9, 20, 'Cleaning Equipment', 'cleaning-equipment', 1, 4, '2024-08-24 02:41:22', '2024-08-24 02:41:22'),
(10, 21, 'معدات التنظيف', 'معدات-التنظيف', 1, 4, '2024-08-24 02:41:37', '2024-08-24 02:41:37'),
(11, 20, 'Electronics', 'electronics', 1, 5, '2024-08-25 03:18:09', '2024-08-25 03:18:09'),
(12, 21, 'إلكترونيات', 'إلكترونيات', 1, 5, '2024-08-25 03:18:19', '2024-08-25 03:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_contents`
--

CREATE TABLE `product_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `product_category_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `summary` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `product_contents`
--

INSERT INTO `product_contents` (`id`, `language_id`, `product_category_id`, `product_id`, `title`, `slug`, `summary`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 20, 3, 1, 'Beard Oil for Skin Regeneration', 'beard-oil-for-skin-regeneration', 'Transform your grooming routine with our Premium Beard Oil for Skin Regeneration. Formulated with a blend of natural oils, this high-quality beard oil is designed to enhance beard growth, soothe irritated skin, and promote overall beard health. At $19.99, it\'s a luxurious yet affordable way to maintain a well-groomed and revitalized beard.', '<p>Experience the ultimate in beard care with our Premium Beard Oil for Skin Regeneration. Crafted with a rich combination of essential oils, including nourishing argan, hydrating jojoba, and revitalizing vitamin E, this beard oil provides exceptional benefits for both your beard and the skin underneath.</p>\r\n<p>Our unique formula delivers deep moisture, softening and conditioning your facial hair while combating dryness and itchiness. The lightweight, non-greasy texture ensures quick absorption without leaving any residue, making it perfect for daily use.</p>\r\n<p>Not only does this beard oil enhance the appearance and feel of your beard, but it also supports skin regeneration. The nourishing ingredients work to repair and rejuvenate your skin, reducing flakiness and promoting a healthy, hydrated complexion.</p>\r\n<p>With a subtle, refreshing scent, this beard oil is an essential addition to your grooming arsenal. Ideal for all skin types, it offers a simple yet effective solution for maintaining a polished, well-groomed look. Treat yourself to the premium care your beard deserves and enjoy the confidence that comes with a healthier, more vibrant beard.</p>', NULL, NULL, '2024-08-24 00:16:56', '2024-08-24 03:07:22'),
(2, 21, 4, 1, 'زيت اللحية لتجديد البشرة', 'زيت-اللحية-لتجديد-البشرة', 'غيّر روتين العناية باللحية الخاص بك باستخدام زيت اللحية الفاخر لتجديد البشرة. تم تركيب هذا الزيت عالي الجودة بمزيج من الزيوت الطبيعية، وهو مصمم لتعزيز نمو اللحية، وتهدئة البشرة المتهيجة، وتعزيز صحة اللحية بشكل عام. بسعر 19.99 دولارًا، إنه طريقة فاخرة وبأسعار معقولة للحفاظ على لحية مشذبة ومنتعشة.', '<p>استمتع بأفضل ما في العناية باللحية مع زيت اللحية الفاخر لتجديد البشرة. مصنوع من مزيج غني من الزيوت الأساسية، بما في ذلك الأرجان المغذي والجوجوبا المرطب وفيتامين إي المنشط، يوفر زيت اللحية هذا فوائد استثنائية للحية والبشرة تحتها.</p>\r\n<p>تركيبتنا الفريدة توفر ترطيبًا عميقًا وتنعيمًا وتكييفًا لشعر وجهك مع مكافحة الجفاف والحكة. يضمن الملمس الخفيف غير الدهني الامتصاص السريع دون ترك أي بقايا، مما يجعله مثاليًا للاستخدام اليومي.</p>\r\n<p>لا يعمل زيت اللحية هذا على تحسين مظهر لحيتك وشعورها فحسب، بل إنه يدعم أيضًا تجديد البشرة. تعمل المكونات المغذية على إصلاح وتجديد بشرتك، وتقليل التقشر وتعزيز بشرة صحية ورطبة.</p>\r\n<p>برائحة لطيفة ومنعشة، يعد زيت اللحية هذا إضافة أساسية إلى ترسانة العناية الخاصة بك. مثالي لجميع أنواع البشرة، فهو يوفر حلاً بسيطًا وفعالًا للحفاظ على مظهر مصقول ومهندم. دلل نفسك بالعناية المتميزة التي تستحقها لحيتك واستمتع بالثقة التي تأتي مع لحية أكثر صحة وحيوية.</p>', NULL, NULL, '2024-08-24 00:16:56', '2024-08-24 03:07:22'),
(5, 20, 1, 3, 'Omron Upper Arm Blood Pressure Monitor', 'omron-upper-arm-blood-pressure-monitor', 'Monitor your blood pressure with precision using the Omron Upper Arm Blood Pressure Monitor. Engineered for accuracy and convenience, this reliable device is now available for $39.99, offering you a top-quality health tool at an exceptional value.', '<p>The Omron Upper Arm Blood Pressure Monitor is designed to provide accurate and consistent blood pressure readings with ease. Ideal for home use, this monitor combines advanced technology with user-friendly features to ensure you get the most reliable data on your cardiovascular health.</p>\r\n<p>Key features include:</p>\r\n<ul>\r\n<li><strong>Precise Measurements:</strong> Utilizes advanced sensor technology for accurate blood pressure and pulse rate readings.</li>\r\n<li><strong>Large Display:</strong> Features a clear, backlit digital screen for easy viewing of results.</li>\r\n<li><strong>Memory Storage:</strong> Can store up to 90 readings for two users, making it easy to track and review your blood pressure history.</li>\r\n<li><strong>Automatic Cuff Inflation:</strong> Ensures a comfortable fit and quick, effortless measurement.</li>\r\n<li><strong>Hypertension Indicator:</strong> Alerts you if your readings are outside normal ranges, helping you stay informed about your health.</li>\r\n</ul>\r\n<p>Perfect for daily monitoring or tracking changes over time, the Omron Upper Arm Blood Pressure Monitor is both reliable and easy to use. Its compact design makes it convenient for storage and transport, while its durability ensures long-lasting performance.</p>', NULL, NULL, '2024-08-24 00:50:35', '2024-08-24 00:52:12'),
(6, 21, 2, 3, 'جهاز قياس ضغط الدم من أومرون للذراع العلوي', 'جهاز-قياس-ضغط-الدم-من-أومرون-للذراع-العلوي', 'راقب ضغط دمك بدقة باستخدام جهاز قياس ضغط الدم من أعلى الذراع من Omron. تم تصميم هذا الجهاز الموثوق به لتحقيق الدقة والراحة، وهو متاح الآن مقابل 40 دولارًا، مما يوفر لك أداة صحية عالية الجودة بقيمة استثنائية.', '<p>تم تصميم جهاز قياس ضغط الدم من أومرون لتوفير قراءات دقيقة ومتسقة لضغط الدم بسهولة. مثالي للاستخدام المنزلي، يجمع هذا الجهاز بين التكنولوجيا المتقدمة والميزات سهلة الاستخدام لضمان حصولك على البيانات الأكثر موثوقية حول صحة القلب والأوعية الدموية لديك.</p>\r\n<p>تتضمن الميزات الرئيسية ما يلي:</p>\r\n<ul>\r\n<li>قياسات دقيقة: تستخدم تقنية الاستشعار المتقدمة لقراءات دقيقة لضغط الدم ومعدل النبض.</li>\r\n<li>شاشة كبيرة: تتميز بشاشة رقمية واضحة ذات إضاءة خلفية لسهولة عرض النتائج.</li>\r\n<li>تخزين الذاكرة: يمكن تخزين ما يصل إلى 90 قراءة لمستخدمين اثنين، مما يجعل من السهل تتبع ومراجعة تاريخ ضغط الدم لديك.</li>\r\n<li>نفخ الكفة تلقائيًا: يضمن ملاءمة مريحة وقياسًا سريعًا وبدون مجهود.</li>\r\n<li>مؤشر ارتفاع ضغط الدم: ينبهك إذا كانت قراءاتك خارج النطاق الطبيعي، مما يساعدك على البقاء مطلعًا على صحتك.</li>\r\n</ul>\r\n<p>يُعد جهاز قياس ضغط الدم من أعلى الذراع من Omron مثاليًا للمراقبة اليومية أو تتبع التغييرات بمرور الوقت، فهو موثوق وسهل الاستخدام. كما أن تصميمه المدمج يجعله ملائمًا للتخزين والنقل، في حين تضمن متانته أداءً يدوم طويلًا.</p>', NULL, NULL, '2024-08-24 00:50:35', '2024-08-24 00:50:35'),
(7, 20, 1, 4, 'Portable ECG Machine', 'portable-ecg-machine', 'Monitor your heart health with precision using the Portable ECG Machine. Designed for ease of use and accurate readings, this advanced device is now available for $299.99, offering a professional-grade solution for personal and clinical use.', '<p>The Portable ECG Machine is an essential tool for anyone needing reliable heart monitoring. Whether for home use or in a clinical setting, this compact and user-friendly device provides accurate electrocardiogram readings to help you keep track of your cardiovascular health.</p>\r\n<p>Key features include:</p>\r\n<ul>\r\n<li><strong>High-Resolution ECG Recording:</strong> Delivers clear and precise electrocardiogram readings to assist in diagnosing heart conditions.</li>\r\n<li><strong>Portable Design:</strong> Lightweight and compact for easy transport and use in various settings, from home to medical facilities.</li>\r\n<li><strong>Large Display:</strong> Features a high-resolution screen for easy viewing of ECG waveforms and results.</li>\r\n<li><strong>User-Friendly Interface:</strong> Simple controls and intuitive menu options make it easy for users of all skill levels to operate the device.</li>\r\n<li><strong>Multiple Lead Options:</strong> Includes various lead configurations to provide detailed heart data and comprehensive analysis.</li>\r\n<li><strong>Data Storage and Transfer:</strong> Allows for storing and transferring ECG data to computers or mobile devices for further analysis and record-keeping.</li>\r\n<li><strong>Built-in Battery:</strong> Comes with a rechargeable battery for extended use without the need for constant recharging.</li>\r\n</ul>\r\n<p> </p>', NULL, NULL, '2024-08-24 01:31:05', '2024-08-24 01:31:05'),
(8, 21, 2, 4, 'جهاز تخطيط القلب المحمول', 'جهاز-تخطيط-القلب-المحمول', 'راقب صحة قلبك بدقة باستخدام جهاز تخطيط القلب المحمول. صُمم هذا الجهاز المتطور لسهولة الاستخدام والحصول على قراءات دقيقة، وهو متاح الآن بسعر 299.99 دولارًا، مما يوفر حلاً احترافيًا للاستخدام الشخصي والسريري.', '<p>يعد جهاز تخطيط القلب المحمول أداة أساسية لأي شخص يحتاج إلى مراقبة موثوقة للقلب. سواء للاستخدام المنزلي أو في بيئة سريرية، يوفر هذا الجهاز الصغير وسهل الاستخدام قراءات دقيقة لتخطيط القلب لمساعدتك على تتبع صحة القلب والأوعية الدموية لديك.</p>\r\n<p>تتضمن الميزات الرئيسية ما يلي:</p>\r\n<ul>\r\n<li>تسجيل تخطيط كهربية القلب عالي الدقة: يوفر قراءات تخطيط كهربية القلب واضحة ودقيقة للمساعدة في تشخيص حالات القلب.</li>\r\n<li>تصميم محمول: خفيف الوزن وصغير الحجم لسهولة النقل والاستخدام في مختلف الأماكن، من المنزل إلى المرافق الطبية.</li>\r\n<li>شاشة كبيرة: تتميز بشاشة عالية الدقة لعرض أشكال موجات تخطيط القلب ونتائجها بسهولة.</li>\r\n<li>واجهة سهلة الاستخدام: عناصر التحكم البسيطة وخيارات القائمة البديهية تجعل من السهل على المستخدمين من جميع مستويات المهارة تشغيل الجهاز.</li>\r\n<li>خيارات متعددة للأسلاك: تتضمن تكوينات أسلاك مختلفة لتوفير بيانات تفصيلية عن القلب وتحليل شامل.</li>\r\n<li>تخزين البيانات ونقلها: يسمح بتخزين ونقل بيانات تخطيط كهربية القلب إلى أجهزة الكمبيوتر أو الأجهزة المحمولة لمزيد من التحليل وحفظ السجلات.</li>\r\n<li>بطارية مدمجة: تأتي مع بطارية قابلة لإعادة الشحن للاستخدام المطول دون الحاجة إلى إعادة الشحن المستمر.</li>\r\n</ul>\r\n<p> </p>', NULL, NULL, '2024-08-24 01:31:05', '2024-08-24 01:31:05'),
(9, 20, 3, 5, 'CurlMaster Hair Curler', 'curlmaster-hair-curler', 'Transform your hair routine with the Premium CurlMaster Hair Curler, the ultimate tool for achieving salon-quality curls from the comfort of your home. Designed with cutting-edge technology and user-friendly features, this versatile curler offers a professional styling experience at an unbeatable price of $59.99. Whether you’re aiming for voluminous waves or tight ringlets, the Premium CurlMaster delivers exceptional results with ease. Its rapid heat-up time, adjustable temperature settings, and sleek ceramic barrel ensure that you can style your hair quickly and efficiently, creating stunning curls that last all day. Ideal for all hair types, this curler combines performance with convenience, making it a must-have addition to your beauty arsenal.', '<p>The Premium CurlMaster Hair Curler is crafted to provide flawless curls with effortless precision. Featuring a sleek, ergonomic design and advanced ceramic technology, this curler ensures even heat distribution and minimizes damage to your hair, leaving it looking shiny and healthy.</p>\r\n<p><strong>Key features include:</strong></p>\r\n<ul>\r\n<li>\r\n<p><strong>Ceramic Coating:</strong> The curler’s barrel is coated with high-quality ceramic, which helps distribute heat evenly and reduces hair damage. This technology ensures that your curls are smooth and frizz-free, giving you a polished look every time.</p>\r\n</li>\r\n<li>\r\n<p><strong>Adjustable Temperature Settings:</strong> With multiple heat settings, you can easily customize the temperature to suit your hair type and desired style. Whether you have fine, medium, or thick hair, you can select the perfect heat level for optimal results.</p>\r\n</li>\r\n<li>\r\n<p><strong>Rapid Heat-Up:</strong> Designed for efficiency, the Premium CurlMaster heats up quickly, reaching your selected temperature in seconds. This feature allows for fast and convenient styling, perfect for busy mornings or last-minute touch-ups.</p>\r\n</li>\r\n<li>\r\n<p><strong>Curling Wand Design:</strong> The wand’s tapered barrel design enables you to create a range of curl styles, from soft, beachy waves to tight, defined ringlets. The design helps add natural-looking volume and movement to your hair.</p>\r\n</li>\r\n<li>\r\n<p><strong>Cool Tip:</strong> Equipped with a cool tip for safe handling, the Premium CurlMaster ensures that you can style your hair comfortably without risking burns or discomfort. The cool tip also aids in holding the curler while curling.</p>\r\n</li>\r\n<li>\r\n<p><strong>Swivel Cord:</strong> The 360-degree swivel cord prevents tangling and allows for unrestricted movement, giving you the flexibility to style your hair from any angle with ease.</p>\r\n</li>\r\n<li>\r\n<p><strong>Auto Shut-Off:</strong> For added safety, the curler features an automatic shut-off function that activates if the device is left on for an extended period. This ensures peace of mind and helps prevent accidents.</p>\r\n</li>\r\n</ul>', NULL, NULL, '2024-08-24 02:58:11', '2024-08-24 02:58:11'),
(10, 21, 4, 5, 'مكواة تجعيد الشعر كيرلماستر', 'مكواة-تجعيد-الشعر-كيرلماستر', 'غير روتين شعرك باستخدام أداة تجعيد الشعر كيرل ماستر، الأداة المثالية لتحقيق تجعيدات عالية الجودة من راحة منزلك. تم تصميم أداة تجعيد الشعر متعددة الاستخدامات هذه بتقنية متطورة وميزات سهلة الاستخدام، وتوفر تجربة تصفيف احترافية بسعر لا يُضاهى 59.99 دولارًا. سواء كنت تستهدفين تموجات كثيفة أو تجعيدات ضيقة، فإن Premium CurlMaster تقدم نتائج استثنائية بكل سهولة. يضمن وقت التسخين السريع وإعدادات درجة الحرارة القابلة للتعديل والأسطوانة الخزفية الأنيقة إمكانية تصفيف شعرك بسرعة وكفاءة، مما يخلق تجعيدات مذهلة تدوم طوال اليوم. مثالية لجميع أنواع الشعر، تجمع أداة تجعيد الشعر هذه بين الأداء والراحة، مما يجعلها إضافة لا غنى عنها لترسانة جمالك.', '<p>تم تصميم مكواة تجعيد الشعر كيرل ماسترالفاخرة لتوفير تجعيدات خالية من العيوب بدقة لا مثيل لها. تتميز هذه المكواة بتصميم أنيق ومريح وتقنية سيراميك متقدمة، وتضمن توزيعًا متساويًا للحرارة وتقلل من تلف شعرك، مما يجعله يبدو لامعًا وصحيًا.</p>\r\n<p>تتضمن الميزات الرئيسية ما يلي:</p>\r\n<ul>\r\n<li>\r\n<p>طلاء سيراميك: أسطوانة مكواة التجعيد مغطاة بسيراميك عالي الجودة، مما يساعد على توزيع الحرارة بالتساوي ويقلل من تلف الشعر.</p>\r\n</li>\r\n<li>\r\n<p>إعدادات درجة الحرارة القابلة للتعديل: مع إعدادات الحرارة المتعددة، يمكنك بسهولة تخصيص درجة الحرارة لتناسب نوع شعرك والأسلوب المطلوب.</p>\r\n</li>\r\n<li>\r\n<p>تسخين سريع: تم تصميم جهاز كيرل ماسترالمتميز لتحقيق الكفاءة، حيث يسخن بسرعة، ليصل إلى درجة الحرارة المحددة في ثوانٍ.</p>\r\n</li>\r\n<li>\r\n<p>تصميم عصا التجعيد: يتيح لك التصميم المدبب لأسطوانة العصا إنشاء مجموعة من أنماط التجعيد، من الموجات الناعمة الشاطئية إلى الخصلات الضيقة المحددة.</p>\r\n</li>\r\n<li>\r\n<p>رأس بارد: مزود برأس بارد للتعامل الآمن، يضمن لك جهاز كيرل ماسترإمكانية تصفيف شعرك بشكل مريح دون المخاطرة بالحروق أو الانزعاج.</p>\r\n</li>\r\n<li>\r\n<p>سلك دوار: يمنع السلك الدوار بزاوية 360 درجة التشابك ويسمح بحركة غير مقيدة، مما يمنحك المرونة لتصفيف شعرك من أي زاوية بسهولة.</p>\r\n</li>\r\n<li>\r\n<p>الإيقاف التلقائي: لمزيد من الأمان، يتميز جهاز تجعيد الشعر بوظيفة الإيقاف التلقائي التي يتم تنشيطها إذا تم ترك الجهاز قيد التشغيل لفترة طويلة. وهذا يضمن راحة البال ويساعد في منع الحوادث.</p>\r\n</li>\r\n</ul>', NULL, NULL, '2024-08-24 02:58:11', '2024-08-24 02:58:11'),
(11, 20, 1, 6, 'UltraVision Diagnostic Ultrasound Machine', 'ultravision-diagnostic-ultrasound-machine', 'Unlock unparalleled diagnostic capabilities with the UltraVision Diagnostic Ultrasound Machine. Priced at $4,999.99, this state-of-the-art device offers exceptional imaging clarity and a comprehensive suite of features, making it an ideal choice for precise medical evaluations. Designed for ease of use and versatility, the UltraVision provides accurate, real-time imaging across a range of clinical applications, supporting both routine and advanced diagnostic needs with confidence.', '<p>The UltraVision Diagnostic Ultrasound Machine is designed to deliver high-quality imaging and robust performance for a variety of medical applications. With its advanced technology and user-friendly interface, this machine is perfect for healthcare professionals seeking reliable and detailed diagnostic tools.</p>\r\n<p><strong>Key features include:</strong></p>\r\n<ul>\r\n<li>\r\n<p><strong>Exceptional Imaging Clarity:</strong> Advanced imaging technology ensures high-resolution, detailed images, allowing for accurate assessments of internal structures and conditions.</p>\r\n</li>\r\n<li>\r\n<p><strong>Intuitive User Interface:</strong> The machine features a touch-screen interface with customizable settings, making it easy to operate and adjust according to specific diagnostic needs.</p>\r\n</li>\r\n<li>\r\n<p><strong>Broad Clinical Applications:</strong> Suitable for diverse applications including obstetrics, gynecology, cardiology, and musculoskeletal imaging. Supports various imaging modes and probe types to meet different clinical requirements.</p>\r\n</li>\r\n<li>\r\n<p><strong>Real-Time Visualization:</strong> Provides real-time imaging capabilities for immediate assessment during procedures, enhancing diagnostic accuracy and decision-making.</p>\r\n</li>\r\n<li>\r\n<p><strong>Advanced Doppler Features:</strong> Equipped with Doppler imaging technology to evaluate blood flow and detect vascular issues, offering valuable insights into cardiovascular health.</p>\r\n</li>\r\n<li>\r\n<p><strong>Compact and Portable:</strong> Designed with portability in mind, the UltraVision is lightweight and easy to transport, ideal for both fixed and mobile clinical settings.</p>\r\n</li>\r\n<li>\r\n<p><strong>Data Management and Connectivity:</strong> Includes integrated storage and connectivity options for seamless data management and integration with electronic health records (EHR) systems.</p>\r\n</li>\r\n<li>\r\n<p><strong>Enhanced Image Processing:</strong> Features sophisticated image processing tools to improve image quality and reduce noise, including automatic gain control and image enhancement.</p>\r\n</li>\r\n</ul>\r\n<p>The UltraVision Diagnostic Ultrasound Machine combines high-performance imaging with user-friendly design, making it an essential tool for effective medical diagnostics. Enhance your practice with the UltraVision and experience the benefits of superior imaging technology.</p>', NULL, NULL, '2024-08-24 03:06:30', '2024-08-24 03:06:30'),
(12, 21, 2, 6, 'UltraVision Diagnostic Ultrasound Machine', 'ultravision-diagnostic-ultrasound-machine', 'استمتع بإمكانيات تشخيصية لا مثيل لها مع جهاز الموجات فوق الصوتية التشخيصي ألترا فيجن. بسعر 4999.99 دولارًا، يوفر هذا الجهاز المتطور وضوحًا استثنائيًا في التصوير ومجموعة شاملة من الميزات، مما يجعله خيارًا مثاليًا للتقييمات الطبية الدقيقة. تم تصميم ألترا فيجنلسهولة الاستخدام والتنوع، ويوفر تصويرًا دقيقًا في الوقت الفعلي عبر مجموعة من التطبيقات السريرية، ويدعم كل من الاحتياجات التشخيصية الروتينية والمتقدمة بثقة.', '<p>تم تصميم جهاز الموجات فوق الصوتية التشخيصية ألترا فيجنلتقديم صور عالية الجودة وأداء قوي لمجموعة متنوعة من التطبيقات الطبية. بفضل تقنيته المتقدمة وواجهته سهلة الاستخدام، يعد هذا الجهاز مثاليًا لمهنيي الرعاية الصحية الذين يبحثون عن أدوات تشخيصية موثوقة ومفصلة.</p>\r\n<p><strong>تتضمن الميزات الرئيسية ما يلي:</strong></p>\r\n<ul>\r\n<li>\r\n<p>وضوح استثنائي في التصوير: تضمن تقنية التصوير المتقدمة صورًا عالية الدقة ومفصلة، ​​مما يسمح بإجراء تقييمات دقيقة للهياكل والظروف الداخلية.</p>\r\n</li>\r\n<li>\r\n<p>واجهة مستخدم سهلة الاستخدام: يتميز الجهاز بواجهة شاشة تعمل باللمس مع إعدادات قابلة للتخصيص، مما يجعل من السهل تشغيله وتعديله وفقًا لاحتياجات التشخيص المحددة.</p>\r\n</li>\r\n<li>\r\n<p>تطبيقات سريرية واسعة النطاق: مناسبة لتطبيقات متنوعة بما في ذلك التصوير الطبي للولادة وأمراض النساء وأمراض القلب والجهاز العضلي الهيكلي. تدعم أوضاع التصوير المختلفة وأنواع المجسات لتلبية المتطلبات السريرية المختلفة.</p>\r\n</li>\r\n<li>\r\n<p>التصور في الوقت الفعلي: يوفر إمكانيات التصوير في الوقت الفعلي للتقييم الفوري أثناء الإجراءات، مما يعزز دقة التشخيص واتخاذ القرار.</p>\r\n</li>\r\n<li>\r\n<p>ميزات دوبلر المتقدمة: مجهزة بتقنية التصوير دوبلر لتقييم تدفق الدم واكتشاف المشاكل الوعائية، مما يوفر رؤى قيمة حول صحة القلب والأوعية الدموية</p>\r\n</li>\r\n<li>\r\n<p>صغير الحجم وقابل للحمل: تم تصميم UltraVision مع وضع قابلية النقل في الاعتبار، فهو خفيف الوزن وسهل النقل، ومثالي للإعدادات السريرية الثابتة والمتحركة.</p>\r\n</li>\r\n<li>\r\n<p>إدارة البيانات والاتصال: تتضمن خيارات تخزين واتصال متكاملة لإدارة البيانات بسلاسة والتكامل مع أنظمة السجلات الصحية الإلكترونية (EHR).</p>\r\n</li>\r\n<li>\r\n<p>معالجة الصور المحسنة: تتميز بأدوات معالجة الصور المتطورة لتحسين جودة الصورة وتقليل الضوضاء، بما في ذلك التحكم التلقائي في المكسب وتحسين الصورة.</p>\r\n</li>\r\n</ul>\r\n<p>يجمع جهاز الموجات فوق الصوتية التشخيصي UltraVision بين التصوير عالي الأداء والتصميم سهل الاستخدام، مما يجعله أداة أساسية للتشخيص الطبي الفعال. عزز ممارستك مع جهاز UltraVision واستمتع بفوائد تقنية التصوير المتفوقة.</p>', NULL, NULL, '2024-08-24 03:06:30', '2024-08-24 03:06:30'),
(13, 20, 5, 7, 'Gastronomic World', 'gastronomic-world', 'Embark on a culinary adventure with \"Gastronomic World,\" a captivating book that explores the diverse and rich flavors of global cuisine. This beautifully illustrated guide takes you on a journey across continents, introducing you to traditional recipes, culinary techniques, and the cultural significance behind some of the world\'s most beloved dishes. Whether you’re a seasoned chef or a food enthusiast, this book is a must-have for anyone looking to expand their culinary horizons and experience the tastes of the world from the comfort of their own kitchen.', '<p><strong>\"Gastronomic World\"</strong> is more than just a cookbook—it\'s an exploration of the rich tapestry of global cuisine. Inside its pages, you\'ll discover a curated collection of recipes that span the continents, offering a taste of everything from the vibrant spices of Asia to the hearty, comforting dishes of Europe. Each recipe is thoughtfully selected to showcase the authentic flavors and traditions of its origin, allowing you to recreate these culinary treasures in your own kitchen.</p>\r\n<p>As you delve into <strong>\"Gastronomic World,\"</strong> you’ll not only learn how to prepare these dishes, but you’ll also gain a deeper understanding of the cultural and historical contexts that shape the way food is enjoyed around the world. The stunning photography throughout the book captures the essence of each dish, providing visual inspiration that makes cooking an even more enjoyable experience.</p>\r\n<p>Whether you’re looking to master the art of a classic French dish, explore the bold flavors of Middle Eastern cuisine, or indulge in the sweet treats of Latin America, <strong>\"Gastronomic World\"</strong> offers something for everyone. The easy-to-follow instructions ensure that both novice cooks and seasoned chefs can confidently recreate these dishes at home.</p>\r\n<p>This book isn’t just a collection of recipes; it’s an invitation to embark on a culinary journey that will expand your palate and enrich your understanding of the world through food. With <strong>\"Gastronomic World\"</strong> in your kitchen, you’re just a recipe away from experiencing the global flavors that unite us all.</p>', NULL, NULL, '2024-08-24 03:45:48', '2024-08-24 03:45:48'),
(14, 21, 6, 7, 'عالم الطعام', 'عالم-الطعام', 'انطلق في مغامرة طهي مع كتاب \"Gastronomic World\"، وهو كتاب آسر يستكشف النكهات المتنوعة والغنية للمطبخ العالمي. يأخذك هذا الدليل المصوَّر بشكل جميل في رحلة عبر القارات، ويعرّفك على الوصفات التقليدية وتقنيات الطهي والأهمية الثقافية وراء بعض الأطباق الأكثر شهرة في العالم. سواء كنت طاهيًا متمرسًا أو متحمسًا للطعام، فإن هذا الكتاب ضروري لأي شخص يتطلع إلى توسيع آفاقه في الطهي وتجربة أذواق العالم من راحة مطبخه الخاص.', '<p>\"<strong>الطعام</strong>\" هو أكثر من مجرد كتاب طبخ، بل هو استكشاف للنسيج الغني للمطبخ العالمي. داخل صفحاته، ستكتشف مجموعة مختارة من الوصفات التي تمتد عبر القارات، وتقدم لك مذاقًا لكل شيء من التوابل النابضة بالحياة في آسيا إلى الأطباق الشهية والمريحة في أوروبا. يتم اختيار كل وصفة بعناية لإبراز النكهات والتقاليد الأصيلة لأصلها، مما يسمح لك بإعادة إنشاء هذه الكنوز الطهوية في مطبخك الخاص.</p>\r\n<p>مع تعمقك في \"عالم \"، لن تتعلم فقط كيفية تحضير هذه الأطباق، بل ستكتسب أيضًا فهمًا أعمق للسياقات الثقافية والتاريخية التي تشكل الطريقة التي يتم بها الاستمتاع بالطعام في جميع أنحاء العالم. تلتقط الصور المذهلة في جميع أنحاء الكتاب جوهر كل طبق، مما يوفر إلهامًا بصريًا يجعل الطهي تجربة أكثر متعة.</p>\r\n<p>سواء كنت تتطلع إلى إتقان فن الطبق الفرنسي الكلاسيكي، أو استكشاف النكهات الجريئة للمطبخ الشرق أوسطي، أو الاستمتاع بالحلويات اللذيذة في أمريكا اللاتينية، فإن \"عالم \" يقدم شيئًا للجميع. تضمن التعليمات سهلة المتابعة أن يتمكن كل من الطهاة المبتدئين والطهاة المخضرمين من إعادة إنشاء هذه الأطباق بثقة في المنزل.</p>\r\n<p>هذا الكتاب ليس مجرد مجموعة من الوصفات؛ بل هو دعوة للانطلاق في رحلة طهي من شأنها توسيع ذوقك وإثراء فهمك للعالم من خلال الطعام. مع \"عالم تذوق الطعام\" في مطبخك، أنت على بعد وصفة واحدة فقط من تجربة النكهات العالمية التي توحدنا جميعًا.</p>', NULL, NULL, '2024-08-24 03:45:48', '2024-08-24 03:45:48'),
(15, 20, 1, 8, 'Precision Infrared Thermometer', 'precision-infrared-thermometer', 'Ensure accurate and contactless temperature readings with the Precision Infrared Thermometer. Designed for both home and professional use, this thermometer provides fast, reliable readings with just a single click. Whether you\'re monitoring the health of your family or patients, this device offers the precision and convenience you need.', '<p>The <strong>Precision Infrared Thermometer</strong> is an essential tool for modern health monitoring, offering a fast and hygienic way to measure body temperature without physical contact. This thermometer is equipped with advanced infrared technology, which allows it to capture accurate temperature readings from a distance, making it ideal for use in any setting where hygiene is a top priority.</p>\r\n<p>With a clear digital display, you can easily read temperatures in both Celsius and Fahrenheit, ensuring you get the information you need at a glance. The thermometer\'s ergonomic design fits comfortably in hand, and its intuitive controls make it easy to operate even for first-time users. A quick scan across the forehead delivers results in just seconds, making it an excellent choice for checking temperatures in children, adults, and even sleeping individuals without disturbing them.</p>\r\n<p>The <strong>Precision Infrared Thermometer</strong> is not just for body temperature; it can also be used to measure the temperature of objects and surfaces, providing versatility in various situations. Whether you\'re checking the temperature of a baby\'s bathwater, a bottle, or even room temperature, this thermometer adapts to your needs.</p>\r\n<p>With its high precision and user-friendly interface, the <strong>Precision Infrared Thermometer</strong> is a reliable choice for anyone looking to maintain health and safety standards in their environment. Keep your family safe with the accuracy and convenience of this indispensable device.</p>', NULL, NULL, '2024-08-24 03:58:54', '2024-08-24 03:58:54'),
(16, 21, 2, 8, 'مقياس الحرارة الدقيق بالأشعة تحت الحمراء', 'مقياس-الحرارة-الدقيق-بالأشعة-تحت-الحمراء', 'اضمن قراءات دقيقة وغير تلامسية لدرجة الحرارة باستخدام مقياس الحرارة بالأشعة تحت الحمراء الدقيق. تم تصميم هذا المقياس الحراري للاستخدام المنزلي والمهني، حيث يوفر قراءات سريعة وموثوقة بنقرة واحدة فقط. سواء كنت تراقب صحة عائلتك أو مرضاك، فإن هذا الجهاز يوفر الدقة والراحة التي تحتاجها.', '<p>يُعد مقياس الحرارة الدقيق بالأشعة تحت الحمراء أداة أساسية لمراقبة الصحة الحديثة، حيث يوفر طريقة سريعة وصحية لقياس درجة حرارة الجسم دون ملامسة جسدية. تم تجهيز هذا المقياس الحراري بتقنية الأشعة تحت الحمراء المتقدمة، مما يسمح له بالتقاط قراءات دقيقة لدرجة الحرارة من مسافة بعيدة، مما يجعله مثاليًا للاستخدام في أي مكان حيث تكون النظافة أولوية قصوى.</p>\r\n<p>بفضل الشاشة الرقمية الواضحة، يمكنك بسهولة قراءة درجات الحرارة بالدرجة المئوية والفهرنهايت، مما يضمن لك الحصول على المعلومات التي تحتاجها في لمحة. يتناسب التصميم المريح للمقياس الحراري بشكل مريح في اليد، كما أن عناصر التحكم البديهية تجعله سهل التشغيل حتى للمستخدمين لأول مرة. يوفر المسح السريع عبر الجبهة نتائج في ثوانٍ فقط، مما يجعله خيارًا ممتازًا للتحقق من درجات الحرارة عند الأطفال والبالغين وحتى الأفراد النائمين دون إزعاجهم.</p>\r\n<p>لا يقتصر مقياس الحرارة الدقيق بالأشعة تحت الحمراء على درجة حرارة الجسم؛ بل يمكن استخدامه أيضًا لقياس درجة حرارة الأشياء والأسطح، مما يوفر تنوعًا في مواقف مختلفة. سواء كنت تتحقق من درجة حرارة مياه الاستحمام الخاصة بالطفل أو الزجاجة أو حتى درجة حرارة الغرفة، فإن هذا المقياس الحراري يتكيف مع احتياجاتك.</p>\r\n<p>بفضل دقته العالية وواجهته سهلة الاستخدام، يعد مقياس الحرارة بالأشعة تحت الحمراء الدقيق خيارًا موثوقًا به لأي شخص يتطلع إلى الحفاظ على معايير الصحة والسلامة في بيئته. حافظ على سلامة عائلتك بدقة وراحة هذا الجهاز الذي لا غنى عنه.</p>', NULL, NULL, '2024-08-24 03:58:54', '2024-08-24 03:58:54'),
(17, 20, 3, 9, 'Hydraulic Salon Chair', 'hydraulic-salon-chair', 'Elevate your salon experience with the LuxeComfort Hydraulic Salon Chair, designed for both style and functionality. This chair combines premium comfort with a sleek, modern design, ensuring your clients feel pampered from the moment they sit down. With adjustable height and a 360-degree swivel, it\'s the perfect addition to any professional salon setting, enhancing both client comfort and stylist efficiency.', '<p>The <strong>LuxeComfort Hydraulic Salon Chair</strong> is a testament to quality and comfort, making it an essential piece for any modern salon. Crafted with high-density foam cushioning and upholstered in luxurious, easy-to-clean vinyl, this chair offers the perfect blend of durability and elegance. The ergonomic design provides excellent support, ensuring your clients remain comfortable during long styling sessions.</p>\r\n<p>The hydraulic pump allows for effortless height adjustments, accommodating clients of all sizes and ensuring the stylist can work at the optimal height. The 360-degree swivel feature adds convenience, allowing for easy access to all sides without needing to reposition the client. Whether you\'re cutting, styling, or coloring, this chair offers the flexibility and stability required for a seamless salon experience.</p>\r\n<p>Designed with both the client and stylist in mind, the <strong>LuxeComfort Hydraulic Salon Chair</strong> features a sturdy chrome base that ensures stability even during extensive use. The stylish design complements any salon decor, adding a touch of sophistication to your space. Additionally, the adjustable headrest and reclining backrest provide extra comfort, making it suitable for a variety of salon services, from haircuts to shaves and facials.</p>\r\n<p>Invest in the <strong>LuxeComfort Hydraulic Salon Chair</strong> and offer your clients an experience of relaxation and luxury that keeps them coming back. Its durability, ease of use, and chic design make it the perfect choice for salons looking to upgrade their equipment with a product that is as functional as it is stylish.</p>', NULL, NULL, '2024-08-24 04:16:01', '2024-08-24 04:16:01'),
(18, 21, 4, 9, 'كرسي صالون هيدروليكي', 'كرسي-صالون-هيدروليكي', 'ارتقِ بتجربة صالون التجميل الخاصة بك مع كرسي صالون التجميل الهيدروليكي LuxeComfort، المصمم للأناقة والوظائف. يجمع هذا الكرسي بين الراحة المتميزة والتصميم الأنيق والحديث، مما يضمن لعملائك الشعور بالدلال منذ اللحظة التي يجلسون فيها. مع ارتفاع قابل للتعديل ودوران بزاوية 360 درجة، فهو الإضافة المثالية لأي صالون احترافي، مما يعزز راحة العميل وكفاءة المصمم.', '<p>كرسي صالون لوكس كومفورت الهيدروليكي هو شهادة على الجودة والراحة، مما يجعله قطعة أساسية لأي صالون عصري. مصنوع من بطانة إسفنجية عالية الكثافة ومفروش بفينيل فاخر وسهل التنظيف، يوفر هذا الكرسي المزيج المثالي من المتانة والأناقة. يوفر التصميم المريح دعمًا ممتازًا، مما يضمن راحة عملائك أثناء جلسات التصفيف الطويلة.</p>\r\n<p>تسمح المضخة الهيدروليكية بتعديل الارتفاع دون عناء، وتستوعب العملاء من جميع الأحجام وتضمن أن يتمكن المصمم من العمل على الارتفاع الأمثل. تضيف ميزة الدوران بزاوية 360 درجة الراحة، مما يسمح بسهولة الوصول إلى جميع الجوانب دون الحاجة إلى إعادة وضع العميل. سواء كنت تقوم بالقص أو التصفيف أو التلوين، يوفر هذا الكرسي المرونة والاستقرار المطلوبين لتجربة صالون سلسة.</p>\r\n<p>تم تصميم كرسي صالون لوكس كومفورت الهيدروليكي مع وضع العميل والمصمم في الاعتبار، ويتميز بقاعدة كروم قوية تضمن الاستقرار حتى أثناء الاستخدام المكثف. يكمل التصميم الأنيق ديكور أي صالون، ويضيف لمسة من الرقي إلى مساحتك. بالإضافة إلى ذلك، يوفر مسند الرأس القابل للتعديل ومسند الظهر القابل للإمالة راحة إضافية، مما يجعله مناسبًا لمجموعة متنوعة من خدمات الصالون، من قص الشعر إلى الحلاقة والعناية بالوجه.</p>\r\n<p>استثمر في كرسي الصالون الهيدروليكي LuxeComfort وقدم لعملائك تجربة استرخاء وفخامة تجعلهم يعودون إليك. متانته وسهولة استخدامه وتصميمه الأنيق تجعله الخيار الأمثل للصالونات التي تتطلع إلى ترقية معداتها بمنتج عملي وأنيق.</p>', NULL, NULL, '2024-08-24 04:16:01', '2024-08-24 04:16:01'),
(19, 20, 5, 10, 'Deluxe Geometry Box Set', 'deluxe-geometry-box-set', 'Unleash the power of precision with our Deluxe Geometry Box, designed for students, professionals, and artists alike. This comprehensive set includes all the essential tools you need for accurate geometric constructions and technical drawings. Whether you\'re drafting technical sketches, tackling complex math problems, or refining your artistic skills, this geometry box has everything you need to succeed.', '<p><strong>What\'s Inside:</strong></p>\r\n<ul>\r\n<li>A sturdy metal compass for smooth, controlled circles</li>\r\n<li>A precise divider for accurate measurements</li>\r\n<li>Transparent set squares for perfect angles and parallel lines</li>\r\n<li>A 180° protractor with clear, easy-to-read markings</li>\r\n<li>A 15 cm/6-inch scale ruler with both metric and imperial measurements</li>\r\n<li>A high-quality HB pencil for clean, sharp lines</li>\r\n<li>A soft, non-smudging eraser for clean corrections</li>\r\n<li>A compact sharpener with a container for easy disposal of shavings</li>\r\n</ul>\r\n<p>All of these tools are neatly organized in a durable, compact case, making it easy to carry and store your essential geometry tools wherever you go.</p>', NULL, NULL, '2024-08-25 02:59:43', '2024-08-25 02:59:43'),
(20, 21, 6, 10, 'مجموعة صناديق هندسية فاخرة', 'مجموعة-صناديق-هندسية-فاخرة', 'أطلق العنان لقوة الدقة مع الصندوق الهندسي الفاخر، المصمم للطلاب والمهنيين والفنانين على حدٍ سواء. تتضمن هذه المجموعة الشاملة جميع الأدوات الأساسية التي تحتاجها لإنشاءات هندسية ورسومات فنية دقيقة. سواء كنت تقوم بصياغة الرسومات الفنية، أو معالجة مشاكل الرياضيات المعقدة، أو تحسين مهاراتك الفنية، فإن هذا الصندوق الهندسي يحتوي على كل ما تحتاجه لتحقيق النجاح.', '<p><strong>ماذا يوجد في الداخل:</strong></p>\r\n<ul>\r\n<li>بوصلة معدنية من طراز Sturya لدوائر سلسة يمكن التحكم فيها</li>\r\n<li>قرص DVD دقيق لقياسات دقيقة</li>\r\n<li>مجموعة مربعات شفافة للحصول على زوايا مثالية وخطوط متوازية</li>\r\n<li>منقلة 180 درجة مع علامات واضحة وسهلة القراءة</li>\r\n<li>مسطرة بمقياس 15 SIM/6 بوصة مع قياسات مترية وإمبراطورية</li>\r\n<li>قلم رصاص عالي الجودة لخطوط نظيفة وحادة</li>\r\n<li>ممحاة ناعمة وغير ناعمة لإجراء تصحيحات نظيفة</li>\r\n<li>مبراة مدمجة مع حاوية لسهولة التخلص من المدخرات</li>\r\n</ul>\r\n<p>تم تنظيم جميع هذه الأدوات بشكل أنيق في علبة متينة وصغيرة الحجم، مما يجعل من السهل حمل وتخزين أدواتك الهندسية الأساسية أينما ذهبت.</p>', NULL, NULL, '2024-08-25 02:59:43', '2024-08-25 02:59:43'),
(21, 20, 9, 11, 'UltraVac Pro Vacuum Cleaner', 'ultravac-pro-vacuum-cleaner', 'Unleash the power of spotless cleaning with our UltraVac Pro Vacuum Cleaner, designed for modern homes and busy lifestyles. This high-performance vacuum cleaner delivers powerful suction, HEPA filtration, and multi-surface versatility, making it the perfect cleaning companion.', '<p>Unleash the power of spotless cleaning with our UltraVac Pro Vacuum Cleaner, designed for modern homes and busy lifestyles. This high-performance vacuum cleaner delivers powerful suction, HEPA filtration, and multi-surface versatility, making it the perfect cleaning companion.</p>\r\n<p><strong>Description:</strong><br />Unleash the power of spotless cleaning with our <strong>UltraVac Pro Vacuum Cleaner</strong>, crafted for those who demand efficiency and thoroughness in their cleaning routine. Equipped with a robust 1500W motor, the UltraVac Pro ensures deep cleaning across various surfaces, from plush carpets to hardwood floors. The advanced HEPA filtration system captures 99.97% of dust, pollen, and allergens, promoting a healthier home environment.</p>\r\n<p>The vacuum\'s versatility is unmatched, featuring interchangeable nozzles and brushes that adapt to any cleaning task. Its lightweight design makes maneuvering effortless, while the 2.5-liter dustbin reduces the need for frequent emptying. Enjoy cordless convenience with up to 60 minutes of runtime, allowing you to clean every corner of your home without interruption.</p>\r\n<p>Say goodbye to cumbersome cleaning and hello to the UltraVac Pro—your key to a spotless home with ease.</p>', NULL, NULL, '2024-08-25 03:12:12', '2024-08-25 03:12:12'),
(22, 21, 10, 11, 'مكنسة الترا المقيم برو الكهربائية', 'مكنسة-الترا-المقيم-برو-الكهربائية', 'أطلق العنان لقوة التنظيف الخالي من البقع باستخدام المكنسة الكهربائية UltraVac Pro، المصممة للمنازل الحديثة وأنماط الحياة المزدحمة. توفر هذه المكنسة الكهربائية عالية الأداء شفطًا قويًا وترشيح HEPA وتعدد الاستخدامات على الأسطح المتعددة، مما يجعلها الرفيق المثالي للتنظيف.', '<p>أطلق العنان لقوة التنظيف الخالي من البقع باستخدام المكنسة الكهربائية UltraVac Pro، المصممة لأولئك الذين يحتاجون إلى الكفاءة والدقة في روتين التنظيف الخاص بهم. يضمن UltraVac Pro، المجهز بمحرك قوي بقدرة 1500 واط، تنظيفًا عميقًا عبر الأسطح المختلفة، بدءًا من السجاد الفخم وحتى الأرضيات الصلبة. يلتقط نظام الترشيح HEPA المتقدم 99.97% من الغبار وحبوب اللقاح والمواد المسببة للحساسية، مما يعزز بيئة منزلية أكثر صحة.</p>\r\n<p>تعد المكنسة الكهربائية متعددة الاستخدامات لا مثيل لها، حيث تتميز بفوهات وفرش قابلة للتبديل تتكيف مع أي مهمة تنظيف. تصميمها خفيف الوزن يجعل المناورة سهلة، بينما تقلل سلة المهملات سعة 2.5 لتر من الحاجة إلى التفريغ المتكرر. استمتع براحة لاسلكية مع ما يصل إلى 60 دقيقة من وقت التشغيل، مما يسمح لك بتنظيف كل ركن من أركان منزلك دون انقطاع.</p>\r\n<p>قل وداعًا للتنظيف المرهق ومرحبًا بـ أولتراباسي برو - مفتاحك لمنزل نظيف بسهولة.</p>', NULL, NULL, '2024-08-25 03:12:12', '2024-08-25 03:12:12'),
(23, 20, 11, 12, 'Smart Wave Home Assistant', 'smart-wave-home-assistant', 'The SmartWave Home Assistant revolutionizes the way you manage your smart speakers. With unified control, voice command integration, and customizable settings, this device brings effortless convenience and enhanced audio experiences to your home.', '<p>Transform your home into a symphony of connectivity with the <strong>SmartWave Home Assistant</strong>. Designed for seamless management of your smart speakers, this device offers a central hub for controlling multiple speakers with ease. Enjoy unified control through an intuitive interface, or use voice commands to adjust settings hands-free.</p>\r\n<p>The SmartWave Home Assistant supports major voice assistants like Alexa, Google Assistant, and Siri, allowing for a truly integrated experience. Set schedules to automate your audio preferences, synchronize music across multiple rooms, or customize individual speaker settings to suit any environment. With quick setup and enhanced security features, you’ll have a streamlined and secure audio management system in no time.</p>', NULL, NULL, '2024-08-25 03:32:27', '2024-08-25 04:09:35'),
(24, 21, 12, 12, 'مساعد منزلي ذكي من شركة سمارت ويف', 'مساعد-منزلي-ذكي-من-شركة-سمارت-ويف', 'يُحدث مساعد المنزل على الموجة الذكيةثورة في الطريقة التي تدير بها مكبرات الصوت الذكية. بفضل التحكم الموحد وتكامل الأوامر الصوتية والإعدادات القابلة للتخصيص، يوفر هذا الجهاز راحة سهلة وتجارب صوتية محسنة لمنزلك.', '<p>قم بتحويل منزلك إلى سيمفونية اتصال مع مساعد . تم تصميم هذا الجهاز لإدارة مكبرات الصوت الذكية بسلاسة، ويوفر مركزًا مركزيًا للتحكم في مكبرات الصوت المتعددة بسهولة. استمتع بالتحكم الموحد من خلال واجهة بديهية، أو استخدم الأوامر الصوتية لضبط الإعدادات دون استخدام اليدين.</p>\r\n<p>يدعم SmartWave Home Assistant المساعدين الصوتيين الرئيسيين مثل Alexa وGoogle Assistant وSiri، مما يتيح تجربة متكاملة حقًا. قم بتعيين الجداول الزمنية لأتمتة تفضيلاتك الصوتية، أو مزامنة الموسيقى عبر غرف متعددة، أو تخصيص إعدادات السماعات الفردية لتناسب أي بيئة. بفضل الإعداد السريع وميزات الأمان المحسنة، سيكون لديك نظام إدارة صوت مبسط وآمن في وقت قصير.</p>', NULL, NULL, '2024-08-25 03:32:27', '2024-08-25 04:09:35'),
(25, 20, 9, 13, 'SafeAir UV-C Air Purifier', 'safeair-uv-c-air-purifier', 'The SafeAir UV-C Air Purifier delivers advanced air purification with cutting-edge UV-C technology, ensuring a cleaner, healthier environment. Ideal for any space, this purifier eliminates airborne germs, odors, and allergens, promoting fresher air for you and your family.', '<p>Breathe easier with the <strong>SafeAir UV-C Air Purifier</strong>, a state-of-the-art solution designed to enhance indoor air quality. Utilizing powerful UV-C light technology, this air purifier effectively destroys airborne pathogens, including viruses, bacteria, and mold spores, ensuring a hygienic and fresh atmosphere.</p>\r\n<p>Featuring a sleek, modern design, the SafeAir UV-C Air Purifier seamlessly fits into any room decor. Its advanced filtration system captures dust, pollen, and other allergens, making it ideal for allergy sufferers. The device operates quietly, providing clean air without disrupting your peace and quiet.</p>\r\n<p>Additional features include an intuitive control panel for easy operation, a filter replacement indicator, and multiple fan speed settings to customize your air purification experience. The SafeAir UV-C Air Purifier is also energy-efficient, designed to deliver superior performance while minimizing power consumption.</p>', NULL, NULL, '2024-08-25 03:42:02', '2024-08-25 03:42:02'),
(26, 21, 10, 13, 'منقي الهواء الياقوت UV-C', 'منقي-الهواء-الياقوت-uv-c', 'يوفر جهاز تنقية الهواء SafeAir UV-C تنقية متقدمة للهواء باستخدام تقنية UV-C المتطورة، مما يضمن بيئة أكثر نظافة وصحة. مثالي لأي مساحة، حيث يزيل هذا المنقي الجراثيم والروائح والمواد المسببة للحساسية المحمولة في الهواء، مما يعزز الهواء النقي لك ولعائلتك.', '<p>تنفس بشكل أسهل مع جهاز تنقية الهواء SafeAir UV-C، وهو حل متطور مصمم لتحسين جودة الهواء الداخلي. باستخدام تقنية الضوء UV-C القوية، يقوم جهاز تنقية الهواء هذا بتدمير مسببات الأمراض المحمولة بالهواء بشكل فعال، بما في ذلك الفيروسات والبكتيريا وجراثيم العفن، مما يضمن جوًا صحيًا ومنعشًا.</p>\r\n<p>يتميز جهاز تنقية الهواء SafeAir UV-C بتصميم أنيق وعصري، ويتناسب بسهولة مع ديكور أي غرفة. يعمل نظام الترشيح المتقدم على التقاط الغبار وحبوب اللقاح والمواد المسببة للحساسية الأخرى، مما يجعله مثاليًا لمن يعانون من الحساسية. يعمل الجهاز بهدوء، مما يوفر هواءً نظيفًا دون إزعاج سلامتك وهدوءك.</p>\r\n<p>تشتمل الميزات الإضافية على لوحة تحكم بديهية لسهولة التشغيل، ومؤشر استبدال الفلتر، وإعدادات متعددة لسرعة المروحة لتخصيص تجربة تنقية الهواء الخاصة بك. يتميز جهاز تنقية الهواء SafeAir UV-C أيضًا بالكفاءة في استخدام الطاقة، وهو مصمم لتقديم أداء فائق مع تقليل استهلاك الطاقة.</p>', NULL, NULL, '2024-08-25 03:42:02', '2024-08-25 03:42:02'),
(27, 20, 11, 14, 'X-Drive Gaming Mouse', 'x-drive-gaming-mouse', 'The X-Drive Gaming Mouse is your ultimate weapon for precision and speed. Engineered for gamers, it features ultra-responsive controls, customizable RGB lighting, and ergonomic design for hours of comfortable gameplay.', '<p>Dominate the battlefield with the <strong>X-Drive Gaming Mouse</strong>, meticulously crafted to give you the edge in every game. With its ultra-precise sensor offering up to 16,000 DPI, this mouse ensures pinpoint accuracy, allowing you to execute swift maneuvers and headshots with ease.</p>\r\n<p>Designed with gamers in mind, the X-Drive Gaming Mouse boasts an ergonomic shape that fits comfortably in your hand, reducing fatigue during extended gaming sessions. The customizable RGB lighting lets you personalize your setup with millions of color combinations, syncing with your game for an immersive experience.</p>\r\n<p>The X-Drive also features programmable buttons that can be tailored to your gaming style, enabling quick access to essential commands and macros. Built with durable, high-quality materials, this mouse is designed to withstand the rigors of intense gaming.</p>\r\n<p>With the X-Drive Gaming Mouse, you’ll experience smooth, responsive gameplay that keeps you ahead of the competition.</p>', NULL, NULL, '2024-08-25 03:52:18', '2024-08-25 03:52:18'),
(28, 21, 12, 14, 'ماوس الألعاب إكس درايف', 'ماوس-الألعاب-إكس-درايف', 'يُعد ماوس الألعاب X-Drive سلاحك الأمثل لتحقيق الدقة والسرعة. تم تصميمه خصيصًا للاعبين، فهو يتميز بعناصر تحكم فائقة الاستجابة وإضاءة RGB قابلة للتخصيص وتصميم مريح لساعات من اللعب المريح.', '<p>سيطر على ساحة المعركة باستخدام ماوس الألعاب X-Drive، المصمم بدقة ليمنحك الأفضلية في كل لعبة. بفضل مستشعره فائق الدقة الذي يوفر ما يصل إلى 16,000 نقطة في البوصة، يضمن هذا الماوس دقة بالغة، مما يسمح لك بتنفيذ مناورات سريعة والتقاط صور للرأس بسهولة.</p>\r\n<p>تم تصميم ماوس الألعاب X-Drive مع وضع اللاعبين في الاعتبار، ويتميز بشكل مريح يناسب يدك بشكل مريح، مما يقلل من التعب أثناء جلسات اللعب الممتدة. تتيح لك إضاءة RGB القابلة للتخصيص تخصيص إعدادك بملايين مجموعات الألوان، والمزامنة مع لعبتك للحصول على تجربة غامرة.</p>\r\n<p>يتميز X-Drive أيضًا بأزرار قابلة للبرمجة يمكن تخصيصها وفقًا لأسلوب اللعب الخاص بك، مما يتيح الوصول السريع إلى الأوامر الأساسية ووحدات الماكرو. تم تصميم هذا الماوس بمواد متينة وعالية الجودة لتحمل قسوة الألعاب المكثفة.</p>\r\n<p>مع ماوس الألعاب X-Drive، ستستمتع بتجربة لعب سلسة وسريعة الاستجابة تبقيك في صدارة المنافسة.</p>', NULL, NULL, '2024-08-25 03:52:18', '2024-08-25 03:52:18'),
(29, 20, 5, 15, 'Precision Craft Pencil with Holder', 'precision-craft-pencil-with-holder', 'The Precision Craft Pencil with Holder combines elegance and functionality, offering a sleek writing instrument paired with a stylish holder. Perfect for professionals, students, and creatives, it’s an essential addition to any workspace.', '<p>The <strong>PrecisionCraft Pencil with Holder</strong> combines elegance and functionality, offering a sleek writing instrument paired with a stylish holder. Perfect for professionals, students, and creatives, it’s an essential addition to any workspace.</p>\r\n<p><strong>Description:</strong><br />Elevate your workspace with the <strong>PrecisionCraft Pencil with Holder</strong>, a perfect blend of style and utility. This premium pencil is crafted for smooth, precise writing and sketching, making it ideal for daily tasks, detailed drawings, or note-taking. The pencil’s balanced design ensures comfort during extended use, reducing hand fatigue.</p>\r\n<p>Accompanying the pencil is a sleek holder that keeps your writing tool within easy reach while adding a touch of sophistication to your desk. The holder’s minimalist design complements any office or studio setup, making it not only functional but also a stylish accessory.</p>\r\n<p>Whether you’re a professional, student, or creative, the PrecisionCraft Pencil with Holder is a versatile tool that enhances your productivity and aesthetic. Keep your workspace organized and your ideas flowing with this elegant writing solution.</p>', NULL, NULL, '2024-08-25 04:00:22', '2024-08-25 04:00:22'),
(30, 21, 6, 15, 'قلم رصاص بريسيجن كرافت مع حامل', 'قلم-رصاص-بريسيجن-كرافت-مع-حامل', 'تجمع قلم PrecisionCraft مع الحامل بين الأناقة والوظيفية، حيث يقدم أداة كتابة أنيقة مصحوبة بحامل أنيق. مثالي للمحترفين والطلاب والمبدعين، وهو إضافة أساسية لأي مساحة عمل.', '<p>قم بترقية مساحة عملك باستخدام قلم PrecisionCraft مع الحامل، الذي يمثل مزيجًا مثاليًا من الأسلوب والفائدة. تم تصميم هذا القلم الفاخر للكتابة والرسم بسلاسة ودقة، مما يجعله مثاليًا للمهام اليومية، الرسومات التفصيلية، أو تدوين الملاحظات. يضمن التصميم المتوازن للقلم الراحة أثناء الاستخدام المطول، مما يقلل من إجهاد اليد.</p>\r\n<p>يصاحب القلم حامل أنيق يحافظ على أداة الكتابة الخاصة بك في متناول اليد بينما يضفي لمسة من الرقي على مكتبك. يتماشى التصميم البسيط للحامل مع أي مكتب أو استوديو، مما يجعله ليس فقط وظيفيًا بل أيضًا ملحقًا أنيقًا.</p>\r\n<p>سواء كنت محترفًا أو طالبًا أو مبدعًا، فإن قلم PrecisionCraft مع الحامل هو أداة متعددة الاستخدامات تعزز إنتاجيتك وجمالياتك. حافظ على تنظيم مساحة عملك وتدفق أفكارك باستخدام هذا الحل الكتابي الأنيق.</p>', NULL, NULL, '2024-08-25 04:00:23', '2024-08-25 04:00:23'),
(31, 20, 5, 16, 'Comprehensive Dictionary of Modern English', 'comprehensive-dictionary-of-modern-english', 'Unlock the full potential of your language skills with our Comprehensive Dictionary of Modern English. This meticulously curated e-book offers an extensive collection of words and definitions, providing readers with a reliable and up-to-date reference tool for everyday use. At $14.99, it’s an essential resource for students, professionals, and language enthusiasts alike.', '<p>Our Comprehensive Dictionary of Modern English is designed to be the definitive guide to contemporary English vocabulary. Featuring thousands of entries, this e-book covers a wide range of words, from the most commonly used to those emerging in modern usage. Each entry includes clear and precise definitions, along with phonetic pronunciations and usage examples to aid understanding.</p>\r\n<p>Key features include:</p>\r\n<ul>\r\n<li><strong>Extensive Vocabulary:</strong> Detailed definitions for a broad spectrum of words, including slang, idioms, and technical terms.</li>\r\n<li><strong>User-Friendly Layout:</strong> An intuitive format that makes it easy to quickly locate and understand entries.</li>\r\n<li><strong>Phonetic Pronunciations:</strong> Accurate pronunciation guides to help with correct word usage and speaking.</li>\r\n<li><strong>Usage Examples:</strong> Contextual sentences that illustrate how words are used in real-life scenarios.</li>\r\n</ul>\r\n<p>Whether you’re looking to expand your vocabulary, improve your writing, or simply better understand the nuances of the English language, this e-book is an invaluable tool. Its digital format allows for easy navigation and instant access, making it a convenient reference for any time and place.</p>', NULL, NULL, '2024-08-25 04:26:25', '2024-08-25 04:26:25');
INSERT INTO `product_contents` (`id`, `language_id`, `product_category_id`, `product_id`, `title`, `slug`, `summary`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(32, 21, 6, 16, 'القاموس الشامل للغة الانجليزية الحديثة', 'القاموس-الشامل-للغة-الانجليزية-الحديثة', 'أطلق العنان لإمكاناتك اللغوية الكاملة مع قاموسنا الشامل للغة الإنجليزية الحديثة. يقدم هذا الكتاب الإلكتروني المنسق بعناية مجموعة واسعة من الكلمات والتعريفات، مما يوفر للقراء أداة مرجعية موثوقة وحديثة للاستخدام اليومي. بسعر 14.99 دولارًا، يعد هذا الكتاب موردًا أساسيًا للطلاب والمحترفين وعشاق اللغة على حد سواء.', '<p>تم تصميم قاموسنا الشامل للغة الإنجليزية الحديثة ليكون الدليل النهائي لمفردات اللغة الإنجليزية المعاصرة. يضم هذا الكتاب الإلكتروني آلاف الإدخالات، ويغطي مجموعة واسعة من الكلمات، من الأكثر استخدامًا إلى تلك الناشئة في الاستخدام الحديث. يتضمن كل إدخال تعريفات واضحة ودقيقة، إلى جانب النطق الصوتي وأمثلة الاستخدام للمساعدة في الفهم.</p>\r\n<p>تتضمن الميزات الرئيسية ما يلي:</p>\r\n<ul>\r\n<li>مفردات واسعة: تعريفات مفصلة لمجموعة واسعة من الكلمات، بما في ذلك اللغة العامية، والتعبيرات الاصطلاحية، والمصطلحات التقنية.</li>\r\n<li>تصميم سهل الاستخدام: تنسيق بديهي يجعل من السهل تحديد موقع الإدخالات وفهمها بسرعة.</li>\r\n<li>النطق الصوتي: أدلة النطق الدقيقة للمساعدة في استخدام الكلمات والتحدث بشكل صحيح.</li>\r\n<li>أمثلة الاستخدام: الجمل السياقية التي توضح كيفية استخدام الكلمات في سيناريوهات الحياة الواقعية.</li>\r\n</ul>\r\n<p>سواء كنت تبحث عن توسيع مفرداتك أو تحسين كتابتك أو ببساطة فهم الفروق الدقيقة في اللغة الإنجليزية بشكل أفضل، فإن هذا الكتاب الإلكتروني يعد أداة لا تقدر بثمن. يتيح تنسيقه الرقمي سهولة التنقل والوصول الفوري، مما يجعله مرجعًا مناسبًا في أي وقت ومكان.</p>', NULL, NULL, '2024-08-25 04:26:25', '2024-08-25 04:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_coupons`
--

CREATE TABLE `product_coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` decimal(8,2) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `minimum_spend` decimal(8,2) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `billing_state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `total` decimal(8,2) UNSIGNED NOT NULL,
  `discount` decimal(8,2) UNSIGNED DEFAULT NULL,
  `product_shipping_charge_id` bigint UNSIGNED DEFAULT NULL,
  `shipping_cost` decimal(8,2) UNSIGNED DEFAULT NULL,
  `tax` decimal(8,2) UNSIGNED NOT NULL,
  `grand_total` decimal(8,2) UNSIGNED NOT NULL,
  `currency_text` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `currency_text_position` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `currency_symbol` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `currency_symbol_position` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `gateway_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `order_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_items`
--

CREATE TABLE `product_purchase_items` (
  `id` bigint UNSIGNED NOT NULL,
  `product_order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rating` smallint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_shipping_charges`
--

CREATE TABLE `product_shipping_charges` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `short_text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_charge` decimal(8,2) UNSIGNED NOT NULL,
  `serial_number` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `product_shipping_charges`
--

INSERT INTO `product_shipping_charges` (`id`, `language_id`, `title`, `short_text`, `shipping_charge`, `serial_number`, `created_at`, `updated_at`) VALUES
(27, 21, 'الشحن مجانا', 'ستكون الشحنة في غضون 10-15 يومًا.', 0.00, 1, '2024-08-25 05:12:44', '2024-08-25 05:12:44'),
(28, 21, 'شحن قياسي', 'سيتم الشحن في غضون 5-10 يوم.', 5.00, 2, '2024-08-25 05:13:00', '2024-08-25 05:13:00'),
(29, 21, 'شحن لمدة يومين', 'ستكون الشحنة في غضون يومين.', 10.00, 3, '2024-08-25 05:13:16', '2024-08-25 05:13:16'),
(30, 21, 'نفس الشحن يوم', 'ستكون الشحنة في غضون يوم واحد.', 20.00, 4, '2024-08-25 05:13:32', '2024-08-25 05:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `quick_links`
--

CREATE TABLE `quick_links` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `serial_number` smallint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `quick_links`
--

INSERT INTO `quick_links` (`id`, `language_id`, `title`, `url`, `serial_number`, `created_at`, `updated_at`) VALUES
(19, 20, 'FAQ', 'https://example.com', 1, '2024-08-29 02:44:23', '2024-08-29 02:44:23'),
(20, 20, 'About Us', 'https://example.com', 2, '2024-08-29 02:44:42', '2024-08-29 02:44:42'),
(22, 20, 'Terms & Conditions', 'https://example.com', 4, '2024-08-29 02:45:13', '2024-08-29 02:45:13'),
(23, 20, 'Privacy Policy', 'https://example.com', 5, '2024-08-29 02:45:32', '2024-08-29 02:45:32'),
(24, 21, 'التعليمات', 'https://example.com', 1, '2024-08-29 02:45:56', '2024-08-29 02:45:56'),
(25, 21, 'معلومات عنا', 'https://example.com', 2, '2024-08-29 02:46:14', '2024-08-29 02:46:14'),
(27, 21, 'الشروط والأحكام', 'https://example.com', 4, '2024-08-29 02:46:48', '2024-08-29 02:46:48'),
(28, 21, 'سياسة الخصوصية', 'https://example.com', 5, '2024-08-29 02:47:09', '2024-08-29 02:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint UNSIGNED NOT NULL,
  `work_process_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `category_section_status` tinyint DEFAULT '0',
  `feature_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `banner_section` tinyint DEFAULT '0',
  `testimonial_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `call_to_action_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `subscribe_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `vendor_featured_section_status` tinyint DEFAULT '1',
  `latest_service_section_status` tinyint DEFAULT '1',
  `footer_section_status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `about_section_status` tinyint NOT NULL DEFAULT '0',
  `features_section_status` tinyint NOT NULL DEFAULT '0',
  `about_testimonial_section_status` tinyint NOT NULL DEFAULT '0',
  `about_work_status` tinyint NOT NULL DEFAULT '0',
  `custom_section_status` text COLLATE utf8mb3_unicode_ci,
  `about_custom_section_status` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `work_process_section_status`, `category_section_status`, `feature_section_status`, `banner_section`, `testimonial_section_status`, `call_to_action_section_status`, `subscribe_section_status`, `vendor_featured_section_status`, `latest_service_section_status`, `footer_section_status`, `about_section_status`, `features_section_status`, `about_testimonial_section_status`, `about_work_status`, `custom_section_status`, `about_custom_section_status`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, '2024-09-12 07:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `section_contents`
--

CREATE TABLE `section_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint NOT NULL,
  `category_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latest_service_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_service_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_background_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workprocess_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workprocess_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workprocess_section_btn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workprocess_section_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workprocess_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_process_background_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_section_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_section_inner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_section_btn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_section_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `testimonial_section_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_section_clients` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_contents`
--

INSERT INTO `section_contents` (`id`, `language_id`, `category_section_title`, `latest_service_section_title`, `featured_service_section_title`, `vendor_section_title`, `hero_section_background_img`, `hero_section_title`, `hero_section_subtitle`, `workprocess_section_title`, `workprocess_section_subtitle`, `workprocess_section_btn`, `workprocess_section_url`, `workprocess_icon`, `work_process_background_img`, `call_to_action_section_image`, `call_to_action_section_inner_image`, `call_to_action_section_title`, `call_to_action_section_btn`, `call_to_action_icon`, `call_to_action_url`, `action_section_text`, `testimonial_section_image`, `testimonial_section_title`, `testimonial_section_subtitle`, `testimonial_section_clients`, `created_at`, `updated_at`) VALUES
(10, 20, 'Most Popular Categories', 'Most Popular Booking Services We Offer', 'Our Top Featured Services', 'Our Top Featured Shop', '66dfecf3c4055.png', 'Find Anything From Nearest Location To Make A Booking', 'Link Build is an advanced and modern-looking directory script with rich SEO features where you can create your.', 'How appointment Booking System Works', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind.', 'Book Now', 'https://example.com/', 'far fa-calendar-check iconpicker-component', '66dfed695bbae.png', '66dfef46ccd2d.png', '66dfef46cd0f6.png', 'Now Get 50% Discount For First Booking', 'Book Now', 'far fa-calendar-check iconpicker-component', 'https://example.com/', 'Take advantage of our special offer! Get a 50% discount on your first booking with us. Book now and enjoy our top-notch services at half the price. Don\'t miss out—this offer is available for a limited time only', '66dfee33d50b3.png', 'What Customers Say About Our Booking Systems', 'We have 2000+ positive customer reviews', '2k', '2024-09-10 00:53:13', '2024-09-10 05:23:44'),
(11, 21, 'الفئات الأكثر شعبية', 'خدمات الحجز الأكثر شعبية التي نقدمها', 'خدماتنا المميزة', 'أفضل المتاجر المميزة لدينا', '66e0298d76801.png', 'ابحث عن أي شيء من أقرب موقع لإجراء الحجز', 'Link Build هو برنامج نصي للدليل متقدم وحديث المظهر مع ميزات SEO غنية حيث يمكنك إنشاء دليلك الخاص.', 'كيف يعمل نظام حجز المواعيد', 'بعيدًا جدًا، خلف جبال الكلمات، بعيدًا عن بلدان Vokalia و Consonantia، يعيش المكفوفون.', 'احجز الآن', 'https://example.com/', 'far fa-calendar-check iconpicker-component', '66e02a5b71744.png', '66e02adbec064.png', '66e02adbec4bc.png', 'احصل الآن على خصم 50% للحجز الأول', 'احجز الآن', 'far fa-calendar-check iconpicker-component', 'https://example.com/', 'استفد من عرضنا الخاص! احصل على خصم 50% على أول حجز لك معنا. احجز الآن واستمتع بخدماتنا المتميزة بنصف السعر. لا تفوت الفرصة - هذا العرض متاح لفترة محدودة فقط', '66e02adbecc9e.png', 'ماذا يقول عملاؤنا عنا', 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت', '2 كيلو', '2024-09-10 05:12:13', '2024-09-10 05:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `meta_keyword_home` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_home` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_services` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_description_services` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_products` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_products` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_blog` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_blog` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_faq` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_faq` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_contact` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_contact` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_login` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_login` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_signup` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_signup` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keyword_forget_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_forget_password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keywords_vendor_login` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_vendor_login` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_keywords_vendor_signup` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_vendor_signup` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_keywords_vendor_forget_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_descriptions_vendor_forget_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_keywords_vendor_page` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_vendor_page` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_keywords_about_page` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_description_about_page` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `meta_keywords_staff_login_page` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_staff_login_page` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_keyword_pricing` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `meta_description_pricing` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `custome_page_meta_keyword` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `custome_page_meta_description` text COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `language_id`, `meta_keyword_home`, `meta_description_home`, `meta_keyword_services`, `meta_description_services`, `meta_keyword_products`, `meta_description_products`, `meta_keyword_blog`, `meta_description_blog`, `meta_keyword_faq`, `meta_description_faq`, `meta_keyword_contact`, `meta_description_contact`, `meta_keyword_login`, `meta_description_login`, `meta_keyword_signup`, `meta_description_signup`, `meta_keyword_forget_password`, `meta_description_forget_password`, `meta_keywords_vendor_login`, `meta_description_vendor_login`, `meta_keywords_vendor_signup`, `meta_description_vendor_signup`, `meta_keywords_vendor_forget_password`, `meta_descriptions_vendor_forget_password`, `meta_keywords_vendor_page`, `meta_description_vendor_page`, `meta_keywords_about_page`, `meta_description_about_page`, `meta_keywords_staff_login_page`, `meta_description_staff_login_page`, `created_at`, `updated_at`, `meta_keyword_pricing`, `meta_description_pricing`, `custome_page_meta_keyword`, `custome_page_meta_description`) VALUES
(5, 20, 'Home', 'Home Descriptions', 'Services', 'Services descriptions', 'Products', 'Product descriptions', 'Blog', 'Blog descriptions', 'Faq', 'faq descriptions', 'contact', 'contact descriptions', 'Login', 'Login descriptions', 'Signup', 'signup descriptions', 'Forget Password', 'Forget Password descriptions', 'Vendor Login', 'Vendor Login descriptions', 'Vendor Signup', 'Vendor Signup descriptions', 'Vendor Forget Password', 'vendor forget password descriptions', 'vendors', 'vendors descriptions', 'About us', 'about us descriptions', 'Staff Login', 'staff login descriptions', '2023-08-27 01:03:33', '2024-06-23 04:54:21', 'Pricing', 'Pricing Description', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint NOT NULL,
  `staff_id` int DEFAULT NULL,
  `status` tinyint NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `prev_price` decimal(8,2) DEFAULT NULL,
  `service_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_meeting` tinyint DEFAULT '0',
  `calendar_status` tinyint NOT NULL DEFAULT '0',
  `max_person` int DEFAULT NULL,
  `average_rating` decimal(5,1) DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `vendor_id`, `staff_id`, `status`, `price`, `prev_price`, `service_image`, `zoom_meeting`, `calendar_status`, `max_person`, `average_rating`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, 2500.00, 2700.00, '66c580b265d3e.png', 0, 0, NULL, NULL, '34.0522', '-118.2437', '2024-08-20 23:52:50', '2024-08-31 03:55:55'),
(2, 3, 16, 1, 40.00, 60.00, '66c58365e7aff.png', 0, 0, NULL, NULL, '39.9267', '-86.2110', '2024-08-21 00:04:21', '2024-08-31 03:56:12'),
(3, 6, NULL, 1, 40.00, 50.00, '66c5897106df3.png', 0, 0, NULL, NULL, '36.1761', '174.2294', '2024-08-21 00:30:09', '2024-08-31 03:56:25'),
(4, 7, 11, 1, 30.00, 40.00, '66c58b3fec1e6.png', 0, 0, NULL, 4.0, '24.0032', '89.2331', '2024-08-21 00:37:51', '2024-08-31 03:56:37'),
(5, 7, 11, 1, 35.00, 45.00, '66c58cc44911c.png', 0, 0, NULL, NULL, '25.0657', '55.1371', '2024-08-21 00:44:20', '2024-08-31 03:56:50'),
(6, 2, NULL, 1, 100.00, 200.00, '66c6c64b57ca4.png', 1, 0, 3, NULL, '', '', '2024-08-21 00:55:19', '2024-08-21 23:02:03'),
(7, 7, 11, 1, 150.00, 200.00, '66c6cf8700104.png', 0, 0, NULL, NULL, '6.6882', '-1.6202', '2024-08-21 23:41:27', '2024-08-31 03:53:51'),
(8, 3, 16, 1, 250.00, 300.00, '66c6d0fcdae8e.png', 0, 0, 3, 4.0, '34.9854', '-80.5498', '2024-08-21 23:47:40', '2024-08-31 03:53:31'),
(9, 7, 11, 1, 40.00, 50.00, '66c6d488075ed.png', 1, 0, 20, 5.0, '', '', '2024-08-22 00:02:48', '2024-08-28 06:29:13'),
(10, 7, 11, 1, 120.00, 150.00, '66d2a4b2d42b4.png', 0, 0, NULL, 5.0, '51.5128', '-0.1900', '2024-08-22 00:22:39', '2024-08-31 03:52:57'),
(11, 4, NULL, 1, 80.00, 100.00, '66c6e135e12b8.png', 0, 0, NULL, NULL, '39.7684', '-86.1581', '2024-08-22 00:56:53', '2024-08-31 03:52:35'),
(12, 5, 19, 1, 50.00, 65.00, '66c6e15e72d2b.png', 0, 0, 3, 5.0, '25.2721', '55.3214', '2024-08-22 00:57:34', '2024-08-31 03:52:06'),
(13, 4, NULL, 1, 50.00, 65.00, '66c6e61c0d9f0.png', 0, 0, NULL, NULL, '43.3351', '-80.3094', '2024-08-22 01:17:48', '2024-08-31 03:51:48'),
(14, 4, NULL, 1, 60.00, 75.00, '66c6f9020ced7.png', 1, 0, 10, NULL, '', '', '2024-08-22 02:38:26', '2024-08-22 02:38:26'),
(15, 6, NULL, 1, 120.00, 150.00, '66c700101e758.png', 0, 0, NULL, NULL, '38.7467', '-77.7617', '2024-08-22 03:08:32', '2024-08-31 03:51:29'),
(16, 7, 11, 1, 120.00, 150.00, '66c7040b65326.png', 0, 0, NULL, 5.0, '34.0522', '-118.2437', '2024-08-22 04:59:29', '2024-08-31 03:50:17'),
(17, 1, NULL, 1, 45.00, 60.00, '66c70698cc24d.png', 0, 0, NULL, NULL, '32.8663', '-96.7917', '2024-08-22 04:39:29', '2024-08-31 03:49:54'),
(18, 0, NULL, 1, 90.00, 120.00, '66c70eaa38827.png', 0, 0, NULL, NULL, '41.8369', '-87.6847', '2024-08-22 04:10:50', '2024-08-31 03:49:27'),
(19, 0, NULL, 1, 100.00, 130.00, '66c71499c500b.png', 0, 0, NULL, NULL, '28.0598', '-82.4117', '2024-08-22 04:36:09', '2024-08-31 03:48:57'),
(20, 5, 19, 1, 90.00, 120.00, '66c715618e0dc.png', 0, 0, NULL, NULL, '36.1761', '174.2294', '2024-08-22 05:15:51', '2024-08-31 03:48:22'),
(21, 2, NULL, 1, 200.00, 250.00, '66c716c750c2c.png', 0, 0, NULL, NULL, '1.3262', '103.8861', '2024-08-22 04:45:27', '2024-08-31 03:47:43'),
(22, 5, 19, 1, 99.00, 120.00, '66c717bd2460a.png', 0, 0, NULL, NULL, '53.7706', '-2.3847', '2024-08-22 04:49:33', '2024-08-31 03:47:03'),
(23, 6, NULL, 1, 75.00, 100.00, '66c71a1172f97.png', 1, 0, 3, NULL, '', '', '2024-08-22 03:25:31', '2024-08-22 04:59:29'),
(24, 0, NULL, 1, 150.00, 250.00, '66c71de77fcf0.png', 1, 0, 10, NULL, '', '', '2024-08-22 03:36:24', '2024-08-22 05:15:51'),
(26, 2, NULL, 1, 120.00, 150.00, '66d2a3153ad74.png', 0, 0, NULL, NULL, '44.0600', '-79.4600', '2024-08-30 22:59:01', '2024-08-31 02:45:37'),
(27, 6, NULL, 1, 120.00, 150.00, '66d3ec0ea78a9.png', 0, 0, 10, NULL, '24.012345', '89.987654', '2024-08-31 22:22:38', '2024-08-31 22:22:38'),
(28, 7, NULL, 1, 110.00, 130.00, '66d3ef110599b.png', 0, 1, NULL, NULL, '34.052235', '-118.243683', '2024-08-31 22:35:29', '2024-09-03 22:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `membership_id` int DEFAULT NULL,
  `vendor_id` bigint NOT NULL,
  `staff_id` bigint DEFAULT NULL,
  `service_id` bigint NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_person` int DEFAULT '1',
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_zip_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_date` date NOT NULL,
  `location` bigint DEFAULT NULL,
  `service_hour_id` bigint DEFAULT NULL,
  `start_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_paid` decimal(8,2) NOT NULL,
  `currency_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_text_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `refund` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint NOT NULL,
  `serial_number` bigint NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `background_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `icon`, `image`, `slug`, `language_id`, `serial_number`, `status`, `created_at`, `updated_at`, `background_color`) VALUES
(1, 'Doctor', 'fas fa-user-md', '', 'doctor', 20, 1, 1, '2024-08-20 23:12:20', '2024-08-28 05:37:17', 'DB607B'),
(2, 'طبيب', 'fas fa-user-md', '', 'طبيب', 21, 1, 1, '2024-08-20 23:12:59', '2024-08-20 23:12:59', 'CB0A38'),
(3, 'Electrical', 'fas fa-bolt', '', 'electrical', 20, 2, 1, '2024-08-20 23:14:40', '2024-08-28 05:37:50', '365DAD'),
(4, 'كهربائي', 'fas fa-bolt', '', 'كهربائي', 21, 2, 1, '2024-08-20 23:15:21', '2024-08-20 23:15:36', '036CDA'),
(5, 'Barber Shop', 'fas fa-cut', '', 'barber-shop', 20, 3, 1, '2024-08-20 23:19:31', '2024-08-28 05:38:20', '77BD37'),
(6, 'صالون حلاقة', 'fas fa-cut', '', 'صالون-حلاقة', 21, 3, 1, '2024-08-20 23:20:27', '2024-08-20 23:20:27', '429421'),
(7, 'Cleaning', 'fab fa-bitbucket', '', 'cleaning', 20, 4, 1, '2024-08-20 23:22:44', '2024-08-28 05:39:10', '9136FF'),
(8, 'تنظيف', 'fab fa-bitbucket', '', 'تنظيف', 21, 4, 1, '2024-08-20 23:23:18', '2024-08-20 23:23:18', '3425AF'),
(9, 'Plumber', 'fas fa-users', '', 'plumber', 20, 5, 1, '2024-08-20 23:25:39', '2024-08-28 05:39:48', 'F39238'),
(10, 'سباك', 'fas fa-users', '', 'سباك', 21, 5, 1, '2024-08-20 23:26:28', '2024-08-20 23:26:28', 'FF512F'),
(11, 'Education', 'fas fa-chalkboard-teacher', '', 'education', 20, 6, 1, '2024-08-20 23:27:19', '2024-08-28 05:40:20', '0DB8EE'),
(12, 'تعليم', 'fas fa-chalkboard-teacher', '', 'تعليم', 21, 6, 1, '2024-08-20 23:27:53', '2024-08-21 03:28:21', '021B79');

-- --------------------------------------------------------

--
-- Table structure for table `service_contents`
--

CREATE TABLE `service_contents` (
  `id` int NOT NULL,
  `service_id` bigint NOT NULL,
  `language_id` bigint NOT NULL,
  `category_id` bigint NOT NULL,
  `features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_contents`
--

INSERT INTO `service_contents` (`id`, `service_id`, `language_id`, `category_id`, `features`, `name`, `address`, `description`, `slug`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 1, 'Board-Certified Surgeons with Specialized Expertise\r\nState-of-the-Art Surgical Facilities and Equipment\r\nComprehensive Pre- and Post-Operative Care\r\nPersonalized Surgical Plans Tailored to Your Needs\r\n24/7 Support and Consultation Available', 'Expert Surgical Services', '123 Main Street, Los Angeles, CA, USA', '<p>Experience top-tier care with our Expert Surgical Services. Our team of board-certified surgeons brings specialized expertise to ensure the highest level of precision and safety in every procedure.</p>\r\n<p>We utilize state-of-the-art surgical facilities and equipment to provide you with the best possible outcomes.</p>\r\n<p>From comprehensive pre-operative evaluations to meticulous post-operative care, we are dedicated to supporting you every step of the way.</p>\r\n<p>Our personalized surgical plans are tailored to your specific needs, ensuring that you receive the most effective and appropriate treatment.</p>\r\n<p>With 24/7 support and consultation available, we are here to address any concerns and provide peace of mind throughout your surgical journey.</p>', 'expert-surgical-services', NULL, NULL, '2024-08-20 23:52:50', '2024-08-30 23:20:34'),
(2, 1, 21, 2, 'جراحون معتمدون يتمتعون بخبرة متخصصة\r\nمرافق ومعدات جراحية حديثة\r\nرعاية شاملة قبل وبعد الجراحة\r\nخطط جراحية مخصصة تناسب احتياجاتك\r\nدعم واستشارة متاحان على مدار الساعة طوال أيام الأسبوع', 'خدمات جراحية متخصصة', '123 شارع ماين، لوس أنجلوس، كاليفورنيا، الولايات المتحدة الأمريكية', '<p>استمتع برعاية من الدرجة الأولى مع خدماتنا الجراحية المتخصصة. يقدم فريقنا من الجراحين المعتمدين خبرة متخصصة لضمان أعلى مستوى من الدقة والسلامة في كل إجراء.</p>\r\n<p>نحن نستخدم أحدث المرافق والمعدات الجراحية لنقدم لك أفضل النتائج الممكنة.</p>\r\n<p>من التقييمات الشاملة قبل الجراحة إلى الرعاية الدقيقة بعد الجراحة، نحن ملتزمون بدعمك في كل خطوة على الطريق.</p>\r\n<p>خططنا الجراحية الشخصية مصممة لتناسب احتياجاتك المحددة، مما يضمن حصولك على العلاج الأكثر فعالية وملاءمة.</p>\r\n<p>مع الدعم والاستشارة المتاحة على مدار الساعة طوال أيام الأسبوع، نحن هنا لمعالجة أي مخاوف وتوفير راحة البال طوال رحلتك الجراحية.</p>', 'خدمات-جراحية-متخصصة', NULL, NULL, '2024-08-20 23:52:50', '2024-08-30 23:20:34'),
(3, 2, 20, 9, 'Certified and experienced plumbers\r\nEmergency leak repair services\r\nInstallation of plumbing fixtures\r\nDrain cleaning and unclogging\r\nPipe inspection and replacement', 'Reliable Plumbing Services', '789 Waterway Blvd, Indianapolis, IN, USA', '<p>Our expert plumbers offer top-quality repair, maintenance, and installation services for both homes and offices.</p>\r\n<p>Whether you’re dealing with a leaky faucet, a clogged drain, or need new fixtures installed, our certified professionals are ready to help.</p>\r\n<p>We provide emergency services to tackle urgent plumbing issues and ensure your plumbing system runs smoothly.</p>\r\n<p>Book our reliable plumbing services and enjoy peace of mind knowing your water systems are in expert hands.</p>', 'reliable-plumbing-services', NULL, NULL, '2024-08-21 00:04:21', '2024-08-21 00:06:34'),
(4, 2, 21, 10, 'سباكين معتمدين وذوي خبرة\r\nخدمات إصلاح التسربات الطارئة\r\nتركيب تركيبات السباكة\r\nتنظيف وإزالة انسداد المجاري\r\nفحص الأنابيب واستبدالها', 'خدمات السباكة الموثوقة', '789 Waterway Blvd، إنديانابوليس، إنديانا، الولايات المتحدة الأمريكية', '<p>يقدم سباكينا الخبراء خدمات إصلاح وصيانة وتركيب عالية الجودة للمنازل والمكاتب.</p>\r\n<p>سواء كنت تتعامل مع صنبور متسرب أو بالوعة مسدودة أو تحتاج إلى تركيب تركيبات جديدة، فإن محترفينا المعتمدين على استعداد للمساعدة.</p>\r\n<p>نحن نقدم خدمات الطوارئ لمعالجة مشاكل السباكة العاجلة وضمان تشغيل نظام السباكة الخاص بك بسلاسة.</p>\r\n<p>احجز خدمات السباكة الموثوقة لدينا واستمتع براحة البال مع العلم أن أنظمة المياه الخاصة بك في أيدٍ خبيرة.</p>', 'خدمات-السباكة-الموثوقة', NULL, NULL, '2024-08-21 00:04:21', '2024-08-29 03:20:14'),
(5, 3, 20, 7, 'Comprehensive Dusting & Vacuuming\r\nDetailed Kitchen & Bathroom Sanitization\r\nFloor & Surface Disinfection\r\nEnvironmentally Friendly Products\r\nCustomizable Scheduling', 'Residential Cleaning Service', '789 Clean St, Te Kōpuru, New Zealand', '<p>Our Premium Residential Cleaning Service ensures a thorough and meticulous approach to maintaining your home.</p>\r\n<p>We specialize in comprehensive dusting, vacuuming, and detailed sanitization of kitchens and bathrooms using environmentally friendly products.</p>\r\n<p>Enjoy customizable scheduling to suit your needs and a consistently pristine home environment.</p>', 'residential-cleaning-service', NULL, NULL, '2024-08-21 00:30:09', '2024-08-21 00:31:12'),
(6, 3, 21, 8, 'إزالة الغبار والتنظيف بالمكنسة الكهربائية بشكل شامل\r\nتطهير المطبخ والحمام بشكل مفصل\r\nتطهير الأرضيات والأسطح\r\nمنتجات صديقة للبيئة\r\nجدولة قابلة للتخصيص', 'خدمة التنظيف السكنية', '789 شارع كلين، تي كوبورو، نيوزيلندا', '<p>تضمن خدمة التنظيف السكنية المتميزة لدينا نهجًا شاملاً ودقيقًا للحفاظ على منزلك.</p>\r\n<p>نحن متخصصون في إزالة الغبار والتنظيف بالمكنسة الكهربائية والتطهير التفصيلي للمطابخ والحمامات باستخدام منتجات صديقة للبيئة.</p>\r\n<p>استمتع بالجدولة القابلة للتخصيص لتناسب احتياجاتك وبيئة منزلية نظيفة باستمرار.</p>', 'خدمة-التنظيف-السكنية', NULL, NULL, '2024-08-21 00:30:09', '2024-08-29 03:20:01'),
(7, 4, 20, 5, 'Precision Haircut\r\nProfessional Shaving\r\nBeard Trimming & Styling\r\nScalp Massage\r\nComplimentary Beverage', 'Executive Haircut & Grooming', 'UNITY STYLE, 6600, Pabna, Bangladesh', '<p>Experience top-notch grooming with our Executive Haircut &amp; Grooming service.</p>\r\n<p>Enjoy a precision haircut tailored to your style, professional shaving, and expert beard trimming and styling.</p>\r\n<p>Relax with a soothing scalp massage and enjoy a complimentary beverage during your appointment.</p>\r\n<p>Our skilled barbers are dedicated to providing a refined and personalized grooming experience.</p>', 'executive-haircut-&-grooming', NULL, NULL, '2024-08-21 00:37:52', '2024-08-21 00:37:52'),
(8, 4, 21, 6, 'قص الشعر بدقة\r\nحلاقة احترافية\r\nتشذيب وتصفيف اللحية\r\nتدليك فروة الرأس\r\nمشروب مجاني', 'قص الشعر والعناية الشخصية التنفيذية', 'يونيتي ستايل، 6600، بابنا، بنغلاديش', '<p>استمتع بأعلى مستويات العناية بالشعر من خلال خدمة قص الشعر والعناية الشخصية لدينا.</p>\r\n<p>استمتع بقص شعر دقيق يناسب أسلوبك، وحلاقة احترافية، وتشذيب وتصفيف اللحية على يد خبراء.</p>\r\n<p>استرخِ مع تدليك فروة الرأس المهدئ واستمتع بمشروب مجاني أثناء موعدك.</p>\r\n<p>يكرس حلاقونا المهرة أنفسهم لتوفير تجربة عناية شخصية راقية.</p>', 'قص-الشعر-والعناية-الشخصية-التنفيذية', NULL, NULL, '2024-08-21 00:37:52', '2024-08-29 03:19:46'),
(9, 5, 20, 5, 'Customized Haircut & Trim\r\nHot Towel Shave\r\nBeard Shaping & Maintenance\r\nRelaxing Scalp Treatment\r\nRefreshing Beverage Included', 'Elite Grooming & Styling Package', 'The Grooming Lounge - Cluster L - Dubai - UAE', '<p>Indulge in our Elite Grooming &amp; Styling Package, designed for a premium grooming experience.</p>\r\n<p>Receive a customized haircut and trim, complemented by a luxurious hot towel shave and precise beard shaping.</p>\r\n<p>Enjoy a relaxing scalp treatment and a refreshing beverage included with your service.</p>\r\n<p>Our experienced barbers ensure you leave looking sharp and feeling revitalized.</p>', 'elite-grooming-&-styling-package', NULL, NULL, '2024-08-21 00:44:20', '2024-08-21 00:44:20'),
(10, 5, 21, 6, 'قص الشعر وتقليمه حسب الطلب\r\nحلاقة بالمنشفة الساخنة\r\nتشكيل اللحية والعناية بها\r\nعلاج فروة الرأس المريح\r\nمشروب منعش متضمن', 'باقة العناية والتصفيف المتميزة', 'صالة العناية الشخصية - المجموعة L - دبي - الإمارات العربية المتحدة', '<p>استمتع بباقة العناية الشخصية والتصفيف المتميزة لدينا، والمصممة خصيصًا لتمنحك تجربة عناية شخصية متميزة.</p>\r\n<p>احصل على قصة شعر مخصصة، بالإضافة إلى حلاقة فاخرة بمنشفة ساخنة وتشكيل دقيق للحية.</p>\r\n<p>استمتع بعلاج فروة الرأس المريح والمشروبات المنعشة المضمنة في خدمتك.</p>\r\n<p>يضمن لك حلاقونا ذوو الخبرة أن تغادر المكان بمظهر أنيق وشعور بالحيوية.</p>', 'باقة-العناية-والتصفيف-المتميزة', NULL, NULL, '2024-08-21 00:44:20', '2024-08-29 03:19:31'),
(11, 6, 20, 1, 'Comprehensive Virtual Health Evaluation\r\nDetailed Diagnostic Recommendations\r\nCustomized Treatment Plan\r\nFollow-Up Virtual Appointments\r\n24/7 Telehealth Support', 'Online Medical Consultation', NULL, '<p>In today\'s fast-paced world, taking care of your health shouldn\'t be a challenge. Our Online Medical Consultation service brings top-tier healthcare directly to you, offering the expertise and attention you need without the hassle of visiting a clinic.</p>\r\n<p>Through a secure and easy-to-use virtual platform, our experienced medical professionals provide comprehensive health evaluations tailored to your unique needs. From initial consultations to follow-up appointments, each session is designed to ensure you receive personalized, high-quality care.</p>\r\n<p>During your consultation, you’ll undergo a thorough virtual health evaluation, where our doctors will assess your symptoms, review your medical history, and listen to your concerns. Based on this assessment, you\'ll receive detailed diagnostic recommendations, which may include further tests, specialist referrals, or specific lifestyle adjustments.</p>\r\n<p>What sets our service apart is the customized treatment plan we provide, tailored specifically to address your health concerns. Whether you’re managing a chronic condition, seeking advice on a new health issue, or simply looking to improve your overall well-being, our medical team is here to guide you every step of the way.</p>\r\n<p>The convenience of our service extends beyond the initial consultation. We offer follow-up virtual appointments to monitor your progress and adjust your treatment plan as needed, ensuring you receive the ongoing care you deserve. Additionally, our 24/7 telehealth support is available to answer any questions or address any concerns that may arise between appointments, providing you with peace of mind and continuous access to medical guidance.</p>\r\n<p>With our Online Medical Consultation, you can experience the benefits of high-quality healthcare without leaving your home. Our flexible scheduling options make it easy to fit healthcare into your busy life, allowing you to prioritize your well-being on your terms.</p>\r\n<p>Take control of your health with the convenience and excellence of our Online Medical Consultation service. Book your appointment today and experience the future of healthcare.</p>', 'online-medical-consultation', NULL, NULL, '2024-08-21 00:55:19', '2024-08-29 00:01:18'),
(12, 6, 21, 2, 'تقييم صحي شامل افتراضي\r\nتوصيات تشخيصية مفصلة\r\nخطة علاج مخصصة\r\nمواعيد متابعة افتراضية\r\nدعم عن بعد على مدار الساعة طوال أيام الأسبوع', 'استشارة طبية عبر الإنترنت', NULL, '<p>في عالم اليوم سريع الخطى، لا ينبغي أن يكون الاهتمام بصحتك تحديًا. توفر لك خدمة الاستشارة الطبية عبر الإنترنت رعاية صحية من الدرجة الأولى مباشرةً، وتقدم الخبرة والاهتمام الذي تحتاج إليه دون متاعب زيارة العيادة.</p>\r\n<p>من خلال منصة افتراضية آمنة وسهلة الاستخدام، يقدم متخصصونا الطبيون ذوو الخبرة تقييمات صحية شاملة مصممة خصيصًا لتلبية احتياجاتك الفريدة. من الاستشارات الأولية إلى مواعيد المتابعة، تم تصميم كل جلسة لضمان حصولك على رعاية شخصية وعالية الجودة.</p>\r\n<p>أثناء الاستشارة، ستخضع لتقييم صحي افتراضي شامل، حيث سيقوم أطباؤنا بتقييم أعراضك ومراجعة تاريخك الطبي والاستماع إلى مخاوفك. بناءً على هذا التقييم، ستتلقى توصيات تشخيصية مفصلة، ​​والتي قد تشمل اختبارات أخرى أو إحالات متخصصة أو تعديلات محددة على نمط الحياة.</p>\r\n<p>ما يميز خدمتنا هو خطة العلاج المخصصة التي نقدمها، والمصممة خصيصًا لمعالجة مخاوفك الصحية. سواء كنت تدير حالة مزمنة أو تبحث عن المشورة بشأن مشكلة صحية جديدة أو تبحث ببساطة عن تحسين صحتك العامة، فإن فريقنا الطبي موجود هنا لتوجيهك في كل خطوة على الطريق.</p>\r\n<p>تمتد راحة خدمتنا إلى ما هو أبعد من الاستشارة الأولية. نحن نقدم مواعيد متابعة افتراضية لمراقبة تقدمك وتعديل خطة العلاج الخاصة بك حسب الحاجة، مما يضمن حصولك على الرعاية المستمرة التي تستحقها. بالإضافة إلى ذلك، يتوفر دعمنا عن بعد على مدار الساعة طوال أيام الأسبوع للإجابة على أي أسئلة أو معالجة أي مخاوف قد تنشأ بين المواعيد، مما يوفر لك راحة البال والوصول المستمر إلى الإرشادات الطبية.</p>\r\n<p>من خلال الاستشارة الطبية عبر الإنترنت، يمكنك تجربة فوائد الرعاية الصحية عالية الجودة دون مغادرة منزلك. تجعل خيارات الجدولة المرنة لدينا من السهل ملاءمة الرعاية الصحية لحياتك المزدحمة، مما يسمح لك بإعطاء الأولوية لرفاهيتك وفقًا لشروطك.</p>\r\n<p>تحكم في صحتك من خلال الراحة والتميز في خدمة الاستشارة الطبية عبر الإنترنت. احجز موعدك اليوم واستمتع بمستقبل الرعاية الصحية.</p>', 'استشارة-طبية-عبر-الإنترنت', NULL, NULL, '2024-08-21 00:55:19', '2024-08-29 00:01:55'),
(13, 7, 20, 1, 'Full Health Assessment\r\nBlood Pressure Monitoring\r\nCholesterol and Lipid Profile\r\nDetailed Health Report and Recommendations', 'Thorough Health Assessment', 'Helth Care Center, Kumasi, Ghana', '<p>Ensure your well-being with our Thorough Health Assessment.</p>\r\n<p>This comprehensive service includes a detailed physical examination, an in-depth review of your medical history, and necessary diagnostic tests and laboratory work.</p>\r\n<p>Our expert team will analyze your health risks and provide a personalized report with tailored recommendations.</p>\r\n<p>Whether you’re seeking to address specific health concerns or just want a complete check-up, our Thorough Health Assessment offers the insights and guidance you need to maintain optimal health.</p>\r\n<p>Trust us to provide a thorough and professional evaluation for your peace of mind.</p>', 'thorough-health-assessment', NULL, NULL, '2024-08-21 23:41:27', '2024-08-30 23:12:55'),
(14, 7, 21, 2, 'التقييم الصحي الكامل\r\nمراقبة ضغط الدم\r\nالملف الشخصي للكوليسترول والدهون\r\nتقارير وتوصيات صحية مفصلة', 'تقييم صحي شامل', 'مركز الرعاية الصحية، كوماسي، غانا', '<p>اضمن سلامتك من خلال تقييمنا الصحي الشامل.</p>\r\n<p>تتضمن هذه الخدمة الشاملة فحصًا جسديًا مفصلاً ومراجعة متعمقة لتاريخك الطبي والاختبارات التشخيصية اللازمة والعمل المعملي.</p>\r\n<p>سيقوم فريق الخبراء لدينا بتحليل المخاطر الصحية الخاصة بك وتقديم تقرير شخصي مع توصيات مخصصة.</p>\r\n<p>سواء كنت تسعى إلى معالجة مشاكل صحية محددة أو تريد فقط إجراء فحص كامل، فإن تقييمنا الصحي الشامل يوفر لك الأفكار والإرشادات التي تحتاجها للحفاظ على صحة مثالية.</p>\r\n<p>ثق بنا لتقديم تقييم شامل ومهني لراحة بالك.</p>', 'تقييم-صحي-شامل', NULL, NULL, '2024-08-21 23:41:27', '2024-08-30 23:12:55'),
(15, 8, 20, 1, 'Complete Blood Panel\r\nECG (Electrocardiogram)\r\nDiabetes Screening\r\nKidney and Liver Function Tests', 'Advanced Diagnostic Screening', '456 Wellness Blvd, Monroe, NC, USA', '<p>The Advanced Diagnostic Screening is a comprehensive service designed to provide a detailed analysis of your health.</p>\r\n<p>It includes a complete blood panel, ECG for heart health, diabetes screening, and kidney and liver function tests.</p>\r\n<p>This thorough evaluation helps in the early detection of potential health issues, ensuring timely intervention and management.</p>', 'advanced-diagnostic-screening', NULL, NULL, '2024-08-21 23:47:40', '2024-08-21 23:47:40'),
(16, 8, 21, 2, 'لوحة دم كاملة\r\nتخطيط كهربية القلب (ECG)\r\nفحص مرض السكري\r\nاختبارات وظائف الكلى والكبد', 'الفحص التشخيصي المتقدم', '456 Wellness Blvd، مونرو، كارولاينا الشمالية، الولايات المتحدة الأمريكية', '<p>يعد الفحص التشخيصي المتقدم خدمة شاملة مصممة لتوفير تحليل مفصل لحالتك الصحية.</p>\r\n<p>ويشمل لوحة دم كاملة، وتخطيط القلب لصحة القلب، وفحص مرض السكري، واختبارات وظائف الكلى والكبد.</p>\r\n<p>يساعد هذا التقييم الشامل في الكشف المبكر عن المشكلات الصحية المحتملة، مما يضمن التدخل والإدارة في الوقت المناسب.</p>', 'الفحص-التشخيصي-المتقدم', NULL, NULL, '2024-08-21 23:47:40', '2024-08-29 03:18:43'),
(17, 9, 20, 11, 'One-on-One Tutoring Sessions\r\nCustomized Lesson Plans\r\nHomework Assistance\r\nExam Preparation Strategies\r\nFlexible Scheduling', 'Online Tutoring in Mathematics', NULL, '<p>Unlock the full potential of your mathematical abilities with our comprehensive Online Tutoring service, designed to cater to learners of all levels.</p>\r\n<p>Whether you\'re struggling with basic concepts or seeking to master advanced topics, our one-on-one sessions provide the focused attention you need to succeed.</p>\r\n<p>Conducted via Zoom, our tutoring sessions are flexible and convenient, allowing you to learn from the comfort of your home, office, or wherever you have an internet connection.</p>\r\n<p>Each session is tailored to your unique needs, with customized lesson plans that address your specific challenges and goals.</p>\r\n<p>In addition to personalized instruction, you\'ll benefit from dedicated homework assistance, ensuring you fully grasp each topic before moving on.</p>\r\n<p>Our tutors also offer targeted exam preparation strategies, helping you approach tests with confidence and clarity.</p>\r\n<p>We understand that life can be busy, so we offer flexible scheduling options to fit learning seamlessly into your routine.</p>\r\n<p>Whether you prefer morning, afternoon, or evening sessions, our tutors are available to accommodate your needs.</p>\r\n<p>Invest in your education with our Online Tutoring service and watch your mathematical skills flourish.</p>\r\n<p>Book your session today and take the first step toward academic success.</p>', 'online-tutoring-in-mathematics', NULL, NULL, '2024-08-22 00:02:48', '2024-08-28 23:58:45'),
(18, 9, 21, 12, 'جلسات تعليمية فردية\r\nخطط الدروس المخصصة\r\nالمساعدة في الواجبات المنزلية\r\nاستراتيجيات التحضير للامتحان\r\nجدولة مرنة', 'التدريس عبر الإنترنت في الرياضيات', NULL, '<p>أطلق العنان لإمكاناتك الكاملة في الرياضيات من خلال خدمة التدريس عبر الإنترنت الشاملة، والمصممة لتلبية احتياجات المتعلمين من جميع المستويات.</p>\r\n<p>سواء كنت تواجه صعوبة في المفاهيم الأساسية أو تسعى إلى إتقان مواضيع متقدمة، فإن جلساتنا الفردية توفر لك الاهتمام المركّز الذي تحتاجه لتحقيق النجاح.</p>\r\n<p>يتم إجراء جلسات التدريس لدينا عبر Zoom، وهي مرنة ومريحة، مما يسمح لك بالتعلم من راحة منزلك أو مكتبك أو أينما كان لديك اتصال بالإنترنت.</p>\r\n<p>يتم تصميم كل جلسة وفقًا لاحتياجاتك الفريدة، مع خطط دروس مخصصة تعالج تحدياتك وأهدافك المحددة.</p>\r\n<p>بالإضافة إلى التعليم الشخصي، ستستفيد من المساعدة المخصصة في الواجبات المنزلية، مما يضمن لك فهمًا كاملاً لكل موضوع قبل الانتقال إلى موضوع آخر.</p>\r\n<p>يقدم مدرسونا أيضًا استراتيجيات إعداد اختبار مستهدفة، مما يساعدك على التعامل مع الاختبارات بثقة ووضوح.</p>\r\n<p>نحن نتفهم أن الحياة قد تكون مزدحمة، لذلك نقدم خيارات جدولة مرنة لتناسب التعلم بسلاسة في روتينك.</p>\r\n<p>سواء كنت تفضل الجلسات الصباحية أو بعد الظهر أو المسائية، فإن مدرسينا متاحون لتلبية احتياجاتك.</p>\r\n<p>استثمر في تعليمك من خلال خدمة التدريس عبر الإنترنت وشاهد مهاراتك في الرياضيات تزدهر.</p>\r\n<p>احجز جلستك اليوم واتخذ الخطوة الأولى نحو النجاح الأكاديمي.</p>', 'التدريس-عبر-الإنترنت-في-الرياضيات', NULL, NULL, '2024-08-22 00:02:48', '2024-08-28 23:58:45'),
(19, 10, 20, 3, 'Complete Electrical System Inspection\r\nWiring and Outlet Repairs\r\nCircuit Breaker Maintenance\r\nLighting Installation and Repairs\r\nSafety Compliance Checks', 'Home Electrical Maintenance', 'Electrical Wholesalers, Westbourne Grove, London, UK', '<p>Ensure the safety and efficiency of your home’s electrical system with our Professional Home Electrical Maintenance service.</p>\r\n<p>Our experienced electricians provide thorough inspections, identify and repair faulty wiring and outlets, and maintain circuit breakers.</p>\r\n<p>We also offer lighting installation and repair services, ensuring your home remains well-lit and safe.</p>\r\n<p>Each visit includes a safety compliance check to protect your home from electrical hazards.</p>', 'home-electrical-maintenance', NULL, NULL, '2024-08-22 00:22:39', '2024-08-22 01:24:50'),
(20, 10, 21, 4, 'فحص كامل للنظام الكهربائي\r\nإصلاح الأسلاك والمنافذ\r\nصيانة قواطع الدائرة\r\nتركيب وإصلاح الإضاءة\r\nفحوصات الامتثال للسلامة', 'صيانة كهرباء المنزل', 'تجار الجملة للأجهزة الكهربائية، ويستبورن جروف، لندن، المملكة المتحدة', '<p>تأكد من سلامة وكفاءة النظام الكهربائي في منزلك من خلال خدمة الصيانة الكهربائية المنزلية الاحترافية لدينا.</p>\r\n<p>يقدم كهربائيونا ذوو الخبرة عمليات تفتيش شاملة، وتحديد وإصلاح الأسلاك والمنافذ المعيبة، وصيانة قواطع الدائرة.</p>\r\n<p>نقدم أيضًا خدمات تركيب وإصلاح الإضاءة، مما يضمن بقاء منزلك مضاءً جيدًا وآمنًا.</p>\r\n<p>تتضمن كل زيارة فحصًا للامتثال للسلامة لحماية منزلك من المخاطر الكهربائية.</p>', 'صيانة-كهرباء-المنزل', NULL, NULL, '2024-08-22 00:22:39', '2024-08-29 03:18:28'),
(21, 11, 20, 7, 'Comprehensive Dusting and Vacuuming\r\nDeep Floor and Carpet Cleaning\r\nSurface Sanitization and Disinfection\r\nBed Linen Replacement and Room Organization\r\nWaste Disposal and Air Freshening', 'Room Sanitization and Cleaning', 'cleaning services near Indiana, USA', '<p>Elevate the cleanliness and hygiene of your living space with our Executive Room Sanitization and Maintenance service.</p>\r\n<p>Our expert cleaners deliver meticulous dusting, vacuuming, and deep cleaning of floors and carpets, ensuring a pristine environment.</p>\r\n<p>We sanitize and disinfect all surfaces, replace bed linens, and organize your room to perfection.</p>\r\n<p>The service also includes waste disposal and air freshening, leaving your space immaculate and inviting.</p>', 'room-sanitization-and-cleaning', NULL, NULL, '2024-08-22 00:56:53', '2024-08-22 01:24:13'),
(22, 11, 21, 8, 'إزالة الغبار والتنظيف بالمكنسة الكهربائية\r\nالتنظيف العميق للأرضيات والسجاد\r\nتعقيم الأسطح وتطهيرها\r\nاستبدال أغطية الأسرة وتنظيم الغرف\r\nالتخلص من النفايات وتجديد الهواء', 'تعقيم وتنظيف الغرف', 'خدمات التنظيف بالقرب من إنديانا، الولايات المتحدة الأمريكية', '<p>ارتقِ بنظافة ونقاء مساحة معيشتك من خلال خدمة تعقيم وصيانة الغرف التنفيذية.</p>\r\n<p>يقدم عمال النظافة الخبراء لدينا خدمات إزالة الغبار والتنظيف بالمكنسة الكهربائية والتنظيف العميق للأرضيات والسجاد، مما يضمن بيئة نقية.</p>\r\n<p>نقوم بتعقيم وتطهير جميع الأسطح، واستبدال أغطية الأسرة، وتنظيم غرفتك بشكل مثالي.</p>\r\n<p>تتضمن الخدمة أيضًا التخلص من النفايات وتنقية الهواء، مما يجعل مساحتك نظيفة وجذابة.</p>', 'تعقيم-وتنظيف-الغرف', NULL, NULL, '2024-08-22 00:56:53', '2024-08-29 03:18:17'),
(23, 12, 20, 11, 'Tailored One-on-One Tutoring\r\nFlexible Curriculum Coverage\r\nHomework and Assignment Assistance\r\nExam and Test Preparation\r\nInteractive Learning Techniques', 'Customized In-Person Tutoring', 'Bangladesh Embassy - Abu Hail street - Dubai - United Arab Emirates', '<p>Experience the benefits of Customized In-Person Tutoring, designed to meet the unique educational needs of each student.</p>\r\n<p>Our one-on-one sessions offer flexible curriculum coverage, ensuring that every subject area is addressed according to the student\'s requirements.</p>\r\n<p>The service includes comprehensive homework help, assignment support, and targeted exam preparation, all delivered with interactive and engaging learning</p>\r\n<p>techniques to maximize understanding and retention.</p>', 'customized-in-person-tutoring', NULL, NULL, '2024-08-22 00:57:34', '2024-08-22 00:57:34'),
(24, 12, 21, 12, 'دروس خصوصية فردية مصممة خصيصًا\r\nتغطية مرنة للمناهج الدراسية\r\nمساعدة في الواجبات المنزلية والواجبات المنزلية\r\nإعداد الامتحانات والاختبارات\r\nتقنيات التعلم التفاعلية', 'دروس خصوصية شخصية مخصصة', 'سفارة بنغلاديش - شارع أبو هيل - دبي - الإمارات العربية المتحدة', '<p>استمتع بفوائد الدروس الخصوصية الشخصية المخصصة، والمصممة لتلبية الاحتياجات التعليمية الفريدة لكل طالب.</p>\r\n<p>توفر جلساتنا الفردية تغطية مرنة للمناهج الدراسية، مما يضمن معالجة كل مجال من مجالات الموضوع وفقًا لمتطلبات الطالب.</p>\r\n<p>وتتضمن الخدمة مساعدة شاملة في الواجبات المنزلية، ودعم المهام، وإعدادًا مستهدفًا للاختبارات، وكل ذلك يتم تقديمه باستخدام تقنيات تعليمية تفاعلية وجذابة</p>\r\n<p>لتعظيم الفهم والاحتفاظ بالمعلومات.</p>', 'دروس-خصوصية-شخصية-مخصصة', NULL, NULL, '2024-08-22 00:57:34', '2024-08-29 03:18:03'),
(25, 13, 20, 5, 'Customized Haircut and Style\r\nExpert Beard Sculpting\r\nLuxurious Hot Towel Service\r\nRevitalizing Scalp Treatment\r\nComplimentary Beverage', 'Men\'s Grooming and Styling', 'The Grooming Lounge, Hespeler Road, Cambridge, ON, Canada', '<p>Experience the Prestige Men\'s Grooming and Styling service, designed for those who appreciate the finer details.</p>\r\n<p>Our expert barbers offer customized haircuts and styling, alongside precise beard sculpting for a polished look.</p>\r\n<p>Indulge in a luxurious hot towel service and a revitalizing scalp treatment, leaving you refreshed and invigorated.</p>\r\n<p>A complimentary beverage is provided, ensuring a complete grooming experience.</p>', 'men\'s-grooming-and-styling', NULL, NULL, '2024-08-22 01:17:48', '2024-08-22 01:19:07'),
(26, 13, 21, 6, 'قص الشعر وتصفيفه حسب الطلب\r\nنحت اللحية على يد خبراء\r\nخدمة منشفة ساخنة فاخرة\r\nعلاج فروة الرأس المنعش\r\nمشروب مجاني', 'العناية بالرجل وتصفيف شعره', 'صالة العناية بالجمال، طريق هيسبيلر، كامبريدج، أونتاريو، كندا', '<p>استمتع بخدمة العناية بالشعر والتصفيف للرجال من Prestige، المصممة خصيصًا لأولئك الذين يقدرون التفاصيل الدقيقة.</p>\r\n<p>يقدم حلاقونا الخبراء قصات شعر وتصفيف مخصصة، إلى جانب نحت اللحية بدقة للحصول على مظهر أنيق.</p>\r\n<p>انغمس في خدمة منشفة ساخنة فاخرة وعلاج فروة الرأس المنعش، مما يجعلك منتعشًا ونشطًا.</p>\r\n<p>يتم تقديم مشروب مجاني، مما يضمن تجربة عناية كاملة.</p>', 'العناية-بالرجل-وتصفيف-شعره', NULL, NULL, '2024-08-22 01:17:48', '2024-08-29 03:17:51'),
(27, 14, 20, 11, 'Personalized One-on-One Sessions\r\nInteractive and Engaging Learning Materials\r\nFlexible Scheduling Options\r\nExtensive Subject Matter Expertise\r\nComprehensive Progress Tracking', 'Online Educational Coaching', NULL, '<p>Achieve academic excellence with our <strong>Online Educational Coaching</strong> service.</p>\r\n<p>Delivered via Zoom, this service offers customized one-on-one coaching tailored to your specific learning objectives.</p>\r\n<p>Experience interactive and engaging learning materials, flexible scheduling to fit your needs, and benefit from our extensive subject matter expertise.</p>\r\n<p>We also provide comprehensive progress tracking to ensure you reach your educational goals.</p>', 'online-educational-coaching', NULL, NULL, '2024-08-22 02:38:26', '2024-08-26 22:09:38'),
(28, 14, 21, 12, 'جلسات فردية مخصصة\r\nمواد تعليمية تفاعلية وجذابة\r\nخيارات جدولة مرنة\r\nخبرة واسعة في الموضوع\r\nتتبع شامل للتقدم', 'التدريب التعليمي عبر الإنترنت', NULL, '<p>حقق التميز الأكاديمي من خلال خدمة التدريب التعليمي عبر الإنترنت المتميزة لدينا.</p>\r\n<p>تقدم هذه الخدمة، التي يتم تقديمها عبر تطبيق Zoom، تدريبًا فرديًا مخصصًا ومصممًا وفقًا لأهدافك التعليمية المحددة.</p>\r\n<p>استمتع بمواد تعليمية تفاعلية وجذابة، وجدول زمني مرن يناسب احتياجاتك، واستفد من خبرتنا الواسعة في الموضوع.</p>\r\n<p>كما نقدم تتبعًا شاملاً للتقدم لضمان تحقيق أهدافك التعليمية.</p>', 'التدريب-التعليمي-عبر-الإنترنت', NULL, NULL, '2024-08-22 02:38:26', '2024-08-26 22:08:52'),
(29, 15, 20, 3, 'Thorough Electrical System Evaluation\r\nPrecision Wiring and Circuit Repairs\r\nAdvanced Circuit Breaker Servicing\r\nEnergy-Efficient Lighting Solutions\r\nComprehensive Safety and Compliance Checks', 'Premier Electrical Care', '789 Electric Ave, Vint Hill Farms, VA, USA', '<p>Ensure the highest standards of electrical service with our Premier Electrical Care.</p>\r\n<p>Our expert technicians provide a detailed evaluation of your electrical system, addressing wiring and circuit issues with precision.</p>\r\n<p>We offer advanced servicing for circuit breakers and implement energy-efficient lighting solutions.</p>\r\n<p>Comprehensive safety and compliance checks are also included, guaranteeing that your electrical setup is both safe and up-to-date.</p>', 'premier-electrical-care', NULL, NULL, '2024-08-22 03:08:32', '2024-08-22 03:10:37'),
(30, 15, 21, 4, 'تقييم شامل للنظام الكهربائي\r\nإصلاح الأسلاك والدوائر الكهربائية بدقة\r\nخدمة متقدمة لقواطع الدوائر\r\nحلول الإضاءة الموفرة للطاقة\r\nفحوصات السلامة والامتثال الشاملة', 'رعاية كهربائية ممتازة', '789 شارع إلكتريك، مزارع فينت هيل، فيرجينيا، الولايات المتحدة الأمريكية', '<p>تأكد من أعلى معايير الخدمة الكهربائية من خلال خدمة رعاية كهربائية ممتازة الخاصة بنا.</p>\r\n<p>يقدم فنيونا الخبراء تقييمًا تفصيليًا لنظامك الكهربائي، ومعالجة مشكلات الأسلاك والدوائر بدقة.</p>\r\n<p>نقدم خدمة متقدمة لقواطع الدائرة وننفذ حلول الإضاءة الموفرة للطاقة.</p>\r\n<p>كما يتم تضمين فحوصات السلامة والامتثال الشاملة، مما يضمن أن إعدادك الكهربائي آمن وحديث.</p>', 'رعاية-كهربائية-ممتازة', NULL, NULL, '2024-08-22 03:08:32', '2024-08-29 03:17:13'),
(31, 16, 20, 9, 'Expert Diagnosis\r\nQuality Parts\r\nUpgrades & Replacements\r\nEfficient Installation\r\nSatisfaction Guarantee\r\nAffordable Pricing', 'Faucet Repair & Installation', 'Los Angeles, CA, USA', '<p><strong>Ensure flawless functionality with our Premier Faucet Repair &amp; Installation Services.</strong></p>\r\n<p>Our team of skilled technicians is dedicated to providing top-tier faucet solutions, ensuring your plumbing system operates flawlessly.</p>\r\n<p>We start with a comprehensive inspection to accurately diagnose any issues, from persistent leaks and annoying drips to diminished water pressure.</p>\r\n<p>Using only high-quality parts and professional tools, we expertly repair existing faucets, guaranteeing reliable performance and durability.</p>\r\n<p>When it comes to installing new faucets, we handle every detail with precision.</p>\r\n<p>Our efficient installation process ensures your new fixtures are perfectly aligned and functioning optimally, enhancing both the aesthetics and functionality of your space.</p>\r\n<p>We also offer customized solutions to meet your specific needs, including upgrades to modern, water-efficient models and replacements for outdated fixtures.</p>\r\n<p>To prevent future issues, we provide thorough maintenance checks and adjustments, addressing potential problems before they arise.</p>\r\n<p>For those unexpected emergencies, our prompt service ensures that urgent faucet issues are resolved quickly and effectively, minimizing disruption to your daily routine.</p>\r\n<p>Trust us for all your faucet repair and installation needs, and experience exceptional service with a commitment to quality and customer satisfaction.</p>', 'faucet-repair-&-installation', NULL, NULL, '2024-08-22 03:25:31', '2024-08-30 22:43:13'),
(32, 16, 21, 10, 'تشخيص الخبراء\r\nقطع غيار عالية الجودة\r\nترقيات واستبدالات\r\nتركيب فعال\r\nضمان الرضا\r\nأسعار معقولة', 'إصلاح وتركيب الصنابير', 'لوس أنجلوس، كاليفورنيا، الولايات المتحدة الأمريكية', '<p>تأكد من الأداء الوظيفي الخالي من العيوب من خلال خدمات إصلاح وتركيب الصنابير المتميزة لدينا.</p>\r\n<p>يكرس فريقنا من الفنيين المهرة أنفسهم لتقديم حلول صنابير من الدرجة الأولى، وضمان عمل نظام السباكة الخاص بك دون عيوب.</p>\r\n<p>نبدأ بفحص شامل لتشخيص أي مشكلات بدقة، من التسربات المستمرة والتنقيط المزعج إلى انخفاض ضغط المياه.</p>\r\n<p>باستخدام أجزاء عالية الجودة وأدوات احترافية فقط، نقوم بإصلاح الصنابير الموجودة بخبرة، مما يضمن الأداء الموثوق والمتانة.</p>\r\n<p>عندما يتعلق الأمر بتثبيت صنابير جديدة، فإننا نتعامل مع كل التفاصيل بدقة.</p>\r\n<p>تضمن عملية التثبيت الفعّالة لدينا محاذاة التركيبات الجديدة بشكل مثالي وعملها على النحو الأمثل، مما يعزز من جماليات ووظائف مساحتك.</p>\r\n<p>نحن نقدم أيضًا حلولاً مخصصة لتلبية احتياجاتك المحددة، بما في ذلك الترقيات إلى النماذج الحديثة الموفرة للمياه واستبدال التركيبات القديمة.</p>\r\n<p>لمنع المشكلات المستقبلية، نقدم فحوصات وتعديلات صيانة شاملة، ومعالجة المشكلات المحتملة قبل ظهورها.</p>\r\n<p>بالنسبة لحالات الطوارئ غير المتوقعة، تضمن خدمتنا السريعة حل مشكلات الصنابير العاجلة بسرعة وفعالية، مما يقلل من الاضطراب في روتينك اليومي.</p>\r\n<p>ثق بنا في جميع احتياجاتك المتعلقة بإصلاح وتثبيت الصنابير، واستمتع بخدمة استثنائية مع الالتزام بالجودة ورضا العملاء.</p>', 'إصلاح-وتركيب-الصنابير', NULL, NULL, '2024-08-22 03:25:31', '2024-08-30 22:43:13'),
(33, 17, 20, 5, 'Customized Haircut and Styling\r\nPrecision Beard Trimming\r\nHot Towel Shave\r\nScalp Massage and Conditioning\r\nRefreshing Beverage Included', 'Signature Barber Experience', 'Grooming Room, Hillcrest Avenue, Dallas, TX, USA', '<p>Enhance your grooming routine with our Executive Barbering service.</p>\r\n<p>Located in New York, our barbers provide expert haircuts and styling, precise beard trimming, and a luxurious hot towel shave.</p>\r\n<p>Enjoy a relaxing scalp massage and conditioning treatment, and a refreshing beverage to make your experience truly exceptional.</p>', 'signature-barber-experience', NULL, NULL, '2024-08-22 03:36:24', '2024-08-22 03:36:24'),
(34, 17, 21, 6, 'قص الشعر وتصفيفه حسب الطلب\r\nتشذيب اللحية بدقة\r\nحلاقة بمنشفة ساخنة\r\nتدليك فروة الرأس وترطيبها\r\nمشروب منعش متضمن', 'تجربة الحلاقة المميزة', 'غرفة العناية بالحيوانات الأليفة، شارع هيلكريست، دالاس، تكساس، الولايات المتحدة الأمريكية', '<p>عزز روتين العناية بشعرك من خلال خدمة الحلاقة التنفيذية لدينا.</p>\r\n<p>يقع مصففو الشعر لدينا في نيويورك، ويقدمون قصات شعر وتصفيفات احترافية، وتشذيبًا دقيقًا للحية، وحلاقة فاخرة بمنشفة ساخنة.</p>\r\n<p>استمتع بتدليك فروة الرأس وعلاج الترطيب المريح، ومشروب منعش لجعل تجربتك استثنائية حقًا.</p>', 'تجربة-الحلاقة-المميزة', NULL, NULL, '2024-08-22 03:36:24', '2024-08-29 03:16:41'),
(35, 18, 20, 7, 'Comprehensive Dusting and Vacuuming\r\nDeep Floor and Carpet Cleaning\r\nSurface Sanitization\r\nBed Linen Replacement\r\nTrash Removal and Air Freshening', 'Top-Notch Room Cleaning', 'U.S. 20, Chicago, IL, USA', '<p>Ensure your space is impeccably clean with our Top-Notch Room Cleaning service.</p>\r\n<p>Based in Chicago, we offer thorough dusting, vacuuming, and deep cleaning of floors and carpets.</p>\r\n<p>Our service includes surface sanitization, bed linen replacement, and trash removal, with an air freshening treatment to keep your environment fresh and welcoming.</p>', 'top-notch-room-cleaning', NULL, NULL, '2024-08-22 04:10:50', '2024-08-29 03:16:14'),
(36, 18, 21, 8, 'إزالة الغبار والتنظيف بالمكنسة الكهربائية\r\nالتنظيف العميق للأرضيات والسجاد\r\nتعقيم الأسطح\r\nاستبدال أغطية الأسرة\r\nإزالة القمامة وتجديد الهواء', 'تنظيف الغرف على أعلى مستوى', 'الولايات المتحدة الأمريكية 20، شيكاغو، إلينوي، الولايات المتحدة الأمريكية', '<p>تأكد من نظافة مساحتك بشكل لا تشوبه شائبة من خلال خدمة تنظيف الغرف المتميزة لدينا.</p>\r\n<p>نحن موجودون في شيكاغو، ونقدم خدمات إزالة الغبار والتنظيف بالمكنسة الكهربائية والتنظيف العميق للأرضيات والسجاد.</p>\r\n<p>تشمل خدمتنا تطهير الأسطح واستبدال أغطية الأسرة وإزالة القمامة، مع معالجة منعشة للهواء للحفاظ على بيئتك منعشة وترحيبية.</p>', 'تنظيف-الغرف-على-أعلى-مستوى', NULL, NULL, '2024-08-22 04:10:50', '2024-08-29 03:16:14'),
(37, 19, 20, 3, 'Diagnostic and Repair of PCs\r\nElectronic Device Troubleshooting\r\nComponent Replacement and Repair\r\nSystem Optimization and Maintenance\r\nData Backup and Recovery', 'Precision Electronics Service', '567 Tech Blvd, Tampa, FL, USA', '<p>Trust our Precision Electronics Service for expert care of your electronic devices.</p>\r\n<p>Located in San Francisco, we offer meticulous diagnostic and repair services for PCs and other electronics.</p>\r\n<p>Our offerings include troubleshooting, component replacement, system optimization, and data backup and recovery, ensuring your devices perform at their best.</p>', 'precision-electronics-service', NULL, NULL, '2024-08-22 04:36:09', '2024-08-22 04:36:09'),
(38, 19, 21, 4, 'تشخيص وإصلاح أجهزة الكمبيوتر\r\nاستكشاف أخطاء الأجهزة الإلكترونية وإصلاحها\r\nاستبدال المكونات وإصلاحها\r\nتحسين النظام وصيانته\r\nنسخ البيانات احتياطيًا واستعادتها', 'خدمة الالكترونيات الدقيقة', '567 Tech Blvd، تامبا، فلوريدا، الولايات المتحدة الأمريكية', '<p>ثق في خدمة الإلكترونيات الدقيقة لدينا للحصول على رعاية متخصصة لأجهزتك الإلكترونية.</p>\r\n<p>نحن موجودون في سان فرانسيسكو، ونقدم خدمات تشخيص وإصلاح دقيقة لأجهزة الكمبيوتر وغيرها من الأجهزة الإلكترونية.</p>\r\n<p>تشمل عروضنا استكشاف الأخطاء وإصلاحها، واستبدال المكونات، وتحسين النظام، والنسخ الاحتياطي للبيانات واستعادتها، مما يضمن أداء أجهزتك بأفضل ما يمكن.</p>', 'خدمة-الالكترونيات-الدقيقة', NULL, NULL, '2024-08-22 04:36:09', '2024-08-29 03:15:50'),
(39, 20, 20, 7, 'Thorough Dusting and Vacuuming\r\nDeep Floor and Carpet Cleaning\r\nComprehensive Surface Sanitization\r\nBed Linen Replacement\r\nTrash Removal and Air Freshening', 'Elite Cleaning Solutions', '789 Clean Street, Te Kōpuru, New Zealand', '<p>Experience superior cleanliness and an unparalleled level of service with our Elite Cleaning Solutions. Based in the vibrant city of New York, we pride ourselves on delivering meticulous and thorough cleaning services that cater to the unique needs of every client. Whether you’re maintaining a high-end residential space, a bustling office environment, or any other type of property, our professional cleaning team is dedicated to transforming your surroundings into a spotless, welcoming haven.</p>\r\n<p>Our comprehensive cleaning services begin with meticulous dusting and vacuuming, ensuring that every nook and cranny is free of dust and debris. We understand the importance of maintaining clean floors and carpets, which is why we offer deep cleaning solutions that penetrate beyond the surface, removing stubborn dirt and allergens that ordinary cleaning methods might miss. Our team uses state-of-the-art equipment and eco-friendly cleaning products to ensure your floors and carpets not only look immaculate but are also safe for everyone who uses the space.</p>\r\n<p>In addition to our exceptional floor and carpet care, we provide a full range of services designed to elevate the overall cleanliness and hygiene of your space. This includes comprehensive surface sanitization, where we meticulously clean and disinfect all high-touch areas, from countertops to door handles, to reduce the spread of germs and bacteria. We also take care of your comfort and convenience by replacing bed linens with fresh, crisp sheets and handling trash removal, ensuring that every aspect of your environment is refreshed and revitalized.</p>\r\n<p>To complete our service, we offer an air freshening treatment that leaves your space smelling clean and inviting. Whether you prefer a subtle, calming fragrance or a more invigorating scent, our air freshening options are designed to enhance the overall atmosphere of your space, making it a place where you and your guests will feel at ease.</p>\r\n<p>Choose Elite Cleaning Solutions for a cleaning service that goes above and beyond the ordinary. With our attention to detail and commitment to excellence, we ensure that every aspect of your space is pristine, welcoming, and ready to impress. Let us provide you with a cleaning experience that not only meets but exceeds your expectations.</p>', 'elite-cleaning-solutions', NULL, NULL, '2024-08-22 04:39:29', '2024-08-29 03:15:05'),
(40, 20, 21, 8, 'إزالة الغبار والتنظيف بالمكنسة الكهربائية\r\nالتنظيف العميق للأرضيات والسجاد\r\nالتطهير الشامل للأسطح\r\nاستبدال أغطية الأسرة\r\nإزالة القمامة وتجديد الهواء', 'حلول التنظيف المتميزة', '789 شارع كلين، تي كوبورو، نيوزيلندا', '<p>استمتع بنظافة فائقة وخدمة لا مثيل لها مع حلول التنظيف الفاخرة لدينا. نحن في نيويورك نفتخر بتقديم خدمات تنظيف دقيقة وشاملة تلبي احتياجات كل عميل بشكل خاص. سواء كنت تحافظ على مساحة سكنية فاخرة، أو بيئة مكتبية مزدحمة، أو أي نوع آخر من الممتلكات، فإن فريق التنظيف المحترف لدينا ملتزم بتحويل محيطك إلى مكان نظيف ومرحب.</p>\r\n<p>تبدأ خدمات التنظيف الشاملة لدينا بتنظيف دقيق وإزالة الغبار باستخدام المكنسة الكهربائية، لضمان خلو كل زاوية وركن من الغبار والحطام. نحن ندرك أهمية الحفاظ على نظافة الأرضيات والسجاد، ولهذا السبب نقدم حلول تنظيف عميقة تتوغل تحت السطح، مما يزيل الأوساخ المستعصية ومسببات الحساسية التي قد تفوتها طرق التنظيف العادية. يستخدم فريقنا أحدث المعدات ومنتجات التنظيف الصديقة للبيئة لضمان أن تبدو الأرضيات والسجاد نظيفة وآمنة لجميع مستخدمي المكان.</p>\r\n<p>بالإضافة إلى العناية الممتازة بالأرضيات والسجاد، نقدم مجموعة كاملة من الخدمات المصممة لرفع مستوى النظافة العامة والصحة في مساحتك. يشمل ذلك تعقيم الأسطح بشكل شامل، حيث نقوم بتنظيف وتعقيم جميع المناطق التي يتم لمسها بشكل متكرر، من الأسطح إلى مقابض الأبواب، لتقليل انتشار الجراثيم والبكتيريا. كما نعتني براحتك ورفاهيتك عن طريق استبدال بياضات السرير بأخرى نظيفة وجديدة، والتخلص من القمامة، لضمان أن يتم تحديث وإحياء كل جانب من جوانب بيئتك.</p>\r\n<p>لإكمال خدمتنا، نقدم معالجة لتلطيف الهواء تترك مساحتك برائحة نظيفة وجذابة. سواء كنت تفضل رائحة خفيفة ومهدئة أو رائحة أكثر تنشيطًا، فإن خيارات تلطيف الهواء لدينا مصممة لتعزيز الأجواء العامة لمكانك، مما يجعله مكانًا تشعر فيه أنت وضيوفك بالراحة.</p>\r\n<p>اختر حلول التنظيف الفاخرة لدينا لخدمة تنظيف تتجاوز العادي. مع اهتمامنا بالتفاصيل والتزامنا بالتميز، نضمن أن يكون كل جانب من جوانب مساحتك نظيفًا ومرحبًا وجاهزًا للإبهار. دعنا نقدم لك تجربة تنظيف تلبي توقعاتك وتتجاوزها.</p>', 'حلول-التنظيف-المتميزة', NULL, NULL, '2024-08-22 04:39:29', '2024-08-29 03:15:05'),
(41, 21, 20, 3, 'Comprehensive Building Wiring Installation\r\nElectrical System Design and Planning\r\nHigh-voltage and Low-Voltage Wiring\r\nCode Compliance and Safety Checks\r\nTroubleshooting and System Upgrades', 'Building Wiring Experts', '123 Circuit Rd, Singapore', '<p>Ensure your building’s electrical system is installed and maintained to the highest standards with our premier Building Wiring Experts service, where we bring decades of expertise and precision to every project. Based in the heart of Los Angeles, we specialize in delivering comprehensive wiring solutions for a diverse range of building types, from residential complexes to commercial skyscrapers. Our team of licensed electricians is adept at handling both high-voltage and low-voltage installations, ensuring that every aspect of your electrical infrastructure is meticulously planned and executed.</p>\r\n<p>Our services go beyond just installation; we offer a full suite of electrical solutions tailored to meet the unique needs of each building. This includes custom electrical system design, where we work closely with you to create a layout that maximizes efficiency, functionality, and safety. We ensure all designs are fully compliant with the latest building codes and industry standards, giving you peace of mind that your electrical system is built to last.</p>\r\n<p>Safety is at the forefront of everything we do. Our team conducts thorough safety checks at every stage of the installation process, identifying and mitigating potential risks before they become issues. We also offer regular maintenance and troubleshooting services to ensure that your system continues to operate smoothly long after the initial installation. Whether it\'s diagnosing a complex issue, performing routine inspections, or upgrading outdated systems, our experts are equipped to handle it all.</p>\r\n<p>Moreover, we understand that technology is constantly evolving, which is why we stay ahead of the curve with system upgrades that enhance your building\'s energy efficiency and reduce long-term operational costs. Our commitment to using the latest tools and technologies ensures that your electrical infrastructure remains robust and future-proof.</p>\r\n<p>Choose our Building Wiring Experts service for a reliable, efficient, and safe electrical system that meets the highest standards of quality. Let us power your building with the expertise and dedication that only the best in the industry can provide.</p>', 'building-wiring-experts', NULL, NULL, '2024-08-22 04:45:27', '2024-08-29 03:37:15'),
(42, 21, 21, 4, 'تركيب الأسلاك الكهربائية الشاملة للمباني\r\nتصميم وتخطيط النظام الكهربائي\r\nتمديد الأسلاك ذات الجهد العالي والمنخفض\r\nالامتثال للكود وفحوصات السلامة\r\nاستكشاف الأخطاء وإصلاحها وترقيات النظام', 'خبراء في تمديدات الأسلاك في المباني', '123 طريق سيركيت، سنغافورة', '<p>تأكد من أن نظام الكهرباء في مبناك يتم تركيبه وصيانته وفقًا لأعلى المعايير مع خدمة \"خبراء توصيل الكهرباء للمباني\" المتميزة لدينا، حيث نقدم عقودًا من الخبرة والدقة في كل مشروع. مقيمون في قلب لوس أنجلوس، نحن متخصصون في تقديم حلول شاملة لتوصيل الكهرباء لمجموعة متنوعة من أنواع المباني، من المجمعات السكنية إلى ناطحات السحاب التجارية. فريقنا من الكهربائيين المرخصين يتمتع بالمهارة في التعامل مع كل من التركيبات ذات الجهد العالي والمنخفض، مما يضمن أن كل جانب من جوانب البنية التحتية الكهربائية لديك يتم تخطيطه وتنفيذه بدقة.</p>\r\n<p>تتجاوز خدماتنا مجرد التركيب؛ نحن نقدم مجموعة كاملة من الحلول الكهربائية المصممة لتلبية الاحتياجات الفريدة لكل مبنى. يشمل ذلك تصميم أنظمة الكهرباء المخصصة، حيث نعمل عن كثب معك لإنشاء تخطيط يعزز من الكفاءة والوظائف والسلامة. نحرص على أن تكون جميع التصاميم متوافقة تمامًا مع أحدث القوانين والمعايير الصناعية، مما يمنحك راحة البال بأن نظام الكهرباء لديك مصمم ليصمد طويلاً.</p>\r\n<p>السلامة هي في طليعة كل ما نقوم به. يقوم فريقنا بإجراء فحوصات سلامة شاملة في كل مرحلة من مراحل عملية التركيب، حيث يتم تحديد ومعالجة المخاطر المحتملة قبل أن تتحول إلى مشاكل. كما نقدم خدمات الصيانة الدورية والتشخيص لضمان استمرار نظامك في العمل بسلاسة بعد التركيب الأولي. سواء كان الأمر يتعلق بتشخيص مشكلة معقدة، أو إجراء فحوصات روتينية، أو ترقية الأنظمة القديمة، فإن خبراءنا مستعدون للتعامل مع كل ذلك.</p>\r\n<p>علاوة على ذلك، نحن ندرك أن التكنولوجيا تتطور باستمرار، ولهذا السبب نبقى على اطلاع دائم بالتحديثات التي تعزز من كفاءة الطاقة في المبنى الخاص بك وتقلل من تكاليف التشغيل على المدى الطويل. التزامنا باستخدام أحدث الأدوات والتقنيات يضمن أن تظل بنيتك التحتية الكهربائية قوية ومستعدة للمستقبل.</p>\r\n<p>اختر خدمة \"خبراء توصيل الكهرباء للمباني\" لدينا لنظام كهربائي موثوق وكفء وآمن يلبي أعلى معايير الجودة. دعنا نوفر الطاقة لمبناك بالخبرة والتفاني الذي لا يقدمه إلا الأفضل في الصناعة.</p>', 'خبراء-في-تمديدات-الأسلاك-في-المباني', NULL, NULL, '2024-08-22 04:45:27', '2024-08-29 03:13:01'),
(43, 22, 20, 7, 'Detailed Dusting and Vacuuming\r\nIntensive Floor and Carpet Cleaning\r\nFull Surface Disinfection\r\nLinen Change and Bed-Making\r\nWaste Disposal and Odor Control', 'Superior Cleaning Services', '456 Hygiene, Clayton-le-Moors, Accrington, UK', '<p>Elevate your environment with our Superior Cleaning Services.</p>\r\n<p>Located in London, we offer comprehensive cleaning solutions, including detailed dusting, vacuuming, and intensive floor and carpet cleaning.</p>\r\n<p>Our service ensures full surface disinfection, linen changes, waste disposal, and odor control, leaving your space immaculate and fresh.</p>', 'superior-cleaning-services', NULL, NULL, '2024-08-22 04:49:33', '2024-08-22 04:49:33'),
(44, 22, 21, 8, 'إزالة الغبار والتنظيف بالمكنسة الكهربائية بشكل مفصل\r\nالتنظيف المكثف للأرضيات والسجاد\r\nتطهير الأسطح بالكامل\r\nتغيير البياضات وترتيب السرير\r\nالتخلص من النفايات والتحكم في الروائح', 'خدمات التنظيف المتميزة', '456 Hygiene، كلايتون لو مورز، أكينجتون، المملكة المتحدة', '<p>ارتقِ ببيئتك بخدمات التنظيف المتميزة لدينا.</p>\r\n<p>نقدم في لندن حلول تنظيف شاملة، بما في ذلك إزالة الغبار بالتفصيل، والتنظيف بالمكنسة الكهربائية، وتنظيف الأرضيات والسجاد بشكل مكثف.</p>\r\n<p>تضمن خدمتنا تطهير الأسطح بالكامل، وتغيير البياضات، والتخلص من النفايات، والتحكم في الروائح، مما يترك مساحتك نظيفة ومنعشة.</p>', 'خدمات-التنظيف-المتميزة', NULL, NULL, '2024-08-22 04:49:33', '2024-08-29 03:08:52'),
(45, 23, 20, 1, 'Zoom-Based Medical Consultations\r\nPrescription Services\r\nFollow-up and Continuous Care\r\nSpecialist Referrals\r\nSecure and Confidential Sessions', 'Virtual Health Consultations', NULL, '<p>Receive expert medical advice from the comfort of your home with our Virtual Health Consultations via Zoom.</p>\r\n<p>Based in Dubai, our service offers secure and confidential video consultations with licensed doctors, allowing you to access professional healthcare without visiting a clinic.</p>\r\n<p>Our doctors provide prescriptions, follow-up care, and specialist referrals tailored to your health needs.</p>', 'virtual-health-consultations', NULL, NULL, '2024-08-22 04:59:29', '2024-08-22 04:59:29'),
(46, 23, 21, 2, 'الاستشارات الطبية عبر تطبيق زووم\r\nخدمات الوصفات الطبية\r\nالمتابعة والرعاية المستمرة\r\nالإحالات المتخصصة\r\nجلسات آمنة وسرية', 'استشارات صحية افتراضية', NULL, '<p>احصل على المشورة الطبية المتخصصة من راحة منزلك من خلال استشاراتنا الصحية الافتراضية عبر تطبيق زووم.</p>\r\n<p>تقع خدمتنا في دبي، وتقدم استشارات فيديو آمنة وسرية مع أطباء مرخصين، مما يتيح لك الوصول إلى الرعاية الصحية المهنية دون زيارة عيادة.</p>\r\n<p>يقدم أطباؤنا الوصفات الطبية والرعاية المتابعة والإحالات المتخصصة المصممة خصيصًا لاحتياجاتك الصحية.</p>', 'استشارات-صحية-افتراضية', NULL, NULL, '2024-08-22 04:59:29', '2024-08-22 04:59:29'),
(47, 24, 20, 11, 'Comprehensive Language Courses for All Levels\r\nNative-Speaking Instructors\r\nInteractive Sessions via Zoom\r\nCultural Immersion and Language Labs\r\nPersonalized Learning Paths and Progress Tracking', 'Intensive Language Programs', NULL, '<p>Achieve fluency with our Intensive Language Programs, offering comprehensive online language courses via Zoom.</p>\r\n<p>Whether you\'re a beginner or looking to enhance your skills, our programs provide expert instruction from native-speaking teachers.</p>\r\n<p>Engage in interactive sessions, cultural immersion activities, and personalized learning paths, all designed to help you master your chosen language efficiently.</p>', 'intensive-language-programs', NULL, NULL, '2024-08-22 05:15:52', '2024-08-22 05:15:52'),
(48, 24, 21, 12, 'دورات لغة شاملة لجميع المستويات\r\nمدرسون يتحدثون اللغة الأم\r\nجلسات تفاعلية عبر زووم\r\nالانغماس الثقافي ومختبرات اللغة\r\nمسارات التعلم الشخصية وتتبع التقدم', 'برامج اللغة المكثفة', NULL, '<p>حقق الطلاقة من خلال برامجنا اللغوية المكثفة، والتي تقدم دورات لغوية شاملة عبر الإنترنت عبر Zoom.</p>\r\n<p>سواء كنت مبتدئًا أو تتطلع إلى تحسين مهاراتك، فإن برامجنا توفر تعليمات متخصصة من معلمين يتحدثون اللغة الأم.</p>\r\n<p>اشترك في جلسات تفاعلية وأنشطة انغماس ثقافي ومسارات تعليمية مخصصة، وكلها مصممة لمساعدتك على إتقان اللغة التي اخترتها بكفاءة.</p>', 'برامج-اللغة-المكثفة', NULL, NULL, '2024-08-22 05:15:52', '2024-08-22 05:15:52');
INSERT INTO `service_contents` (`id`, `service_id`, `language_id`, `category_id`, `features`, `name`, `address`, `description`, `slug`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(49, 26, 20, 3, 'Certified Technicians with Extensive Experience\r\nFast and Efficient Repairs for All AC Brands\r\nTransparent Pricing with No Hidden Fees\r\n24/7 Emergency Repair Available\r\nComprehensive Diagnostic and Maintenance Checks', 'Air Conditioning Repair Service', '123 Comfort Lane, Newmarket, ON, Canada', '<p>Keep your cool with Expert Air Conditioning Repair! Our team of certified technicians brings years of experience to diagnose and repair any issues with your air conditioning unit.</p>\r\n<p>Whether it\'s a minor malfunction or a major breakdown, we provide fast and efficient repairs for all AC brands, ensuring your system is up and running in no time.</p>\r\n<p>We offer transparent pricing with no hidden fees, so you know exactly what to expect. Our 24/7 emergency repair ensures we\'re always available when you need us most.</p>\r\n<p>We also provide comprehensive diagnostic and maintenance checks to prevent future issues. Trust us to keep your home comfortable all year round.</p>', 'air-conditioning-repair-service', NULL, NULL, '2024-08-30 22:59:01', '2024-08-30 23:08:11'),
(50, 26, 21, 4, 'فنيون معتمدون يتمتعون بخبرة واسعة\r\nإصلاحات سريعة وفعالة لجميع ماركات مكيفات الهواء\r\nأسعار شفافة بدون رسوم خفية\r\nإصلاحات طارئة متاحة على مدار الساعة طوال أيام الأسبوع\r\nفحوصات تشخيصية وصيانة شاملة', 'خدمة اصلاح تكييف الهواء', '123 Comfort Lane، نيوماركت، أونتاريو، كندا', '<p>حافظ على هدوئك مع خدمة إصلاح مكيفات الهواء المتخصصة! يتمتع فريقنا من الفنيين المعتمدين بخبرة سنوات في تشخيص وإصلاح أي مشكلات في وحدة تكييف الهواء الخاصة بك.</p>\r\n<p>سواء كان عطلًا بسيطًا أو انهيارًا كبيرًا، فإننا نقدم إصلاحات سريعة وفعالة لجميع ماركات مكيفات الهواء، مما يضمن تشغيل نظامك في أي وقت من الأوقات.</p>\r\n<p>نقدم أسعارًا شفافة بدون رسوم خفية، حتى تعرف بالضبط ما تتوقعه. تضمن خدمة الإصلاح الطارئة لدينا على مدار الساعة طوال أيام الأسبوع أننا متاحون دائمًا عندما تحتاج إلينا أكثر.</p>\r\n<p>كما نقدم فحوصات تشخيصية وصيانة شاملة لمنع حدوث مشكلات في المستقبل. ثق بنا للحفاظ على منزلك مريحًا طوال العام.</p>', 'خدمة-اصلاح-تكييف-الهواء', NULL, NULL, '2024-08-30 22:59:01', '2024-08-30 23:08:11'),
(51, 27, 20, 1, 'Comprehensive health assessments\r\nPersonalized treatment plans\r\nExperienced medical professionals\r\nVirtual or in-person consultations\r\nFollow-up care and support', 'Care First Medical Consultation', '123 Wellness Avenue, Pabna, Bangladesh', '<p>Experience top-notch healthcare with <strong>Care First Medical Consultation</strong>. Our dedicated team of experienced doctors is here to provide you with personalized care tailored to your unique needs.</p>\r\n<p>Whether you\'re seeking a routine check-up or specialized medical advice, we ensure that you receive the highest quality of care.</p>\r\n<p>With both virtual and in-person consultation options, CareFirst Medical makes it easy to prioritize your health.</p>\r\n<p>Take the first step towards a healthier you with our comprehensive health assessments and expert guidance.</p>\r\n<p>Book your consultation today and benefit from our reduced price of $120, down from $150.</p>', 'care-first-medical-consultation', NULL, NULL, '2024-08-31 22:22:39', '2024-08-31 22:22:39'),
(52, 27, 21, 2, 'تقييمات صحية شاملة\r\nخطط علاج مخصصة\r\nمتخصصون طبيون ذوو خبرة\r\nاستشارات افتراضية أو شخصية\r\nرعاية ودعم متابعة', 'استشارة طبية من كير فيرست', '123 شارع العافية، بابنا، بنغلاديش', '<p>استمتع برعاية صحية من الدرجة الأولى مع استشارة Care First الطبية. فريقنا المتخصص من الأطباء ذوي الخبرة موجود هنا لتزويدك برعاية شخصية مصممة خصيصًا لتلبية احتياجاتك الفريدة.</p>\r\n<p>سواء كنت تبحث عن فحص روتيني أو نصيحة طبية متخصصة، فإننا نضمن حصولك على أعلى جودة من الرعاية.</p>\r\n<p>مع خيارات الاستشارة الافتراضية والشخصية، تسهل استشارة طبية من كير فيرست إعطاء الأولوية لصحتك.</p>\r\n<p>اتخذ الخطوة الأولى نحو صحة أفضل من خلال تقييماتنا الصحية الشاملة والتوجيه من الخبراء.</p>\r\n<p>احجز استشارتك اليوم واستفد من سعرنا المخفض البالغ 120 دولارًا، بدلاً من 150 دولارًا.</p>', 'استشارة-طبية-من-كير-فيرست', NULL, NULL, '2024-08-31 22:22:39', '2024-08-31 22:22:39'),
(53, 28, 20, 9, 'Fully equipped for on-site plumbing services\r\n24/7 emergency response\r\nCertified and experienced plumbers\r\nQuick repairs and installations\r\nState-of-the-art leak detection tools\r\nSustainable plumbing solutions', 'Mobile Plumbing Solutions Van', '123 Main St, Los Angeles, CA 90012, USA', '<p>Introducing our Mobile Plumbing Solutions Van, designed to bring top-tier plumbing services directly to your location with utmost convenience and efficiency.</p>\r\n<p>Our state-of-the-art van is equipped with the latest plumbing tools and technology to handle a wide range of plumbing issues, from minor leaks and clogs to major repairs and installations. </p>\r\n<p>Our skilled and certified plumbers are available around the clock to address your needs promptly, ensuring minimal disruption to your daily routine.</p>\r\n<p>Our van is stocked with high-quality parts and equipment, enabling us to perform on-the-spot repairs and installations with precision.</p>\r\n<p>We use advanced leak detection tools to identify and resolve issues quickly, helping to prevent potential damage and costly repairs.</p>\r\n<p>At Mobile Plumbing Solutions, we are committed to providing exceptional service with a focus on environmental responsibility.</p>\r\n<p>Our eco-friendly solutions aim to reduce water wastage and enhance the efficiency of your plumbing system.</p>\r\n<p>We prioritize customer satisfaction and work diligently to ensure that every job is completed to the highest standards.</p>\r\n<p>Whether you’re facing an emergency plumbing issue or need routine maintenance, our Mobile Plumbing Solutions Van is ready to deliver reliable, professional service right to your doorstep.</p>\r\n<p>Trust us to address your plumbing needs with expertise and care, restoring your system swiftly and effectively.</p>', 'mobile-plumbing-solutions-van', NULL, NULL, '2024-08-31 22:35:29', '2024-08-31 22:35:29'),
(54, 28, 21, 10, 'مجهز بالكامل لخدمات السباكة في الموقع\r\nاستجابة للطوارئ على مدار الساعة طوال أيام الأسبوع\r\nسباكون معتمدون وذوو خبرة\r\nإصلاحات وتركيبات سريعة\r\nأدوات حديثة للكشف عن التسربات\r\nحلول سباكة مستدامة', 'حلول السباكة المتنقلة', '123 Main St، لوس أنجلوس، كاليفورنيا 90012، الولايات المتحدة الأمريكية', '<p>نقدم لكم شاحنة حلول السباكة المتنقلة الخاصة بنا، والمصممة لتقديم خدمات السباكة من الدرجة الأولى مباشرة إلى موقعك بأقصى قدر من الراحة والكفاءة.</p>\r\n<p>شاحنتنا الحديثة مجهزة بأحدث أدوات السباكة والتكنولوجيا للتعامل مع مجموعة واسعة من مشاكل السباكة، من التسريبات البسيطة والانسدادات إلى الإصلاحات والتركيبات الكبرى.</p>\r\n<p>يتوفر سباكينا المهرة والمعتمدون على مدار الساعة لتلبية احتياجاتك على الفور، مما يضمن الحد الأدنى من الاضطراب في روتينك اليومي.</p>\r\n<p>شاحنتنا مزودة بأجزاء ومعدات عالية الجودة، مما يمكننا من إجراء إصلاحات وتركيبات على الفور بدقة.</p>\r\n<p>نحن نستخدم أدوات الكشف عن التسرب المتقدمة لتحديد المشكلات وحلها بسرعة، مما يساعد على منع الأضرار المحتملة والإصلاحات المكلفة.</p>\r\n<p>نحن في Mobile Plumbing Solutions ملتزمون بتقديم خدمة استثنائية مع التركيز على المسؤولية البيئية.</p>\r\n<p>تهدف حلولنا الصديقة للبيئة إلى تقليل هدر المياه وتعزيز كفاءة نظام السباكة الخاص بك.</p>\r\n<p>نعطي الأولوية لرضا العملاء ونعمل بجد لضمان إكمال كل مهمة بأعلى المعايير.</p>\r\n<p>سواء كنت تواجه مشكلة طارئة في السباكة أو تحتاج إلى صيانة روتينية، فإن شاحنة حلول السباكة المتنقلة لدينا جاهزة لتقديم خدمة موثوقة واحترافية إلى باب منزلك.</p>\r\n<p>ثق بنا لتلبية احتياجاتك في السباكة بخبرة وعناية، واستعادة نظامك بسرعة وفعالية.</p>', 'حلول-السباكة-المتنقلة', NULL, NULL, '2024-08-31 22:35:29', '2024-08-31 22:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `service_images`
--

CREATE TABLE `service_images` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_images`
--

INSERT INTO `service_images` (`id`, `service_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '66c5801d392ff.jpg', '2024-08-20 23:50:21', '2024-08-20 23:52:50'),
(2, 1, '66c5801ed6629.jpg', '2024-08-20 23:50:22', '2024-08-20 23:52:50'),
(3, 1, '66c5802094b34.jpg', '2024-08-20 23:50:24', '2024-08-20 23:52:50'),
(4, 1, '66c58022a6c2e.jpg', '2024-08-20 23:50:26', '2024-08-20 23:52:50'),
(5, 2, '66c58358a05c3.jpg', '2024-08-21 00:04:08', '2024-08-21 00:04:21'),
(6, 2, '66c5835aee10a.jpg', '2024-08-21 00:04:10', '2024-08-21 00:04:21'),
(7, 2, '66c5835d21272.jpg', '2024-08-21 00:04:13', '2024-08-21 00:04:21'),
(8, 2, '66c5835f8968f.jpg', '2024-08-21 00:04:15', '2024-08-21 00:04:21'),
(9, 3, '66c588f063736.jpg', '2024-08-21 00:28:00', '2024-08-21 00:30:09'),
(10, 3, '66c588f20468b.jpg', '2024-08-21 00:28:02', '2024-08-21 00:30:09'),
(11, 3, '66c588f3c836a.jpg', '2024-08-21 00:28:03', '2024-08-21 00:30:09'),
(12, 3, '66c588f5b9dbd.jpg', '2024-08-21 00:28:05', '2024-08-21 00:30:09'),
(13, 4, '66c58b3396456.jpg', '2024-08-21 00:37:39', '2024-08-21 00:37:51'),
(14, 4, '66c58b356870c.jpg', '2024-08-21 00:37:41', '2024-08-21 00:37:51'),
(15, 4, '66c58b3768667.jpg', '2024-08-21 00:37:43', '2024-08-21 00:37:51'),
(16, 4, '66c58b39bf192.jpg', '2024-08-21 00:37:45', '2024-08-21 00:37:51'),
(17, 5, '66c58c93bb06b.jpg', '2024-08-21 00:43:31', '2024-08-21 00:44:20'),
(18, 5, '66c58c9831f5a.jpg', '2024-08-21 00:43:36', '2024-08-21 00:44:20'),
(19, 5, '66c58c9ccdabe.jpg', '2024-08-21 00:43:40', '2024-08-21 00:44:20'),
(20, 5, '66c58ca3c22b6.jpg', '2024-08-21 00:43:47', '2024-08-21 00:44:20'),
(21, 6, '66c58f4187538.jpg', '2024-08-21 00:54:57', '2024-08-21 00:55:19'),
(22, 6, '66c58f466d78d.jpg', '2024-08-21 00:55:02', '2024-08-21 00:55:19'),
(24, 6, '66c6c87034453.jpg', '2024-08-21 23:11:12', '2024-08-21 23:11:15'),
(25, 7, '66c6cdd1a1fa7.jpg', '2024-08-21 23:34:09', '2024-08-21 23:41:27'),
(26, 7, '66c6cdd35880f.jpg', '2024-08-21 23:34:11', '2024-08-21 23:41:27'),
(27, 7, '66c6cdd5224d2.jpg', '2024-08-21 23:34:13', '2024-08-21 23:41:27'),
(28, 7, '66c6cdd71402c.jpg', '2024-08-21 23:34:15', '2024-08-21 23:41:27'),
(29, 8, '66c6d086e7419.jpg', '2024-08-21 23:45:42', '2024-08-21 23:47:40'),
(30, 8, '66c6d088d13ef.jpg', '2024-08-21 23:45:44', '2024-08-21 23:47:40'),
(31, 8, '66c6d08a6e037.jpg', '2024-08-21 23:45:46', '2024-08-21 23:47:40'),
(32, 8, '66c6d08c29470.jpg', '2024-08-21 23:45:48', '2024-08-21 23:47:40'),
(33, 9, '66c6d40ce4871.jpg', '2024-08-22 00:00:44', '2024-08-22 00:02:48'),
(34, 9, '66c6d41a0f1a4.jpg', '2024-08-22 00:00:58', '2024-08-22 00:02:48'),
(35, 9, '66c6d42600f52.jpg', '2024-08-22 00:01:10', '2024-08-22 00:02:48'),
(36, 9, '66c6d42ecc22c.jpg', '2024-08-22 00:01:18', '2024-08-22 00:02:48'),
(37, 12, '66c6d516c7b72.jpg', '2024-08-22 00:05:10', '2024-08-22 00:57:34'),
(38, 12, '66c6d518d4542.jpg', '2024-08-22 00:05:12', '2024-08-22 00:57:34'),
(39, 12, '66c6d51f97a6c.jpg', '2024-08-22 00:05:19', '2024-08-22 00:57:34'),
(40, 12, '66c6d5239a66c.jpg', '2024-08-22 00:05:23', '2024-08-22 00:57:34'),
(45, 11, '66c6e07f9a2e3.jpg', '2024-08-22 00:53:51', '2024-08-22 00:56:53'),
(46, 11, '66c6e0810cdc9.jpg', '2024-08-22 00:53:53', '2024-08-22 00:56:53'),
(47, 11, '66c6e082ae7a2.jpg', '2024-08-22 00:53:54', '2024-08-22 00:56:53'),
(48, 11, '66c6e0846f64d.jpg', '2024-08-22 00:53:56', '2024-08-22 00:56:53'),
(49, 13, '66c6e52fe553d.jpg', '2024-08-22 01:13:51', '2024-08-22 01:17:48'),
(50, 13, '66c6e5320e91a.jpg', '2024-08-22 01:13:54', '2024-08-22 01:17:48'),
(51, 13, '66c6e534438ab.jpg', '2024-08-22 01:13:56', '2024-08-22 01:17:48'),
(53, 13, '66c6e53b8f5e8.jpg', '2024-08-22 01:14:03', '2024-08-22 01:17:48'),
(54, 14, '66c6f83c16371.jpg', '2024-08-22 02:35:08', '2024-08-22 02:38:26'),
(55, 14, '66c6f83c16372.jpg', '2024-08-22 02:35:08', '2024-08-22 02:38:26'),
(56, 14, '66c6f83c64c79.jpg', '2024-08-22 02:35:08', '2024-08-22 02:38:26'),
(57, 14, '66c6f83c66d05.jpg', '2024-08-22 02:35:08', '2024-08-22 02:38:26'),
(59, 15, '66c6fc8a56a66.jpg', '2024-08-22 02:53:30', '2024-08-22 03:08:32'),
(60, 15, '66c6fc8a5e0a9.jpg', '2024-08-22 02:53:30', '2024-08-22 03:08:32'),
(61, 15, '66c6fc8f22bcf.jpg', '2024-08-22 02:53:35', '2024-08-22 03:08:32'),
(62, 16, '66c702c87b051.jpg', '2024-08-22 03:20:08', '2024-08-22 03:25:31'),
(63, 16, '66c702cabed9c.jpg', '2024-08-22 03:20:10', '2024-08-22 03:25:31'),
(64, 16, '66c702cca246e.jpg', '2024-08-22 03:20:12', '2024-08-22 03:25:31'),
(65, 16, '66c702ce57646.jpg', '2024-08-22 03:20:14', '2024-08-22 03:25:31'),
(66, NULL, '66c704c39ab9d.jpg', '2024-08-22 03:28:35', '2024-08-22 03:28:35'),
(69, 17, '66c704e7808f7.jpg', '2024-08-22 03:29:11', '2024-08-22 03:36:24'),
(70, 17, '66c704e9995d3.jpg', '2024-08-22 03:29:13', '2024-08-22 03:36:24'),
(71, 17, '66c704ebdbd31.jpg', '2024-08-22 03:29:15', '2024-08-22 03:36:24'),
(73, 17, '66c704f645541.jpg', '2024-08-22 03:29:26', '2024-08-22 03:36:24'),
(74, 18, '66c70c222753f.jpg', '2024-08-22 04:00:02', '2024-08-22 04:10:50'),
(75, 18, '66c70c24a2e0f.jpg', '2024-08-22 04:00:04', '2024-08-22 04:10:50'),
(76, 18, '66c70c2881d6b.jpg', '2024-08-22 04:00:08', '2024-08-22 04:10:50'),
(79, 18, '66c70c7710c81.jpg', '2024-08-22 04:01:27', '2024-08-22 04:10:50'),
(80, 19, '66c713bd83d9e.jpg', '2024-08-22 04:32:29', '2024-08-22 04:36:09'),
(81, 19, '66c713bee8506.jpg', '2024-08-22 04:32:30', '2024-08-22 04:36:09'),
(82, 19, '66c713c352045.jpg', '2024-08-22 04:32:35', '2024-08-22 04:36:09'),
(83, 19, '66c713c653bbe.jpg', '2024-08-22 04:32:38', '2024-08-22 04:36:09'),
(84, 20, '66c714c98122d.jpg', '2024-08-22 04:36:57', '2024-08-22 04:39:29'),
(85, 20, '66c714cb4d9a0.jpg', '2024-08-22 04:36:59', '2024-08-22 04:39:29'),
(86, 20, '66c714d2c9cb1.jpg', '2024-08-22 04:37:06', '2024-08-22 04:39:29'),
(87, 20, '66c714d97c2be.jpg', '2024-08-22 04:37:13', '2024-08-22 04:39:29'),
(88, 21, '66c7162e8da01.jpg', '2024-08-22 04:42:54', '2024-08-22 04:45:27'),
(89, 21, '66c716302a53f.jpg', '2024-08-22 04:42:56', '2024-08-22 04:45:27'),
(90, 21, '66c71631b06fa.jpg', '2024-08-22 04:42:57', '2024-08-22 04:45:27'),
(91, 21, '66c71637e22c8.jpg', '2024-08-22 04:43:03', '2024-08-22 04:45:27'),
(92, 22, '66c71746534ef.jpg', '2024-08-22 04:47:34', '2024-08-22 04:49:33'),
(93, 22, '66c717484eba2.jpg', '2024-08-22 04:47:36', '2024-08-22 04:49:33'),
(94, 22, '66c7174a490bc.jpg', '2024-08-22 04:47:38', '2024-08-22 04:49:33'),
(95, 22, '66c7174c1cb42.jpg', '2024-08-22 04:47:40', '2024-08-22 04:49:33'),
(96, 23, '66c719003f575.jpg', '2024-08-22 04:54:56', '2024-08-22 04:59:29'),
(97, 23, '66c71903d61f8.jpg', '2024-08-22 04:54:59', '2024-08-22 04:59:29'),
(98, 23, '66c7190a0a2d8.jpg', '2024-08-22 04:55:06', '2024-08-22 04:59:29'),
(99, 23, '66c719114e37f.jpg', '2024-08-22 04:55:13', '2024-08-22 04:59:29'),
(100, 24, '66c71d0757d5d.jpg', '2024-08-22 05:12:07', '2024-08-22 05:15:51'),
(101, 24, '66c71d086df05.jpg', '2024-08-22 05:12:08', '2024-08-22 05:15:51'),
(102, 24, '66c71d0a37eae.jpg', '2024-08-22 05:12:10', '2024-08-22 05:15:51'),
(103, 24, '66c71d0c0fedd.jpg', '2024-08-22 05:12:12', '2024-08-22 05:15:51'),
(104, 26, '66d2a30a31679.jpg', '2024-08-30 22:58:50', '2024-08-30 22:59:01'),
(105, 26, '66d2a30c00a14.jpg', '2024-08-30 22:58:52', '2024-08-30 22:59:01'),
(106, 26, '66d2a30dbeffb.jpg', '2024-08-30 22:58:53', '2024-08-30 22:59:01'),
(107, 26, '66d2a30f57d85.jpg', '2024-08-30 22:58:55', '2024-08-30 22:59:01'),
(108, 10, '66d2a4a808eaa.jpg', '2024-08-30 23:05:44', '2024-08-30 23:05:54'),
(109, 10, '66d2a4a9a2a00.jpg', '2024-08-30 23:05:45', '2024-08-30 23:05:54'),
(110, 10, '66d2a4ab45992.jpg', '2024-08-30 23:05:47', '2024-08-30 23:05:54'),
(111, 10, '66d2a4ad0cda2.jpg', '2024-08-30 23:05:49', '2024-08-30 23:05:54'),
(112, 27, '66d3ec037e89b.jpg', '2024-08-31 22:22:27', '2024-08-31 22:22:38'),
(113, 27, '66d3ec05aa1d9.jpg', '2024-08-31 22:22:29', '2024-08-31 22:22:38'),
(114, 27, '66d3ec0756cc2.jpg', '2024-08-31 22:22:31', '2024-08-31 22:22:38'),
(115, 27, '66d3ec09024ed.jpg', '2024-08-31 22:22:33', '2024-08-31 22:22:38'),
(116, 28, '66d3edc45af9a.jpg', '2024-08-31 22:29:56', '2024-08-31 22:35:29'),
(117, 28, '66d3edc6aacca.jpg', '2024-08-31 22:29:58', '2024-08-31 22:35:29'),
(118, 28, '66d3edd16eeca.jpg', '2024-08-31 22:30:09', '2024-08-31 22:35:29'),
(119, 28, '66d3edd542108.jpg', '2024-08-31 22:30:13', '2024-08-31 22:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `service_promotions`
--

CREATE TABLE `service_promotions` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint DEFAULT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `day` int DEFAULT NULL,
  `currency_text_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_promotions`
--

INSERT INTO `service_promotions` (`id`, `order_number`, `service_id`, `vendor_id`, `attachment`, `invoice`, `payment_method`, `gateway_type`, `payment_status`, `currency_text`, `amount`, `day`, `currency_text_position`, `currency_symbol`, `currency_symbol_position`, `order_status`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(316, '66c9a36c05e19', 4, 7, NULL, '66c9a36c05e19.pdf', 'PayPal', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:10:04', '2024-08-24 03:12:40'),
(317, '66c9a3c71cbb5', 16, 7, NULL, '66c9a3c71cbb5.pdf', 'Stripe', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:11:35', '2024-08-24 03:12:32'),
(318, '66c9a5119c7e7', 22, 5, NULL, '66c9a5119c7e7.pdf', 'Instamojo', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:17:05', '2024-08-24 03:17:05'),
(319, '66c9a559c6aee', 19, 0, NULL, NULL, 'Paystack', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:18:17', '2024-08-24 03:18:17'),
(320, '66c9a595ee3a3', 12, 5, NULL, '66c9a595ee3a3.pdf', 'PayPal', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:19:17', '2024-08-24 03:19:18'),
(322, '66c9a6a630d7d', 8, 3, NULL, '66c9a6a630d7d.pdf', 'PayPal', 'online', 'completed', 'USD', 1000.00, 900, 'right', '$', 'left', 'approved', '2024-08-24', '2027-02-10', '2024-08-24 03:23:50', '2024-08-24 03:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `service_reviews`
--

CREATE TABLE `service_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `service_id` bigint DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rating` smallint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_medias`
--

CREATE TABLE `social_medias` (
  `id` bigint UNSIGNED NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `serial_number` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `social_medias`
--

INSERT INTO `social_medias` (`id`, `icon`, `url`, `serial_number`, `created_at`, `updated_at`) VALUES
(36, 'fab fa-facebook-f', 'http://example.com/', 1, '2021-11-20 03:01:42', '2021-11-20 03:01:42'),
(37, 'fab fa-twitter', 'http://example.com/', 3, '2021-11-20 03:03:22', '2021-11-20 03:03:22'),
(38, 'fab fa-linkedin-in', 'http://example.com/', 2, '2021-11-20 03:04:29', '2021-11-20 03:04:29'),
(39, 'fab fa-github', 'http://example.com/', 4, '2023-11-16 03:17:07', '2023-11-16 03:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` int DEFAULT NULL,
  `allow_login` tinyint(1) DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_day` tinyint NOT NULL DEFAULT '0',
  `service_add` tinyint NOT NULL DEFAULT '0',
  `service_edit` tinyint NOT NULL DEFAULT '0',
  `service_delete` tinyint NOT NULL DEFAULT '0',
  `time` tinyint NOT NULL DEFAULT '0',
  `email_status` tinyint NOT NULL DEFAULT '0',
  `info_status` tinyint NOT NULL DEFAULT '0',
  `phone_status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `role`, `vendor_id`, `status`, `email`, `phone`, `image`, `order_number`, `allow_login`, `username`, `password`, `is_day`, `service_add`, `service_edit`, `service_delete`, `time`, `email_status`, `info_status`, `phone_status`, `created_at`, `updated_at`) VALUES
(1, 'vendor', 0, 1, NULL, NULL, NULL, 0, 0, 'admin', NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 00:03:26', '2024-08-20 00:03:26'),
(2, 'vendor', 1, 1, 'medica@example.com', NULL, NULL, 0, 1, 'medica', '$2y$10$HCFRRateqOG6jnyKy7cmb.o1U7eo3jEeqCf43okpkRiOZr6muxbHC', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(3, 'vendor', 2, 1, 'curewell@example.com', NULL, NULL, 0, 1, 'curewell', '$2y$10$vEDW2xJmPKAk7DD4SYSkbuY99UvRrejwlOnZWrFQmYepKVV.LvSp2', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(4, 'vendor', 3, 1, 'pipemasterpro@example.com', NULL, NULL, 0, 1, 'pipemasterpro', '$2y$10$Nx33lqKinfsWfglUVbKy5e23yBR9amLzPCpsxKgGNTKw6KoSL1xbq', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(5, 'vendor', 4, 1, 'flowfixplumb@example.com', NULL, NULL, 0, 1, 'flowfixplumb', '$2y$10$F0SePAdgEd5n3EEkOuWavOGT62DYHKvRqjL/rVQVKIEng0nWNtmi.', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(6, 'vendor', 5, 1, 'fitfusion@example.com', NULL, NULL, 0, 1, 'fitfusion', '$2y$10$UO72bnR7yrMXXyQK9ilN4O2zUXdTmcd4GnIeVhVA05.vkkJvq3IS2', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(7, 'vendor', 6, 1, 'muscleminds@example.com', NULL, NULL, 0, 1, 'muscleminds', '$2y$10$KiIKOUzpQEhrW0oD8MJsGOs1Eq7rjJvoM7emeMG9WeMOntRK4Z/Yq', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(8, 'vendor', 7, 1, 'stylesharp@example.com', NULL, NULL, 0, 1, 'stylesharp', '$2y$10$kSsSr/qnOq8OLGUfKDx.YeDHFZPn6udG9T6fhHq.Po1wRabWfN3fu', 0, 0, 0, 0, 0, 0, 0, 0, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(10, NULL, 1, 1, 'emmawilson@example.com', '+1-234-567-8901', '66c5995be4e57.jpg', 1, 1, 'emmawilson', '$2y$10$fa3BZowUFMJogJ7fZ2KWxO5mMUQRXZ1KVUbzewLuLJYc8/zm.T04S', 0, 0, 0, 0, 0, 1, 0, 0, '2024-08-21 01:38:04', '2024-08-21 01:39:35'),
(11, NULL, 7, 1, 'liamjohnson@example.com', '+1-234-567-8902', '66c59a3db2257.jpg', 1, 1, 'liamjohnson', '$2y$10$T34jQ2Xf3mci8LR8q2FlteosBv5VAhu4s2sx31J1TdI1B5TrueveK', 0, 1, 1, 1, 1, 1, 0, 0, '2024-08-21 01:41:49', '2024-09-01 05:51:47'),
(12, NULL, 7, 1, 'sophialee@example.com', '+1-234-567-8903', '66c59abe445b5.jpg', 2, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(13, NULL, 7, 1, 'alex.johnson@example.com', '+1 (555) 123-4567', '66cb1c2611f81.png', 3, 1, 'alexj', '$2y$10$bYUijNeRBPuTx/clwT1a7ObCvRS4V2u2M3n9AIvkiPY.UQ1hcaNF2', 0, 0, 0, 0, 0, 1, 1, 1, '2024-08-25 05:57:26', '2024-08-25 06:18:51'),
(14, NULL, 3, 1, 'emily@example.com', '+1 (555) 234-5678', '66cb1d172c5f7.png', 1, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-08-25 06:01:27', '2024-08-25 06:06:16'),
(15, NULL, 3, 1, 'michael@example.com', '+1 (555) 345-6789', '66cb1d8b794bf.png', 2, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-08-25 06:03:23', '2024-08-25 06:06:09'),
(16, NULL, 3, 1, 'laura@example.com', '+1 (555) 678-9012', '66cb1e06abbce.png', 3, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(17, NULL, 5, 1, 'martinez@example.com', '+1 (555) 567-8901', '66cb1eacc9506.png', 1, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-09-05 04:32:23', '2024-08-25 06:08:12'),
(18, NULL, 5, 1, 'michael@example.com', '+1 (555) 345-6789', '66cb1f0e79a58.png', 2, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-09-05 04:32:17', '2024-08-25 06:09:50'),
(19, NULL, 5, 1, 'anderson@example.com', '+1 (555) 234-5678', '66cb1f721a02f.png', 3, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 1, '2024-08-25 06:11:30', '2024-08-25 06:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `staff_contents`
--

CREATE TABLE `staff_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_contents`
--

INSERT INTO `staff_contents` (`id`, `staff_id`, `language_id`, `name`, `information`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'Leonard', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae blanditiis minus tempora quibusdam quas quo magni, repellat sit? Adipisci accusantium quasi autem tempora nemo aspernatur tenetur repellat numquam sed cupiditate.', 'House no 32, Road 3, sector 11, Uttara, Dhaka, Bangladesh', '2024-08-20 00:03:26', '2024-08-20 00:03:26'),
(2, 1, 21, 'Leonard', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae blanditiis minus tempora quibusdam quas quo magni, repellat sit? Adipisci accusantium quasi autem tempora nemo aspernatur tenetur repellat numquam sed cupiditate.', 'House no 32, Road 3, sector 11, Uttara, Dhaka, Bangladesh', '2024-08-20 00:03:26', '2024-08-20 00:03:26'),
(3, 2, 20, 'Medica Connect', 'Medica Connect offers general consultations, specialist visits, and emergency care. Known for its skilled doctors and modern facilities, they provide high-quality, personalized medical care.', NULL, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(4, 2, 21, 'ميديكا كونكت', 'يقدم مركز ميديكا كونكت استشارات عامة وزيارات متخصصة ورعاية طارئة. ويشتهر المركز بأطبائه المهرة ومرافقه الحديثة، كما يقدم رعاية طبية عالية الجودة ومخصصة.', NULL, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(5, 3, 20, 'CureWell Clinics', 'CureWell Clinics offer routine check-ups, specialized treatments, and emergency care with a focus on high-quality, patient-centered service in a modern setting.', NULL, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(6, 3, 21, 'عيادات كيورويل', 'تقدم عيادات كيورويلفحوصات روتينية وعلاجات متخصصة ورعاية طارئة مع التركيز على الخدمة عالية الجودة التي تركز على المريض في بيئة حديثة.', NULL, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(7, 4, 20, 'PipeMaster Pro', 'PipeMaster Pro offers expert plumbing services, including repairs and installations, with a focus on quality and promptness.', NULL, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(8, 4, 21, 'بايب ماستر برو', 'تقدم بايب ماستر برو خدمات السباكة المتخصصة، بما في ذلك الإصلاحات والتركيبات، مع التركيز على الجودة والسرعة.', NULL, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(9, 5, 20, 'FlowFix Plumbing', 'FlowFix Plumbing provides reliable plumbing services, from repairs to installations, with a commitment to efficient and high-quality solutions.', NULL, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(10, 5, 21, 'فلوفيكس للسباكة', 'توفر شركة فلوفيكس للسباكة خدمات سباكة موثوقة، من الإصلاحات إلى التركيبات، مع الالتزام بالحلول الفعالة وعالية الجودة.', NULL, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(11, 6, 20, 'FitFusion Gym', 'FitFusion Gym offers a range of fitness services, including personal training, group classes, and state-of-the-art equipment, focused on helping members achieve their fitness goals.', NULL, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(12, 6, 21, 'صالة فيت فيوجن الرياضية', 'يقدم نادي صالة فيت فيوجن الرياضية مجموعة من خدمات اللياقة البدنية، بما في ذلك التدريب الشخصي، والدروس الجماعية، والمعدات الحديثة، والتي تركز على مساعدة الأعضاء على تحقيق أهداف اللياقة البدنية الخاصة بهم.', NULL, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(13, 7, 20, 'MuscleMinds', 'MuscleMinds provides expert fitness training and personalized workout plans, along with modern equipment and group classes, dedicated to helping clients build strength and achieve their fitness goals.', NULL, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(14, 7, 21, 'العضلات العقول', 'يقدم العضلات العقولتدريبات اللياقة البدنية المتخصصة وخطط التمرين الشخصية، بالإضافة إلى المعدات الحديثة والدروس الجماعية، المخصصة لمساعدة العملاء على بناء القوة وتحقيق أهداف اللياقة البدنية الخاصة بهم.', NULL, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(15, 8, 20, 'Style Sharp', 'StyleSharp provides professional barbering services, including haircuts, grooming, and styling, with a focus on precision and personalized care for a sharp, polished look.', NULL, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(16, 8, 21, 'ستايل شارب', 'يقدم ستايل شاربخدمات الحلاقة الاحترافية، بما في ذلك قص الشعر والعناية به وتصفيفه، مع التركيز على الدقة والرعاية الشخصية للحصول على مظهر حاد ولامع.', NULL, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(19, 10, 20, 'Emma Wilson', NULL, NULL, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(20, 10, 21, 'إيما ويلسون', NULL, NULL, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(21, 11, 20, 'Liam Johnson', NULL, NULL, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(22, 11, 21, 'ليام جونسون', NULL, NULL, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(23, 12, 20, 'Sophia Lee', NULL, NULL, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(24, 12, 21, 'صوفيا لي', NULL, NULL, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(25, 13, 20, 'Alex Johnson', NULL, '123 Maple Street, Springfield, IL, 62704, USA', '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(26, 13, 21, 'اليكس جونسون', NULL, '123 شارع مابل، سبرينغفيلد، إلينوي، 62704، الولايات المتحدة الأمريكية', '2024-08-25 05:57:26', '2024-08-25 06:01:49'),
(27, 14, 20, 'Emily Davis', NULL, NULL, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(28, 14, 21, 'إميلي ديفيس', NULL, NULL, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(29, 15, 20, 'Michael Brown', NULL, NULL, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(30, 15, 21, 'مايكل براون', NULL, NULL, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(31, 16, 20, 'Laura Carter', NULL, NULL, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(32, 16, 21, 'لورا كارتر', NULL, NULL, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(33, 17, 20, 'Daniel Martinez', NULL, NULL, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(34, 17, 21, 'دانييل مارتينيز', NULL, NULL, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(35, 18, 20, 'Michael Brown', NULL, NULL, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(36, 18, 21, 'مايكل براون', NULL, NULL, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(37, 19, 20, 'James Anderson', NULL, NULL, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(38, 19, 21, 'جيمس أندرسون', NULL, NULL, '2024-08-25 06:11:30', '2024-08-25 06:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `staff_days`
--

CREATE TABLE `staff_days` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint NOT NULL,
  `vendor_id` bigint NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `indx` int NOT NULL,
  `is_weekend` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_days`
--

INSERT INTO `staff_days` (`id`, `staff_id`, `vendor_id`, `day`, `indx`, `is_weekend`, `created_at`, `updated_at`) VALUES
(1, 10, 1, 'Sunday', 0, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(2, 10, 1, 'Monday', 1, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(3, 10, 1, 'Tuesday', 2, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(4, 10, 1, 'Wednesday', 3, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(5, 10, 1, 'Thursday', 4, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(6, 10, 1, 'Friday', 5, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(7, 10, 1, 'Saturday', 6, 0, '2024-08-21 01:38:04', '2024-08-21 01:38:04'),
(8, 11, 7, 'Sunday', 0, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(9, 11, 7, 'Monday', 1, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(10, 11, 7, 'Tuesday', 2, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(11, 11, 7, 'Wednesday', 3, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(12, 11, 7, 'Thursday', 4, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(13, 11, 7, 'Friday', 5, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(14, 11, 7, 'Saturday', 6, 0, '2024-08-21 01:41:49', '2024-08-21 01:41:49'),
(15, 12, 7, 'Sunday', 0, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(16, 12, 7, 'Monday', 1, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(17, 12, 7, 'Tuesday', 2, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(18, 12, 7, 'Wednesday', 3, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(19, 12, 7, 'Thursday', 4, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(20, 12, 7, 'Friday', 5, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(21, 12, 7, 'Saturday', 6, 0, '2024-08-21 01:43:58', '2024-08-21 01:43:58'),
(22, 13, 7, 'Sunday', 0, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(23, 13, 7, 'Monday', 1, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(24, 13, 7, 'Tuesday', 2, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(25, 13, 7, 'Wednesday', 3, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(26, 13, 7, 'Thursday', 4, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(27, 13, 7, 'Friday', 5, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(28, 13, 7, 'Saturday', 6, 0, '2024-08-25 05:57:26', '2024-08-25 05:57:26'),
(29, 14, 3, 'Sunday', 0, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(30, 14, 3, 'Monday', 1, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(31, 14, 3, 'Tuesday', 2, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(32, 14, 3, 'Wednesday', 3, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(33, 14, 3, 'Thursday', 4, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(34, 14, 3, 'Friday', 5, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(35, 14, 3, 'Saturday', 6, 0, '2024-08-25 06:01:27', '2024-08-25 06:01:27'),
(36, 15, 3, 'Sunday', 0, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(37, 15, 3, 'Monday', 1, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(38, 15, 3, 'Tuesday', 2, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(39, 15, 3, 'Wednesday', 3, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(40, 15, 3, 'Thursday', 4, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(41, 15, 3, 'Friday', 5, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(42, 15, 3, 'Saturday', 6, 0, '2024-08-25 06:03:23', '2024-08-25 06:03:23'),
(43, 16, 3, 'Sunday', 0, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(44, 16, 3, 'Monday', 1, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(45, 16, 3, 'Tuesday', 2, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(46, 16, 3, 'Wednesday', 3, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(47, 16, 3, 'Thursday', 4, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(48, 16, 3, 'Friday', 5, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(49, 16, 3, 'Saturday', 6, 0, '2024-08-25 06:05:26', '2024-08-25 06:05:26'),
(50, 17, 5, 'Sunday', 0, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(51, 17, 5, 'Monday', 1, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(52, 17, 5, 'Tuesday', 2, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(53, 17, 5, 'Wednesday', 3, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(54, 17, 5, 'Thursday', 4, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(55, 17, 5, 'Friday', 5, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(56, 17, 5, 'Saturday', 6, 0, '2024-08-25 06:08:12', '2024-08-25 06:08:12'),
(57, 18, 5, 'Sunday', 0, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(58, 18, 5, 'Monday', 1, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(59, 18, 5, 'Tuesday', 2, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(60, 18, 5, 'Wednesday', 3, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(61, 18, 5, 'Thursday', 4, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(62, 18, 5, 'Friday', 5, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(63, 18, 5, 'Saturday', 6, 0, '2024-08-25 06:09:50', '2024-08-25 06:09:50'),
(64, 19, 5, 'Sunday', 0, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(65, 19, 5, 'Monday', 1, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(66, 19, 5, 'Tuesday', 2, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(67, 19, 5, 'Wednesday', 3, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(68, 19, 5, 'Thursday', 4, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(69, 19, 5, 'Friday', 5, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30'),
(70, 19, 5, 'Saturday', 6, 0, '2024-08-25 06:11:30', '2024-08-25 06:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `staff_global_days`
--

CREATE TABLE `staff_global_days` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_weekend` tinyint NOT NULL DEFAULT '0',
  `indx` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_global_days`
--

INSERT INTO `staff_global_days` (`id`, `vendor_id`, `day`, `is_weekend`, `indx`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sunday', 0, 0, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(2, 1, 'Monday', 0, 1, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(3, 1, 'Tuesday', 0, 2, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(4, 1, 'Wednesday', 0, 3, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(5, 1, 'Thursday', 0, 4, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(6, 1, 'Friday', 0, 5, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(7, 1, 'Saturday', 0, 6, '2024-08-20 03:16:37', '2024-08-20 03:16:37'),
(8, 2, 'Sunday', 0, 0, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(9, 2, 'Monday', 0, 1, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(10, 2, 'Tuesday', 0, 2, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(11, 2, 'Wednesday', 0, 3, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(12, 2, 'Thursday', 0, 4, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(13, 2, 'Friday', 0, 5, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(14, 2, 'Saturday', 0, 6, '2024-08-20 03:21:05', '2024-08-20 03:21:05'),
(15, 3, 'Sunday', 1, 0, '2024-08-20 03:24:14', '2024-08-26 22:30:35'),
(16, 3, 'Monday', 0, 1, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(17, 3, 'Tuesday', 0, 2, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(18, 3, 'Wednesday', 0, 3, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(19, 3, 'Thursday', 0, 4, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(20, 3, 'Friday', 0, 5, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(21, 3, 'Saturday', 0, 6, '2024-08-20 03:24:14', '2024-08-20 03:24:14'),
(22, 4, 'Sunday', 0, 0, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(23, 4, 'Monday', 0, 1, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(24, 4, 'Tuesday', 0, 2, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(25, 4, 'Wednesday', 0, 3, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(26, 4, 'Thursday', 0, 4, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(27, 4, 'Friday', 0, 5, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(28, 4, 'Saturday', 0, 6, '2024-08-20 03:26:49', '2024-08-20 03:26:49'),
(29, 5, 'Sunday', 1, 0, '2024-08-20 03:29:30', '2024-08-26 22:35:36'),
(30, 5, 'Monday', 0, 1, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(31, 5, 'Tuesday', 0, 2, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(32, 5, 'Wednesday', 0, 3, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(33, 5, 'Thursday', 0, 4, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(34, 5, 'Friday', 0, 5, '2024-08-20 03:29:30', '2024-08-20 03:29:30'),
(35, 5, 'Saturday', 1, 6, '2024-08-20 03:29:30', '2024-08-26 22:37:11'),
(36, 6, 'Sunday', 0, 0, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(37, 6, 'Monday', 0, 1, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(38, 6, 'Tuesday', 0, 2, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(39, 6, 'Wednesday', 0, 3, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(40, 6, 'Thursday', 0, 4, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(41, 6, 'Friday', 0, 5, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(42, 6, 'Saturday', 0, 6, '2024-08-20 03:31:39', '2024-08-20 03:31:39'),
(43, 7, 'Sunday', 1, 0, '2024-08-20 03:39:38', '2024-08-25 06:25:36'),
(44, 7, 'Monday', 0, 1, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(45, 7, 'Tuesday', 0, 2, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(46, 7, 'Wednesday', 0, 3, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(47, 7, 'Thursday', 0, 4, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(48, 7, 'Friday', 0, 5, '2024-08-20 03:39:38', '2024-08-20 03:39:38'),
(49, 7, 'Saturday', 1, 6, '2024-08-20 03:39:38', '2024-08-25 06:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `staff_global_holidays`
--

CREATE TABLE `staff_global_holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint NOT NULL,
  `date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_global_holidays`
--

INSERT INTO `staff_global_holidays` (`id`, `vendor_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 7, '2024-09-11', '2024-08-26 22:39:37', '2024-08-26 22:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `staff_global_hours`
--

CREATE TABLE `staff_global_hours` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` int NOT NULL,
  `global_day_id` int NOT NULL,
  `start_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_booking` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_global_hours`
--

INSERT INTO `staff_global_hours` (`id`, `vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(5, 0, 2, '01:00', '03:30', NULL, '2024-08-26 22:23:51', '2024-08-26 22:23:51'),
(6, 0, 2, '03:30', '05:00', 5, '2024-08-26 22:24:06', '2024-08-26 22:24:06'),
(7, 7, 44, '01:00', '03:00', NULL, '2024-08-26 22:25:05', '2024-08-26 22:25:05'),
(8, 7, 44, '03:00', '05:00', NULL, '2024-08-26 22:25:36', '2024-08-26 22:25:36'),
(9, 7, 44, '05:00', '07:00', 2, '2024-08-26 22:25:53', '2024-08-26 22:25:53'),
(10, 7, 44, '07:00', '09:00', NULL, '2024-08-26 22:26:33', '2024-08-26 22:26:33'),
(11, 7, 45, '01:00', '02:00', NULL, '2024-08-26 22:27:18', '2024-08-26 22:27:18'),
(12, 7, 45, '02:00', '03:00', NULL, '2024-08-26 22:27:25', '2024-08-26 22:27:25'),
(13, 7, 45, '03:00', '04:00', NULL, '2024-08-26 22:27:33', '2024-08-26 22:27:33'),
(14, 7, 45, '04:00', '05:00', 5, '2024-08-26 22:27:42', '2024-08-26 22:27:42'),
(15, 7, 46, '01:00', '03:00', NULL, '2024-08-26 22:28:30', '2024-08-26 22:28:30'),
(16, 7, 46, '03:00', '05:00', NULL, '2024-08-26 22:28:39', '2024-08-26 22:28:39'),
(17, 7, 46, '05:00', '07:00', NULL, '2024-08-26 22:28:48', '2024-08-26 22:28:48'),
(18, 7, 46, '07:00', '09:00', NULL, '2024-08-26 22:28:59', '2024-08-26 22:28:59'),
(19, 3, 16, '01:00', '01:30', NULL, '2024-08-26 22:30:50', '2024-08-26 22:30:50'),
(20, 3, 16, '01:30', '02:00', NULL, '2024-08-26 22:30:57', '2024-08-26 22:30:57'),
(21, 3, 16, '02:00', '02:30', NULL, '2024-08-26 22:31:03', '2024-08-26 22:31:03'),
(22, 3, 16, '02:30', '03:00', NULL, '2024-08-26 22:31:12', '2024-08-26 22:31:12'),
(23, 3, 17, '01:00', '02:00', NULL, '2024-08-26 22:31:54', '2024-08-26 22:31:54'),
(24, 3, 17, '02:00', '03:00', NULL, '2024-08-26 22:31:59', '2024-08-26 22:31:59'),
(25, 3, 17, '03:00', '04:00', NULL, '2024-08-26 22:32:10', '2024-08-26 22:32:10'),
(26, 3, 17, '04:00', '05:00', NULL, '2024-08-26 22:32:17', '2024-08-26 22:32:17'),
(27, 3, 18, '01:00', '03:00', NULL, '2024-08-26 22:32:28', '2024-08-26 22:32:28'),
(28, 3, 18, '03:30', '05:00', NULL, '2024-08-26 22:32:34', '2024-08-26 22:32:34'),
(29, 3, 18, '05:00', '07:00', NULL, '2024-08-26 22:32:41', '2024-08-26 22:32:41'),
(30, 3, 18, '07:00', '09:00', NULL, '2024-08-26 22:32:59', '2024-08-26 22:32:59'),
(31, 3, 20, '01:00', '01:30', NULL, '2024-08-26 22:33:10', '2024-08-26 22:33:10'),
(32, 3, 20, '01:30', '02:00', NULL, '2024-08-26 22:33:21', '2024-08-26 22:33:21'),
(33, 3, 20, '02:00', '02:30', NULL, '2024-08-26 22:33:29', '2024-08-26 22:33:29'),
(34, 3, 20, '02:30', '03:00', NULL, '2024-08-26 22:33:39', '2024-08-26 22:33:39'),
(35, 5, 30, '01:00', '02:00', NULL, '2024-08-26 22:35:46', '2024-08-26 22:35:46'),
(36, 5, 30, '02:00', '03:00', NULL, '2024-08-26 22:35:52', '2024-08-26 22:35:52'),
(37, 5, 30, '03:00', '04:00', NULL, '2024-08-26 22:35:57', '2024-08-26 22:35:57'),
(38, 5, 30, '04:00', '05:00', NULL, '2024-08-26 22:36:03', '2024-08-26 22:36:03'),
(39, 5, 31, '01:00', '03:00', NULL, '2024-08-26 22:36:16', '2024-08-26 22:36:16'),
(40, 5, 31, '03:00', '05:00', NULL, '2024-08-26 22:36:22', '2024-08-26 22:36:22'),
(41, 5, 31, '05:00', '07:00', NULL, '2024-08-26 22:36:28', '2024-08-26 22:36:28'),
(42, 5, 31, '07:00', '09:00', NULL, '2024-08-26 22:36:35', '2024-08-26 22:36:35'),
(43, 5, 32, '01:00', '01:30', NULL, '2024-08-26 22:36:46', '2024-08-26 22:36:46'),
(44, 5, 32, '01:30', '02:00', NULL, '2024-08-26 22:36:52', '2024-08-26 22:36:52'),
(45, 5, 32, '02:00', '02:30', NULL, '2024-08-26 22:36:59', '2024-08-26 22:36:59'),
(46, 5, 32, '02:30', '03:00', NULL, '2024-08-26 22:37:05', '2024-08-26 22:37:05'),
(47, 5, 34, '01:00', '05:00', NULL, '2024-08-26 22:37:25', '2024-08-26 22:37:25'),
(48, 5, 34, '05:00', '10:00', NULL, '2024-08-26 22:37:37', '2024-08-26 22:37:37'),
(49, 5, 34, '10:00', '15:00', NULL, '2024-08-26 22:37:49', '2024-08-26 22:37:49'),
(50, 5, 34, '15:00', '20:00', NULL, '2024-08-26 22:38:01', '2024-08-26 22:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `staff_holidays`
--

CREATE TABLE `staff_holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint NOT NULL,
  `vendor_id` bigint NOT NULL,
  `date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_plugins`
--

CREATE TABLE `staff_plugins` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint DEFAULT NULL,
  `google_calendar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calender_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_services`
--

CREATE TABLE `staff_services` (
  `id` int NOT NULL,
  `staff_id` bigint NOT NULL,
  `service_id` bigint NOT NULL,
  `vendor_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_services`
--

INSERT INTO `staff_services` (`id`, `staff_id`, `service_id`, `vendor_id`, `created_at`, `updated_at`) VALUES
(1, 10, 1, 1, '2024-08-21 01:39:05', '2024-08-21 01:39:05'),
(4, 12, 4, 7, '2024-08-21 01:44:07', '2024-08-21 01:44:07'),
(5, 12, 5, 7, '2024-08-21 01:44:12', '2024-08-21 01:44:12'),
(6, 12, 7, 7, '2024-08-25 05:52:57', '2024-08-25 05:52:57'),
(7, 12, 9, 7, '2024-08-25 05:53:02', '2024-08-25 05:53:02'),
(8, 12, 10, 7, '2024-08-25 05:53:09', '2024-08-25 05:53:09'),
(9, 12, 16, 7, '2024-08-25 05:53:13', '2024-08-25 05:53:13'),
(14, 13, 4, 7, '2024-08-25 05:57:34', '2024-08-25 05:57:34'),
(15, 13, 5, 7, '2024-08-25 05:57:37', '2024-08-25 05:57:37'),
(16, 13, 7, 7, '2024-08-25 05:57:40', '2024-08-25 05:57:40'),
(17, 13, 9, 7, '2024-08-25 05:57:45', '2024-08-25 05:57:45'),
(18, 13, 10, 7, '2024-08-25 05:57:49', '2024-08-25 05:57:49'),
(19, 13, 16, 7, '2024-08-25 05:57:56', '2024-08-25 05:57:56'),
(20, 14, 2, 3, '2024-08-25 06:03:32', '2024-08-25 06:03:32'),
(21, 14, 8, 3, '2024-08-25 06:03:35', '2024-08-25 06:03:35'),
(22, 15, 2, 3, '2024-08-25 06:03:43', '2024-08-25 06:03:43'),
(23, 15, 8, 3, '2024-08-25 06:03:46', '2024-08-25 06:03:46'),
(24, 16, 2, 3, '2024-08-25 06:05:33', '2024-08-25 06:05:33'),
(25, 16, 8, 3, '2024-08-25 06:05:36', '2024-08-25 06:05:36'),
(26, 17, 12, 5, '2024-08-25 06:08:18', '2024-08-25 06:08:18'),
(27, 17, 20, 5, '2024-08-25 06:08:22', '2024-08-25 06:08:22'),
(28, 17, 22, 5, '2024-08-25 06:08:25', '2024-08-25 06:08:25'),
(29, 18, 12, 5, '2024-08-25 06:09:57', '2024-08-25 06:09:57'),
(30, 18, 20, 5, '2024-08-25 06:10:00', '2024-08-25 06:10:00'),
(31, 18, 22, 5, '2024-08-25 06:10:03', '2024-08-25 06:10:03'),
(32, 19, 12, 5, '2024-08-25 06:11:35', '2024-08-25 06:11:35'),
(33, 19, 20, 5, '2024-08-25 06:11:38', '2024-08-25 06:11:38'),
(34, 19, 22, 5, '2024-08-25 06:11:42', '2024-08-25 06:11:42'),
(35, 11, 4, 7, '2024-08-25 06:23:56', '2024-08-25 06:23:56'),
(36, 11, 5, 7, '2024-08-25 06:24:16', '2024-08-25 06:24:16'),
(37, 11, 7, 7, '2024-08-25 06:24:24', '2024-08-25 06:24:24'),
(38, 11, 9, 7, '2024-08-25 06:24:31', '2024-08-25 06:24:31'),
(39, 11, 16, 7, '2024-08-25 06:24:38', '2024-08-25 06:24:38'),
(40, 11, 10, 7, '2024-08-25 06:24:45', '2024-08-25 06:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `staff_service_hours`
--

CREATE TABLE `staff_service_hours` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint NOT NULL,
  `staff_day_id` bigint NOT NULL,
  `start_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_booking` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` longtext,
  `attachment` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1-pending, 2-open, 3-closed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_message` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_statuses`
--

CREATE TABLE `support_ticket_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `support_ticket_statuses`
--

INSERT INTO `support_ticket_statuses` (`id`, `support_ticket_status`, `created_at`, `updated_at`) VALUES
(1, 'active', '2022-06-25 03:52:18', '2024-06-23 22:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `occupation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `rating` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `language_id`, `image`, `name`, `occupation`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(36, 20, '66c5b1c8bfbc1.jpg', 'Anna Müller', 'Lawyer', 'Booking an appointment through this platform was incredibly easy.\r\nThe variety of services available is impressive, and the booking process was seamless. Highly recommend it to anyone looking for reliable service.', '5', '2024-08-21 03:21:14', '2024-08-21 03:22:16'),
(37, 21, '66c5b1faed2a3.jpg', 'آنا مولر', 'محامي', 'كان حجز موعد عبر هذه المنصة سهلاً بشكل لا يصدق. إن تنوع الخدمات المتاحة مثير للإعجاب، وكانت عملية الحجز سلسة. أوصي بها بشدة لأي شخص يبحث عن خدمة موثوقة.', '5', '2024-08-21 03:23:06', '2024-08-21 03:23:06'),
(38, 20, '66c5b22394f73.jpg', 'Luca Rossi', 'Marketing Manager', 'I’ve used this service multiple times, and I’ve always had a positive experience. The service providers are professional and punctual. It’s my go-to platform for all my service needs.', '4', '2024-08-21 03:23:47', '2024-08-21 03:23:47'),
(39, 21, '66c5b24da469d.jpg', 'لوكا روسي', 'مدير التسويق', 'لقد استخدمت هذه الخدمة عدة مرات، وكانت تجربتي معها إيجابية دائمًا. مقدمو الخدمة محترفون ودقيقون. إنها المنصة التي ألجأ إليها لتلبية جميع احتياجاتي من الخدمات.', '4', '2024-08-21 03:24:29', '2024-08-21 03:24:29'),
(40, 20, '66c5b289284a9.jpg', 'Sophie Dubois', 'Teacher', 'The website’s interface is user-friendly, and finding the right service provider is a breeze. The service I received was excellent, and I appreciated the detailed descriptions and ratings for each provider.', '5', '2024-08-21 03:25:29', '2024-08-21 03:25:29'),
(41, 21, '66c5b2b04154e.jpg', 'صوفي دوبوا', 'مدرس', 'واجهة الموقع سهلة الاستخدام، كما أن العثور على مزود الخدمة المناسب أمر سهل للغاية. كانت الخدمة التي تلقيتها ممتازة، وأقدر الأوصاف التفصيلية والتقييمات لكل مزود خدمة.', '5', '2024-08-21 03:26:08', '2024-08-21 03:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `country_code` char(3) NOT NULL,
  `timezone` varchar(125) NOT NULL DEFAULT '',
  `gmt_offset` float(10,2) DEFAULT NULL,
  `dst_offset` float(10,2) DEFAULT NULL,
  `raw_offset` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`country_code`, `timezone`, `gmt_offset`, `dst_offset`, `raw_offset`) VALUES
('AD', 'Europe/Andorra', 1.00, 2.00, 1.00),
('AE', 'Asia/Dubai', 4.00, 4.00, 4.00),
('AF', 'Asia/Kabul', 4.50, 4.50, 4.50),
('AG', 'America/Antigua', -4.00, -4.00, -4.00),
('AI', 'America/Anguilla', -4.00, -4.00, -4.00),
('AL', 'Europe/Tirane', 1.00, 2.00, 1.00),
('AM', 'Asia/Yerevan', 4.00, 4.00, 4.00),
('AO', 'Africa/Luanda', 1.00, 1.00, 1.00),
('AQ', 'Antarctica/Casey', 8.00, 8.00, 8.00),
('AQ', 'Antarctica/Davis', 7.00, 7.00, 7.00),
('AQ', 'Antarctica/DumontDUrville', 10.00, 10.00, 10.00),
('AQ', 'Antarctica/Mawson', 5.00, 5.00, 5.00),
('AQ', 'Antarctica/McMurdo', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Palmer', -3.00, -4.00, -4.00),
('AQ', 'Antarctica/Rothera', -3.00, -3.00, -3.00),
('AQ', 'Antarctica/South_Pole', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Syowa', 3.00, 3.00, 3.00),
('AQ', 'Antarctica/Vostok', 6.00, 6.00, 6.00),
('AR', 'America/Argentina/Buenos_Aires', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Catamarca', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Cordoba', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Jujuy', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/La_Rioja', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Mendoza', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Rio_Gallegos', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Salta', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Juan', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Luis', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Tucuman', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Ushuaia', -3.00, -3.00, -3.00),
('AS', 'Pacific/Pago_Pago', -11.00, -11.00, -11.00),
('AT', 'Europe/Vienna', 1.00, 2.00, 1.00),
('AU', 'Antarctica/Macquarie', 11.00, 11.00, 11.00),
('AU', 'Australia/Adelaide', 10.50, 9.50, 9.50),
('AU', 'Australia/Brisbane', 10.00, 10.00, 10.00),
('AU', 'Australia/Broken_Hill', 10.50, 9.50, 9.50),
('AU', 'Australia/Currie', 11.00, 10.00, 10.00),
('AU', 'Australia/Darwin', 9.50, 9.50, 9.50),
('AU', 'Australia/Eucla', 8.75, 8.75, 8.75),
('AU', 'Australia/Hobart', 11.00, 10.00, 10.00),
('AU', 'Australia/Lindeman', 10.00, 10.00, 10.00),
('AU', 'Australia/Lord_Howe', 11.00, 10.50, 10.50),
('AU', 'Australia/Melbourne', 11.00, 10.00, 10.00),
('AU', 'Australia/Perth', 8.00, 8.00, 8.00),
('AU', 'Australia/Sydney', 11.00, 10.00, 10.00),
('AW', 'America/Aruba', -4.00, -4.00, -4.00),
('AX', 'Europe/Mariehamn', 2.00, 3.00, 2.00),
('AZ', 'Asia/Baku', 4.00, 5.00, 4.00),
('BA', 'Europe/Sarajevo', 1.00, 2.00, 1.00),
('BB', 'America/Barbados', -4.00, -4.00, -4.00),
('BD', 'Asia/Dhaka', 6.00, 6.00, 6.00),
('BE', 'Europe/Brussels', 1.00, 2.00, 1.00),
('BF', 'Africa/Ouagadougou', 0.00, 0.00, 0.00),
('BG', 'Europe/Sofia', 2.00, 3.00, 2.00),
('BH', 'Asia/Bahrain', 3.00, 3.00, 3.00),
('BI', 'Africa/Bujumbura', 2.00, 2.00, 2.00),
('BJ', 'Africa/Porto-Novo', 1.00, 1.00, 1.00),
('BL', 'America/St_Barthelemy', -4.00, -4.00, -4.00),
('BM', 'Atlantic/Bermuda', -4.00, -3.00, -4.00),
('BN', 'Asia/Brunei', 8.00, 8.00, 8.00),
('BO', 'America/La_Paz', -4.00, -4.00, -4.00),
('BQ', 'America/Kralendijk', -4.00, -4.00, -4.00),
('BR', 'America/Araguaina', -3.00, -3.00, -3.00),
('BR', 'America/Bahia', -3.00, -3.00, -3.00),
('BR', 'America/Belem', -3.00, -3.00, -3.00),
('BR', 'America/Boa_Vista', -4.00, -4.00, -4.00),
('BR', 'America/Campo_Grande', -3.00, -4.00, -4.00),
('BR', 'America/Cuiaba', -3.00, -4.00, -4.00),
('BR', 'America/Eirunepe', -5.00, -5.00, -5.00),
('BR', 'America/Fortaleza', -3.00, -3.00, -3.00),
('BR', 'America/Maceio', -3.00, -3.00, -3.00),
('BR', 'America/Manaus', -4.00, -4.00, -4.00),
('BR', 'America/Noronha', -2.00, -2.00, -2.00),
('BR', 'America/Porto_Velho', -4.00, -4.00, -4.00),
('BR', 'America/Recife', -3.00, -3.00, -3.00),
('BR', 'America/Rio_Branco', -5.00, -5.00, -5.00),
('BR', 'America/Santarem', -3.00, -3.00, -3.00),
('BR', 'America/Sao_Paulo', -2.00, -3.00, -3.00),
('BS', 'America/Nassau', -5.00, -4.00, -5.00),
('BT', 'Asia/Thimphu', 6.00, 6.00, 6.00),
('BW', 'Africa/Gaborone', 2.00, 2.00, 2.00),
('BY', 'Europe/Minsk', 3.00, 3.00, 3.00),
('BZ', 'America/Belize', -6.00, -6.00, -6.00),
('CA', 'America/Atikokan', -5.00, -5.00, -5.00),
('CA', 'America/Blanc-Sablon', -4.00, -4.00, -4.00),
('CA', 'America/Cambridge_Bay', -7.00, -6.00, -7.00),
('CA', 'America/Creston', -7.00, -7.00, -7.00),
('CA', 'America/Dawson', -8.00, -7.00, -8.00),
('CA', 'America/Dawson_Creek', -7.00, -7.00, -7.00),
('CA', 'America/Edmonton', -7.00, -6.00, -7.00),
('CA', 'America/Glace_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Goose_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Halifax', -4.00, -3.00, -4.00),
('CA', 'America/Inuvik', -7.00, -6.00, -7.00),
('CA', 'America/Iqaluit', -5.00, -4.00, -5.00),
('CA', 'America/Moncton', -4.00, -3.00, -4.00),
('CA', 'America/Montreal', -5.00, -4.00, -5.00),
('CA', 'America/Nipigon', -5.00, -4.00, -5.00),
('CA', 'America/Pangnirtung', -5.00, -4.00, -5.00),
('CA', 'America/Rainy_River', -6.00, -5.00, -6.00),
('CA', 'America/Rankin_Inlet', -6.00, -5.00, -6.00),
('CA', 'America/Regina', -6.00, -6.00, -6.00),
('CA', 'America/Resolute', -6.00, -5.00, -6.00),
('CA', 'America/St_Johns', -3.50, -2.50, -3.50),
('CA', 'America/Swift_Current', -6.00, -6.00, -6.00),
('CA', 'America/Thunder_Bay', -5.00, -4.00, -5.00),
('CA', 'America/Toronto', -5.00, -4.00, -5.00),
('CA', 'America/Vancouver', -8.00, -7.00, -8.00),
('CA', 'America/Whitehorse', -8.00, -7.00, -8.00),
('CA', 'America/Winnipeg', -6.00, -5.00, -6.00),
('CA', 'America/Yellowknife', -7.00, -6.00, -7.00),
('CC', 'Indian/Cocos', 6.50, 6.50, 6.50),
('CD', 'Africa/Kinshasa', 1.00, 1.00, 1.00),
('CD', 'Africa/Lubumbashi', 2.00, 2.00, 2.00),
('CF', 'Africa/Bangui', 1.00, 1.00, 1.00),
('CG', 'Africa/Brazzaville', 1.00, 1.00, 1.00),
('CH', 'Europe/Zurich', 1.00, 2.00, 1.00),
('CI', 'Africa/Abidjan', 0.00, 0.00, 0.00),
('CK', 'Pacific/Rarotonga', -10.00, -10.00, -10.00),
('CL', 'America/Santiago', -3.00, -4.00, -4.00),
('CL', 'Pacific/Easter', -5.00, -6.00, -6.00),
('CM', 'Africa/Douala', 1.00, 1.00, 1.00),
('CN', 'Asia/Chongqing', 8.00, 8.00, 8.00),
('CN', 'Asia/Harbin', 8.00, 8.00, 8.00),
('CN', 'Asia/Kashgar', 8.00, 8.00, 8.00),
('CN', 'Asia/Shanghai', 8.00, 8.00, 8.00),
('CN', 'Asia/Urumqi', 8.00, 8.00, 8.00),
('CO', 'America/Bogota', -5.00, -5.00, -5.00),
('CR', 'America/Costa_Rica', -6.00, -6.00, -6.00),
('CU', 'America/Havana', -5.00, -4.00, -5.00),
('CV', 'Atlantic/Cape_Verde', -1.00, -1.00, -1.00),
('CW', 'America/Curacao', -4.00, -4.00, -4.00),
('CX', 'Indian/Christmas', 7.00, 7.00, 7.00),
('CY', 'Asia/Nicosia', 2.00, 3.00, 2.00),
('CZ', 'Europe/Prague', 1.00, 2.00, 1.00),
('DE', 'Europe/Berlin', 1.00, 2.00, 1.00),
('DE', 'Europe/Busingen', 1.00, 2.00, 1.00),
('DJ', 'Africa/Djibouti', 3.00, 3.00, 3.00),
('DK', 'Europe/Copenhagen', 1.00, 2.00, 1.00),
('DM', 'America/Dominica', -4.00, -4.00, -4.00),
('DO', 'America/Santo_Domingo', -4.00, -4.00, -4.00),
('DZ', 'Africa/Algiers', 1.00, 1.00, 1.00),
('EC', 'America/Guayaquil', -5.00, -5.00, -5.00),
('EC', 'Pacific/Galapagos', -6.00, -6.00, -6.00),
('EE', 'Europe/Tallinn', 2.00, 3.00, 2.00),
('EG', 'Africa/Cairo', 2.00, 2.00, 2.00),
('EH', 'Africa/El_Aaiun', 0.00, 0.00, 0.00),
('ER', 'Africa/Asmara', 3.00, 3.00, 3.00),
('ES', 'Africa/Ceuta', 1.00, 2.00, 1.00),
('ES', 'Atlantic/Canary', 0.00, 1.00, 0.00),
('ES', 'Europe/Madrid', 1.00, 2.00, 1.00),
('ET', 'Africa/Addis_Ababa', 3.00, 3.00, 3.00),
('FI', 'Europe/Helsinki', 2.00, 3.00, 2.00),
('FJ', 'Pacific/Fiji', 13.00, 12.00, 12.00),
('FK', 'Atlantic/Stanley', -3.00, -3.00, -3.00),
('FM', 'Pacific/Chuuk', 10.00, 10.00, 10.00),
('FM', 'Pacific/Kosrae', 11.00, 11.00, 11.00),
('FM', 'Pacific/Pohnpei', 11.00, 11.00, 11.00),
('FO', 'Atlantic/Faroe', 0.00, 1.00, 0.00),
('FR', 'Europe/Paris', 1.00, 2.00, 1.00),
('GA', 'Africa/Libreville', 1.00, 1.00, 1.00),
('GB', 'Europe/London', 0.00, 1.00, 0.00),
('GD', 'America/Grenada', -4.00, -4.00, -4.00),
('GE', 'Asia/Tbilisi', 4.00, 4.00, 4.00),
('GF', 'America/Cayenne', -3.00, -3.00, -3.00),
('GG', 'Europe/Guernsey', 0.00, 1.00, 0.00),
('GH', 'Africa/Accra', 0.00, 0.00, 0.00),
('GI', 'Europe/Gibraltar', 1.00, 2.00, 1.00),
('GL', 'America/Danmarkshavn', 0.00, 0.00, 0.00),
('GL', 'America/Godthab', -3.00, -2.00, -3.00),
('GL', 'America/Scoresbysund', -1.00, 0.00, -1.00),
('GL', 'America/Thule', -4.00, -3.00, -4.00),
('GM', 'Africa/Banjul', 0.00, 0.00, 0.00),
('GN', 'Africa/Conakry', 0.00, 0.00, 0.00),
('GP', 'America/Guadeloupe', -4.00, -4.00, -4.00),
('GQ', 'Africa/Malabo', 1.00, 1.00, 1.00),
('GR', 'Europe/Athens', 2.00, 3.00, 2.00),
('GS', 'Atlantic/South_Georgia', -2.00, -2.00, -2.00),
('GT', 'America/Guatemala', -6.00, -6.00, -6.00),
('GU', 'Pacific/Guam', 10.00, 10.00, 10.00),
('GW', 'Africa/Bissau', 0.00, 0.00, 0.00),
('GY', 'America/Guyana', -4.00, -4.00, -4.00),
('HK', 'Asia/Hong_Kong', 8.00, 8.00, 8.00),
('HN', 'America/Tegucigalpa', -6.00, -6.00, -6.00),
('HR', 'Europe/Zagreb', 1.00, 2.00, 1.00),
('HT', 'America/Port-au-Prince', -5.00, -4.00, -5.00),
('HU', 'Europe/Budapest', 1.00, 2.00, 1.00),
('ID', 'Asia/Jakarta', 7.00, 7.00, 7.00),
('ID', 'Asia/Jayapura', 9.00, 9.00, 9.00),
('ID', 'Asia/Makassar', 8.00, 8.00, 8.00),
('ID', 'Asia/Pontianak', 7.00, 7.00, 7.00),
('IE', 'Europe/Dublin', 0.00, 1.00, 0.00),
('IL', 'Asia/Jerusalem', 2.00, 3.00, 2.00),
('IM', 'Europe/Isle_of_Man', 0.00, 1.00, 0.00),
('IN', 'Asia/Kolkata', 5.50, 5.50, 5.50),
('IO', 'Indian/Chagos', 6.00, 6.00, 6.00),
('IQ', 'Asia/Baghdad', 3.00, 3.00, 3.00),
('IR', 'Asia/Tehran', 3.50, 4.50, 3.50),
('IS', 'Atlantic/Reykjavik', 0.00, 0.00, 0.00),
('IT', 'Europe/Rome', 1.00, 2.00, 1.00),
('JE', 'Europe/Jersey', 0.00, 1.00, 0.00),
('JM', 'America/Jamaica', -5.00, -5.00, -5.00),
('JO', 'Asia/Amman', 2.00, 3.00, 2.00),
('JP', 'Asia/Tokyo', 9.00, 9.00, 9.00),
('KE', 'Africa/Nairobi', 3.00, 3.00, 3.00),
('KG', 'Asia/Bishkek', 6.00, 6.00, 6.00),
('KH', 'Asia/Phnom_Penh', 7.00, 7.00, 7.00),
('KI', 'Pacific/Enderbury', 13.00, 13.00, 13.00),
('KI', 'Pacific/Kiritimati', 14.00, 14.00, 14.00),
('KI', 'Pacific/Tarawa', 12.00, 12.00, 12.00),
('KM', 'Indian/Comoro', 3.00, 3.00, 3.00),
('KN', 'America/St_Kitts', -4.00, -4.00, -4.00),
('KP', 'Asia/Pyongyang', 9.00, 9.00, 9.00),
('KR', 'Asia/Seoul', 9.00, 9.00, 9.00),
('KW', 'Asia/Kuwait', 3.00, 3.00, 3.00),
('KY', 'America/Cayman', -5.00, -5.00, -5.00),
('KZ', 'Asia/Almaty', 6.00, 6.00, 6.00),
('KZ', 'Asia/Aqtau', 5.00, 5.00, 5.00),
('KZ', 'Asia/Aqtobe', 5.00, 5.00, 5.00),
('KZ', 'Asia/Oral', 5.00, 5.00, 5.00),
('KZ', 'Asia/Qyzylorda', 6.00, 6.00, 6.00),
('LA', 'Asia/Vientiane', 7.00, 7.00, 7.00),
('LB', 'Asia/Beirut', 2.00, 3.00, 2.00),
('LC', 'America/St_Lucia', -4.00, -4.00, -4.00),
('LI', 'Europe/Vaduz', 1.00, 2.00, 1.00),
('LK', 'Asia/Colombo', 5.50, 5.50, 5.50),
('LR', 'Africa/Monrovia', 0.00, 0.00, 0.00),
('LS', 'Africa/Maseru', 2.00, 2.00, 2.00),
('LT', 'Europe/Vilnius', 2.00, 3.00, 2.00),
('LU', 'Europe/Luxembourg', 1.00, 2.00, 1.00),
('LV', 'Europe/Riga', 2.00, 3.00, 2.00),
('LY', 'Africa/Tripoli', 2.00, 2.00, 2.00),
('MA', 'Africa/Casablanca', 0.00, 0.00, 0.00),
('MC', 'Europe/Monaco', 1.00, 2.00, 1.00),
('MD', 'Europe/Chisinau', 2.00, 3.00, 2.00),
('ME', 'Europe/Podgorica', 1.00, 2.00, 1.00),
('MF', 'America/Marigot', -4.00, -4.00, -4.00),
('MG', 'Indian/Antananarivo', 3.00, 3.00, 3.00),
('MH', 'Pacific/Kwajalein', 12.00, 12.00, 12.00),
('MH', 'Pacific/Majuro', 12.00, 12.00, 12.00),
('MK', 'Europe/Skopje', 1.00, 2.00, 1.00),
('ML', 'Africa/Bamako', 0.00, 0.00, 0.00),
('MM', 'Asia/Rangoon', 6.50, 6.50, 6.50),
('MN', 'Asia/Choibalsan', 8.00, 8.00, 8.00),
('MN', 'Asia/Hovd', 7.00, 7.00, 7.00),
('MN', 'Asia/Ulaanbaatar', 8.00, 8.00, 8.00),
('MO', 'Asia/Macau', 8.00, 8.00, 8.00),
('MP', 'Pacific/Saipan', 10.00, 10.00, 10.00),
('MQ', 'America/Martinique', -4.00, -4.00, -4.00),
('MR', 'Africa/Nouakchott', 0.00, 0.00, 0.00),
('MS', 'America/Montserrat', -4.00, -4.00, -4.00),
('MT', 'Europe/Malta', 1.00, 2.00, 1.00),
('MU', 'Indian/Mauritius', 4.00, 4.00, 4.00),
('MV', 'Indian/Maldives', 5.00, 5.00, 5.00),
('MW', 'Africa/Blantyre', 2.00, 2.00, 2.00),
('MX', 'America/Bahia_Banderas', -6.00, -5.00, -6.00),
('MX', 'America/Cancun', -6.00, -5.00, -6.00),
('MX', 'America/Chihuahua', -7.00, -6.00, -7.00),
('MX', 'America/Hermosillo', -7.00, -7.00, -7.00),
('MX', 'America/Matamoros', -6.00, -5.00, -6.00),
('MX', 'America/Mazatlan', -7.00, -6.00, -7.00),
('MX', 'America/Merida', -6.00, -5.00, -6.00),
('MX', 'America/Mexico_City', -6.00, -5.00, -6.00),
('MX', 'America/Monterrey', -6.00, -5.00, -6.00),
('MX', 'America/Ojinaga', -7.00, -6.00, -7.00),
('MX', 'America/Santa_Isabel', -8.00, -7.00, -8.00),
('MX', 'America/Tijuana', -8.00, -7.00, -8.00),
('MY', 'Asia/Kuala_Lumpur', 8.00, 8.00, 8.00),
('MY', 'Asia/Kuching', 8.00, 8.00, 8.00),
('MZ', 'Africa/Maputo', 2.00, 2.00, 2.00),
('NA', 'Africa/Windhoek', 2.00, 1.00, 1.00),
('NC', 'Pacific/Noumea', 11.00, 11.00, 11.00),
('NE', 'Africa/Niamey', 1.00, 1.00, 1.00),
('NF', 'Pacific/Norfolk', 11.50, 11.50, 11.50),
('NG', 'Africa/Lagos', 1.00, 1.00, 1.00),
('NI', 'America/Managua', -6.00, -6.00, -6.00),
('NL', 'Europe/Amsterdam', 1.00, 2.00, 1.00),
('NO', 'Europe/Oslo', 1.00, 2.00, 1.00),
('NP', 'Asia/Kathmandu', 5.75, 5.75, 5.75),
('NR', 'Pacific/Nauru', 12.00, 12.00, 12.00),
('NU', 'Pacific/Niue', -11.00, -11.00, -11.00),
('NZ', 'Pacific/Auckland', 13.00, 12.00, 12.00),
('NZ', 'Pacific/Chatham', 13.75, 12.75, 12.75),
('OM', 'Asia/Muscat', 4.00, 4.00, 4.00),
('PA', 'America/Panama', -5.00, -5.00, -5.00),
('PE', 'America/Lima', -5.00, -5.00, -5.00),
('PF', 'Pacific/Gambier', -9.00, -9.00, -9.00),
('PF', 'Pacific/Marquesas', -9.50, -9.50, -9.50),
('PF', 'Pacific/Tahiti', -10.00, -10.00, -10.00),
('PG', 'Pacific/Port_Moresby', 10.00, 10.00, 10.00),
('PH', 'Asia/Manila', 8.00, 8.00, 8.00),
('PK', 'Asia/Karachi', 5.00, 5.00, 5.00),
('PL', 'Europe/Warsaw', 1.00, 2.00, 1.00),
('PM', 'America/Miquelon', -3.00, -2.00, -3.00),
('PN', 'Pacific/Pitcairn', -8.00, -8.00, -8.00),
('PR', 'America/Puerto_Rico', -4.00, -4.00, -4.00),
('PS', 'Asia/Gaza', 2.00, 3.00, 2.00),
('PS', 'Asia/Hebron', 2.00, 3.00, 2.00),
('PT', 'Atlantic/Azores', -1.00, 0.00, -1.00),
('PT', 'Atlantic/Madeira', 0.00, 1.00, 0.00),
('PT', 'Europe/Lisbon', 0.00, 1.00, 0.00),
('PW', 'Pacific/Palau', 9.00, 9.00, 9.00),
('PY', 'America/Asuncion', -3.00, -4.00, -4.00),
('QA', 'Asia/Qatar', 3.00, 3.00, 3.00),
('RE', 'Indian/Reunion', 4.00, 4.00, 4.00),
('RO', 'Europe/Bucharest', 2.00, 3.00, 2.00),
('RS', 'Europe/Belgrade', 1.00, 2.00, 1.00),
('RU', 'Asia/Anadyr', 12.00, 12.00, 12.00),
('RU', 'Asia/Irkutsk', 9.00, 9.00, 9.00),
('RU', 'Asia/Kamchatka', 12.00, 12.00, 12.00),
('RU', 'Asia/Khandyga', 10.00, 10.00, 10.00),
('RU', 'Asia/Krasnoyarsk', 8.00, 8.00, 8.00),
('RU', 'Asia/Magadan', 12.00, 12.00, 12.00),
('RU', 'Asia/Novokuznetsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Novosibirsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Omsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Sakhalin', 11.00, 11.00, 11.00),
('RU', 'Asia/Ust-Nera', 11.00, 11.00, 11.00),
('RU', 'Asia/Vladivostok', 11.00, 11.00, 11.00),
('RU', 'Asia/Yakutsk', 10.00, 10.00, 10.00),
('RU', 'Asia/Yekaterinburg', 6.00, 6.00, 6.00),
('RU', 'Europe/Kaliningrad', 3.00, 3.00, 3.00),
('RU', 'Europe/Moscow', 4.00, 4.00, 4.00),
('RU', 'Europe/Samara', 4.00, 4.00, 4.00),
('RU', 'Europe/Volgograd', 4.00, 4.00, 4.00),
('RW', 'Africa/Kigali', 2.00, 2.00, 2.00),
('SA', 'Asia/Riyadh', 3.00, 3.00, 3.00),
('SB', 'Pacific/Guadalcanal', 11.00, 11.00, 11.00),
('SC', 'Indian/Mahe', 4.00, 4.00, 4.00),
('SD', 'Africa/Khartoum', 3.00, 3.00, 3.00),
('SE', 'Europe/Stockholm', 1.00, 2.00, 1.00),
('SG', 'Asia/Singapore', 8.00, 8.00, 8.00),
('SH', 'Atlantic/St_Helena', 0.00, 0.00, 0.00),
('SI', 'Europe/Ljubljana', 1.00, 2.00, 1.00),
('SJ', 'Arctic/Longyearbyen', 1.00, 2.00, 1.00),
('SK', 'Europe/Bratislava', 1.00, 2.00, 1.00),
('SL', 'Africa/Freetown', 0.00, 0.00, 0.00),
('SM', 'Europe/San_Marino', 1.00, 2.00, 1.00),
('SN', 'Africa/Dakar', 0.00, 0.00, 0.00),
('SO', 'Africa/Mogadishu', 3.00, 3.00, 3.00),
('SR', 'America/Paramaribo', -3.00, -3.00, -3.00),
('SS', 'Africa/Juba', 3.00, 3.00, 3.00),
('ST', 'Africa/Sao_Tome', 0.00, 0.00, 0.00),
('SV', 'America/El_Salvador', -6.00, -6.00, -6.00),
('SX', 'America/Lower_Princes', -4.00, -4.00, -4.00),
('SY', 'Asia/Damascus', 2.00, 3.00, 2.00),
('SZ', 'Africa/Mbabane', 2.00, 2.00, 2.00),
('TC', 'America/Grand_Turk', -5.00, -4.00, -5.00),
('TD', 'Africa/Ndjamena', 1.00, 1.00, 1.00),
('TF', 'Indian/Kerguelen', 5.00, 5.00, 5.00),
('TG', 'Africa/Lome', 0.00, 0.00, 0.00),
('TH', 'Asia/Bangkok', 7.00, 7.00, 7.00),
('TJ', 'Asia/Dushanbe', 5.00, 5.00, 5.00),
('TK', 'Pacific/Fakaofo', 13.00, 13.00, 13.00),
('TL', 'Asia/Dili', 9.00, 9.00, 9.00),
('TM', 'Asia/Ashgabat', 5.00, 5.00, 5.00),
('TN', 'Africa/Tunis', 1.00, 1.00, 1.00),
('TO', 'Pacific/Tongatapu', 13.00, 13.00, 13.00),
('TR', 'Europe/Istanbul', 2.00, 3.00, 2.00),
('TT', 'America/Port_of_Spain', -4.00, -4.00, -4.00),
('TV', 'Pacific/Funafuti', 12.00, 12.00, 12.00),
('TW', 'Asia/Taipei', 8.00, 8.00, 8.00),
('TZ', 'Africa/Dar_es_Salaam', 3.00, 3.00, 3.00),
('UA', 'Europe/Kiev', 2.00, 3.00, 2.00),
('UA', 'Europe/Simferopol', 2.00, 4.00, 4.00),
('UA', 'Europe/Uzhgorod', 2.00, 3.00, 2.00),
('UA', 'Europe/Zaporozhye', 2.00, 3.00, 2.00),
('UG', 'Africa/Kampala', 3.00, 3.00, 3.00),
('UM', 'Pacific/Johnston', -10.00, -10.00, -10.00),
('UM', 'Pacific/Midway', -11.00, -11.00, -11.00),
('UM', 'Pacific/Wake', 12.00, 12.00, 12.00),
('US', 'America/Adak', -10.00, -9.00, -10.00),
('US', 'America/Anchorage', -9.00, -8.00, -9.00),
('US', 'America/Boise', -7.00, -6.00, -7.00),
('US', 'America/Chicago', -6.00, -5.00, -6.00),
('US', 'America/Denver', -7.00, -6.00, -7.00),
('US', 'America/Detroit', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Indianapolis', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Knox', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Marengo', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Petersburg', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Tell_City', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Vevay', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Vincennes', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Winamac', -5.00, -4.00, -5.00),
('US', 'America/Juneau', -9.00, -8.00, -9.00),
('US', 'America/Kentucky/Louisville', -5.00, -4.00, -5.00),
('US', 'America/Kentucky/Monticello', -5.00, -4.00, -5.00),
('US', 'America/Los_Angeles', -8.00, -7.00, -8.00),
('US', 'America/Menominee', -6.00, -5.00, -6.00),
('US', 'America/Metlakatla', -8.00, -8.00, -8.00),
('US', 'America/New_York', -5.00, -4.00, -5.00),
('US', 'America/Nome', -9.00, -8.00, -9.00),
('US', 'America/North_Dakota/Beulah', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/Center', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/New_Salem', -6.00, -5.00, -6.00),
('US', 'America/Phoenix', -7.00, -7.00, -7.00),
('US', 'America/Shiprock', -7.00, -6.00, -7.00),
('US', 'America/Sitka', -9.00, -8.00, -9.00),
('US', 'America/Yakutat', -9.00, -8.00, -9.00),
('US', 'Pacific/Honolulu', -10.00, -10.00, -10.00),
('UY', 'America/Montevideo', -2.00, -3.00, -3.00),
('UZ', 'Asia/Samarkand', 5.00, 5.00, 5.00),
('UZ', 'Asia/Tashkent', 5.00, 5.00, 5.00),
('VA', 'Europe/Vatican', 1.00, 2.00, 1.00),
('VC', 'America/St_Vincent', -4.00, -4.00, -4.00),
('VE', 'America/Caracas', -4.50, -4.50, -4.50),
('VG', 'America/Tortola', -4.00, -4.00, -4.00),
('VI', 'America/St_Thomas', -4.00, -4.00, -4.00),
('VN', 'Asia/Ho_Chi_Minh', 7.00, 7.00, 7.00),
('VU', 'Pacific/Efate', 11.00, 11.00, 11.00),
('WF', 'Pacific/Wallis', 12.00, 12.00, 12.00),
('WS', 'Pacific/Apia', 14.00, 13.00, 13.00),
('YE', 'Asia/Aden', 3.00, 3.00, 3.00),
('YT', 'Indian/Mayotte', 3.00, 3.00, 3.00),
('ZA', 'Africa/Johannesburg', 2.00, 2.00, 2.00),
('ZM', 'Africa/Lusaka', 2.00, 2.00, 2.00),
('ZW', 'Africa/Harare', 2.00, 2.00, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withdraw_id` bigint DEFAULT NULL,
  `transaction_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_balance` decimal(10,2) DEFAULT NULL,
  `actual_total` decimal(10,2) DEFAULT NULL,
  `after_balance` decimal(10,2) DEFAULT NULL,
  `admin_profit` decimal(10,2) DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT '0.00',
  `featured_refund` decimal(8,2) DEFAULT '0.00',
  `currency_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 -> banned or deactive, 1 -> active',
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `provider` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint UNSIGNED NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `recived_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `featured` tinyint NOT NULL DEFAULT '0',
  `amount` double(8,2) DEFAULT '0.00',
  `total_appointment` int DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avg_rating` float(8,2) NOT NULL DEFAULT '0.00',
  `show_email_addresss` tinyint NOT NULL DEFAULT '1',
  `show_phone_number` tinyint NOT NULL DEFAULT '1',
  `show_contact_form` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `photo`, `email`, `recived_email`, `phone`, `username`, `password`, `status`, `featured`, `amount`, `total_appointment`, `email_verified_at`, `avg_rating`, `show_email_addresss`, `show_phone_number`, `show_contact_form`, `created_at`, `updated_at`) VALUES
(1, '66d2f90f36c9d.png', 'alexgreen@example.com', 'medica@example.com', '+1-555-123-4567', 'alexgreen', '$2y$10$1NgwyWoZETKJkJR1.PkHqucHDyixMmZ9KtciS5ZmasUCEezjC4Kmm', 1, 1, 0.00, 10, '2024-08-20 03:16:37', 0.00, 1, 1, 1, '2024-08-20 03:16:37', '2024-08-31 05:05:51'),
(2, '66d2fe6e0ec84.png', 'sampatel@example.com', 'curewell@example.com', '+44-207-123-4567', 'sampatel', '$2y$10$9bxwC4udRCYPwObYvPtHceI1NVU7Kgk9/fPaH0aNembGrVt3fDdta', 1, 1, 0.00, 10, '2024-08-20 03:21:05', 0.00, 1, 1, 1, '2024-08-20 03:21:05', '2024-08-31 05:28:46'),
(3, '66d2fdb2348ef.png', 'lisareynolds@example.com', 'pipemasterpro@example.com', '+61-2-1234-5678', 'lisareynolds', '$2y$10$7xnoKa5N.9gxAqii/gXzx.hMe68zYVp1MI9YfiqmloGQYe2g8KHiq', 1, 1, 250.00, 9, '2024-08-20 03:24:14', 0.00, 1, 1, 1, '2024-08-20 03:24:14', '2024-08-31 05:25:38'),
(4, '66d2fdfed8692.png', 'jamesturner@example.com', 'flowfixplumb@example.com', '+91-22-1234-5678', 'jamesturner', '$2y$10$WFVlQ26nK/kH27qyhPOaIumypw3ifiIJ.rjwre9Z/3BEr1naoGY4W', 1, 1, 0.00, 10, '2024-08-20 03:26:49', 0.00, 1, 1, 1, '2024-08-20 03:26:49', '2024-08-31 05:26:54'),
(5, '66d2fed129705.png', 'ninalopez@example.com', 'fitfusion@example.com', '+49-30-1234-5678', 'ninalopez', '$2y$10$bJ6oZ5n9W0K6Nkdg0QO7hOA5gVjrCLdS3EVS/0pmZeNnxNI/9e8Jq', 1, 1, 50.00, 7, '2024-08-20 03:29:30', 0.00, 1, 1, 1, '2024-08-20 03:29:30', '2024-08-31 05:30:25'),
(6, '66d2fe989e77c.png', 'saramiller@example.com', 'muscleminds@example.com', '+81-3-1234-5678', 'saramiller', '$2y$10$/hPwZwrSjd4Ec8OTCILoEuvI2eV.lZG/QUDffwKR6LroV3Id42OSC', 1, 1, 0.00, 10, '2024-08-20 03:31:39', 0.00, 1, 1, 1, '2024-08-20 03:31:39', '2024-08-31 05:29:28'),
(7, '66d2ff3cd7c9f.png', 'tomhughes@example.com', 'stylesharp@example.com', '+971-4-1234-5678', 'tomhughes', '$2y$10$3wQcJqg.1w9jsdZMliCbIOOxFD4/V8AEjtQjpx4/LyuP4BJ/qQJ/6', 1, 1, 840.00, 5, '2024-08-20 03:39:38', 0.00, 1, 1, 1, '2024-08-20 03:39:38', '2024-09-03 23:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_infos`
--

CREATE TABLE `vendor_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `language_id` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `details` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vendor_infos`
--

INSERT INTO `vendor_infos` (`id`, `vendor_id`, `language_id`, `name`, `country`, `city`, `state`, `zip_code`, `address`, `details`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'Alex Green', 'USA', NULL, NULL, NULL, '123 Wellness Blvd, New York, NY', NULL, '2024-08-20 03:16:37', '2024-08-21 01:15:15'),
(2, 1, 21, 'أليكس جرين', 'الولايات المتحدة الأمريكية', NULL, NULL, NULL, '123 Wellness Blvd، نيويورك، نيويورك', NULL, '2024-08-20 03:16:37', '2024-08-21 01:15:15'),
(3, 2, 20, 'Sam Patel', 'UK', NULL, NULL, NULL, '456 Health St, London, UK', NULL, '2024-08-20 03:21:05', '2024-08-21 01:16:13'),
(4, 2, 21, 'سام باتيل', 'المملكة المتحدة', NULL, NULL, NULL, '456 شارع هيلث، لندن، المملكة المتحدة', NULL, '2024-08-20 03:21:05', '2024-08-21 01:16:13'),
(5, 3, 20, 'Lisa Reynolds', 'Australia', NULL, NULL, NULL, '789 Aqua Lane, Sydney, Australia', NULL, '2024-08-20 03:24:14', '2024-08-21 01:17:13'),
(6, 3, 21, 'ليزا رينولدز', 'أستراليا', NULL, NULL, NULL, '789 أكوا لين، سيدني، أستراليا', NULL, '2024-08-20 03:24:14', '2024-08-21 01:17:13'),
(7, 4, 20, 'James Turner', 'India', NULL, NULL, NULL, '101 Waterway Rd, Mumbai, India', NULL, '2024-08-20 03:26:49', '2024-08-21 01:17:49'),
(8, 4, 21, 'جيمس تيرنر', 'الهند', NULL, NULL, NULL, '101 طريق ووترواي، مومباي، الهند', NULL, '2024-08-20 03:26:49', '2024-08-21 01:17:49'),
(9, 5, 20, 'Nina Lopez', 'Germany', NULL, NULL, NULL, '102 Fitness Ave, Berlin, Germany', NULL, '2024-08-20 03:29:30', '2024-08-21 01:18:39'),
(10, 5, 21, 'نينا لوبيز', 'ألمانيا', NULL, NULL, NULL, '102 شارع فيتنيس، برلين، ألمانيا', NULL, '2024-08-20 03:29:30', '2024-08-21 01:18:39'),
(11, 6, 20, 'Sara Miller', 'Japan', NULL, NULL, NULL, '202 Workout St, Tokyo, Japan', NULL, '2024-08-20 03:31:39', '2024-08-21 01:19:21'),
(12, 6, 21, 'سارة ميلر', 'اليابان', NULL, NULL, NULL, '202 شارع ورك أوت، طوكيو، اليابان', NULL, '2024-08-20 03:31:39', '2024-08-21 01:19:21'),
(13, 7, 20, 'Tom Hughes', 'UAE', NULL, NULL, NULL, '707 Grooming Rd, Dubai, UAE', NULL, '2024-08-20 03:39:38', '2024-08-21 01:20:04'),
(14, 7, 21, 'توم هيوز', 'الامارات العربية المتحدة', NULL, NULL, NULL, '707 طريق جرومنج، دبي، الإمارات العربية المتحدة', NULL, '2024-08-20 03:39:38', '2024-08-21 01:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_plugins`
--

CREATE TABLE `vendor_plugins` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` int NOT NULL,
  `zoom_account_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_client_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_client_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_calendar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calender_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `vendor_id` bigint NOT NULL,
  `service_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `vendor_id`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 16, '2024-08-26 22:06:55', '2024-08-26 22:06:55'),
(2, 1, 1, 17, '2024-08-26 22:07:01', '2024-08-26 22:07:01'),
(3, 1, 2, 21, '2024-08-26 22:07:13', '2024-08-26 22:07:13'),
(4, 1, 6, 15, '2024-08-26 22:07:23', '2024-08-26 22:07:23'),
(5, 1, 4, 14, '2024-08-26 22:07:37', '2024-08-26 22:07:37'),
(6, 1, 6, 23, '2024-08-27 00:19:47', '2024-08-27 00:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint DEFAULT NULL,
  `withdraw_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_id` bigint DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable_amount` decimal(10,2) NOT NULL,
  `total_charge` decimal(10,2) NOT NULL,
  `additional_reference` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fields` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_method_inputs`
--

CREATE TABLE `withdraw_method_inputs` (
  `id` bigint UNSIGNED NOT NULL,
  `withdraw_payment_method_id` bigint DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint DEFAULT NULL,
  `order_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_method_options`
--

CREATE TABLE `withdraw_method_options` (
  `id` bigint UNSIGNED NOT NULL,
  `withdraw_method_input_id` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_payment_methods`
--

CREATE TABLE `withdraw_payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(10,2) DEFAULT NULL,
  `max_limit` decimal(10,2) DEFAULT NULL,
  `fixed_charge` decimal(10,2) DEFAULT NULL,
  `percentage_charge` decimal(5,2) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_processes`
--

CREATE TABLE `work_processes` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `background_color` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `serial_number` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `work_processes`
--

INSERT INTO `work_processes` (`id`, `language_id`, `icon`, `background_color`, `serial_number`, `title`, `text`, `image`, `created_at`, `updated_at`) VALUES
(36, 20, 'fas fa-search', 'C56CD6', 1, 'Find Services', 'Search and filter local services to find the right provider', NULL, '2024-08-21 02:47:50', '2024-08-29 03:54:44'),
(37, 21, 'fas fa-search', 'C56CD6', 1, 'البحث عن الخدمات', 'ابحث وصَفِّ الخدمات للعثور على المزود المناسب', NULL, '2024-08-21 02:50:45', '2024-08-29 03:54:07'),
(38, 20, 'fas fa-check', '87C3FF', 2, 'Choose Staff', 'Choose top staff for your service by availability and expertise.', NULL, '2024-08-21 02:53:36', '2024-08-29 03:44:30'),
(39, 21, 'fas fa-check', '87C3FF', 2, 'اختر الموظفين', 'اختر أفضل الموظفين لخدمتك حسب التوافر والخبرة.', NULL, '2024-08-21 02:54:33', '2024-08-29 03:45:12'),
(40, 20, 'far fa-calendar-alt', '036CDA', 3, 'Choose Schedule', 'Choose a date and time from available options.', NULL, '2024-08-21 03:00:12', '2024-08-21 04:23:01'),
(41, 20, 'fas fa-credit-card', '15F5FD', 4, 'Send Your Payment', 'Complete your transaction securely to finalize your booking.', NULL, '2024-08-21 03:01:27', '2024-09-03 06:49:41'),
(42, 21, 'far fa-calendar-alt', '036CDA', 3, 'اختر الجدول الزمني', 'اختر التاريخ والوقت من الخيارات المتاحة.', NULL, '2024-08-21 03:03:38', '2024-08-21 04:23:46'),
(43, 21, 'fas fa-credit-card', '15F5FD', 4, 'أرسل دفعتك', 'أكمل معاملتك بشكل آمن لإتمام حجزك.', NULL, '2024-08-21 03:04:54', '2024-09-03 06:50:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_role_id_foreign` (`role_id`);

--
-- Indexes for table `admin_global_days`
--
ALTER TABLE `admin_global_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_settings`
--
ALTER TABLE `basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_categories_language_id_foreign` (`language_id`);

--
-- Indexes for table `blog_informations`
--
ALTER TABLE `blog_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_informations_language_id_foreign` (`language_id`),
  ADD KEY `blog_informations_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_informations_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cookie_alerts`
--
ALTER TABLE `cookie_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cookie_alerts_language_id_foreign` (`language_id`);

--
-- Indexes for table `custom_sections`
--
ALTER TABLE `custom_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_section_contents`
--
ALTER TABLE `custom_section_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_language_id_foreign` (`language_id`);

--
-- Indexes for table `featured_service_charges`
--
ALTER TABLE `featured_service_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_contents`
--
ALTER TABLE `footer_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_texts_language_id_foreign` (`language_id`);

--
-- Indexes for table `hero_sections`
--
ALTER TABLE `hero_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hero_sections_language_id_foreign` (`language_id`);

--
-- Indexes for table `inqury_messages`
--
ALTER TABLE `inqury_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_builders`
--
ALTER TABLE `menu_builders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_gateways`
--
ALTER TABLE `offline_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_gateways`
--
ALTER TABLE `online_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_contents`
--
ALTER TABLE `page_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_contents_language_id_foreign` (`language_id`),
  ADD KEY `page_contents_page_id_foreign` (`page_id`);

--
-- Indexes for table `page_headings`
--
ALTER TABLE `page_headings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_headings_language_id_foreign` (`language_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `popups_language_id_foreign` (`language_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_language_id_foreign` (`language_id`);

--
-- Indexes for table `product_contents`
--
ALTER TABLE `product_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_contents_language_id_foreign` (`language_id`),
  ADD KEY `product_contents_product_category_id_foreign` (`product_category_id`),
  ADD KEY `product_contents_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_coupons`
--
ALTER TABLE `product_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_purchase_items`
--
ALTER TABLE `product_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchase_items_product_order_id_foreign` (`product_order_id`),
  ADD KEY `product_purchase_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_shipping_charges`
--
ALTER TABLE `product_shipping_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_charges_language_id_foreign` (`language_id`);

--
-- Indexes for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quick_links_language_id_foreign` (`language_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_contents`
--
ALTER TABLE `section_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seos_language_id_foreign` (`language_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_contents`
--
ALTER TABLE `service_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_images`
--
ALTER TABLE `service_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_promotions`
--
ALTER TABLE `service_promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_medias`
--
ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_contents`
--
ALTER TABLE `staff_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_days`
--
ALTER TABLE `staff_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_global_days`
--
ALTER TABLE `staff_global_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_global_holidays`
--
ALTER TABLE `staff_global_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_global_hours`
--
ALTER TABLE `staff_global_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_holidays`
--
ALTER TABLE `staff_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_plugins`
--
ALTER TABLE `staff_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_services`
--
ALTER TABLE `staff_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_service_hours`
--
ALTER TABLE `staff_service_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_id_unique` (`email_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_statuses`
--
ALTER TABLE `support_ticket_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`country_code`,`timezone`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_infos`
--
ALTER TABLE `vendor_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_plugins`
--
ALTER TABLE `vendor_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_method_inputs`
--
ALTER TABLE `withdraw_method_inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_method_options`
--
ALTER TABLE `withdraw_method_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_payment_methods`
--
ALTER TABLE `withdraw_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_processes`
--
ALTER TABLE `work_processes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_global_days`
--
ALTER TABLE `admin_global_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `basic_settings`
--
ALTER TABLE `basic_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `blog_informations`
--
ALTER TABLE `blog_informations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cookie_alerts`
--
ALTER TABLE `cookie_alerts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `custom_sections`
--
ALTER TABLE `custom_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `custom_section_contents`
--
ALTER TABLE `custom_section_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `featured_service_charges`
--
ALTER TABLE `featured_service_charges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `footer_contents`
--
ALTER TABLE `footer_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hero_sections`
--
ALTER TABLE `hero_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inqury_messages`
--
ALTER TABLE `inqury_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_builders`
--
ALTER TABLE `menu_builders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `offline_gateways`
--
ALTER TABLE `offline_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `online_gateways`
--
ALTER TABLE `online_gateways`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `page_contents`
--
ALTER TABLE `page_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `page_headings`
--
ALTER TABLE `page_headings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_contents`
--
ALTER TABLE `product_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product_coupons`
--
ALTER TABLE `product_coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `product_purchase_items`
--
ALTER TABLE `product_purchase_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_shipping_charges`
--
ALTER TABLE `product_shipping_charges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quick_links`
--
ALTER TABLE `quick_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section_contents`
--
ALTER TABLE `section_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=754;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_contents`
--
ALTER TABLE `service_contents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `service_images`
--
ALTER TABLE `service_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `service_promotions`
--
ALTER TABLE `service_promotions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `social_medias`
--
ALTER TABLE `social_medias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff_contents`
--
ALTER TABLE `staff_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `staff_days`
--
ALTER TABLE `staff_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `staff_global_days`
--
ALTER TABLE `staff_global_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `staff_global_holidays`
--
ALTER TABLE `staff_global_holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_global_hours`
--
ALTER TABLE `staff_global_hours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `staff_holidays`
--
ALTER TABLE `staff_holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `staff_plugins`
--
ALTER TABLE `staff_plugins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff_services`
--
ALTER TABLE `staff_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `staff_service_hours`
--
ALTER TABLE `staff_service_hours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `support_ticket_statuses`
--
ALTER TABLE `support_ticket_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vendor_infos`
--
ALTER TABLE `vendor_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vendor_plugins`
--
ALTER TABLE `vendor_plugins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `withdraw_method_inputs`
--
ALTER TABLE `withdraw_method_inputs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `withdraw_method_options`
--
ALTER TABLE `withdraw_method_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw_payment_methods`
--
ALTER TABLE `withdraw_payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `work_processes`
--
ALTER TABLE `work_processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_informations`
--
ALTER TABLE `blog_informations`
  ADD CONSTRAINT `blog_informations_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_informations_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_informations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cookie_alerts`
--
ALTER TABLE `cookie_alerts`
  ADD CONSTRAINT `cookie_alerts_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_contents`
--
ALTER TABLE `footer_contents`
  ADD CONSTRAINT `footer_texts_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hero_sections`
--
ALTER TABLE `hero_sections`
  ADD CONSTRAINT `hero_sections_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_contents`
--
ALTER TABLE `page_contents`
  ADD CONSTRAINT `page_contents_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `page_contents_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `popups`
--
ALTER TABLE `popups`
  ADD CONSTRAINT `popups_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_contents`
--
ALTER TABLE `product_contents`
  ADD CONSTRAINT `product_contents_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_contents_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_contents_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_purchase_items`
--
ALTER TABLE `product_purchase_items`
  ADD CONSTRAINT `product_purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchase_items_product_order_id_foreign` FOREIGN KEY (`product_order_id`) REFERENCES `product_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_shipping_charges`
--
ALTER TABLE `product_shipping_charges`
  ADD CONSTRAINT `shipping_charges_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD CONSTRAINT `quick_links_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seos`
--
ALTER TABLE `seos`
  ADD CONSTRAINT `seos_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
