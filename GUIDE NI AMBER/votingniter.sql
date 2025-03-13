-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 06:28 PM
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
-- Database: `votingniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `username`, `password`, `last_login`) VALUES
(1, 'Pyanz Jheo Quiros1', 'pjquiros', '8cc5ac7b84f8dd6476f85691d7c24137', '2025-03-13 23:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id_candidate` int(11) NOT NULL,
  `candidate_name` varchar(50) NOT NULL DEFAULT '0',
  `description` text DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id_candidate`, `candidate_name`, `description`, `photo`) VALUES
(1, 'Pyanz Jheo Quiros', 'Pahuway nakaha ta ster', 'default.jpg'),
(3, 'Amber Velasco', 'Pahuway nakaha ta ster', 'Edited_default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_participation`
--

CREATE TABLE `candidate_participation` (
  `id_candidate_participation` int(11) NOT NULL,
  `id_voting` int(11) DEFAULT NULL,
  `id_candidate` int(11) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidate_participation`
--

INSERT INTO `candidate_participation` (`id_candidate_participation`, `id_voting`, `id_candidate`, `points`) VALUES
(3, 2, 1, 0),
(4, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id_voter` int(11) NOT NULL,
  `name` varchar(50) DEFAULT '0',
  `username` varchar(15) DEFAULT '0',
  `password` varchar(32) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id_voter`, `name`, `username`, `password`) VALUES
(3, 'Pyanz Jheo Quiros', 'liam', '534173c048199e1e8bd23671ea3bf4fb');

-- --------------------------------------------------------

--
-- Table structure for table `voter_participation`
--

CREATE TABLE `voter_participation` (
  `id_participation` int(11) NOT NULL,
  `id_voting` int(11) DEFAULT NULL,
  `id_voter` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voter_participation`
--

INSERT INTO `voter_participation` (`id_participation`, `id_voting`, `id_voter`, `timestamp`) VALUES
(2, 2, 3, '2025-03-14 00:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `voting`
--

CREATE TABLE `voting` (
  `id_voting` int(11) NOT NULL,
  `voting_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voting`
--

INSERT INTO `voting` (`id_voting`, `voting_name`) VALUES
(2, 'Voting para barangay sk');

--
-- Triggers `voting`
--
DELIMITER $$
CREATE TRIGGER `delete_voting` BEFORE DELETE ON `voting` FOR EACH ROW BEGIN
	DELETE FROM candidate_participation WHERE candidate_participation.id_voting=OLD.id_voting;
	DELETE FROM voter_participation WHERE voter_participation.id_voting=OLD.id_voting;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id_candidate`);

--
-- Indexes for table `candidate_participation`
--
ALTER TABLE `candidate_participation`
  ADD PRIMARY KEY (`id_candidate_participation`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id_voter`);

--
-- Indexes for table `voter_participation`
--
ALTER TABLE `voter_participation`
  ADD PRIMARY KEY (`id_participation`);

--
-- Indexes for table `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id_voting`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id_candidate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `candidate_participation`
--
ALTER TABLE `candidate_participation`
  MODIFY `id_candidate_participation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id_voter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `voter_participation`
--
ALTER TABLE `voter_participation`
  MODIFY `id_participation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `voting`
--
ALTER TABLE `voting`
  MODIFY `id_voting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
