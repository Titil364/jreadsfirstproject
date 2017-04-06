-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Jeu 06 Avril 2017 à 16:58
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ChiCI`
--

-- --------------------------------------------------------

--
-- Structure de la table `Answer`
--

CREATE TABLE `Answer` (
  `visitorId` int(11) DEFAULT NULL,
  `questionId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Application`
--

CREATE TABLE `Application` (
  `applicationId` int(11) NOT NULL,
  `applicationName` varchar(20) DEFAULT NULL,
  `applicationDescription` varchar(20) DEFAULT NULL,
  `formId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Form`
--

CREATE TABLE `Form` (
  `formId` int(11) NOT NULL,
  `formName` varchar(20) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `questionId` int(11) NOT NULL,
  `questionName` varchar(20) DEFAULT NULL,
  `applicationId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `userId` int(11) NOT NULL,
  `userMail` varchar(20) DEFAULT NULL,
  `userSurname` varchar(20) DEFAULT NULL,
  `userForename` varchar(20) DEFAULT NULL,
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Visitor`
--

CREATE TABLE `Visitor` (
  `visitorId` int(11) NOT NULL,
  `visitorGroupId` int(11) DEFAULT NULL,
  `visitorSecretName` varchar(20) DEFAULT NULL,
  `visitorSchool` varchar(20) DEFAULT NULL,
  `visitorAge` int(11) DEFAULT NULL,
  `visitorClass` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Answer`
--
ALTER TABLE `Answer`
  ADD KEY `fk_question_answer` (`questionId`),
  ADD KEY `fk_visitor_answer` (`visitorId`);

--
-- Index pour la table `Application`
--
ALTER TABLE `Application`
  ADD PRIMARY KEY (`applicationId`),
  ADD KEY `fk_for_application` (`formId`);

--
-- Index pour la table `Form`
--
ALTER TABLE `Form`
  ADD PRIMARY KEY (`formId`),
  ADD KEY `fk_user_form` (`userId`);

--
-- Index pour la table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`questionId`),
  ADD KEY `fk_application_question` (`applicationId`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userId`);

--
-- Index pour la table `Visitor`
--
ALTER TABLE `Visitor`
  ADD PRIMARY KEY (`visitorId`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Answer`
--
ALTER TABLE `Answer`
  ADD CONSTRAINT `fk_question_answer` FOREIGN KEY (`questionId`) REFERENCES `Question` (`questionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_visitor_answer` FOREIGN KEY (`visitorId`) REFERENCES `Visitor` (`visitorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Application`
--
ALTER TABLE `Application`
  ADD CONSTRAINT `fk_for_application` FOREIGN KEY (`formId`) REFERENCES `Form` (`formId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Form`
--
ALTER TABLE `Form`
  ADD CONSTRAINT `fk_user_form` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `fk_application_question` FOREIGN KEY (`applicationId`) REFERENCES `Application` (`applicationId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
