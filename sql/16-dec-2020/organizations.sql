-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2020 at 07:24 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `allevia`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `access_code` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `clinic_logo` varchar(255) NOT NULL,
  `clinic_data_dump` varchar(255) NOT NULL,
  `specialization_ids` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `api_secret` varchar(255) NOT NULL,
  `api_system_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `heading_color` varchar(22) DEFAULT NULL,
  `background_color` varchar(22) DEFAULT NULL,
  `dashboard_background_color` varchar(22) DEFAULT NULL,
  `text_color` varchar(22) DEFAULT NULL,
  `button_gradient_color1` varchar(22) DEFAULT NULL,
  `button_gradient_color2` varchar(22) DEFAULT NULL,
  `button_gradient_color3` varchar(22) DEFAULT NULL,
  `active_button_color` varchar(20) DEFAULT NULL,
  `hover_state_color` varchar(20) DEFAULT NULL,
  `active_state_color` varchar(20) DEFAULT NULL,
  `link_color` varchar(20) DEFAULT NULL,
  `link_hover_color` varchar(20) DEFAULT NULL,
  `appoint_box_bg_color` varchar(20) DEFAULT NULL,
  `is_shown` tinyint(4) NOT NULL DEFAULT '1',
  `make_test_clinic` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - for not test clinic, 1 - for test clinic',
  `standard_openemr_output` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - for standard json outpur , 1 - openemr output format (separated by \\n)',
  `destination_url_for_json` tinytext NOT NULL,
  `org_url` varchar(500) DEFAULT NULL,
  `treatment_consent_docs` varchar(200) DEFAULT NULL,
  `privacy_policy_docs` varchar(200) DEFAULT NULL,
  `is_show_ancillary_docs` int(11) NOT NULL DEFAULT '0',
  `cl_group_id` text,
  `client_id` text COMMENT 'api client id',
  `client_secret` text COMMENT 'api client secret',
  `show_credential` int(11) NOT NULL DEFAULT '0' COMMENT '0=> show api credentail, 1 => hide api credential',
  `is_show_secret_key` int(11) NOT NULL DEFAULT '0',
  `is_request_accept` int(11) NOT NULL DEFAULT '0',
  `is_generate_new_key` tinyint(4) NOT NULL DEFAULT '0',
  `progress_bar_graphic` varchar(255) DEFAULT 'step_number_active',
  `appoint_box_text_color` varchar(255) DEFAULT NULL,
  `clinic_logo_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 => don''t show, 2=> replace, 3 => put next',
  `appoint_box_button_color` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `user_id`, `organization_name`, `access_code`, `location`, `clinic_logo`, `clinic_data_dump`, `specialization_ids`, `api_key`, `api_secret`, `api_system_id`, `status`, `heading_color`, `background_color`, `dashboard_background_color`, `text_color`, `button_gradient_color1`, `button_gradient_color2`, `button_gradient_color3`, `active_button_color`, `hover_state_color`, `active_state_color`, `link_color`, `link_hover_color`, `appoint_box_bg_color`, `is_shown`, `make_test_clinic`, `standard_openemr_output`, `destination_url_for_json`, `org_url`, `treatment_consent_docs`, `privacy_policy_docs`, `is_show_ancillary_docs`, `cl_group_id`, `client_id`, `client_secret`, `show_credential`, `is_show_secret_key`, `is_request_accept`, `is_generate_new_key`, `progress_bar_graphic`, `appoint_box_text_color`, `clinic_logo_status`, `appoint_box_button_color`, `created`, `modified`) VALUES
