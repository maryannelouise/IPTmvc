-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 12:21 AM
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
-- Database: `careset`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointments_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `birthdate` date NOT NULL,
  `appointment_date` date NOT NULL,
  `medical_records` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`medical_records`)),
  `diseases` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointments_id`, `doctor_id`, `firstname`, `lastname`, `gender`, `birthdate`, `appointment_date`, `medical_records`, `diseases`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mary', 'Mabutas', 'female', '2004-02-20', '2025-04-10', '[{\"path\":\"\\/uploads\\/medical_records\\/medrec_67f2fe181fdf8.jpg\",\"description\":\"Medical Record 2024\"}]', 'Cough', '2025-04-06 22:20:08', '2025-04-06 22:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty_id`, `description`, `image`) VALUES
(1, 'Dr. John Doe', 1, 'Cardiologist with over 10 years of experience in treating heart conditions.', 'john_doe.png'),
(2, 'Dr. Jane Smith', 2, 'Expert in diagnosing and treating skin disorders and diseases.', 'jane_smith.png'),
(3, 'Dr. Alice Brown', 3, 'Neurologist specializing in brain and nervous system disorders.', 'alice_brown.png'),
(4, 'Dr. Michael Johnson', 4, 'Orthopedic surgeon specializing in joint replacement and bone fractures.', 'michael_johnson.png'),
(5, 'Dr. Linda White', 5, 'Pediatrician focused on children\'s health from infancy to adolescence.', 'linda_white.png'),
(6, 'Dr. Sarah Green', 6, 'Gynecologist offering specialized care in women\'s reproductive health.', 'sarah_green.png'),
(7, 'Dr. Robert Lee', 7, 'Psychiatrist with expertise in mental health disorders and therapies.', 'robert_lee.png'),
(8, 'Dr. Karen Harris', 8, 'Ophthalmologist with experience in treating eye diseases and performing surgeries.', 'karen_harris.png'),
(9, 'Dr. James Clark', 9, 'Dentist offering comprehensive oral care, including preventive and cosmetic treatments.', 'james_clark.png'),
(10, 'Dr. Emma Walker', 10, 'General surgeon skilled in performing surgeries for a wide range of medical conditions.', 'emma_walker.png');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `available_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `doctor_id`, `available_time`) VALUES
(1, 1, '09:00:00'),
(2, 2, '08:00:00'),
(3, 3, '10:00:00'),
(4, 4, '14:00:00'),
(5, 5, '09:30:00'),
(6, 6, '11:00:00'),
(7, 7, '15:00:00'),
(8, 8, '13:00:00'),
(9, 9, '08:30:00'),
(10, 10, '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specialties`
--

CREATE TABLE `doctor_specialties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_specialties`
--

INSERT INTO `doctor_specialties` (`id`, `name`) VALUES
(1, 'Cardiology'),
(2, 'Dermatology'),
(3, 'Neurology'),
(4, 'Orthopedics'),
(5, 'Pediatrics'),
(6, 'Gynecology'),
(7, 'Psychiatry'),
(8, 'Ophthalmology'),
(9, 'Dentistry'),
(10, 'General Surgery');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Mary Mabutas', 'marymabutas@gmail.com', '$2y$10$2FNwA3B3dXi2t7iFBeZWdeN58zG9hq8RuLQMHiccORFFQY8pdCSZC', '2025-04-06 22:18:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointments_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialty_id` (`specialty_id`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_specialties`
--
ALTER TABLE `doctor_specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor_specialties`
--
ALTER TABLE `doctor_specialties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`specialty_id`) REFERENCES `doctor_specialties` (`id`);

--
-- Constraints for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD CONSTRAINT `doctor_availability_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
