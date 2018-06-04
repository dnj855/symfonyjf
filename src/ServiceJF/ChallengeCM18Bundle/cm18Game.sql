-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 11 mai 2018 à 15:57
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `symfonyjf`
--

--
-- Déchargement des données de la table `cm18Game`
--

INSERT INTO `cm18Game` (`id`, `team_home_id`, `team_away_id`, `game_phase_id`, `pool_id`, `fifaNumber`, `scoreHome`, `scoreAway`, `result`, `winner`, `date`) VALUES
  (1, 1, 2, 1, 1, 1, NULL, NULL, NULL, NULL, '2018-06-14 17:00:00'),
  (2, 3, 4, 1, 1, 2, NULL, NULL, NULL, NULL, '2018-06-15 14:00:00'),
  (3, 5, 6, 1, 2, 3, NULL, NULL, NULL, NULL, '2018-06-15 20:00:00'),
  (4, 7, 8, 1, 2, 4, NULL, NULL, NULL, NULL, '2018-06-15 17:00:00'),
  (5, 9, 10, 1, 3, 5, NULL, NULL, NULL, NULL, '2018-06-16 12:00:00'),
  (6, 13, 14, 1, 4, 7, NULL, NULL, NULL, NULL, '2018-06-16 15:00:00'),
  (7, 11, 12, 1, 3, 6, NULL, NULL, NULL, NULL, '2018-06-16 18:00:00'),
  (8, 15, 16, 1, 4, 8, NULL, NULL, NULL, NULL, '2018-06-16 21:00:00'),
  (15, 17, 18, 1, 5, 9, NULL, NULL, NULL, NULL, '2018-06-17 20:00:00'),
  (16, 19, 20, 1, 5, 10, NULL, NULL, NULL, NULL, '2018-06-17 14:00:00'),
  (17, 21, 22, 1, 6, 11, NULL, NULL, NULL, NULL, '2018-06-17 17:00:00'),
  (18, 23, 24, 1, 6, 12, NULL, NULL, NULL, NULL, '2018-06-18 14:00:00'),
  (19, 25, 26, 1, 7, 13, NULL, NULL, NULL, NULL, '2018-06-18 17:00:00'),
  (20, 27, 28, 1, 7, 14, NULL, NULL, NULL, NULL, '2018-06-18 20:00:00'),
  (21, 29, 30, 1, 8, 15, NULL, NULL, NULL, NULL, '2018-06-19 17:00:00'),
  (22, 31, 32, 1, 8, 16, NULL, NULL, NULL, NULL, '2018-06-19 14:00:00'),
  (23, 1, 3, 2, 1, 17, NULL, NULL, NULL, NULL, '2018-06-19 20:00:00'),
  (24, 4, 2, 2, 1, 18, NULL, NULL, NULL, NULL, '2018-06-20 17:00:00'),
  (25, 5, 7, 2, 2, 19, NULL, NULL, NULL, NULL, '2018-06-20 14:00:00'),
  (26, 8, 6, 2, 2, 20, NULL, NULL, NULL, NULL, '2018-06-20 20:00:00'),
  (27, 9, 11, 2, 3, 21, NULL, NULL, NULL, NULL, '2018-06-21 17:00:00'),
  (28, 12, 10, 2, 3, 22, NULL, NULL, NULL, NULL, '2018-06-21 14:00:00'),
  (29, 13, 15, 2, 4, 23, NULL, NULL, NULL, NULL, '2018-06-21 20:00:00'),
  (30, 16, 14, 2, 4, 24, NULL, NULL, NULL, NULL, '2018-06-22 17:00:00'),
  (31, 17, 19, 2, 5, 25, NULL, NULL, NULL, NULL, '2018-06-22 14:00:00'),
  (32, 20, 18, 2, 5, 26, NULL, NULL, NULL, NULL, '2018-06-22 20:00:00'),
  (33, 21, 23, 2, 6, 27, NULL, NULL, NULL, NULL, '2018-06-23 20:00:00'),
  (34, 24, 22, 2, 6, 28, NULL, NULL, NULL, NULL, '2018-06-23 17:00:00'),
  (35, 25, 27, 2, 7, 29, NULL, NULL, NULL, NULL, '2018-06-23 14:00:00'),
  (36, 28, 26, 2, 7, 30, NULL, NULL, NULL, NULL, '2018-06-24 14:00:00'),
  (37, 29, 31, 2, 8, 31, NULL, NULL, NULL, NULL, '2018-06-24 20:00:00'),
  (38, 32, 30, 2, 8, 32, NULL, NULL, NULL, NULL, '2018-06-24 17:00:00'),
  (39, 4, 1, 3, 1, 33, NULL, NULL, NULL, NULL, '2018-06-25 16:00:00'),
  (40, 2, 3, 3, 1, 34, NULL, NULL, NULL, NULL, '2018-06-25 16:00:00'),
  (41, 8, 5, 3, 2, 35, NULL, NULL, NULL, NULL, '2018-06-25 20:00:00'),
  (42, 6, 7, 3, 2, 36, NULL, NULL, NULL, NULL, '2018-06-25 20:00:00'),
  (43, 12, 9, 3, 3, 37, NULL, NULL, NULL, NULL, '2018-06-26 16:00:00'),
  (44, 10, 11, 3, 3, 38, NULL, NULL, NULL, NULL, '2018-06-26 16:00:00'),
  (45, 16, 13, 3, 4, 39, NULL, NULL, NULL, NULL, '2018-06-26 20:00:00'),
  (46, 14, 15, 3, 4, 40, NULL, NULL, NULL, NULL, '2018-06-26 20:00:00'),
  (47, 20, 17, 3, 5, 41, NULL, NULL, NULL, NULL, '2018-06-27 20:00:00'),
  (48, 18, 19, 3, 5, 42, NULL, NULL, NULL, NULL, '2018-06-27 20:00:00'),
  (49, 24, 21, 3, 6, 43, NULL, NULL, NULL, NULL, '2018-06-27 16:00:00'),
  (50, 22, 23, 3, 6, 44, NULL, NULL, NULL, NULL, '2018-06-27 16:00:00'),
  (51, 28, 25, 3, 7, 45, NULL, NULL, NULL, NULL, '2018-06-28 20:00:00'),
  (52, 26, 27, 3, 7, 46, NULL, NULL, NULL, NULL, '2018-06-28 20:00:00'),
  (53, 32, 29, 3, 8, 47, NULL, NULL, NULL, NULL, '2018-06-28 16:00:00'),
  (54, 30, 31, 3, 8, 48, NULL, NULL, NULL, NULL, '2018-06-28 16:00:00');
