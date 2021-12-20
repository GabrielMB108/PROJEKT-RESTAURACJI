-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 04:31 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restauracjapnk`
--

-- --------------------------------------------------------

--
-- Table structure for table `dania`
--

CREATE TABLE `dania` (
  `ID` int(11) NOT NULL,
  `typ` int(11) DEFAULT NULL,
  `nazwa` varchar(30) DEFAULT NULL,
  `cena` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dania`
--

INSERT INTO `dania` (`ID`, `typ`, `nazwa`, `cena`) VALUES
(1, 1, 'Pierś z kurczaka', 16),
(2, 1, 'Placki ziemniaczane', 14),
(3, 1, 'Polędwiczka wieprzowa', 21),
(4, 1, 'Filet z kaczki', 27),
(5, 2, 'Rosół', 9),
(6, 2, 'Barszcz z uszkami', 12),
(7, 2, 'Pomidorowa', 9),
(8, 3, 'Frytki', 5),
(9, 3, 'Ziemniaczki', 5),
(10, 3, 'Ryż', 5),
(11, 4, 'Szarlotka', 14),
(12, 4, 'Sernik', 12),
(13, 4, 'Puchar lodowy', 20),
(14, 4, 'Tiramisu', 25),
(15, 5, 'Woda', 3),
(16, 5, 'Sok Pomarańczowy', 4),
(17, 5, 'Cola', 5),
(18, 5, 'Herbata', 4);

-- --------------------------------------------------------

--
-- Table structure for table `klient`
--

CREATE TABLE `klient` (
  `ID` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `imie` varchar(30) DEFAULT NULL,
  `nazwisko` varchar(30) DEFAULT NULL,
  `telefon` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`ID`, `email`, `pass`, `imie`, `nazwisko`, `telefon`) VALUES
(1, 'mail@gmail.com', '123', 'Kamil', 'Nowal', 123456789),
(2, 'email@gmail.com', 'abc', 'Imie', 'Nazwisko', 321321321);

-- --------------------------------------------------------

--
-- Table structure for table `konta`
--

CREATE TABLE `konta` (
  `ID` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konta`
--

INSERT INTO `konta` (`ID`, `login`, `pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `opis` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`ID`, `opis`) VALUES
(1, 'Czeka na zatwierdzenie'),
(2, 'W realizacji'),
(3, 'Gotowe'),
(4, 'Odebrane');

-- --------------------------------------------------------

--
-- Table structure for table `zamowienia`
--

CREATE TABLE `zamowienia` (
  `ID` int(11) NOT NULL,
  `klient` varchar(61) NOT NULL,
  `ID_dania` int(11) NOT NULL,
  `telefon` int(9) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`ID`, `klient`, `ID_dania`, `telefon`, `status`) VALUES
(2, 'Kamil Nowal', 11, 123456789, 2),
(3, 'Kamil Nowal', 12, 123456789, 4),
(4, 'Kamil Nowal', 1, 123456789, 1),
(5, 'Imie Nazwisko', 3, 321321321, 2),
(8, 'Imie Nazwisko', 12, 321321321, 4),
(12, 'Imie Nazwisko', 14, 321321321, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dania`
--
ALTER TABLE `dania`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_dania` (`ID_dania`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dania`
--
ALTER TABLE `dania`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konta`
--
ALTER TABLE `konta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`ID_dania`) REFERENCES `dania` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
