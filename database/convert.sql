-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 01, 2022 lúc 10:43 AM
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

--
-- Đang đổ dữ liệu cho bảng `duck_image`
--

INSERT INTO `duck_image` (`id`, `name`, `user_id`, `size_before`, `size_after`, `created_at`, `updated_at`) VALUES
(81, '144565_28112022_ASCzFKC.webp', 13, 1378395, 153900, '2022-11-28 02:48:39', '2022-11-28 02:48:45'),
(82, '714834_28112022_VdXh3nD.webp', 13, 4112621, 309900, '2022-11-28 02:48:42', '2022-11-28 02:48:48'),
(83, 'Gearvn_Anime-P12_-20-1536x960_28112022_UYoquwc.webp', 13, 193525, 114842, '2022-11-28 02:48:42', '2022-11-28 02:48:51'),
(84, 'Thành phố Cyberpunk_ (21)_28112022_qK9lRnb.webp', 13, 5433691, 2083764, '2022-11-28 02:48:43', '2022-11-28 02:48:59'),
(85, 't-5-bbbbb_28112022_t9yEozO.webp', 13, 609783, 261302, '2022-11-28 02:48:44', '2022-11-28 02:49:01'),
(86, '1186318_28112022_oVCtrPy.webp', 13, 1871360, 469658, '2022-11-28 02:48:45', '2022-11-28 02:49:06'),
(87, '294213_28112022_BfY8qNs.webp', 13, 498688, 236180, '2022-11-28 02:48:46', '2022-11-28 02:49:09'),
(88, '545909_28112022_TdPoa6P.webp', 13, 396042, 45352, '2022-11-28 02:48:46', '2022-11-28 02:49:12'),
(89, 'image-01_28112022_7iUQmEY.webp', 13, 382063, 202842, '2022-11-28 02:48:47', '2022-11-28 02:49:17'),
(90, 'image-02_28112022_qRpaMak.webp', 13, 2061488, 463398, '2022-11-28 02:48:48', '2022-11-28 02:49:22'),
(91, '163496_28112022_hkD2dcL.webp', 13, 1572331, 276388, '2022-11-28 02:52:09', '2022-11-28 02:52:13'),
(92, '177329_28112022_72eTCC2.webp', 13, 319535, 64552, '2022-11-28 02:52:10', '2022-11-28 02:52:15'),
(93, '294213_28112022_pQSBpnM.webp', 13, 498688, 225988, '2022-11-28 02:52:12', '2022-11-28 02:52:18'),
(94, '144565_28112022_aU61cqn.webp', 13, 1378395, 149534, '2022-11-28 02:52:13', '2022-11-28 02:52:20'),
(95, '545909_28112022_40vR8Bl.webp', 13, 396042, 44852, '2022-11-28 02:52:14', '2022-11-28 02:52:22'),
(96, 'AutoVina_29112022_yX2RzpQ.webp', 13, 1378395, 153900, '2022-11-28 20:03:26', '2022-11-28 20:03:32'),
(97, 'AutoVina_29112022_AJAST57.webp', 13, 4112621, 309900, '2022-11-28 20:03:28', '2022-11-28 20:03:35'),
(98, 'AutoVina_29112022_B1q3sO0.webp', 13, 193525, 114842, '2022-11-28 20:03:28', '2022-11-28 20:03:37'),
(99, 'AutoVina_29112022_vS1rJEC.webp', 13, 5433691, 2083764, '2022-11-28 20:03:29', '2022-11-28 20:03:45'),
(100, 'AutoVina_29112022_qQKPXwi.webp', 13, 609783, 261302, '2022-11-28 20:03:30', '2022-11-28 20:03:50'),
(101, 'AutoVina_29112022_KilWSde.webp', 13, 1871360, 469658, '2022-11-28 20:03:32', '2022-11-28 20:03:56'),
(102, 'AutoVina_29112022_x4Zwbr6.webp', 13, 498688, 236180, '2022-11-28 20:03:32', '2022-11-28 20:03:58'),
(103, 'AutoVina_29112022_6SEftVZ.webp', 13, 396042, 45352, '2022-11-28 20:03:33', '2022-11-28 20:04:03'),
(104, 'AutoVina_29112022_x2xDiNV.webp', 13, 382063, 202842, '2022-11-28 20:03:33', '2022-11-28 20:04:06'),
(105, 'AutoVina_29112022_QUsSmMp.webp', 13, 2061488, 463398, '2022-11-28 20:03:34', '2022-11-28 20:04:14');

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
(5, '2019_08_19_000000_create_failed_jobs_table', 3),
(6, '2022_11_29_042859_create_sessions_table', 4),
(7, '2022_11_29_080707_create_tokens_table', 5);

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
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify` tinyint(4) NOT NULL DEFAULT 0,
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `otp`, `verify`, `expire_at`, `created_at`, `updated_at`) VALUES
(54, 13, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hZGIxLTExNy02LTg2LTIuYXAubmdyb2suaW9cL2FwaVwvbG9naW4iLCJpYXQiOjE2Njk4NzkzMzMsImV4cCI6MTY3MTM5MTMzMywibmJmIjoxNjY5ODc5MzMzLCJqdGkiOiJneXNZTW5iYXN4NHV5OEFPIiwic3ViIjoxMywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsImhzdCI6IjRjYTg5ZWIyYTU5NWVlNTVlNzVjNzJlNWIxYzk2ZmI4IiwiaXBhIjoiZjUyODc2NGQ2MjRkYjEyOWIzMmMyMWZiY2EwY2I4ZDYiLCJ1cmEiOiI1ZmMwZTVjMGI0ZTJhZDQ2OGVjOWE0ODNkOGNhOGI1YiJ9.IFpD5LDA9nkE6wLPTwLVr2lvschWVckpVVbhLnY5JDU', '914958', 1, '2022-12-01 00:23:50', '2022-12-01 00:22:13', '2022-12-01 00:23:50'),
(55, 13, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hZGIxLTExNy02LTg2LTIuYXAubmdyb2suaW9cL2FwaVwvbG9naW4iLCJpYXQiOjE2Njk4ODIzNTQsImV4cCI6MTY3MTM5NDM1NCwibmJmIjoxNjY5ODgyMzU0LCJqdGkiOiJzYUx1Rjg3MWl2M2tTNllnIiwic3ViIjoxMywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsImhzdCI6IjRjYTg5ZWIyYTU5NWVlNTVlNzVjNzJlNWIxYzk2ZmI4IiwiaXBhIjoiZjUyODc2NGQ2MjRkYjEyOWIzMmMyMWZiY2EwY2I4ZDYiLCJ1cmEiOiI4ZDNmZWMyNTgxZDM5NjFmMzAzNzg1MWQ1Y2MwMDM5YyJ9.WjP5OyN9I0xeZJkztgeraxp_uj8RMRlZxSe0jhk9Y74', '512399', 0, '2022-12-01 01:22:34', '2022-12-01 01:12:34', '2022-12-01 01:12:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'company',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) DEFAULT 1,
  `current_upload` int(11) DEFAULT 0,
  `limit_upload` int(11) DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `company`, `email_verified_at`, `password`, `role`, `current_upload`, `limit_upload`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'DUck', 'cuongnew27@gmail.com', '0976947354', 'AutoVina', NULL, '$2y$10$vminadd4KQKstLgY5lqlz.1mVFGsMA9vogf/qfE2iAOmMm1HOsD1q', 0, 0, 0, NULL, '2022-11-25 02:27:00', '2022-11-25 02:27:00'),
(13, 'PTD', 'cuongnew37@gmail.com', '0976947354', 'AutoVina', NULL, '$2y$10$kCFMdoypZhYnIl0A5FODx.WaV5Gka6YHjjMIEkOFqm7GemRV/NBVu', 0, 0, 0, NULL, '2022-11-25 02:30:13', '2022-11-25 02:30:13'),
(15, 'Nguyen Van A', 'user01@gmail.com', '123456789', 'AutoVina', NULL, '$2y$10$g9JxVNCcgaBdAnPIJR4BaOtHl7jirZJczbTxFtniHoj2QA1a9cv6C', 1, 0, 0, NULL, '2022-11-27 07:00:05', '2022-11-27 07:00:05'),
(17, 'Nguyen Van A', 'nguyenvana@gmail.com', '09769473333', 'AutoVina', NULL, '$2y$10$ODxbylLlSz4cL89/dCFfYONKH7iYH3tVHDiAICsO4t1lAs8lkDebO', 1, 0, 0, NULL, '2022-11-27 11:39:10', '2022-11-27 11:39:10'),
(18, 'PTD', 'cuongnew37123@gmail.com', '0976947354', 'AutoVina', NULL, '$2y$10$w2JzYWKddP2ejFjoCm3cEOm1y3TlcwPU2uPDPJLgU1e55E.VpDoUS', 0, 0, 0, NULL, '2022-11-28 19:31:34', '2022-11-28 19:31:34'),
(19, 'PTD', 'cuongnew141123@gmail.com', '0976947354', 'AutoVina', NULL, '$2y$10$g.oGoYcyAA3YpaD3zPP1Ce8DgoXNAvM7X8l2Llbwf.J32U/dD0OHG', 0, 0, 0, NULL, '2022-11-28 19:38:00', '2022-11-28 19:38:00'),
(20, 'PTD', 'cuongnew141122223@gmail.com', '0976947354', 'AutoVina', NULL, '$2y$10$cedGVmpy7.wvCwWo2U7pDOptcaxI3xCrueq5vJljIhc1AtWE.EDTe', 1, 0, 0, NULL, '2022-11-28 19:52:33', '2022-11-28 19:52:33');

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
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
