-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 11:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `com_code` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول الادمن';

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `password`, `com_code`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin1', 'admin1@admin1.com', 'Admin1', '$2y$10$qnxCv4Z00wZhcOYHv6Rdbe11VGiPkzd9lup6fgGOevE5elP.UEL7.', 123456789, NULL, NULL, NULL, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'Admin2', 'admin2@admin2.com', 'Admin2', '$2y$10$/DJOZG4VPFAv88VC66JCQe/4leWmMaNx0JOuad3CO6TUcLjX1EAnm', 123456789, NULL, NULL, NULL, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_settings`
--

CREATE TABLE `admin_panel_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `general_alert` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `com_code` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول اعدادات الادمن';

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `system_name`, `photo`, `active`, `general_alert`, `address`, `phone`, `com_code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'حلول-للكمبيوتر', 'dash.jpg', 1, 'حلول-للكمبيوتر', 'سوهاج-كوبري النيل', '0123456789', 123456789, NULL, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_cards`
--

CREATE TABLE `inv_item_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'اسم الصنف ذي فراخ او لحمة',
  `item_code` bigint(20) UNSIGNED NOT NULL COMMENT 'الكود بتاع كل صنف',
  `item_type` tinyint(4) NOT NULL COMMENT '1- مخزني : ذي المكاتب والكراسي ليس لها تاريخ صلاحية\n                                                                    2- استهلاكي : ذي الماكولات لها تاريخ صلاحية\n                                                                    3- عهدة : ذي صرف جهاز كمبيوتر للموظف فممكن استرجاعه لما الموظف يترك العمل',
  `barcode` varchar(255) NOT NULL COMMENT 'باركود الصنف',
  `parent_inv_item_card_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'كود الصنف الاب',
  `does_has_retail_unit` tinyint(4) DEFAULT NULL COMMENT 'هل للصنف وحدة تجزئه',
  `has_fixed_price` tinyint(4) DEFAULT NULL COMMENT 'هل للصنف سعر ثابت بالفواتير او قابل للتغيير بالفواتير',
  `retail_uom_to_uom` decimal(8,2) UNSIGNED NOT NULL COMMENT 'وحدة التجزئه ذي طبق 1 كيلو فوحدة النجزئه بتساوي كام من الوحدة الاب مثال الشكاره فيها 10 طبق 1 كيلو',
  `active` tinyint(4) NOT NULL COMMENT 'هل الخزنة مفعلة او معطلة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `quantity` double(10,3) DEFAULT NULL COMMENT 'الكمية بالوحدة الاب',
  `quantity_retail` double(10,3) DEFAULT NULL COMMENT ' كمية التجزئه المتبقية من وحدة الاب في حالة وجود وحدة تجزئه للصنف',
  `quantity_all_retail` double(10,3) DEFAULT NULL COMMENT 'quantity + quantity_retail  كل الكمية للصنف بوحدة التجزئه وهتساوي',
  `price` double(10,2) DEFAULT NULL COMMENT 'السعر القطاعي بوحدة القياس الاساسية',
  `gomla_price` double(10,2) DEFAULT NULL COMMENT 'السعر جملة بوحدة القياس الاساسية',
  `nos_gomla_price` double(10,2) DEFAULT NULL COMMENT 'سعر النص جملة قطاعي مع الوحدة الاساسية',
  `price_retail` double(10,2) DEFAULT NULL COMMENT 'السعر القطاعي بوحدة قياس التجزئه',
  `gomla_price_retail` double(10,2) DEFAULT NULL COMMENT 'السعر جملة بوحدة القياس التجزئه',
  `nos_gomla_price_retail` double(10,2) DEFAULT NULL COMMENT 'سعر النص جملة قطاعي مع الوحدة التجزئه',
  `cost_price` double(10,2) DEFAULT NULL COMMENT 'متوسط التكلفة للصنف بوحدة القياس الاساسية',
  `cost_price_retail` double(10,2) DEFAULT NULL COMMENT 'متوسط التكلفة للصنف بوحدة قياس التجزئه',
  `inv_item_card_categories_id` bigint(20) UNSIGNED NOT NULL,
  `retail_uom_id` bigint(20) UNSIGNED NOT NULL COMMENT 'وحدة تجزئه ذي طبق 1 كيلو او طبق 200 جرام',
  `uom_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'وحدة القياس الاب للصنف مثال ذي الفراخ وحدة القياس الاساسية لها ممكن شكارة او كارتونة',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول الاصناف';

--
-- Dumping data for table `inv_item_cards`
--

