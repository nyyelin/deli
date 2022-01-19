-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 19, 2022 at 07:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `7days_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `amount`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 116000, NULL, '2021-12-02 06:41:48', '2021-12-02 07:56:51'),
(2, 'KBZ', 100000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'AYA', 100000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'KBZ Pay', 100000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'CB', 100000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Mandalay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Pyay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Nay Pyi Taw', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Taunggyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `township_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `contact_person`, `phone_no`, `address`, `codeno`, `account`, `owner`, `user_id`, `township_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ma One', '09-123456789', 'Home Street, Hlaing Township', '202112001', '1234567892345678', 'client One', 7, 6, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Ma Two', '09-123456789', 'Mati Street, Botahtaung Township', '202112002', '1234567892345678', 'client two', 8, 22, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_man_township`
--

CREATE TABLE `delivery_man_township` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_men_id` bigint(20) UNSIGNED NOT NULL,
  `township_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_man_township`
--

INSERT INTO `delivery_man_township` (`id`, `delivery_men_id`, `township_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 25, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 1, 26, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 2, 2, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 2, 3, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 2, 4, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(6, 4, 49, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(7, 5, 10, NULL, '2021-12-02 07:57:47', '2021-12-02 07:57:47'),
(8, 5, 31, NULL, '2021-12-02 07:57:47', '2021-12-02 07:57:47'),
(9, 5, 34, NULL, '2021-12-02 07:57:47', '2021-12-02 07:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_men`
--

INSERT INTO `delivery_men` (`id`, `phone_no`, `address`, `user_id`, `city_id`, `deleted_at`, `created_at`, `updated_at`, `status`) VALUES
(1, '09-123456789', 'Baho Street, Mayangone Township', 3, 1, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48', 0),
(2, '09-123456789', 'Baho Street, Mayangone Township', 4, 1, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48', 0),
(3, '09-123456789', 'Baho Street, Mayangone Township', 5, 1, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48', 1),
(4, '09-123456789', 'Aungmyaetharzan township', 6, 2, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48', 0),
(5, '1234567', 'yangon', 10, 1, NULL, '2021-12-02 07:57:47', '2021-12-02 07:57:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_amount` int(11) NOT NULL DEFAULT 0,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_type_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `amount`, `guest_amount`, `description`, `pickup_id`, `expense_type_id`, `client_id`, `staff_id`, `city_id`, `item_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '20000', 0, 'Client Fee', 2, 1, NULL, NULL, 1, NULL, 1, NULL, '2021-12-02 07:56:51', '2021-12-02 07:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_types`
--

INSERT INTO `expense_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Client', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Office', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Salary', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Others', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Carry Fees', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_fees` int(11) DEFAULT NULL,
  `deposit` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `bank_amount` int(11) NOT NULL DEFAULT 0,
  `cash_amount` int(11) NOT NULL DEFAULT 0,
  `way_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `delivery_fees`, `deposit`, `amount`, `bank_amount`, `cash_amount`, `way_id`, `payment_type_id`, `deleted_at`, `created_at`, `updated_at`, `status`, `bank_id`) VALUES
(1, 2000, NULL, 12000, 0, 12000, 1, 1, NULL, '2021-12-02 07:49:07', '2021-12-02 07:56:21', 1, 1),
(2, 2000, NULL, 12000, 0, 12000, 3, 1, NULL, '2021-12-02 07:55:41', '2021-12-02 07:56:21', 1, 1),
(3, 2000, NULL, 12000, 0, 12000, 4, 1, NULL, '2021-12-02 07:55:45', '2021-12-02 07:56:21', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codeno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_date` date NOT NULL,
  `expired_date` date DEFAULT NULL,
  `deposit` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `delivery_fees` int(11) NOT NULL DEFAULT 0,
  `other_fees` int(11) NOT NULL DEFAULT 0,
  `receiver_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_phone_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paystatus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0,
  `pickup_id` bigint(20) UNSIGNED NOT NULL,
  `township_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `error_remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_gate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_postoffice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `codeno`, `assign_date`, `expired_date`, `deposit`, `amount`, `delivery_fees`, `other_fees`, `receiver_name`, `receiver_address`, `receiver_phone_no`, `remark`, `paystatus`, `status`, `pickup_id`, `township_id`, `staff_id`, `error_remark`, `sender_gate_id`, `sender_postoffice_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '20211200102001', '2021-12-02', NULL, 10000, 12000, 2000, 0, 'mg mg', NULL, NULL, 'testing', '1', 0, 1, 31, 1, NULL, NULL, NULL, NULL, '2021-12-02 07:47:32', '2021-12-02 07:47:32'),
(2, '20211200102002', '2021-12-02', '2021-12-03', 10000, 12000, 2000, 0, 'Hla Hla', NULL, NULL, 'testing', '1', 0, 1, 17, 1, 'Recall', NULL, NULL, NULL, '2021-12-02 07:47:59', '2021-12-02 07:49:21'),
(3, '20211200202003', '2021-12-02', NULL, 10000, 12000, 2000, 0, 'mya mya', NULL, NULL, 'testing1', '1', 0, 2, 1, 1, NULL, NULL, NULL, NULL, '2021-12-02 07:53:43', '2021-12-02 07:53:43'),
(4, '20211200202004', '2021-12-02', NULL, 10000, 12000, 2000, 0, 'aung aung', NULL, NULL, 'testing1', '1', 0, 2, 6, 1, NULL, NULL, NULL, NULL, '2021-12-02 07:53:58', '2021-12-02 07:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_10_14_092127_create_cities_table', 1),
(5, '2020_10_14_092128_create_sender_gates_table', 1),
(6, '2020_10_14_092129_create_sender_postoffices_table', 1),
(7, '2020_10_14_092336_create_townships_table', 1),
(8, '2020_10_14_093352_create_statuses_table', 1),
(9, '2020_10_14_093747_create_expense_types_table', 1),
(10, '2020_10_14_094711_create_delivery_men_table', 1),
(11, '2020_10_14_095100_create_delivery_man_township_table', 1),
(12, '2020_10_14_095629_create_clients_table', 1),
(13, '2020_10_14_095630_create_staff_table', 1),
(14, '2020_10_14_100628_create_schedules_table', 1),
(15, '2020_10_14_101311_create_pickups_table', 1),
(16, '2020_10_14_102258_create_items_table', 1),
(17, '2020_10_14_103539_create_ways_table', 1),
(18, '2020_10_14_110458_create_rebacks_table', 1),
(19, '2020_10_14_110459_create_payment_types_table', 1),
(20, '2020_10_14_110460_create_banks_table', 1),
(21, '2020_10_14_110743_create_incomes_table', 1),
(22, '2020_10_14_123848_create_expenses_table', 1),
(23, '2020_10_15_085816_create_permission_tables', 1),
(24, '2020_11_12_094726_create_notifications_table', 1),
(25, '2020_12_08_134331_create_transactions_table', 1),
(26, '2021_01_14_223210_add_status_column', 1),
(27, '2021_01_21_104128_add_status_column_to_delivery_men_table', 1),
(28, '2021_01_25_153237_add_item_id_column_into_transactions_table', 1),
(29, '2021_01_26_133652_add_bank_id_to_income', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 9),
(3, 'App\\User', 3),
(3, 'App\\User', 4),
(3, 'App\\User', 5),
(3, 'App\\User', 6),
(3, 'App\\User', 10),
(4, 'App\\User', 7),
(4, 'App\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('8db45077-a707-42ea-9ea8-4b367e73a907', 'App\\Notifications\\PickupNotification', 'App\\Pickup', 2, '{\"pickup\":{\"id\":2,\"status\":0,\"schedule_id\":2,\"delivery_man_id\":3,\"staff_id\":1,\"deleted_at\":null,\"created_at\":\"2021-12-02T07:52:11.000000Z\",\"updated_at\":\"2021-12-02T07:52:11.000000Z\",\"unread_notifications\":[]}}', NULL, '2021-12-02 07:52:27', '2021-12-02 07:52:27'),
('eceb6018-cd12-4fb0-abfd-a2fa03e11ea8', 'App\\Notifications\\PickupNotification', 'App\\Pickup', 1, '{\"pickup\":{\"id\":1,\"status\":0,\"schedule_id\":1,\"delivery_man_id\":3,\"staff_id\":1,\"deleted_at\":null,\"created_at\":\"2021-12-02T07:45:53.000000Z\",\"updated_at\":\"2021-12-02T07:45:53.000000Z\",\"unread_notifications\":[]}}', NULL, '2021-12-02 07:46:02', '2021-12-02 07:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cash', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Bank', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Cash+Bank', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Os', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Only Deli', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(6, 'Only Deposit', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

CREATE TABLE `pickups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pickups`
--

INSERT INTO `pickups` (`id`, `status`, `schedule_id`, `delivery_man_id`, `staff_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 3, 1, NULL, '2021-12-02 07:45:53', '2021-12-02 07:48:42'),
(2, 4, 2, 3, 1, NULL, '2021-12-02 07:52:11', '2021-12-02 07:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `rebacks`
--

CREATE TABLE `rebacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_id` bigint(20) UNSIGNED NOT NULL,
  `way_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'staff', 'web', '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'delivery_man', 'web', '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'client', 'web', '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `remark` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `pickup_date`, `status`, `remark`, `file`, `quantity`, `amount`, `client_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2021-12-02', 1, 'testing', '', 2, 20000, 1, NULL, '2021-12-02 07:45:53', '2021-12-02 07:46:27'),
(2, '2021-12-02', 1, 'testing11', '', 2, 20000, 2, NULL, '2021-12-02 07:52:11', '2021-12-02 07:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `sender_gates`
--

CREATE TABLE `sender_gates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sender_gates`
--

INSERT INTO `sender_gates` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Aungmingalar Gate', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Aungsan Gate', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Hlaingtharyar Gate', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Bayintnaung Gate', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `sender_postoffices`
--

CREATE TABLE `sender_postoffices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sender_postoffices`
--

INSERT INTO `sender_postoffices` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ahlone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Bahan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Botataung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Myanma Navy', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Dagon', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(6, 'Dagon Myothit (East)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(7, 'Dagon Myothit (North)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(8, 'Dagon University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(9, 'Dagon Myothit (Seikkan)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(10, 'Dagon Myothit (South)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(11, 'Dagon South (Industrial Zone)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(12, 'Laydaungkan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(13, 'University of Economic', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(14, 'Dala', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(15, 'Pyawbwegyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(16, 'Dawpone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(17, 'Hlaing', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(18, 'Hlaing University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(19, 'Hlaingtharyar', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(20, 'Technological University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(21, 'Dapain', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(22, 'Hlegu', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(23, 'Phaunggyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(24, 'Inndine', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(25, 'Ngarsutaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(26, 'Thapyut', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(27, 'Yemontat', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(28, 'Hmawbi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(29, 'Hmawbi Cantonment', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(30, 'Myaungdaka', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(31, 'Wanetchaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(32, 'Shwehlaygyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(33, 'Hleseik', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(34, 'Htantabin', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(35, 'Western University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(36, 'Aungsan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(37, 'Insein', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(38, 'Sawbwargyigone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(39, 'Yangon University (Kamaryut)', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(40, 'Kawthmu', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(41, 'Kyaikhtaw', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(42, 'Ngetawwsan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(43, 'Warbaloutthaught', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(44, 'Khayan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(45, 'Phayarpyo', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(46, 'Kokoegyung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(47, 'Konchankone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(48, 'Letkhokekone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(49, 'Tawkuanout', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(50, 'Kyauktada', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(51, 'Yangon GPO', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(52, 'Kamakalote', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(53, 'Khanaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(54, 'Kyauktan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(55, 'Meepya', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(56, 'Mingalon', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(57, 'Tadar', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(58, 'Khaloutchaine', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(59, 'Khathtiya', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(60, 'Kyeemyindine', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(61, 'Lanmadaw', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(62, 'Latha', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(63, 'Bayintnaung zay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(64, 'Htayrawara', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(65, 'Mayangone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(66, 'Htaukkyant', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(67, 'Mingalardon', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(68, 'Palemyothit', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(69, 'Mingalartaungnyunt', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(70, 'Yangon Station', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(71, 'North Okkalapa', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(72, 'Shwepaukkan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(73, 'Bogyokezay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(74, 'Pabedan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(75, 'Theingyizay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(76, 'Pazundaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(77, 'Sanchaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(78, 'Seikkyikanaugto', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(79, 'Shwepyithar', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(80, 'South Okkalapa', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(81, 'Ahpyauk', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(82, 'Okkan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(83, 'Phalone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(84, 'Phugyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(85, 'Taikkyi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(86, 'Tawlati', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(87, 'Thanatchaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(88, 'Thayetchaung', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(89, 'Yaeayesan', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(90, 'Myitarnyunt', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(91, 'Tamwe', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(92, 'Thaketa', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(93, 'Maritine University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(94, 'Hparkuanout', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(95, 'Thanlyin', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(96, 'Thanlyin Cantonment', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(97, 'Thahtaykwin', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(98, 'Eastern University', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(99, 'Thingangyun', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(100, 'Thuwanna', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(101, 'Nyaunglangone', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(102, 'Thonegwa', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(103, 'Kanbet', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(104, 'Thawuntaw', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(105, 'Twante', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(106, 'Pyaythaya', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(107, 'Yankin', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined_date` date NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `phone_no`, `address`, `joined_date`, `designation`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '09-123456789', 'Baho Street, Mayangone Township', '2019-02-01', 'Store Manager', 2, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, '`1234567890', 'yangon', '2000-12-03', 'Store Manager', 9, NULL, '2021-12-02 07:44:07', '2021-12-02 07:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codeno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `codeno`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '001', 'success', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, '002', 'return', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, '003', 'refund', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, '004', 'delay', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, '005', 'assign', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `townships`
--

CREATE TABLE `townships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_fees` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `townships`
--

INSERT INTO `townships` (`id`, `name`, `delivery_fees`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Insein', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Mayangone', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Sawbwagyigone', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Thamine', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Parami', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(6, 'Hlaing', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(7, 'Kamayut', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(8, 'Myaynigone', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(9, 'Sanchaung', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(10, 'Ahlon', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(11, 'Kyimyintnaing', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(12, 'Latha', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(13, 'Lanmadaw', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(14, 'Kyauttada', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(15, 'Pabedan', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(16, 'Sule', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(17, 'Bahan', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(18, 'Yankin', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(19, 'Tamwe', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(20, 'Kyaytmaung', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(21, 'Mingalartaungnyut', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(22, 'Botahtaung', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(23, 'Pazundaung', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(24, 'Thingangyun', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(25, 'Thuwana', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(26, 'Dawbon', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(27, 'Thakata', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(28, 'North Oakka', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(29, 'South Oakka', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(30, 'Kabaraye', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(31, 'Aungmingalar Highway', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(32, 'Bayintnaung', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(33, 'Phatkan', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(34, 'Aungsan', 2000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(35, 'North Dagon', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(36, 'South Dagon', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(37, 'East Dagon', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(38, 'Hlaingthayar', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(39, 'Shwepyitha', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(40, 'Shew Pauk Kan', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(41, 'Da Nyin Gone', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(42, 'Mingalardon', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(43, 'Htauk Kyant', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(44, 'Hmabi', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(45, 'Thanlyan', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(46, 'Kyauttan', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(47, 'Dagon Seikkan', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(48, 'Yu Za Na', 4000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(49, 'Mandalay District', 3000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(50, 'Pyay District', 3500, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(51, 'Naypyitaw District', 3500, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(52, 'Taunggyi District', 3500, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(53, 'Mandalay Gate', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(54, 'Pyay Gate', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(55, 'Naypyitaw Gate', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(56, 'Taunggyi Gate', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(57, 'Mandalay Post Office', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(58, 'Pyay Post Office', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(59, 'Naypyitaw Post Office', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(60, 'Taunggyi Post Office', 1000, NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `income_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tobank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `bank_id`, `income_id`, `expense_id`, `tobank_id`, `amount`, `description`, `deleted_at`, `created_at`, `updated_at`, `item_id`) VALUES
(1, 1, 1, NULL, NULL, 12000, 'Success Way', NULL, '2021-12-02 07:56:21', '2021-12-02 07:56:21', 1),
(2, 1, 2, NULL, NULL, 12000, 'Success Way', NULL, '2021-12-02 07:56:21', '2021-12-02 07:56:21', 3),
(3, 1, 3, NULL, NULL, 12000, 'Success Way', NULL, '2021-12-02 07:56:21', '2021-12-02 07:56:21', 4),
(4, 1, NULL, 1, NULL, 20000, 'Fix Debit List', NULL, '2021-12-02 07:56:51', '2021-12-02 07:56:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$PgMn8wqLMRNq8hfBLKoEA.zRZhDkXr.nTrkmaAsBrwTZIRDp.K5/K', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(2, 'Staff', 'staff@gmail.com', NULL, '$2y$10$2M4xYLmv5NSf0lEJSBaCbualy.s3YZp2w..5bIxbT0AroBrsfyTYO', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(3, 'Delivery Man One', 'deliveryman1@gmail.com', NULL, '$2y$10$KMaelP1a7HgWeMHfzZB4JeIB/1yxBjxKapjRggslbZLqTPJHUPPyO', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(4, 'Delivery Man Two', 'deliveryman2@gmail.com', NULL, '$2y$10$sWk5.fa6g./DIzIN4ga7CuIpobB77eo7isCPUqwaWlxkwkrTY/u7m', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(5, 'Car One', 'carone@gmail.com', NULL, '$2y$10$A5PocVUcTAcYuPP6VKnOAORjVG2fEB1BuNJqrpvwMBui9VH2vJHdi', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(6, 'MDY DeliveryMan', 'mdy@gmail.com', NULL, '$2y$10$82oY1.9C9Pxr6VcdLTrprOjQCsPqs.Pg0Zulvt3eHPtL2NRqyKb8i', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(7, 'Client One', 'client1@gmail.com', NULL, '$2y$10$pjvIW.L8qBdRoFfl/uW.I.C1jyXJLL/9tf79GiuMMnJ3z1Xjlplb6', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(8, 'Client Two', 'client2@gmail.com', NULL, '$2y$10$9NQyTE6IMFdSXq21w2h5retWIG0G6MskGzwYoR3q95NX4SPsfyAxK', NULL, '2021-12-02 06:41:48', '2021-12-02 06:41:48'),
(9, 'staff1', 'staff1@gmail.com', NULL, '$2y$10$Fo13izOlH3hirSOrIRCSH.JcGjvRAH9zk/TmlzFIeRiTnendeONsm', NULL, '2021-12-02 07:44:07', '2021-12-02 07:44:07'),
(10, 'aungaung', 'aung@gmail.com', NULL, '$2y$10$362hL7adzsqpozomNYN9eei8Nz0OXxDpJLUC0c7tjbfAmXv789XDm', NULL, '2021-12-02 07:57:47', '2021-12-02 07:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `ways`
--

CREATE TABLE `ways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `refund_date` date DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ways`
--

INSERT INTO `ways` (`id`, `status_code`, `delivery_date`, `refund_date`, `item_id`, `delivery_man_id`, `staff_id`, `status_id`, `remark`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '001', '2021-12-02', NULL, 1, 3, 1, 1, NULL, NULL, '2021-12-02 07:47:32', '2021-12-02 07:49:07'),
(2, '002', NULL, NULL, 2, 3, 1, 2, 'Recall', '2021-12-02 07:56:21', '2021-12-02 07:47:59', '2021-12-02 07:56:21'),
(3, '001', '2021-12-02', NULL, 3, 3, 1, 1, NULL, NULL, '2021-12-02 07:53:43', '2021-12-02 07:55:41'),
(4, '001', '2021-12-02', NULL, 4, 3, 1, 1, NULL, NULL, '2021-12-02 07:53:58', '2021-12-02 07:55:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`),
  ADD KEY `clients_township_id_foreign` (`township_id`);

--
-- Indexes for table `delivery_man_township`
--
ALTER TABLE `delivery_man_township`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_man_township_delivery_men_id_foreign` (`delivery_men_id`),
  ADD KEY `delivery_man_township_township_id_foreign` (`township_id`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_men_user_id_foreign` (`user_id`),
  ADD KEY `delivery_men_city_id_foreign` (`city_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_pickup_id_foreign` (`pickup_id`),
  ADD KEY `expenses_expense_type_id_foreign` (`expense_type_id`),
  ADD KEY `expenses_client_id_foreign` (`client_id`),
  ADD KEY `expenses_staff_id_foreign` (`staff_id`),
  ADD KEY `expenses_city_id_foreign` (`city_id`),
  ADD KEY `expenses_item_id_foreign` (`item_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_way_id_foreign` (`way_id`),
  ADD KEY `incomes_payment_type_id_foreign` (`payment_type_id`),
  ADD KEY `incomes_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_pickup_id_foreign` (`pickup_id`),
  ADD KEY `items_sender_gate_id_foreign` (`sender_gate_id`),
  ADD KEY `items_sender_postoffice_id_foreign` (`sender_postoffice_id`),
  ADD KEY `items_township_id_foreign` (`township_id`),
  ADD KEY `items_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickups_schedule_id_foreign` (`schedule_id`),
  ADD KEY `pickups_delivery_man_id_foreign` (`delivery_man_id`),
  ADD KEY `pickups_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `rebacks`
--
ALTER TABLE `rebacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rebacks_pickup_id_foreign` (`pickup_id`),
  ADD KEY `rebacks_way_id_foreign` (`way_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_client_id_foreign` (`client_id`);

--
-- Indexes for table `sender_gates`
--
ALTER TABLE `sender_gates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sender_postoffices`
--
ALTER TABLE `sender_postoffices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `townships`
--
ALTER TABLE `townships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_bank_id_foreign` (`bank_id`),
  ADD KEY `transactions_income_id_foreign` (`income_id`),
  ADD KEY `transactions_expense_id_foreign` (`expense_id`),
  ADD KEY `transactions_tobank_id_foreign` (`tobank_id`),
  ADD KEY `transactions_item_id_foreign` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ways`
--
ALTER TABLE `ways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ways_item_id_foreign` (`item_id`),
  ADD KEY `ways_delivery_man_id_foreign` (`delivery_man_id`),
  ADD KEY `ways_staff_id_foreign` (`staff_id`),
  ADD KEY `ways_status_id_foreign` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_man_township`
--
ALTER TABLE `delivery_man_township`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rebacks`
--
ALTER TABLE `rebacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sender_gates`
--
ALTER TABLE `sender_gates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sender_postoffices`
--
ALTER TABLE `sender_postoffices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `townships`
--
ALTER TABLE `townships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ways`
--
ALTER TABLE `ways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_township_id_foreign` FOREIGN KEY (`township_id`) REFERENCES `townships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_man_township`
--
ALTER TABLE `delivery_man_township`
  ADD CONSTRAINT `delivery_man_township_delivery_men_id_foreign` FOREIGN KEY (`delivery_men_id`) REFERENCES `delivery_men` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivery_man_township_township_id_foreign` FOREIGN KEY (`township_id`) REFERENCES `townships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD CONSTRAINT `delivery_men_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivery_men_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_expense_type_id_foreign` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_pickup_id_foreign` FOREIGN KEY (`pickup_id`) REFERENCES `pickups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomes_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomes_way_id_foreign` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_pickup_id_foreign` FOREIGN KEY (`pickup_id`) REFERENCES `pickups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_sender_gate_id_foreign` FOREIGN KEY (`sender_gate_id`) REFERENCES `sender_gates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_sender_postoffice_id_foreign` FOREIGN KEY (`sender_postoffice_id`) REFERENCES `sender_postoffices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_township_id_foreign` FOREIGN KEY (`township_id`) REFERENCES `townships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickups`
--
ALTER TABLE `pickups`
  ADD CONSTRAINT `pickups_delivery_man_id_foreign` FOREIGN KEY (`delivery_man_id`) REFERENCES `delivery_men` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickups_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickups_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rebacks`
--
ALTER TABLE `rebacks`
  ADD CONSTRAINT `rebacks_pickup_id_foreign` FOREIGN KEY (`pickup_id`) REFERENCES `pickups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rebacks_way_id_foreign` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `incomes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_tobank_id_foreign` FOREIGN KEY (`tobank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ways`
--
ALTER TABLE `ways`
  ADD CONSTRAINT `ways_delivery_man_id_foreign` FOREIGN KEY (`delivery_man_id`) REFERENCES `delivery_men` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ways_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ways_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ways_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
