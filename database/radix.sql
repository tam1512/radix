-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 01, 2024 lúc 11:04 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `radix`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT 0,
  `content` text DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `thumbnail` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duplicate` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `user_id`, `category_id`, `content`, `view_count`, `thumbnail`, `description`, `duplicate`, `create_at`, `update_at`) VALUES
(1, 'Cách nắm bắt ngôn ngữ Javascript', 'cach-nam-bat-ngon-ngu-javascript', 1, 6, '&#60;p&#62;&#60;img alt=&#34;&#34; src=&#34;/PHP/PHP_co_ban/module05/radix/uploads/images/OIP.jpg&#34; style=&#34;height:180px; width:278px&#34; /&#62;&#60;/p&#62;&#13;&#10;', 20000, '/PHP/PHP_co_ban/module05/radix/uploads/images/OIP.jpg', '', 1, '2023-10-30 11:52:37', '2023-10-30 13:44:18'),
(2, 'Tổng quan về lập trình ABAP', 'tong-quan-ve-lap-trinh-abap', 1, 6, '&#60;p&#62;&#60;img alt=&#34;&#34; src=&#34;/PHP/PHP_co_ban/module05/radix/uploads/images/unnamed.png&#34; style=&#34;height:30px; width:61px&#34; /&#62;&#60;/p&#62;&#13;&#10;', 0, '/PHP/PHP_co_ban/module05/radix/uploads/images/unnamed.png', 'a', 1, '2023-10-30 13:39:39', NULL),
(4, 'Tổng quan về lập trình ABAP(1)', 'tong-quan-ve-lap-trinh-abap1', 1, 6, '&#60;p&#62;&#60;img alt=&#34;&#34; src=&#34;/PHP/PHP_co_ban/module05/radix/uploads/images/unnamed.png&#34; style=&#34;height:30px; width:61px&#34; /&#62;&#60;/p&#62;&#13;&#10;', 0, '/PHP/PHP_co_ban/module05/radix/uploads/images/unnamed.png', 'a', 0, '2023-10-30 13:48:06', NULL),
(5, 'Cách nắm bắt ngôn ngữ Javascript(1)', 'cach-nam-bat-ngon-ngu-javascript1', 1, 6, '&#60;p&#62;&#60;img alt=&#34;&#34; src=&#34;/PHP/PHP_co_ban/module05/radix/uploads/images/OIP.jpg&#34; style=&#34;height:180px; width:278px&#34; /&#62;&#60;/p&#62;&#13;&#10;', 0, '/PHP/PHP_co_ban/module05/radix/uploads/images/OIP.jpg', '', 0, '2023-10-30 13:48:11', NULL),
(6, 'blog 1', 'blog-1', 1, 3, '&#60;p&#62;s&#60;/p&#62;&#13;&#10;', 0, '/PHP/PHP_co_ban/module05/radix/uploads/images/logo-kim-duc.png', '', 1, '2023-11-01 15:39:12', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(1, 'Tư vấn website', 'tu-van-website', 1, 0, '2023-10-27 17:00:47', '2023-10-30 13:27:45'),
(3, 'tư vấn sản phẩm', 'tu-van-san-pham', 1, 1, '2023-10-30 10:52:13', NULL),
(4, 'tư vấn sản phẩm(1)', 'tu-van-san-pham1', 1, 1, '2023-10-30 10:56:22', NULL),
(5, 'tư vấn sản phẩm(1)(1)', 'tu-van-san-pham11', 1, 0, '2023-10-30 10:56:32', NULL),
(6, 'Ngôn ngữ, công nghệ', 'ngon-ngu-cong-nghe', 1, 0, '2023-10-30 13:33:39', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `blog_id` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 0 COMMENT '0: chưa duyệt - 1: được duyệt',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT 0,
  `message` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1: Chưa xử lý; 2: Đang xử lý; 3: Đã xử lý',
  `note` text DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `fullname`, `email`, `department_id`, `message`, `status`, `note`, `create_at`, `update_at`) VALUES
(2, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', 3, 'Tôi muốn xây dựng website cho công ty của tôi', 1, 'Khách hàng muốn xây dựng một website bán hàng về quần áo', '2023-11-20 15:10:41', '2023-11-21 11:50:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `name`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(2, 'Kinh doanh', 1, 0, '2023-11-20 13:26:13', NULL),
(3, 'IT', 1, 1, '2023-11-20 13:33:47', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `groups`
--

INSERT INTO `groups` (`id`, `name`, `permission`, `create_at`, `update_at`) VALUES
(1, 'Super Admin', 'dsafđf', '2023-10-01 16:30:49', '2023-10-02 00:35:17'),
(2, 'Admin', NULL, '2023-10-01 16:30:49', NULL),
(3, 'Manager', NULL, '2023-10-01 16:30:49', NULL),
(6, 'admin user', '1', '2023-10-02 00:47:02', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_token`
--

