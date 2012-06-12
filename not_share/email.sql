-- phpMyAdmin SQL Dump
-- version 3.5.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: db01-share
-- Generation Time: Jun 10, 2012 at 12:12 PM
-- Server version: 5.1.55-rel12.6-log
-- PHP Version: 5.3.2-1ubuntu4.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `floplatform-com`
--

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=105 ;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `email`, `date`, `ip`) VALUES
(1, 'pnunez@amincor.com', '2011-10-27 17:55:45', '67.119.150.194'),
(2, 'ehlivkova@gmail.com', '2011-10-28 00:26:36', '190.31.34.157'),
(3, 'barbora.honcova@telomar.cz', '2011-11-01 08:49:09', '90.177.177.152'),
(4, 'cnunez@amincor.com', '2011-11-02 20:21:41', '67.119.150.194'),
(5, 'andrewcase18@gmail.com', '2011-11-09 16:29:56', '74.207.71.135'),
(6, 'alidundar7@hotmail.com', '2011-11-14 21:21:57', '90.182.5.95'),
(7, 'jen.ofallon@gmail.com', '2011-11-14 21:21:58', '86.49.62.202'),
(8, 'rachel.c.bruch@gmail.com', '2011-11-14 21:23:02', '85.71.3.42'),
(9, 'benjamoog@hotmail.com', '2011-11-14 21:32:43', '94.230.152.7'),
(10, 'derekjobrien@hotmail.com', '2011-11-14 21:35:19', '88.103.9.230'),
(11, 'jake.zahradnik@gmail.com', '2011-11-14 21:35:20', '85.70.67.115'),
(12, 'susanasheehan@gmail.com', '2011-11-14 21:40:59', '128.12.113.160'),
(13, 'gilloptimistic83@gmail.com', '2011-11-14 21:49:58', '109.80.48.185'),
(14, 'm.frankeau@gmail.com', '2011-11-14 21:50:56', '193.179.196.123'),
(15, 'couto.adrian@googlemail.com', '2011-11-14 21:51:11', '193.165.2.80'),
(16, 'jeff.kingyens@gmail.com', '2011-11-14 21:51:57', '76.204.73.134'),
(17, 'dustinnantais@gmail.com', '2011-11-14 21:52:17', '64.86.141.133'),
(18, 'lcrwilko@hotmail.com', '2011-11-14 22:07:35', '78.45.180.82'),
(19, 'marekwins@hotmail.com', '2011-11-14 22:18:22', '90.178.27.92'),
(20, 'joyquintas@gmail.com', '2011-11-14 22:20:06', '80.28.108.89'),
(21, 'rusch.jana@gmail.com', '2011-11-14 22:32:46', '78.102.53.195'),
(22, 'ivana_yu2002@yahoo.com', '2011-11-14 22:34:28', '213.220.194.230'),
(23, 'paysa08@adinet.com.uy', '2011-11-14 22:42:43', '85.70.145.3'),
(24, 'martina.pavlikova@cpljobs.cz', '2011-11-14 22:43:44', '109.80.25.19'),
(25, 'sportmed2000@yahoo.ca', '2011-11-14 22:53:15', '216.221.68.135'),
(26, 'clabbeb@gmail.com', '2011-11-14 22:57:07', '85.70.67.115'),
(27, 'rpgargiulo@gmail.com', '2011-11-15 04:32:12', '24.218.134.214'),
(28, 'kmlazyus@googlemail.com', '2011-11-15 14:39:38', '79.247.102.206'),
(29, 'goucsdjb@gmail.com', '2011-11-15 22:36:35', '88.103.36.182'),
(30, 'pennycobrien@gmail.com', '2011-11-16 02:09:24', '58.161.130.199'),
(31, 'michaelpitthan@yahoo.co.uk', '2011-11-16 13:08:41', '78.45.21.83'),
(32, 'riina.tiira@gmail.com', '2011-11-17 20:40:08', '86.49.60.205'),
(33, 'eva.macuchova@gmail.com', '2011-11-17 23:17:18', '95.103.93.165'),
(34, 'thtonnu@gmail.com', '2011-11-17 23:50:48', '88.103.36.182'),
(35, 'mustcanst@gmail.com', '2011-11-19 21:30:25', '74.15.76.19'),
(36, 'Dana_janouskova@Yahoo.com', '2011-11-19 23:40:42', '89.102.199.160'),
(37, 'jake.zahradnik@gmail.com', '2011-11-20 12:50:31', '85.70.67.115'),
(38, 'yalinyuregil@gmail.com', '2011-11-28 14:45:00', '195.47.6.126'),
(39, 'ani.ceran@gmail.com', '2011-11-28 20:46:50', '94.112.166.147'),
(40, 'empurio_j@hotmail.com', '2012-01-23 15:10:07', '217.136.227.183'),
(41, 'daveburkard@gmail.com', '2012-01-23 19:41:46', '90.180.200.58'),
(42, 'cbrodiex@gmail.com', '2012-02-06 00:45:23', '72.39.224.135'),
(43, 'dan_lefou@hotmail.com', '2012-02-06 01:23:15', '74.14.200.226'),
(44, 'bdub077@hotmail.com', '2012-02-07 01:24:34', '174.112.3.246'),
(45, 'elena.gurzhiy@gmail.com', '2012-02-07 05:45:35', '10.6.97.6'),
(46, 'corkery_m@yahoo.com', '2012-02-07 21:13:22', '88.101.252.72'),
(47, 'kevinkean@gmail.com', '2012-02-08 23:09:29', '10.240.58.182'),
(48, 'nancyvirgilio@rogers.com', '2012-02-10 23:03:23', '174.117.108.8'),
(49, 'fragoso.ruben@gmail.com', '2012-02-14 16:10:04', '193.165.182.100'),
(50, 'christibrookspdx@gmail.com', '2012-02-14 16:11:58', '10.254.203.118'),
(51, 'sangel@rogers.com', '2012-02-14 16:19:17', '129.42.208.174'),
(52, 'svoboda.philip@gmail.com', '2012-02-14 16:23:46', '88.102.183.220'),
(53, 'kamokotucz@yahoo.com', '2012-02-14 16:27:24', '90.182.141.114'),
(54, 'ekskn-3@yahoo.com', '2012-02-14 16:50:17', '10.254.203.118'),
(55, 'Restivo82@yahoo.com', '2012-02-14 17:33:05', '72.39.177.141'),
(56, 'simon.puppo@gmail.com', '2012-02-14 17:42:37', '78.250.62.244'),
(57, 'salieri@gmail.com', '2012-02-14 18:15:41', '205.233.124.50'),
(58, 'sascha.graeber@mail.ru', '2012-02-14 19:15:23', '46.13.53.246'),
(59, 'melanieveenbaas@gmail.com', '2012-02-14 23:34:45', '173.33.210.127'),
(60, 'dtorga@gmail.com', '2012-02-15 08:15:49', '10.254.203.118'),
(61, 'dtorga@gmail.com', '2012-02-15 08:15:49', '10.254.203.118'),
(62, 'parteeba@hotmail.com', '2012-02-15 08:53:10', '80.99.254.251'),
(63, 'fiorildotenace@gmail.com', '2012-02-15 23:23:31', '10.254.203.118'),
(64, 'jengillis@msn.com', '2012-02-16 19:56:54', '99.237.57.242'),
(65, 'booyahmedia@gmail.com', '2012-02-17 04:04:35', '166.147.76.105'),
(66, 'caterina.giresi@gmail.com', '2012-02-17 14:00:28', '10.254.203.118'),
(67, 'crystal.dery@gmail.com', '2012-02-17 15:21:22', '10.254.203.118'),
(68, 'mjr325@gmail.com', '2012-02-17 20:19:56', '24.206.32.209'),
(69, 'hotwingz@gmail.com', '2012-02-17 21:49:47', '24.186.214.223'),
(70, 'gnunez0@gmail.com', '2012-02-19 05:13:25', '199.83.220.184'),
(71, 'kenperkins7@hotmail.com', '2012-02-19 11:25:36', '10.254.203.118'),
(72, 'tuomo.majaniemi@gmail.com', '2012-02-20 02:06:34', '213.220.209.137'),
(73, 'michaelhpietrzak@gmail.com', '2012-02-21 03:41:28', '184.144.109.182'),
(74, 'vexity@gmail.com', '2012-02-21 12:14:05', '108.27.248.117'),
(75, 'riana@duckygo.com', '2012-02-21 19:35:17', '109.80.200.222'),
(76, 'jesse@getbackstory.com', '2012-02-22 12:28:02', '99.111.65.193'),
(77, 'agsternthal@gmail.com', '2012-02-22 13:12:28', '10.215.201.161'),
(78, 'mattctyndall@gmail.com', '2012-02-22 16:01:08', '10.215.201.161'),
(79, 'davidskch@gmail.com', '2012-02-24 19:14:19', '10.255.111.191'),
(80, 'jmarpet@datadevastation.com', '2012-02-24 21:04:50', '199.169.200.4'),
(81, 'fabioputz@hotmail.it', '2012-02-27 17:52:09', '213.220.228.54'),
(82, 'paul.brunson@gmail.com', '2012-02-28 23:35:18', '174.21.116.251'),
(83, 'moser.lukca@gmail.com', '2012-02-29 18:55:52', '10.210.51.79'),
(84, 'giselle.pantazis@gmail.com', '2012-03-05 21:56:02', '206.223.179.70'),
(85, 'Vchamakkala@gmail.com', '2012-03-06 07:13:48', '24.215.195.195'),
(86, 'michelle_hebbard@yahoo.com.au', '2012-03-10 11:34:25', '86.182.24.209'),
(87, 'ichopov@gmail.com', '2012-03-13 21:29:31', '91.199.36.10'),
(88, 'Arazzook@gmail.com', '2012-04-02 00:05:06', '166.248.36.199'),
(89, 'rebresgabi@email.cz', '2012-04-06 14:14:07', '193.9.13.137'),
(90, 'Flickemail@me.com', '2012-04-08 03:58:16', '67.163.254.121'),
(91, 'kylenish@gmail.com', '2012-04-22 02:19:49', '98.154.204.188'),
(92, 'je2424@gmail.com', '2012-04-27 05:26:12', '127.0.0.1'),
(93, 'davidkerny@gmail.com', '2012-05-03 19:26:24', '94.112.186.91'),
(94, 'fukpeh@gmail.com', '2012-05-06 00:59:19', '96.248.51.179'),
(95, 'stephen.michael.allison@gmail.com', '2012-05-10 18:01:35', '68.5.165.52'),
(96, 'leila.tanayeva@gmail.com', '2012-05-15 12:37:17', '193.9.13.136'),
(97, 'brianmaxwellkern@gmail.com', '2012-05-16 13:30:34', '160.79.103.146'),
(98, 'fuck@you.com', '2012-05-17 19:23:24', '83.33.41.103'),
(99, 'lorenzo92160@hotmail.com', '2012-05-18 17:42:35', '88.6.78.252'),
(100, 'Sly03100@hotmail.fr', '2012-05-18 18:15:39', '90.84.144.194'),
(101, 'dom@dominicphilips.de', '2012-05-19 21:21:58', '93.134.119.15'),
(102, 'ondrej.michalak@gmail.com', '2012-05-28 07:33:35', '193.9.13.133'),
(103, 'mwalls67@gmail.com', '2012-06-07 07:05:18', '10.191.6.248'),
(104, 'jiri.kinkor@gmail.com', '2012-06-10 12:12:05', '90.183.43.132');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
