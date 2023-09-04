-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage des données de la table forum_v2.category : ~11 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `categoryName`, `description`) VALUES
	(1, 'REGLEMENT', 'Catégorie réservée aux règlements du forum (veuillez la lire avant de vous inscrire et de contribuer).'),
	(2, 'PRESENTATION', 'Catégorie réservée à la présentation des membres, pour signaler votre appartenance à la communauté.'),
	(3, 'HISTOIRE DU CLUB', 'Catégorie réservée à l\'histoire du Chelsea Football Club.'),
	(4, 'ACTUALITE', 'Catégorie réservée à l\'actualité brûlante du CFC.'),
	(5, 'LES MATCHS', 'Catégorie réservée aux matchs : donnez votre avis, top et flop, compos idéale, etc'),
	(6, 'LE MERCATO', 'Catégorie réservée aux transferts du CFC, venez donner votre avis.'),
	(7, 'INFRASTRUCTURE', 'Infrastructures : Nouveautés, perspectives d\'améliorations, suggestions.'),
	(8, 'BILAN SAISON', 'Catégorie réservée au bilan de la saison, aux moments mémorables, aux points forts et aux points faibles.'),
	(9, 'EVENEMENTS', 'Catégorie réservée aux événements : venez partager des moments inoubliables.'),
	(10, 'BLA-BLATAGE', 'Catégorie réservée aux discussions éphémères, aux joies et aux coups de gueule.'),
	(11, 'bonjour', 'comment allez-vous');

-- Listage des données de la table forum_v2.post : ~19 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `message`, `postDate`, `topic_id`, `user_id`) VALUES
	(5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:01:36', 2, 1),
	(6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:01:57', 2, 13),
	(7, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:02:14', 2, 10),
	(8, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 09:02:29', 2, 13),
	(9, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:02:51', 1, 5),
	(10, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 09:03:04', 1, 11),
	(11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 3, 5),
	(12, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 3, 14),
	(13, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 4, 7),
	(14, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 4, 17),
	(15, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 5, 8),
	(16, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 5, 10),
	(17, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 6, 3),
	(18, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 6, 16),
	(19, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 7, 13),
	(20, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 7, 1),
	(21, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 8, 8),
	(22, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 8, 7),
	(23, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere eligendi, vero repellendus quisquam animi commodi modi unde veritatis neque ea beatae, fugit, asperiores impedit at quos vitae perspiciatis natus blanditiis.', '2023-09-01 11:03:20', 10, 2);

-- Listage des données de la table forum_v2.topic : ~10 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `user_id`, `category_id`, `isLocked`) VALUES
	(1, 'Les Légendes', '2023-09-01 10:50:30', 15, 3, 0),
	(2, 'Le Palmarès', '2023-09-01 08:54:15', 2, 3, 0),
	(3, 'Présentez-vous', '2023-09-04 08:27:58', 1, 2, 0),
	(4, 'Soirée gala ', '2023-09-04 08:28:43', 1, 9, 0),
	(5, 'La Boutique', '2023-09-04 08:29:38', 2, 7, 0),
	(6, 'Les nouveaux', '2023-09-04 08:29:50', 3, 6, 0),
	(7, 'Victoire dans la douleur', '2023-09-04 08:30:22', 4, 5, 0),
	(8, 'Le reglement intérieur', '2023-09-04 08:30:57', 1, 1, 0),
	(9, 'Le classement', '2023-09-04 08:34:14', 14, 8, 0),
	(10, 'venez blablater', '2023-09-04 08:34:49', 11, 10, 0);

-- Listage des données de la table forum_v2.user : ~17 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `email`, `pseudo`, `passWord`, `signUpDate`, `role`, `avatar`, `isBanned`) VALUES
	(1, 'jules@gmail.com', 'JuliusCesar', '1234', '2023-08-30 16:40:10', NULL, 'avatara.png', 0),
	(2, 'paul@yahoo.fr', 'Paulo2023', '12345', '2023-08-30 16:54:34', NULL, 'avatarb.png', 0),
	(3, 'caromb12@chelsea-fc.com', 'CarolineMB12', 'MotDePasse1', '2023-09-01 07:38:46', NULL, 'avatar1.png', 0),
	(4, 'alexG03@chelsea-fc.com', 'AlexG03', 'MotDePasse2', '2023-09-01 07:38:46', NULL, 'avatar2.png', 0),
	(5, 'lucyP45@chelsea-fc.com', 'LucyP45', 'MotDePasse3', '2023-09-01 07:38:46', NULL, 'avatar3.png', 0),
	(6, 'mikeT99@chelsea-fc.com', 'MikeT99', 'MotDePasse4', '2023-09-01 07:38:46', NULL, 'avatar4.png', 0),
	(7, 'sophieL88@chelsea-fc.com', 'SophieL88', 'MotDePasse5', '2023-09-01 07:38:46', NULL, 'avatar5.png', 0),
	(8, 'davidH76@chelsea-fc.com', 'DavidH76', 'MotDePasse6', '2023-09-01 07:38:46', NULL, 'avatar6.png', 0),
	(9, 'oliviaS22@chelsea-fc.com', 'OliviaS22', 'MotDePasse7', '2023-09-01 07:38:46', NULL, 'avatar7.png', 0),
	(10, 'jamesK11@chelsea-fc.com', 'JamesK11', 'MotDePasse8', '2023-09-01 07:38:46', NULL, 'avatar8.png', 0),
	(11, 'lauraD67@chelsea-fc.com', 'LauraD67', 'MotDePasse9', '2023-09-01 07:38:46', NULL, 'avatar9.png', 0),
	(12, 'maxW55@chelsea-fc.com', 'MaxW55', 'MotDePasse10', '2023-09-01 07:38:46', NULL, 'avatar10.png', 0),
	(13, 'emilyR89@chelsea-fc.com', 'EmilyR89', 'MotDePasse11', '2023-09-01 07:38:46', NULL, 'avatar11.png', 0),
	(14, 'danielJ33@chelsea-fc.com', 'DanielJ33', 'MotDePasse12', '2023-09-01 07:38:46', NULL, 'avatar12.png', 0),
	(15, 'sarahC44@chelsea-fc.com', 'SarahC44', 'MotDePasse13', '2023-09-01 07:38:46', NULL, 'avatar13.png', 0),
	(16, 'williamE78@chelsea-fc.com', 'WilliamE78', 'MotDePasse14', '2023-09-01 07:38:46', NULL, 'avatar14.png', 0),
	(17, 'juliaM25@chelsea-fc.com', 'JuliaM25', 'MotDePasse15', '2023-09-01 07:38:46', NULL, 'avatar15.png', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
