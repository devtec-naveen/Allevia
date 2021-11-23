-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2020 at 11:44 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `common_questions`
--

CREATE TABLE `common_questions` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `question_type` int(2) DEFAULT NULL COMMENT '0 - text , 1 - radio, 2 - checkbox, 3 - selectbox, 4 - image as checkbox',
  `options` text COMMENT 'serialized array of options in cake of radio type question',
  `placeholder` varchar(255) DEFAULT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `step_id` varchar(100) DEFAULT NULL,
  `tab_number` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_questions`
--

INSERT INTO `common_questions` (`id`, `question`, `question_type`, `options`, `placeholder`, `hint`, `specialization_id`, `step_id`, `tab_number`) VALUES
(1, 'Do you have a family history of colon cancer in your immediate family?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '9', '9'),
(2, 'What age was your relative diagnosed with colon cancer?', 3, 'a:4:{i:0;s:0:\"\";i:1;s:9:\"<50 years\";i:2;s:11:\"50-60 years\";i:3;s:9:\">60 years\";}', '', '', 6, '9', '9'),
(3, 'When was the last time you were screened for blood in your stools?', 1, 'a:2:{i:0;s:16:\"less than a year\";i:1;s:16:\"more than a year\";}', '', '', 6, '9', '9'),
(4, 'Do you have a history of anemia or require iron?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '9', '9'),
(5, 'When was your last colonoscopy?', 1, 'a:2:{i:0;s:9:\"<10 years\";i:1;s:10:\">=10 years\";}', '', '', 6, '9', '9'),
(6, 'Have you had a previous colonoscopy?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '9', '9'),
(7, 'Do you have a history of polyps?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '9', '9'),
(13, 'Which procedure did you have done?', 1, 'a:3:{i:0;s:15:\"endoscopy (EGD)\";i:1;s:11:\"colonoscopy\";i:2;s:5:\"other\";}', '', '', 6, '11,13', '10,11'),
(14, '', 0, '', '', '', 6, '11,13', '10,11'),
(15, 'When was your procedure?', 0, '', '', '', 6, '11', '10'),
(16, 'Do you take any blood thinners?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '11', '10'),
(17, 'Did you restart your blood thinners since your procedure?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '11', '10'),
(18, 'Please tell us when you restarted your blood thinners:', 0, '', '', '', 6, '11', '10'),
(19, 'What kind of foods are you currently eating since your procedure?', 1, 'a:3:{i:0;s:12:\"regular diet\";i:1;s:15:\"soft foods only\";i:2;s:18:\"clear liquids only\";}', '', '', 6, '11', '10'),
(20, 'How are you tolerating the food above?', 1, 'a:2:{i:0;s:4:\"well\";i:1;s:8:\"not well\";}', '', '', 6, '11', '10'),
(21, 'Check all that apply:', 2, 'a:4:{i:0;s:8:\"vomiting\";i:1;s:14:\"abdominal pain\";i:2;s:17:\"dark black stools\";i:3;s:26:\"bright red blood in stools\";}', '', '', 6, '11', '10'),
(22, 'How many times have you vomited?', 3, 'a:11:{i:0;s:0:\"\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";i:7;s:1:\"7\";i:8;s:1:\"8\";i:9;s:1:\"9\";s:3:\"10+\";s:3:\"10+\";}', '', '', 6, '11', '10'),
(23, 'Was there blood or coffee ground-looking stuff in the vomit?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '11', '10'),
(24, 'Overall, how do you feel right now?', 3, 'a:4:{s:0:\"\";s:0:\"\";i:1;s:5:\"great\";i:2;s:4:\"good\";i:3;s:3:\"bad\";}', '', '', 6, '11', '10'),
(25, 'Do you have date scheduled for the procedure?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '13', '11'),
(26, 'When is your procedure scheduled for?', 0, '', '', '', 6, '13', '11'),
(27, 'Do you currently take any blood thinner medications like warfarin, heparin, Coumadin, Xarelto, or Lovenox?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '13', '12'),
(28, 'Please select any of the following you are taking:', 2, 'a:11:{i:1;s:18:\"Acova (argatroban)\";i:2;s:22:\"Angiomax (bivalirudin)\";i:3;s:22:\"Arixtra (fondaparinux)\";i:4;s:25:\"Atryn (antithrombin alfa)\";i:5;s:32:\"Ceprotin (protein C concentrate)\";i:6;s:19:\"Coumadin (warfarin)\";i:7;s:20:\"Fragmin (dalteparin)\";i:8;s:20:\"Lovenox (enoxaparin)\";i:9;s:20:\"Pradaxa (dabigatran)\";i:10;s:21:\"Xarelto (rivaroxaban)\";i:11;s:5:\"Other\";}', '', '', 6, '13', '12'),
(29, '', 0, '', '', '', 6, '13', '12'),
(30, 'Do you regularly take aspirin or baby aspirin?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '13', '12'),
(31, 'In the past week, have you taken any NSAID pain medications like ibuprofen, Advil, Motrin, Alleve?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '13', '12'),
(32, 'Are you currently taking any herbal supplements such as garlic, ginko, ginseng?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '13', '12'),
(33, 'Please select any of the following you are taking:', 2, 'a:7:{i:1;s:6:\"garlic\";i:2;s:5:\"ginko\";i:3;s:7:\"ginseng\";i:4;s:15:\"St. John\'s Wort\";i:5;s:4:\"kava\";i:6;s:8:\"valerian\";i:7;s:5:\"other\";}', '', '', 6, '13', '12'),
(34, '', 0, '', '', '', 6, '13', '12'),
(35, 'Have you had a colonoscopy in the last 10 years?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '14', '12'),
(36, 'Please specify the date of the last colonscopy:', 0, '', '', '', 6, '14', '12'),
(37, 'Have you received genetic counseling in the past?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '14', '12'),
(38, 'Please specify the date of the last genetics appointment:', 0, '', '', '', 6, '14', '12'),
(39, 'Have you done any genetic tests for colon cancer before?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '14', '12'),
(40, 'Please specify the date of the last test:', 0, '', '', '', 6, '14', '12'),
(41, 'Have you ever had a \'flexible sigmoidoscopy\" done?', 1, 'a:3:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";i:3;s:12:\"I don\'t know\";}', '', '', 6, '14', '12'),
(42, 'please specify a date:', 0, '', '', '', 6, '14', '12'),
(43, 'Are you taking any supplements like a multivitamin, iron, or B12?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '14', '12'),
(44, 'Have you noticed any side effects when taking your medications?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 6, '14', '12'),
(45, 'Overall, how do you feel your condition is since your last visit?', 1, 'a:5:{i:1;s:11:\"Much better\";i:2;s:15:\"A little better\";i:3;s:14:\"About the same\";i:4;s:14:\"A little worse\";i:5;s:10:\"Much worse\";}', '', '', 6, '14', '12'),
(46, 'which of the following are you following up with your doctor because of ?', 0, '', '', '', 0, '15', '0'),
(47, 'Which hospital was your stay at?', 0, '', '', '', 0, '15', '0'),
(48, 'When were you admitted into the hospital ?', 0, '', '', '', 0, '15', '0'),
(49, 'When were you discharged from the hospital?', 0, '', '', '', 0, '15', '0'),
(50, 'What the reason you were admitted to the hospital for?', 0, '', '', '', 0, '15', '0'),
(51, 'Were any surgeries or procedures done ?', 1, 'a:3:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";i:3;s:11:\"I dont know\";}', '', '', 0, '15', '0'),
(52, 'Which surgeries or procedures were done ?', 0, '', '', '', 0, '15', '0'),
(53, 'Which emergency room did you visit?', 0, '', '', '', 0, '15', '0'),
(54, 'When was the ER visit?', 0, '', '', '', 0, '15', '0'),
(55, 'What was the reason you went to the ER for?', 0, '', '', '', 0, '15', '0'),
(56, 'Were any lab tests done?', 1, 'a:3:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";i:3;s:11:\"I dont know\";}', '', '', 0, '15', '0'),
(57, 'Which lab tests were done ?', 0, '', '', '', 0, '15', '0'),
(58, 'Were any procedures or imaging studies done?', 1, 'a:3:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";i:3;s:11:\"I dont know\";}', '', '', 0, '15', '0'),
(59, 'Which procedures or imaging studies were done?', 0, '', '', '', 0, '15', '0'),
(60, 'In the past 30 days, how often have you had trouble with thinking clearly or had memory problems?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(61, 'In the past 30 days, how often do people complain that you are not completing necessary tasks? (ie: Doing things that need to be done, such as going to class work or appointments)', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(62, 'In the past 30 days, how often have you had to go to someone other than your prescribing physician to get sufficient pain relief from medications? (ie: another doctor, the emergency room, friends, street sources)', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(63, 'In the past 30 days, how often have you taken your medications differently from how they are prescribed?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(64, 'In the past 30 days, how often have you seriously thought about hurting yourself?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(65, 'In the past 30 days, how much of your time was spent thinking about opioid medications (having enough, taking them, dosing schedule, etc.)', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(66, 'In the past 30 days, how often have you been in an argument?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(67, 'In the past 30 days, how often have you had trouble controlling your anger (ex: road rage, screaming, etc.)', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(68, 'In the past 30 days, how often have you needed to take pain medications belonging to someone else?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(69, 'In the past 30 days, how often have you been worried about how you\'re handling your medication?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(70, 'In the past 30 days, how often have others been worried about how you\'re handling your medications?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(71, 'In the past 30 days, how often have you had to make an emergency phone call or show up at the clinic without an appointment?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(72, 'In the past 30 days, how often have you gotten angry with people?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(73, 'In the past 30 days, how often have you had to take more of your medication than prescribed?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(74, 'In the past 30 days, how often have you borrowed pain medication from someone else?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(75, 'In the past 30 days, how often have you used your pain medicine for symptoms other than for pain (ex: to help you sleep, improve your mood or relieve stress)', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(76, 'In the past 30 days, how often have you had to visit the emergency room (ER)?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'comm'),
(77, 'In the past 12 months, have you used drugs other than those required for medical reasons?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(78, 'In the past 12 months, do you abuse more than one drug at a time?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(79, 'In the past 12 months, are you unable to stop abusing drugs when you want to?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(80, 'In the past 12 months, have you ever had blackouts or flashbacks as a result of drug use?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(81, 'In the past 12 months, do you ever feel bad or guilty about your drug use?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(82, 'In the past 12 months, does your spouse or family members ever complain about your involvement with drugs?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(83, 'In the past 12 months, have you neglected your family because of your use of drugs?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(84, 'In the past 12 months, have you engaged in illegal activities in order to obtain drugs?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(85, 'In the past 12 months, have you ever experienced withdrawal symptoms (felt sick) when you stopped taking drugs?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(86, 'In the past 12 months, have you had medical problems as a result of your drug use (ex: memory loss, hepatitis, convulsions, bleeding)?', 1, 'a:2:{i:0;s:2:\"No\";i:1;s:3:\"Yes\";}', '', '', 0, '4', 'dast'),
(87, 'How often do you have mood swings?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(88, 'How often have you felt a need for higher dose of medication to treat your pain?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(89, 'How often have you felt impatient with your doctors?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(90, 'How often have you felt that things are just too overwhelming that you can\'t handle them?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(91, 'How often is there tension in the home?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(92, 'How often have you counted pain pills to see how many are remaining?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(93, 'How often have you been concerned that people will judge you for taking pain medication?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(94, 'How often do you feel bored?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(95, 'How often have you taken more pain medication than you were supposed to?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(96, 'How often have you worried about being left alone?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(97, 'How often have you felt a craving for medication?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(98, 'How often have others expressed concern over your use of medication?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(99, 'How often have any of your close friends had a problem with alcohol or drugs?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(100, 'How often have others told you had a bad temper?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(101, 'How often have you felt consumed by the need to get pain medication?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(102, 'How often have you run out of pain medication early?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(103, 'How often have others kept you from getting what you deserve?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(104, 'How often, in your lifetime, have you had legal problems or been arrested?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(105, 'How often have you attended an AA or NA meeting?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(106, 'How often have you been in an argument that was so out of control that someone got hurt?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(107, 'How often have you been sexually abused?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(108, 'How often have others suggested that you have a drug or alcohol problem?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(109, 'How often have you had to borrow pain medication from your family or friends?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(110, 'How often have you been treated for an alcohol or drug problem?', 1, 'a:5:{i:0;s:5:\"Never\";i:1;s:6:\"Seldom\";i:2;s:9:\"Sometimes\";i:3;s:5:\"Often\";i:4;s:10:\"Very often\";}', '', '', 0, '4', 'soapp'),
(111, 'nausea', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(112, 'vomiting', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(113, 'constipation', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(114, 'itching', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(115, 'mental cloudiness', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(116, 'sweating', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(117, 'fatigue', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(118, 'drowsiness', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(119, 'other', 1, 'a:4:{i:1;s:6:\"Severe\";i:2;s:8:\"Moderate\";i:3;s:4:\"Mild\";i:4;s:4:\"None\";}', '', '', 0, '4', 'padt'),
(120, 'Average pain level during the past week:', 3, 'a:12:{s:0:\"\";s:0:\"\";i:0;i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;i:7;i:8;i:8;i:9;i:9;i:10;i:10;}', '', '', 0, '4', 'padt'),
(121, 'Pain level at its worst during the past week:', 3, 'a:12:{s:0:\"\";s:0:\"\";i:0;i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;i:7;i:8;i:8;i:9;i:9;i:10;i:10;}', '', '', 0, '4', 'padt'),
(122, 'About what percent of your pain has been relieved during the past week?', 3, 'a:12:{s:0:\"\";s:0:\"\";i:0;s:2:\"0%\";i:10;s:3:\"10%\";i:20;s:3:\"20%\";i:30;s:3:\"30%\";i:40;s:3:\"40%\";i:50;s:3:\"50%\";i:60;s:3:\"60%\";i:70;s:3:\"70%\";i:80;s:3:\"80%\";i:90;s:3:\"90%\";i:100;s:4:\"100%\";}', '', '', 0, '4', 'padt'),
(123, 'Is the amount of pain relief you are now getting from your current pain reliever(s) enough to make a real difference in your life?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 0, '4', 'padt'),
(124, 'Is your physical functioning better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(125, 'Are your family relationships better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(126, 'Are your social relationships better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(127, 'Is your mood better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(128, 'Are your sleep pattern better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(129, 'Is your overall functioning better, worse, or about the same?', 1, 'a:3:{i:1;s:6:\"Better\";i:2;s:5:\"Worse\";i:3;s:4:\"Same\";}', '', '', 0, '4', 'padt'),
(130, 'Overall, How would you describe the *** to the last time you were here?', 1, 'a:4:{i:1;s:15:\"Completely gone\";i:2;s:6:\"Better\";i:3;s:14:\"About the same\";i:4;s:5:\"Worse\";}', '', '', 0, '16', '17'),
(131, 'Do you still feel the *** in your **oldloc?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 0, '16', '17'),
(132, 'Do you feel the *** in any new location?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 0, '16', '17'),
(133, 'Where?', 0, '', '', '', 0, '16', '17'),
(134, 'Last visit you said your pain was a **bestpain at its best. Today, how would you rate your pain at its best?', 3, 'a:12:{s:0:\"\";s:26:\"Least level of pain daily?\";i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";i:7;s:1:\"7\";i:8;s:1:\"8\";i:9;s:1:\"9\";i:10;s:2:\"10\";}', '', '', 0, '16', '17'),
(135, 'Last visit you said your pain was a **worstpain at its worst. Today, how would you rate your pain at its worst?', 3, 'a:12:{s:0:\"\";s:26:\"Worst level of pain daily?\";i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";i:7;s:1:\"7\";i:8;s:1:\"8\";i:9;s:1:\"9\";i:10;s:2:\"10\";}', '', '', 0, '16', '17'),
(136, 'Do your symptoms still occur most **oldtemp?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 0, '16', '17'),
(137, 'When do the symptoms occur now?', 1, 'a:4:{i:1;s:7:\"Morning\";i:2;s:9:\"Afternoon\";i:3;s:5:\"Night\";i:4;s:12:\"Same all day\";}', '', '', 0, '16', '17'),
(138, 'Have you noticed any new symptoms since your last visit?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 0, '16', '17'),
(139, 'Which symptoms?', 0, '', '', '', 0, '16', '17'),
(140, 'What kind of medications or treatments were you prescribed by your doctor for the ***?', 2, 'a:4:{i:1;s:27:\"Over-the-counter medication\";i:2;s:21:\"Prescribed medication\";i:3;s:16:\"Physical therapy\";i:4;s:10:\"Injections\";}', '', '', 0, '16', '17'),
(141, 'Have you traveled from China, Iran, Italy, Japan, or South Korea within 14 days of symptoms starting?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(142, 'Have you had close contact with a laboratory-confirmed COVID-19 patient within 14 days of symptoms starting?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(143, 'Have you personally traveled to or from washington state, massachusetts, or new york in the last 14 days?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(144, 'Check all of the states you\'ve traveled to:', 2, 'a:3:{i:1;s:10:\"Washington\";i:2;s:13:\"Massachusetts\";i:3;s:8:\"New york\";}', '', '', 1, '0', '18'),
(145, 'Did you visit any nursing facilities in kirkland, WA or standwood, WA?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(146, 'Did you attend the biogen business conference in boston?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(147, 'Did you visit new rochelle, NY?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(148, 'Have you been in close contact with others who traveled to or from washington state, massachusetts, or new york in the last 14 days?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(149, 'Check all of the states which they traveled to:', 2, 'a:3:{i:1;s:10:\"Washington\";i:2;s:13:\"Massachusetts\";i:3;s:8:\"New york\";}', '', '', 1, '0', '18'),
(150, 'Did you they visit any nursing facilities in kirkland, WA or standwood, WA?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(151, 'Did you they attend the biogen business conference in boston?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(152, 'Did you they visit new rochelle, NY?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(153, 'Have you personally been on a grand princess or diamond princess cruise in the last 2 months?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(154, 'Have you ever been in close contact with anyone who was on a grand princess or diamond princess cruise in the last 2 months?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(155, 'Do you currently smoke or have smoked in the past week?', 1, 'a:2:{i:1;s:3:\"Yes\";i:2;s:2:\"No\";}', '', '', 1, '0', '18'),
(156, 'Please select any of the conditions you\'ve been diagnosed with:', 2, 'a:4:{i:1;s:44:\"Chronic obstructive pulmonary disease (COPD)\";i:2;s:39:\"Heart disease (coronary artery disease)\";i:3;s:8:\"Diabetes\";i:4;s:34:\"High blood pressure (Hypertension)\";}', '', '', 1, '0', '18'),
(157, 'Little interest or pleasure in doing things?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(158, 'Feeling down, depressed or hopeless?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(159, 'Trouble falling or staying asleep, or sleeping too much?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(160, 'Feeling tired or having little energy?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(161, 'Poor appetite or overeating?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(162, 'Feeling bad about yourself - or that you are a failure or have let yourself or your family down?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(163, 'Trouble concentrating on things, such as reading the newspaper or watching television?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(164, 'Moving or speaking so slowly that other people could have noticed? Or so fidgety or restless that you have been moving a lot more than usual?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9'),
(165, 'Thoughts that you would be better off dead, or thoughts of hurting yourself in some way?', 1, 'a:4:{i:0;s:10:\"Not at all\";i:1;s:12:\"Several days\";i:2;s:23:\"More than half the days\";i:3;s:16:\"Nearly every day\";}', '', '', 1, '0', 'phq-9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `common_questions`
--
ALTER TABLE `common_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `common_questions`
--
ALTER TABLE `common_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
