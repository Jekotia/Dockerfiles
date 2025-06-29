-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2015 at 03:08 AM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ionwebst_linguistics`
--

-- --------------------------------------------------------

--
-- Table structure for table `abbriviations_settings`
--

DROP TABLE IF EXISTS `abbriviations_settings`;
CREATE TABLE IF NOT EXISTS `abbriviations_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_desc` varchar(255) NOT NULL,
  `page_display` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `abbriviations_settings`
--

INSERT INTO `abbriviations_settings` (`id`, `page_desc`, `page_display`) VALUES
(1, 'Use Abbreviations', 'Y'),
(2, 'Useful Definitions', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `add_new_entry`
--

DROP TABLE IF EXISTS `add_new_entry`;
CREATE TABLE IF NOT EXISTS `add_new_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `sindarin_order` int(2) NOT NULL,
  `sindarin_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `english_order` int(2) NOT NULL,
  `english_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `root_word` varchar(255) COLLATE utf8_bin NOT NULL,
  `sound` varchar(50) CHARACTER SET latin1 NOT NULL,
  `alphabetic` varchar(20) CHARACTER SET latin1 NOT NULL,
  `alphabetic_image` varchar(100) CHARACTER SET latin1 NOT NULL,
  `menu_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `annotation` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=164 ;

--
-- Dumping data for table `add_new_entry`
--

INSERT INTO `add_new_entry` (`id`, `post_id`, `sindarin_order`, `sindarin_text`, `english_order`, `english_text`, `root_word`, `sound`, `alphabetic`, `alphabetic_image`, `menu_id`, `annotation`) VALUES
(135, 25, 1, 'first', 1, 'primera [break]', 'eru', '', 'e r u ', '', '', ''),
(136, 25, 2, 'entry', 2, 'entrada', 'e', '', 'e ', '', '', ''),
(137, 26, 1, 'dule', 1, 'dulpe', '', '', '', '', '', ''),
(138, 27, 1, 'vi', 1, 'min', '', '', '', '', '', ''),
(139, 27, 2, 'gf', 2, 'gf', '', '', '', '', '', ''),
(140, 28, 1, 'vf', 1, 'vf', '', '', '', '', '', ''),
(141, 28, 2, 'bg', 2, 'bg', '', '', '', '', '', ''),
(142, 29, 1, 'u-havin', 1, 'I did not sit', 'hav', '', 'u h a v i n ', '', '136,141,189', ''),
(143, 30, 1, 'u-hevin', 1, 'i do not sit', 'hav', '', '', '', '139,141,160,174,170,189,194', ''),
(144, 31, 1, 'u-hevin', 1, 'I do not sit', '', '', '', '', '136,141', ''),
(145, 32, 1, 'fdf', 1, 'gfg', '', '', '', '', '', ''),
(146, 25, 3, 'otra [br]', 3, 'another [br]', '', '', '', '', '', ''),
(147, 25, 4, 'then this', 4, 'luego esto', '', '', '', '', '', ''),
(148, 33, 1, 'a', 1, 'b', 'asd', '', '', '', '', ''),
(149, 34, 1, 'fgvdgvf', 1, 'fgbfbf', '', '', '', '', '', ''),
(150, 35, 1, 'this ', 1, 'esta', '', '', '', '', '', ''),
(151, 35, 2, 'is', 2, 'es', '', '', '', '', '', ''),
(152, 35, 3, 'a', 3, 'una', '', '', '', '', '', ''),
(153, 35, 4, 'home', 4, 'casa', '', '', '', '', '', ''),
(154, 35, 5, '. A very', 5, '. Bastante', '', '', '', '', '', ''),
(155, 35, 6, 'beautiful one.', 6, 'bonita.', '', '', '', '', '', ''),
(156, 35, 7, '[br]', 7, '[br]', '', '', '', '', '', ''),
(157, 35, 8, 'And this', 8, 'y esto', '', '', '', '', '', ''),
(158, 35, 9, 'starts ', 9, 'empieza', '', '', '', '', '', ''),
(159, 35, 10, 'a new sentence', 10, 'una nueva linia', '', '', '', '', '', ''),
(160, 36, 1, 'then the magic', 1, 'luego la majia', '', '', '', '', '', ''),
(161, 36, 2, '[br]', 2, '[br]', '', '', '', '', '', ''),
(162, 36, 3, 'happened.', 3, 'paso.', '', '', '', '', '', ''),
(163, 37, 1, 'one', 1, 'uno', 'eru', '', 'l e s ', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `add_post`
--

DROP TABLE IF EXISTS `add_post`;
CREATE TABLE IF NOT EXISTS `add_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type` enum('author','admin') CHARACTER SET latin1 NOT NULL,
  `is_approve` enum('N','Y') CHARACTER SET latin1 NOT NULL,
  `post_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `accessibility` enum('Public','Unlisted','Private') CHARACTER SET latin1 NOT NULL,
  `search_tags` varchar(255) CHARACTER SET latin1 NOT NULL,
  `added_date` date NOT NULL,
  `modify_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL DEFAULT '',
  `follow_tags` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `approval_required` enum('N','Y') NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `follow_tags`, `date_added`, `is_active`, `approval_required`) VALUES
(1, 'Admin', 'abc@gmail.com', 'MTIzNDU2', '', '2015-03-24 16:53:36', 'Y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `post_id` int(11) NOT NULL,
  `bookmark_url` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `user_id`, `post_id`, `bookmark_url`) VALUES
(4, 0, 6, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=6&postname=Another Trial'),
(5, 0, 6, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=6&postname=Another Trial'),
(6, 29, 5, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=5&postname=Library Page Test'),
(7, 29, 6, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=6&postname=Another Trial'),
(10, 1, 10, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=10&postname=Another Test'),
(13, 43, 24, 'http://sindarinlibrary.com/bookmark.php?link_page=library&id=24&postname=Danish - Harry Potter and The Deathly Hallows (WIP)');

-- --------------------------------------------------------

--
-- Table structure for table `charset`
--

DROP TABLE IF EXISTS `charset`;
CREATE TABLE IF NOT EXISTS `charset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `char_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `graphics`
--

DROP TABLE IF EXISTS `graphics`;
CREATE TABLE IF NOT EXISTS `graphics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frontpage_background` varchar(255) NOT NULL,
  `banner_background` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `website_name` varchar(255) NOT NULL,
  `footer_html1` text NOT NULL,
  `footer_html2` text NOT NULL,
  `footer_html3` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `graphics`
--

INSERT INTO `graphics` (`id`, `frontpage_background`, `banner_background`, `favicon`, `website_name`, `footer_html1`, `footer_html2`, `footer_html3`) VALUES
(1, 'default0_78791.png', 'default002_35971.png', 'favicon_37045.ico', 'Linguistic Library', 'Welcome to your language library. Click <a href=\\"admin/\\">here</a>, to enter the admin panel with:<br><br>\r\nusername: abc@gmail.com<br>\r\npassword: 123456\r\n<br><br>\r\nAnd start setting up your site. Make sure to change your password!', 'Visit the admin panel and add your website links here.\r\n<ul>\r\n<li><a href=\\"admin/\\">Admin Access</a></li>\r\n<li><a href=\\"howtocompose.php\\">How to Compose</a></li>\r\n<li><a href=\\"documentation.php\\">Documentation</a></li>\r\n<li><a href=\\"http://linguisticlibrary.org/\\">Support Forum</a></li>\r\n</ul>', '<img src=\\"http://i.imgur.com/Cr3aQ4g.png\\" width=\\"120px\\"/>');

-- --------------------------------------------------------

--
-- Table structure for table `manage_cms`
--

DROP TABLE IF EXISTS `manage_cms`;
CREATE TABLE IF NOT EXISTS `manage_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_title` varchar(255) NOT NULL,
  `file` text NOT NULL,
  `cms_desc` text NOT NULL,
  `is_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `manage_cms`
