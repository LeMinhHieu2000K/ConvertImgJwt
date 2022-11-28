-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2022 lúc 08:19 AM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `convert`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `checkout_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `checkout`
--

INSERT INTO `checkout` (`id`, `user_id`, `bank_name`, `amount`, `checkout_date`, `created_at`, `updated_at`) VALUES
(1, 13, 'Momo', 10000, '2022-11-25 17:36:00', '2022-11-26 11:52:48', '2022-11-26 11:52:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `duck_image`
--

CREATE TABLE `duck_image` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `size_before` int(11) NOT NULL,
  `size_after` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `img`
--

CREATE TABLE `img` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `size` int(255) NOT NULL,
  `formatSize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `imgafter`
--

CREATE TABLE `imgafter` (
  `id` int(255) NOT NULL,
  `id_img` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `formatSizeBefore` varchar(255) NOT NULL,
  `formatSizeAfter` varchar(255) NOT NULL,
  `decleare` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `imgclient`
--

CREATE TABLE `imgclient` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2022_11_26_081906_create_jobs_table', 2),
(5, '2019_08_19_000000_create_failed_jobs_table', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `current_upload` int(11) DEFAULT 0,
  `limit_upload` int(11) DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `current_upload`, `limit_upload`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'DUck', 'cuongnew27@gmail.com', '0976947354', NULL, '$2y$10$vminadd4KQKstLgY5lqlz.1mVFGsMA9vogf/qfE2iAOmMm1HOsD1q', 0, 0, 0, NULL, '2022-11-25 02:27:00', '2022-11-25 02:27:00'),
(13, 'PTD', 'cuongnew37@gmail.com', '0976947354', NULL, '$2y$10$kCFMdoypZhYnIl0A5FODx.WaV5Gka6YHjjMIEkOFqm7GemRV/NBVu', 0, 0, 0, NULL, '2022-11-25 02:30:13', '2022-11-25 02:30:13'),
(15, 'Nguyen Van A', 'user01@gmail.com', '123456789', NULL, '$2y$10$g9JxVNCcgaBdAnPIJR4BaOtHl7jirZJczbTxFtniHoj2QA1a9cv6C', 1, 0, 0, NULL, '2022-11-27 07:00:05', '2022-11-27 07:00:05'),
(17, 'Nguyen Van A', 'nguyenvana@gmail.com', '09769473333', NULL, '$2y$10$ODxbylLlSz4cL89/dCFfYONKH7iYH3tVHDiAICsO4t1lAs8lkDebO', 1, 0, 0, NULL, '2022-11-27 11:39:10', '2022-11-27 11:39:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `verification_codes`
--

CREATE TABLE `verification_codes` (
  `id` int(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `verification_codes`
--

INSERT INTO `verification_codes` (`id`, `user_id`, `otp`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, 1, '947443', '2022-11-24 01:15:07', '2022-11-24 01:14:59', '2022-11-24 01:15:07'),
(2, 1, '739319', '2022-11-24 01:15:40', '2022-11-24 01:15:36', '2022-11-24 01:15:40'),
(3, 5, '496326', '2022-11-24 01:27:59', '2022-11-24 01:27:29', '2022-11-24 01:27:59'),
(4, 5, '601618', '2022-11-24 01:39:31', '2022-11-24 01:29:31', '2022-11-24 01:29:31'),
(5, 5, '773762', '2022-11-24 01:49:32', '2022-11-24 01:39:32', '2022-11-24 01:39:32'),
(6, 5, '589342', '2022-11-24 02:07:21', '2022-11-24 01:57:21', '2022-11-24 01:57:21'),
(7, 7, '864760', '2022-11-24 04:52:19', '2022-11-24 04:48:50', '2022-11-24 04:52:19'),
(8, 7, '156286', '2022-11-24 04:53:49', '2022-11-24 04:53:46', '2022-11-24 04:53:49'),
(9, 7, '396253', '2022-11-24 08:29:54', '2022-11-24 08:19:54', '2022-11-24 08:19:54'),
(10, 7, '726169', '2022-11-24 08:43:04', '2022-11-24 08:33:04', '2022-11-24 08:33:04'),
(11, 7, '324999', '2022-11-24 09:01:27', '2022-11-24 08:51:27', '2022-11-24 08:51:27'),
(12, 7, '534519', '2022-11-24 09:16:15', '2022-11-24 09:06:15', '2022-11-24 09:06:15'),
(13, 7, '926495', '2022-11-24 09:19:59', '2022-11-24 09:19:52', '2022-11-24 09:19:59'),
(14, 7, '180305', '2022-11-24 09:21:49', '2022-11-24 09:21:45', '2022-11-24 09:21:49'),
(15, 7, '535817', '2022-11-24 09:33:38', '2022-11-24 09:23:38', '2022-11-24 09:23:38'),
(16, 7, '989642', '2022-11-24 09:44:54', '2022-11-24 09:35:39', '2022-11-24 09:44:54'),
(17, 7, '318280', '2022-11-24 09:49:49', '2022-11-24 09:49:45', '2022-11-24 09:49:49'),
(18, 7, '958685', '2022-11-24 10:05:00', '2022-11-24 09:55:00', '2022-11-24 09:55:00'),
(19, 7, '851200', '2022-11-24 10:17:23', '2022-11-24 10:07:23', '2022-11-24 10:07:23'),
(20, 7, '364502', '2022-11-24 10:53:08', '2022-11-24 10:48:33', '2022-11-24 10:53:08'),
(21, 7, '357491', '2022-11-24 10:54:57', '2022-11-24 10:54:53', '2022-11-24 10:54:57'),
(22, 7, '159718', '2022-11-24 10:55:50', '2022-11-24 10:55:47', '2022-11-24 10:55:50'),
(23, 7, '892672', '2022-11-24 10:56:59', '2022-11-24 10:56:55', '2022-11-24 10:56:59'),
(24, 7, '397063', '2022-11-24 10:59:10', '2022-11-24 10:59:06', '2022-11-24 10:59:10'),
(25, 7, '451296', '2022-11-24 19:01:03', '2022-11-24 18:55:29', '2022-11-24 19:01:03'),
(26, 7, '615546', '2022-11-24 19:15:34', '2022-11-24 19:15:30', '2022-11-24 19:15:34');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `duck_image`
--
ALTER TABLE `duck_image`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `imgafter`
--
ALTER TABLE `imgafter`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `imgclient`
--
ALTER TABLE `imgclient`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `duck_image`
--
ALTER TABLE `duck_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `img`
--
ALTER TABLE `img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=534;

--
-- AUTO_INCREMENT cho bảng `imgafter`
--
ALTER TABLE `imgafter`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT cho bảng `imgclient`
--
ALTER TABLE `imgclient`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
