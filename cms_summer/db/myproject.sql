-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2013 at 12:12 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `admin_designation` varchar(100) DEFAULT NULL,
  `admin_permission_status` int(3) NOT NULL DEFAULT '0',
  `type` varchar(10) DEFAULT 'primary',
  `user_id` int(11) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_id` (`admin_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `name`, `email_id`, `admin_designation`, `admin_permission_status`, `type`, `user_id`, `institute_No`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(2, 'Admin IITJ', 'admin@iitj.ac.in', '', 1, 'primary', 2, 1, '2013-06-18 05:51:07', '2013-06-06 16:19:54', 'iitjadmin', 'instructor1@iitj.ac.in'),
(9, 'Admin1 IITJ abc', 'admin1@iitj.ac.in', 'abc111', 1, 'primary', 7, 1, '2013-06-27 10:35:01', '2013-06-09 18:46:50', 'iitjadmin', 'iitjadmin'),
(10, 'Admin2 IITJ', 'admin2@iitj.ac.in', 'opt4', 1, 'secondary', 8, 1, '2013-06-17 15:13:14', '2013-06-09 18:47:26', 'iitjadmin', 'iitjadmin'),
(11, 'Admin3 IITJ', 'admin3@iitj.ac.in', 'opt2', 1, 'primary', 9, 1, '2013-06-28 10:08:30', '2013-06-10 05:23:19', 'iitjadmin', 'iitjadmin'),
(12, 'Instructor1 IITJ', 'instructor1@iitj.ac.in', 'opt1asads', 1, ' secondary', 3, 1, '2013-06-24 02:05:56', '2013-06-10 06:50:53', 'iitjadmin', 'iitjadmin'),
(13, 'Admin a MBM', 'admin1@mbm.ac.in', 'abc', 1, 'primary', 11, 2, '2013-06-19 05:53:10', '2013-06-11 07:45:49', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in'),
(15, 'admin a JIET', 'admin@jiet.ac.in', 'aaa', 1, 'primary', 14, 5, '2013-06-19 05:53:15', '2013-06-11 12:56:10', 'admin@jiet.ac.in', 'admin@jiet.ac.in'),
(17, 'MBM sec Admin', 'adminx@mbm.in', 'opt1', 1, 'secondary', 32, 2, '2013-06-19 02:26:00', '2013-06-18 07:19:05', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in'),
(18, 'test', 'testMBM@admin.in', 'opt1', 1, 'primary', 37, 2, '2013-06-19 02:22:29', '2013-06-19 07:52:29', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_No` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `topic` text NOT NULL,
  `cur_date` datetime NOT NULL,
  `due_date` varchar(100) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `institute_No` (`institute_No`,`instructor_id`,`course_id`,`assignment_id`,`academic_year`,`session`,`filename`),
  KEY `instructor_id` (`instructor_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_No` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(20) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` varchar(520) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `institute_No` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `status` int(3) DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`course_No`),
  UNIQUE KEY `course_No` (`course_No`),
  UNIQUE KEY `course_id` (`course_id`,`institute_No`),
  KEY `institute_No` (`institute_No`),
  KEY `program_id` (`program_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_No`, `course_id`, `name`, `description`, `department_id`, `institute_No`, `program_id`, `status`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(2, '111011', 'Operating Systems', 'OS', 2, 1, 5, 1, '2013-06-24 18:21:03', '2013-06-12 14:27:52', 'iitjadmin', 'iitjadmin'),
(3, '21001', 'Artificial Intelligence', 'AI ijilio', 2, 1, 5, 1, '2013-06-24 18:21:13', '2013-06-12 15:03:01', 'iitjadmin', 'iitjadmin'),
(4, '310001', 'Introduction to Electrical Engineering', 'IE', 3, 1, 5, 1, '2013-06-24 18:21:22', '2013-06-12 15:04:50', 'iitjadmin', 'iitjadmin'),
(5, '32110', 'Thermodynamics', 'TD', 3, 1, 5, 1, '2013-06-24 18:21:17', '2013-06-12 15:07:27', 'iitjadmin', 'iitjadmin'),
(6, '10012', 'Chemistry', 'chem', 11, 1, 5, 1, '2013-06-24 18:20:36', '2013-06-16 11:58:18', 'iitjadmin', 'iitjadmin'),
(7, '121001', 'Mathematic-1', 'math1', 11, 1, 5, 1, '2013-06-24 18:20:42', '2013-06-16 12:03:58', 'iitjadmin', 'iitjadmin'),
(9, '50001', 'M.tech_Course1', 'course1', 4, 1, 6, 1, '2013-06-24 18:20:59', '2013-06-24 13:06:50', 'iitjadmin', 'iitjadmin'),
(10, '50002', 'M.tech_Course2', 'ICT_Course2', 4, 1, 6, 1, '2013-06-24 18:21:27', '2013-06-24 13:07:52', 'iitjadmin', 'iitjadmin'),
(11, '50003', 'M.tech_Course3', 'Energy_Course1', 5, 1, 6, 1, '2013-06-24 18:21:30', '2013-06-24 13:08:43', 'iitjadmin', 'iitjadmin'),
(12, '50004', 'M.tech_Course4', 'Energy_Course2', 5, 1, 6, 1, '2013-06-24 18:21:32', '2013-06-24 13:09:29', 'iitjadmin', 'iitjadmin'),
(21, '50005', 'M.tech_Course5', 'SS_Course1', 6, 1, 6, 1, '2013-06-24 18:22:48', '2013-06-24 20:12:02', 'iitjadmin', 'iitjadmin'),
(22, '50006', 'M.tech_Course6', 'kvnhkufhsnvu', 6, 1, 6, 1, '2013-06-24 14:53:30', '2013-06-24 20:23:30', 'iitjadmin', 'iitjadmin'),
(23, '30001', 'Fluid Mechanics', 'uiyuiyiuyiuyi', 10, 1, 5, 1, '2013-06-24 14:54:19', '2013-06-24 20:24:19', 'iitjadmin', 'iitjadmin'),
(24, '30002', 'Introduction to Electronics', 'ygtuygiuhiu', 10, 1, 5, 1, '2013-06-24 14:55:59', '2013-06-24 20:25:59', 'iitjadmin', 'iitjadmin'),
(25, '51001', 'PhD_Course1', 'BISS_Course1', 7, 1, 7, 1, '2013-06-24 14:57:48', '2013-06-24 20:27:48', 'iitjadmin', 'iitjadmin'),
(26, '51002', 'PhD_Course2', 'SS_Course1', 8, 1, 7, 1, '2013-06-24 14:58:47', '2013-06-24 20:28:47', 'iitjadmin', 'iitjadmin'),
(27, '51003', 'PhD_Course3', 'ICT_Course1', 9, 1, 7, 1, '2013-06-24 15:01:05', '2013-06-24 20:31:05', 'iitjadmin', 'iitjadmin'),
(28, '30003', 'Mechanics of Solids', 'wiutiowreuiot', 10, 1, 5, 1, '2013-06-24 15:02:25', '2013-06-24 20:32:25', 'iitjadmin', 'iitjadmin');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor`
--

CREATE TABLE IF NOT EXISTS `course_instructor` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `academic_year` varchar(10) DEFAULT NULL,
  `semester` varchar(4) DEFAULT NULL,
  `grade_upload` varchar(3) NOT NULL DEFAULT 'N',
  `grade_submit` varchar(45) NOT NULL DEFAULT 'N',
  `feedback_status` varchar(3) NOT NULL DEFAULT 'N',
  `session` varchar(4) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `no` (`no`),
  UNIQUE KEY `course_id` (`course_id`,`instructor_id`,`academic_year`,`session`,`institute_No`),
  KEY `institute_No` (`institute_No`),
  KEY `instructor_id` (`instructor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `course_instructor`
--

INSERT INTO `course_instructor` (`no`, `course_id`, `instructor_id`, `academic_year`, `semester`, `grade_upload`, `grade_submit`, `feedback_status`, `session`, `institute_No`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(5, 2, 2, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-15 05:15:57', '2013-06-15 10:45:57', 'iitjadmin', 'iitjadmin'),
(6, 3, 3, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-15 06:59:10', '2013-06-15 12:29:10', 'iitjadmin', 'iitjadmin'),
(7, 4, 10, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-15 06:59:46', '2013-06-15 12:29:46', 'iitjadmin', 'iitjadmin'),
(8, 5, 11, '2012-13', '8', 'N', 'N', 'N', '2', 1, '2013-06-15 07:00:09', '2013-06-15 12:30:09', 'iitjadmin', 'iitjadmin'),
(9, 3, 2, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-16 04:15:30', '2013-06-16 09:45:30', 'iitjadmin', 'iitjadmin'),
(10, 4, 2, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-16 04:16:17', '2013-06-16 09:46:17', 'iitjadmin', 'iitjadmin'),
(11, 7, 13, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-16 06:54:46', '2013-06-16 12:24:46', 'iitjadmin', 'iitjadmin'),
(13, 9, 13, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-24 15:14:22', '2013-06-24 20:44:22', 'iitjadmin', 'iitjadmin'),
(14, 10, 13, '2012-13', '6', 'N', 'N', 'N', '2', 1, '2013-06-24 15:14:47', '2013-06-24 20:44:47', 'iitjadmin', 'iitjadmin'),
(15, 11, 14, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:15:14', '2013-06-24 20:45:14', 'iitjadmin', 'iitjadmin'),
(16, 12, 15, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:16:13', '2013-06-24 20:46:13', 'iitjadmin', 'iitjadmin'),
(17, 21, 16, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-24 15:17:07', '2013-06-24 20:47:07', 'iitjadmin', 'iitjadmin'),
(18, 22, 17, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:17:30', '2013-06-24 20:47:30', 'iitjadmin', 'iitjadmin'),
(19, 23, 18, '2012-13', '6', 'N', 'N', 'N', '2', 1, '2013-06-24 15:17:56', '2013-06-24 20:47:56', 'iitjadmin', 'iitjadmin'),
(20, 24, 19, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-24 15:18:19', '2013-06-24 20:48:19', 'iitjadmin', 'iitjadmin'),
(21, 28, 19, '2012-13', '6', 'N', 'N', 'N', '2', 1, '2013-06-24 15:18:45', '2013-06-24 20:48:45', 'iitjadmin', 'iitjadmin'),
(22, 25, 14, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:19:09', '2013-06-24 20:49:09', 'iitjadmin', 'iitjadmin'),
(23, 26, 15, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:19:36', '2013-06-24 20:49:36', 'iitjadmin', 'iitjadmin'),
(24, 27, 16, '2012-13', '2', 'N', 'N', 'N', '2', 1, '2013-06-24 15:19:59', '2013-06-24 20:49:59', 'iitjadmin', 'iitjadmin'),
(25, 6, 17, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-24 15:20:28', '2013-06-24 20:50:28', 'iitjadmin', 'iitjadmin'),
(26, 24, 17, '2012-13', '4', 'N', 'N', 'N', '2', 1, '2013-06-24 15:37:56', '2013-06-24 21:07:56', 'iitjadmin', 'iitjadmin');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(45) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `department_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `program_id` int(11) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `department_id` (`department_id`),
  UNIQUE KEY `department_code` (`department_code`,`program_id`,`institute_No`),
  KEY `institute_No` (`institute_No`),
  KEY `program_id` (`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_code`, `department_name`, `status`, `program_id`, `institute_No`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(2, 'CSE', 'Computer Science and Engineering', 1, 5, 1, 'iitjadmin', '2013-06-11 16:29:44', 'iitjadmin', '2013-06-11 16:29:44'),
(3, 'EE', 'Electrical Engineering', 1, 5, 1, 'iitjadmin', '2013-06-11 23:43:54', 'iitjadmin', '2013-06-11 23:43:54'),
(4, 'ICT', 'Information and Communication Technologies', 1, 6, 1, 'iitjadmin', '2013-06-12 09:59:14', 'iitjadmin', '2013-06-12 09:59:14'),
(5, 'Energy', 'Energy', 1, 6, 1, 'iitjadmin', '2013-06-12 10:00:12', 'iitjadmin', '2013-06-12 10:00:12'),
(6, 'SS', 'System Science', 1, 6, 1, 'iitjadmin', '2013-06-12 10:00:56', 'iitjadmin', '2013-06-12 10:00:56'),
(7, 'BISS', 'Biologically Inspired Systems Science', 1, 7, 1, 'iitjadmin', '2013-06-12 10:02:17', 'iitjadmin', '2013-06-12 10:02:17'),
(8, 'SS', 'Systems Science', 1, 7, 1, 'iitjadmin', '2013-06-12 10:03:26', 'iitjadmin', '2013-06-12 10:03:26'),
(9, 'ICT', 'Information and Communication Technologies', 1, 7, 1, 'iitjadmin', '2013-06-12 10:06:11', 'iitjadmin', '2013-06-12 10:06:11'),
(10, 'ME', 'Mechanical Engineering', 1, 5, 1, 'iitjadmin', '2013-06-12 10:08:57', 'iitjadmin', '2013-06-12 10:08:57'),
(11, 'SS', 'Systems Science', 1, 5, 1, 'iitjadmin', '2013-06-12 10:09:22', 'iitjadmin', '2013-06-12 10:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `no_of_groups` int(11) NOT NULL,
  `student_no` int(11) NOT NULL,
  `Academic_year` varchar(100) NOT NULL,
  `Session` int(11) NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `institute_id` (`institute_id`,`instructor_id`,`course_id`,`Session`,`Academic_year`,`group_name`),
  KEY `instructor_id` (`instructor_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE IF NOT EXISTS `institute` (
  `institute_No` int(11) NOT NULL AUTO_INCREMENT,
  `instAdmin` varchar(120) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `institute_address` varchar(200) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `pin_code` int(6) NOT NULL,
  `state` varchar(100) NOT NULL,
  `institute_phone` varchar(45) NOT NULL,
  `institute_fax` varchar(45) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `activation_date` datetime DEFAULT NULL,
  `activated_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`institute_No`),
  UNIQUE KEY `institute_id` (`institute_No`),
  UNIQUE KEY `institute_phone` (`institute_phone`),
  UNIQUE KEY `email_id` (`email_id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `institute_fax` (`institute_fax`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`institute_No`, `instAdmin`, `email_id`, `url`, `institute_address`, `city`, `pin_code`, `state`, `institute_phone`, `institute_fax`, `status`, `name`, `updated_at`, `created_at`, `created_by`, `updated_by`, `activation_date`, `activated_by`) VALUES
(1, 'IITJ Admin', 'institute@iitj.ac.in', 'https://iitj.ac.in', 'Residency Road, Ratanada', 'Jodhpur', 342005, 'Rajasthan', '9778866551', '654-326-765676', '1', 'Indian Institute of Technology Jodhpur', '2013-06-27 20:43:31', '2013-06-06 15:04:43', 'iitjadmin', 'master', NULL, NULL),
(2, 'Admin a MBM', 'institute@mbm.ac.in', 'https://mbm.ac.in', 'Residency road, Ratanada', 'Jodhpur', 342005, 'Rajasthan', '34254222', '888-2134-222-222', '1', 'MBM Jodhpur', '2013-06-27 20:43:28', '2013-06-11 07:45:49', 'admin1@mbm.ac.in', 'master', '2013-06-11 07:54:35', 'master'),
(5, 'admin a JIET', 'institute@jiet.ac.in', 'https://jiet.ac.in', 'jnsvfwsnviwnw', 'Jodhpur', 342005, 'Rajasthan', '1122112211', '8888888888888', '0', 'JIET Jodhpur', '2013-06-27 20:43:24', '2013-06-11 12:56:10', 'admin@jiet.ac.in', 'admin@jiet.ac.in', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE IF NOT EXISTS `instructor` (
  `instructor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `address` varchar(520) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `contactNo` int(13) DEFAULT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `institute_No` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`instructor_id`),
  UNIQUE KEY `admin_id` (`instructor_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `name`, `address`, `email_id`, `contactNo`, `status`, `institute_No`, `user_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(2, 'Instructor1 IITJ', 'IITJ Campus GPRA', 'instructor1@iitj.ac.in', 2147483647, 1, 1, 3, '2013-06-18 05:34:14', '2013-06-08 19:41:59', 'iitjadmin', 'instructor1@iitj.ac.in'),
(3, 'Instructor2a IITJ', 'GPRA Jodhpur111', 'instructor2@iitj.ac.in', 123456788, 1, 1, 4, '2013-06-18 10:55:14', '2013-06-08 19:50:05', 'iitjadmin', 'iitjadmin'),
(10, 'Admin1 IITJ', 'kkkk 	\r\n', 'admin1@iitj.ac.in', 2147483647, 1, 1, 7, '2013-06-17 15:13:30', '2013-06-09 19:36:07', 'admin1@iitj.ac.in', 'iitjadmin'),
(11, 'Admin3 IITJ', 'iuywjhdj 	\r\n', 'admin3@iitj.ac.in', 2147483647, 1, 1, 9, '2013-06-28 09:32:25', '2013-06-10 05:24:19', 'iitjadmin', 'iitjadmin'),
(12, 'Instructor3 IITJ', 'GPRA, Kendranchal, Pali road, Jodhpur', 'instructor3@iitj.ac.in', 2147483647, 1, 1, 22, '2013-06-15 07:46:48', '2013-06-15 13:16:48', 'iitjadmin', 'iitjadmin'),
(13, 'Instructor4 IITJ', 'IIT Rajasthan', 'instructor4@iitj.ac.in', 2341231, 1, 1, 25, '2013-06-16 06:38:01', '2013-06-16 12:08:01', 'iitjadmin', 'iitjadmin'),
(14, 'Instructor5 IITJ', 'IITJ abc', 'instructor5@iitj.ac.in', 782134, 1, 1, 39, '2013-06-24 07:46:25', '2013-06-24 13:16:25', 'iitjadmin', 'iitjadmin'),
(15, 'Instructor6 IITJ', 'GPRA123', 'instructor6@iitj.ac.in', 34123122, 1, 1, 40, '2013-06-24 07:47:20', '2013-06-24 13:17:20', 'iitjadmin', 'iitjadmin'),
(16, 'Instructor7 IITJ', 'abjbcakbk', 'instructor7@iitj.ac.in', 364897, 1, 1, 41, '2013-06-24 07:47:57', '2013-06-24 13:17:57', 'iitjadmin', 'iitjadmin'),
(17, 'Instructor8 IITJ', 'hndaucndaa', 'instructor8@iitj.ac.in', 978999237, 1, 1, 42, '2013-06-24 07:51:18', '2013-06-24 13:21:18', 'iitjadmin', 'iitjadmin'),
(18, 'Instructor9 IITJ', 'sjnhfushn', 'instructor9@iitj.ac.in', 263546832, 1, 1, 43, '2013-06-24 15:04:03', '2013-06-24 20:34:03', 'iitjadmin', 'iitjadmin'),
(19, 'Instructor10 IITJ', 'bsdhcbsyhbcsh', 'instructor10@iitj.ac.in', 2147483647, 1, 1, 44, '2013-06-24 15:04:37', '2013-06-24 20:34:37', 'iitjadmin', 'iitjadmin');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_code` varchar(45) NOT NULL,
  `program_name` varchar(200) DEFAULT NULL,
  `institute_No` int(11) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  UNIQUE KEY `program_id` (`program_id`),
  UNIQUE KEY `program_code` (`program_code`,`institute_No`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_id`, `program_code`, `program_name`, `institute_No`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(5, 'BT', 'B.Tech', 1, 'iitjadmin', '2013-06-11 20:02:04', 'iitjadmin', '2013-06-11 20:02:04'),
(6, 'MT', 'M.Tech', 1, 'iitjadmin', '2013-06-11 20:11:52', 'iitjadmin', '2013-06-11 20:11:52'),
(7, 'PD', 'PhD', 1, 'iitjadmin', '2013-06-11 20:14:31', 'iitjadmin', '2013-06-11 20:14:31'),
(8, 'MS', 'M.Sc.', 1, 'iitjadmin', '2013-06-11 20:31:04', 'iitjadmin', '2013-06-11 20:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `std_id` int(11) NOT NULL AUTO_INCREMENT,
  `roll_no` varchar(45) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) NOT NULL,
  `program_id` int(11) NOT NULL,
  `department_id` int(11) unsigned NOT NULL,
  `address` text,
  `pin_code` int(6) unsigned NOT NULL,
  `mobile_no` varchar(10) DEFAULT NULL,
  `blood_group` varchar(45) DEFAULT NULL,
  `status` int(3) DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`std_id`),
  UNIQUE KEY `std_id` (`std_id`),
  UNIQUE KEY `email_id` (`email_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `roll_no` (`roll_no`,`institute_No`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`std_id`, `roll_no`, `student_name`, `father_name`, `mother_name`, `email_id`, `program_id`, `department_id`, `address`, `pin_code`, `mobile_no`, `blood_group`, `status`, `user_id`, `institute_No`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(16, 'ug201010003', 'Hamzah Khan', NULL, NULL, 'student3@iitj.ac.in', 5, 10, NULL, 0, NULL, NULL, 1, 46, 1, 'iitjadmin', '2013-06-24 16:09:14', 'iitjadmin', '2013-06-24 16:09:14'),
(17, 'ug201010001', 'Amar Singh', NULL, NULL, 'student1@iitj.ac.in', 5, 2, NULL, 0, NULL, NULL, 1, 47, 1, 'iitjadmin', '2013-06-24 16:13:11', 'iitjadmin', '2013-06-24 16:13:11'),
(18, 'ug201010002', 'Aman Deep', NULL, NULL, 'student2@iitj.ac.in', 5, 2, NULL, 0, NULL, NULL, 1, 48, 1, 'iitjadmin', '2013-06-24 16:14:45', 'iitjadmin', '2013-06-24 16:14:45'),
(19, 'ug201011025', 'Rahul Malav', NULL, NULL, 'student4@iitj.ac.in', 5, 3, NULL, 0, NULL, NULL, 1, 49, 1, 'iitjadmin', '2013-06-24 16:23:43', 'iitjadmin', '2013-06-24 16:23:43'),
(20, 'pg201012001', 'Sumit Agrawal', NULL, NULL, 'student5@iitj.ac.in', 6, 4, NULL, 0, NULL, NULL, 1, 50, 1, 'iitjadmin', '2013-06-24 16:25:54', 'iitjadmin', '2013-06-24 16:25:54'),
(21, 'pg201011001', 'Nishant Kumar', NULL, NULL, 'student6@iitj.ac.in', 7, 7, NULL, 0, NULL, NULL, 1, 51, 1, 'iitjadmin', '2013-06-24 16:28:47', 'iitjadmin', '2013-06-24 16:28:47'),
(22, 'ug201011001', 'Ravi Mahavar', NULL, NULL, 'student7@iitj.ac.in', 5, 3, NULL, 0, NULL, NULL, 1, 52, 1, 'iitjadmin', '2013-06-24 16:35:29', 'iitjadmin', '2013-06-24 16:35:29'),
(23, 'ug201012001', 'Niket Singh', NULL, NULL, 'student8@iitj.ac.in', 5, 10, NULL, 0, NULL, NULL, 1, 53, 1, 'iitjadmin', '2013-06-24 16:37:12', 'iitjadmin', '2013-06-24 16:37:12'),
(24, 'pg201013001', 'Rohit Gupta', NULL, NULL, 'student9@iitj.ac.in', 6, 5, NULL, 0, NULL, NULL, 1, 54, 1, 'iitjadmin', '2013-06-24 16:48:03', 'iitjadmin', '2013-06-24 16:48:03'),
(25, 'pg201014001', 'Saurabh Maheshwari', NULL, NULL, 'student10@iitj.ac.in', 6, 6, NULL, 0, NULL, NULL, 1, 55, 1, 'iitjadmin', '2013-06-24 16:50:21', 'iitjadmin', '2013-06-24 16:50:21'),
(26, 'pg201021001', 'Pankaj Khandelwal', NULL, NULL, 'student11@iitj.ac.in', 7, 8, NULL, 0, NULL, NULL, 1, 56, 1, 'iitjadmin', '2013-06-24 16:53:02', 'iitjadmin', '2013-06-24 16:53:02'),
(27, 'pg201021002', 'Vinod Meena', NULL, NULL, 'student12@iitj.ac.in', 7, 9, NULL, 0, NULL, NULL, 1, 57, 1, 'iitjadmin', '2013-06-24 16:54:37', 'iitjadmin', '2013-06-24 16:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `studentgroups`
--

CREATE TABLE IF NOT EXISTS `studentgroups` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_No` int(11) NOT NULL,
  `description` text NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `session` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`tblid`),
  UNIQUE KEY `institute_id` (`institute_id`,`instructor_id`,`course_id`,`group_id`,`academic_year`,`session`,`student_id`,`group_No`),
  KEY `course_id` (`course_id`),
  KEY `group_id` (`group_id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_reg`
--

CREATE TABLE IF NOT EXISTS `student_reg` (
  `no` int(20) NOT NULL AUTO_INCREMENT,
  `roll_No` varchar(30) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `session` varchar(5) NOT NULL DEFAULT '1',
  `semester` varchar(5) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `academic_year` (`academic_year`,`semester`,`course_id`,`student_id`,`session`,`institute_No`),
  KEY `institute_No` (`institute_No`),
  KEY `course_id` (`course_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `student_reg`
--

INSERT INTO `student_reg` (`no`, `roll_No`, `student_id`, `course_id`, `institute_No`, `academic_year`, `session`, `semester`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(14, 'ug201010003', 16, 28, 1, '2012-13', '2', '6', '2013-06-24 16:09:15', '2013-06-24 21:39:15', 'iitjadmin', 'iitjadmin'),
(15, 'ug201010001', 17, 2, 1, '2012-13', '2', '2', '2013-06-24 16:13:12', '2013-06-24 21:43:12', 'iitjadmin', 'iitjadmin'),
(16, 'ug201010002', 18, 2, 1, '2012-13', '2', '2', '2013-06-24 16:14:45', '2013-06-24 21:44:45', 'iitjadmin', 'iitjadmin'),
(17, 'ug201010001', 17, 3, 1, '2012-13', '2', '2', '2013-06-24 16:17:32', '2013-06-24 21:47:32', 'iitjadmin', 'iitjadmin'),
(19, 'ug201010002', 18, 3, 1, '2012-13', '2', '4', '2013-06-24 16:20:05', '2013-06-24 21:50:05', 'iitjadmin', 'iitjadmin'),
(21, 'ug201010003', 16, 23, 1, '2012-13', '2', '6', '2013-06-24 16:21:53', '2013-06-24 21:51:53', 'iitjadmin', 'iitjadmin'),
(22, 'ug201010003', 16, 24, 1, '2012-13', '2', '4', '2013-06-24 16:22:20', '2013-06-24 21:52:20', 'iitjadmin', 'iitjadmin'),
(23, 'ug201011025', 19, 4, 1, '2012-13', '2', '4', '2013-06-24 16:23:43', '2013-06-24 21:53:43', 'iitjadmin', 'iitjadmin'),
(24, 'ug201011025', 19, 5, 1, '2012-13', '2', '8', '2013-06-24 16:24:13', '2013-06-24 21:54:13', 'iitjadmin', 'iitjadmin'),
(25, 'pg201012001', 20, 9, 1, '2012-13', '2', '4', '2013-06-24 16:25:54', '2013-06-24 21:55:54', 'iitjadmin', 'iitjadmin'),
(26, 'pg201012001', 20, 10, 1, '2012-13', '2', '6', '2013-06-24 16:26:23', '2013-06-24 21:56:23', 'iitjadmin', 'iitjadmin'),
(27, 'pg201011001', 21, 25, 1, '2012-13', '2', '2', '2013-06-24 16:28:47', '2013-06-24 21:58:47', 'iitjadmin', 'iitjadmin'),
(28, 'ug201011001', 22, 4, 1, '2012-13', '2', '4', '2013-06-24 16:35:29', '2013-06-24 22:05:29', 'iitjadmin', 'iitjadmin'),
(29, 'ug201012001', 23, 23, 1, '2012-13', '2', '6', '2013-06-24 16:37:13', '2013-06-24 22:07:13', 'iitjadmin', 'iitjadmin'),
(30, 'ug201011001', 22, 5, 1, '2012-13', '2', '8', '2013-06-24 16:38:42', '2013-06-24 22:08:42', 'iitjadmin', 'iitjadmin'),
(31, 'ug201012001', 23, 24, 1, '2012-13', '2', '4', '2013-06-24 16:40:52', '2013-06-24 22:10:52', 'iitjadmin', 'iitjadmin'),
(32, 'ug201012001', 23, 28, 1, '2012-13', '2', '6', '2013-06-24 16:41:17', '2013-06-24 22:11:17', 'iitjadmin', 'iitjadmin'),
(33, 'pg201013001', 24, 11, 1, '2012-13', '2', '2', '2013-06-24 16:48:03', '2013-06-24 22:18:03', 'iitjadmin', 'iitjadmin'),
(34, 'pg201013001', 24, 12, 1, '2012-13', '2', '2', '2013-06-24 16:48:30', '2013-06-24 22:18:30', 'iitjadmin', 'iitjadmin'),
(35, 'pg201014001', 25, 21, 1, '2012-13', '2', '4', '2013-06-24 16:50:21', '2013-06-24 22:20:21', 'iitjadmin', 'iitjadmin'),
(36, 'pg201014001', 25, 22, 1, '2012-13', '2', '2', '2013-06-24 16:50:49', '2013-06-24 22:20:49', 'iitjadmin', 'iitjadmin'),
(37, 'pg201021001', 26, 26, 1, '2012-13', '2', '2', '2013-06-24 16:53:02', '2013-06-24 22:23:02', 'iitjadmin', 'iitjadmin'),
(38, 'pg201021002', 27, 27, 1, '2012-13', '2', '2', '2013-06-24 16:54:37', '2013-06-24 22:24:37', 'iitjadmin', 'iitjadmin');

-- --------------------------------------------------------

--
-- Table structure for table `ta`
--

CREATE TABLE IF NOT EXISTS `ta` (
  `ta_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `address` varchar(120) NOT NULL,
  `email_id` varchar(120) NOT NULL,
  `contactNo` int(20) NOT NULL,
  `status` int(3) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(120) NOT NULL,
  `updated_by` varchar(120) NOT NULL,
  PRIMARY KEY (`ta_id`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ta`
--

INSERT INTO `ta` (`ta_id`, `name`, `address`, `email_id`, `contactNo`, `status`, `institute_No`, `user_id`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 'TA1 IITJ', 'dgbdtg', 'ta1@iitj.ac.in', 1234511, 1, 1, 62, '2013-06-27 16:24:35', '2013-06-27 21:54:35', 'instructor1@iitj.ac.in', 'instructor1@iitj.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `ta_course`
--

CREATE TABLE IF NOT EXISTS `ta_course` (
  `no` int(20) NOT NULL AUTO_INCREMENT,
  `ta_email` varchar(30) NOT NULL,
  `ta_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `institute_No` int(11) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `session` varchar(5) NOT NULL DEFAULT '1',
  `semester` varchar(5) NOT NULL,
  `status` int(4) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `unique` (`academic_year`,`course_id`,`ta_id`,`session`,`institute_No`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ta_instructor`
--

CREATE TABLE IF NOT EXISTS `ta_instructor` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `ta_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `institute_No` int(11) DEFAULT NULL,
  `semester` varchar(10) NOT NULL,
  `session` varchar(10) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `ta_id` (`ta_id`,`instructor_id`,`institute_No`,`academic_year`,`session`),
  KEY `institute_No` (`institute_No`),
  KEY `instructor_id` (`instructor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(18) NOT NULL,
  `cat` varchar(20) DEFAULT NULL,
  `institute_No` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `institute_No` (`institute_No`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `cat`, `institute_No`, `updated_at`, `created_at`, `created_by`, `updated_by`) VALUES
(2, 'iitjadmin', 'iitjadmin', '1,2', 1, '2013-06-26 08:40:12', '2013-06-06 16:19:54', 'iitjadmin', 'iitjadmin'),
(3, 'instructor1@iitj.ac.in', 'iitjinstructor', '4', 1, '2013-06-26 08:40:14', '2013-06-08 19:41:59', 'iitjadmin', 'iitjadmin'),
(4, 'instructor2@iitj.ac.in', '7NboM', '4', 1, '2013-06-26 08:40:17', '2013-06-08 19:50:05', 'iitjadmin', 'iitjadmin'),
(7, 'admin1@iitj.ac.in', 'tAwKz', '3,4', 1, '2013-06-26 08:40:18', '2013-06-09 18:46:50', 'iitjadmin', 'iitjadmin'),
(8, 'admin2@iitj.ac.in', 'XYZN4', '3', 1, '2013-06-26 08:39:36', '2013-06-09 18:47:26', 'iitjadmin', 'iitjadmin'),
(9, 'admin3@iitj.ac.in', 'xMzp6', '3,4', 1, '2013-06-26 08:39:24', '2013-06-10 05:23:19', 'iitjadmin', 'iitjadmin'),
(11, 'admin1@mbm.ac.in', 'mbmadmin', '2', 2, '2013-06-26 08:48:15', '2013-06-11 07:45:49', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in'),
(14, 'admin@jiet.ac.in', 'rUcw8', '2', 5, '2013-06-26 08:48:20', '2013-06-11 12:56:10', 'admin@jiet.ac.in', 'admin@jiet.ac.in'),
(22, 'instructor3@iitj.ac.in', '7491I', '4', 1, '2013-06-26 08:39:44', '2013-06-15 13:16:48', 'iitjadmin', 'iitjadmin'),
(25, 'instructor4@iitj.ac.in', 'cIVPd', '4', 1, '2013-06-26 08:39:47', '2013-06-16 12:08:01', 'iitjadmin', 'iitjadmin'),
(32, 'adminx@mbm.in', '0RbAq', '3', 2, '2013-06-26 08:48:23', '2013-06-18 07:19:05', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in'),
(37, 'testMBM@admin.in', 'SyRDa', '2', 2, '2013-06-26 08:48:27', '2013-06-19 07:52:29', 'admin1@mbm.ac.in', 'admin1@mbm.ac.in'),
(39, 'instructor5@iitj.ac.in', 'hKFsd', '4', 1, '2013-06-26 08:39:58', '2013-06-24 13:16:25', 'iitjadmin', 'iitjadmin'),
(40, 'instructor6@iitj.ac.in', 'sfCuz', '4', 1, '2013-06-26 08:40:01', '2013-06-24 13:17:20', 'iitjadmin', 'iitjadmin'),
(41, 'instructor7@iitj.ac.in', 'LYD1j', '4', 1, '2013-06-26 08:40:04', '2013-06-24 13:17:56', 'iitjadmin', 'iitjadmin'),
(42, 'instructor8@iitj.ac.in', '3nknF', '4', 1, '2013-06-26 08:40:06', '2013-06-24 13:21:18', 'iitjadmin', 'iitjadmin'),
(43, 'instructor9@iitj.ac.in', 'FQWdj', '4', 1, '2013-06-26 08:40:08', '2013-06-24 20:34:02', 'iitjadmin', 'iitjadmin'),
(44, 'instructor10@iitj.ac.in', 'nYIpO', '4', 1, '2013-06-26 08:40:25', '2013-06-24 20:34:37', 'iitjadmin', 'iitjadmin'),
(46, 'student3@iitj.ac.in', 'Oul2x', '6', 1, '2013-06-26 08:40:28', '2013-06-24 21:39:14', 'iitjadmin', 'iitjadmin'),
(47, 'student1@iitj.ac.in', 'yAtVb', '6', 1, '2013-06-26 08:40:29', '2013-06-24 21:43:11', 'iitjadmin', 'iitjadmin'),
(48, 'student2@iitj.ac.in', 'LZ2H7', '6', 1, '2013-06-26 08:40:31', '2013-06-24 21:44:45', 'iitjadmin', 'iitjadmin'),
(49, 'student4@iitj.ac.in', '16oEK', '6', 1, '2013-06-26 08:40:33', '2013-06-24 21:53:43', 'iitjadmin', 'iitjadmin'),
(50, 'student5@iitj.ac.in', 'UaX9A', '6', 1, '2013-06-26 08:40:35', '2013-06-24 21:55:54', 'iitjadmin', 'iitjadmin'),
(51, 'student6@iitj.ac.in', '3E5ko', '6', 1, '2013-06-26 08:40:37', '2013-06-24 21:58:47', 'iitjadmin', 'iitjadmin'),
(52, 'student7@iitj.ac.in', 'KMjmM', '6', 1, '2013-06-26 08:40:39', '2013-06-24 22:05:29', 'iitjadmin', 'iitjadmin'),
(53, 'student8@iitj.ac.in', 'fzuEG', '6', 1, '2013-06-26 08:40:41', '2013-06-24 22:07:12', 'iitjadmin', 'iitjadmin'),
(54, 'student9@iitj.ac.in', 'jW2EN', '6', 1, '2013-06-26 08:40:43', '2013-06-24 22:18:03', 'iitjadmin', 'iitjadmin'),
(55, 'student10@iitj.ac.in', 'JN4wD', '6', 1, '2013-06-24 16:50:21', '2013-06-24 22:20:21', 'iitjadmin', 'iitjadmin'),
(56, 'student11@iitj.ac.in', 'SLjoA', '6', 1, '2013-06-24 16:53:02', '2013-06-24 22:23:02', 'iitjadmin', 'iitjadmin'),
(57, 'student12@iitj.ac.in', 'RcH6E', '6', 1, '2013-06-24 16:54:37', '2013-06-24 22:24:37', 'iitjadmin', 'iitjadmin'),
(62, 'ta1@iitj.ac.in', 'c6Ooc', '5', 1, '2013-06-27 16:24:35', '2013-06-27 21:54:35', 'instructor1@iitj.ac.in', 'instructor1@iitj.ac.in');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `administrator_ibfk_2` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE;

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`),
  ADD CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `assignment_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_No`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD CONSTRAINT `course_instructor_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_ibfk_3` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`) ON DELETE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_No`),
  ADD CONSTRAINT `groups_ibfk_3` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_No`);

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `studentgroups`
--
ALTER TABLE `studentgroups`
  ADD CONSTRAINT `studentgroups_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_No`),
  ADD CONSTRAINT `studentgroups_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_No`),
  ADD CONSTRAINT `studentgroups_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `studentgroups_ibfk_4` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `studentgroups_ibfk_5` FOREIGN KEY (`student_id`) REFERENCES `student` (`std_id`);

--
-- Constraints for table `student_reg`
--
ALTER TABLE `student_reg`
  ADD CONSTRAINT `student_reg_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_reg_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_No`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_reg_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `ta`
--
ALTER TABLE `ta`
  ADD CONSTRAINT `ta_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE;

--
-- Constraints for table `ta_course`
--
ALTER TABLE `ta_course`
  ADD CONSTRAINT `ta_course_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE;

--
-- Constraints for table `ta_instructor`
--
ALTER TABLE `ta_instructor`
  ADD CONSTRAINT `ta_instructor_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`),
  ADD CONSTRAINT `ta_instructor_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `ta_instructor_ibfk_3` FOREIGN KEY (`ta_id`) REFERENCES `ta` (`ta_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`institute_No`) REFERENCES `institute` (`institute_No`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
