-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 11 Août 2015 à 20:33
-- Version du serveur :  5.5.38
-- Version de PHP :  5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `muse`
--

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
`id` int(11) NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `reponse` text CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
`id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(11,2) NOT NULL,
  `nbClicks` int(11) NOT NULL,
  `nbAjouts` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `titre`, `description`, `prix`, `nbClicks`, `nbAjouts`) VALUES
(1, 'La Muse', 'La Muse décide de composer un bouquet à son image, elle le voulait joyeux et passionné. Elle choisit plusieurs variétés de fleurs. La rose pour la passion, les oelliets pour l''effronterie, les rononcules pour la beauté la scabieuse pour sa note nostalgique, l''alstromeria symbolisant le bonheur et le lisianthus pour sa note de joie.', 45.83, 0, 0),
(2, 'Il était une fois', 'Pour commencer il était une fois une Muse qui cueillait à l''aube quelques roses violettes puis des lisianthus et du freesia. Mais pour lui donner toute sa magie elle y ajouta de la scabieuse et de la giroflée.', 55.00, 0, 0),
(3, 'La Muse', 'La Muse décide de composer un bouquet à son image, elle le voulait joyeux et passionné. Elle choisit plusieurs variétés de fleurs. La rose pour la passion, les oelliets pour l''effronterie, les rononcules pour la beauté la scabieuse pour sa note nostalgique, l''alstromeria symbolisant le bonheur et le lisianthus pour sa note de joie.', 45.83, 0, 0),
(4, 'Il était une fois', 'Pour commencer il était une fois une Muse qui cueillait à l''aube quelques roses violettes puis des lisianthus et du freesia. Mais pour lui donner toute sa magie elle y ajouta de la scabieuse et de la giroflée.', 55.00, 0, 0),
(5, 'La Muse', 'La Muse décide de composer un bouquet à son image, elle le voulait joyeux et passionné. Elle choisit plusieurs variétés de fleurs. La rose pour la passion, les oelliets pour l''effronterie, les rononcules pour la beauté la scabieuse pour sa note nostalgique, l''alstromeria symbolisant le bonheur et le lisianthus pour sa note de joie.', 45.83, 0, 0),
(6, 'Il était une fois', 'Pour commencer il était une fois une Muse qui cueillait à l''aube quelques roses violettes puis des lisianthus et du freesia. Mais pour lui donner toute sa magie elle y ajouta de la scabieuse et de la giroflée.', 55.00, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `adresse` text CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `pays` varchar(255) CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `ville` varchar(255) CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;