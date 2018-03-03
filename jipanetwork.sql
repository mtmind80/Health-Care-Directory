-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 17, 2016 at 11:37 PM
-- Server version: 5.6.28-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jipanetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `provider_id` int(10) UNSIGNED NOT NULL,
  `address_type_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address_types`
--
-- Creation: Jun 16, 2016 at 01:26 PM
--

DROP TABLE IF EXISTS `address_types`;
CREATE TABLE `address_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address_types`
--

INSERT INTO `address_types` (`id`, `name`, `code`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Offices of Physicians (except Mental Health Specialists)', '621111', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(2, 'Offices of Physicians, Mental Health Specialists', '621112', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(3, 'Offices of Dentists', '621210', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(4, 'Offices of Chiropractors', '621310', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(5, 'Offices of Optometrists', '621320', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(6, 'Offices of Mental Health Practitioners (except Physicians)', '621330', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(7, 'Offices of Physical, Occupational and Speech Therapists, and Audiologists', '621340', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(8, 'Offices of Podiatrists', '621391', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(9, 'Offices of All Other Miscellaneous Health Practitioners', '621399', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(10, 'Family Planning Centers', '621410', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(11, 'Outpatient Mental Health and Substance Abuse Centers', '621420', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(12, 'HMO Medical Centers', '621491', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(13, 'Kidney Dialysis Centers', '621492', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(14, 'Freestanding Ambulatory Surgical and Emergency Centers', '621493', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(15, 'All Other Outpatient Care Centers', '621498', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(16, 'Medical Laboratories', '621511', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(17, 'Diagnostic Imaging Centers', '621512', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(18, 'Home Health Care Services', '621610', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(19, 'Ambulance Services', '621910', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(20, 'Blood and Organ Banks', '621991', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(21, 'All Other Miscellaneous Ambulatory Health Care Services', '621999', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(22, 'General Medical and Surgical Hospitals', '622110', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(23, 'Psychiatric and Substance Abuse Hospitals', '622210', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(24, 'Specialty (except Psychiatric and Substance Abuse) Hospitals', '622310', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(25, 'Nursing Care Facilities (Skilled Nursing Facilities)', '623110', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(26, 'Residential Intellectual and Developmental Disability Facilities', '623210', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(27, 'Residential Mental Health and Substance Abuse Facilities', '623220', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(28, 'Continuing Care Retirement Communities', '623311', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(29, 'Assisted Living Facilities for the Elderly', '623312', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(30, 'Other Residential Care Facilities', '623990', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(31, 'Child and Youth Services', '624110', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(32, 'Services for the Elderly and Persons with Disabilities', '624120', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(33, 'Other Individual and Family Services', '624190', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(34, 'Community Food Services', '624210', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(35, 'Temporary Shelters', '624221', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(36, 'Other Community Housing Services', '624229', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(37, 'Emergency and Other Relief Services', '624230', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(38, 'Vocational Rehabilitation Services', '624310', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34'),
(39, 'Child Day Care Services', '624410', 0, '2016-06-16 13:25:34', '2016-06-16 13:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--
-- Creation: Jun 17, 2016 at 02:36 PM
--

DROP TABLE IF EXISTS `boards`;
CREATE TABLE `boards` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `speciality_type_id` int(10) UNSIGNED NOT NULL,
  `body_id` int(10) UNSIGNED NOT NULL,
  `certification_id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bodies`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `bodies`;
CREATE TABLE `bodies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bodies`
--

INSERT INTO `bodies` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'American Board of Allergy and Immunology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(2, 'American Board of Anesthesiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(3, 'American Board of Colon and Rectal Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(4, 'American Board of Dermatology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(5, 'American Board of Emergency Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(6, 'American Board of Family Practice', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(7, 'American Board of Medical Genetics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(8, 'American Board of Internal Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(9, 'American Board of Neurological Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(10, 'American Board of Nuclear Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(11, 'American Board of Obstetrics and Gynecology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(12, 'American Board of Ophthalmology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(13, 'American Board of Orthopaedic Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(14, 'American Board of Otolaryngology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(15, 'American Board of Pathology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(16, 'American Board of Pediatrics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(17, 'American Board of Plastic Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(18, 'American Board of Preventive Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(19, 'American Board of Psychiatry and Neurology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(20, 'American Board of Radiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(21, 'American Board of Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(22, 'American Board of Thoracic Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(23, 'American Board of Urology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(24, 'American Board of Physical Medicine and Rehabilitation', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(25, 'American Board of Surgical Assistants', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(26, 'American Board of Podiatric Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(27, 'American Osteopathic Board of Family Physicians', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(28, 'American Osteopathic Board of General Practice', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(29, 'American Board of Electrostatic Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(30, 'American Board of Hematology/Oncology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(31, 'American Board of Endodontics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(32, 'American Osteopathic Board of Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(33, 'National Board of Addiction Examiners', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(34, 'American Association of Pastoral Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(35, 'Board of Georgia Addition Couselors` Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(36, 'Council on Sex Offender Treatment', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(37, 'American Board of Laser Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(38, 'National Certification Commission for Acupuncture', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(39, 'National Cert Board for Therapeutic Massage & Bodywork', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(40, 'American Podiatric Medical Specialties Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(41, 'American Board of Electroencephalography', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(42, 'Certified Disability Management Specialist', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(43, 'American Board of Examiners in Psychodrama', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(44, 'Certified Independent Social Worker', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(45, 'American Academy of Peditric Dentistry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(46, 'American Board of Cardiovascular Perfusion', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(47, 'American Board of Medical Psychotherapists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(48, 'The American Academy of Experts in Traumatic Stress', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(49, 'American Board of Child Mental Health Service Providers', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(50, 'American Board of Disability Analysts', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(51, 'National Council for Therapeutic Recreation Certificati', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(52, 'National Board for Certified Gerontological Counselor', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(53, 'The American Association of Physician Specialists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(54, 'American Osteopathic Board of Neurology and Psychiatry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(55, 'National Assoc. of Alcoholism & Drug Abuse Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(56, 'American Occupational Therapy Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(57, 'Georgia Addiction Counselors` Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(58, 'National Board of Cognitive Behavioral Therapists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(59, 'Commonwealth of Pennsylvania Professional Certificate', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(60, 'Georgia Professional Standards Commission', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(61, 'American Academy of Wound Management', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(62, 'National Certification Corporation for the Obstetric, G', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(63, 'American Osteopathic Board of Preventive Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(64, 'American Board of Examiners in Clinical Social Work', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(65, 'Louisiana State Board Cert. Substance Abuse Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(66, 'American Board of Pain Management', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(67, 'Maryland Addiction Counselor Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(68, 'Board for Certification in Pedorthics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(69, 'Board for Orthotist/Prosthetist Certification', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(70, 'American Board of Medical Specialties in Podiatry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(71, 'American Association of Clinical-Care Nurse', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(72, 'National Counselor Therapeutic Recreation Specialist', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(73, 'National Registry of Certified Group Psychotherapists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(74, 'State of Florida Emergency Medical Services', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(75, 'American Academy of Pain Management', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(76, 'American Board for Occupational Health Nurses', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(77, 'American Board of Electroencephalographic', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(78, 'American Association of Medical Review Officer', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(79, 'American Osteopathic Board of Otolaryngology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(80, 'American Board of Hospice and Palliative Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(81, 'Florida Board of Optometry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(82, 'National Board for Respiratory Care', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(83, 'American Board of Professional Psychology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(84, 'Department of Business and Professional Regulator-FL', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(85, 'National Surgical Assistant Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(86, 'American Osteopathic Board of Emergency Med', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(87, 'American Board of General Practice', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(88, 'American Osteopathic Board of Cardiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(89, 'American Board of Optometry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(90, 'American Osteopathic Board of Internal Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(91, 'American Board Orthotics and Prosthetics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(92, 'American Osteopathic Board of Ophthalmolgy', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(93, 'American Osteopathic Board of Orthopedic Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(94, 'American Osteopathic Board of Dermatology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(95, 'AOB of Ophthalmology and Otorhinolaryngology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(96, 'AB for Certification in Orthotics and Prosthetics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(97, 'American Board of Abdominal Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(98, 'American Board of Certification in Radiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(99, 'Eligible', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(100, 'Not Certified', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(101, 'American Osteopathic Board of Rehab. Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(102, 'American Board of Oral and Maxillofacial Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(103, 'American Council of Certified Podiatric Physicians', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(104, 'American Institute of Foot Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(105, 'American Board of Podiatric Orthopedics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(106, 'American Board of Dental Public Health', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(107, 'American Osteopathic Board of OB/GYN', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(108, 'American Osteopathic Board of Radiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(109, 'State of Florida Department of Education', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(110, 'Certification Board for Addiction Professionals of FL', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(111, 'American Board of Sexology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(112, 'Council on Recertification of Nurse Anesthetists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(113, 'National Board for Certified Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(114, 'National Certification as a Surgical Technologist', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(115, 'Behavior Analyst Certification Program', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(116, 'American Board of Certified Managed Care Providers', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(117, 'National Association of Social Workers', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(118, 'American Academy of Osteopathic Emergency Physicians', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(119, 'American Board of Forensic Examiners', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(120, 'National Association of Forensic Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(121, 'American Board of Professional Neuropsychology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(122, 'National Board for Cert. in Occupational Therapy', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(123, 'Florida State Board of Dentistry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(124, 'American Osteopathic College of Proctology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(125, 'American Society of Bariatric Physicians', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(126, 'American Association of Nurse Anesthetists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(127, 'American Dietetic Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(128, 'National Board for Certified Clinical Hypnotherapists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(129, 'American Speech-Language -Hearing Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(130, 'National Commission on Certification of PA`s', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(131, 'American Osteopathic Board of Pediatrics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(132, 'Board of Behavioral Health Examiners Arizona', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(133, 'National Board for Certification in Occupational Therap', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(134, 'National Council on Family Relations', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(135, 'American Osteopathic Board of Anesthesiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(136, 'Texas Certification Board of Alcoholism & Drug Abuse C', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(137, 'National Certification Board of Perioperative', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(138, 'American Board of Child Mental Health Service Providers', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(139, 'National Certification Board/Perioperative Nursing, In', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(140, 'National Register of Health Service Providers in Psych.', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(141, 'University of the State of New York', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(142, 'American Academy of Nurse Practitioners', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(143, 'The American College of Nurse-Midwives', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(144, 'Florida Physical Therapy Association', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(145, 'Certification Board for Music Therapists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(146, 'American Nurses Credentialing Center', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(147, 'National Association of Neonatal Nurses', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(148, 'American Osteopathic Board of Urology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(149, 'Child Life Certifiying Committee', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(150, 'American Association of Physician Specialists, Inc.', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(151, 'American Board of Sleep Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(152, 'Texas Interagency Council on ECI', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(153, 'Arizona Board for Certification of Addiction Counselors', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(154, 'American Board of Periodontology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(155, 'Professional Psychologist Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(156, 'American Association of Marriage & Family Therapy', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(157, 'American Board of Ambulatory Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(158, 'National Cert Board of Pediatric Nurse Practitioner', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(159, 'National School Psychology Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(160, 'American Osteopathic College of Ophthalmology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(161, 'NAADAC Certification Commission', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(162, 'American Board of Neurophysiologic Monitoring', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(163, 'American Osteopathic Board of Internal Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(164, 'American Board of mohs Micrographic Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(165, 'American Board of Preventive Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(166, 'Certificate Nuro Introoperative Monitor', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(167, 'Certification Board Perioperative Nursing', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(168, 'American Board of Electrodiagnostic Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(169, 'American Board of Eye Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(170, 'Texas Certification Board of Addiction Professionals', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(171, 'American Board of Quality Assurance Utilization Review', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(172, 'The Nephrology Nursing Certification Commission', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(173, 'American Board of Adolescent Psychiatry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(174, 'America Academy of Otolaryngology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(175, 'Association for Play Therapy', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(176, 'National Board of Echocardiography', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(177, 'The Certification Board of Nuclear Cardiology', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(178, 'Board of Certification in Emergency Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(179, 'Board of Pharmaceutical Specialties', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(180, 'American Board of Surigcal Assistants', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(181, 'American Board of Physician Specialties', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(182, 'National Certification Board for Diabetes Educators', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(183, 'American Board of Family Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(184, 'Nephrology Nursing Certification Commission', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(185, 'American Board of Geriatrics', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(186, 'American Board of Pulmonary Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(187, 'American Board of Urgent Care Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(188, 'National Board for Cert. of Orthopaedic PA', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(189, 'Pediatric Nursing Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(190, 'American Board of Pediatric Dentistry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(191, 'Behavior Analyst Certification Board, Inc.', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(192, 'American Association of Critical-Care Nurses', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(193, 'American Board of Podiatric Orthopedics and Primary Med', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(194, 'Academy of Ambulatory Foot & Ankle Surgery', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(195, 'Aerospace Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(196, 'National Registry of Emergency Medical Technicians', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(197, 'American Academy of Urgent Care Medicine', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(198, 'The American Registry of Radiologic Technologists', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(199, 'American Board of Multiple Specialties in Podiatry', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(200, 'Florida Certification Board', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(201, 'National Certification Corporation', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23'),
(202, 'American Osteopathic Board of Family Practice', 0, '2016-06-15 16:48:23', '2016-06-15 16:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `certifications`;
CREATE TABLE `certifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `d_sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `name`, `code`, `d_sort`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'State', '1', 1, 0, '2015-12-16 05:00:00', '2016-06-16 01:18:06'),
(2, 'NCQA', '2', 2, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(3, 'GHAA', '3', 3, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(4, 'JCAHO', '4', 4, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(5, 'AAAHC', '5', 5, 0, '2015-12-16 05:00:00', '2016-06-14 19:18:41'),
(6, 'Other', '6', 10000, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `key`, `value`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'favico', 'jipa.ico', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(2, 'company', 'JIPA Network', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(3, 'logo', 'JIPA-Full-Logo.png', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(4, 'address', '3114 Commerce Parkway', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(5, 'city', 'Miramar', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(6, 'state', 'FL', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(7, 'zipcode', '33025 ', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(8, 'country', 'US', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(9, 'email', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(10, 'phone', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(11, 'fax', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(12, 'website', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(13, 'facebook', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(14, 'twitter', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(15, 'instagram', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(16, 'linkedin', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(17, 'defaultAvatar', 'default-avatar-150x150.jpg', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(18, 'adminEmail', '', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(19, 'developerEmail', 'user@localhost.com', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(20, 'defaultLanguage', 'en', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(21, 'simpleFormSubmission', '1', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(22, 'logUserAuthAction', '0', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(23, 'seoDefaultTitlePrefix_en', 'JIPA | ', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(24, 'seoDefaultTitlePrefix_sp', 'JIPA | ', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(25, 'seoDefaultTitle_en', 'Joint Independent Provider Association', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(26, 'seoDefaultTitle_sp', 'Joint Independent Provider Association', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(27, 'seoDefaultKeywords_en', 'keywords', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(28, 'seoDefaultKeywords_sp', 'palabras claves', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(29, 'seoDefaultDescription_en', 'JIPA Network collaborates with medical experts, with state-of-the-art technologies and services, in order to provide patients with access to health care, critical medical services and elective procedures.', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(30, 'seoDefaultDescription_sp', 'descripcion de la pagina', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--
-- Creation: Jun 17, 2016 at 04:20 PM
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(2, 'Albania', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(3, 'Algeria', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(4, 'American Samoa', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(5, 'Andorra', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(6, 'Angola', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(7, 'Anguilla', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(8, 'Antigua and Barbuda', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(9, 'Argentina', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(10, 'Armenia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(11, 'Aruba', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(12, 'Australia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(13, 'Austria', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(14, 'Azerbaijan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(15, 'Bahamas', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(16, 'Bahrain', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(17, 'Bangladesh', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(18, 'Barbados', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(19, 'Belarus', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(20, 'Belgium', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(21, 'Belize', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(22, 'Benin', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(23, 'Bermuda', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(24, 'Bhutan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(25, 'Bolivia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(26, 'Bonaire', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(27, 'Bosnia and Herzegovina', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(28, 'Botswana', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(29, 'Brazil', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(30, 'British Indian Ocean Territory', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(31, 'Brunei', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(32, 'Bulgaria', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(33, 'Burkina Faso', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(34, 'Burundi', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(35, 'Cambodia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(36, 'Cameroon', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(37, 'Canada', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(38, 'Canary Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(39, 'Cape Verde', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(40, 'Cayman Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(41, 'Central African Republic', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(42, 'Chad', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(43, 'Channel Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(44, 'Chile', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(45, 'China', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(46, 'Christmas Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(47, 'Cocos Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(48, 'Colombia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(49, 'Comoros', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(50, 'Congo', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(51, 'Cook Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(52, 'Costa Rica', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(53, 'Cote D\'Ivoire', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(54, 'Croatia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(55, 'Cuba', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(56, 'Curacao', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(57, 'Cyprus', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(58, 'Czech Republic', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(59, 'Denmark', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(60, 'Djibouti', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(61, 'Dominica', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(62, 'Dominican Republic', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(63, 'East Timor', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(64, 'Ecuador', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(65, 'Egypt', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(66, 'El Salvador', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(67, 'Equatorial Guinea', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(68, 'Eritrea', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(69, 'Estonia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(70, 'Ethiopia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(71, 'Falkland Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(72, 'Faroe Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(73, 'Fiji', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(74, 'Finland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(75, 'France', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(76, 'French Guiana', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(77, 'French Polynesia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(78, 'French Southern Territory', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(79, 'Gabon', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(80, 'Gambia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(81, 'Georgia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(82, 'Germany', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(83, 'Ghana', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(84, 'Gibraltar', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(85, 'Great Britain', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(86, 'Greece', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(87, 'Greenland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(88, 'Grenada', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(89, 'Guadeloupe', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(90, 'Guam', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(91, 'Guatemala', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(92, 'Guinea', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(93, 'Guyana', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(94, 'Haiti', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(95, 'Hawaii', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(96, 'Honduras', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(97, 'Hong Kong', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(98, 'Hungary', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(99, 'Iceland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(100, 'India', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(101, 'Indonesia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(102, 'Iran', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(103, 'Iraq', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(104, 'Ireland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(105, 'Isle of Man', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(106, 'Israel', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(107, 'Italy', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(108, 'Jamaica', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(109, 'Japan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(110, 'Jordan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(111, 'Kazakhstan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(112, 'Kenya', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(113, 'Kiribati', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(114, 'Korea North', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(115, 'Korea South', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(116, 'Kuwait', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(117, 'Kyrgyzstan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(118, 'Laos', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(119, 'Latvia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(120, 'Lebanon', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(121, 'Lesotho', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(122, 'Liberia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(123, 'Libya', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(124, 'Liechtenstein', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(125, 'Lithuania', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(126, 'Luxembourg', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(127, 'Macau', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(128, 'Macedonia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(129, 'Madagascar', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(130, 'Malaysia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(131, 'Malawi', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(132, 'Maldives', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(133, 'Mali', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(134, 'Malta', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(135, 'Marshall Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(136, 'Martinique', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(137, 'Mauritania', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(138, 'Mauritius', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(139, 'Mayotte', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(140, 'Mexico', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(141, 'Midway Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(142, 'Moldova', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(143, 'Monaco', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(144, 'Mongolia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(145, 'Montserrat', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(146, 'Morocco', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(147, 'Mozambique', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(148, 'Myanmar', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(149, 'Nambia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(150, 'Nauru', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(151, 'Nepal', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(152, 'Netherland Antilles', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(153, 'Netherland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(154, 'Nevis', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(155, 'New Caledonia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(156, 'New Zealand', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(157, 'Nicaragua', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(158, 'Niger', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(159, 'Nigeria', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(160, 'Niue', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(161, 'Norfolk Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(162, 'Norway', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(163, 'Oman', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(164, 'Pakistan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(165, 'Palau Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(166, 'Palestine', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(167, 'Panama', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(168, 'Papua New Guinea', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(169, 'Paraguay', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(170, 'Peru', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(171, 'Philippines', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(172, 'Pitcairn Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(173, 'Poland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(174, 'Portugal', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(175, 'Puerto Rico', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(176, 'Qatar', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(177, 'Republic of Montenegro', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(178, 'Republic of Serbia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(179, 'Reunion', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(180, 'Romania', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(181, 'Russia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(182, 'Rwanda', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(183, 'St Barthelemy', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(184, 'St Eustatius', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(185, 'St Helena', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(186, 'St Kitts-Nevis', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(187, 'St Lucia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(188, 'St Maarten', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(189, 'St Pierre and Miquelon', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(190, 'St Vincent and Grenadines', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(191, 'Saipan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(192, 'Samoa', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(193, 'Samoa American', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(194, 'San Marino', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(195, 'Sao Tome and Principe', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(196, 'Saudi Arabia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(197, 'Senegal', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(198, 'Seychelles', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(199, 'Sierra Leone', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(200, 'Singapore', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(201, 'Slovakia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(202, 'Slovenia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(203, 'Solomon Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(204, 'Somalia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(205, 'South Africa', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(206, 'Spain', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(207, 'Sri Lanka', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(208, 'Sudan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(209, 'Suriname', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(210, 'Swaziland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(211, 'Sweden', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(212, 'Switzerland', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(213, 'Syria', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(214, 'Tahiti', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(215, 'Taiwan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(216, 'Tajikistan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(217, 'Tanzania', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(218, 'Thailand', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(219, 'Togo', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(220, 'Tokelau', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(221, 'Tonga', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(222, 'Trinidad and Tobago', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(223, 'Tunisia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(224, 'Turkey', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(225, 'Turkmenistan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(226, 'Turks and Caicos Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(227, 'Tuvalu', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(228, 'Uganda', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(229, 'Ukraine', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(230, 'United Arab Emirates', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(231, 'United Kingdom', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(232, 'United States', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(233, 'Uruguay', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(234, 'Uzbekistan', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(235, 'Vanuatu', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(236, 'Vatican City State', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(237, 'Venezuela', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(238, 'Vietnam', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(239, 'Virgin Islands British', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(240, 'Virgin Islands USA', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(241, 'Wake Island', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(242, 'Wallis and Futana Islands', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(243, 'Yemen', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(244, 'Zaire', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(245, 'Zambia', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55'),
(246, 'Zimbabwe', 0, '2015-12-16 05:00:00', '2016-06-17 15:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `degrees`;
CREATE TABLE `degrees` (
  `id` int(10) UNSIGNED NOT NULL,
  `short_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `short_name`, `full_name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'DO', 'Doctor of Osteopathic', 0, '2016-06-14 16:57:03', '2016-06-15 01:29:26'),
(2, 'MD', 'Medical Doctor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(3, 'DC', 'Doctor of Chiropractic', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(4, 'DDS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(5, 'DPM', 'Doctor of Podiatric Medicine', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(6, 'Ph.D', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(7, 'PsyD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(8, 'DMD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(9, 'OD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(10, 'D.psyc', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(11, 'DSW', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(12, 'Ed.D', 'Education Doctor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(13, 'Ed.M', 'Education Master', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(14, 'MSW', 'Master of Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(15, 'MS', 'Master of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(16, 'MA', 'Master of Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(17, 'PA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(18, 'MSPT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(19, 'PT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(20, 'BSN', 'Bachelor of Science in Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(21, 'MRN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(22, 'OT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(23, 'BS', 'Bachelor of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(24, 'ARNP', 'Advanced Registered Nurse Practioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(25, 'CPO', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(26, 'D.Min', 'Doctor of Ministry', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(27, 'N/A', 'Not Applicable', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(28, 'AS', 'Asociate of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(29, 'BSW', 'Bachelor of Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(30, 'AA', 'Associate of Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(31, 'ASN', 'Associate of Science in Nurisng', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(32, 'MBA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(33, 'CAN', 'Certified Nurse Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(34, 'LCSW-C', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(35, 'MPA', 'Master of Public Adminstration', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(36, 'LVN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(37, 'CRNA', 'Certified Registered Nurse Practioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(38, 'D.Min', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(39, 'CTRS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(40, 'DM', 'Doctorate Ministry', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(41, 'MFC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(42, 'MC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(43, 'LPC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(44, 'LCDC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(45, 'AAS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(46, 'Ed.S', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(47, 'LMFT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(48, 'BM', 'Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(49, 'CAS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(50, 'MMT', 'Master of Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(51, 'RP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(52, 'RNFA', 'Registered Nurse First Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(53, 'RD', 'Registered Dietician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(54, 'MM', 'Master of Music', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(55, 'ADAC', 'Alchohol/Drug Add. Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(56, 'AP', 'Acupunture Physician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(57, 'MHS', 'Master of Humans Services', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(58, 'ET', 'Electroencephalography', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(59, 'SA', 'Surgical Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(60, 'ST', 'Surgical Technologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(61, 'MFT', 'Marriage Family Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(62, 'RT', 'Recreational Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(63, 'M.Ed', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(64, 'MRE', 'Master of Religious Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(65, 'D.Ed', 'Doctor of Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(66, 'PA-C', 'Certified Physician Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(67, 'PC', 'Postbachelor Certificate in Citotechnology', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(68, 'MT', 'Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(69, 'CAP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(70, 'BA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(71, 'LMHC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(72, 'LCSW', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(73, 'RN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(74, 'LPN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(75, 'MSN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(76, 'SLP', 'Speech Language Pathologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(77, 'CNM', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(78, 'Other', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(79, 'Unknown', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(80, 'MFCC', 'Marriage Fam Child Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(81, 'LMW', 'Licensed Mid Wife', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(82, 'Pharm.D', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(83, 'SRNA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(84, 'EMT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(85, 'LN', 'Licensed Nutritionist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(86, 'ANP-C', 'Advanced Nurse Practitioner Certified', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(87, 'NDT', 'Nuerophysiology Technician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(88, 'FNP', 'Family Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(89, 'NFPA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(90, 'PERFUSION', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(91, 'LPA', 'Licensed Psychiatric Associate', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(92, 'MPS', 'Masters of Pastoral Studies', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(93, 'BBA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(94, 'COTA', 'Certified Occupational Therapist Asst', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(95, 'LMSW', 'Licensed Master Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(96, 'AND', 'Associates Degree in Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(97, 'MSS', 'Master of Social Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(98, 'RPH', 'Registered Pharmacist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(99, 'CNIM', 'Cert Neurophysiology Monitoring', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(100, 'NP', 'Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(101, 'LSWA', 'Licensed Social Worker Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(102, 'LD', 'Licensed Dietician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(103, 'LPTA', 'Licensed Physical Therapy Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(104, 'OTR/L', 'Hand Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(105, 'CPhT', 'Certified Pharmacy Tech', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(106, 'CAGS', 'Certificate of Advance Graduate Studies', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(107, 'IMH', 'Intern Mental Health Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(108, 'MPH', 'Master of Public Health', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(109, 'ACNP', 'Acute Care Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(110, 'MLA', 'Master of Language Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(111, 'BDS', 'Bachelor of Dental Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(112, 'AY', 'Audiologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(113, 'PN', 'Practical Nurse', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(114, 'LSW', 'Licensed Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(115, 'BAS', 'Bachelor of Applied Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(116, 'UT', 'Ultrasound Technician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(117, 'ACSW', 'Associate Clinical Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(118, 'IMFT', 'Intern-Marriage & Family Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(119, 'TRP', 'Therapeutic Radiological Physics', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(120, 'CCP', 'Certified Clinical Profusionist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(121, 'PTA', 'Physical Therapist Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(122, 'ISW', 'Intern-Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(123, 'LGSW', 'Licensed Graduate Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(124, 'CPC', 'Certified Professional Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(125, 'CRNP', 'Certified Registered Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(126, 'CO', 'Certified Orthotist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(127, 'LMSW-ACP', 'LMSW-Advanced Clinical Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(128, 'BFA', 'Bachelor of Fine Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(129, 'MSE', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(130, 'MHA', 'Masters of Health Administration', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(131, 'PNP', 'Pediatric Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(132, 'Au.D', 'Doctor of Audiology', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(133, 'OTA', 'Occupational Therapy Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(134, 'CVP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(135, 'RFOM', 'Registered Fitter Orthotics/Mastectomy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(136, 'CNN', 'Certified Nephrology Nurse', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(137, 'LISAC', 'Licensed Independent Substance Abuse Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(138, 'MED', 'Masters in Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(139, 'CERT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(140, 'MOT', 'Masters in Occupational Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(141, 'BSPT', 'Bachelor of Science in Physical Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(142, 'PCN', 'Primary Care Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(143, 'CMA', 'Certified Medical Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(144, 'LAC', 'Licensed Associate Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(145, 'M.Div', 'Master of Divinity', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(146, 'DO', 'Doctor of Osteopathic', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(147, 'MD', 'Medical Doctor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(148, 'DC', 'Doctor of Chiropractic', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(149, 'DDS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(150, 'DPM', 'Doctor of Podiatric Medicine', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(151, 'Ph.D', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(152, 'PsyD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(153, 'DMD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(154, 'OD', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(155, 'D.psyc', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(156, 'DSW', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(157, 'Ed.D', 'Education Doctor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(158, 'Ed.M', 'Education Master', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(159, 'MSW', 'Master of Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(160, 'MS', 'Master of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(161, 'MA', 'Master of Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(162, 'PA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(163, 'MSPT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(164, 'PT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(165, 'BSN', 'Bachelor of Science in Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(166, 'MRN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(167, 'OT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(168, 'BS', 'Bachelor of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(169, 'ARNP', 'Advanced Registered Nurse Practioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(170, 'CPO', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(171, 'D.Min', 'Doctor of Ministry', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(172, 'N/A', 'Not Applicable', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(173, 'AS', 'Asociate of Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(174, 'BSW', 'Bachelor of Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(175, 'AA', 'Associate of Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(176, 'ASN', 'Associate of Science in Nurisng', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(177, 'MBA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(178, 'CAN', 'Certified Nurse Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(179, 'LCSW-C', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(180, 'MPA', 'Master of Public Adminstration', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(181, 'LVN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(182, 'CRNA', 'Certified Registered Nurse Practioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(183, 'D.Min', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(184, 'CTRS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(185, 'DM', 'Doctorate Ministry', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(186, 'MFC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(187, 'MC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(188, 'LPC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(189, 'LCDC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(190, 'AAS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(191, 'Ed.S', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(192, 'LMFT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(193, 'BM', 'Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(194, 'CAS', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(195, 'MMT', 'Master of Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(196, 'RP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(197, 'RNFA', 'Registered Nurse First Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(198, 'RD', 'Registered Dietician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(199, 'MM', 'Master of Music', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(200, 'ADAC', 'Alchohol/Drug Add. Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(201, 'AP', 'Acupunture Physician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(202, 'MHS', 'Master of Humans Services', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(203, 'ET', 'Electroencephalography', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(204, 'SA', 'Surgical Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(205, 'ST', 'Surgical Technologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(206, 'MFT', 'Marriage Family Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(207, 'RT', 'Recreational Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(208, 'M.Ed', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(209, 'MRE', 'Master of Religious Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(210, 'D.Ed', 'Doctor of Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(211, 'PA-C', 'Certified Physician Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(212, 'PC', 'Postbachelor Certificate in Citotechnology', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(213, 'MT', 'Music Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(214, 'CAP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(215, 'BA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(216, 'LMHC', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(217, 'LCSW', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(218, 'RN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(219, 'LPN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(220, 'MSN', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(221, 'SLP', 'Speech Language Pathologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(222, 'CNM', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(223, 'Other', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(224, 'Unknown', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(225, 'MFCC', 'Marriage Fam Child Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(226, 'LMW', 'Licensed Mid Wife', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(227, 'Pharm.D', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(228, 'SRNA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(229, 'EMT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(230, 'LN', 'Licensed Nutritionist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(231, 'ANP-C', 'Advanced Nurse Practitioner Certified', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(232, 'NDT', 'Nuerophysiology Technician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(233, 'FNP', 'Family Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(234, 'NFPA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(235, 'PERFUSION', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(236, 'LPA', 'Licensed Psychiatric Associate', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(237, 'MPS', 'Masters of Pastoral Studies', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(238, 'BBA', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(239, 'COTA', 'Certified Occupational Therapist Asst', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(240, 'LMSW', 'Licensed Master Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(241, 'AND', 'Associates Degree in Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(242, 'MSS', 'Master of Social Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(243, 'RPH', 'Registered Pharmacist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(244, 'CNIM', 'Cert Neurophysiology Monitoring', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(245, 'NP', 'Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(246, 'LSWA', 'Licensed Social Worker Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(247, 'LD', 'Licensed Dietician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(248, 'LPTA', 'Licensed Physical Therapy Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(249, 'OTR/L', 'Hand Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(250, 'CPhT', 'Certified Pharmacy Tech', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(251, 'CAGS', 'Certificate of Advance Graduate Studies', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(252, 'IMH', 'Intern Mental Health Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(253, 'MPH', 'Master of Public Health', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(254, 'ACNP', 'Acute Care Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(255, 'MLA', 'Master of Language Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(256, 'BDS', 'Bachelor of Dental Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(257, 'AY', 'Audiologist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(258, 'PN', 'Practical Nurse', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(259, 'LSW', 'Licensed Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(260, 'BAS', 'Bachelor of Applied Science', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(261, 'UT', 'Ultrasound Technician', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(262, 'ACSW', 'Associate Clinical Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(263, 'IMFT', 'Intern-Marriage & Family Therapist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(264, 'TRP', 'Therapeutic Radiological Physics', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(265, 'CCP', 'Certified Clinical Profusionist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(266, 'PTA', 'Physical Therapist Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(267, 'ISW', 'Intern-Social Work', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(268, 'LGSW', 'Licensed Graduate Social Worker', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(269, 'CPC', 'Certified Professional Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(270, 'CRNP', 'Certified Registered Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(271, 'CO', 'Certified Orthotist', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(272, 'LMSW-ACP', 'LMSW-Advanced Clinical Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(273, 'BFA', 'Bachelor of Fine Arts', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(274, 'MSE', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(275, 'MHA', 'Masters of Health Administration', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(276, 'PNP', 'Pediatric Nurse Practitioner', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(277, 'Au.D', 'Doctor of Audiology', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(278, 'OTA', 'Occupational Therapy Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(279, 'CVP', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(280, 'RFOM', 'Registered Fitter Orthotics/Mastectomy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(281, 'CNN', 'Certified Nephrology Nurse', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(282, 'LISAC', 'Licensed Independent Substance Abuse Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(283, 'MED', 'Masters in Education', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(284, 'CERT', '', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(285, 'MOT', 'Masters in Occupational Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(286, 'BSPT', 'Bachelor of Science in Physical Therapy', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(287, 'PCN', 'Primary Care Nursing', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(288, 'CMA', 'Certified Medical Assistant', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(289, 'LAC', 'Licensed Associate Counselor', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03'),
(290, 'M.Div', 'Master of Divinity', 0, '2016-06-14 16:57:03', '2016-06-14 16:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `disciplines`;
CREATE TABLE `disciplines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `educations`;
CREATE TABLE `educations` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `degree_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `d_sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `name`, `d_sort`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'ECFMG', 0, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(2, 'FLEX', 0, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(3, 'USMLE', 0, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00'),
(4, 'No Qualifying Exam', 10000, 0, '2015-12-16 05:00:00', '2016-06-14 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exam_provider`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `exam_provider`;
CREATE TABLE `exam_provider` (
  `provider_id` int(10) UNSIGNED NOT NULL,
  `exam_id` int(10) UNSIGNED NOT NULL,
  `issued_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fellowships`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `fellowships`;
CREATE TABLE `fellowships` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `speciality_type_id` int(10) UNSIGNED NOT NULL,
  `hospital_id` int(10) UNSIGNED NOT NULL,
  `degree_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE `hospitals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identifications`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `identifications`;
CREATE TABLE `identifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `is_licence` tinyint(1) DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `identifications`
--

INSERT INTO `identifications` (`id`, `name`, `is_licence`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Upin Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(2, 'Medicare', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(3, 'Malpractice Insurance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(4, 'Social Security No.', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(5, 'Medicaid Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(6, 'Florida License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(7, 'Occupational License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(8, 'Driver License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(9, 'Dea License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(10, 'ECFMG', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(11, 'Board Certified', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(12, 'State Certified', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(13, 'Federal Tax Id', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(14, 'Medipass Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(15, 'Texas License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(16, 'Texas Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(17, 'Hawaii License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(18, 'Hawaii DPS License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(19, 'Pennsylvania License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(20, 'New Jersey License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(21, 'Illinois License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(22, 'Georgia License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(23, 'Maryland License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(24, 'California License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(25, 'Washington DC License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(26, 'Virginia License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(27, 'Indiana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(28, 'New York License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(29, 'Wisconsin License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(30, 'Ohio License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(31, 'Massachusetts License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(32, 'Connecticut Licence', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(33, 'Arizona License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(34, 'Kentucky License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(35, 'Louisiana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(36, 'US Virgin Islands', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(37, 'North Carolina', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(38, 'Missouri License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(39, 'Colorado License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(40, 'Rhode Island License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(41, 'Mississippi License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(42, 'Montana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(43, 'Michigan License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(44, 'Tennessee License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(45, 'Puerto Rico', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(46, 'Minnesota License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(47, 'Nevada License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(48, 'New Hampshire License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(49, 'CDS License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(50, 'Kansas License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(51, 'New Mexico License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(52, 'Alabama License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(53, 'Oklahoma License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(54, 'ACLS Program', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(55, 'BLS Program', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(56, 'Guam License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(57, 'South Dakota license', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(58, 'Guam Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(59, 'Maryland Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(60, 'BTLS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(61, 'PALS', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(62, 'BTLS-A', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(63, 'ACLS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(64, 'PALS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(65, 'Wash. DC Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(66, 'Oregon License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(67, 'Indiana Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(68, 'New Jersey Controlled Substanc', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(69, 'Washington State License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(70, 'Massachusetts Control Substan', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(71, 'South Carolina License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(72, 'Alabama Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(73, 'Arkansas License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(74, 'Idaho License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(75, 'Maine License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(76, 'Delaware License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(77, 'Texas Social Worker License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(78, 'Iowa License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(79, 'Iowa Controlled Substance', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(80, 'Nebraska License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(81, 'Nebraska Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(82, 'West Virginia License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(83, 'Illinois Control Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(84, 'Michigan Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(85, 'Alaska License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(86, 'Alaska Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(87, 'Idaho Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(88, 'Missouri Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(89, 'Louisiana Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(90, 'Oklahoma Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(91, 'South Carolina Controlled Subs', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(92, 'Utah License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(93, 'Connectic Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(94, 'North Dakota License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(95, 'Vermont License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(96, 'Nat\'l Provider Identifier', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(97, 'Medicaid Group #\'s', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(98, 'Upin Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(99, 'Medicare', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(100, 'Malpractice Insurance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(101, 'Social Security No.', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(102, 'Medicaid Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(103, 'Florida License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(104, 'Occupational License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(105, 'Driver License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(106, 'Dea License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(107, 'ECFMG', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(108, 'Board Certified', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(109, 'State Certified', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(110, 'Federal Tax Id', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(111, 'Medipass Number', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(112, 'Texas License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(113, 'Texas Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(114, 'Hawaii License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(115, 'Hawaii DPS License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(116, 'Pennsylvania License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(117, 'New Jersey License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(118, 'Illinois License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(119, 'Georgia License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(120, 'Maryland License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(121, 'California License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(122, 'Washington DC License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(123, 'Virginia License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(124, 'Indiana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(125, 'New York License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(126, 'Wisconsin License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(127, 'Ohio License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(128, 'Massachusetts License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(129, 'Connecticut Licence', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(130, 'Arizona License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(131, 'Kentucky License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(132, 'Louisiana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(133, 'US Virgin Islands', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(134, 'North Carolina', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(135, 'Missouri License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(136, 'Colorado License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(137, 'Rhode Island License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(138, 'Mississippi License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(139, 'Montana License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(140, 'Michigan License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(141, 'Tennessee License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(142, 'Puerto Rico', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(143, 'Minnesota License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(144, 'Nevada License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(145, 'New Hampshire License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(146, 'CDS License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(147, 'Kansas License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(148, 'New Mexico License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(149, 'Alabama License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(150, 'Oklahoma License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(151, 'ACLS Program', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(152, 'BLS Program', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(153, 'Guam License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(154, 'South Dakota license', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(155, 'Guam Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(156, 'Maryland Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(157, 'BTLS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(158, 'PALS', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(159, 'BTLS-A', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(160, 'ACLS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(161, 'PALS-I', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(162, 'Wash. DC Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(163, 'Oregon License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(164, 'Indiana Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(165, 'New Jersey Controlled Substanc', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(166, 'Washington State License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(167, 'Massachusetts Control Substan', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(168, 'South Carolina License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(169, 'Alabama Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(170, 'Arkansas License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(171, 'Idaho License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(172, 'Maine License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(173, 'Delaware License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(174, 'Texas Social Worker License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(175, 'Iowa License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(176, 'Iowa Controlled Substance', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(177, 'Nebraska License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(178, 'Nebraska Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(179, 'West Virginia License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(180, 'Illinois Control Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(181, 'Michigan Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(182, 'Alaska License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(183, 'Alaska Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(184, 'Idaho Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(185, 'Missouri Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(186, 'Louisiana Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(187, 'Oklahoma Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(188, 'South Carolina Controlled Subs', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(189, 'Utah License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(190, 'Connectic Controlled Substance', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(191, 'North Dakota License', 1, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(192, 'Vermont License', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(193, 'Nat\'l Provider Identifier', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42'),
(194, 'Medicaid Group #\'s', 0, 0, '2016-06-14 18:17:42', '2016-06-14 18:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `identification_provider`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `identification_provider`;
CREATE TABLE `identification_provider` (
  `provider_id` int(10) UNSIGNED NOT NULL,
  `identification_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurers`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `insurers`;
CREATE TABLE `insurers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internships`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `internships`;
CREATE TABLE `internships` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `internship_type_id` int(10) UNSIGNED NOT NULL,
  `hospital_id` int(10) UNSIGNED NOT NULL,
  `discipline_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internship_types`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `internship_types`;
CREATE TABLE `internship_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `internship_types`
--

INSERT INTO `internship_types` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Radiology', 0, '2016-06-14 22:44:09', '2016-06-15 21:53:26'),
(2, 'Research', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(3, 'Medical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(4, 'Surgical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(5, 'Pediatrics', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(6, 'Rotating', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(7, 'Fifth Path', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(8, 'Not Specif', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(9, 'Podiatry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(10, 'Teacher', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(11, 'Psychology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(12, 'SocialWork', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(13, 'Anesthesia', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(14, 'Pathology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(15, 'Counselor', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(16, 'Transition', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(17, 'Dietetic', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(18, 'Flexible', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(19, 'Optometry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(20, 'Psychiatry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(21, 'Nurse-Midw', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(22, 'Clinical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(23, 'Chiro.', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(24, 'Music', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(25, 'Massage', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(26, 'Dermatolog', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(27, 'Dental', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(28, 'Externship', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(29, 'Orthopedic', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(30, 'Therapy', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(31, 'N/A', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(32, 'Family Practice', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(33, 'Categorical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(34, 'Oxolaryngology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(35, 'EMG', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(36, 'Neuropsychology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(37, 'Osteopathic Internship', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(38, 'Obstetrics & Gynecology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(39, 'Internal Medicine', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(40, 'Family Medicine', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(41, 'Traditional', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(42, 'Oncology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(43, 'Dermatologic Pathology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(44, 'Radiology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(45, 'Research', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(46, 'Medical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(47, 'Surgical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(48, 'Pediatrics', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(49, 'Rotating', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(50, 'Fifth Path', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(51, 'Not Specif', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(52, 'Podiatry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(53, 'Teacher', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(54, 'Psychology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(55, 'SocialWork', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(56, 'Anesthesia', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(57, 'Pathology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(58, 'Counselor', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(59, 'Transition', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(60, 'Dietetic', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(61, 'Flexible', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(62, 'Optometry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(63, 'Psychiatry', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(64, 'Nurse-Midw', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(65, 'Clinical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(66, 'Chiro.', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(67, 'Music', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(68, 'Massage', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(69, 'Dermatolog', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(70, 'Dental', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(71, 'Externship', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(72, 'Orthopedic', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(73, 'Therapy', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(74, 'N/A', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(75, 'Family Practice', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(76, 'Categorical', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(77, 'Oxolaryngology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(78, 'EMG', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(79, 'Neuropsychology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(80, 'Osteopathic Internship', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(81, 'Obstetrics & Gynecology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(82, 'Internal Medicine', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(83, 'Family Medicine', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(84, 'Traditional', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(85, 'Oncology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09'),
(86, 'Dermatologic Pathology', 0, '2016-06-14 22:44:09', '2016-06-14 22:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'NO RESPONSE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(2, 'NATIVE AMERICAN INDIAN (ANY)', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(3, 'ALBANIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(4, 'AMHARIC', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(5, 'ARABIC', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(6, 'ARMENIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(7, 'ASSYRIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(8, 'BANTU', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(9, 'BOHEMIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(10, 'BULGARIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(11, 'BURMESE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(12, 'BYELORUSSIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(13, 'CAMBODIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(14, 'CHINESE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(15, 'CROATIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(16, 'DANISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(17, 'DUTCH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(18, 'ESTONIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(19, 'FINNISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(20, 'FLEMISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(21, 'FRENCH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(22, 'GERMAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(23, 'GREEK', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(24, 'HEBREW', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(25, 'HINDI', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(26, 'HUNGARIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(27, 'ICELANDIC', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(28, 'ITALIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(29, 'JAPANESE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(30, 'KOREAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(31, 'LAO', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(32, 'LATVIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(33, 'LITHUANIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(34, 'MALAY', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(35, 'MAHRATTA', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(36, 'NORWEGIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(37, 'PAPUAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(38, 'PERSIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(39, 'POLISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(40, 'POLYNESIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(41, 'PORTUGESE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(42, 'PUNJABI', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(43, 'RUMANIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(44, 'RUSSIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(45, 'SCANDINAVIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(46, 'SERBIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(47, 'SLOVENIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(48, 'SPANISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(49, 'SWEDISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(50, 'TAMIL', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(51, 'TURKISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(52, 'UKRANIAN', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(53, 'URDU', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(54, 'VIETNAMESE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(55, 'AMERICAN SIGN LANGUAGE (ASL)', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(56, 'ENGLISH', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(57, 'UNSPECIFIED FOREIGN LANGUAGE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55'),
(58, 'OTHER FOREIGN LANGUAGE', 0, '2016-06-14 18:50:55', '2016-06-14 18:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `language_provider`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `language_provider`;
CREATE TABLE `language_provider` (
  `provider_id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `logins`;
CREATE TABLE `logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logged_in` datetime DEFAULT NULL,
  `logged_out` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_12_16_000001_create_privileges_table', 1),
('2015_12_16_000002_create_roles_table', 1),
('2015_12_16_000003_create_privilege_role_pivot_table', 1),
('2015_12_16_000004_create_users_table', 1),
('2015_12_16_000005_create_role_user_pivot_table', 1),
('2015_12_16_000006_create_password_resets_table', 1),
('2015_12_16_000007_create_config_table', 1),
('2015_12_16_000008_create_logins_table', 1),
('2015_12_16_000009_create_privilege_user_pivot_table', 1),
('2016_06_14_000011_create_certifications_table', 2),
('2016_06_14_000012_create_degrees_table', 3),
('2016_06_14_000013_create_bodies_table', 4),
('2016_06_14_000014_create_exams_table', 5),
('2016_06_14_000015_create_identifications_table', 5),
('2016_06_14_000016_create_schools_table', 6),
('2016_06_14_000017_create_hospitals_table', 6),
('2016_06_14_000018_create_insurers_table', 6),
('2016_06_14_000019_create_internships_table', 6),
('2016_06_14_000020_create_languages_table', 7),
('2016_06_14_000021_create_services_table', 8),
('2016_06_14_000022_create_procedures_table', 8),
('2016_06_14_000023_create_titles_table', 9),
('2016_06_14_000019_create_internshiptypes_table', 10),
('2016_06_14_000024_create_types_table', 10),
('2016_06_14_000025_create_addresstypes_table', 10),
('2016_06_14_000026_create_states_table', 10),
('2016_06_14_000027_create_specialitytypes_table', 10),
('2016_06_14_000028_create_disciplines_table', 10),
('2016_06_14_000051_create_providers_table', 10),
('2016_06_14_000052_create_notes_table', 10),
('2016_06_14_000053_create_boards_table', 10),
('2016_06_14_000054_create_educations_table', 10),
('2016_06_14_000055_create_fellowships_table', 10),
('2016_06_14_000056_create_residencies_table', 10),
('2016_06_14_000057_create_addresses_table', 10),
('2016_06_14_000058_create_internships_table', 10),
('2016_06_14_000059_create_specialities_table', 10),
('2016_06_14_000081_create_language_provider_pivot_table', 10),
('2016_06_14_000082_create_identification_provider_pivot_table', 10),
('2016_06_14_000083_create_exam_provider_pivot_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE `privileges` (
  `id` int(10) UNSIGNED NOT NULL,
  `privilege_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `privilege_name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'list-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(2, 'search-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(3, 'show-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(4, 'create-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(5, 'update-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(6, 'delete-user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(7, 'list-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(8, 'search-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(9, 'show-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(10, 'create-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(11, 'update-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(12, 'modify-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(13, 'delete-role', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(14, 'list-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(15, 'search-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(16, 'show-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(17, 'create-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(18, 'update-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(19, 'modify-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(20, 'delete-privilege', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(21, 'list-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(22, 'search-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(23, 'show-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(24, 'create-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(25, 'update-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(26, 'modify-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(27, 'delete-config', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(28, 'list-login', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(29, 'search-login', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(30, 'show-login', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(31, 'list-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(32, 'search-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(33, 'show-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(34, 'create-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(35, 'update-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(36, 'delete-certification', 0, '2016-06-14 18:23:20', '2016-06-14 18:23:20'),
(37, 'list-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(38, 'search-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(39, 'show-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(40, 'create-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(41, 'update-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(42, 'delete-body', 0, '2016-06-14 23:37:17', '2016-06-14 23:37:17'),
(43, 'list-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(44, 'search-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(45, 'show-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(46, 'create-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(47, 'update-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(48, 'delete-degree', 0, '2016-06-15 01:22:37', '2016-06-15 01:22:37'),
(49, 'list-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(50, 'search-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(51, 'show-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(52, 'create-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(53, 'update-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(54, 'delete-addresstype', 0, '2016-06-15 20:26:51', '2016-06-15 20:26:51'),
(55, 'list-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(56, 'search-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(57, 'show-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(58, 'create-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(59, 'update-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(60, 'delete-specialitytype', 0, '2016-06-15 20:27:42', '2016-06-15 20:27:42'),
(61, 'list-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(62, 'search-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(63, 'show-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(64, 'create-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(65, 'update-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(66, 'delete-internshiptype', 0, '2016-06-15 20:28:06', '2016-06-15 20:28:06'),
(67, 'list-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(68, 'search-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(69, 'show-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(70, 'create-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(71, 'update-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(72, 'delete-address', 0, '2016-06-15 20:31:58', '2016-06-15 20:31:58'),
(73, 'list-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(74, 'search-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(75, 'show-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(76, 'create-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(77, 'update-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(78, 'delete-board', 0, '2016-06-15 20:33:04', '2016-06-15 20:33:04'),
(79, 'list-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(80, 'search-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(81, 'show-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(82, 'create-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(83, 'update-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(84, 'delete-certification', 0, '2016-06-15 20:33:30', '2016-06-15 20:33:30'),
(85, 'list-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(86, 'search-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(87, 'show-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(88, 'create-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(89, 'update-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(90, 'delete-discipline', 0, '2016-06-15 20:51:18', '2016-06-15 20:51:18'),
(91, 'list-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(92, 'search-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(93, 'show-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(94, 'create-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(95, 'update-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(96, 'delete-education', 0, '2016-06-15 20:51:38', '2016-06-15 20:51:38'),
(97, 'list-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(98, 'search-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(99, 'show-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(100, 'create-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(101, 'update-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(102, 'delete-exam', 0, '2016-06-15 20:51:55', '2016-06-15 20:51:55'),
(103, 'list-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(104, 'search-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(105, 'show-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(106, 'create-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(107, 'update-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(108, 'delete-fellowship', 0, '2016-06-15 20:52:19', '2016-06-15 20:52:19'),
(109, 'list-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(110, 'search-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(111, 'show-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(112, 'create-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(113, 'update-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(114, 'delete-hospital', 0, '2016-06-15 20:52:45', '2016-06-15 20:52:45'),
(115, 'list-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(116, 'search-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(117, 'show-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(118, 'create-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(119, 'update-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(120, 'delete-identification', 0, '2016-06-15 20:53:17', '2016-06-15 20:53:17'),
(121, 'list-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(122, 'search-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(123, 'show-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(124, 'create-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(125, 'update-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(126, 'delete-insurer', 0, '2016-06-15 20:53:31', '2016-06-15 20:53:31'),
(127, 'list-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(128, 'search-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(129, 'show-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(130, 'create-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(131, 'update-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(132, 'delete-internship', 0, '2016-06-15 20:53:51', '2016-06-15 20:53:51'),
(133, 'list-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(134, 'search-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(135, 'show-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(136, 'create-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(137, 'update-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(138, 'delete-language', 0, '2016-06-15 20:54:07', '2016-06-15 20:54:07'),
(139, 'list-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(140, 'search-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(141, 'show-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(142, 'create-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(143, 'update-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(144, 'delete-note', 0, '2016-06-15 20:54:22', '2016-06-15 20:54:22'),
(145, 'list-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(146, 'search-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(147, 'show-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(148, 'create-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(149, 'update-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(150, 'delete-procedure', 0, '2016-06-15 20:54:36', '2016-06-15 20:54:36'),
(151, 'list-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(152, 'search-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(153, 'show-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(154, 'create-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(155, 'update-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(156, 'delete-provider', 0, '2016-06-15 20:54:54', '2016-06-15 20:54:54'),
(157, 'list-residency', 0, '2016-06-15 20:55:11', '2016-06-15 20:55:11'),
(158, 'search-residency', 0, '2016-06-15 20:55:12', '2016-06-15 20:55:12'),
(159, 'show-residency', 0, '2016-06-15 20:55:12', '2016-06-15 20:55:12'),
(160, 'create-residency', 0, '2016-06-15 20:55:12', '2016-06-15 20:55:12'),
(161, 'update-residency', 0, '2016-06-15 20:55:12', '2016-06-15 20:55:12'),
(162, 'delete-residency', 0, '2016-06-15 20:55:12', '2016-06-15 20:55:12'),
(163, 'list-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(164, 'search-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(165, 'show-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(166, 'create-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(167, 'update-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(168, 'delete-school', 0, '2016-06-15 20:55:27', '2016-06-15 20:55:27'),
(169, 'list-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(170, 'search-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(171, 'show-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(172, 'create-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(173, 'update-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(174, 'delete-service', 0, '2016-06-15 20:55:44', '2016-06-15 20:55:44'),
(175, 'list-speciality', 0, '2016-06-15 20:56:00', '2016-06-15 20:56:00'),
(176, 'search-speciality', 0, '2016-06-15 20:56:00', '2016-06-15 20:56:00'),
(177, 'show-speciality', 0, '2016-06-15 20:56:01', '2016-06-15 20:56:01'),
(178, 'create-speciality', 0, '2016-06-15 20:56:01', '2016-06-15 20:56:01'),
(179, 'update-speciality', 0, '2016-06-15 20:56:01', '2016-06-15 20:56:01'),
(180, 'delete-speciality', 0, '2016-06-15 20:56:01', '2016-06-15 20:56:01'),
(181, 'list-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(182, 'search-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(183, 'show-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(184, 'create-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(185, 'update-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(186, 'delete-state', 0, '2016-06-15 20:56:16', '2016-06-15 20:56:16'),
(187, 'list-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(188, 'search-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(189, 'show-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(190, 'create-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(191, 'update-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(192, 'delete-title', 0, '2016-06-15 20:56:34', '2016-06-15 20:56:34'),
(193, 'list-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(194, 'search-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(195, 'show-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(196, 'create-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(197, 'update-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(198, 'delete-type', 0, '2016-06-15 20:56:51', '2016-06-15 20:56:51'),
(199, 'list-country', 0, '2016-06-17 14:52:47', '2016-06-17 14:52:47'),
(200, 'search-country', 0, '2016-06-17 14:52:47', '2016-06-17 14:52:47'),
(201, 'show-country', 0, '2016-06-17 14:52:47', '2016-06-17 14:52:47'),
(202, 'create-country', 0, '2016-06-17 14:52:47', '2016-06-17 14:52:47'),
(203, 'update-country', 0, '2016-06-17 14:52:47', '2016-06-17 14:52:47'),
(204, 'delete-country', 0, '2016-06-17 14:52:48', '2016-06-17 14:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `privilege_role`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `privilege_role`;
CREATE TABLE `privilege_role` (
  `privilege_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `privilege_role`
--

INSERT INTO `privilege_role` (`privilege_id`, `role_id`) VALUES
(70, 4),
(52, 4),
(76, 4),
(40, 4),
(34, 4),
(82, 4),
(46, 4),
(88, 4),
(94, 4),
(100, 4),
(106, 4),
(112, 4),
(118, 4),
(124, 4),
(130, 4),
(64, 4),
(136, 4),
(142, 4),
(148, 4),
(154, 4),
(160, 4),
(166, 4),
(172, 4),
(178, 4),
(58, 4),
(184, 4),
(190, 4),
(196, 4),
(67, 4),
(49, 4),
(73, 4),
(37, 4),
(31, 4),
(79, 4),
(43, 4),
(85, 4),
(91, 4),
(97, 4),
(103, 4),
(109, 4),
(115, 4),
(121, 4),
(127, 4),
(61, 4),
(133, 4),
(139, 4),
(145, 4),
(151, 4),
(157, 4),
(163, 4),
(169, 4),
(175, 4),
(55, 4),
(181, 4),
(187, 4),
(193, 4),
(68, 4),
(50, 4),
(74, 4),
(38, 4),
(32, 4),
(80, 4),
(44, 4),
(86, 4),
(92, 4),
(98, 4),
(104, 4),
(110, 4),
(116, 4),
(122, 4),
(128, 4),
(62, 4),
(134, 4),
(140, 4),
(146, 4),
(152, 4),
(158, 4),
(164, 4),
(170, 4),
(176, 4),
(56, 4),
(182, 4),
(188, 4),
(194, 4),
(69, 4),
(51, 4),
(75, 4),
(39, 4),
(33, 4),
(81, 4),
(45, 4),
(87, 4),
(93, 4),
(99, 4),
(105, 4),
(111, 4),
(117, 4),
(123, 4),
(129, 4),
(63, 4),
(135, 4),
(141, 4),
(147, 4),
(153, 4),
(159, 4),
(165, 4),
(171, 4),
(177, 4),
(57, 4),
(183, 4),
(189, 4),
(195, 4),
(71, 4),
(53, 4),
(77, 4),
(41, 4),
(35, 4),
(83, 4),
(47, 4),
(89, 4),
(95, 4),
(101, 4),
(107, 4),
(113, 4),
(119, 4),
(125, 4),
(131, 4),
(65, 4),
(137, 4),
(143, 4),
(149, 4),
(155, 4),
(161, 4),
(167, 4),
(173, 4),
(179, 4),
(59, 4),
(185, 4),
(191, 4),
(197, 4),
(70, 3),
(52, 3),
(76, 3),
(40, 3),
(34, 3),
(82, 3),
(46, 3),
(88, 3),
(94, 3),
(100, 3),
(106, 3),
(112, 3),
(118, 3),
(124, 3),
(130, 3),
(64, 3),
(136, 3),
(142, 3),
(148, 3),
(154, 3),
(160, 3),
(166, 3),
(172, 3),
(178, 3),
(58, 3),
(184, 3),
(190, 3),
(196, 3),
(4, 3),
(72, 3),
(54, 3),
(78, 3),
(42, 3),
(36, 3),
(84, 3),
(48, 3),
(90, 3),
(96, 3),
(102, 3),
(108, 3),
(114, 3),
(120, 3),
(126, 3),
(132, 3),
(66, 3),
(138, 3),
(144, 3),
(150, 3),
(156, 3),
(162, 3),
(168, 3),
(174, 3),
(180, 3),
(60, 3),
(186, 3),
(192, 3),
(198, 3),
(67, 3),
(49, 3),
(73, 3),
(37, 3),
(31, 3),
(79, 3),
(21, 3),
(43, 3),
(85, 3),
(91, 3),
(97, 3),
(103, 3),
(109, 3),
(115, 3),
(121, 3),
(127, 3),
(61, 3),
(133, 3),
(28, 3),
(139, 3),
(14, 3),
(145, 3),
(151, 3),
(157, 3),
(7, 3),
(163, 3),
(169, 3),
(175, 3),
(55, 3),
(181, 3),
(187, 3),
(193, 3),
(1, 3),
(68, 3),
(50, 3),
(74, 3),
(38, 3),
(32, 3),
(80, 3),
(22, 3),
(44, 3),
(86, 3),
(92, 3),
(98, 3),
(104, 3),
(110, 3),
(116, 3),
(122, 3),
(128, 3),
(62, 3),
(134, 3),
(29, 3),
(140, 3),
(15, 3),
(146, 3),
(152, 3),
(158, 3),
(8, 3),
(164, 3),
(170, 3),
(176, 3),
(56, 3),
(182, 3),
(188, 3),
(194, 3),
(2, 3),
(69, 3),
(51, 3),
(75, 3),
(39, 3),
(33, 3),
(81, 3),
(23, 3),
(45, 3),
(87, 3),
(93, 3),
(99, 3),
(105, 3),
(111, 3),
(117, 3),
(123, 3),
(129, 3),
(63, 3),
(135, 3),
(30, 3),
(141, 3),
(16, 3),
(147, 3),
(153, 3),
(159, 3),
(9, 3),
(165, 3),
(171, 3),
(177, 3),
(57, 3),
(183, 3),
(189, 3),
(195, 3),
(3, 3),
(71, 3),
(53, 3),
(77, 3),
(41, 3),
(35, 3),
(83, 3),
(25, 3),
(47, 3),
(89, 3),
(95, 3),
(101, 3),
(107, 3),
(113, 3),
(119, 3),
(125, 3),
(131, 3),
(65, 3),
(137, 3),
(143, 3),
(149, 3),
(155, 3),
(161, 3),
(167, 3),
(173, 3),
(179, 3),
(59, 3),
(185, 3),
(191, 3),
(197, 3),
(5, 3),
(70, 2),
(52, 2),
(76, 2),
(40, 2),
(34, 2),
(82, 2),
(24, 2),
(202, 2),
(46, 2),
(88, 2),
(94, 2),
(100, 2),
(106, 2),
(112, 2),
(118, 2),
(124, 2),
(130, 2),
(64, 2),
(136, 2),
(142, 2),
(17, 2),
(148, 2),
(154, 2),
(160, 2),
(10, 2),
(166, 2),
(172, 2),
(178, 2),
(58, 2),
(184, 2),
(190, 2),
(196, 2),
(4, 2),
(72, 2),
(54, 2),
(78, 2),
(42, 2),
(36, 2),
(84, 2),
(27, 2),
(204, 2),
(48, 2),
(90, 2),
(96, 2),
(102, 2),
(108, 2),
(114, 2),
(120, 2),
(126, 2),
(132, 2),
(66, 2),
(138, 2),
(144, 2),
(20, 2),
(150, 2),
(156, 2),
(162, 2),
(13, 2),
(168, 2),
(174, 2),
(180, 2),
(60, 2),
(186, 2),
(192, 2),
(198, 2),
(6, 2),
(67, 2),
(49, 2),
(73, 2),
(37, 2),
(31, 2),
(79, 2),
(21, 2),
(199, 2),
(43, 2),
(85, 2),
(91, 2),
(97, 2),
(103, 2),
(109, 2),
(115, 2),
(121, 2),
(127, 2),
(61, 2),
(133, 2),
(28, 2),
(139, 2),
(14, 2),
(145, 2),
(151, 2),
(157, 2),
(7, 2),
(163, 2),
(169, 2),
(175, 2),
(55, 2),
(181, 2),
(187, 2),
(193, 2),
(1, 2),
(26, 2),
(19, 2),
(12, 2),
(68, 2),
(50, 2),
(74, 2),
(38, 2),
(32, 2),
(80, 2),
(22, 2),
(200, 2),
(44, 2),
(86, 2),
(92, 2),
(98, 2),
(104, 2),
(110, 2),
(116, 2),
(122, 2),
(128, 2),
(62, 2),
(134, 2),
(29, 2),
(140, 2),
(15, 2),
(146, 2),
(152, 2),
(158, 2),
(8, 2),
(164, 2),
(170, 2),
(176, 2),
(56, 2),
(182, 2),
(188, 2),
(194, 2),
(2, 2),
(69, 2),
(51, 2),
(75, 2),
(39, 2),
(33, 2),
(81, 2),
(23, 2),
(201, 2),
(45, 2),
(87, 2),
(93, 2),
(99, 2),
(105, 2),
(111, 2),
(117, 2),
(123, 2),
(129, 2),
(63, 2),
(135, 2),
(30, 2),
(141, 2),
(16, 2),
(147, 2),
(153, 2),
(159, 2),
(9, 2),
(165, 2),
(171, 2),
(177, 2),
(57, 2),
(183, 2),
(189, 2),
(195, 2),
(3, 2),
(71, 2),
(53, 2),
(77, 2),
(41, 2),
(35, 2),
(83, 2),
(25, 2),
(203, 2),
(47, 2),
(89, 2),
(95, 2),
(101, 2),
(107, 2),
(113, 2),
(119, 2),
(125, 2),
(131, 2),
(65, 2),
(137, 2),
(143, 2),
(18, 2),
(149, 2),
(155, 2),
(161, 2),
(11, 2),
(167, 2),
(173, 2),
(179, 2),
(59, 2),
(185, 2),
(191, 2),
(197, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `privilege_user`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `privilege_user`;
CREATE TABLE `privilege_user` (
  `privilege_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `procedures`;
CREATE TABLE `procedures` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `vlink` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`id`, `name`, `code`, `vlink`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Office Visits', '1001', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(2, 'Specialists Consultation, Diagnosis', '1002', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(3, 'Other Outpatient Non-Surgical Care', '1003', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(4, 'Periodic Physical Exams', '1004', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(5, 'Surgical Care in Physicians Office', '1005', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(6, 'Well Child Care', '1006', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(7, 'Inpatient Surgery', '1007', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(8, 'Obstetrical / Gynecological Care', '1008', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(9, 'Family Planning', '1009', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(10, 'Immunization', '1031', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(11, 'Ear Exam', '1032', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(12, 'Eye Exam', '1033', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(13, 'Pre-Natal Care', '1034', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(14, 'Lab', '1041', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(15, 'X-Ray', '1044', 'A', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(16, 'Non-Surgical care', '1012', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(17, 'Organ Transplants', '1013', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(18, 'Pre-Admission Testing', '1014', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(19, 'Diagnostic Services', '1035', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(20, 'Drugs, Medication', '1036', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(21, 'Surgical Procedures', '1037', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(22, 'Anesthesia', '1038', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(23, 'Blood', '1039', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(24, 'Dialysis', '1040', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(25, 'Obstetrical Delivery', '1041', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(26, 'Newborn`s Nursery Services', '1042', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(27, 'Mother`s Hospital Services', '1043', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(28, 'General Hospital Stay', '1045', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(29, 'Diagnostic Testing', '1046', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(30, 'Labs', '1047', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(31, 'X-Rays', '1048', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(32, 'Nursing Care', '1049', 'B', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(33, 'Home Health Care', '1018', 'C', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(34, 'Ambulance', '1019', 'C', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(35, 'Skilled Nursing Facility', '1020', 'C', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(36, 'Durable Medical Equipment', '1021', 'C', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(37, 'Hospice Care', '1022', 'C', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(38, 'In PCP Office', '1015', 'D', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(39, 'In Hospital', '1016', 'D', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(40, 'In Urgent Care Center', '1017', 'D', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(41, 'Mental Health', '1023', 'E', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(42, 'Alcohol & Chemical Detoxification', '1026', 'E', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20'),
(43, 'Vision Care', '1050', 'F', 0, '2016-06-14 18:59:20', '2016-06-14 18:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--
-- Creation: Jun 17, 2016 at 09:17 PM
--

DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_type_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider_subtypes`
--
-- Creation: Jun 17, 2016 at 09:17 PM
--

DROP TABLE IF EXISTS `provider_subtypes`;
CREATE TABLE `provider_subtypes` (
  `id` int(11) NOT NULL,
  `provider_type_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_subtypes`
--

INSERT INTO `provider_subtypes` (`id`, `provider_type_id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 1, 'Physicians (MDs, DOs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(2, 1, 'Nurses', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(3, 1, 'Pharmacists', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(4, 1, 'Certified nurse midwives (CNMs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(5, 1, 'Certified registered nurse anesthetists (CRNAs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(6, 1, 'Licensed practical nurses (LPNs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(7, 1, 'Registered nurses (RNs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(8, 1, 'Clinical nurse specialists (CNSs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(9, 1, 'Physician assistant (PA)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19'),
(10, 1, 'Nurse practitioners (NPs)', 0, '2016-06-17 21:13:47', '2016-06-17 21:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `provider_types`
--
-- Creation: Jun 17, 2016 at 09:15 PM
--

DROP TABLE IF EXISTS `provider_types`;
CREATE TABLE `provider_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_types`
--

INSERT INTO `provider_types` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Person', 0, '2016-06-17 04:00:00', '2016-06-17 21:10:03'),
(2, 'Institution', 0, '2016-06-17 04:00:00', '2016-06-17 21:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `residencies`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `residencies`;
CREATE TABLE `residencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `speciality_type_id` int(10) UNSIGNED NOT NULL,
  `hospital_id` int(10) UNSIGNED NOT NULL,
  `degree_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'root', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(2, 'superadmin', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(3, 'admin', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00'),
(4, 'dataentry', 0, '2015-12-16 05:00:00', '2016-06-14 18:25:51'),
(5, 'user', 0, '2015-12-16 05:00:00', '2015-12-16 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(6, 2),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE `schools` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Physical Exams', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(2, 'Check Ups', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(3, 'Medical Treatment', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(4, 'Surgical Treatment', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(5, 'Xrays', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(6, 'Allergy Injections', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(7, 'Lab Tests', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(8, 'Well Child Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(9, 'Family Planning', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(10, 'Immunizations', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(11, 'Pediatrician', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(12, 'Other Specialists', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(13, 'Semi Private Accommodation', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(14, 'Medically Necessary Services - Physician', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(15, 'Medically Necessary Services - Surgeon S', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(16, 'Routine Nursing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(17, 'Intensive Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(18, 'Coronary Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(19, 'Pre-admission Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(20, 'Drugs', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(21, 'Anesthesia', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(22, 'Physical Therapy', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(23, 'Administration of Blood and other service', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(24, 'Private Room when medically necessary', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(25, 'Private Duty Nurse when Medically necessary', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(26, 'Outpatient non-emergency services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(27, 'Pre-natal services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(28, 'Post-natal services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(29, 'Hospitalization and Pregnancy complicati', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(30, 'Primary Care Physician Services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(31, 'Hospital Services within Plan Service ar', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(32, 'Hospital services outside plan service a', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(33, 'Medically necessary service in emegency', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(34, 'Necessary services arranged by Primary P', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(35, '100 days of non-custodial care per lifet', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(36, 'Inpatient/Partial hospital coverage - 30', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(37, 'Outpatient, greater of 20 visits/$1000 p', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(38, 'Medically necessary detoxification - inp', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(39, 'Medically necessary detoxification - out', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(40, 'Outpatient(non-detox), 44 visits/lifetim', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(41, 'Elective Procedures', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(42, 'Counseling and testing services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(43, 'Dental coverage', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(44, 'Prescription drug coverage, $3/$5 copaym', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(45, 'Vision coverage', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(46, 'Outpatient surgery', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(47, 'Hospital emergency room care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(48, 'Maximum hospital out-of-pocket expense l', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(49, 'Allergy Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(50, 'Diagnostic Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(51, 'Physical Exams', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(52, 'Check Ups', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(53, 'Medical Treatment', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(54, 'Surgical Treatment', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(55, 'Xrays', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(56, 'Allergy Injections', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(57, 'Lab Tests', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(58, 'Well Child Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(59, 'Family Planning', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(60, 'Immunizations', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(61, 'Pediatrician', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(62, 'Other Specialists', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(63, 'Semi Private Accommodation', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(64, 'Medically Necessary Services - Physician', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(65, 'Medically Necessary Services - Surgeon S', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(66, 'Routine Nursing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(67, 'Intensive Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(68, 'Coronary Care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(69, 'Pre-admission Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(70, 'Drugs', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(71, 'Anesthesia', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(72, 'Physical Therapy', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(73, 'Administration of Blood and other service', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(74, 'Private Room when medically necessary', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(75, 'Private Duty Nurse when Medically necessary', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(76, 'Outpatient non-emergency services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(77, 'Pre-natal services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(78, 'Post-natal services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(79, 'Hospitalization and Pregnancy complicati', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(80, 'Primary Care Physician Services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(81, 'Hospital Services within Plan Service ar', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(82, 'Hospital services outside plan service a', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(83, 'Medically necessary service in emegency', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(84, 'Necessary services arranged by Primary P', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(85, '100 days of non-custodial care per lifet', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(86, 'Inpatient/Partial hospital coverage - 30', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(87, 'Outpatient, greater of 20 visits/$1000 p', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(88, 'Medically necessary detoxification - inp', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(89, 'Medically necessary detoxification - out', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(90, 'Outpatient(non-detox), 44 visits/lifetim', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(91, 'Elective Procedures', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(92, 'Counseling and testing services', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(93, 'Dental coverage', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(94, 'Prescription drug coverage, $3/$5 copaym', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(95, 'Vision coverage', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(96, 'Outpatient surgery', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(97, 'Hospital emergency room care', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(98, 'Maximum hospital out-of-pocket expense l', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(99, 'Allergy Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48'),
(100, 'Diagnostic Testing', 0, '2016-06-14 19:03:48', '2016-06-14 19:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `specialities`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `specialities`;
CREATE TABLE `specialities` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `speciality_type_id` int(10) UNSIGNED NOT NULL,
  `certification_id` int(10) UNSIGNED NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `speciality_types`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `speciality_types`;
CREATE TABLE `speciality_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--
-- Creation: Jun 17, 2016 at 04:26 PM
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `short_name` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `short_name`, `full_name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 232, 'AL', 'Alabama', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(2, 232, 'AK', 'Alaska', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(3, 232, 'AZ', 'Arizona', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(4, 232, 'AR', 'Arkansas', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(5, 232, 'CA', 'California', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(6, 232, 'CO', 'Colorado', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(7, 232, 'CT', 'Connecticut', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(8, 232, 'DE', 'Delaware', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(9, 232, 'FL', 'Florida', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(10, 232, 'GA', 'Georgia', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(11, 232, 'HI', 'Hawaii', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(12, 232, 'ID', 'Idaho', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(13, 232, 'IL', 'Illinois', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(14, 232, 'IN', 'Indiana', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(15, 232, 'IA', 'Iowa', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(16, 232, 'KS', 'Kansas', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(17, 232, 'KY', 'Kentucky', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(18, 232, 'LA', 'Louisiana', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(19, 232, 'ME', 'Maine', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(20, 232, 'MD', 'Maryland', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(21, 232, 'MA', 'Massachusetts', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(22, 232, 'MI', 'Michigan', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(23, 232, 'MN', 'Minnesota', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(24, 232, 'MS', 'Mississippi', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(25, 232, 'MO', 'Missouri', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(26, 232, 'MT', 'Montana', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(27, 232, 'NE', 'Nebraska', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(28, 232, 'NV', 'Nevada', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(29, 232, 'NH', 'New Hampshire', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(30, 232, 'NJ', 'New Jersey', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(31, 232, 'NM', 'New Mexico', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(32, 232, 'NY', 'New York', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(33, 232, 'NC', 'North Carolina', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(34, 232, 'ND', 'North Dakota', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(35, 232, 'OH', 'Ohio', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(36, 232, 'OK', 'Oklahoma', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(37, 232, 'OR', 'Oregon', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(38, 232, 'PA', 'Pennsylvania', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(39, 232, 'RI', 'Rhode Island', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(40, 232, 'SC', 'South Carolina', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(41, 232, 'SD', 'South Dakota', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(42, 232, 'TN', 'Tennessee', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(43, 232, 'TX', 'Texas', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(44, 232, 'UT', 'Utah', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(45, 232, 'VT', 'Vermont', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(46, 232, 'VA', 'Virginia', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(47, 232, 'WA', 'Washington', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(48, 232, 'WV', 'West Virginia', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(49, 232, 'WI', 'Wisconsin', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49'),
(50, 232, 'WY', 'Wyoming', 0, '2016-06-17 14:13:22', '2016-06-17 16:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `titles`;
CREATE TABLE `titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `name`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(2, 'Administrator, Sr. Assistant', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(3, 'Admissions, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(4, 'Ambulatory Services, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(5, 'Anesthesiology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(6, 'Blood Bank, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(7, 'Burn Care Services, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(8, 'Cardiac Surgery, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(9, 'Cardiology, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(10, 'Catheterization Laboratory, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(11, 'Central Supply, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(12, 'Chemistry, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(13, 'Chief Financial Officer', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(14, 'Chief Resident', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(15, 'Controller', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(16, 'Counseling Services, Dir. of patient', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(17, 'Cytology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(18, 'Data Processing / MIS, Mng. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(19, 'Dentistry, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(20, 'Dermatology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(21, 'Detoxification Services, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(22, 'Dialysis Services, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(23, 'DRG Coding Manager', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(24, 'Ear/Nose/Throat Dpt., Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(25, 'Emerg. Rm. Services, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(26, 'Emerg. Rm./ Services, Clin./Biomed', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(27, 'Executive Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(28, 'Food Services, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(29, 'Formulary, Head of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(30, 'Gastrology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(31, 'Home Health Care Coord.', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(32, 'Housekeeping Coord.', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(33, 'In-Service Education, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(34, 'Infection Control, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(35, 'Infectious Diseases, Dir.of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(36, 'Intensive Care Unit, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(37, 'Internal Medicine, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(38, 'Laboratories, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(39, 'Laundry Management, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(40, 'Library, Dir. of Medical', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(41, 'Marketing/Planning, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(42, 'Materials Management, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(43, 'Medical Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(44, 'Member/Provider Services Mng.', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(45, 'Neurosurgery, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(46, 'Nuclear Medicine, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(47, 'Nurse Central services Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(48, 'Nurse, Crit. Care Unit Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(49, 'Nurse, ICU Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(50, 'Nurse, Neonatal ICU Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(51, 'Nurse, Operating Room Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(52, 'Nurse, Pediatrics ICU Supervising', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(53, 'Nursery, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(54, 'Nursing, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(55, 'Nursing, Dir. of Med/Surg', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(56, 'OB/GYN, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(57, 'Occupational Therapy, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(58, 'Oncology, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(59, 'Opthalmic Surgery, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(60, 'Orthopedic Surgery, chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(61, 'Orthopedics, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(62, 'Pathology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(63, 'Pediatrics, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(64, 'Personnel Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(65, 'Pharmacy Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(66, 'Physical Plant, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(67, 'Physical Therapy, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(68, 'President or CEO', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(69, 'Psychiatric Services, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(70, 'Public Relations, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(71, 'Purchasing Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(72, 'Quality Assurance, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(73, 'Radiation Therapy, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(74, 'Risk Management', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(75, 'Security, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(76, 'Serology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(77, 'Speech therapt, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(78, 'Staff, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(79, 'Surgery, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(80, 'Toxicology, Dir. of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(81, 'Urology, Chief of', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(82, 'Director of Operations', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(83, 'Financial Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(84, 'Nurse, Head', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(85, 'Utilization Review Manager', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(86, 'Sales Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(87, 'Contact Person', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(88, 'VP', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(89, 'Project Management Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(90, 'Plan Administrator', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(91, 'Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(92, 'Provider Services', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(93, 'Network Manager', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(94, 'MIS Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(95, 'Medical Affairs', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(96, 'SVP', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(97, 'Managed Care Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(98, 'General Manager', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(99, 'Support Services', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(100, 'Counsel', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(101, 'Regional Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(102, 'Claims Director', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(103, 'Manager', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37'),
(104, 'Place', 0, '2016-06-14 19:07:37', '2016-06-14 19:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jun 15, 2016 at 09:47 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `avatar`, `remember_token`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Jose', 'Vidal', 'josei.vidal@yahoo.com', '$2y$10$W1a.p9deK7Oh7cleqtQLp.ZcxfJe1CltkUb1HApm9Ccogc8P2Gpbm', 'yo-470x450-fa3cf1.png', 'rv6b5jDqNvuq1NjorgH7LLVr2mK6S740B3XvWQKhupKNmKo7YpJ3ortD7aQj', 0, '2015-12-16 05:00:00', '2016-06-17 00:41:30'),
(2, 'Michael', 'Trachtenberg', 'mike.trachtenberg@gmail.com', '$2y$10$xrCgkZXhe4UEAVuPHbDDnOU/LAwE1fKqbNn.dlBYCPziP7LueTaAa', 'mike-52881f.jpg', 'QrqzGeE76ChCltQL4eExB951E7wDfyH6XMJeNzfo4bOCjEMwXJOa2c4HqdQz', 0, '2015-12-16 05:00:00', '2016-06-16 13:46:20'),
(3, 'Kenneth', 'Nedd', 'ken@ehdl.com', '$2y$10$ryKE0OrmfOFooAmttrS6h.a9RC09MtwTtWeu0I7Ty3rTfaDUf9BuS', '1383262590_man-7b1e3f.png', 'Yh1hidtafMQT9lmtsbtWT2yst6QGYicpHeYVxfJzqvTVdIdcmXPiTBKqik8H', 0, '2015-12-16 05:00:00', '2016-06-16 13:14:27'),
(4, 'Dataentry', 'User', 'dataentry@test.com', '$2y$10$MmwUVmMOBFphUQmoYQNJPO/aWukl2YdJ0zWNJWb05Wz9mlkneGaJm', '1383263370_serviceman-cc4712.png', NULL, 0, '2015-12-16 05:00:00', '2016-06-16 13:14:49'),
(5, 'Authenticated', 'User', 'authuser@test.com', '$2y$10$MmwUVmMOBFphUQmoYQNJPO/aWukl2YdJ0zWNJWb05Wz9mlkneGaJm', '1383342428_user_female-319010.png', NULL, 0, '2015-12-16 05:00:00', '2016-06-16 13:14:58'),
(6, 'Tabassum', 'Khan', 'tkhan@jipanetwork.com', '$2y$10$ONIMEs1clO/YSKhM5TwkPeGWTJDQqq3vIlQexCi59LP/A3WyyNfIi', '1383262590_man-09e615.png', 'vsB3i2bSFSqLc8QhrT6zTAHcABTe4WGVsiqQw6mynIJOjQRwSUjPeOEZGVm1', 0, '2016-06-14 18:34:52', '2016-06-16 15:10:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD KEY `addresses_provider_id_index` (`provider_id`),
  ADD KEY `addresses_addresstype_id_index` (`address_type_id`);

--
-- Indexes for table `address_types`
--
ALTER TABLE `address_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boards_provider_id_index` (`provider_id`),
  ADD KEY `boards_specialitytype_id_index` (`speciality_type_id`),
  ADD KEY `boards_body_id_index` (`body_id`),
  ADD KEY `boards_certification_id_index` (`certification_id`),
  ADD KEY `boards_state_id_index` (`state_id`);

--
-- Indexes for table `bodies`
--
ALTER TABLE `bodies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certifications_d_sort_index` (`d_sort`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `config_key_unique` (`key`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`name`),
  ADD KEY `country_name` (`name`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educations_provider_id_index` (`provider_id`),
  ADD KEY `educations_school_id_index` (`school_id`),
  ADD KEY `educations_degree_id_index` (`degree_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_d_sort_index` (`d_sort`);

--
-- Indexes for table `exam_provider`
--
ALTER TABLE `exam_provider`
  ADD KEY `exam_provider_provider_id_index` (`provider_id`),
  ADD KEY `exam_provider_exam_id_index` (`exam_id`);

--
-- Indexes for table `fellowships`
--
ALTER TABLE `fellowships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fellowships_provider_id_index` (`provider_id`),
  ADD KEY `fellowships_specialitytype_id_index` (`speciality_type_id`),
  ADD KEY `fellowships_hospital_id_index` (`hospital_id`),
  ADD KEY `fellowships_degree_id_index` (`degree_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identifications`
--
ALTER TABLE `identifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identification_provider`
--
ALTER TABLE `identification_provider`
  ADD KEY `identification_provider_provider_id_index` (`provider_id`),
  ADD KEY `identification_provider_identification_id_index` (`identification_id`);

--
-- Indexes for table `insurers`
--
ALTER TABLE `insurers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internships_provider_id_index` (`provider_id`),
  ADD KEY `internships_internshiptype_id_index` (`internship_type_id`),
  ADD KEY `internships_hospital_id_index` (`hospital_id`),
  ADD KEY `internships_discipline_id_index` (`discipline_id`);

--
-- Indexes for table `internship_types`
--
ALTER TABLE `internship_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_provider`
--
ALTER TABLE `language_provider`
  ADD KEY `language_provider_provider_id_index` (`provider_id`),
  ADD KEY `language_provider_language_id_index` (`language_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logins_user_id_index` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_provider_id_index` (`provider_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege_role`
--
ALTER TABLE `privilege_role`
  ADD KEY `privilege_role_privilege_id_index` (`privilege_id`),
  ADD KEY `privilege_role_role_id_index` (`role_id`);

--
-- Indexes for table `privilege_user`
--
ALTER TABLE `privilege_user`
  ADD KEY `privilege_user_privilege_id_index` (`privilege_id`),
  ADD KEY `privilege_user_user_id_index` (`user_id`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `providers_type_id_index` (`provider_type_id`);

--
-- Indexes for table `provider_subtypes`
--
ALTER TABLE `provider_subtypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_type_id` (`provider_type_id`);

--
-- Indexes for table `provider_types`
--
ALTER TABLE `provider_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residencies`
--
ALTER TABLE `residencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residencies_provider_id_index` (`provider_id`),
  ADD KEY `residencies_specialitytype_id_index` (`speciality_type_id`),
  ADD KEY `residencies_hospital_id_index` (`hospital_id`),
  ADD KEY `residencies_degree_id_index` (`degree_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `role_user_user_id_index` (`user_id`),
  ADD KEY `role_user_role_id_index` (`role_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialities`
--
ALTER TABLE `specialities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialities_provider_id_index` (`provider_id`),
  ADD KEY `specialities_certification_id_index` (`certification_id`),
  ADD KEY `speciality_type_id` (`speciality_type_id`);

--
-- Indexes for table `speciality_types`
--
ALTER TABLE `speciality_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_types`
--
ALTER TABLE `address_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bodies`
--
ALTER TABLE `bodies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;
--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fellowships`
--
ALTER TABLE `fellowships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `identifications`
--
ALTER TABLE `identifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
--
-- AUTO_INCREMENT for table `insurers`
--
ALTER TABLE `insurers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `internship_types`
--
ALTER TABLE `internship_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `provider_subtypes`
--
ALTER TABLE `provider_subtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `provider_types`
--
ALTER TABLE `provider_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `residencies`
--
ALTER TABLE `residencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `specialities`
--
ALTER TABLE `specialities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `speciality_types`
--
ALTER TABLE `speciality_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_address_type_id_foreign` FOREIGN KEY (`address_type_id`) REFERENCES `address_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `addresses_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_body_id_foreign` FOREIGN KEY (`body_id`) REFERENCES `bodies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `certifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_speciality_type_id_foreign` FOREIGN KEY (`speciality_type_id`) REFERENCES `speciality_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_degree_id_foreign` FOREIGN KEY (`degree_id`) REFERENCES `degrees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `educations_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `educations_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_provider`
--
ALTER TABLE `exam_provider`
  ADD CONSTRAINT `exam_provider_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_provider_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fellowships`
--
ALTER TABLE `fellowships`
  ADD CONSTRAINT `fellowships_degree_id_foreign` FOREIGN KEY (`degree_id`) REFERENCES `degrees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fellowships_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fellowships_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fellowships_speciality_type_id_foreign` FOREIGN KEY (`speciality_type_id`) REFERENCES `speciality_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `identification_provider`
--
ALTER TABLE `identification_provider`
  ADD CONSTRAINT `identification_provider_identification_id_foreign` FOREIGN KEY (`identification_id`) REFERENCES `identifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `identification_provider_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_discipline_id_foreign` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_internship_type_id_foreign` FOREIGN KEY (`internship_type_id`) REFERENCES `internship_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `language_provider`
--
ALTER TABLE `language_provider`
  ADD CONSTRAINT `language_provider_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `language_provider_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `privilege_role`
--
ALTER TABLE `privilege_role`
  ADD CONSTRAINT `privilege_role_privilege_id_foreign` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `privilege_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `privilege_user`
--
ALTER TABLE `privilege_user`
  ADD CONSTRAINT `privilege_user_privilege_id_foreign` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `privilege_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_ibfk_1` FOREIGN KEY (`provider_type_id`) REFERENCES `provider_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_subtypes`
--
ALTER TABLE `provider_subtypes`
  ADD CONSTRAINT `provider_subtypes_ibfk_1` FOREIGN KEY (`provider_type_id`) REFERENCES `provider_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residencies`
--
ALTER TABLE `residencies`
  ADD CONSTRAINT `residencies_degree_id_foreign` FOREIGN KEY (`degree_id`) REFERENCES `degrees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residencies_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residencies_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residencies_speciality_type_id_foreign` FOREIGN KEY (`speciality_type_id`) REFERENCES `speciality_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specialities`
--
ALTER TABLE `specialities`
  ADD CONSTRAINT `specialities_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `certifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `specialities_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `specialities_speciality_type_id_foreign` FOREIGN KEY (`speciality_type_id`) REFERENCES `speciality_types` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreignkey` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
