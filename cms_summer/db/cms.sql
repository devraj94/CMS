-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2013 at 07:19 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_m_details`
--

CREATE TABLE IF NOT EXISTS `admin_m_details` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `admin_designation` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `institute_id` (`institute_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `admin_m_details`
--

INSERT INTO `admin_m_details` (`admin_id`, `admin_name`, `email_id`, `admin_designation`, `status`, `user_id`, `institute_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 'Admin IITJ', 'admin1@iitj.ac.in', 'abc', 1, 1, 1, '0000-00-00 00:00:00', '2013-07-03 02:17:35', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(3, 'Admin2 IITJ', 'admin2@iitj.ac.in', 'aaa123hgj', 1, 3, 1, '2013-07-09 08:09:29', '2013-07-03 18:18:49', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(7, 'admin MBM', 'admin@mbm.ac.in', 'adfdas', 1, 10, 4, '0000-00-00 00:00:00', '2013-07-07 06:44:17', 'admin@mbm.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_m_details`
--

CREATE TABLE IF NOT EXISTS `assignment_m_details` (
  `assignment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) unsigned NOT NULL,
  `instructor_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `assignment_code` varchar(255) NOT NULL,
  `assignment_no` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `filename` varchar(1000) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cur_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `due_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `permission_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`assignment_id`),
  UNIQUE KEY `institute_id` (`institute_id`,`instructor_id`,`course_id`,`academic_year`,`session`),
  KEY `instructor_id` (`instructor_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_t_details`
--

CREATE TABLE IF NOT EXISTS `assignment_t_details` (
  `tblid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) unsigned NOT NULL,
  `assignment_id` int(11) unsigned NOT NULL,
  `student_id` int(11) unsigned NOT NULL,
  `answer_upload` varchar(1) NOT NULL DEFAULT 'N',
  `upload_status` varchar(1) NOT NULL DEFAULT 'N',
  `grade` varchar(1) DEFAULT NULL,
  `academic_year` varchar(10) NOT NULL,
  `session` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uploaded_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `student_id` (`student_id`,`assignment_id`,`institute_id`),
  KEY `institute_id` (`institute_id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor`
--

CREATE TABLE IF NOT EXISTS `course_instructor` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) unsigned NOT NULL,
  `program_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned NOT NULL,
  `instructor_id` int(11) unsigned NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `semester` int(1) NOT NULL,
  `feedback_status` varchar(1) NOT NULL DEFAULT 'N',
  `session` int(1) NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `academic_year` (`academic_year`,`course_id`,`instructor_id`,`session`,`institute_id`,`department_id`,`program_id`),
  KEY `institute_id` (`institute_id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `program_id` (`program_id`),
  KEY `department_id` (`department_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `course_instructor`
--

INSERT INTO `course_instructor` (`tblid`, `course_id`, `program_id`, `department_id`, `instructor_id`, `academic_year`, `semester`, `feedback_status`, `session`, `institute_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(3, 9, 1, 1, 3, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:27:49', 'admin1@iitj.ac.in', NULL),
(4, 10, 1, 2, 4, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:28:11', 'admin1@iitj.ac.in', NULL),
(5, 12, 1, 3, 5, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:28:40', 'admin1@iitj.ac.in', NULL),
(6, 13, 1, 4, 6, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:29:04', 'admin1@iitj.ac.in', NULL),
(7, 14, 1, 4, 7, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:29:30', 'admin1@iitj.ac.in', NULL),
(8, 15, 1, 3, 4, '2013-14', 1, 'N', 1, 1, '0000-00-00 00:00:00', '2013-07-09 09:14:28', 'admin1@iitj.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_m_details`
--

CREATE TABLE IF NOT EXISTS `course_m_details` (
  `course_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_code` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `description_file_path` varchar(555) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `institute_id` int(11) unsigned NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`,`institute_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `course_m_details`
--

INSERT INTO `course_m_details` (`course_id`, `course_code`, `course_title`, `description`, `description_file_path`, `status`, `institute_id`, `created_by`, `updated_at`, `created_at`, `updated_by`) VALUES
(9, '100001', 'Mathematics -I', 'm1', 'files/course_description//Indian Institute of Technology Jodhpur/100001/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '2013-07-10 06:16:51', '2013-07-08 16:25:36', 'admin1@iitj.ac.in'),
(10, '100002', 'Physic-I', 'p1', 'files/course_description//Indian Institute of Technology Jodhpur/100002/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:26:33', NULL),
(12, '100003', 'English Communication Skills', 'ecs', '', 1, 1, 'admin1@iitj.ac.in', '2013-07-08 20:15:28', '2013-07-08 16:37:12', NULL),
(13, '100004', 'Programming and Data Structure', 'pda', '', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:47:05', NULL),
(14, '100005', 'Engineering Graphics', 'EG', '', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:47:46', NULL),
(15, '100006', 'French Language', 'FL', '', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:48:24', NULL),
(16, '300001', 'Mathematics – III', 'm3', 'files/course_description//Indian Institute of Technology Jodhpur/300001/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:50:58', NULL),
(17, '300002', 'Physics-III', 'p3', 'files/course_description//Indian Institute of Technology Jodhpur/300002/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:51:51', NULL),
(18, '300003', 'Data Structures And Algorithms', 'dsa', 'files/course_description//Indian Institute of Technology Jodhpur/300003/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 16:52:35', NULL),
(19, '300004', 'Introduction to Electronics', 'IE', 'files/course_description//Indian Institute of Technology Jodhpur/300004/NH 65_RJ SH 61 to Raika Bagh Station Rd - Google Maps.pdf', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 17:00:20', NULL),
(20, '300005', 'Biology Lab', 'BL', '', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-08 17:00:56', NULL),
(25, '111111', 'test', 'test 123', 'files/course_description//Indian Institute of Technology Jodhpur/111111/abc.pdf', 1, 1, 'admin1@iitj.ac.in', '2013-07-09 11:20:31', '2013-07-09 06:44:26', 'admin1@iitj.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `department_m_details`
--

CREATE TABLE IF NOT EXISTS `department_m_details` (
  `department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_code` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `institute_id` int(11) unsigned NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `department_code` (`department_code`,`institute_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `department_m_details`
--

INSERT INTO `department_m_details` (`department_id`, `department_code`, `department_name`, `status`, `institute_id`, `created_by`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 'CSE', 'Computer Science and Engineering', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:05:44', NULL),
(2, 'EE', 'Electrical Engineering', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:10', NULL),
(3, 'ME', 'Mechanical Engineering', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:28', NULL),
(4, 'SS', 'Systems Science', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:46', NULL),
(5, 'ICT', 'Information and Communication Technologies', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:08:04', NULL),
(6, 'BISS', 'Biologically Inspired Systems Science', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:08:23', NULL),
(7, 'MSS', 'System Science', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:09:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_m_details`
--

CREATE TABLE IF NOT EXISTS `group_m_details` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `instructor_id` int(11) unsigned NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `total_groups` int(11) unsigned NOT NULL,
  `student_no` int(11) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `session` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `institute_id` (`institute_id`,`course_id`,`instructor_id`),
  KEY `course_id` (`course_id`),
  KEY `instructor_id` (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_t_details`
--

CREATE TABLE IF NOT EXISTS `group_t_details` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `student_id` int(11) unsigned NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `session` int(11) NOT NULL,
  `semester` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  KEY `institute_id` (`institute_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `institute_m_details`
--

CREATE TABLE IF NOT EXISTS `institute_m_details` (
  `institute_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `institute_name` varchar(255) NOT NULL,
  `institute_short_name` varchar(255) NOT NULL,
  `institute_address` varchar(200) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pin_code` int(6) NOT NULL,
  `state` varchar(255) NOT NULL,
  `landline_no` varchar(12) DEFAULT NULL,
  `institute_domain` varchar(255) NOT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `institute_fax` varchar(45) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `admin_name` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `activation_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activated_by` varchar(255) DEFAULT NULL,
  `institute_logo` varchar(550) DEFAULT NULL,
  PRIMARY KEY (`institute_id`),
  UNIQUE KEY `institute_name` (`institute_name`),
  UNIQUE KEY `institute_short_name` (`institute_short_name`),
  UNIQUE KEY `institute_name_2` (`institute_name`),
  UNIQUE KEY `institute_short_name_2` (`institute_short_name`),
  UNIQUE KEY `institute_domain` (`institute_domain`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `institute_m_details`
--

INSERT INTO `institute_m_details` (`institute_id`, `institute_name`, `institute_short_name`, `institute_address`, `city`, `pin_code`, `state`, `landline_no`, `institute_domain`, `email_id`, `institute_fax`, `status`, `admin_name`, `updated_at`, `created_at`, `created_by`, `updated_by`, `activation_date`, `activated_by`, `institute_logo`) VALUES
(1, 'Indian Institute of Technology Jodhpur', 'IITJ', 'gpra, iitj', 'Jodhpur', 342005, 'Rajasthan', '9778866551', 'https://iitj.ac.in', 'institute@iitj.ac.in', '654-326-765676', 1, 'Admin IITJ', '2013-07-06 16:22:05', '2013-07-03 02:17:34', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in', '0000-00-00 00:00:00', NULL, 'files/institute_logo//Indian Institute of Technology Jodhpur/logo2.png'),
(4, 'MBM Jodhpur', 'MBM', 'sdvfsf', 'Jodhpur', 342005, 'Rajasthan', '9778866551', 'https://mbm.in', 'mbm@mbm.in', '654-326-765676', 0, 'admin MBM', '0000-00-00 00:00:00', '2013-07-07 06:44:16', 'admin@mbm.ac.in', NULL, '0000-00-00 00:00:00', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_m_details`
--

CREATE TABLE IF NOT EXISTS `instructor_m_details` (
  `instructor_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `instructor_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) NOT NULL,
  `contactNo` int(12) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `institute_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`instructor_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `instructor_m_details`
--

INSERT INTO `instructor_m_details` (`instructor_id`, `instructor_name`, `address`, `email_id`, `contactNo`, `status`, `institute_id`, `user_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(3, 'Abhishek Mishra', 'GPRA', 'amishra@iitj.ac.in', 978999237, 1, 1, 17, '2013-07-09 12:39:09', '2013-07-08 18:13:58', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(4, 'Abdul Gafoor Shaik', '1103-B, Admin Block-I IIT Jodhpur', 'saadgafoor@iitj.ac.in', 91, 1, 1, 18, '0000-00-00 00:00:00', '2013-07-08 18:17:26', 'admin1@iitj.ac.in', NULL),
(5, 'Ambesh Dixit', 'Room 1109, Academic Block-I', 'ambesh@iitj.ac.in', 2147483647, 1, 1, 19, '0000-00-00 00:00:00', '2013-07-08 18:19:24', 'admin1@iitj.ac.in', NULL),
(6, 'Amit Mishra', 'Room No. 1112 IIT Rajasthan', 'amit@iitj.ac.in', 2147483647, 1, 1, 20, '0000-00-00 00:00:00', '2013-07-08 18:20:07', 'admin1@iitj.ac.in', NULL),
(7, 'Anand Krishnan Plappally', '3106, Administrative Block, IIT Rajasthanfjhfjh', 'anandk@iitj.ac.in', 291, 1, 1, 21, '2013-07-09 04:38:53', '2013-07-08 18:20:53', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `program_department`
--

CREATE TABLE IF NOT EXISTS `program_department` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) unsigned NOT NULL,
  `program_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `department_id` (`department_id`,`program_id`,`institute_id`),
  KEY `institute_id` (`institute_id`),
  KEY `program_id` (`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `program_department`
--

INSERT INTO `program_department` (`tblid`, `department_id`, `program_id`, `institute_id`, `created_by`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 1, 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:05:44', NULL),
(2, 2, 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:10', NULL),
(3, 3, 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:28', NULL),
(4, 4, 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:07:47', NULL),
(5, 5, 2, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:08:04', NULL),
(6, 6, 4, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:08:23', NULL),
(7, 7, 3, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 05:09:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_m_details`
--

CREATE TABLE IF NOT EXISTS `program_m_details` (
  `program_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `program_code` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `institute_id` int(11) unsigned NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  UNIQUE KEY `program_code` (`program_code`,`institute_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `program_m_details`
--

INSERT INTO `program_m_details` (`program_id`, `program_code`, `program_name`, `status`, `institute_id`, `created_by`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 'BT', 'B.Tech', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 04:06:17', NULL),
(2, 'MT', 'M.Tech', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 04:09:07', NULL),
(3, 'MS', 'M.Sc.', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 04:09:45', NULL),
(4, 'PD', 'PhD', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 04:14:03', NULL),
(5, 'abc', 'adfad', 1, 1, 'admin1@iitj.ac.in', '0000-00-00 00:00:00', '2013-07-06 04:14:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_m_details`
--

CREATE TABLE IF NOT EXISTS `role_m_details` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `role_m_details`
--

INSERT INTO `role_m_details` (`role_id`, `role_name`, `description`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 'Master', 'master', '2013-07-02 17:41:02', '2013-07-02 15:35:19', NULL, NULL),
(2, 'Primary Admin', NULL, '0000-00-00 00:00:00', '2013-07-02 17:37:06', NULL, NULL),
(3, 'Secondary Admin', NULL, '0000-00-00 00:00:00', '2013-07-02 17:38:07', NULL, NULL),
(4, 'Instructor', NULL, '0000-00-00 00:00:00', '2013-07-02 17:39:10', NULL, NULL),
(5, 'Teaching Asistant', NULL, '0000-00-00 00:00:00', '2013-07-02 17:40:03', NULL, NULL),
(6, 'Student', NULL, '0000-00-00 00:00:00', '2013-07-02 17:41:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `session` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `academic_year` (`academic_year`,`course_id`,`student_id`,`session`,`institute_id`),
  KEY `institute_id` (`institute_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`tblid`, `student_id`, `course_id`, `institute_id`, `academic_year`, `session`, `semester`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(4, 6, 9, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:35:29', 'admin1@iitj.ac.in', NULL),
(5, 6, 10, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:47:05', 'admin1@iitj.ac.in', NULL),
(6, 6, 12, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 11:21:27', 'admin1@iitj.ac.in', NULL),
(7, 6, 13, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 11:22:12', 'admin1@iitj.ac.in', NULL),
(8, 6, 14, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 11:22:48', 'admin1@iitj.ac.in', NULL),
(9, 6, 15, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 11:23:13', 'admin1@iitj.ac.in', NULL),
(10, 7, 9, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:12:57', 'admin1@iitj.ac.in', NULL),
(11, 7, 10, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:14:59', 'admin1@iitj.ac.in', NULL),
(12, 7, 12, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:15:23', 'admin1@iitj.ac.in', NULL),
(13, 8, 15, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:17:10', 'admin1@iitj.ac.in', NULL),
(14, 8, 14, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:17:30', 'admin1@iitj.ac.in', NULL),
(15, 8, 13, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:17:50', 'admin1@iitj.ac.in', NULL),
(16, 9, 15, 1, '2013-14', 1, 1, '0000-00-00 00:00:00', '2013-07-11 01:45:07', 'admin1@iitj.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_m_details`
--

CREATE TABLE IF NOT EXISTS `student_m_details` (
  `student_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roll_no` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pin_code` int(6) DEFAULT '0',
  `mobile_no` int(12) DEFAULT '0',
  `blood_group` varchar(5) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email_id` (`email_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `roll_no` (`roll_no`,`institute_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student_m_details`
--

INSERT INTO `student_m_details` (`student_id`, `roll_no`, `student_name`, `father_name`, `mother_name`, `email_id`, `address`, `pin_code`, `mobile_no`, `blood_group`, `status`, `user_id`, `institute_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(3, 'ug201010001', 'Amar Singh', NULL, NULL, 'amarsingh@iitj.ac.in', NULL, 0, 0, NULL, 1, 14, 1, '0000-00-00 00:00:00', '2013-07-07 15:56:18', 'admin1@iitj.ac.in', NULL),
(4, 'ug201010002', 'Aman Deep', NULL, NULL, 'amandeep@iitj.ac.in', NULL, 0, 0, NULL, 1, 15, 1, '0000-00-00 00:00:00', '2013-07-08 14:36:32', 'admin1@iitj.ac.in', NULL),
(5, 'ug201010003', 'Hamzah Khan', NULL, NULL, 'hamzah@iitj.ac.in', NULL, 0, 0, NULL, 1, 16, 1, '0000-00-00 00:00:00', '2013-07-08 14:55:11', 'admin1@iitj.ac.in', NULL),
(6, 'UG201210014', 'ABHISHEK SAINI', NULL, NULL, 'student1@iitj.ac.in', NULL, 0, 0, NULL, 1, 22, 1, '0000-00-00 00:00:00', '2013-07-08 18:35:29', 'admin1@iitj.ac.in', NULL),
(7, 'UG201210015', 'AMIT RAJ', NULL, NULL, 'araj15@iitj.ac.in', NULL, 0, 0, NULL, 1, 23, 1, '0000-00-00 00:00:00', '2013-07-10 13:12:57', 'admin1@iitj.ac.in', NULL),
(8, 'UG201210016', 'APURV GUPTA', NULL, NULL, 'aprgupta16@iitj.ac.in', NULL, 0, 0, NULL, 1, 24, 1, '0000-00-00 00:00:00', '2013-07-10 13:17:09', 'admin1@iitj.ac.in', NULL),
(9, 'ug201010020', 'test', NULL, NULL, 'student4@iitj.ac.in', NULL, 0, 0, NULL, 1, 25, 1, '0000-00-00 00:00:00', '2013-07-11 01:45:07', 'admin1@iitj.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_t_details`
--

CREATE TABLE IF NOT EXISTS `student_t_details` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned NOT NULL,
  `program_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `student_id` (`student_id`),
  KEY `institute_id` (`institute_id`),
  KEY `department_id` (`department_id`),
  KEY `program_id` (`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `student_t_details`
--

INSERT INTO `student_t_details` (`tblid`, `student_id`, `department_id`, `program_id`, `institute_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 3, 1, 1, 1, '0000-00-00 00:00:00', '2013-07-07 15:56:18', 'admin1@iitj.ac.in', NULL),
(2, 4, 1, 1, 1, '0000-00-00 00:00:00', '2013-07-08 14:36:33', 'admin1@iitj.ac.in', NULL),
(3, 5, 1, 1, 1, '0000-00-00 00:00:00', '2013-07-08 14:55:11', 'admin1@iitj.ac.in', NULL),
(4, 6, 2, 1, 1, '0000-00-00 00:00:00', '2013-07-08 18:35:29', 'admin1@iitj.ac.in', NULL),
(5, 7, 1, 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:12:57', 'admin1@iitj.ac.in', NULL),
(6, 8, 4, 1, 1, '0000-00-00 00:00:00', '2013-07-10 13:17:09', 'admin1@iitj.ac.in', NULL),
(7, 9, 2, 1, 1, '0000-00-00 00:00:00', '2013-07-11 01:45:07', 'admin1@iitj.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ta_instructor_course`
--

CREATE TABLE IF NOT EXISTS `ta_instructor_course` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ta_id` int(11) unsigned NOT NULL,
  `instructor_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `semester` int(1) NOT NULL,
  `session` int(11) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `academic_year` (`academic_year`,`course_id`,`instructor_id`,`session`,`institute_id`,`ta_id`),
  KEY `institute_id` (`institute_id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `ta_id` (`ta_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ta_m_details`
--

CREATE TABLE IF NOT EXISTS `ta_m_details` (
  `ta_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ta_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) NOT NULL,
  `contactNo` int(12) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `institute_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ta_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `institute_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `institute_id` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `institute_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 'admin1@iitj.ac.in', 'iitjadmin', 1, '2013-07-04 07:51:03', '2013-07-03 02:17:34', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(3, 'admin2@iitj.ac.in', 'Zxr3a', 1, '0000-00-00 00:00:00', '2013-07-03 18:18:49', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(10, 'admin@mbm.ac.in', 'TXoiT', 4, '0000-00-00 00:00:00', '2013-07-07 06:44:16', 'admin@mbm.ac.in', NULL),
(14, 'amarsingh@iitj.ac.in', 'IrVEq', 1, '0000-00-00 00:00:00', '2013-07-07 15:56:17', 'admin1@iitj.ac.in', NULL),
(15, 'amandeep@iitj.ac.in', 'DRLwb', 1, '0000-00-00 00:00:00', '2013-07-08 14:36:32', 'admin1@iitj.ac.in', NULL),
(16, 'hamzah@iitj.ac.in', 'ZKw2j', 1, '0000-00-00 00:00:00', '2013-07-08 14:55:10', 'admin1@iitj.ac.in', NULL),
(17, 'amishra@iitj.ac.in', '1jwRw', 1, '0000-00-00 00:00:00', '2013-07-08 18:13:58', 'admin1@iitj.ac.in', NULL),
(18, 'saadgafoor@iitj.ac.in', 'RXL55', 1, '0000-00-00 00:00:00', '2013-07-08 18:17:26', 'admin1@iitj.ac.in', NULL),
(19, 'ambesh@iitj.ac.in', 'E7lhI', 1, '0000-00-00 00:00:00', '2013-07-08 18:19:24', 'admin1@iitj.ac.in', NULL),
(20, 'amit@iitj.ac.in', 'dha62', 1, '0000-00-00 00:00:00', '2013-07-08 18:20:07', 'admin1@iitj.ac.in', NULL),
(21, 'anandk@iitj.ac.in', 'Gf8ya', 1, '0000-00-00 00:00:00', '2013-07-08 18:20:53', 'admin1@iitj.ac.in', NULL),
(22, 'student1@iitj.ac.in', 'W3p5E', 1, '0000-00-00 00:00:00', '2013-07-08 18:35:28', 'admin1@iitj.ac.in', NULL),
(23, 'araj15@iitj.ac.in', 'UJzSP', 1, '0000-00-00 00:00:00', '2013-07-10 13:12:56', 'admin1@iitj.ac.in', NULL),
(24, 'aprgupta16@iitj.ac.in', 'MTMWU', 1, '0000-00-00 00:00:00', '2013-07-10 13:17:09', 'admin1@iitj.ac.in', NULL),
(25, 'student4@iitj.ac.in', 'mVacH', 1, '0000-00-00 00:00:00', '2013-07-11 01:45:07', 'admin1@iitj.ac.in', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_role`
--

CREATE TABLE IF NOT EXISTS `users_role` (
  `tblid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tblid`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `users_role`
--

INSERT INTO `users_role` (`tblid`, `user_id`, `role_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '2013-07-03 02:17:35', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(2, 1, 2, '0000-00-00 00:00:00', '2013-07-03 02:17:35', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(4, 3, 3, '2013-07-04 08:11:10', '2013-07-03 18:18:49', 'admin1@iitj.ac.in', 'admin1@iitj.ac.in'),
(11, 10, 2, '0000-00-00 00:00:00', '2013-07-07 06:44:16', 'admin@mbm.ac.in', NULL),
(15, 14, 6, '0000-00-00 00:00:00', '2013-07-07 15:56:18', 'admin1@iitj.ac.in', NULL),
(16, 15, 6, '0000-00-00 00:00:00', '2013-07-08 14:36:32', 'admin1@iitj.ac.in', NULL),
(17, 16, 6, '0000-00-00 00:00:00', '2013-07-08 14:55:11', 'admin1@iitj.ac.in', NULL),
(18, 17, 4, '0000-00-00 00:00:00', '2013-07-08 18:13:58', 'admin1@iitj.ac.in', NULL),
(19, 18, 4, '0000-00-00 00:00:00', '2013-07-08 18:17:26', 'admin1@iitj.ac.in', NULL),
(20, 19, 4, '0000-00-00 00:00:00', '2013-07-08 18:19:24', 'admin1@iitj.ac.in', NULL),
(21, 20, 4, '0000-00-00 00:00:00', '2013-07-08 18:20:07', 'admin1@iitj.ac.in', NULL),
(22, 21, 4, '0000-00-00 00:00:00', '2013-07-08 18:20:53', 'admin1@iitj.ac.in', NULL),
(23, 22, 6, '0000-00-00 00:00:00', '2013-07-08 18:35:29', 'admin1@iitj.ac.in', NULL),
(24, 23, 6, '0000-00-00 00:00:00', '2013-07-10 13:12:57', 'admin1@iitj.ac.in', NULL),
(25, 24, 6, '0000-00-00 00:00:00', '2013-07-10 13:17:09', 'admin1@iitj.ac.in', NULL),
(26, 25, 6, '0000-00-00 00:00:00', '2013-07-11 01:45:07', 'admin1@iitj.ac.in', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_m_details`
--
ALTER TABLE `admin_m_details`
  ADD CONSTRAINT `admin_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_m_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `assignment_m_details`
--
ALTER TABLE `assignment_m_details`
  ADD CONSTRAINT `assignment_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_m_details_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor_m_details` (`instructor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_m_details_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course_m_details` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `assignment_t_details`
--
ALTER TABLE `assignment_t_details`
  ADD CONSTRAINT `assignment_t_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_t_details_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `assignment_m_details` (`assignment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_t_details_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student_m_details` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD CONSTRAINT `course_instructor_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor_m_details` (`instructor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_3` FOREIGN KEY (`program_id`) REFERENCES `program_m_details` (`program_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_4` FOREIGN KEY (`department_id`) REFERENCES `department_m_details` (`department_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_5` FOREIGN KEY (`course_id`) REFERENCES `course_m_details` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_m_details`
--
ALTER TABLE `course_m_details`
  ADD CONSTRAINT `course_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE;

--
-- Constraints for table `department_m_details`
--
ALTER TABLE `department_m_details`
  ADD CONSTRAINT `department_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE;

--
-- Constraints for table `group_m_details`
--
ALTER TABLE `group_m_details`
  ADD CONSTRAINT `group_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_m_details_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course_m_details` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_m_details_ibfk_3` FOREIGN KEY (`instructor_id`) REFERENCES `instructor_m_details` (`instructor_id`) ON DELETE CASCADE;

--
-- Constraints for table `group_t_details`
--
ALTER TABLE `group_t_details`
  ADD CONSTRAINT `group_t_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_t_details_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `group_m_details` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_t_details_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student_m_details` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `instructor_m_details`
--
ALTER TABLE `instructor_m_details`
  ADD CONSTRAINT `instructor_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_m_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `program_department`
--
ALTER TABLE `program_department`
  ADD CONSTRAINT `program_department_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department_m_details` (`department_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_department_ibfk_3` FOREIGN KEY (`program_id`) REFERENCES `program_m_details` (`program_id`) ON DELETE CASCADE;

--
-- Constraints for table `program_m_details`
--
ALTER TABLE `program_m_details`
  ADD CONSTRAINT `program_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_m_details` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_course_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course_m_details` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_m_details`
--
ALTER TABLE `student_m_details`
  ADD CONSTRAINT `student_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_m_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_t_details`
--
ALTER TABLE `student_t_details`
  ADD CONSTRAINT `student_t_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_t_details_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_m_details` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_t_details_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department_m_details` (`department_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_t_details_ibfk_4` FOREIGN KEY (`program_id`) REFERENCES `program_m_details` (`program_id`) ON DELETE CASCADE;

--
-- Constraints for table `ta_instructor_course`
--
ALTER TABLE `ta_instructor_course`
  ADD CONSTRAINT `ta_instructor_course_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ta_instructor_course_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor_m_details` (`instructor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ta_instructor_course_ibfk_3` FOREIGN KEY (`ta_id`) REFERENCES `ta_m_details` (`ta_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ta_instructor_course_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `course_m_details` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `ta_m_details`
--
ALTER TABLE `ta_m_details`
  ADD CONSTRAINT `ta_m_details_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ta_m_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute_m_details` (`institute_id`) ON DELETE CASCADE;

--
-- Constraints for table `users_role`
--
ALTER TABLE `users_role`
  ADD CONSTRAINT `users_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role_m_details` (`role_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
