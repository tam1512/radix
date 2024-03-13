-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 12, 2024 lúc 12:58 PM
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
(8, 'How to grow your business with blank table!', 'how-to-grow-your-business-with-blank-table', 3, 8, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 492, 'http://radix.local/uploads/images/blog/blog5.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 2, '2024-03-01 18:06:59', NULL),
(9, '10 ways to improve your startup Business', '10-ways-to-improve-your-startup-business', 1, 7, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 30, 'http://radix.local/uploads/images/blog/blog6.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 2, '2024-03-01 18:07:16', '2024-03-01 18:07:45'),
(10, 'Recognizing the need is the primary', 'recognizing-the-need-is-the-primary', 1, 8, '&#60;p&#62;dolor sit amet, consectetur adipiscing elit. Fusce porttitor tristique mi, sed rhoncus sapien mollis vitae. Pellentesque at mauris neque. Vestibulum pulvinar ac sagittis ex consectetur sed. Ut viverra elementum libero, nec tincidunt orci vehicula quis. Vivamus vehicula quis&#38;nbsp;&#60;strong&#62;Lorem ipsum&#60;/strong&#62;&#38;nbsp;nunc quis rutrum. Aliquam consectetur dapibus tortor, blandit lobortis erat dictum sed. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed vitae quam dolor.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;sed eleifend lectus purus id sem. Morbi eget interdum ligula. Cras tincidunt tincidunt odio et accumsan. Aliquam erat volutpat. In iaculis tortor ac congue cursus. In hac habitasse platea dictumst. Maecenas eu dignissim nisi. Donec feugiat, massa vel egestas dapibus, libero purus lacinia eros,&#38;nbsp;&#60;u&#62;magna enim&#60;/u&#62;&#38;nbsp;eu pellentesque lorem purus id orci. Cras tempor, mauris vitae congue sollicitudin, ex justo viverra ipsum, sit amet viverra justo odio ac metus. Aenean tristique odio id lectus accumsan convallis. Praesent tempor elit pulvinar elit ultricies, sed gravida nulla cursus. In condimentum mi ex, vel dapibus arcu accumsan ut.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;blockquote&#62;Trending Title in ullamcorper sollicitudin, ligula nisi hendrerit magna, eget rhoncus purus urna at risus. Nullam volutpat augue at orci malesuada sollicitudin ut id risus. Ut tincidunt, erat eget feugiat eleifend, eros magna dapibus diam, eu aliquam dolor ipsum fringilla nulla&#60;/blockquote&#62;&#13;&#10;&#13;&#10;&#60;p&#62;dolor sit amet, consectetur adipiscing elit. Fusce porttitor tristique mi, sed rhoncus sapien mollis vitae. Pellentesque at mauris neque. Vestibulum pulvinar ac sagittis ex consectetur sed. Ut viverra elementum libero, nec tincidunt orci vehicula quis. Vivamus vehicula quis nunc quis rutrum. Aliquam consectetur dapibus tortor, blandit lobortis erat dictum sed. Interdum et malesuada fames ac ante ipsum primis in .&#60;/p&#62;&#13;&#10;', 5, 'http://radix.local/uploads/images/blog/blog1.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 1, '2024-03-01 18:07:49', '2024-03-03 13:44:36'),
(11, 'Recognizing the need is the primary', 'recognizing-the-need-is-the-primary', 1, 11, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 6, 'http://radix.local/uploads/images/blog/blog4.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 0, '2024-03-01 18:09:17', '2024-03-01 18:09:52'),
(12, '10 ways to improve your startup Business', '10-ways-to-improve-your-startup-business', 1, 10, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 35, 'http://radix.local/uploads/images/blog/blog3.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 0, '2024-03-01 18:09:56', '2024-03-01 18:10:40'),
(13, 'How to grow your business with blank table!', 'how-to-grow-your-business-with-blank-table', 1, 9, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 0, 'http://radix.local/uploads/images/blog/blog2.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 1, '2024-03-01 18:10:53', '2024-03-01 18:11:22'),
(14, 'How to grow your business with blank table!(1)', 'how-to-grow-your-business-with-blank-table1', 1, 9, '&#60;h2&#62;Where does it come from?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#38;quot;Lorem ipsum dolor sit amet..&#38;quot;, comes from a line in section 1.10.32.&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#38;quot;de Finibus Bonorum et Malorum&#38;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&#60;/p&#62;&#13;&#10;', 1, 'http://radix.local/uploads/images/blog/blog2.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissimet enim. Aenean ac tincidunt tortor sedelon bond', 0, '2024-03-02 23:31:57', NULL);

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
(7, 'Website', 'websi', 1, 0, '2024-03-01 18:00:56', NULL),
(8, 'Marketing', 'marketing', 1, 0, '2024-03-01 18:01:14', NULL),
(9, 'Business', 'business', 1, 0, '2024-03-01 18:01:29', NULL),
(10, 'Brand', 'brand', 1, 0, '2024-03-01 18:01:38', NULL),
(11, 'Online', 'online', 1, 0, '2024-03-01 18:01:43', NULL);

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

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `fullname`, `email`, `website`, `content`, `parent_id`, `user_id`, `blog_id`, `status`, `create_at`, `update_at`) VALUES
(4, 'Bịp', 'bip01@gmail.com', 'radix.com', 'comment sub. oke', 0, NULL, 8, 1, '2024-03-06 10:49:00', '2024-03-07 12:27:13'),
(19, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', '', 'Test comment khi đăng nhập', 0, 1, 8, 1, '2024-03-06 12:36:16', NULL),
(21, 'Nguyễn Thị Thùy Linh', 'nptlinh130401@gmail.com', '', 'trả lời cho bạn test comment sau sửa', 19, 3, 8, 1, '2024-03-06 17:09:27', '2024-03-07 12:25:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `type_id` int(11) DEFAULT 0,
  `message` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1: Chưa xử lý; 2: Đang xử lý; 3: Đã xử lý',
  `note` text DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `fullname`, `email`, `type_id`, `message`, `status`, `note`, `create_at`, `update_at`) VALUES
(2, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', 3, 'Tôi muốn xây dựng website cho công ty của tôi', 1, 'Khách hàng muốn xây dựng một website bán hàng về quần áo', '2023-11-20 15:10:41', '2023-11-21 11:50:15'),
(3, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', 7, 'test contact', 1, NULL, '2024-03-07 16:46:14', NULL),
(4, 'Bịp', 'tamtt1512@gmail.com', 6, 'test send mail', 1, NULL, '2024-03-07 17:07:27', NULL),
(5, 'Bịp', 'tamtt1512@gmail.com', 2, 'test send mail', 1, NULL, '2024-03-07 17:09:46', NULL),
(6, 'Bịp', 'tonthanhtam01@gmail.com', 2, 'test send mail admin', 1, NULL, '2024-03-07 17:10:21', NULL),
(7, 'Bịp', 'tonthanhtam01@gmail.com', 2, 'ssss', 1, NULL, '2024-03-07 17:11:44', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_types`
--

CREATE TABLE `contact_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `duplicate` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_types`
--

INSERT INTO `contact_types` (`id`, `name`, `user_id`, `duplicate`, `create_at`, `update_at`) VALUES
(2, 'Kinh doanh', 1, 0, '2023-11-20 13:26:13', NULL),
(3, 'IT', 1, 1, '2023-11-20 13:33:47', NULL),
(5, 'Starting a new business', 1, 0, '2024-03-07 16:10:02', NULL),
(6, 'Startup Consultation', 1, 0, '2024-03-07 16:10:20', NULL),
(7, 'Financial Consultation', 1, 0, '2024-03-07 16:10:37', NULL),
(8, 'Business Consultation', 1, 0, '2024-03-07 16:10:55', '2024-03-07 16:34:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `root` tinyint(4) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `groups`
--

INSERT INTO `groups` (`id`, `name`, `permission`, `root`, `create_at`, `update_at`) VALUES
(1, 'Senior Author', '{\"groups\":[\"lists\",\"add\",\"edit\",\"delete\",\"permission\"],\"users\":[\"lists\",\"add\",\"edit\",\"delete\"],\"services\":[\"lists\",\"add\",\"edit\",\"delete\",\"detail\",\"duplicate\"],\"pages\":[\"lists\",\"add\",\"edit\",\"delete\",\"detail\"],\"portfolios\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"portfolio_categories\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\"],\"blogs\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"blog_categories\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"contacts\":[\"lists\",\"edit\",\"delete\"],\"contact_types\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\"],\"comments\":[\"lists\",\"edit\",\"delete\",\"chang_status\",\"lists\",\"edit\",\"delete\",\"status\"],\"subscribe\":[\"lists\",\"edit\",\"delete\"],\"options\":[\"lists\",\"general\",\"header\",\"footer\",\"home\",\"about\",\"team\",\"services\",\"portfolios\",\"blogs\",\"contacts\",\"menu\"]}', 1, '2023-10-01 16:30:49', '2024-03-12 10:19:39'),
(2, 'Admin', '{\"groups\":[\"lists\",\"add\",\"edit\",\"delete\",\"permission\"],\"services\":[\"lists\",\"add\",\"edit\",\"delete\",\"detail\"],\"pages\":[\"lists\",\"add\",\"edit\",\"delete\",\"detail\"],\"portfolios\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"portfolio_categories\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\"],\"blos\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"blog_categories\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\",\"detail\"],\"contact\":[\"lists\",\"edit\",\"delete\"],\"contact_type\":[\"lists\",\"add\",\"edit\",\"delete\",\"duplicate\"],\"comments\":[\"lists\",\"edit\",\"delete\",\"chang_status\"],\"subscribe\":[\"lists\",\"edit\",\"delete\"],\"options\":[\"general\",\"header\",\"footer\",\"home\",\"about\",\"team\",\"services\",\"portfolios\",\"blogs\",\"contact\",\"menu\"]}', 1, '2023-10-01 16:30:49', '2024-03-11 16:49:05'),
(3, 'Manager', '{\"groups\":[\"lists\",\"permission\"],\"users\":[\"lists\"],\"services\":[\"lists\"],\"pages\":[\"lists\"],\"portfolios\":[\"lists\"],\"portfolio_categories\":[\"lists\",\"lists\"],\"blogs\":[\"lists\"],\"blog_categories\":[\"lists\"],\"contacts\":[\"lists\",\"edit\",\"delete\"],\"contact_types\":[\"lists\"],\"comments\":[\"lists\",\"lists\"],\"subscribe\":[\"lists\"],\"options\":[\"lists\"]}', 0, '2023-10-01 16:30:49', '2024-03-12 10:28:08'),
(6, 'admin user', NULL, 0, '2023-10-02 00:47:02', NULL);

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
(207, 1, '5417bab2fdda59df573493d6a4fad1d3cdf842f2', '2024-03-12 16:16:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `actions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `modules`
--

INSERT INTO `modules` (`id`, `name`, `title`, `actions`) VALUES
(1, 'groups', 'Nhóm người dùng', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"permission\": \"Phân quyền\"\r\n}'),
(2, 'users', 'Người dùng', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\"\r\n}'),
(3, 'services', 'Dịch vụ', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"detail\": \"Xem chi tiết\",\r\n  \"duplicate\": \"Nhân bản\"\r\n}'),
(4, 'pages', 'Trang thông tin', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"detail\": \"Xem chi tiết\"\r\n}'),
(5, 'portfolios', 'Dự án', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\",\r\n  \"detail\": \"Xem chi tiết\"\r\n}'),
(6, 'portfolio_categories', 'Danh mục dự án', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\"\r\n}'),
(7, 'blogs', 'Bài viết', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\",\r\n  \"detail\": \"Xem chi tiết\"\r\n}'),
(8, 'blog_categories', 'Danh mục bài viết', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\",\r\n  \"detail\": \"Xem chi tiết\"\r\n}'),
(9, 'contacts', 'Liên hệ', '{\r\n  \"lists\": \"Xem\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\"\r\n}'),
(10, 'contact_types', 'Loại liên hệ', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\"\r\n}'),
(11, 'comments', 'Bình luận', '{\r\n  \"lists\": \"Xem\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"chang_status\": \"Đổi trạng thái\"\r\n}'),
(12, 'subscribe', 'Đăng ký', '{\r\n  \"lists\": \"Xem\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\"\r\n}'),
(13, 'options', 'Thiết lập', '{\r\n  \"lists\": \"Xem\",\r\n  \"general\": \"Thiết lập chung\",\r\n  \"header\": \"Header\",\r\n  \"footer\": \"Footer\",\r\n  \"home\": \"Trang chủ\",\r\n  \"about\": \"Giới thiệu\",\r\n  \"team\": \"Team\",\r\n  \"services\": \"Dịch vụ\",\r\n  \"portfolios\": \"Dự án\",\r\n  \"blogs\": \"Bài viết\",\r\n  \"contacts\": \"Liên hệ\",\r\n  \"menu\": \"Menu\"\r\n}'),
(14, 'portfolio_categories', 'Danh mục dự án', '{\r\n  \"lists\": \"Xem\",\r\n  \"add\": \"Thêm\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"duplicate\": \"Nhân bản\"\r\n}'),
(15, 'comments', 'Bình luận', '{\r\n  \"lists\": \"Xem\",\r\n  \"edit\": \"Sửa\",\r\n  \"delete\": \"Xóa\",\r\n  \"status\": \"Đổi trạng thái\"\r\n}');

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
(1, 'general_hotline', '+(84) 396371031', 'Hotline', 0),
(2, 'general_email', 'tamtt1512@gmail.com', 'Email', 0),
(3, 'header_time', '09am - 05pm', 'Thời gian làm việc', 0),
(5, 'header_placeholder_search', 'Nhập từ khóa tìm kiếm', 'Placeholder tìm kiếm header', 0),
(6, 'general_facebook', 'https://www.facebook.com/tamtt1512', 'Facebook', 0),
(7, 'general_twitter', 'https://twitter.com/tamtt1512', 'Twitter', 0),
(8, 'general_linkedin', 'https://www.linkedin.com/in/tamtt1512', 'Linkedin', 0),
(9, 'general_behance', 'https://www.behance.net/tamtt1512', 'Behance', 0),
(10, 'general_youtube', 'https://youtube.com/@tamtt1512', 'Youtube', 0),
(11, 'header_quote_text', 'Nhận báo giá', 'Nút báo giá', 0),
(12, 'header_quote_link', 'http://radix.local/lien-he.html', 'Link báo giá', 0),
(13, 'general_logo', 'http://radix.local/uploads/images/logo/logo.png', 'Logo\r\n', 1),
(15, 'general_name_site', 'Radix', 'Tên trang web (< 6 ký tự)\r\n', 0),
(16, 'general_favicon', 'http://radix.local/uploads/images/favicon/favicon.png', 'Favicon\r\n', 1),
(17, 'home_slide', '[{\"slider_title\":\"Radix &#60;span&#62;Business&#60;\\/span&#62; World That Possible anything&#60;span&#62;!&#60;\\/span&#62;\",\"slider_btn\":\"Our Portfolio\",\"slider_btn_link\":\"http:\\/\\/radix.local\\/du-an.html\",\"slider_youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=E-2ocmhF6TA\",\"slider_image_1\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image1.jpg\",\"slider_image_2\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image2.jpg\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image1.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"left\"},{\"slider_title\":\"Radix &#60;span&#62;Business&#60;\\/span&#62; World That Possible anything&#60;span&#62;!&#60;\\/span&#62;\",\"slider_btn\":\"Our Services\",\"slider_btn_link\":\"http:\\/\\/radix.local\\/dich-vu.html\",\"slider_youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=E-2ocmhF6TA\",\"slider_image_1\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image1.jpg\",\"slider_image_2\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-image2.jpg\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image2.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"right\"},{\"slider_title\":\"Build your website with Radix Multipurpose   &#60;span&#62;Business&#60;\\/span&#62; Template.\",\"slider_btn\":\"About Company\",\"slider_btn_link\":\"http:\\/\\/radix.local\\/gioi-thieu.html\",\"slider_youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=E-2ocmhF6TA\",\"slider_image_1\":\"#\",\"slider_image_2\":\"#\",\"slider_bg\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/slider-image1.jpg\",\"slider_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet urna ante, quis luctus nisi sodales sit amet. Aliquam a enim in massa molestie mollis Proin quis velit at nisl vulputate egestas non in arcu Proin a magna hendrerit, tincidunt neque sed\",\"slider_position\":\"center\"}]', 'Slider', 0),
(18, 'page_about', '{\"about_title_page\":\"About Our Company\",\"about_title_bg\":\"Radix\",\"about_title\":\"About Company\",\"about_desc\":\"&#60;p&#62;contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old&#60;\\/p&#62;&#13;&#10;\",\"about_image\":\"http:\\/\\/radix.local\\/uploads\\/images\\/slider\\/gallery-4.jpg\",\"about_youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=E-2ocmhF6TA\",\"about_content\":\"&#60;h2&#62;&#60;strong&#62;We Are Professional Website Design &#38;amp; Development Company!&#60;\\/strong&#62;&#60;\\/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. You think water moves fast? You should see ice.&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a weeked do incididunt magna Lorem&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;p&#62;You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalancip isicing elit, sed do eiusmod tempor incididunt&#60;\\/p&#62;&#13;&#10;&#13;&#10;&#60;div class=&#34;ddict_div&#34; style=&#34;left:49.4844px; max-width:550.969px; top:47px&#34;&#62;&#60;img class=&#34;ddict_audio&#34; src=&#34;chrome-extension:\\/\\/bpggmmljdiliancllaapiggllnkbjocb\\/img\\/audio.png&#34; \\/&#62;&#13;&#10;&#60;p&#62;Ch&#38;uacute;ng t&#38;ocirc;i l&#38;agrave; c&#38;ocirc;ng ty thi\\u1ebft k\\u1ebf v&#38;agrave; ph&#38;aacute;t tri\\u1ec3n trang web chuy&#38;ecirc;n nghi\\u1ec7p!&#60;\\/p&#62;&#13;&#10;&#60;\\/div&#62;&#13;&#10;\",\"about_progress_name\":[\"Communication\",\"Business Develop\",\"Creative Work\",\"Bootstrap 4\"],\"progress-range\":[\"78\",\"80\",\"90\",\"95\"]}', 'Thiết lập giới thiệu', 0),
(19, 'page_services_title-bg', 'Services', 'Tiêu đề nền', 0),
(20, 'page_services_title', 'What We Provide', 'Tiêu đề', 0),
(21, 'page_services_content', '&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(22, 'home_facts', '{\"facts_title_sub\":\"Our Achievements\",\"facts_title\":\"With Smooth Animation Numbering\",\"facts_desc\":\"&#60;p&#62;Pellentesque vitae gravida nulla. Maecenas molestie ligula quis urna viverra venenatis. Donec at ex metus. Suspendisse ac est et magna viverra eleifend. Etiam varius auctor est eu eleifend.&#60;\\/p&#62;&#13;&#10;\",\"facts_button_title\":\"CONTACT US\",\"facts_button_link\":\"http:\\/\\/radix.local\\/lien-he.html\",\"facts_item_desc\":[\"Years Of Success\",\"Project Complete\",\"Total Earnings\",\"Winning Awards\"],\"facts_item_icon\":[\"&#60;i class=&#34;fa fa-clock-o&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-bullseye&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-dollar&#34;&#62;&#60;\\/i&#62;\",\"&#60;i class=&#34;fa fa-trophy&#34;&#62;&#60;\\/i&#62;\"],\"facts_item_number\":[\"35\",\"88\",\"10\",\"32\"],\"facts_item_unit\":[\"\",\"K\",\"M\",\"\"]}', 'Thiết lập thành tựu', 0),
(27, 'page_portfolios_title-bg', 'Projects', 'Tiêu đề nền', 0),
(28, 'page_portfolios_title', 'Our Portfolio', 'Tiêu đề', 0),
(29, 'page_portfolios_content', '&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(30, 'page_portfolios_btn', 'MORE PORTFOLIO', 'Nội dung nút', 0),
(31, 'page_portfolios_btn_link', 'http://radix.local/du-an.html', 'Link nút', 0),
(32, 'home_cta_content', '&#60;h2&#62;We Have 35+ Years Of Experiences For Creating Creative Website Project.&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim feugiat, facilisis arcu vehicula, consequat sem. Cras et vulputate nisi, ac dignissim mi. Etiam laoreet&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(33, 'home_cta_btn', 'BUY THIS THEME', 'Nội dung nút', 0),
(34, 'home_cta_btn_link', 'http://radix.local/lien-he.html', 'Link nút', 0),
(35, 'page_blogs_title-bg', 'News', 'Tiêu đề nền', 0),
(36, 'page_blogs_title', 'Latest Blogs', 'Tiêu đề', 0),
(37, 'page_blogs_content', '&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(38, 'home_partners', '{\"partners_title_bg\":\"Clients\",\"partners_title\":\"Our Partners\",\"partners_desc\":\"&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;\\/p&#62;&#13;&#10;\",\"partners_imgs\":[\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-1.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-2.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-3.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-4.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-5.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-6.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-7.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-8.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-5.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-6.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-7.png\",\"http:\\/\\/radix.local\\/uploads\\/images\\/partner\\/partner-8.png\"],\"partners_links\":[\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\",\"#\"]}', 'Thiết lập đối tác', 0),
(39, 'general_address', 'Bến Lức, Long An', 'Địa chỉ', 0),
(40, 'footer_1_title', 'Office Location', 'Tiêu đề', 0),
(41, 'footer_1_content', '&#60;p&#62;Maecenas sapien erat, porta non porttitor non, dignissim et enim.&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(42, 'footer_3_title', 'Recent Tweets', 'Tiêu đề', 0),
(43, 'footer_4_title', 'Newsletter', 'Tiêu đề', 0),
(44, 'footer_4_content', '&#60;p&#62;consectetur adipiscing elit. Vestibulum vel sapien et lacus tempus varius. In finibus lorem vel.&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(45, 'footer_2', '{\"footer_2_title\":\"Quick Links\",\"footer_2_qick_link_content\":[\"About Our Company\",\"Our Latest services\",\"Our Recent Project\",\"Latest Blog\",\"Help Desk\",\"Contact With Us\"],\"footer_2_qick_link\":[\"#\",\"#\",\"#\",\"#\",\"#\",\"#\"]}', 'Thiết lập cột 2', 0),
(46, 'footer_3_twitter', 'tamtt1512', 'Tài khoản twitter', 0),
(47, 'copyright_content', '&#60;p&#62;&#38;copy; 2020 All Right Reserved. Design &#38;amp; Development By&#38;nbsp;&#60;a href=&#34;http://themelamp.com/&#34; target=&#34;_blank&#34;&#62;ThemeLamp.Com&#60;/a&#62;, Theme Provided By&#38;nbsp;&#60;a href=&#34;https://codeglim.com/&#34; target=&#34;_blank&#34;&#62;CodeGlim.Com&#60;/a&#62;&#60;/p&#62;&#13;&#10;', 'Copyright', 0),
(48, 'page_blogs_title_page', 'Our Blogs', 'Tiêu đề trang', 0),
(49, 'page_services_title_page', 'Our Services', 'Tiêu đề trang', 0),
(50, 'page_portfolios_title_page', 'Our Portfolio', 'Tiêu đề trang', 0),
(51, 'page_contact_title-bg', 'Radix', 'Tiêu đề nền', 0),
(52, 'page_contact_title', 'Contact Us', 'Tiêu đề', 0),
(53, 'page_contact_content', '&#60;p&#62;contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old&#60;/p&#62;&#13;&#10;', 'Nội dung', 3),
(54, 'page_contact_title_page', 'Our Contact Details', 'Tiêu đề trang', 0),
(55, 'page_team', '{\"team_title_page\":\"Our Leaders\",\"team_title_bg\":\"Team\",\"team_title\":\"Our Leaders\",\"team_desc\":\"&#60;p&#62;Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor. Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus magna, a vehicula turpis Proin&#60;\\/p&#62;&#13;&#10;\",\"team_member_img\":[\"http:\\/\\/radix.local\\/uploads\\/images\\/team\\/t2.jpg\",\"http:\\/\\/radix.local\\/uploads\\/images\\/team\\/t1.jpg\",\"http:\\/\\/radix.local\\/uploads\\/images\\/team\\/t3.jpg\",\"http:\\/\\/radix.local\\/uploads\\/images\\/team\\/t4.jpg\"],\"team_member_name\":[\"Collis Molate\",\"Domani Plavon\",\"John Mard\",\"Amanal Frond\"],\"team_member_position\":[\"Founder\",\"Co-Founder\",\"Developer\",\"Marketer\"],\"team_member_facebook\":[\"#\",\"#\",\"#\",\"#\"],\"team_member_twitter\":[\"#\",\"#\",\"#\",\"#\"],\"team_member_linkedin\":[\"#\",\"#\",\"#\",\"#\"],\"team_member_behance\":[\"#\",\"#\",\"#\",\"#\"]}', 'Thiết lập Team', 0),
(57, 'menu', '[{&#34;text&#34;:&#34;Home&#34;,&#34;href&#34;:&#34;http://radix.local/&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;},{&#34;text&#34;:&#34;Pages&#34;,&#34;href&#34;:&#34;http://radix.local/gioi-thieu.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;,&#34;children&#34;:[{&#34;text&#34;:&#34;About Us&#34;,&#34;href&#34;:&#34;http://radix.local/gioi-thieu/chung-toi.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;},{&#34;text&#34;:&#34;Our Team&#34;,&#34;href&#34;:&#34;http://radix.local/gioi-thieu/doi-ngu.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;}]},{&#34;text&#34;:&#34;Services&#34;,&#34;href&#34;:&#34;http://radix.local/dich-vu.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;},{&#34;text&#34;:&#34;Porfolio&#34;,&#34;href&#34;:&#34;http://radix.local/du-an.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;},{&#34;text&#34;:&#34;Blogs&#34;,&#34;href&#34;:&#34;http://radix.local/bai-viet.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;},{&#34;text&#34;:&#34;Contact&#34;,&#34;href&#34;:&#34;http://radix.local/lien-he.html&#34;,&#34;icon&#34;:&#34;empty&#34;,&#34;target&#34;:&#34;_self&#34;,&#34;title&#34;:&#34;&#34;}]', 'Thiết lập Menu', 0),
(59, 'page_blogs_quantity', '6', 'Số bài viết trên trang', 0);

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
(8, 'Chương trình khuyến mãi', 'chuong-trinh-khuyen-mai', '&#60;p&#62;Chương tr&#38;igrave;nh khuyến m&#38;atilde;i&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;div class=&#34;ddict_btn&#34; style=&#34;left:316.047px; top:47px&#34;&#62;&#60;img src=&#34;chrome-extension://bpggmmljdiliancllaapiggllnkbjocb/logo/48.png&#34; /&#62;&#60;/div&#62;&#13;&#10;', 1, 0, '2023-10-07 17:59:02', '2024-03-07 17:30:41');

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
(15, 'Creative Work', 'creative-work', 'http://radix.local/uploads/images/portfolio/p1.jpg', 'Maecenas sapien erat, porta non porttitor non, dignissim et enim. Aenean ac enim', 'https://www.youtube.com/watch?v=E-2ocmhF6TA', '&#60;h2&#62;What is Lorem Ipsum?&#60;/h2&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#60;strong&#62;Lorem Ipsum&#60;/strong&#62;&#38;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#38;#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&#60;/p&#62;&#13;&#10;', 1, '2024-02-29 16:06:54', '2024-03-05 15:34:28', 0),
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
(28, 'PRINTING', 1, 1, '2024-02-28 21:02:31', '2024-03-12 16:17:57');

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
(31, 15, 23, 1, '2024-03-05 15:34:28'),
(32, 15, 25, 1, '2024-03-05 15:34:28'),
(33, 15, 28, 1, '2024-03-05 15:34:28');

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

--
-- Đang đổ dữ liệu cho bảng `portfolio_images`
--

INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image`, `create_at`, `update_at`) VALUES
(24, 15, 'http://radix.local/uploads/images/portfolio/p1.jpg', '2024-03-05 15:34:28', NULL),
(25, 15, 'http://radix.local/uploads/images/portfolio/p6.jpg', '2024-03-05 15:34:28', NULL),
(26, 15, 'http://radix.local/uploads/images/portfolio/p7.jpg', '2024-03-05 15:34:28', NULL),
(27, 15, 'http://radix.local/uploads/images/portfolio/p3.jpg', '2024-03-05 15:34:28', NULL),
(28, 15, 'http://radix.local/uploads/images/portfolio/portfolio-single.jpg', '2024-03-05 15:34:28', NULL),
(29, 15, 'http://radix.local/uploads/images/portfolio/p8.jpg', '2024-03-05 15:34:28', NULL);

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
(70, 'Creative Plan', 'creative-plan', '&#60;i class=&#34;fa fa-cube&#34;&#62;&#60;/i&#62;', 'Information sapien erat, non porttitor non, dignissim et enim Aenean ac enim feugiat classical Latin', '&#60;h3&#62;The standard Lorem Ipsum passage, used since the 1500s&#60;/h3&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#38;quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&#38;quot;&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;h3&#62;Section 1.10.32 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot;, written by Cicero in 45 BC&#60;/h3&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#38;quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&#38;quot;&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;h3&#62;1914 translation by H. Rackham&#60;/h3&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#38;quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&#38;quot;&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;h3&#62;Section 1.10.33 of &#38;quot;de Finibus Bonorum et Malorum&#38;quot;, written by Cicero in 45 BC&#60;/h3&#62;&#13;&#10;&#13;&#10;&#60;p&#62;&#38;quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&#38;quot;&#60;/p&#62;&#13;&#10;&#13;&#10;&#60;div class=&#34;ddict_btn&#34; style=&#34;left:48.9219px; top:40px&#34;&#62;&#60;img src=&#34;chrome-extension://bpggmmljdiliancllaapiggllnkbjocb/logo/48.png&#34; /&#62;&#60;/div&#62;&#13;&#10;', 1, 1, '2024-02-28 17:37:50', '2024-03-03 17:19:34');

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

--
-- Đang đổ dữ liệu cho bảng `subscribe`
--

INSERT INTO `subscribe` (`id`, `fullname`, `email`, `status`, `create_at`, `update_at`) VALUES
(1, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', 0, '2024-03-07 21:20:32', '2024-03-07 22:05:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `about_content` text DEFAULT NULL,
  `contact_facebook` varchar(100) DEFAULT NULL,
  `contact_twitter` varchar(100) DEFAULT NULL,
  `contact_linkedin` varchar(100) DEFAULT NULL,
  `contact_pinterest` varchar(100) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `fullname`, `email`, `avatar`, `password`, `about_content`, `contact_facebook`, `contact_twitter`, `contact_linkedin`, `contact_pinterest`, `forget_token`, `group_id`, `status`, `last_activity`, `create_at`, `update_at`) VALUES
(1, 'Tôn Thành Tâm', 'tamtt1512@gmail.com', 'http://radix.local/uploads/images/team/t4.jpg', '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', 'Hi My name is Lamp! quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterations. Vivamus vehicula quis cursus. In hac habitasse platea dictumst Aenean tristique odio id lectus solmania trundard lamp!', 'https://www.facebook.com/tamtt1512', 'https://twitter.com/tamtt1512', 'https://www.linkedin.com/in/tamtt1512', 'https://www.pinterest.com/tamtt1512/', '60b80700fe4a61b0ecb1c876ed56774b8a9ee18c', 1, 1, '2024-03-12 18:34:12', NULL, '2024-03-05 17:53:27'),
(3, 'Nguyễn Thị Thùy Linh', 'nptlinh130401@gmail.com', 'http://radix.local/uploads/images/team/client4.jpg', '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', 'Hi My name is Lamp! quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterations. Vivamus vehicula quis cursus. In hac habitasse platea dictumst Aenean tristique odio id lectus solmania trundard lamp!', '', '', '', '', NULL, 3, 1, '2024-03-12 10:46:21', NULL, '2024-03-12 09:57:31'),
(4, 'Tôn Thành a', 'att1512@gmail.com', NULL, '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(5, 'Nguyễn Thị Thùy a', 'npta130401@gmail.com', NULL, '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07'),
(6, 'Tôn Thành b', 'btt1512@gmail.com', NULL, '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(7, 'Nguyễn Thị Thùy b', 'blinh130401@gmail.com', NULL, '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07'),
(8, 'Tôn Thành c', 'ctt1512@gmail.com', NULL, '$2y$10$/nEfegFv0bYHlTDKiNd2AOmRnW3FLQYNlyRaizRcH79WNpyf.lLrW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-04 17:15:22', NULL, '2023-10-02 16:56:53'),
(9, 'Nguyễn Thị Thùy c', 'nptc\r\n130401@gmail.com', NULL, '$2y$10$OwRXZqF58JUT78O5XMPus.jlxDeyD/Bwwd1nCnNnYl7HHOWb1s0Ia', '', '', '', '', '', NULL, 1, 1, NULL, NULL, '2023-10-02 17:12:07');

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
  ADD KEY `department_id` (`type_id`);

--
-- Chỉ mục cho bảng `contact_types`
--
ALTER TABLE `contact_types`
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
-- Chỉ mục cho bảng `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contact_types`
--
ALTER TABLE `contact_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT cho bảng `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `portfolio_images`
--
ALTER TABLE `portfolio_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `contact_types` (`id`);

--
-- Các ràng buộc cho bảng `contact_types`
--
ALTER TABLE `contact_types`
  ADD CONSTRAINT `contact_types_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