--

INSERT INTO `manage_cms` (`id`, `cms_title`, `file`, `cms_desc`, `is_active`) VALUES
(1, 'About Us', '', '<h2>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci.Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi dolor sit amet absidum felisiti.<div></div><h2>Ut In Nulla Enim. Phasellus</h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi dolor sit amet absidum felisiti.Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque tempor, lacus lacus ornare ante, ac egestas est urna sit amet arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed. Molestie augue sit amet leo consequat posuere. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin vel ante a orci tempus eleifend ut et magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus luctus urna sed urna ultricies ac tempor dui sagittis. In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla.', 'Y'),
(2, 'Privacy Policy', '', '<h2>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci.Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi dolor sit amet absidum felisiti.', 'Y'),
(3, 'Terms And Conditions', '', '<i><h2>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h2><div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci.Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi dolor sit amet absidum felisiti.</div></i>', 'Y'),
(4, ' Mission Visions', '', '<div><b>Mission&nbsp;: &nbsp;</b></div>\r\n<span><br>\r\n</span>To Provide the best marketplace for all businesses to promote and grow their activities while drastically reducing cost.&nbsp; At Jobquote&nbsp;we believe that strong client relationship and satisfaction are the key to the successful growth of any business. Our work culture is totally focused and based on this principle. Our aim is to promote the best people in business and to satisfy the consumer. We have a passion to ensure that consumers providing job offers on Hizmetuzmani get the best tradespeople without sacrificing time and peace of mind.&nbsp; Brandon is hansom, but Oliver is smarter!\r\n<br><span><br>\r\n<span><b>Vision&nbsp;</b>:&nbsp;</span><br>\r\n&nbsp;<br>\r\nTo help people on Jobquote share in the company''s successes, which they make possible. To recognize their individual achievements and help them gain a sense of satisfaction and accomplishment from their work.Our soul our work.&nbsp; Our vision is that Brandon can retire next year!</span>', 'N'),
(5, 'Careers', '', 'Etiam eget mi enim, non ultricies nisi voluptatem, illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.', 'Y'),
(6, 'Help', '', 'Etiam eget mi enim, non ultricies nisi voluptatem, illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.', 'Y'),
(7, 'How It Works', 'mkss_45X45_73927.PNG', 'Etiam eget mi enim, non ultricies nisi voluptatem, illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Donec ut volutpat metus. Aliquam tortor lorem, fringilla tempor dignissim at, pretium et arcu. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.', 'Y'),
(8, 'dadadad', '', 'asdsadasda Lorem Ipsum', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu`
--

DROP TABLE IF EXISTS `navigation_menu`;
CREATE TABLE IF NOT EXISTS `navigation_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_desc` varchar(30) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `is_page_display` enum('N','Y') NOT NULL,
  `page_order` int(1) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `navigation_menu`
--

INSERT INTO `navigation_menu` (`id`, `page_desc`, `page_name`, `is_page_display`, `page_order`, `url`) VALUES
(1, 'Homepage:', 'Home', 'Y', 1, 'index.php'),
(2, 'All Entries Page:', 'Library', 'Y', 2, 'library.php'),
(3, 'Custom Page 1:', 'Link', 'Y', 3, '#'),
(4, 'Custom Page 2:', 'Link', 'Y', 4, '#'),
(5, 'Custom Page 3:', 'Link', 'Y', 5, '#');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alphabet`
--

DROP TABLE IF EXISTS `tbl_alphabet`;
CREATE TABLE IF NOT EXISTS `tbl_alphabet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alpha_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` enum('Y','N') NOT NULL,
  `is_tehta` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_alphabet`
--

INSERT INTO `tbl_alphabet` (`id`, `alpha_name`, `image`, `is_active`, `is_tehta`) VALUES
(1, '[br]', '[br]_36190.png', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dictionary`
--

DROP TABLE IF EXISTS `tbl_dictionary`;
CREATE TABLE IF NOT EXISTS `tbl_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Root` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Meaning` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_dictionary`
--

INSERT INTO `tbl_dictionary` (`id`, `Root`, `Meaning`) VALUES
(1, 'Apple', 'A delicious fruit');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL,
  `abbrevation` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_register`
--

DROP TABLE IF EXISTS `user_register`;
CREATE TABLE IF NOT EXISTS `user_register` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `display_email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `follow_tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_type` enum('reader','author','admin') NOT NULL,
  `approval_required` enum('N','Y') NOT NULL,
  `date_added` datetime NOT NULL,
  `is_active` enum('N','Y') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_register`
--

INSERT INTO `user_register` (`id`, `name`, `display_email`, `password`, `follow_tags`, `user_type`, `approval_required`, `date_added`, `is_active`) VALUES
(1, 'Admin', 'team@adiondesigns.com', '', 'single,double,triple', 'admin', 'N', '2015-03-23 23:27:43', 'Y'),
(5, 'Tester', 'auburneye@live.com', 'a2F0YWthbmE=', '', 'admin', 'N', '2015-03-29 15:09:11', 'Y'),
(6, 'Admin', 'erifrail@live.com', 'aGlub2thZ2U=', '', 'admin', 'N', '2015-03-29 15:22:29', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `visibility`
--

DROP TABLE IF EXISTS `visibility`;
CREATE TABLE IF NOT EXISTS `visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_page_display` enum('Y','N') NOT NULL,
  `page_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visibility`
--

INSERT INTO `visibility` (`id`, `page_desc`, `is_page_display`, `page_name`) VALUES
(1, 'Entry Text Column', 'Y', 'Foreign'),
(2, 'Translation Column', 'Y', 'Native'),
(3, 'Alphabetic Column', 'Y', 'Alphabetic'),
(4, 'Grammar Column', 'Y', 'Grammar');

-- --------------------------------------------------------

--
-- Table structure for table `words_spacing`
--

DROP TABLE IF EXISTS `words_spacing`;
CREATE TABLE IF NOT EXISTS `words_spacing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_spacing` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `words_spacing`
--

INSERT INTO `words_spacing` (`id`, `word_spacing`) VALUES
(1, 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