(1, 0, 'sdfsfss', '123456', 'sefsdffs', '1541225879_1539003665_how1.png', '1548827602_file.csv', '1,2,3', 'test', 'teszxt', 'test', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'sdfsfss', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-08-18 09:45:06', '2019-12-27 06:15:48'),
(2, 0, 'test organization 1', 'asdfwe23', 'test address 1', '1540804776_1539004192_trophy.svg', '', '1,2,3', 'abc key', 'abc secret', 'abc systemid', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'test-organization-1', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-08-18 09:45:06', '2019-12-27 06:15:49'),
(3, 0, 'test organization 2', 'asdfzx34', 'test address 2', '1541225870_1539003947_like.svg', '', '1,2,3', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'test-organization-2', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-08-18 09:45:06', '2019-12-27 06:15:49'),
(4, 0, 'test organization 3', 'asdfdf32', '', '1541225864_1539004050_alarm-clock.svg', '', '1,2,3', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'http://localhost/allevia/admin/organizations/edit/4', 'test-organization-3', NULL, NULL, 0, '', '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-08-18 09:45:06', '2020-09-21 04:08:13'),
(5, 0, 'test organization 4', 'asdfvfre34', 'test address 4', '1541225855_1539003665_how3.png', '', '1,2,3', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'test-organization-4', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-08-18 09:45:06', '2019-12-27 06:15:49'),
(6, 0, 'tester test', '123456', 'jaipur', '1541225848_1539003665_how2.png', '', '1,2,3', 'test', 'test', 'test', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'tester-test', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-10-25 05:50:13', '2019-12-27 06:15:49'),
(7, 0, 'myclinic', 'myclinic', 'myloc', '1540803347_1539003665_how1.png', '', '1,2,3', 'test', 'test', 'test', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'myclinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-10-29 08:55:47', '2019-12-27 06:15:49'),
(8, 0, 'mytestclinic', 'mytestclinic', 'malviaya nagar', '1541224842_1539004131_money-bag.svg', '1548827602_file.csv', '1,2,3', 'test api key', 'test api secret', 'test system id', 1, '', '', NULL, '', '', '', '', '', '', '', '', '', '', 1, 0, 0, '', 'mytestclinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-11-03 06:00:42', '2019-12-27 06:15:49'),
(9, 0, 'mytestclinicabc', 'mytestclinicabc', 'malviya nagar', '', '1543576994_dummy_data_dump (1).csv', '2,3', 'test mytestclinicabc key', 'test mytestclinicabc secret', 'test mytestclinicabc system', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'mytestclinicabc', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-11-29 10:16:54', '2019-12-27 06:15:49'),
(10, 0, 'abctestclinic', 'abctestclinic', 'asdf', '1545215881_dummy-454x280-Elephant.jpg', '', '1,2,3', 'asd', 'asdf', 'asdf', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', 'abctestclinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-12-19 10:38:01', '2019-12-27 06:15:49'),
(11, 0, 'abctestclinic1', 'abctestclinic', 'qwe', '', '', '1,2', 'qwe', 'qwe', 'qwe', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '', 'abctestclinic1', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-12-19 10:39:22', '2019-12-27 06:15:49'),
(12, 0, 'mtestclinic', 'mtestclinic', 'malviaya nagar', '1545302161_download.jpeg', '1553248391_file.csv', '1,2,3,4,5,6', 'qwer', 'qwer', 'qwer', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1, 0, 'http://localhost/allevia/', 'mtestclinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2018-12-20 10:36:01', '2019-12-27 06:15:49'),
(13, 0, 'testclinic5', 'testcode', 'test loc', '', '', '2,3,4', 'test api key', 'test secret', 'test system id', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 'http://localhost/allevia/', 'testclinic5', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2019-02-11 06:07:59', '2019-12-27 06:15:49'),
(14, 0, 'city hospital', '123456', '', '', '', '1,2,3,4,5,6,7,8', '123456', '123456', '123456', 1, 'FF6417', '40FF19', '322BFF', 'FF3DF2', '9EF5FF', 'B9FF9C', 'F9FF4D', '2E2E2E', 'E18FFF', 'FF696E', '19FFA3', 'C8FF14', 'FFCB21', 1, 1, 0, 'http://192.168.1.89/allevia', 'city-hospital1', '1579519165_5e258cbdd60a6.pdf', '', 1, 'Um1GbU5USTJURGhpYXpOT1JVVk5NQzlEYUU1U05VRnJSM1E0YkZFNFkyTXhaelF4VGtNek4ycFBRMjVPWW1seVIwMDJSRTR4WW1WUk1FTTJVRWRXVW1SQ1p6QklLMFpoZEVSNU4yRjBaVTlKY0haSVJVRTlQVG82', 'Vmt0WGIwWnJhRnBNV25aQmIzQjJlbXM1V1ZWUVdESXlWRE5sZGpWWU1FbEtSRWd3U0RsWlNGSmxXaloxYkhwS1UyNVVkR2xFUTNoaVIzTk1jREJOV1VWcFpXZG5OVFJtYUVzeWVXUXhSellyZERoMGNXNVJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 'VFRWaFZHbHVPRXhIS3pGdk5tcGthMUZGWWpOaFQzbDNSazh4UlZSNVJWZFFNRlpUVGpOMFNGRTFRbE5IU2pSWVJsbDZZMUIxVTBSbldVOXpNMmhVU0VKTllreDBTRTlvTkM4eVRDOXpha1phUjNCTE1saFJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 1, 0, 0, 0, 'step_number_active', NULL, 1, NULL, '2019-07-19 06:23:51', '2020-12-11 04:16:16'),
(15, 0, 'Gi hospital', '123456', 'jaipur', '1564377075_172287_rev-570.png', '', '6', '123456', '123456', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, 'http://192.168.1.89/allevia', 'gi-hospital', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2019-07-29 05:11:15', '2019-12-27 06:15:50'),
(16, 0, 'Pain medicine clinic', '123456', 'jaipur', '', '', '7', '123456', '123456', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 'http://192.168.1.89/allevia', 'pain-medicine-clinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2019-08-02 06:05:04', '2019-12-27 06:15:50'),
(17, 0, 'my test clinic', '123456', 'jaipur', '', '', '2', '123456', '123456', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'my-test-clinic', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2019-12-31 03:38:03', '2019-12-31 03:39:11'),
(18, 0, 'test', '123456', '123456', '1582020967_1576137610-5df1f38a0fd3c.jpg', '', '1', '123456', '12346', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'my-test-clinic1', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2020-01-01 22:44:45', '2020-02-18 04:16:07'),
(19, 0, 'Adarsh Clinic ', '101', 'Jhalana Doongari', '1582180854_clinic.jpg', '', '1', '123', '123', '100', 1, 'D2CFFF', 'CEFFCD', 'FFFEFD', 'FFE1E9', 'FBFFF0', '3A24FF', '8AFFB9', 'FF8255', 'B061FF', 'FFEA2C', '2E2EFF', 'FF3455', 'EFEFEF', 1, 1, 0, 'https://www.practo.com/jaipur/clinic/adarsh-clinic-adarsh-nagar', 'adarsh-clinic-star', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2020-02-20 00:37:56', '2020-02-20 00:46:02'),
(20, 0, 'Test Adarsh Clinic', '121', 'jaipur', '1584437307_test-tv-screen-vector-918544.jpg', '1584437307_images.jpeg', '1,2,3,4,5,6,7', '2345', '56', '23', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'dfgkhkj', 'adarsh', NULL, NULL, 0, NULL, '', '', 0, 0, 0, 0, NULL, NULL, 1, NULL, '2020-03-17 04:28:28', '2020-03-17 04:28:28'),
(21, 0, 'test civil clinic', '123456', 'jaipur', '', '', '4', '123456', '123456', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'civil', NULL, NULL, 0, '', '', '', 1, 0, 0, 0, NULL, NULL, 1, NULL, '2020-04-23 02:36:45', '2020-04-24 05:38:53'),
(22, 0, 'test civil2', '123456', 'jaipur', '', '', '2', '12345678', '13456', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'civil2', NULL, NULL, 0, 'U2twQ2RuTjFTMVpEVVhkUWRscDViRWhZZDFWVGJFZHRjMFE1Y25sTFlVZHhVMUJ4Y1hoR1JuVlFSbU01WW1KV1kzRkZZMlZTUkZkWlJtSklVRXgzVEdSQ1p6QklLMFpoZEVSNU4yRjBaVTlKY0haSVJVRTlQVG82', 'V25veVYzaHlMMjlsWVdSUmFHVmxiMjVJTURGNlVWUkxRbXcyVTFZME1uYzJaSGhvZVVwR2JrSldWWEJWYzBkamVWUklTbTlzVW1aNk9WZERhM1JsYVRNMmNsSjFNekZGVlhvM1RtdzNUekJRVkVkYVRUTlJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 'TlRoUVEyRk9jblo1U0dzeVFVbzNkV0Y1YmtOU1FWbExRMk0yTkhSNFNXSjRUbms1VEhaalYzZHRhSFYxYzB0VmNHNWpWVXRGUzNndmVITXhWSE42Uld4a0wxTkNjMFl3V1RRM2NtbE5ObFpCVlRWR1pFaFJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 1, 0, 0, 0, NULL, NULL, 1, NULL, '2020-04-23 05:31:52', '2020-07-24 09:42:51'),
(23, 309, 'testorg', '123456', '', '', '', '1,2,3,4,5,6,7', '123456', '123456', '123456', 1, '6038FF', '3B3B3B', 'FFCCDB', 'FF969D', 'FF7083', '919191', 'DACCFF', 'FFF2E3', 'CDFFC9', 'D8D6FF', 'DBA6FF', 'C2B3FF', 'A6FFB8', 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'testorg', NULL, NULL, 0, '', 'Y3pSUVREQnJOSE5rV1dScVNXc3hTVmxXV1RGSlkwODViRnBXU21wRFNEVk1RVTVvWmpSWFExZEJSR2RUZGpoU1JGaENTMGhTYUhkblpHVlVhalZEU1hCWGRrRldVemRQUlVkMFlXbHBjWGRHTW5sQk5XNVJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 'V1ZoTll5dENhWGRaWm1GYU1HZ3hSVzVFWW5ONmRIUTVSVmxaTlRKcGRFWkRka0UwVFd4UWNVUXhRMng1Wm5WS1VWRm5SbmhQZFN0S1lWRnlLMHBpV1RST2VHdzVZelZ2VGpoTmNEbE5WMHAxWVVWU1VHNVJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 0, 0, 2, 1, 'dark_green', NULL, 1, NULL, '2020-09-14 07:01:17', '2020-12-11 04:18:31'),
(26, 307, 'demoOrg', '123456', 'jaipur', '', '', '1,2', '123456', '123456', '123456', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, 'http://localhost/allevia/admin/organizations/add', 'demoorg1', NULL, NULL, 0, '', 'YmtSMmJVazFkMFpOUzBGRk0wMVZOR0ptV1VGMGRrTjRiWFUxVW1wamRVeDRXakZKZWt4eFZXMXJSM0I2WkdGRmFDOUZiWFZMSzJ4TU0yVmxiMmhoWTJWVE5uRjROazFSUWl0SU5FYzViRXd3TURCR2EwaFJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 'ZWs1UE5HeE1VVFp2UlZaWFltNW1lRU50VTNaa1JteERMMjg0WW5GWGVVbERjRlJJYTBKcWJWVjRjR0kzVldkbE4zSkRVbkoyWkdGbFYwaHpLMWRTYjFodWRHY3pUa05FVERGWGVVWlZUVzFJU1d3Mk1saFJXVTVDTDJoWGNsRTRkVEp5V0dwcFMySjRlRUU5T2pvPQ==', 0, 0, 0, 0, 'dark_green', NULL, 1, NULL, '2020-09-23 01:29:48', '2020-12-11 04:09:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
