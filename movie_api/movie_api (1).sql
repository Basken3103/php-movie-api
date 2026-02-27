-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Vært: localhost:3306
-- Genereringstid: 27. 02 2026 kl. 13:24:54
-- Serverversion: 5.7.24
-- PHP-version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_api`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `genres`
--

CREATE TABLE `genres` (
  `genreid` int(10) UNSIGNED NOT NULL,
  `genrename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `movieactor`
--

CREATE TABLE `movieactor` (
  `movieid` int(10) UNSIGNED NOT NULL,
  `actorid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `moviedirector`
--

CREATE TABLE `moviedirector` (
  `movieid` int(10) UNSIGNED NOT NULL,
  `directorid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `moviegenres`
--

CREATE TABLE `moviegenres` (
  `movieid` int(10) UNSIGNED NOT NULL,
  `genreid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `movies`
--

CREATE TABLE `movies` (
  `Movieid` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `movielength` smallint(5) UNSIGNED NOT NULL,
  `release_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `people`
--

CREATE TABLE `people` (
  `actor_id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birth` date NOT NULL,
  `nationality` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genreid`);

--
-- Indeks for tabel `movieactor`
--
ALTER TABLE `movieactor`
  ADD PRIMARY KEY (`movieid`),
  ADD KEY `actorid` (`actorid`);

--
-- Indeks for tabel `moviedirector`
--
ALTER TABLE `moviedirector`
  ADD PRIMARY KEY (`movieid`),
  ADD KEY `directorid` (`directorid`);

--
-- Indeks for tabel `moviegenres`
--
ALTER TABLE `moviegenres`
  ADD PRIMARY KEY (`movieid`),
  ADD KEY `genreid` (`genreid`);

--
-- Indeks for tabel `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`Movieid`);

--
-- Indeks for tabel `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`actor_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `genres`
--
ALTER TABLE `genres`
  MODIFY `genreid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `movieactor`
--
ALTER TABLE `movieactor`
  MODIFY `movieid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `moviedirector`
--
ALTER TABLE `moviedirector`
  MODIFY `movieid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `moviegenres`
--
ALTER TABLE `moviegenres`
  MODIFY `movieid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `Movieid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `people`
--
ALTER TABLE `people`
  MODIFY `actor_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `movieactor`
--
ALTER TABLE `movieactor`
  ADD CONSTRAINT `movieactor_ibfk_1` FOREIGN KEY (`actorid`) REFERENCES `movies` (`Movieid`);

--
-- Begrænsninger for tabel `moviedirector`
--
ALTER TABLE `moviedirector`
  ADD CONSTRAINT `moviedirector_ibfk_1` FOREIGN KEY (`movieid`) REFERENCES `movies` (`Movieid`),
  ADD CONSTRAINT `moviedirector_ibfk_2` FOREIGN KEY (`directorid`) REFERENCES `people` (`actor_id`);

--
-- Begrænsninger for tabel `moviegenres`
--
ALTER TABLE `moviegenres`
  ADD CONSTRAINT `moviegenres_ibfk_1` FOREIGN KEY (`genreid`) REFERENCES `genres` (`genreid`);

--
-- Begrænsninger for tabel `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`Movieid`) REFERENCES `moviegenres` (`movieid`);

--
-- Begrænsninger for tabel `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_ibfk_1` FOREIGN KEY (`actor_id`) REFERENCES `movieactor` (`movieid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
