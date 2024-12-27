-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 10:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `volunteerhiredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `username`, `email`, `password`, `Action`, `Timestamp`) VALUES
(1, 'admin1', 'admin3@example.com', 'admin123', 'Account Created', '2024-12-27 12:00:00'),
(2, 'admin2', 'admin4@example.com', 'password123', 'Logged In', '2024-12-27 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `CertificateID` int(11) NOT NULL,
  `VolunteerID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`CertificateID`, `VolunteerID`, `Date`) VALUES
(1, 1, '2023-12-01'),
(2, 2, '2023-12-10'),
(3, 3, '2023-12-15'),
(4, 4, '2023-11-20'),
(5, 5, '2023-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `emergencyassistance`
--

CREATE TABLE `emergencyassistance` (
  `AssistanceID` int(11) NOT NULL,
  `VolunteerID` int(11) DEFAULT NULL,
  `OrgID` int(11) DEFAULT NULL,
  `SupportTool` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencyassistance`
--

INSERT INTO `emergencyassistance` (`AssistanceID`, `VolunteerID`, `OrgID`, `SupportTool`) VALUES
(1, 1, 1, 'First Aid Kit'),
(2, 2, 2, 'Reforestation Tools'),
(3, 3, 3, 'Medical Supplies'),
(4, 4, 4, 'Teaching Kits'),
(5, 5, 5, 'Emergency Food Supplies'),
(6, 6, 6, 'Youth Empowerment Tools'),
(7, 7, 7, 'Animal Rescue Gear'),
(8, 8, 8, 'Social Outreach Materials'),
(9, 9, 9, 'Food Distribution Kits'),
(10, 10, 10, 'Technical Training Kits');

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `InternID` int(11) NOT NULL,
  `OrgID` int(11) DEFAULT NULL,
  `Position` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`InternID`, `OrgID`, `Position`) VALUES
(1, 1, 'Intern Manager'),
(2, 2, 'Environmental Analyst'),
(3, 3, 'Medical Intern'),
(4, 4, 'Education Assistant'),
(5, 5, 'Disaster Response Coordinator');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `OrgID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`OrgID`, `Name`, `email`, `Type`, `Address`, `Password`) VALUES
(1, 'Sewa Foundation', 'sewa@example.com', 'Non-Profit', '123 Charity Rd, Dhaka', 'abc56'),
(2, 'Green Future', 'greenfuture@example.com', 'Environmental', '456 Eco St, Kathmandu', 'cfg78'),
(3, 'Engine Corp', 'enginecorp@example.com', 'Healthcare', '789 Health Blvd, Karachi', 'bfg34'),
(4, 'Teach Today', 'teachtoday@example.com', 'Education', '321 Learning Rd, Delhi', 'hjk25'),
(5, 'Disaster Relief', 'disasterrelief@example.com', 'Emergency Services', '987 Relief Ln, Jakarta', 'kjf21'),
(6, 'Youth Alliance', 'youthalliance@example.com', 'Youth Programs', '654 Future Rd, Bangkok', 'mri84'),
(7, 'Animal Care', 'animalcare@example.com', 'Animal Welfare', '111 Pet St, Seoul', 'dul13'),
(8, 'Bright Steps', 'brightsteps@example.com', 'Social Work', '222 Smile Ave, Singapore', 'aur12'),
(9, 'Food Bank Asia', 'foodbankasia@example.com', 'Charity', '555 Food St, Tokyo', 'een34'),
(10, 'TechBridge', 'techbridge@example.com', 'Technology NGO', '444 Innovation Rd, Singapore', 'mau23');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `RewardID` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `PointCost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`RewardID`, `Description`, `PointCost`) VALUES
(1, 'Voucher', 100),
(2, 'T-shirt', 50),
(3, 'Eco Bag', 150),
(4, 'Notebook', 70);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Area` varchar(100) DEFAULT NULL,
  `HoldingNumber` varchar(50) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Email`, `Phone`, `Address`, `City`, `Area`, `HoldingNumber`, `Age`, `Password`) VALUES
(1, 'Ayesha Khan', 'ayesha.khan@example.com', '01812345678', '123 Gulshan Ave', 'Dhaka', 'Gulshan', 'DHK001', 25, 'abc123!'),
(2, 'Rajesh Gupta', 'rajesh.gupta@example.com', '01798765432', '456 Badda Lane', 'Dhaka', 'Badda', 'DHK002', 28, 'bcd234@'),
(3, 'Mina Choi', 'mina.choi@example.com', '01611223344', '789 Itaewon St', 'Seoul', 'Yongsan', 'SEO001', 27, 'cde345#'),
(4, 'Haruto Tanaka', 'haruto.tanaka@example.com', '01522334455', '321 Shibuya Rd', 'Tokyo', 'Shibuya', 'TOK001', 30, 'def456$'),
(5, 'Mei Ling', 'mei.ling@example.com', '01333445566', '654 Orchard Rd', 'Singapore', 'Orchard', 'SGP001', 26, 'efg567%'),
(6, 'Anil Shah', 'anil.shah@example.com', '01455667788', '987 Bhaktapur Ave', 'Kathmandu', 'Bhaktapur', 'KTM001', 31, 'fgh678^'),
(7, 'Fatima Noor', 'fatima.noor@example.com', '01866778899', '111 Garden St', 'Karachi', 'Clifton', 'KHI001', 29, 'ghi789&'),
(8, 'Chen Wei', 'chen.wei@example.com', '01977889900', '222 Beijing St', 'Beijing', 'Chaoyang', 'BJ001', 24, 'hij891!'),
(9, 'Nobita Nobi', 'nobita.nobi@example.com', '01644556677', '333 Doraemon Lane', 'Tokyo', 'Nerima', 'TOK002', 27, 'ijk123@'),
(10, 'Puja Das', 'puja.das@example.com', '01755667788', '444 New Market Rd', 'Kolkata', 'New Market', 'KOL001', 29, 'jkl234#'),
(11, 'Ali Akbar', 'ali.akbar@example.com', '01999887766', '555 Tariq Rd', 'Lahore', 'Gulberg', 'LHE001', 32, 'klm456$'),
(12, 'Aarti Verma', 'aarti.verma@example.com', '01811223344', '666 Lajpat Nagar', 'Delhi', 'South Delhi', 'DEL001', 28, 'mno567%'),
(13, 'Jin Soo Kim', 'jin.kim@example.com', '01566778899', '777 Gangnam Rd', 'Seoul', 'Gangnam', 'SEO002', 26, 'nop789^'),
(14, 'Siti Aisyah', 'siti.aisyah@example.com', '01955667788', '888 Merdeka Rd', 'Jakarta', 'Menteng', 'JKT001', 27, 'opq891@'),
(15, 'Thongchai Chaiyasit', 'thongchai.chaiyasit@example.com', '01399887766', '999 Sukhumvit Rd', 'Bangkok', 'Sukhumvit', 'BKK001', 30, 'rst234$');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `VolunteerID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Qualifications` varchar(255) DEFAULT NULL,
  `Approved` tinyint(1) DEFAULT 0,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`VolunteerID`, `Name`, `Email`, `Phone`, `Qualifications`, `Approved`, `Password`) VALUES
(1, 'Ayesha Khan', 'ayesha.khan@example.com', '01812345678', 'Bachelor of Science', 0, 'abc123!'),
(2, 'Rajesh Gupta', 'rajesh.gupta@example.com', '01798765432', 'Master of Business Administration', 0, 'bcd234@'),
(3, 'Mina Choi', 'mina.choi@example.com', '01611223344', 'Bachelor of Arts', 0, 'cde345#'),
(4, 'Haruto Tanaka', 'haruto.tanaka@example.com', '01522334455', 'Diploma in Environmental Studies', 0, 'def456$'),
(5, 'Mei Ling', 'mei.ling@example.com', '01333445566', 'Certified Social Worker', 0, 'efg567%'),
(6, 'Anil Shah', 'anil.shah@example.com', '01455667788', 'Law Degree', 0, 'fgh678^'),
(7, 'Fatima Noor', 'fatima.noor@example.com', '01866778899', 'Certified Nurse', 0, 'ghi789&'),
(8, 'Chen Wei', 'chen.wei@example.com', '01977889900', 'Bachelor of Education', 0, 'hij891!'),
(9, 'Nobita Nobi', 'nobita.nobi@example.com', '01644556677', 'Master of Public Administration', 0, 'ijk123@'),
(10, 'Puja Das', 'puja.das@example.com', '01755667788', 'BA in Literature', 0, 'jkl234#'),
(11, 'Ali Akbar', 'ali.akbar@example.com', '01999887766', 'Certified Teacher', 0, 'klm456$'),
(12, 'Aarti Verma', 'aarti.verma@example.com', '01811223344', 'Master in Environmental Studies', 0, 'mno567%'),
(13, 'Jin Soo Kim', 'jin.kim@example.com', '01566778899', 'Diploma in Finance', 0, 'nop789^'),
(14, 'Siti Aisyah', 'siti.aisyah@example.com', '01955667788', 'Engineering Degree', 0, 'opq891@'),
(15, 'Thongchai Chaiyasit', 'thongchai.chaiyasit@example.com', '01399887766', 'Diploma in Marketing', 0, 'rst234$'),
(16, 'Ayesha Khan', 'ayesha.khan@example.com', '01812345678', 'Bachelor of Science', 0, '$2y$10$/nzIjd3wOpSUGOnktKZb0usrRb0kqIHmvaiFE5n0Zd2Dmaq9tr/EO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`CertificateID`),
  ADD KEY `VolunteerID` (`VolunteerID`);

--
-- Indexes for table `emergencyassistance`
--
ALTER TABLE `emergencyassistance`
  ADD PRIMARY KEY (`AssistanceID`),
  ADD KEY `VolunteerID` (`VolunteerID`),
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`InternID`),
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`OrgID`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`RewardID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`VolunteerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `CertificateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emergencyassistance`
--
ALTER TABLE `emergencyassistance`
  MODIFY `AssistanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `InternID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `RewardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `VolunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`);

--
-- Constraints for table `emergencyassistance`
--
ALTER TABLE `emergencyassistance`
  ADD CONSTRAINT `emergencyassistance_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`),
  ADD CONSTRAINT `emergencyassistance_ibfk_2` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