INSERT INTO `inv_item_cards` (`id`, `name`, `item_code`, `item_type`, `barcode`, `parent_inv_item_card_id`, `does_has_retail_unit`, `has_fixed_price`, `retail_uom_to_uom`, `active`, `date`, `com_code`, `quantity`, `quantity_retail`, `quantity_all_retail`, `price`, `gomla_price`, `nos_gomla_price`, `price_retail`, `gomla_price_retail`, `nos_gomla_price_retail`, `cost_price`, `cost_price_retail`, `inv_item_card_categories_id`, `retail_uom_id`, `uom_id`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'لحم سوداني مجمد', 1, 2, '1', NULL, 1, NULL, 10.00, 1, '2024-02-15', 123456789, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 1, 1, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'فراخ شهد', 2, 2, '2', NULL, 1, NULL, 10.00, 1, '2024-02-15', 123456789, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, 2, 2, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(3, 'وراك شهد', 2, 2, '2', 2, 1, NULL, 10.00, 1, '2024-02-15', 123456789, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, 2, 1, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_card_categories`
--

CREATE TABLE `inv_item_card_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'اسم الوحدة',
  `active` tinyint(4) NOT NULL COMMENT 'هل الوحدة مفعلة او معطلة',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول فئات الاصناف';

--
-- Dumping data for table `inv_item_card_categories`
--

INSERT INTO `inv_item_card_categories` (`id`, `name`, `active`, `com_code`, `date`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'لحوم و مجمدات', 1, 123456789, '2024-02-15', 1, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'فراخ', 1, 123456789, '2024-02-15', 2, NULL, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `inv_uoms`
--

CREATE TABLE `inv_uoms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'اسم الوحدة',
  `is_master` tinyint(4) NOT NULL COMMENT 'هل الوحدة رئيسية او فرعية',
  `active` tinyint(4) NOT NULL COMMENT 'هل الوحدة مفعلة او معطلة',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول وحدات القياس';

--
-- Dumping data for table `inv_uoms`
--

INSERT INTO `inv_uoms` (`id`, `name`, `is_master`, `active`, `com_code`, `date`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'شكاره', 1, 1, 123456789, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'كارتونه', 1, 1, 123456789, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(3, 'طبق واحد كيلو', 0, 1, 123456789, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(4, 'كيلو 90 جرام', 0, 1, 123456789, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_01_095239_create_admins_table', 1),
(6, '2024_02_01_195850_create_admin_panel_settings_table', 1),
(7, '2024_02_03_195316_create_treasuries_table', 1),
(8, '2024_02_07_233318_create_treasury_deliveries_table', 1),
(9, '2024_02_09_222527_create_sales_material_types_table', 1),
(10, '2024_02_10_230536_create_stores_table', 1),
(11, '2024_02_11_213428_create_inv_uoms_table', 1),
(12, '2024_02_12_135132_create_inv_item_card_categories_table', 1),
(13, '2024_02_12_185716_create_inv_item_cards_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_material_types`
--

CREATE TABLE `sales_material_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'اسم المادة',
  `active` tinyint(4) NOT NULL COMMENT 'هل المادة مفعلة او معطلة',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول فئات الفواتير';

--
-- Dumping data for table `sales_material_types`
--

INSERT INTO `sales_material_types` (`id`, `name`, `active`, `com_code`, `date`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'لحوم و مجمدات', 1, 123456789, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'فراخ', 1, 123456789, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'اسم المادة',
  `active` tinyint(4) NOT NULL COMMENT 'هل المخزن مفعلة او معطلة',
  `phone` varchar(255) DEFAULT NULL COMMENT 'هاتف المخزن',
  `address` varchar(255) DEFAULT NULL COMMENT 'عنوان المخزن',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول المخازن';

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `active`, `phone`, `address`, `com_code`, `date`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'المخزن الاول', 1, '42798', 'shubraElkheyima/Qalubiya/Egypt', 123456789, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'المخزن الثاني', 0, '42798', 'Benha/Qalubiya/Egypt', 123456789, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `treasuries`
--

CREATE TABLE `treasuries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL COMMENT 'اسم الخزنة',
  `is_master` tinyint(4) NOT NULL COMMENT 'هل الخزنة رئيسية او فرعية',
  `active` tinyint(4) NOT NULL COMMENT 'هل الخزنة مفعلة او معطلة',
  `last_isal_exchange` bigint(20) DEFAULT NULL COMMENT 'اخر ايصال تم صرفه',
  `last_isal_collect` int(11) DEFAULT NULL COMMENT 'اخر ايصال تم تحصيله',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `date` date DEFAULT NULL COMMENT 'i will use this column for search',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول الخزن';

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `name`, `is_master`, `active`, `last_isal_exchange`, `last_isal_collect`, `com_code`, `date`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'الرئيسية', 1, 1, 1, 1, 1, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(2, 'فرعية', 0, 0, 2, 2, 2, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(3, 'خزنة كاشير1', 1, 1, 3, 3, 3, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(4, 'خزنة كاشير2', 0, 0, 4, 4, 4, '2024-02-15', 2, 2, '2024-02-14 22:17:54', '2024-02-14 22:17:54'),
(5, 'خزنة كاشير3', 1, 1, 5, 5, 5, '2024-02-15', 1, 1, '2024-02-14 22:17:54', '2024-02-14 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `treasury_deliveries`
--

CREATE TABLE `treasury_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `treasuries_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'الخزنة الرئيسية التي سوف تستلم من الخزنة الفرعية',
  `treasuries_can_delivery_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'الخزنة الفرعية التي سوف يتم تسليمها للخزنة الرئيسية',
  `com_code` int(11) DEFAULT NULL COMMENT 'رقم الشركة',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول استيلام الخزن';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_created_by_foreign` (`created_by`),
  ADD KEY `admins_updated_by_foreign` (`updated_by`),
  ADD KEY `admins_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_panel_settings_created_by_foreign` (`created_by`),
  ADD KEY `admin_panel_settings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inv_item_cards`
--
ALTER TABLE `inv_item_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_item_cards_inv_item_card_categories_id_foreign` (`inv_item_card_categories_id`),
  ADD KEY `inv_item_cards_retail_uom_id_foreign` (`retail_uom_id`),
  ADD KEY `inv_item_cards_uom_id_foreign` (`uom_id`),
  ADD KEY `inv_item_cards_added_by_foreign` (`added_by`),
  ADD KEY `inv_item_cards_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `inv_item_card_categories`
--
ALTER TABLE `inv_item_card_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_item_card_categories_added_by_foreign` (`added_by`),
  ADD KEY `inv_item_card_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_uoms_added_by_foreign` (`added_by`),
  ADD KEY `inv_uoms_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sales_material_types`
--
ALTER TABLE `sales_material_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_material_types_added_by_foreign` (`added_by`),
  ADD KEY `sales_material_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stores_added_by_foreign` (`added_by`),
  ADD KEY `stores_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treasuries_added_by_foreign` (`added_by`),
  ADD KEY `treasuries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `treasury_deliveries`
--
ALTER TABLE `treasury_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treasury_deliveries_treasuries_id_foreign` (`treasuries_id`),
  ADD KEY `treasury_deliveries_treasuries_can_delivery_id_foreign` (`treasuries_can_delivery_id`),
  ADD KEY `treasury_deliveries_added_by_foreign` (`added_by`),
  ADD KEY `treasury_deliveries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_item_cards`
--
ALTER TABLE `inv_item_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inv_item_card_categories`
--
ALTER TABLE `inv_item_card_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_material_types`
--
ALTER TABLE `sales_material_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treasury_deliveries`
--
ALTER TABLE `treasury_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admins_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD CONSTRAINT `admin_panel_settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_panel_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_item_cards`
--
ALTER TABLE `inv_item_cards`
  ADD CONSTRAINT `inv_item_cards_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_item_cards_inv_item_card_categories_id_foreign` FOREIGN KEY (`inv_item_card_categories_id`) REFERENCES `inv_item_card_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_item_cards_retail_uom_id_foreign` FOREIGN KEY (`retail_uom_id`) REFERENCES `inv_uoms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_item_cards_uom_id_foreign` FOREIGN KEY (`uom_id`) REFERENCES `inv_uoms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_item_cards_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_item_card_categories`
--
ALTER TABLE `inv_item_card_categories`
  ADD CONSTRAINT `inv_item_card_categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_item_card_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  ADD CONSTRAINT `inv_uoms_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_uoms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_material_types`
--
ALTER TABLE `sales_material_types`
  ADD CONSTRAINT `sales_material_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_material_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stores_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD CONSTRAINT `treasuries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasuries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treasury_deliveries`
--
ALTER TABLE `treasury_deliveries`
  ADD CONSTRAINT `treasury_deliveries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_deliveries_treasuries_can_delivery_id_foreign` FOREIGN KEY (`treasuries_can_delivery_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_deliveries_treasuries_id_foreign` FOREIGN KEY (`treasuries_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_deliveries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
