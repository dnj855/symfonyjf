-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 11 mai 2018 à 15:58
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `symfonyjf`
--

--
-- Déchargement des données de la table `cm18GamePhase`
--

INSERT INTO `cm18GamePhase` (`id`, `name`, `eliminatory`, `final`) VALUES
  (1, 'Phase de poule - Match 1', 0, 0),
  (2, 'Phase de poule - Match 2', 0, 0),
  (3, 'Phase de poule - Match 3', 0, 0),
  (4, '8è de finale', 1, 0),
  (5, 'Quart de finale', 1, 0),
  (6, 'Demi-finale', 1, 0),
  (7, 'Petite finale', 1, 0),
  (8, 'Finale', 1, 1);
