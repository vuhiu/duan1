-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 03:26 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du_an_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 30, '2025-04-02 15:59:20', '2025-04-02 15:59:20'),
(6, 34, '2025-04-02 15:59:20', '2025-04-02 15:59:20'),
(7, 1, '2025-04-02 15:59:20', '2025-04-02 15:59:20'),
(8, 41, '2025-04-02 16:02:35', '2025-04-02 16:02:35'),
(9, 42, '2025-04-10 15:08:09', '2025-04-10 15:08:09'),
(10, 40, '2025-04-10 17:49:19', '2025-04-10 17:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` float NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(8, 8, 4, 1, 2, 0, '2025-04-02 16:04:25', '2025-04-02 16:04:25'),
(12, 9, 4, 1, 3, 0, '2025-04-10 15:54:23', '2025-04-11 00:09:50'),
(16, 9, 7, 11, 1, 0, '2025-04-11 00:11:23', '2025-04-11 00:11:23'),
(17, 9, 3, 8, 1, 0, '2025-04-11 00:16:43', '2025-04-11 00:16:43'),
(24, 10, 1, 9, 5, 6900000, '2025-04-11 02:31:42', '2025-04-11 03:10:27'),
(25, 10, 3, 27, 2, 29950000, '2025-04-11 02:33:09', '2025-04-11 02:39:05'),
(26, 10, 3, 8, 1, 27590000, '2025-04-11 02:38:50', '2025-04-11 02:38:50'),
(27, 10, 2, 21, 1, 27990000, '2025-04-11 03:14:02', '2025-04-11 03:14:02'),
(28, 10, 7, 25, 2, 99000, '2025-04-11 03:14:19', '2025-04-11 03:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('hidden','active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `status`, `image`, `description`, `created_at`, `updated_at`) VALUES
(14, 'Laptop', 'active', 'laptop.jpg', 'Mặt hàng laptop', NULL, NULL),
(34, 'iphone', 'active', 'apple.jpg', 'Sản phẩm iphone', NULL, NULL),
(35, 'phụ kiện ', 'active', 'phukien.jpg', 'sạc dự phòng, tai nghe, giá đỡ,...', NULL, NULL),
(36, 'SamSung', 'active', 'logo-samsung.jpg', 'Sản phẩm SamSung', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_type` enum('free shiping','percentage','fixed amount') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('hidden','active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coupon_value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `name`, `coupon_type`, `coupon_code`, `start_date`, `end_date`, `quantity`, `status`, `created_at`, `updated_at`, `coupon_value`) VALUES
(1, 'Voucher 10%', 'percentage', 'VOUCHER10', '2025-01-01', '2025-12-31', 100, 'active', '2025-03-30 18:33:55', '2025-03-30 18:33:55', 10),
(2, 'voucher 100k', 'fixed amount', 'ST100k', '2025-03-31', '2025-06-08', 20, 'active', NULL, NULL, 100),
(3, 'voucher20%', 'percentage', 'st20', '2025-04-11', '2025-04-18', 5, 'active', NULL, NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `order_detail_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `variant_id`, `order_detail_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 34, 1, 1, 12, 2, '2025-03-31 03:00:00', '2025-03-31 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` float NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `coupon_id` int NOT NULL,
  `shipping_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','shiping','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('unpaid','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `name`, `email`, `phone`, `address`, `amount`, `note`, `user_id`, `coupon_id`, `shipping_id`, `created_at`, `updated_at`, `payment_method`, `status`, `payment_status`) VALUES
(12, 'Nguyễn Văn Huy', 'nguyenvanhuy@gmail.com', 123456789, 'Hà Nội', 500000, 'Giao hàng nhanh', 34, 1, 1, '2025-03-31 03:00:00', '2025-03-31 03:00:00', 'cod', 'pending', 'unpaid'),
(13, 'Lê Văn Tuấn', 'levantuan@gmail.com', 987654321, 'Đà Nẵng', 1000000, 'Giao hàng hỏa tốc', 34, 1, 3, '2025-03-31 05:00:00', '2025-03-31 05:00:00', 'paypal', 'shiping', 'unpaid'),
(14, 'Phạm Thị Dung', 'phamthidung@gmail.com', 321654987, 'Hải Phòng', 200000, 'Giao hàng nhanh', 34, 1, 1, '2025-03-31 06:00:00', '2025-03-31 06:00:00', 'cod', 'delivered', 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `sale_price` float NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `image`, `price`, `sale_price`, `slug`, `description`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'iphone15', '67f63bbeb24e8-iphone15.jpg', 100000, 90000, 'iphone-15', 'Màn hình: 6.1 inch Dynamic Island, Super Retina XDR\r\nChip xử lý: A16 Bionic.\r\n\r\n', 1, 34, '2025-03-30 18:52:41', '2025-03-30 18:52:41'),
(2, 'iphone16', '67f5cc54ad006-iphone_16.jpg', 100000, 200000, '20000', 'iphone 16 pro', 1, 34, '2024-11-20 04:13:14', '2024-11-08 04:13:14'),
(3, ' MacBook Air 13 M3 2024', '67f5cc659e8f8-macbook_air.jpg', 100000, 200000, '20000', 'Kiểu dáng tinh tế, siêu mỏng và gọn gàng', 1, 14, '2024-11-20 04:13:14', '2024-11-08 04:13:14'),
(4, 'Samsung Galaxy A26', '67f5cc8e6b701-samsung_galaxy.jpg', 31000, 39000, 'Samsung-Galaxy-A26', 'Thiết kế mỏng gọn, thời trang', 1, 36, '2024-11-20 06:10:51', '2024-11-20 06:10:51'),
(6, 'MacBook Pro 14 M4', '67f67c7f30f8b-macbook_pro_14_m4.jpg', 12300000, 1220000, 'MacBook-Pro-14-M4', 'Sản phẩm đạt thời lượng pin lên đến 24 giờ trải nghiệm', 1, 14, NULL, NULL),
(7, 'Củ sạc nhanh 1 cổng 10.5W', '67f802320c72d-cu_sac_nhanh.jpg', 99000, 89000, 'Cu-sac-nhanh-10.5W', 'thiết kế nhỏ gọn và công suất 10.5W', 1, 35, NULL, NULL),
(8, 'Cáp USB A to Type C 1m Trusmi', '67f803c93a207-cap_usb_a_to_type_c.jpg', 100000, 89000, 'cap_usb_a_to_type_c_1m_trusmi', 'Hỗ trợ sạc nhanh và truyền dữ liệu ổn định', 1, 35, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_galleries`
--

CREATE TABLE `product_galleries` (
  `product_gallery_id` int NOT NULL,
  `product_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_galleries`
--

INSERT INTO `product_galleries` (`product_gallery_id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 4, 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:quality(100)/galaxy_s25_ultra_titan_black_1_5ffaab118c.png', NULL, NULL),
(2, 4, 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:quality(100)/galaxy_s25_ultra_titan_gray_1_e2fe9c0d57.png', NULL, NULL),
(3, 4, 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:quality(100)/galaxy_s25_ultra_titan_white_silver_1_e9f4db0fc4.png', NULL, NULL),
(4, 4, 'https://cdn2.fptshop.com.vn/unsafe/192x0/filters:quality(100)/galaxy_s25_ultra_titan_silver_blue_1_8225f9e1f4.png', NULL, NULL),
(5, 4, '674178e4d442d-text_ng_n_1__5_13.webp', NULL, NULL),
(6, 4, '674178e4d442d-text_ng_n_1__5_13.webp', NULL, NULL),
(7, 6, '674407ed031fb-67414316a953a-samsung-galaxy-s24-plus.webp', NULL, NULL),
(8, 6, '674407ed0508f-67414316ab01f-ss-s24-ultra-xam-222.webp', NULL, NULL),
(9, 6, '674407ed0ab21-674182668ce15-samsung-galaxy-s24-plus.webp', NULL, NULL),
(10, 6, '674407ed0bfb1-67418266905e2-ss-s24-ultra-xam-222.webp', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `product_variant_id` int NOT NULL,
  `price` float NOT NULL,
  `sale_price` float NOT NULL,
  `quantity` int NOT NULL,
  `product_id` int NOT NULL,
  `variant_color_id` int NOT NULL,
  `variant_size_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`product_variant_id`, `price`, `sale_price`, `quantity`, `product_id`, `variant_color_id`, `variant_size_id`, `created_at`, `updated_at`) VALUES
(1, 6000000, 4999000, 20, 4, 1, 1, NULL, NULL),
(7, 18000000, 16990000, 50, 2, 3, 2, NULL, NULL),
(8, 28000000, 27590000, 20, 3, 2, 2, NULL, NULL),
(9, 7500000, 6900000, 12, 1, 3, 2, NULL, NULL),
(10, 28000000, 25590000, 22, 6, 1, 2, NULL, NULL),
(11, 99000, 89000, 23, 7, 2, 3, NULL, NULL),
(12, 100000, 89000, 35, 8, 2, 4, NULL, NULL),
(15, 6100000, 4999000, 20, 4, 2, 1, NULL, NULL),
(16, 6200000, 4999000, 20, 4, 3, 1, NULL, NULL),
(17, 6900000, 5500000, 12, 4, 1, 2, NULL, NULL),
(18, 6900000, 5500000, 20, 4, 2, 2, NULL, NULL),
(19, 29000000, 27590000, 100, 2, 1, 2, NULL, NULL),
(20, 28500000, 26950000, 35, 2, 2, 2, NULL, NULL),
(21, 28900000, 27990000, 23, 2, 1, 5, NULL, NULL),
(22, 29900000, 279500000, 10, 2, 3, 6, NULL, NULL),
(25, 109000, 99000, 50, 7, 1, 3, NULL, NULL),
(26, 105000, 99000, 10, 8, 1, 7, NULL, NULL),
(27, 31000000, 29950000, 23, 3, 1, 6, NULL, NULL),
(28, 33000000, 31990000, 12, 3, 2, 6, NULL, NULL),
(29, 31000000, 29950000, 50, 6, 2, 5, NULL, NULL),
(30, 39000000, 37900000, 35, 6, 3, 6, NULL, NULL),
(31, 18000000, 16990000, 50, 1, 1, 5, NULL, NULL),
(32, 22000000, 20990000, 100, 1, 2, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int NOT NULL,
  `role_type` enum('Admin','Customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Customer', 'user', '2024-11-15 13:16:46', '2024-11-11 13:16:46'),
(2, 'Admin', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ships`
--

CREATE TABLE `ships` (
  `ship_id` int NOT NULL,
  `shipping_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_prices` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ships`
--

INSERT INTO `ships` (`ship_id`, `shipping_name`, `shipping_prices`, `created_at`, `updated_at`) VALUES
(1, 'Giao hàng tiết kiệm', 2000, NULL, NULL),
(2, 'Giao hàng hỏa tốc', 2400, NULL, NULL),
(3, 'Giao hàng nhanh', 34000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `render` enum('Nam','Nu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `avatar`, `address`, `email`, `phone`, `password`, `role_id`, `created_at`, `updated_at`, `render`, `active`) VALUES
(1, 'Nguyễn Văn Huy', NULL, 'Hà Nội', 'nguyenvanhuy@gmail.com', '033456789', 'password123', 1, '2025-03-30 18:32:27', '2025-03-30 18:32:27', NULL, NULL),
(3, 'Lê Văn Tuấn', NULL, 'Hà Nam', 'levantuan@gmail.com', '0356789123', 'password123', 1, '2025-03-30 18:32:27', '2025-03-30 18:32:27', NULL, NULL),
(4, 'Phạm Thị Dung', NULL, 'Nam Định', 'phamthidun@gmail.com', '0321654987', 'password123', 1, '2025-03-30 18:32:27', '2025-03-30 18:32:27', NULL, NULL),
(5, 'phuong', NULL, NULL, 'phuongnttph51657@gmail.com', '0329616649', '123456', NULL, NULL, NULL, NULL, NULL),
(26, 'Nguyễn Thị Giang', NULL, 'Hà Nam', 'Giangk3@gmail.com', '0978123666', '1234567', 1, NULL, NULL, NULL, NULL),
(27, 'Nguyễn Thị Thu Hương', NULL, 'Hưng Yên', 'huongnt73@gmail.com', '0325655888', '87654321', 1, NULL, NULL, NULL, NULL),
(28, 'test', NULL, 'Thái Bình', 'test@gmail.com', '0397307999', '1111111', 1, NULL, NULL, NULL, NULL),
(29, 'triển', NULL, 'Hà Nội', 'triennt@gmail.com', '0397307999', '11111111', 1, NULL, NULL, 'Nu', NULL),
(30, 'phuong', NULL, 'Đà Nẵng', 'a@gmail.com', '0329616649', '1234567', 1, NULL, NULL, 'Nam', NULL),
(31, 'Oanh', NULL, 'Nam Định', 'oanhng@gmail.com', '0397307686', '1234567', 1, NULL, NULL, NULL, NULL),
(32, 'Nguyễn Thị Quỳnh', 'z6070338498021_ceca527d453e6c3dafde55d76e920fed.jpg', 'Thái Bình', 'quynhng213@gmail.com', '0329616649', '123456', 1, NULL, NULL, NULL, 1),
(34, 'Đặng Quang Huy', NULL, 'Thái Bình', 'Huyy@gmail.com', '0338995444', '123456', 1, NULL, NULL, NULL, NULL),
(39, 'huyen', NULL, NULL, 'huyen@gmail.com', NULL, '$2y$10$b0M6uXAHDfMyOdwNldr8puXSrwIv85.UGzJ9nuaINR2ZoZeOZnn3S', 2, NULL, NULL, NULL, NULL),
(40, 'Oanh22', NULL, NULL, 'oanh22@gmail.com', NULL, '$2y$10$g2iF1cjpfmHE95sjkLJ.eO8IW2Q8H2MFCb40N1ZQjWEAVuXsJOJce', 2, NULL, NULL, NULL, NULL),
(41, 'quynhng', NULL, 'Hà Nội', 'quynhng@gmail.com', '0973984000', '$2y$10$M5N.LeON1kj/4zvM0J/hzOoEd904B.w4qQ.wJxP53ih1lT.zXwH4.', 1, NULL, NULL, NULL, NULL),
(42, 'Diệp', NULL, NULL, 'diep12@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variant_colors`
--

CREATE TABLE `variant_colors` (
  `variant_color_id` int NOT NULL,
  `color_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant_colors`
--

INSERT INTO `variant_colors` (`variant_color_id`, `color_code`, `color_name`, `created_at`, `updated_at`) VALUES
(1, '#000000', 'Đen', NULL, NULL),
(2, ' #FFFFFF', 'Trắng', NULL, NULL),
(3, '#FFC0CB', 'Hồng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variant_size`
--

CREATE TABLE `variant_size` (
  `variant_size_id` int NOT NULL,
  `size_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant_size`
--

INSERT INTO `variant_size` (`variant_size_id`, `size_name`, `created_at`, `updated_at`) VALUES
(1, '128GB', NULL, NULL),
(2, '256GB', NULL, NULL),
(3, '59 x 36 x 22 mm', NULL, NULL),
(4, '1m ', NULL, NULL),
(5, '512GB', NULL, NULL),
(6, '1TB', NULL, NULL),
(7, '2m', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_ibfk_1` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_ibfk_1` (`cart_id`),
  ADD KEY `cart_items_ibfk_2` (`product_id`),
  ADD KEY `cart_items_ibfk_3` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `order_detail_id` (`order_detail_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_id` (`shipping_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`product_gallery_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`product_variant_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_color_id` (`variant_color_id`),
  ADD KEY `variant_size_id` (`variant_size_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `ships`
--
ALTER TABLE `ships`
  ADD PRIMARY KEY (`ship_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `variant_colors`
--
ALTER TABLE `variant_colors`
  ADD PRIMARY KEY (`variant_color_id`);

--
-- Indexes for table `variant_size`
--
ALTER TABLE `variant_size`
  ADD PRIMARY KEY (`variant_size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `product_gallery_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `product_variant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ships`
--
ALTER TABLE `ships`
  MODIFY `ship_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `variant_colors`
--
ALTER TABLE `variant_colors`
  MODIFY `variant_color_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `variant_size`
--
ALTER TABLE `variant_size`
  MODIFY `variant_size_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`product_variant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`product_variant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`order_detail_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`shipping_id`) REFERENCES `ships` (`ship_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD CONSTRAINT `product_galleries_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`variant_color_id`) REFERENCES `variant_colors` (`variant_color_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`variant_size_id`) REFERENCES `variant_size` (`variant_size_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
