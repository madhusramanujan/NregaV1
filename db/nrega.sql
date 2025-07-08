-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 10:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrega`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_table`
--

CREATE TABLE `activity_table` (
  `activityID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `districtID` int(11) NOT NULL,
  `talukID` int(11) NOT NULL,
  `fromLocation` varchar(30) DEFAULT NULL,
  `FromDateAndTime` datetime DEFAULT NULL,
  `toLoc` varchar(30) DEFAULT NULL,
  `toDateAndTime` datetime DEFAULT NULL,
  `activityDone` varchar(1000) DEFAULT NULL,
  `activityImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_table`
--

INSERT INTO `activity_table` (`activityID`, `userID`, `districtID`, `talukID`, `fromLocation`, `FromDateAndTime`, `toLoc`, `toDateAndTime`, `activityDone`, `activityImage`) VALUES
(2, 32, 12, 70, 'Davangere', '2025-07-06 01:01:00', 'Honnalli', '2025-07-06 01:06:00', 'I went from Davangere to Honnalli today', '1751819609_Screenshot 2025-06-18 203836.png'),
(3, 32, 12, 70, 'Davangere', '2025-07-07 14:08:00', 'Nyamati', '2025-07-07 16:13:00', 'From Davangere to Nyamati all the required activities has been done', '1751873979_nature.jpg'),
(4, 32, 12, 70, 'ಬೆಂಗಳೂರು', '2025-07-05 10:30:00', 'ಕೊಪ್ಪಳ', '2025-07-05 18:29:00', 'ನಾಳೆ ನಮ್ಮ ಊರಿನಲ್ಲಿ ಹಬ್ಬದ ಉತ್ಸವವಿದೆ. ಮುಂಜಾವಿನಿಂದಲೇ ಜನರು ದೇವಸ್ಥಾನಕ್ಕೆ ಹೋಗಿ ಪೂಜೆ ಸಲ್ಲಿಸುತ್ತಾರೆ. ರಸ್ತೆಗಳಲ್ಲಿ ಹೂವಿನ ವಾಸನೆ ತುಂಬಿರುತ್ತದೆ ಮತ್ತು ಎಲ್ಲೆಲ್ಲೂ ಸಂಭ್ರಮದ ವಾತಾವರಣ ಕಂಡುಬರುತ್ತದೆ. ಮಕ್ಕಳು ಹೊಸ ಬಟ್ಟೆ ತೊಟ್ಟು ಆಟವಾಡುತ್ತಾ ಕಾಣಿಸುತ್ತಾರೆ. ಮನೆಮನೆಯಲ್ಲೂ ಹಲವಾರು ವಿಧದ ತಿಂಡಿಗಳು ತಯಾರಾಗುತ್ತವೆ. ಹತ್ತಿರದ ಬಂಧುಗಳು, ಸ್ನೇಹಿತರು ಸೇರಿ ಸಂತೋಷದಿಂದ ಸಮಯ ಕಳೆಯುತ್ತಾರೆ. ಈ ರೀತಿಯ ಹಬ್ಬಗಳು ಸಮಾಜದಲ್ಲಿ ಒಗ್ಗಟ್ಟು ಮತ್ತು ಸಹಭಾವನೆ ತರುವಲ್ಲಿ ಸಹಾಯಕವಾಗುತ್ತವೆ.', '1751893308_elephant.jpeg'),
(5, 32, 12, 70, 'Harihara', '2025-07-07 20:40:00', 'Davangere', '2025-07-07 23:43:00', 'went from harihara to Dav', '1751901051_elephant.jpeg'),
(6, 32, 12, 70, 'Bnaglore', '2025-07-08 11:45:00', 'haveri', '2025-07-08 17:51:00', 'To meet abhi', '1751955346_nature.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `districtID` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`districtID`, `district_name`) VALUES
(1, 'Bagalkot'),
(2, 'Ballari'),
(3, 'Belagavi'),
(4, 'Bengaluru Rural'),
(5, 'Bengaluru Urban'),
(6, 'Bidar'),
(7, 'Chamarajanagar'),
(8, 'Chikkaballapura'),
(9, 'Chikkamagaluru'),
(10, 'Chitradurga'),
(11, 'Dakshina Kannada'),
(12, 'Davanagere'),
(13, 'Dharwad'),
(14, 'Gadag'),
(16, 'Hassan'),
(17, 'Haveri'),
(15, 'Kalaburagi'),
(18, 'Kodagu'),
(19, 'Kolar'),
(20, 'Koppal'),
(21, 'Mandya'),
(22, 'Mysuru'),
(23, 'Raichur'),
(24, 'Ramanagara'),
(25, 'Shivamogga'),
(26, 'Tumakuru'),
(27, 'Udupi'),
(28, 'Uttara Kannada'),
(29, 'Vijayanagara'),
(30, 'Vijayapura'),
(31, 'Yadgir');

-- --------------------------------------------------------

--
-- Table structure for table `taluks`
--

CREATE TABLE `taluks` (
  `talukID` int(11) NOT NULL,
  `districtID` int(11) NOT NULL,
  `taluk_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taluks`
--

INSERT INTO `taluks` (`talukID`, `districtID`, `taluk_name`) VALUES
(1, 1, 'Bagalkot'),
(2, 1, 'Jamkhandi'),
(3, 1, 'Mudhol'),
(4, 1, 'Badami'),
(5, 1, 'Bilagi'),
(6, 1, 'Hungund'),
(7, 2, 'Ballari'),
(8, 2, 'Kampli'),
(9, 2, 'Kurugodu'),
(10, 2, 'Sanduru'),
(11, 2, 'Siraguppa'),
(12, 2, 'Hospet'),
(13, 2, 'Hadagali'),
(14, 2, 'Hagaribommanahalli'),
(15, 3, 'Belagavi'),
(16, 3, 'Athani'),
(17, 3, 'Bailhongal'),
(18, 3, 'Chikkodi'),
(19, 3, 'Gokak'),
(20, 3, 'Khanapur'),
(21, 3, 'Mudalgi'),
(22, 3, 'Nippani'),
(23, 3, 'Raybag'),
(24, 3, 'Savadatti'),
(25, 3, 'Ramdurg'),
(26, 3, 'Hukkeri'),
(27, 3, 'Kittur'),
(28, 5, 'Bengaluru North'),
(29, 5, 'Bengaluru South'),
(30, 5, 'Bengaluru East'),
(31, 5, 'Yelahanka'),
(32, 5, 'Anekal'),
(33, 4, 'Doddaballapura'),
(34, 4, 'Devanahalli'),
(35, 4, 'Hoskote'),
(36, 4, 'Nelamangala'),
(37, 6, 'Bidar'),
(38, 6, 'Aurad'),
(39, 6, 'Basavakalyan'),
(40, 6, 'Bhalki'),
(41, 6, 'Humnabad'),
(42, 7, 'Chamarajanagar'),
(43, 7, 'Gundlupete'),
(44, 7, 'Kollegal'),
(45, 7, 'Yelandur'),
(46, 7, 'Hanur'),
(47, 8, 'Chikkaballapura'),
(48, 8, 'Bagepalli'),
(49, 8, 'Chintamani'),
(50, 8, 'Gauribidanur'),
(51, 8, 'Gudibanda'),
(52, 8, 'Sidlaghatta'),
(53, 9, 'Chikkamagaluru'),
(54, 9, 'Kadur'),
(55, 9, 'Koppa'),
(56, 9, 'Mudigere'),
(57, 9, 'Narasimharajapura'),
(58, 9, 'Sringeri'),
(59, 9, 'Tarikere'),
(60, 10, 'Chitradurga'),
(61, 10, 'Hiriyur'),
(62, 10, 'Holalkere'),
(63, 10, 'Hosadurga'),
(64, 10, 'Molakalmuru'),
(65, 11, 'Mangaluru'),
(66, 11, 'Bantwal'),
(67, 11, 'Belthangady'),
(68, 11, 'Puttur'),
(69, 11, 'Sullia'),
(70, 12, 'Davanagere'),
(71, 12, 'Harihara'),
(72, 12, 'Honnali'),
(73, 12, 'Channagiri'),
(74, 12, 'Jagalur'),
(75, 12, 'Nyamati'),
(76, 13, 'Dharwad'),
(77, 13, 'Hubballi'),
(78, 13, 'Kalghatgi'),
(79, 13, 'Kundgol'),
(80, 13, 'Navalgund'),
(81, 14, 'Gadag'),
(82, 14, 'Ron'),
(83, 14, 'Shirhatti'),
(84, 14, 'Mundargi'),
(85, 14, 'Nargund'),
(86, 15, 'Kalaburagi'),
(87, 15, 'Afzalpur'),
(88, 15, 'Aland'),
(89, 15, 'Chincholi'),
(90, 15, 'Chittapur'),
(91, 15, 'Jewargi'),
(92, 15, 'Sedam'),
(93, 15, 'Shahabad'),
(94, 16, 'Hassan'),
(95, 16, 'Alur'),
(96, 16, 'Arsikere'),
(97, 16, 'Belur'),
(98, 16, 'Channarayapatna'),
(99, 16, 'Holenarasipura'),
(100, 16, 'Sakleshpur'),
(101, 16, 'Arakalgud'),
(102, 17, 'Haveri'),
(103, 17, 'Byadgi'),
(104, 17, 'Hanagal'),
(105, 17, 'Hirekerur'),
(106, 17, 'Ranebennur'),
(107, 17, 'Savanur'),
(108, 17, 'Shiggaon'),
(109, 18, 'Madikeri'),
(110, 18, 'Somwarpet'),
(111, 18, 'Virajpet'),
(112, 19, 'Kolar'),
(113, 19, 'Bangarapet'),
(114, 19, 'Malur'),
(115, 19, 'Mulbagal'),
(116, 19, 'Srinivaspur'),
(117, 20, 'Koppal'),
(118, 20, 'Gangavathi'),
(119, 20, 'Kushtagi'),
(120, 20, 'Yelburga'),
(121, 21, 'Mandya'),
(122, 21, 'Krishnarajpet'),
(123, 21, 'Maddur'),
(124, 21, 'Malavalli'),
(125, 21, 'Nagamangala'),
(126, 21, 'Pandavapura'),
(127, 21, 'Shrirangapattana'),
(128, 22, 'Mysuru'),
(129, 22, 'Hunsur'),
(130, 22, 'K.R. Nagar'),
(131, 22, 'Nanjangud'),
(132, 22, 'Periyapatna'),
(133, 22, 'T. Narasipura'),
(134, 22, 'H.D. Kote'),
(135, 23, 'Raichur'),
(136, 23, 'Devadurga'),
(137, 23, 'Lingasugur'),
(138, 23, 'Manvi'),
(139, 23, 'Sindhanur'),
(140, 24, 'Ramanagara'),
(141, 24, 'Channapatna'),
(142, 24, 'Kanakapura'),
(143, 24, 'Magadi'),
(144, 25, 'Shivamogga'),
(145, 25, 'Bhadravati'),
(146, 25, 'Hosanagara'),
(147, 25, 'Sagar'),
(148, 25, 'Shikaripura'),
(149, 25, 'Soraba'),
(150, 25, 'Tirthahalli'),
(151, 26, 'Tumakuru'),
(152, 26, 'Gubbi'),
(153, 26, 'Koratagere'),
(154, 26, 'Kunigal'),
(155, 26, 'Madhugiri'),
(156, 26, 'Pavagada'),
(157, 26, 'Sira'),
(158, 26, 'Tiptur'),
(159, 26, 'Turuvekere'),
(160, 27, 'Udupi'),
(161, 27, 'Karkala'),
(162, 27, 'Kundapura'),
(163, 28, 'Karwar'),
(164, 28, 'Ankola'),
(165, 28, 'Bhatkal'),
(166, 28, 'Dandeli'),
(167, 28, 'Haliyal'),
(168, 28, 'Joida'),
(169, 28, 'Kumta'),
(170, 28, 'Mundgod'),
(171, 28, 'Siddapur'),
(172, 28, 'Sirsi'),
(173, 28, 'Yellapur'),
(174, 29, 'Hosapete'),
(175, 29, 'Hagaribommanahalli'),
(176, 29, 'Harapanahalli'),
(177, 29, 'Kudligi'),
(178, 30, 'Vijayapura'),
(179, 30, 'Basavana Bagewadi'),
(180, 30, 'Indi'),
(181, 30, 'Muddebihal'),
(182, 30, 'Sindagi'),
(183, 30, 'Tikota'),
(184, 31, 'Yadgir'),
(185, 31, 'Shorapur'),
(186, 31, 'Shahapur');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `userID` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `districtID` int(11) NOT NULL,
  `talukID` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`userID`, `userName`, `password`, `districtID`, `talukID`, `status`, `role`) VALUES
(1, 'Bagalkot_admin', 'admin@123', 1, NULL, 1, 'admin'),
(2, 'Ballari_admin', 'admin@123', 2, NULL, 1, 'admin'),
(3, 'Belagavi_admin', 'admin@123', 3, NULL, 1, 'admin'),
(4, 'Bengaluru Rural_admin', 'admin@123', 4, NULL, 1, 'admin'),
(5, 'Bengaluru Urban_admin', 'admin@123', 5, NULL, 1, 'admin'),
(6, 'Bidar_admin', 'admin@123', 6, NULL, 1, 'admin'),
(7, 'Chamarajanagar_admin', 'admin@123', 7, NULL, 1, 'admin'),
(8, 'Chikkaballapura_admin', 'admin@123', 8, NULL, 1, 'admin'),
(9, 'Chikkamagaluru_admin', 'admin@123', 9, NULL, 1, 'admin'),
(10, 'Chitradurga_admin', 'admin@123', 10, NULL, 1, 'admin'),
(11, 'Dakshina Kannada_admin', 'admin@123', 11, NULL, 1, 'admin'),
(12, 'Davanagere_admin', 'admin@123', 12, NULL, 1, 'admin'),
(13, 'Dharwad_admin', 'admin@123', 13, NULL, 1, 'admin'),
(14, 'Gadag_admin', 'admin@123', 14, NULL, 1, 'admin'),
(15, 'Kalaburagi_admin', 'admin@123', 15, NULL, 1, 'admin'),
(16, 'Hassan_admin', 'admin@123', 16, NULL, 1, 'admin'),
(17, 'Haveri_admin', 'admin@123', 17, NULL, 1, 'admin'),
(18, 'Kodagu_admin', 'admin@123', 18, NULL, 1, 'admin'),
(19, 'Kolar_admin', 'admin@123', 19, NULL, 1, 'admin'),
(20, 'Koppal_admin', 'admin@123', 20, NULL, 1, 'admin'),
(21, 'Mandya_admin', 'admin@123', 21, NULL, 1, 'admin'),
(22, 'Mysuru_admin', 'admin@123', 22, NULL, 1, 'admin'),
(23, 'Raichur_admin', 'admin@123', 23, NULL, 1, 'admin'),
(24, 'Ramanagara_admin', 'admin@123', 24, NULL, 1, 'admin'),
(25, 'Shivamogga_admin', 'admin@123', 25, NULL, 1, 'admin'),
(26, 'Tumakuru_admin', 'admin@123', 26, NULL, 1, 'admin'),
(27, 'Udupi_admin', 'admin@123', 27, NULL, 1, 'admin'),
(28, 'Uttara Kannada_admin', 'admin@123', 28, NULL, 1, 'admin'),
(29, 'Vijayanagara_admin', 'admin@123', 29, NULL, 1, 'admin'),
(30, 'Vijayapura_admin', 'admin@123', 30, NULL, 1, 'admin'),
(31, 'Yadgir_admin', 'admin@123', 31, NULL, 1, 'admin'),
(32, 'dummyUser', '$2y$10$YOx5LzO5CEV7paUaVSHa6OEBuGPNbjgadGHD.eWqxqQl5cqn3od3m', 12, 70, 1, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_table`
--
ALTER TABLE `activity_table`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`districtID`),
  ADD UNIQUE KEY `district_name` (`district_name`);

--
-- Indexes for table `taluks`
--
ALTER TABLE `taluks`
  ADD PRIMARY KEY (`talukID`),
  ADD KEY `districtID` (`districtID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD KEY `districtID` (`districtID`),
  ADD KEY `talukID` (`talukID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_table`
--
ALTER TABLE `activity_table`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `districtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `taluks`
--
ALTER TABLE `taluks`
  MODIFY `talukID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `taluks`
--
ALTER TABLE `taluks`
  ADD CONSTRAINT `taluks_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`);

--
-- Constraints for table `user_table`
--
ALTER TABLE `user_table`
  ADD CONSTRAINT `user_table_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`),
  ADD CONSTRAINT `user_table_ibfk_2` FOREIGN KEY (`talukID`) REFERENCES `taluks` (`talukID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
