-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 04 Avril 2017 à 11:55
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gatuto`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`) VALUES
(1, 'carb0n', 'romain.pluciennik@gmail.com', '$2y$10$Vy3OYh958bfcqpWTgp3pyemtgeHSRZ1hJx54.MJKbxfNH1A1cC4N2', NULL, '2017-04-04 08:35:30', NULL, NULL, '77ZZUpHkCoF0l5bkJqJye3iPtzvE3iA0lTO5j4RN5sGcwuJphmedPuRok32ZABFmHIvXlxFrFXw89GEAM1bE8bCEBd0RiOyLOxLWiOkuoeTY7VWAEjmfEjfgTnTuQiQVoa93MTICI3Hx7ypIcWxkh4s1wE8w3KQJ3wbIzKMD7XGOrboYf5mEy2RxPLHIKKebO3tYCMeOD7ci3NO51xC1zP8Au959lVlFxczpdJ206e6hJU4RZoK1kGpplT'),
(2, 'Romain62', 'romain.pluciennik@viacesi.fr', '$2y$10$Vy3OYh958bfcqpWTgp3pyemtgeHSRZ1hJx54.MJKbxfNH1A1cC4N2', NULL, '2017-04-04 11:14:08', NULL, NULL, 'Mc0EnZNwML10744PVZhV3ZSUjPmAO8M14LSngiRssFGXAQTb5ZqR0NfOVMzJOrcUelwjKUaxUDPBsX1OZeHwNETJmXYuD4IsLDycEeEFE9Vg61qFQSMv0J1Pla3fnmJuGGmiCiwn7DGoOIemRJ2umGukGZgimaDC8gKKFZT9Tcs0XVZPlc4ct8Xe5EpTjonEyT9IpduGiUHK85NM65QW8YzfD2zrQIXy2zuV8wdFaW3jvSlJhsNZwPv00c');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