CREATE TABLE `login_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `token` varchar(100) DEFAULT NULL COMMENT 'token đăng nhập của quản trị viên',
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `login_token`
--

INSERT INTO `login_token` (`id`, `user_id`, `token`, `create_at`) VALUES
(161, 1, 'd07c26b8558e4587eda48bbcd8453f16f5895117', '2024-03-01 16:34:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `opt_key` varchar(100) DEFAULT NULL,
  `opt_value` text DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `upload` tinyint(4) DEFAULT 0 COMMENT '0: input\r\n1: có upload file\r\n2: textarea\r\n3: textarea + editor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `options`
--

INSERT INTO `options` (`id`, `opt_key`, `opt_value`, `name`, `upload`) VALUES
(1, 'header_hotline', '+(84) 396371031', 'Hotline', 0),
(2, 'header_email', 'tamtt1512@gmail.com', 'Email', 0),
(3, 'header_time', '09am - 05pm', 'Thời gian làm việc', 0),
(5, 'header_placeholder_search', 'Nhập từ khóa tìm kiếm', 'Placeholder tìm kiếm header', 0),
(6, 'header_facebook', 'https://www.facebook.com/tamtt1512/', 'Facebook', 0),
(7, 'header_twitter', 'https://twitter.com/tamtt1512', 'Twitter', 0),
(8, 'header_linkedin', 'https://www.linkedin.com/in/tamtt1512/', 'Linkedin', 0),
(9, 'header_behance', 'https://www.behance.net/tamtt1512', 'Behance', 0),
(10, 'header_youtube', 'https://youtube.com/@tamtt1512', 'Youtube', 0),
(11, 'header_quote_text', 'Nhận báo giá', 'Nút báo giá', 0),
(12, 'header_quote_link', '#', 'Link báo giá', 0),
(13, 'general_logo', 'http://radix.local/uploads/images/logo/logo.png', 'Logo\r\n', 1),
(15, 'general_name_site', 'Radix', 'Tên trang web (< 6 ký tự)\r\n', 0),
(16, 'general_favicon', 'http://radix.local/uploads/images/favicon/favicon.png', 'Favicon\r\n', 1),
(17, 'home_slide', '[{\"slider_title\":\"Radix &#60;span&#62;Business&#60;\\/span&#62; World That Possible anything&#60;span&#62;!&#60;\\/span&#62;\",\"slider_btn\":\"Our Portfolio\",\"slider_btn_link\":\"#\",\"slider_youtube_link\":\"#\",\"slider_image_1\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image1.jpg\",\"slider_image_2\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image2.jpg\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image1.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"left\"},{\"slider_title\":\"Radix &#60;span&#62;Business&#60;\\/span&#62; World That Possible anything&#60;span&#62;!&#60;\\/span&#62;\",\"slider_btn\":\"Our Services\",\"slider_btn_link\":\"#\",\"slider_youtube_link\":\"#\",\"slider_image_1\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image1.jpg\",\"slider_image_2\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image2.jpg\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image2.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"right\"},{\"slider_title\":\"Build your website with Radix Multipurpose   &#60;span&#62;Business&#60;\\/span&#62; Template.\",\"slider_btn\":\"About Company\",\"slider_btn_link\":\"#\",\"slider_youtube_link\":\"#\",\"slider_image_1\":\"#\",\"slider_image_2\":\"#\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image1.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"center\"}]', 'Slider', 0),
(18, 'home_about', '{\"about_title_bg\":\"Radix\",\"about_title\":\"About Company\",\"about_desc\":\"&#60;p&#62;contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old&#60;\\/p&#62;&#13;&#10;\",\"about_image\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-4.jpg\",\"about_youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=E-2ocmhF6TA\",\"about_content\":\"&#60;h2&#62;&#60;strong&#62;We Are Professional Website Design &#38;amp; Development Company!&#60;\\/strong&#62;&#60;\\/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. You think water moves fast? You should see ice.&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a weeked do incididunt magna Lorem&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalancip isicing elit, sed do eiusmod tempor incididunt&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;div class=&#34;ddict_div&#34; style=&#34;left:49.4844px; max-width:550.969px; top:47px&#34;&#62;&#60;img class=&#34;ddict_audio&#34; src=&#34;chrome-extension:\\/\\/bpggmmljdiliancllaapiggllnkbjocb\\/img\\/audio.png&#34; \\/&#62;&#13;&#10;&#60;p&#62;Ch&#38;uacute;ng t&#38;ocirc;i l&#38;agrave; c&#38;ocirc;ng ty thi\\u1ebft k\\u1ebf v&#38;agrave; ph&#38;aacute;t tri\\u1ec3n trang web chuy&#38;ecirc;n nghi\\u1ec7p!&#60;\\/p&#62;&#13;&#10;&#60;\\/div&#62;&#13;&#10;\",\"about_progress_name\":[\"Communication\",\"Business Develop\",\"Creative Work\",\"Bootstrap 4\"],\"progress-range\":[\"78\",\"80\",\"90\",\"95\"]}', 'Thiết lập giới thiệu', 0),
(19, 'home_services_title-bg', 'Services', 'Tiêu đề nền', 0),
(20, 'home_services_title', 'What We Provide', 'Tiêu đề', 0),
(21, 'home_services_content', '&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(22, 'home_facts', '{\"facts_title_sub\":\"Our Achievements\",\"facts_title\":\"With Smooth Animation Numbering\",\"facts_desc\":\"&#60;p&#62;Pellentesque vitae gravida nulla. Maecenas molestie ligula quis urna viverra venenatis. Donec at ex metus. Suspendisse ac est et magna viverra eleifend. Etiam varius auctor est eu eleifend.&#60;\\/p&#62;&#13;&#10;\",\"facts_button_title\":\"CONTACT US\",\"facts_button_link\":\"#\",\"facts_item_desc\":[\"Years Of Success\",\"Project Complete\",\"Total Earnings\",\"Winning Awards\"],\"facts_item_icon\":[\"&#60;i class=&#34;fa fa-clock-o&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-bullseye&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-dollar&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-trophy&#34;&#62;&#60;\\/i&#62;\"],\"facts_item_number\":[\"35\",\"88\",\"10\",\"32\"],\"facts_item_unit\":[\"\",\"K\",\"M\",\"\"]}', 'Thiết lập thành tựu', 0),
(27, 'home_portfolios_title-bg', 'Projects', 'Tiêu đề nền', 0),
(28, 'home_portfolios_title', 'Our Portfolio', 'Tiêu đề', 0),
(29, 'home_portfolios_content', '&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(30, 'home_portfolios_btn', 'MORE PORTFOLIO', 'Nội dung nút', 0),
(31, 'home_portfolios_btn_link', '#', 'Link nút', 0),
(32, 'home_cta_content', '&#60;h2&#62;We Have 35+ Years Of Experiences For Creating Creative Website Project.&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim feugiat, facilisis arcu vehicula, consequat sem. Cras et vulputate nisi, ac dignissim mi. Etiam laoreet&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(33, 'home_cta_btn', 'BUY THIS THEME', 'Nội dung nút', 0),
(34, 'home_cta_btn_link', '#', 'Link nút', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(1, 'Hướng dẫn thanh toán', 'huong-dan-thanh-toan', NULL, 1, 0, '2023-10-07 16:48:44', NULL),
(2, 'Phương thức thanh toán', 'phuong-thuc-thanh-toan', NULL, 3, 0, '2023-10-07 16:48:44', NULL),
(3, 'Phương thức liên hệ', 'phuong-thuc-lien-he', NULL, 1, 0, '2023-10-07 17:00:00', NULL),
(4, 'Về chúng tôi', 've-chung-toi', NULL, 3, 0, '2023-10-07 16:48:44', NULL),
(8, 'Chương trình khuyến mãi', 'chuong-trinh-khuyen-mai', '&#60;h1&#62;Chương tr&#38;igrave;nh khuyến m&#38;atilde;i&#60;/h1&#62;&#13;&#10;', 1, 0, '2023-10-07 17:59:02', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `thumbnail` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `duplicate` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `portfolios`
--

INSERT INTO `portfolios` (`id`, `name`, `slug`, `thumbnail`, `description`, `video`, `content`, `user_id`, `create_at`, `update_at`, `duplicate`) VALUES
(15, 'Creative Work', 'creative-work', 'http://radix.local/uploads/images/portfolio/p1.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;What is Lorem Ipsum?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#60;strong&#62;Lorem Ipsum&#60;/strong&#62;&#38;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#38;#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 16:06:54', '2024-03-01 16:35:03', 0),
(16, 'Responsive Design', 'responsive-design', 'http://radix.local/uploads/images/portfolio/p2.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;Why do we use it?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#38;#39;Content here, content here&#38;#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#38;#39;lorem ipsum&#38;#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 23:29:43', NULL, 0),
(17, 'Bootstrap Based', 'bootstrap-based', 'http://radix.local/uploads/images/portfolio/p3.jpg', 'Bootstrap Based&#13;&#10;Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;Why do we use it?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#38;#39;Content here, content here&#38;#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#38;#39;lorem ipsum&#38;#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 23:31:52', NULL, 0),
(18, 'Clean Design', 'clean-design', 'http://radix.local/uploads/images/portfolio/p4.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;Why do we use it?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#38;#39;Content here, content here&#38;#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#38;#39;lorem ipsum&#38;#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 23:48:02', NULL, 0),
(19, 'Animation', 'animation', 'http://radix.local/uploads/images/portfolio/p5.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;Why do we use it?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#38;#39;Content here, content here&#38;#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#38;#39;lorem ipsum&#38;#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 23:49:12', NULL, 0),
(20, 'Parallax', 'parallax', 'http://radix.local/uploads/images/portfolio/p6.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;Why do we use it?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#38;#39;Content here, content here&#38;#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#38;#39;lorem ipsum&#38;#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 23:50:03', '2024-03-01 00:08:54', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `portfolio_categories`
--

CREATE TABLE `portfolio_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `portfolio_categories`
--

