-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 03:40 PM
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
  `Password` varchar(255) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `username`, `email`, `Password`, `Action`, `Timestamp`) VALUES
(1, 'admin1', 'admin3@example.com', 'admin123', 'Account Created', '2024-12-27 12:00:00'),
(2, 'admin2', 'admin4@example.com', 'password123', 'Logged In', '2024-12-27 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `ApplicationID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `VolunteerID` int(11) NOT NULL,
  `ApplicationDate` date DEFAULT curdate(),
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`ApplicationID`, `EventID`, `VolunteerID`, `ApplicationDate`, `Status`) VALUES
(1, 1, 1, '2024-12-31', 'Pending'),
(2, 2, 2, '2024-12-31', 'Approved'),
(3, 3, 3, '2024-12-31', 'Approved'),
(4, 4, 4, '2024-12-31', 'Pending'),
(5, 5, 5, '2024-12-31', 'Pending'),
(6, 6, 6, '2024-12-31', 'Approved'),
(7, 7, 7, '2024-12-31', 'Pending'),
(8, 8, 8, '2024-12-31', 'Pending'),
(9, 9, 9, '2024-12-31', 'Approved'),
(10, 10, 10, '2024-12-31', 'Pending'),
(11, 1, 11, '2024-12-31', 'Pending'),
(12, 2, 12, '2024-12-31', 'Pending'),
(13, 3, 13, '2024-12-31', 'Approved'),
(14, 4, 14, '2024-12-31', 'Pending'),
(15, 5, 15, '2024-12-31', 'Pending'),
(16, 3, 1, '2024-12-31', 'Pending'),
(17, 2, 1, '2024-12-31', 'Rejected'),
(18, 7, 1, '2025-01-04', 'Pending'),
(19, 12, 1, '2025-01-04', 'Pending'),
(21, 6, 1, '2025-01-04', 'Pending'),
(22, 9, 1, '2025-01-04', 'Pending'),
(23, 8, 1, '2025-01-04', 'Pending'),
(24, 10, 1, '2025-01-04', 'Pending'),
(25, 1, 2, '2025-01-04', 'Pending'),
(26, 9, 2, '2025-01-05', 'Pending'),
(27, 10, 2, '2025-01-05', 'Pending'),
(28, 8, 2, '2025-01-05', 'Pending'),
(29, 6, 2, '2025-01-05', 'Pending'),
(30, 11, 2, '2025-01-05', 'Pending'),
(31, 12, 2, '2025-01-05', 'Pending'),
(32, 3, 2, '2025-01-06', 'Pending'),
(33, 7, 2, '2025-01-06', 'Pending'),
(34, 10, 4, '2025-01-06', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `assistance_requests`
--

CREATE TABLE `assistance_requests` (
  `RequestID` int(11) NOT NULL,
  `VolunteerID` int(11) NOT NULL,
  `AssistanceID` int(11) NOT NULL,
  `RequestDate` datetime NOT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assistance_requests`
--

INSERT INTO `assistance_requests` (`RequestID`, `VolunteerID`, `AssistanceID`, `RequestDate`, `Status`) VALUES
(1, 2, 1, '2025-01-06 00:55:06', 'Pending'),
(2, 4, 3, '2025-01-06 19:02:19', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `CertificateID` int(11) NOT NULL,
  `VolunteerID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `OrgID` int(11) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`CertificateID`, `VolunteerID`, `Date`, `OrgID`, `Description`) VALUES
(1, 1, '2023-12-01', 0, NULL),
(2, 2, '2023-12-10', 0, NULL),
(3, 3, '2023-12-15', 0, NULL),
(4, 4, '2023-11-20', 0, NULL),
(5, 5, '2023-12-05', 0, NULL),
(6, 3, '2025-01-06', 7, 'hello good job'),
(7, 2, '2025-01-06', 7, 'hello good job');

-- --------------------------------------------------------

--
-- Table structure for table `emergencyassistance`
--

CREATE TABLE `emergencyassistance` (
  `AssistanceID` int(11) NOT NULL,
  `OrgID` int(11) DEFAULT NULL,
  `SupportTool` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencyassistance`
--

INSERT INTO `emergencyassistance` (`AssistanceID`, `OrgID`, `SupportTool`) VALUES
(1, 1, 'First Aid Kit'),
(2, 2, 'Reforestation Tools'),
(3, 3, 'Medical Supplies'),
(4, 4, 'Teaching Kits'),
(5, 5, 'Emergency Food Supplies'),
(6, 6, 'Youth Empowerment Tools'),
(7, 7, 'Animal Rescue Gear'),
(8, 8, 'Social Outreach Materials'),
(9, 9, 'Food Distribution Kits'),
(10, 10, 'Technical Training Kits');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `OrgID`, `EventName`, `Description`, `Date`, `Location`) VALUES
(1, 1, 'Tree Plantation Drive', 'Join us to plant trees and save the environment!', '2024-01-15', 'Central Park, Dhaka'),
(2, 2, 'Clean-Up Campaign', 'Help us clean up the streets of Kathmandu!', '2024-02-10', 'Durbar Square, Kathmandu'),
(3, 1, 'Tree Plantation Drive', 'Join us in planting trees to save the environment.', '2024-01-15', 'Health Center, Karachi'),
(4, 2, 'Clean-Up Campaign', 'Help us clean up the streets of Kathmandu!', '2024-02-10', 'Animal Care Center, Delhi'),
(5, 3, 'Blood Donation Camp', 'Donate blood and save lives in our community.', '2024-01-20', 'Disaster Relief Center, Jakarta'),
(6, 4, 'Animal Welfare Workshop', 'Learn about animal care and welfare.', '2024-03-05', 'Leadership Hall, Singapore'),
(7, 5, 'Disaster Relief Training', 'Training session for disaster response volunteers.', '2024-04-10', 'Pet Adoption Center, Seoul'),
(8, 6, 'Youth Leadership Program', 'Empower youth through leadership workshops.', '2024-02-25', 'Mental Wellness Center, Bangkok'),
(9, 7, 'Pet Adoption Drive', 'Encourage adoption of homeless pets.', '2024-03-15', 'Community Center, Tokyo'),
(10, 8, 'Mental Health Awareness', 'Spread awareness about mental health and well-being.', '2024-02-05', 'Tech Innovation Hub, Singapore'),
(11, 9, 'Charity Food Drive', 'Distribute food to underprivileged communities.', '2024-01-30', NULL),
(12, 10, 'Tech for Good Hackathon', 'Innovate solutions for social issues using technology.', '2024-02-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hires`
--

CREATE TABLE `hires` (
  `HireID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `VolunteerID` int(11) NOT NULL,
  `HireDate` date NOT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hires`
--

INSERT INTO `hires` (`HireID`, `OrgID`, `VolunteerID`, `HireDate`, `Status`) VALUES
(1, 2, 10, '2025-01-05', 'Pending'),
(2, 2, 11, '2025-01-05', 'Pending'),
(3, 2, 12, '2025-01-05', 'Pending'),
(4, 2, 16, '2025-01-05', 'Pending'),
(5, 2, 13, '2025-01-05', 'Pending'),
(6, 2, 14, '2025-01-05', 'Pending'),
(7, 2, 16, '2025-01-05', 'Pending'),
(8, 2, 1, '2025-01-05', 'Pending'),
(9, 7, 3, '2025-01-06', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `InternID` int(11) NOT NULL,
  `OrgID` int(11) DEFAULT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `VolunteerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`InternID`, `OrgID`, `Position`, `VolunteerID`) VALUES
(1, 1, 'Intern Manager', NULL),
(2, 2, 'Environmental Analyst', NULL),
(3, 3, 'Medical Intern', NULL),
(4, 4, 'Education Assistant', NULL),
(5, 5, 'Disaster Response Coordinator', NULL),
(6, 1, 'Software Engineer Intern', NULL),
(7, 1, 'Marketing Intern', NULL),
(8, 1, 'Data Analyst Intern', NULL),
(9, 2, 'Environmental Analyst', NULL),
(10, 2, 'Medical Intern', NULL),
(11, 2, 'Education Assistant', NULL),
(12, 3, 'Intern Manager', NULL),
(13, 3, 'Operations Intern', NULL),
(14, 3, 'Community Outreach Intern', NULL),
(15, 4, 'Graphic Design Intern', NULL),
(16, 4, 'Social Media Intern', NULL),
(17, 4, 'Research Analyst', NULL),
(18, 5, 'Event Management Intern', NULL),
(19, 5, 'Technical Support Intern', NULL),
(20, 5, 'Volunteer Coordinator Intern', NULL),
(21, 6, 'Public Relations Intern', NULL),
(22, 6, 'Content Writing Intern', NULL),
(23, 6, 'Project Coordinator Intern', NULL),
(24, 7, 'Disaster Response Coordinator', NULL),
(25, 7, 'Healthcare Assistant Intern', NULL),
(26, 7, 'Supply Chain Intern', NULL),
(27, 8, 'Finance Intern', NULL),
(28, 8, 'HR Intern', NULL),
(29, 8, 'Legal Intern', NULL),
(30, 9, 'IT Support Intern', NULL),
(31, 9, 'Database Management Intern', NULL),
(32, 9, 'Cybersecurity Intern', NULL),
(33, 10, 'Sustainability Intern', NULL),
(34, 10, 'Urban Planning Intern', NULL),
(35, 10, 'Energy Solutions Intern', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `internship_offers`
--

CREATE TABLE `internship_offers` (
  `OfferID` int(11) NOT NULL,
  `VolunteerID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `InternID` int(11) NOT NULL,
  `DateOffered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship_offers`
--

INSERT INTO `internship_offers` (`OfferID`, `VolunteerID`, `OrgID`, `InternID`, `DateOffered`) VALUES
(1, 2, 7, 24, '2025-01-06 14:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `VolunteerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Password` varchar(255) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `Specialities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`OrgID`, `Name`, `email`, `Type`, `Address`, `Password`, `Picture`, `Specialities`) VALUES
(1, 'Sewa Foundation', 'sewa@example.com', 'Non-Profit', '123 Charity Rd, Dhaka', 'abc56', 'images/org1.png', 'education, IT support'),
(2, 'Green Future', 'greenfuture@example.com', 'Environmental', '456 Eco St, Kathmandu', 'cfg78', 'images/organization_2_1736104051.png', 'environment, planting'),
(3, 'Engine Corp', 'enginecorp@example.com', 'Healthcare', '789 Health Blvd, Karachi', 'bfg34', 'images/org3.png', 'public speaking, healthcare'),
(4, 'Teach Today', 'teachtoday@example.com', 'Education', '321 Learning Rd, Delhi', 'hjk25', 'images/org4.png', 'community outreach, mentoring'),
(5, 'Disaster Relief', 'disasterrelief@example.com', 'Emergency Services', '987 Relief Ln, Jakarta', 'kjf21', 'images/org5.png', 'teaching, project management'),
(6, 'Youth Alliance', 'youthalliance@example.com', 'Youth Programs', '654 Future Rd, Bangkok', 'mri84', 'images/org6.png', 'fundraising, leadership'),
(7, 'Animal Care', 'animalcare@example.com', 'Animal Welfare', '111 Pet St, Seoul', 'dul13', 'images/org7.png', 'graphic design, animation'),
(8, 'Bright Steps', 'brightsteps@example.com', 'Social Work', '222 Smile Ave, Singapore', 'aur12', 'images/org8.png', 'event planning, public relations'),
(9, 'Food Bank Asia', 'foodbankasia@example.com', 'Charity', '555 Food St, Tokyo', 'een34', 'images/org9.png', 'environmental awareness, gardening'),
(10, 'TechBridge', 'techbridge@example.com', 'Technology NGO', '444 Innovation Rd, Singapore', 'mau23', 'images/org10.png', 'social media, content creation');

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
-- Table structure for table `rewards_claimed`
--

CREATE TABLE `rewards_claimed` (
  `ClaimID` int(11) NOT NULL,
  `VolunteerID` int(11) NOT NULL,
  `RewardID` int(11) NOT NULL,
  `ClaimDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Password` varchar(255) DEFAULT NULL,
  `Gender` enum('Male','Female') DEFAULT 'Male',
  `EmergencyHelp` tinyint(1) DEFAULT 0,
  `Picture` varchar(255) DEFAULT NULL,
  `Skills` text DEFAULT NULL,
  `Points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`VolunteerID`, `Name`, `Email`, `Phone`, `Qualifications`, `Approved`, `Password`, `Gender`, `EmergencyHelp`, `Picture`, `Skills`, `Points`) VALUES
(1, 'Ayesha Khan', 'ayesha.khan@example.com', '01812345678', 'Bachelor of Science', 0, 'abc123!', 'Female', 0, NULL, 'teaching, fundraising, IT support', 0),
(2, 'Rajesh Gupta', 'rajesh.gupta@example.com', '01798765432', 'Master of Business Administration', 0, 'bcd234@', 'Male', 1, 'images/male_silhouette.png', 'graphic design, IT support, public speaking', 0),
(3, 'Mina Choi', 'mina.choi@example.com', '01611223344', 'Bachelor of Arts', 0, 'cde345#', 'Female', 0, 'images/female_silhouette.png', 'environment, planting, public speaking', 0),
(4, 'Haruto Tanaka', 'haruto.tanaka@example.com', '01522334455', 'Diploma in Environmental Studies', 0, 'def456$', 'Male', 0, NULL, 'healthcare, mentoring, community outreach', 30),
(5, 'Mei Ling', 'mei.ling@example.com', '01333445566', 'Certified Social Worker', 0, 'efg567%', 'Female', 1, NULL, 'teaching, IT support, project management', 0),
(6, 'Anil Shah', 'anil.shah@example.com', '01455667788', 'Law Degree', 0, 'fgh678^', 'Male', 0, NULL, 'environment, fundraising, leadership', 0),
(7, 'Fatima Noor', 'fatima.noor@example.com', '01866778899', 'Certified Nurse', 0, 'ghi789&', 'Female', 1, 'images/female_silhouette.png', 'graphic design, teaching, animation', 0),
(8, 'Chen Wei', 'chen.wei@example.com', '01977889900', 'Bachelor of Education', 0, 'hij891!', 'Male', 0, NULL, 'community outreach, mentoring, healthcare', 0),
(9, 'Nobita Nobi', 'nobita.nobi@example.com', '01644556677', 'Master of Public Administration', 0, 'ijk123@', 'Male', 0, NULL, 'public speaking, leadership, event planning', 0),
(10, 'Puja Das', 'puja.das@example.com', '01755667788', 'BA in Literature', 0, 'jkl234#', 'Female', 0, NULL, 'data analysis, IT support, fundraising', 0),
(11, 'Ali Akbar', 'ali.akbar@example.com', '01999887766', 'Certified Teacher', 0, 'klm456$', 'Male', 0, NULL, 'graphic design, content writing, teaching', 0),
(12, 'Aarti Verma', 'aarti.verma@example.com', '01811223344', 'Master in Environmental Studies', 0, 'mno567%', 'Female', 0, NULL, 'social media, public relations, event planning', 0),
(13, 'Jin Soo Kim', 'jin.kim@example.com', '01566778899', 'Diploma in Finance', 0, 'nop789^', 'Male', 0, NULL, 'gardening, planting, environmental awareness', 0),
(14, 'Siti Aisyah', 'siti.aisyah@example.com', '01955667788', 'Engineering Degree', 0, 'opq891@', 'Female', 0, NULL, 'fundraising, leadership, mentoring', 0),
(15, 'Thongchai Chaiyasit', 'thongchai.chaiyasit@example.com', '01399887766', 'Diploma in Marketing', 0, 'rst234$', 'Male', 0, NULL, 'public speaking, coaching, teaching', 0),
(16, 'Ayesha Khan', 'ayesha.khan@example.com', '01812345678', 'Bachelor of Science', 0, '$2y$10$/nzIjd3wOpSUGOnktKZb0usrRb0kqIHmvaiFE5n0Zd2Dmaq9tr/EO', 'Male', 0, NULL, NULL, 0),
(17, 'Ishrat Zaman Aureen', 'ishratzaman@example.com', NULL, NULL, 0, '$2y$10$PDAfdR0m2BSfkzyDn1eOhu/4V42c1YhtHgMrdqsP8YJx0tsHTgFda', 'Male', 0, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`ApplicationID`),
  ADD UNIQUE KEY `VolunteerID` (`VolunteerID`,`EventID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `assistance_requests`
--
ALTER TABLE `assistance_requests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `VolunteerID` (`VolunteerID`),
  ADD KEY `AssistanceID` (`AssistanceID`);

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
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `hires`
--
ALTER TABLE `hires`
  ADD PRIMARY KEY (`HireID`),
  ADD KEY `OrgID` (`OrgID`),
  ADD KEY `VolunteerID` (`VolunteerID`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`InternID`),
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD PRIMARY KEY (`OfferID`),
  ADD KEY `VolunteerID` (`VolunteerID`),
  ADD KEY `OrgID` (`OrgID`),
  ADD KEY `InternID` (`InternID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `OrgID` (`OrgID`),
  ADD KEY `VolunteerID` (`VolunteerID`);

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
-- Indexes for table `rewards_claimed`
--
ALTER TABLE `rewards_claimed`
  ADD PRIMARY KEY (`ClaimID`),
  ADD KEY `VolunteerID` (`VolunteerID`),
  ADD KEY `RewardID` (`RewardID`);

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `assistance_requests`
--
ALTER TABLE `assistance_requests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `CertificateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `emergencyassistance`
--
ALTER TABLE `emergencyassistance`
  MODIFY `AssistanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hires`
--
ALTER TABLE `hires`
  MODIFY `HireID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `InternID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `internship_offers`
--
ALTER TABLE `internship_offers`
  MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `rewards_claimed`
--
ALTER TABLE `rewards_claimed`
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `VolunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`) ON DELETE CASCADE;

--
-- Constraints for table `assistance_requests`
--
ALTER TABLE `assistance_requests`
  ADD CONSTRAINT `assistance_requests_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`),
  ADD CONSTRAINT `assistance_requests_ibfk_2` FOREIGN KEY (`AssistanceID`) REFERENCES `emergencyassistance` (`AssistanceID`);

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`);

--
-- Constraints for table `emergencyassistance`
--
ALTER TABLE `emergencyassistance`
  ADD CONSTRAINT `emergencyassistance_ibfk_2` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`),
  ADD CONSTRAINT `fk_orgid` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`) ON DELETE CASCADE;

--
-- Constraints for table `hires`
--
ALTER TABLE `hires`
  ADD CONSTRAINT `hires_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`),
  ADD CONSTRAINT `hires_ibfk_2` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`);

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);

--
-- Constraints for table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD CONSTRAINT `internship_offers_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`),
  ADD CONSTRAINT `internship_offers_ibfk_2` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`),
  ADD CONSTRAINT `internship_offers_ibfk_3` FOREIGN KEY (`InternID`) REFERENCES `internship` (`InternID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`);

--
-- Constraints for table `rewards_claimed`
--
ALTER TABLE `rewards_claimed`
  ADD CONSTRAINT `rewards_claimed_ibfk_1` FOREIGN KEY (`VolunteerID`) REFERENCES `volunteers` (`VolunteerID`),
  ADD CONSTRAINT `rewards_claimed_ibfk_2` FOREIGN KEY (`RewardID`) REFERENCES `rewards` (`RewardID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
