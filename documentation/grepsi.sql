-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 23 Mars 2016 à 09:16
-- Version du serveur :  5.6.26
-- Version de PHP :  5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `grepsi`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `label`) VALUES
(11, 'cat1'),
(12, 'cat2');

-- --------------------------------------------------------

--
-- Structure de la table `contributeur`
--

CREATE TABLE IF NOT EXISTS `contributeur` (
  `idpersonne` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `contributeur`
--

INSERT INTO `contributeur` (`idpersonne`, `idarticle`) VALUES
(1000000002, 1000001);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `statut` char(1) COLLATE utf8_bin NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `description` varchar(250) COLLATE utf8_bin NOT NULL,
  `idtype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`id`, `label`, `statut`, `debut`, `fin`, `description`, `idtype`) VALUES
(100001, 'evenement1', '0', '1985-12-23', '1996-11-11', 'test de la BDD', 101);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `devise` varchar(200) COLLATE utf8_bin NOT NULL,
  `logo` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `label`, `devise`, `logo`) VALUES
(100001, 'groupe', 'hello world', '');

-- --------------------------------------------------------

--
-- Structure de la table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `idpersonne` int(11) NOT NULL,
  `idevenement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `invitation`
--

INSERT INTO `invitation` (`idpersonne`, `idevenement`) VALUES
(1000000001, 100001);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `idpersonne` int(11) NOT NULL,
  `idgroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`idpersonne`, `idgroupe`) VALUES
(1000000001, 100001),
(1000000002, 100001);

-- --------------------------------------------------------

--
-- Structure de la table `partage`
--

CREATE TABLE IF NOT EXISTS `partage` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `nbdown` int(11) NOT NULL,
  `lastdown` date NOT NULL,
  `idpersonne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `partage`
--

INSERT INTO `partage` (`id`, `label`, `date`, `nbdown`, `lastdown`, `idpersonne`) VALUES
(1000000001, 'monfichier', '1004-09-17', 2, '1999-12-31', 1000000002);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE IF NOT EXISTS `personne` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `nom` varchar(50) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(50) COLLATE utf8_bin NOT NULL,
  `statut` char(1) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL,
  `datenaiss` date NOT NULL,
  `tel` int(10) NOT NULL,
  `telpublic` tinyint(1) NOT NULL,
  `photo` varchar(200) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(200) COLLATE utf8_bin NOT NULL,
  `cv` text COLLATE utf8_bin NOT NULL,
  `cvpublic` tinyint(1) NOT NULL,
  `devise` varchar(200) COLLATE utf8_bin NOT NULL,
  `signature` varchar(200) COLLATE utf8_bin NOT NULL,
  `acceptmails` tinyint(1) NOT NULL,
  `nbpost` int(11) NOT NULL,
  `nblikes` int(11) NOT NULL,
  `nbarticles` int(11) NOT NULL,
  `nbcontribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`id`, `mail`, `password`, `nom`, `prenom`, `statut`, `pseudo`, `datenaiss`, `tel`, `telpublic`, `photo`, `avatar`, `cv`, `cvpublic`, `devise`, `signature`, `acceptmails`, `nbpost`, `nblikes`, `nbarticles`, `nbcontribution`) VALUES
(1000000001, '', '', 'Guiboud-Ribbaud', 'Théo', '1', 'Théguiboud', '1997-05-21', 666666666, 0, '', '0', 'lol', 0, 'Wesh alors', 'théo', 0, 0, 0, 0, 0),
(1000000002, 'valsov@lol.fr', '', 'Sovignet', 'Valentin', '1', 'Valsov', '2005-01-12', 486523866, 0, '', '0', 'C''est mon super CV', 1, 'Vive l''EPSI', 'yo', 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL,
  `contenu` text COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `likes` int(4) NOT NULL,
  `idpersonne` int(11) NOT NULL,
  `idtopic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `contenu`, `date`, `likes`, `idpersonne`, `idtopic`) VALUES
(100001, 'test d''un post, pour\r\nvoir si base OK.', '2011-07-26', 0, 1000000001, 100000001);

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `idreseau` int(11) NOT NULL,
  `idpersonne` int(11) NOT NULL,
  `urlprofil` varchar(200) COLLATE utf8_bin NOT NULL,
  `urlpublic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`idreseau`, `idpersonne`, `urlprofil`, `urlpublic`) VALUES
(1001, 1000000001, 'theo', 0),
(1001, 1000000002, 'val', 0);

-- --------------------------------------------------------

--
-- Structure de la table `rangement`
--

CREATE TABLE IF NOT EXISTS `rangement` (
  `idcategorie` int(11) NOT NULL,
  `idcategoriep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rangement`
--

INSERT INTO `rangement` (`idcategorie`, `idcategoriep`) VALUES
(11, 12);

-- --------------------------------------------------------

--
-- Structure de la table `reseau`
--

CREATE TABLE IF NOT EXISTS `reseau` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `reseau`
--

INSERT INTO `reseau` (`id`, `label`) VALUES
(1001, 'epsi');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `tag`
--

INSERT INTO `tag` (`id`, `label`) VALUES
(1, 'tag1'),
(2, 'tag2');

-- --------------------------------------------------------

--
-- Structure de la table `tchat`
--

CREATE TABLE IF NOT EXISTS `tchat` (
  `id` int(11) NOT NULL,
  `contenu` text COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `humeur` text COLLATE utf8_bin NOT NULL,
  `idpersonne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `tchat`
--