INSERT INTO `portfolio_categories` (`id`, `name`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(23, 'ANIMATION', 1, 0, '2024-02-28 21:01:49', NULL),
(25, 'WEBSITE', 1, 0, '2024-02-28 21:02:00', NULL),
(26, 'PACKAGE', 1, 0, '2024-02-28 21:02:08', NULL),
(27, 'DEVELOPMENT', 1, 0, '2024-02-28 21:02:22', NULL),
(28, 'PRINTING', 1, 1, '2024-02-28 21:02:31', '2024-02-29 16:27:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `portfolio_category_mapping`
--

CREATE TABLE `portfolio_category_mapping` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `portfolio_category_mapping`
--

INSERT INTO `portfolio_category_mapping` (`id`, `portfolio_id`, `category_id`, `user_id`, `create_at`) VALUES
(4, 16, 25, 1, '2024-02-29 23:29:43'),
(5, 16, 26, 1, '2024-02-29 23:29:43'),
(6, 17, 23, 1, '2024-02-29 23:31:52'),
(7, 17, 25, 1, '2024-02-29 23:31:52'),
(8, 18, 27, 1, '2024-02-29 23:48:02'),
(9, 18, 28, 1, '2024-02-29 23:48:02'),
(10, 19, 26, 1, '2024-02-29 23:49:12'),
(11, 19, 27, 1, '2024-02-29 23:49:12'),
(17, 20, 23, 1, '2024-03-01 00:08:54'),
(18, 20, 25, 1, '2024-03-01 00:08:54'),
(19, 20, 28, 1, '2024-03-01 00:08:54'),
(22, 15, 23, 1, '2024-03-01 16:35:03'),
(23, 15, 25, 1, '2024-03-01 16:35:03'),
(24, 15, 28, 1, '2024-03-01 16:35:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `portfolio_images`
--

CREATE TABLE `portfolio_images` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) DEFAULT 0,
  `image` varchar(150) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `name`, `slug`, `icon`, `description`, `content`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(65, 'Consulting', 'consulting', '&#60;i class=&#34;fa fa-magic&#34;&#62;&#60;/i&#62;', 'welcome to our consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 3, '2024-02-28 17:19:24', NULL),
(66, 'Creative Idea', 'creative-idea', '&#60;i class=&#34;fa fa-lightbulb-o&#34;&#62;&#60;/i&#62;', 'Creative and erat, porta non porttitor non, dignissim et enim Aenean ac enim feugiat classical Latin', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 0, '2024-02-28 17:33:36', '2024-02-28 17:34:39'),
(67, 'Development', 'development', '&#60;i class=&#34;fa fa-wordpress&#34;&#62;&#60;/i&#62;', 'just fine erat, porta non porttitor non, dignissim et enim Aenean ac enim feugiat classical Latin', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 0, '2024-02-28 17:34:44', '2024-02-28 17:35:19'),
(68, 'Marketing', 'marketing', '&#60;i class=&#34;fa fa-bullhorn&#34;&#62;&#60;/i&#62;', 'Possible of erat, porta non porttitor non, dignissim et enim Aenean ac enim feugiat classical Latin', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 1, '2024-02-28 17:35:22', '2024-02-28 17:35:55'),
(69, 'Direct Work', 'direct-work', '&#60;i class=&#34;fa fa-bullseye&#34;&#62;&#60;/i&#62;', 'Everything ien erat, porta non porttitor non, dignissim et enim Aenean ac enim feugiat Latin', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 1, '2024-02-28 17:36:18', '2024-02-28 17:37:45'),
(70, 'Creative Plan', 'creative-plan', '&#60;i class=&#34;fa fa-cube&#34;&#62;&#60;/i&#62;', 'Information sapien erat, non porttitor non, dignissim et enim Aenean ac enim feugiat classical Latin', '&#60;p&#62;none&#60;/p&#62;&#13;&#10;', 1, 0, '2024-02-28 17:37:50', '2024-02-28 17:38:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0: chưa xử lý - 1: đang xử lý - 2: đã xử lý',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `about_content` text DEFAULT NULL,
  `contact_facebook` varchar(100) DEFAULT NULL,
  `contact_twitter` varchar(100) DEFAULT NULL,
  `contact_linkedin` varchar(100) DEFAULT NULL,
  `contact_printerest` varchar(100) DEFAULT NULL,
  `forget_token` varchar(100) DEFAULT NULL COMMENT 'token quên mật khẩu',
  `group_id` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 0 COMMENT '0: chưa kích hoạt - 1: kích hoạt',
  `last_activity` datetime DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `about_content`, `contact_facebook`, `contact_twitter`, `contact_linkedin`, `contact_printerest`, `forget_token`, `group_id`, `status`, `last_activity`, `create_at`, `update_at`) VALUES
(1, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, '60b80700fe4a61b0ecb1c876ed56774b8a9ee18c', 1, 1, '2024-03-01 16:58:38', NULL, '2023-10-02 16:56:53'),
(3, 'Nguyễn Thị Thùy Linh', 'nptlinh130401@gmail.com', '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07'),
(4, 'Tôn Thành a', 'att1512@gmail.com', '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(5, 'Nguyễn Thị Thùy a', 'npta130401@gmail.com', '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07'),
(6, 'Tôn Thành b', 'btt1512@gmail.com', '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(7, 'Nguyễn Thị Thùy b', 'blinh130401@gmail.com', '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07'),
(8, 'Tôn Thành c', 'ctt1512@gmail.com', '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(9, 'Nguyễn Thị Thùy c', 'nptc\r\n130401@gmail.com', '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `login_token`
--
ALTER TABLE `login_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `portfolio_categories`
--
ALTER TABLE `portfolio_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `portfolio_category_mapping`
--
ALTER TABLE `portfolio_category_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `portfolio_images`
--
ALTER TABLE `portfolio_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT cho bảng `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `portfolio_categories`
--
ALTER TABLE `portfolio_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `portfolio_category_mapping`
--
ALTER TABLE `portfolio_category_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `portfolio_images`
--
ALTER TABLE `portfolio_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`);

--
-- Các ràng buộc cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Các ràng buộc cho bảng `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `login_token`
--
ALTER TABLE `login_token`
  ADD CONSTRAINT `login_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `portfolio_categories`
--
ALTER TABLE `portfolio_categories`
  ADD CONSTRAINT `portfolio_categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `portfolio_category_mapping`
--
ALTER TABLE `portfolio_category_mapping`
  ADD CONSTRAINT `portfolio_category_mapping_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`),
  ADD CONSTRAINT `portfolio_category_mapping_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `portfolio_categories` (`id`),
  ADD CONSTRAINT `portfolio_category_mapping_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `portfolio_images`
--
ALTER TABLE `portfolio_images`
  ADD CONSTRAINT `portfolio_images_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`);

--
-- Các ràng buộc cho bảng `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