INSERT INTO `tchat` (`id`, `contenu`, `date`, `humeur`, `idpersonne`) VALUES
(101, 'test d''un tag. Fonctionne?', '2016-03-22', 'Mode rageux si marche pas', 1000000002);

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `blog` tinyint(1) NOT NULL,
  `ferme` tinyint(1) NOT NULL,
  `epingle` tinyint(1) NOT NULL,
  `idcategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `topic`
--

INSERT INTO `topic` (`id`, `label`, `date`, `blog`, `ferme`, `epingle`, `idcategorie`) VALUES
(100000001, 'topic test', '2011-11-11', 0, 0, 0, 11);

-- --------------------------------------------------------

--
-- Structure de la table `topig`
--

CREATE TABLE IF NOT EXISTS `topig` (
  `idtopic` int(11) NOT NULL,
  `idtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `topig`
--

INSERT INTO `topig` (`idtopic`, `idtag`) VALUES
(100000001, 2);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `obligatoire` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id`, `label`, `obligatoire`) VALUES
(101, 'test type', 1);

-- --------------------------------------------------------

--
-- Structure de la table `wig`
--

CREATE TABLE IF NOT EXISTS `wig` (
  `idarticle` int(11) NOT NULL,
  `idtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `wig`
--

INSERT INTO `wig` (`idarticle`, `idtag`) VALUES
(1000001, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wiki`
--

CREATE TABLE IF NOT EXISTS `wiki` (
  `id` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_bin NOT NULL,
  `contenu` text COLLATE utf8_bin NOT NULL,
  `datecrea` date NOT NULL,
  `lastmod` date NOT NULL,
  `visites` int(6) NOT NULL,
  `idpersonne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `wiki`
--

INSERT INTO `wiki` (`id`, `label`, `contenu`, `datecrea`, `lastmod`, `visites`, `idpersonne`) VALUES
(1000001, 'test wiki', 'Si ce test ne marche pas, je répond de rien!', '1515-05-15', '1516-05-15', 15, 1000000002);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contributeur`
--
ALTER TABLE `contributeur`
  ADD PRIMARY KEY (`idpersonne`,`idarticle`),
  ADD KEY `idarticle` (`idarticle`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtype` (`idtype`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`idpersonne`,`idevenement`),
  ADD KEY `idevenement` (`idevenement`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`idpersonne`,`idgroupe`),
  ADD KEY `idgroupe` (`idgroupe`);

--
-- Index pour la table `partage`
--
ALTER TABLE `partage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersonne` (`idpersonne`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersonne` (`idpersonne`),
  ADD KEY `idtopic` (`idtopic`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`idreseau`,`idpersonne`),
  ADD KEY `idpersonne` (`idpersonne`);

--
-- Index pour la table `rangement`
--
ALTER TABLE `rangement`
  ADD PRIMARY KEY (`idcategorie`,`idcategoriep`),
  ADD KEY `idcategoriep` (`idcategoriep`);

--
-- Index pour la table `reseau`
--
ALTER TABLE `reseau`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tchat`
--
ALTER TABLE `tchat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersonne` (`idpersonne`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcategorie` (`idcategorie`);

--
-- Index pour la table `topig`
--
ALTER TABLE `topig`
  ADD PRIMARY KEY (`idtopic`,`idtag`),
  ADD KEY `idtag` (`idtag`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wig`
--
ALTER TABLE `wig`
  ADD PRIMARY KEY (`idarticle`,`idtag`),
  ADD KEY `idtag` (`idtag`);

--
-- Index pour la table `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersonne` (`idpersonne`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contributeur`
--
ALTER TABLE `contributeur`
  ADD CONSTRAINT `contributeur_ibfk_1` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`),
  ADD CONSTRAINT `contributeur_ibfk_2` FOREIGN KEY (`idarticle`) REFERENCES `wiki` (`id`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`idtype`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `invitation_ibfk_1` FOREIGN KEY (`idevenement`) REFERENCES `evenement` (`id`),
  ADD CONSTRAINT `invitation_ibfk_2` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
  ADD CONSTRAINT `membre_ibfk_1` FOREIGN KEY (`idgroupe`) REFERENCES `groupe` (`id`),
  ADD CONSTRAINT `membre_ibfk_2` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

--
-- Contraintes pour la table `partage`
--
ALTER TABLE `partage`
  ADD CONSTRAINT `partage_ibfk_1` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`idtopic`) REFERENCES `topic` (`id`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`idreseau`) REFERENCES `reseau` (`id`),
  ADD CONSTRAINT `profil_ibfk_2` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

--
-- Contraintes pour la table `rangement`
--
ALTER TABLE `rangement`
  ADD CONSTRAINT `rangement_ibfk_1` FOREIGN KEY (`idcategorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `rangement_ibfk_2` FOREIGN KEY (`idcategoriep`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `tchat`
--
ALTER TABLE `tchat`
  ADD CONSTRAINT `tchat_ibfk_1` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`idcategorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `topig`
--
ALTER TABLE `topig`
  ADD CONSTRAINT `topig_ibfk_1` FOREIGN KEY (`idtag`) REFERENCES `tag` (`id`),
  ADD CONSTRAINT `topig_ibfk_2` FOREIGN KEY (`idtopic`) REFERENCES `topic` (`id`);

--
-- Contraintes pour la table `wig`
--
ALTER TABLE `wig`
  ADD CONSTRAINT `wig_ibfk_1` FOREIGN KEY (`idarticle`) REFERENCES `wiki` (`id`),
  ADD CONSTRAINT `wig_ibfk_2` FOREIGN KEY (`idtag`) REFERENCES `tag` (`id`);

--
-- Contraintes pour la table `wiki`
--
ALTER TABLE `wiki`
  ADD CONSTRAINT `wiki_ibfk_1` FOREIGN KEY (`idpersonne`) REFERENCES `personne` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
