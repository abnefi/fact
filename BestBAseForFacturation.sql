-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour facturation_db
CREATE DATABASE IF NOT EXISTS `facturation_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `facturation_db`;

-- Listage de la structure de la table facturation_db. client_devis
CREATE TABLE IF NOT EXISTS `client_devis` (
  `id` int(11) NOT NULL,
  `reference_facture_vente_genere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_reglement` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_284A599CBF396750` FOREIGN KEY (`id`) REFERENCES `client_facture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_devis : ~2 rows (environ)
/*!40000 ALTER TABLE `client_devis` DISABLE KEYS */;
INSERT INTO `client_devis` (`id`, `reference_facture_vente_genere`, `date_reglement`) VALUES
	(0, 'FV00001-AG01ST01-ASP', '2020-11-27'),
	(7, 'FV00001-AG01ST01-ASP', '2020-11-27');
/*!40000 ALTER TABLE `client_devis` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_devis_exportation
CREATE TABLE IF NOT EXISTS `client_devis_exportation` (
  `id` int(11) NOT NULL,
  `reference_facture_vente_genere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_76FA3A53BF396750` FOREIGN KEY (`id`) REFERENCES `client_facture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_devis_exportation : ~0 rows (environ)
/*!40000 ALTER TABLE `client_devis_exportation` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_devis_exportation` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture
CREATE TABLE IF NOT EXISTS `client_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_facture_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `agence_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `devise_id` int(11) DEFAULT NULL,
  `etat_declaration_id` int(11) DEFAULT NULL,
  `reponse_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_facture` date NOT NULL,
  `est_valide` tinyint(1) NOT NULL,
  `ecriture_passee` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `taux_change` double DEFAULT NULL,
  `id_local` int(11) DEFAULT NULL,
  `taux_tva` double NOT NULL,
  `application_aib` tinyint(1) NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci,
  `referenceComptable` longtext COLLATE utf8_unicode_ci,
  `total_ht` double NOT NULL,
  `total_tva` double NOT NULL,
  `total_aib` double NOT NULL,
  `total_ttc` double NOT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_ACBB206DAEA34913` (`reference`),
  KEY `IDX_ACBB206D622E382D` (`type_facture_id`),
  KEY `IDX_ACBB206D19EB6921` (`client_id`),
  KEY `IDX_ACBB206DD725330D` (`agence_id`),
  KEY `IDX_ACBB206DA76ED395` (`user_id`),
  KEY `IDX_ACBB206DF4445056` (`devise_id`),
  KEY `IDX_ACBB206D7912F8BF` (`etat_declaration_id`),
  KEY `IDX_ACBB206DCF18BB82` (`reponse_id`),
  KEY `IDX_ACBB206DFCF77503` (`societe_id`),
  CONSTRAINT `FK_ACBB206D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `tiers_client` (`id`),
  CONSTRAINT `FK_ACBB206D622E382D` FOREIGN KEY (`type_facture_id`) REFERENCES `config_type_facture` (`id`),
  CONSTRAINT `FK_ACBB206D7912F8BF` FOREIGN KEY (`etat_declaration_id`) REFERENCES `config_etat` (`id`),
  CONSTRAINT `FK_ACBB206DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_ACBB206DCF18BB82` FOREIGN KEY (`reponse_id`) REFERENCES `client_facture_reponse` (`id`),
  CONSTRAINT `FK_ACBB206DD725330D` FOREIGN KEY (`agence_id`) REFERENCES `config_agence` (`id`),
  CONSTRAINT `FK_ACBB206DF4445056` FOREIGN KEY (`devise_id`) REFERENCES `config_devise` (`id`),
  CONSTRAINT `FK_ACBB206DFCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture : ~12 rows (environ)
/*!40000 ALTER TABLE `client_facture` DISABLE KEYS */;
INSERT INTO `client_facture` (`id`, `type_facture_id`, `client_id`, `agence_id`, `user_id`, `devise_id`, `etat_declaration_id`, `reponse_id`, `societe_id`, `reference`, `date_facture`, `est_valide`, `ecriture_passee`, `created`, `updated_at`, `createdBy`, `updateBy`, `taux_change`, `id_local`, `taux_tva`, `application_aib`, `notes`, `referenceComptable`, `total_ht`, `total_tva`, `total_aib`, `total_ttc`, `estSupprimer`, `type`) VALUES
	(7, 5, 3, 1, 1, 1, 4, 7, 4, 'DV00001-AG01ST01-ASP', '2020-02-18', 1, 0, '2020-03-04 16:39:30', '2020-03-04 16:39:30', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'devis'),
	(10, 1, 3, 1, 1, 1, 5, 5, 1, 'FV00001-AG01ST01-ASP', '2020-02-18', 1, 0, '2020-03-05 09:40:31', '2020-03-05 09:40:31', '', NULL, NULL, NULL, 18, 1, '<p>Les conditions de règlement de la facture sont stipulées comme suit:</p><ul><li>Later when creating and updating Users,&nbsp;</li><li> you will&nbsp;&nbsp;need to be able to access the phoneNumber&nbsp;</li><li>need to be able to access the phoneNumber&nbsp;</li><li>need to be able to access the phoneNumber&nbsp;<br></li></ul>', NULL, 9800, 900, 0, 10700, 0, 'vente'),
	(11, 1, 4, 2, 2, 1, 5, 6, 1, 'FV00002-AG01ST01-ASP', '2020-02-17', 1, 0, '2020-03-05 10:19:41', '2020-03-05 10:19:41', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 3000, 0, 0, 3000, 0, 'vente'),
	(12, 1, 4, 1, 1, 1, 2, NULL, 1, 'FV00003-AG01ST01-ASP', '2020-03-02', 1, 0, '2020-03-05 10:41:05', '2020-03-05 10:41:05', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 42800, 7704, 0, 51260, 0, 'vente'),
	(13, 3, 4, 2, 2, 1, 5, 7, 1, 'FA00001-AG01ST01-ASP', '2020-03-04', 1, 0, '2020-03-05 10:45:13', '2020-03-05 10:45:13', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'avoir'),
	(14, 1, 7, 2, NULL, 1, 2, NULL, 1, 'FV00004-AG01ST01-ASP', '2020-03-09', 1, 0, '2020-03-05 16:55:12', '2020-03-05 16:55:12', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'vente'),
	(15, 1, 4, 2, 2, 1, 2, NULL, 4, 'FV00005-AG01ST01-ASP', '2020-02-14', 1, 0, '2020-03-06 09:26:27', '2020-03-06 09:26:27', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 2500, 450, 0, 2950, 0, 'vente'),
	(16, 1, 5, 2, 2, 1, 2, NULL, 1, 'FV00006-AG01ST01-ASP', '2020-02-24', 1, 0, '2020-03-09 10:56:49', '2020-03-09 10:56:49', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'vente'),
	(17, 1, 5, 2, 2, 1, 2, NULL, 1, 'FV00007-AG01ST01-ASP', '2020-03-02', 0, 0, '2020-03-12 17:05:36', '2020-03-12 17:05:36', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'vente'),
	(18, 1, 15, 2, 2, 1, 4, 8, 4, 'FV00008-AG01ST01-ASP', '2020-03-10', 1, 0, '2020-03-13 09:55:00', '2020-12-29 07:52:20', '', 'abedr-hounsinouret-2020-11-16-08-40', NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'vente'),
	(19, 3, 7, 2, 2, 1, 6, NULL, 1, 'FA00002-AG01ST01-ASP', '2020-03-16', 0, 0, '2020-03-28 11:02:47', '2020-03-28 11:02:47', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 0, 0, 0, 0, 0, 'avoir'),
	(20, 1, 8, 2, 2, 1, 6, NULL, 1, 'FV00009-AG01ST01-ASP', '2020-03-10', 0, 0, '2020-03-28 11:52:27', '2020-03-28 11:52:27', '', NULL, NULL, NULL, 18, 1, NULL, NULL, 3000, 0, 30, 3030, 0, 'vente'),
	(21, 1, 15, 40, 21, 2, 4, NULL, 4, 'STN01FV57404', '2020-12-29', 1, 0, '2020-12-29 09:42:12', '2020-12-29 09:44:31', 'abedr-hounsinouret-2020-11-16-08-40', 'abedr-hounsinouret-2020-11-16-08-40', NULL, NULL, 80, 1, 'cool', NULL, 18000, 0, 180, 18180, 0, 'vente');
/*!40000 ALTER TABLE `client_facture` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_avoir
CREATE TABLE IF NOT EXISTS `client_facture_avoir` (
  `id` int(11) NOT NULL,
  `reference_facture_origine` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_payee` tinyint(1) NOT NULL,
  `est_declaree` tinyint(1) NOT NULL,
  `date_reglement` date NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_8019A8C0BF396750` FOREIGN KEY (`id`) REFERENCES `client_facture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_avoir : ~2 rows (environ)
/*!40000 ALTER TABLE `client_facture_avoir` DISABLE KEYS */;
INSERT INTO `client_facture_avoir` (`id`, `reference_facture_origine`, `est_payee`, `est_declaree`, `date_reglement`, `updateAt`) VALUES
	(13, 'FV00003-AG01ST01-ASP', 1, 0, '2020-03-05', NULL),
	(19, 'FV00004-AG01ST01-ASP', 0, 0, '2020-03-17', '2020-10-19 19:23:29');
/*!40000 ALTER TABLE `client_facture_avoir` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_avoir_exportation
CREATE TABLE IF NOT EXISTS `client_facture_avoir_exportation` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_A9988CDBF396750` FOREIGN KEY (`id`) REFERENCES `client_facture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_avoir_exportation : ~0 rows (environ)
/*!40000 ALTER TABLE `client_facture_avoir_exportation` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_facture_avoir_exportation` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_detail
CREATE TABLE IF NOT EXISTS `client_facture_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facture_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `unite_mesure_id` int(11) DEFAULT NULL,
  `quantite` double NOT NULL,
  `prix_vente_unitaire` double NOT NULL,
  `taux_remise` double DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `aib_deductible` tinyint(1) NOT NULL,
  `taux_aib` double NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `has_taxe_specifique` tinyint(1) NOT NULL,
  `taxe_specifique` double DEFAULT NULL,
  `description_taxe_specifique` longtext COLLATE utf8_unicode_ci,
  `changement_prix_unitaire_ttc` tinyint(1) NOT NULL,
  `dernier_prix_origine` double DEFAULT NULL,
  `description_prix_origine` longtext COLLATE utf8_unicode_ci,
  `updated_at` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `taxe_de_sejour` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A522FBB7F2DEE08` (`facture_id`),
  KEY `IDX_5A522FBBF347EFB` (`produit_id`),
  KEY `IDX_5A522FBBC75A06BF` (`unite_mesure_id`),
  CONSTRAINT `FK_5A522FBB7F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `client_facture` (`id`),
  CONSTRAINT `FK_5A522FBBC75A06BF` FOREIGN KEY (`unite_mesure_id`) REFERENCES `config_unite_mesure` (`id`),
  CONSTRAINT `FK_5A522FBBF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `stock_produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_detail : ~18 rows (environ)
/*!40000 ALTER TABLE `client_facture_detail` DISABLE KEYS */;
INSERT INTO `client_facture_detail` (`id`, `facture_id`, `produit_id`, `unite_mesure_id`, `quantite`, `prix_vente_unitaire`, `taux_remise`, `estSupprimer`, `aib_deductible`, `taux_aib`, `description`, `has_taxe_specifique`, `taxe_specifique`, `description_taxe_specifique`, `changement_prix_unitaire_ttc`, `dernier_prix_origine`, `description_prix_origine`, `updated_at`, `created`, `createdBy`, `updateBy`, `taxe_de_sejour`) VALUES
	(1, 7, 4, 1, 2, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-04 16:39:31', NULL, '', NULL, NULL),
	(2, 7, 6, 1, 3, 1600, 0, 0, 0, 0, 'Later when creating and updating Users, you will need to be able to access the phoneNumber attribute and any others we create in future.  The User class will need public methods called “getters and setters”.', 0, NULL, NULL, 1, 1500, 'Le prix a changé en raison des fluctuations monétaires', '2020-03-05 08:24:42', NULL, '', NULL, NULL),
	(3, 10, 4, 1, 2, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-05 09:40:32', NULL, '', NULL, NULL),
	(4, 10, 6, 1, 3, 1600, 0, 0, 0, 0, 'Later when creating and updating Users, you will need to be able to access the phoneNumber attribute and any others we create in future.  The User class will need public methods called “getters and setters”.', 0, NULL, NULL, 1, 1500, NULL, '2020-03-05 09:40:32', NULL, '', NULL, NULL),
	(5, 11, 6, 1, 2, 1500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 1500, NULL, '2020-03-05 10:19:41', NULL, '', NULL, NULL),
	(6, 12, 4, 1, 2, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-05 10:41:06', NULL, '', NULL, NULL),
	(7, 12, 8, 1, 3, 12600, 0, 0, 0, 0, NULL, 0, NULL, NULL, 1, 15000, 'Le prix a changé en raison des fluctuations monétaires', '2020-03-05 10:41:06', NULL, '', NULL, NULL),
	(8, 13, 4, 1, 2, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-05 10:45:14', NULL, '', NULL, NULL),
	(9, 13, 8, 1, 3, 12600, 0, 0, 0, 0, NULL, 0, NULL, NULL, 1, 15000, NULL, '2020-03-05 10:45:14', NULL, '', NULL, NULL),
	(10, 14, 4, 1, 1, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-05 16:55:13', NULL, '', NULL, NULL),
	(11, 15, 4, 1, 1, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-06 09:26:27', NULL, '', NULL, NULL),
	(12, 16, 4, 1, 1, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-09 10:56:49', NULL, '', NULL, NULL),
	(13, 16, 7, 3, 3, 2000, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2000, NULL, '2020-03-09 16:47:28', NULL, '', NULL, NULL),
	(14, 17, 4, 1, -3, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-12 17:05:37', NULL, '', NULL, NULL),
	(15, 18, 6, 1, 2, 1500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 1500, NULL, '2020-03-13 09:55:04', NULL, '', NULL, NULL),
	(16, 18, 7, 3, 3, 2000, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2000, NULL, '2020-03-13 09:55:04', NULL, '', NULL, NULL),
	(17, 19, 4, 1, 1, 2500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 2950, NULL, '2020-03-28 11:02:48', NULL, '', NULL, NULL),
	(18, 20, 6, 1, 2, 1500, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, 1500, NULL, '2020-03-28 11:52:27', NULL, '', NULL, NULL),
	(19, 21, 7, 3, 5, 2000, 0, 0, 1, 0.0001, 'aaaah', 0, NULL, NULL, 0, NULL, NULL, '2020-12-29 09:42:11', '2020-12-29 09:42:12', 'abedr-hounsinouret-2020-11-16-08-40', NULL, 0);
/*!40000 ALTER TABLE `client_facture_detail` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_reponse
CREATE TABLE IF NOT EXISTS `client_facture_reponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_facture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `compteur_type_facture` int(11) NOT NULL,
  `compteur_total` int(11) NOT NULL,
  `date_heure` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sig` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code_qr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_reponse : ~5 rows (environ)
/*!40000 ALTER TABLE `client_facture_reponse` DISABLE KEYS */;
INSERT INTO `client_facture_reponse` (`id`, `reference_facture`, `compteur_type_facture`, `compteur_total`, `date_heure`, `sig`, `code_qr`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(4, 'FA00001-AG01ST01-ASP', 1, 1, '20200326105022', 'D357MYBKF6QSMSD2XWSEFT6R', 'F;ED040025;D357MYBKF6QSMSD2XWSEFT6R;9999900000005;20180401122547', NULL, '', NULL, NULL, 0),
	(5, 'FV00001-AG01ST01-ASP', 1, 2, '20200326105022', 'D357MYBKF6QSMSD2XWSEFT6S', 'F;ED040025;D357MYBKF6QSMSD2XWSEFT6S;9999900000005;20180401122547', NULL, '', NULL, NULL, 0),
	(6, 'FV00002-AG01ST01-ASP', 2, 3, '20200326105022', 'D357MYBKF6QSMSD2XWSEFT6T', 'F;ED040025;D357MYBKF6QSMSD2XWSEFT6T;9999900000005;20180401122547', NULL, '', NULL, NULL, 0),
	(7, 'FA00001-AG01ST01-ASP', 158, 188, '27/03/2020 17:15:48', '24JI-GFT3-GILI-BIJ2-B7UO-7Z7N', 'F;ED040026;24JIGFT3GILIBIJ2B7UO7Z7N;46464949;20200327171548', NULL, '', NULL, NULL, 0),
	(8, 'FV00008-AG01ST01-ASP', 159, 189, '28/03/2020 14:55:10', 'P6A5-3CRT-QMJR-GN23-U4YU-FXI2', 'F;ED04000025;6DG4QNJ6ZESM35NHCTOPUFYC;3200800595314;20200317105721', NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `client_facture_reponse` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_vente
CREATE TABLE IF NOT EXISTS `client_facture_vente` (
  `id` int(11) NOT NULL,
  `has_avoir` tinyint(1) NOT NULL,
  `est_payee` tinyint(1) NOT NULL,
  `est_declaree` tinyint(1) NOT NULL,
  `est_cree_par_devis` tinyint(1) NOT NULL,
  `date_reglement` date NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_6D0898CFBF396750` FOREIGN KEY (`id`) REFERENCES `client_facture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_vente : ~9 rows (environ)
/*!40000 ALTER TABLE `client_facture_vente` DISABLE KEYS */;
INSERT INTO `client_facture_vente` (`id`, `has_avoir`, `est_payee`, `est_declaree`, `est_cree_par_devis`, `date_reglement`) VALUES
	(10, 0, 0, 0, 1, '2020-02-18'),
	(11, 0, 1, 0, 0, '2020-02-18'),
	(12, 1, 1, 0, 0, '2020-03-03'),
	(14, 1, 0, 0, 0, '2020-03-11'),
	(15, 0, 1, 0, 0, '2020-02-15'),
	(16, 0, 0, 0, 0, '2020-02-25'),
	(17, 0, 0, 0, 0, '2020-03-02'),
	(18, 0, 0, 0, 0, '2020-03-10'),
	(20, 0, 0, 0, 0, '2020-03-17'),
	(21, 0, 0, 0, 0, '2020-12-29');
/*!40000 ALTER TABLE `client_facture_vente` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_facture_vente_exportation
CREATE TABLE IF NOT EXISTS `client_facture_vente_exportation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_facture_vente_exportation : ~0 rows (environ)
/*!40000 ALTER TABLE `client_facture_vente_exportation` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_facture_vente_exportation` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. client_paiement
CREATE TABLE IF NOT EXISTS `client_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facture_id` int(11) NOT NULL,
  `mode_paiement_id` int(11) NOT NULL,
  `date_paiement` date NOT NULL,
  `montant` double NOT NULL,
  `created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userPublicId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `referenceComptable` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_9F3A4ADB7F2DEE08` (`facture_id`),
  KEY `IDX_9F3A4ADB438F5B63` (`mode_paiement_id`),
  CONSTRAINT `FK_9F3A4ADB438F5B63` FOREIGN KEY (`mode_paiement_id`) REFERENCES `config_mode_paiement` (`id`),
  CONSTRAINT `FK_9F3A4ADB7F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `client_facture` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.client_paiement : ~9 rows (environ)
/*!40000 ALTER TABLE `client_paiement` DISABLE KEYS */;
INSERT INTO `client_paiement` (`id`, `facture_id`, `mode_paiement_id`, `date_paiement`, `montant`, `created`, `updated_at`, `createdBy`, `updateBy`, `userPublicId`, `supprimer`, `referenceComptable`) VALUES
	(1, 13, 1, '2020-03-04', 30000, '2020-03-05 10:52:25', '2020-03-05 10:52:25', '', NULL, NULL, 0, NULL),
	(2, 13, 5, '2020-03-05', 20504, '2020-03-05 10:52:25', '2020-03-05 10:52:25', '', NULL, NULL, 0, NULL),
	(3, 11, 1, '2020-02-18', 3000, '2020-03-06 14:29:05', '2020-03-06 14:29:05', '', NULL, NULL, 0, NULL),
	(4, 12, 1, '2020-03-02', 30000, '2020-03-06 14:30:06', '2020-03-06 14:30:06', '', NULL, NULL, 0, NULL),
	(5, 12, 4, '2020-03-03', 20504, '2020-03-12 11:20:18', '2020-03-12 11:20:18', '', NULL, NULL, 0, NULL),
	(6, 15, 1, '2020-02-15', 2950, '2020-03-12 17:30:50', '2020-03-12 17:30:50', '', NULL, NULL, 0, NULL),
	(7, 14, 1, '2020-03-09', 2950, '2020-03-28 10:30:49', '2020-03-28 10:30:49', '', NULL, NULL, 0, NULL),
	(8, 16, 1, '2020-03-24', 5000, '2020-03-28 12:30:43', '2020-03-28 12:30:43', '', NULL, NULL, 0, NULL),
	(9, 16, 5, '2020-03-25', 3950, '2020-03-28 12:30:43', '2020-03-28 12:30:43', '', NULL, NULL, 0, NULL),
	(10, 18, 1, '2020-12-23', 9000, '2020-12-28 18:15:13', '2020-12-28 18:15:13', 'abedr-hounsinouret-2020-11-16-08-40', 'abedr-hounsinouret-2020-11-16-08-40', NULL, 0, NULL);
/*!40000 ALTER TABLE `client_paiement` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_abonnement
CREATE TABLE IF NOT EXISTS `config_abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombrejour` int(11) NOT NULL,
  `prix` double NOT NULL,
  `estActif` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flyer_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `limite_agence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6D1BF29DA4D60759` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_abonnement : ~4 rows (environ)
/*!40000 ALTER TABLE `config_abonnement` DISABLE KEYS */;
INSERT INTO `config_abonnement` (`id`, `libelle`, `nombrejour`, `prix`, `estActif`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`, `description`, `flyer_image`, `limite_agence`) VALUES
	(1, 'Premium IGO-FACTURATION', 720, 2500000, 1, '2020-11-25 13:08:00', 'abed', '2020-12-02 16:23:49', 'abed-abed-2020-10-27-18-03', 0, '<p>Conçu pour les PME, IGO-Facturation est l\'application des organisations décentralisées avec des besoins de profondeur fonctionnelle :</p><div class="row" style="display: flex;flex-direction: row;align-items: center;  justify-content: space-between;"><div class="col-md-6"><ul class="pl-1-5"><li>Finances (Comptabilités, Trésorerie, Budget…)</li><li>Achats & Stocks</li><li>Production</li><li>Ventes (Tarifs, Facturation…)</li></ul></div>', '/facturation_app_client/web/frontend/img/igofacture/gestion_stocks.png', 3),
	(2, 'Médium IGO-FACTURATION', 270, 600000, 1, '2020-11-25 15:10:16', 'abed', '2020-12-11 17:23:07', 'abedr-hounsinouret-2020-11-16-08-40', 1, '<p>Suivez vos activités de production au quotidien et facilitez votre croissance externe et internationale:</p> <div class="row" style="display: flex;flex-direction: row;align-items: center;  justify-content: space-between;"><div class="col-md-6"><ul class="pl-1-5"><li>Gestion commerciale</li><li>Gestion de production</li><li>Achats / Stocks / Logistique</li><li>Business Intelligence / Administration des ventes</li></ul></div>', '/facturation_app_client/web/frontend/img/igofacture/Cap_accueil_fns_admin.PNG', 6),
	(3, 'Basic IGO-FACTURATION', 90, 150000, 1, '2020-11-25 15:11:17', 'abed', '2020-12-11 17:23:35', 'abedr-hounsinouret-2020-11-16-08-40', 0, '<p>Bénéficiez d’une application modulaire conçu pour la gestion quotidienne de votre PME et de votre développement commercial :</p> <div class="row" style="display: flex;flex-direction: row;align-items: center;  justify-content: space-between;"><div class="col-md-6"><ul class="pl-1-5"><li> Comptabilité & Paie</li><li>Gestion des ventes, devis & facturation</li><li>Gestion des stocks et des achats</li><li>Gestion des livraisons</li></ul></div>', '/facturation_app_client/web/frontend/img/igofacture/Cap_compte_societe.PNG', 15),
	(4, 'Essaie IGO-FACTURATION', 30, 0, 1, '2020-11-25 15:18:00', 'abed', '2020-12-11 17:22:53', 'abedr-hounsinouret-2020-11-16-08-40', 0, '<p>Bénéficiez d’une application modulaire conçu pour la gestion quotidienne de votre PME et de votre développement commercial :</p> <div class="row" style="display: flex;flex-direction: row;align-items: center;  justify-content: space-between;"><div class="col-md-6"><ul class="pl-1-5"><li> Comptabilité & Paie</li><li>Gestion des ventes, devis & facturation</li><li>Gestion des stocks et des achats</li><li>Gestion des livraisons</li></ul></div>', '/facturation_app_client/web/frontend/img/igofacture/Cap_compte_societe.PNG', 1);
/*!40000 ALTER TABLE `config_abonnement` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_abonnement_societe
CREATE TABLE IF NOT EXISTS `config_abonnement_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debutAbonnement` datetime DEFAULT NULL,
  `finAbonnement` datetime DEFAULT NULL,
  `reabonnementAuto` tinyint(1) NOT NULL,
  `estActif` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  `type_abonnement_id` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  `fichier_paie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etat_demande` tinyint(1) NOT NULL,
  `decision_admin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banque_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_22FA17B4813AF326` (`type_abonnement_id`),
  KEY `IDX_22FA17B437E080D9` (`banque_id`),
  KEY `IDX_22FA17B4FCF77503` (`societe_id`),
  CONSTRAINT `FK_22FA17B437E080D9` FOREIGN KEY (`banque_id`) REFERENCES `config_banque` (`id`),
  CONSTRAINT `FK_22FA17B4813AF326` FOREIGN KEY (`type_abonnement_id`) REFERENCES `config_abonnement` (`id`),
  CONSTRAINT `FK_22FA17B4FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_abonnement_societe : ~14 rows (environ)
/*!40000 ALTER TABLE `config_abonnement_societe` DISABLE KEYS */;
INSERT INTO `config_abonnement_societe` (`id`, `libelle`, `debutAbonnement`, `finAbonnement`, `reabonnementAuto`, `estActif`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`, `type_abonnement_id`, `duree`, `fichier_paie`, `etat_demande`, `decision_admin`, `note_details`, `banque_id`, `societe_id`) VALUES
	(1, 'Abonnement de Janvier', NULL, NULL, 0, 0, '2020-11-27 18:19:18', NULL, '2020-11-30 11:38:00', 'abedr-hounsinouret-2020-11-16-08-40', 1, 1, 2, '', 0, NULL, NULL, 2, 8),
	(2, 'Abonnement de Janvier', '2020-12-01 00:00:00', '2021-03-01 00:00:00', 0, 0, '2020-11-30 08:55:41', 'abed-abed-2020-10-27-18-03', '2020-12-01 16:17:35', 'abed-abed-2020-10-27-18-03', 0, 3, 2, 'contrat-5fc4b38e98b2f.pdf', 0, NULL, NULL, 1, 1),
	(3, 'Abonnement de Décembre', '2020-12-01 10:02:30', '2022-11-21 10:02:30', 0, 0, '2020-11-30 08:56:50', 'abed-abed-2020-10-27-18-03', '2020-12-03 14:28:23', 'abedr-hounsinouret-2020-11-16-08-40', 1, 1, 5, 'contrat-5fc4b3d30b815.pdf', 0, 'Incorrecte', NULL, 2, 4),
	(4, 'Abonnement de Janvierer', '2020-12-01 00:00:00', '2021-08-28 00:00:00', 0, 0, '2020-11-30 09:26:08', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-01 16:17:11', 'abed-abed-2020-10-27-18-03', 0, 2, 89, 'contrat-5fc4bab0766d7.pdf', 0, NULL, NULL, 1, 7),
	(5, 'ze', '2020-12-03 00:00:00', '2021-08-30 00:00:00', 0, 0, '2020-11-30 11:26:23', 'abed-abed-2020-10-27-18-03', '2020-12-11 17:17:23', 'abedr-hounsinouret-2020-11-16-08-40', 1, 2, 270, 'contrat-5fc4d6df22dff.pdf', 0, 'cool', NULL, 2, 4),
	(6, 'Abonnement de Janvier', '2020-12-11 17:11:20', '2021-09-07 17:11:20', 0, 1, '2020-12-10 11:23:07', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-11 17:17:37', 'abedr-hounsinouret-2020-11-16-08-40', 1, 2, 270, 'camscanner10092020214432-5fd2051ba57df.pdf', 0, 'cool maintenant', 'cool', 1, 4),
	(7, 'Abonnement de Janvier', NULL, NULL, 0, 0, '2020-12-10 18:34:15', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-10 18:34:14', NULL, 0, 4, 30, 'liste_masters_eligibles_pour_bourse_eiffel_202122-5fd26a270bf8c.pdf', 1, NULL, 'xfwgds', 1, 4),
	(8, 'rzefer', NULL, NULL, 0, 0, '2020-12-10 18:35:05', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-10 18:35:05', NULL, 0, 4, 30, 'liste_masters_eligibles_pour_bourse_eiffel_202122-5fd26a598d434.pdf', 1, NULL, 'dfs', 2, 4),
	(9, 'zeqrez', NULL, NULL, 0, 0, '2020-12-11 10:26:06', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-11 10:26:06', NULL, 0, 4, 30, 'camscanner10092020214432-5fd3493e7fbbc.pdf', 1, NULL, 'qffcd', 1, 4),
	(10, 'rqr', NULL, NULL, 0, 0, '2020-12-11 10:30:14', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-11 10:30:14', NULL, 0, 1, 720, 'liste_masters_eligibles_pour_bourse_eiffel_202122-5fd34a368d824.pdf', 1, NULL, 'fdqfd', 1, 4),
	(11, 'qecdf', NULL, NULL, 0, 0, '2020-12-11 10:30:42', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-11 10:30:42', NULL, 0, 1, 720, 'liste_masters_eligibles_pour_bourse_eiffel_202122-5fd34a5259649.pdf', 1, NULL, 'qfq', 2, 4),
	(12, 'qfd', '2020-12-14 14:00:08', '2021-03-14 14:00:08', 0, 1, '2020-12-11 10:30:59', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-14 14:00:08', 'abedr-hounsinouret-2020-11-16-08-40', 0, 3, 90, 'liste_masters_eligibles_pour_bourse_eiffel_202122-5fd34a6349df3.pdf', 0, 'autoriser', 'qdsfds', 2, 4),
	(13, 'ze', '2020-12-14 00:00:00', '2021-01-13 00:00:00', 0, 0, '2020-12-11 11:17:25', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-14 08:40:03', 'abedr-hounsinouret-2020-11-16-08-40', 0, 4, 30, 'signatureabed-5fd3554591e5c.pdf', 0, 'dssgfd', 'efcer', 2, 4),
	(14, 'dsd', NULL, NULL, 0, 0, '2020-12-16 13:47:42', 'hounsfdinou-abedd-2020-12-16-10-23', '2020-12-16 13:47:36', NULL, 0, 3, 90, 'vademecum_eiffel_2021_fr-5fda0ffdf0e0d.pdf', 1, NULL, NULL, 1, 9);
/*!40000 ALTER TABLE `config_abonnement_societe` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_agence
CREATE TABLE IF NOT EXISTS `config_agence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) DEFAULT NULL,
  `pays_sise_id` int(11) DEFAULT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `numero_mcf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `est_actif` tinyint(1) NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  `etat_demande` tinyint(1) DEFAULT NULL,
  `port_serveur` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_12A0F66B77153098` (`code`),
  UNIQUE KEY `UNIQ_12A0F66BA5E68FAB` (`port_serveur`),
  KEY `IDX_12A0F66BFCF77503` (`societe_id`),
  KEY `IDX_12A0F66B5840AB63` (`pays_sise_id`),
  CONSTRAINT `FK_12A0F66B5840AB63` FOREIGN KEY (`pays_sise_id`) REFERENCES `config_pays_lang` (`id`),
  CONSTRAINT `FK_12A0F66BFCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_agence : ~13 rows (environ)
/*!40000 ALTER TABLE `config_agence` DISABLE KEYS */;
INSERT INTO `config_agence` (`id`, `societe_id`, `pays_sise_id`, `code`, `libelle`, `created`, `numero_mcf`, `est_actif`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`, `etat_demande`, `port_serveur`, `ville`) VALUES
	(1, 1, 1, 'AG01', 'Agence 1', '2020-03-05 15:43:56', 'ED040025', 0, 'absded-houdsfnsinou-2020-11-12-17-18', '2020-12-14 13:51:10', 'abedr-hounsinouret-2020-11-16-08-40', 0, 0, '81', 'Parakou'),
	(2, 1, 3, 'AG02', 'Agence 2', '2020-03-05 15:44:21', 'ED040026', 0, 'absded-houdsfnsinou-2020-11-12-17-18', '2020-12-14 13:50:51', 'abedr-hounsinouret-2020-11-16-08-40', 0, 0, '58', 'Parakou'),
	(3, 4, 1, 'AG03', 'Agence 3', '2020-03-06 17:26:48', 'ED040027', 1, 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-17 16:59:54', 'abedr-hounsinouret-2020-11-16-08-40', 1, 0, '55', 'Parakou'),
	(23, 4, 1, 'zef', 'qfdef', '2020-10-23 15:37:21', 'sqfdqsf', 0, 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-17 16:59:54', 'abedr-hounsinouret-2020-11-16-08-40', 0, 0, '1', 'Parakou'),
	(25, 1, 37, 'AG00', 'Agence 3', '2020-03-06 17:26:48', 'ED040027', 0, 'absded-houdsfnsinou-2020-11-12-17-18', '2020-11-20 09:42:16', 'abed-abed-2020-10-27-18-03', 0, 0, '77', 'Parakou'),
	(27, 4, 1, 'd', 'Agence 3', '2020-03-06 17:26:48', 'ED040027', 0, 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-17 16:59:54', 'abedr-hounsinouret-2020-11-16-08-40', 1, 0, '11', 'Parakou'),
	(28, 7, 2, 'AG07', 'agr2', '2020-10-28 09:02:55', '532652', 0, 'abed-abed-2020-10-27-18-03', '2020-11-20 09:58:52', 'abed-abed-2020-10-27-18-03', 0, 0, '78', 'Parakou'),
	(37, 1, 15, 'ST01AG76482', 'Agence5', '2020-11-13 11:45:55', 'lecon', 0, 'absded-houdsfnsinou-2020-11-12-17-18', '2020-11-20 09:44:09', 'abed-abed-2020-10-27-18-03', 0, 0, '87', 'CALAVI2'),
	(38, 1, 31, 'ST01AG91508', 'Agence6', '2020-11-13 11:48:19', 'ezgzt', 0, 'absded-houdsfnsinou-2020-11-12-17-18', '2020-11-18 11:37:45', 'absded-houdsfnsinou-2020-11-12-17-18', 0, 1, '89', 'CALAVI3'),
	(39, 8, 488, 'AG14O', 'Agence principal', '2020-11-16 10:35:13', 'numeroMCF', 0, 'abedr-hounsinouret-2020-11-16-08-40', '2020-11-19 18:35:54', 'abed-abed-2020-10-27-18-03', 0, 1, NULL, NULL),
	(40, 4, 1, 'STN01AG90416', 'ssqf', '2020-11-27 10:15:27', 'dsfv', 0, 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-17 16:59:54', 'abedr-hounsinouret-2020-11-16-08-40', 0, NULL, '12', 'dsfg'),
	(41, 4, 37, 'STN01AG24572', 'abed1', '2020-12-15 16:42:11', 'erfc', 0, 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-17 16:59:54', 'abedr-hounsinouret-2020-11-16-08-40', 0, NULL, NULL, 'abomeytr'),
	(42, 9, NULL, 'SOT5AGPR13', 'Agence principal', '2020-12-16 10:48:27', 'numeroMCF', 1, 'hounsfdinou-abedd-2020-12-16-10-23', '2020-12-21 12:05:46', 'hounsfdinou-abedd-2020-12-16-10-23', 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `config_agence` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_banque
CREATE TABLE IF NOT EXISTS `config_banque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_banque : ~2 rows (environ)
/*!40000 ALTER TABLE `config_banque` DISABLE KEYS */;
INSERT INTO `config_banque` (`id`, `libelle`, `slug`, `estSupprimer`, `createdAt`, `updateAt`) VALUES
	(1, 'NSIA', 'dsqf', 0, '2020-11-19 12:10:01', '2020-11-19 12:10:03'),
	(2, 'BGFI', 'dzsv', 0, '2020-11-19 12:39:25', '2020-11-19 12:39:26');
/*!40000 ALTER TABLE `config_banque` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_devise
CREATE TABLE IF NOT EXISTS `config_devise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbole` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_devise : ~3 rows (environ)
/*!40000 ALTER TABLE `config_devise` DISABLE KEYS */;
INSERT INTO `config_devise` (`id`, `code`, `libelle`, `symbole`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'XOF', 'CFA', 'CFA', NULL, '', NULL, NULL, 0),
	(2, 'USD', 'US Dollars', '$', NULL, '', NULL, NULL, 0),
	(3, 'EUR', 'Euro', '€', NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_devise` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_etat
CREATE TABLE IF NOT EXISTS `config_etat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_etat : ~6 rows (environ)
/*!40000 ALTER TABLE `config_etat` DISABLE KEYS */;
INSERT INTO `config_etat` (`id`, `code`, `libelle`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'BR', 'Brouillon', '2020-11-11 16:59:30', '', NULL, NULL, 0),
	(2, 'EC', 'En cours', '2020-11-11 16:59:31', '', NULL, NULL, 0),
	(3, 'VA', 'Validé', '2020-11-11 16:59:32', '', NULL, NULL, 0),
	(4, 'EA', 'En attente', '2020-11-11 16:59:32', '', NULL, NULL, 0),
	(5, 'TR', 'Terminé', '2020-11-11 16:59:33', '', NULL, NULL, 0),
	(6, 'FAV', 'Facture à valider', '2020-11-11 16:59:34', '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_etat` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_lang
CREATE TABLE IF NOT EXISTS `config_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `iso_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `date_format_lite` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `date_format_full` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `is_rtl` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_lang : ~2 rows (environ)
/*!40000 ALTER TABLE `config_lang` DISABLE KEYS */;
INSERT INTO `config_lang` (`id`, `name`, `active`, `iso_code`, `language_code`, `locale`, `date_format_lite`, `date_format_full`, `is_rtl`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'Français (French)', 1, 'fr', 'fr', 'fr-FR', 'd/m/Y', 'd/m/Y H:i:s', 0, NULL, NULL, NULL, NULL, NULL),
	(2, 'English (English)', 1, 'en', 'en-us', 'en-US', 'm/d/Y', 'm/d/Y H:i:s', 0, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `config_lang` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_mode_paiement
CREATE TABLE IF NOT EXISTS `config_mode_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_mode_paiement : ~6 rows (environ)
/*!40000 ALTER TABLE `config_mode_paiement` DISABLE KEYS */;
INSERT INTO `config_mode_paiement` (`id`, `code`, `libelle`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'E', 'Espèces', NULL, '', NULL, NULL, 0),
	(2, 'C', 'Carte bancaire', NULL, '', NULL, NULL, 0),
	(3, 'D', 'Chèque', NULL, '', NULL, NULL, 0),
	(4, 'V', 'Virement bancaire', NULL, '', NULL, NULL, 0),
	(5, 'M', 'Mobile Money', NULL, '', NULL, NULL, 0),
	(6, 'A', 'Autre', NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_mode_paiement` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_mode_reglement
CREATE TABLE IF NOT EXISTS `config_mode_reglement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_mode_reglement : ~0 rows (environ)
/*!40000 ALTER TABLE `config_mode_reglement` DISABLE KEYS */;
/*!40000 ALTER TABLE `config_mode_reglement` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_pays
CREATE TABLE IF NOT EXISTS `config_pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) DEFAULT NULL,
  `iso_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `call_prefix` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `contains_states` tinyint(1) NOT NULL,
  `need_zip_code` tinyint(1) NOT NULL,
  `need_identification_number` tinyint(1) NOT NULL,
  `zip_code_format` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `display_tax_label` tinyint(1) NOT NULL,
  `taux_tva` double DEFAULT NULL,
  `taux_aib` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_829140B79F2C3FAB` (`zone_id`),
  CONSTRAINT `FK_829140B79F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `config_zone` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_pays : ~244 rows (environ)
/*!40000 ALTER TABLE `config_pays` DISABLE KEYS */;
INSERT INTO `config_pays` (`id`, `zone_id`, `iso_code`, `call_prefix`, `active`, `contains_states`, `need_zip_code`, `need_identification_number`, `zip_code_format`, `display_tax_label`, `taux_tva`, `taux_aib`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 1, 'DE', 49, 0, 0, 1, 0, 'NNNNN', 1, 80, 20, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(2, 1, 'AT', 43, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(3, 1, 'BE', 32, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(4, 2, 'CA', 1, 0, 1, 1, 0, 'LNL NLN', 0, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(5, 3, 'CN', 86, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(6, 1, 'ES', 34, 0, 0, 1, 1, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(7, 1, 'FI', 358, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(8, 1, 'FR', 33, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(9, 1, 'GR', 30, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(10, 1, 'IT', 39, 0, 1, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(11, 3, 'JP', 81, 0, 1, 1, 0, 'NNN-NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(12, 1, 'LU', 352, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(13, 1, 'NL', 31, 0, 0, 1, 0, 'NNNN LL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(14, 1, 'PL', 48, 0, 0, 1, 0, 'NN-NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(15, 1, 'PT', 351, 0, 0, 1, 0, 'NNNN-NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(16, 1, 'CZ', 420, 0, 0, 1, 0, 'NNN NN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(17, 1, 'GB', 44, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(18, 1, 'SE', 46, 0, 0, 1, 0, 'NNN NN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(19, 7, 'CH', 41, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(20, 1, 'DK', 45, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(21, 2, 'US', 1, 0, 1, 1, 0, 'NNNNN', 0, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(22, 3, 'HK', 852, 0, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(23, 7, 'NO', 47, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(24, 5, 'AU', 61, 0, 1, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(25, 3, 'SG', 65, 0, 0, 1, 0, 'NNNNNN', 1, 16, 5, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(26, 1, 'IE', 353, 0, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(27, 5, 'NZ', 64, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(28, 3, 'KR', 82, 0, 0, 1, 0, 'NNN-NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(29, 3, 'IL', 972, 0, 0, 1, 0, 'NNNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(30, 4, 'ZA', 27, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(31, 4, 'NG', 234, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(32, 4, 'CI', 225, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(33, 4, 'TG', 228, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(34, 6, 'BO', 591, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(35, 4, 'MU', 230, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(36, 1, 'RO', 40, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(37, 1, 'SK', 421, 0, 0, 1, 0, 'NNN NN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(38, 4, 'DZ', 213, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(39, 2, 'AS', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(40, 7, 'AD', 376, 0, 0, 1, 0, 'CNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(41, 4, 'AO', 244, 0, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(42, 8, 'AI', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(43, 2, 'AG', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(44, 6, 'AR', 54, 0, 1, 1, 0, 'LNNNNLLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(45, 3, 'AM', 374, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(46, 8, 'AW', 297, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(47, 3, 'AZ', 994, 0, 0, 1, 0, 'CNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(48, 2, 'BS', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(49, 3, 'BH', 973, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(50, 3, 'BD', 880, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(51, 2, 'BB', 0, 0, 0, 1, 0, 'CNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(52, 7, 'BY', 0, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(53, 8, 'BZ', 501, 0, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(54, 4, 'BJ', 229, 1, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(55, 2, 'BM', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(56, 3, 'BT', 975, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(57, 4, 'BW', 267, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(58, 6, 'BR', 55, 0, 0, 1, 0, 'NNNNN-NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(59, 3, 'BN', 673, 0, 0, 1, 0, 'LLNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(60, 4, 'BF', 226, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(61, 3, 'MM', 95, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(62, 4, 'BI', 257, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(63, 3, 'KH', 855, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(64, 4, 'CM', 237, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(65, 4, 'CV', 238, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(66, 4, 'CF', 236, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(67, 4, 'TD', 235, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(68, 6, 'CL', 56, 0, 0, 1, 0, 'NNN-NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(69, 6, 'CO', 57, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(70, 4, 'KM', 269, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(71, 4, 'CD', 242, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(72, 4, 'CG', 243, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(73, 8, 'CR', 506, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(74, 7, 'HR', 385, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(75, 8, 'CU', 53, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(76, 1, 'CY', 357, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(77, 4, 'DJ', 253, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(78, 8, 'DM', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(79, 8, 'DO', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(80, 3, 'TL', 670, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(81, 6, 'EC', 593, 0, 0, 1, 0, 'CNNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(82, 4, 'EG', 20, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(83, 8, 'SV', 503, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(84, 4, 'GQ', 240, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(85, 4, 'ER', 291, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(86, 1, 'EE', 372, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(87, 4, 'ET', 251, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(88, 8, 'FK', 0, 0, 0, 1, 0, 'LLLL NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(89, 7, 'FO', 298, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(90, 5, 'FJ', 679, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(91, 4, 'GA', 241, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(92, 4, 'GM', 220, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(93, 3, 'GE', 995, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(94, 4, 'GH', 233, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(95, 8, 'GD', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(96, 7, 'GL', 299, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(97, 7, 'GI', 350, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(98, 8, 'GP', 590, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(99, 5, 'GU', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(100, 8, 'GT', 502, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(101, 7, 'GG', 0, 0, 0, 1, 0, 'LLN NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(102, 4, 'GN', 224, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(103, 4, 'GW', 245, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(104, 6, 'GY', 592, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(105, 8, 'HT', 509, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(106, 5, 'HM', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(107, 7, 'VA', 379, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(108, 8, 'HN', 504, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(109, 7, 'IS', 354, 0, 0, 1, 0, 'NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(110, 3, 'IN', 91, 0, 0, 1, 0, 'NNN NNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(111, 3, 'ID', 62, 0, 1, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(112, 3, 'IR', 98, 0, 0, 1, 0, 'NNNNN-NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(113, 3, 'IQ', 964, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(114, 7, 'IM', 0, 0, 0, 1, 0, 'CN NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(115, 8, 'JM', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(116, 7, 'JE', 0, 0, 0, 1, 0, 'CN NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(117, 3, 'JO', 962, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(118, 3, 'KZ', 7, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(119, 4, 'KE', 254, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(120, 5, 'KI', 686, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(121, 3, 'KP', 850, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(122, 3, 'KW', 965, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(123, 3, 'KG', 996, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(124, 3, 'LA', 856, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(125, 1, 'LV', 371, 0, 0, 1, 0, 'C-NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(126, 3, 'LB', 961, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(127, 4, 'LS', 266, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(128, 4, 'LR', 231, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(129, 4, 'LY', 218, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(130, 1, 'LI', 423, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(131, 1, 'LT', 370, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(132, 3, 'MO', 853, 0, 0, 0, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(133, 7, 'MK', 389, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(134, 4, 'MG', 261, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(135, 4, 'MW', 265, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(136, 3, 'MY', 60, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(137, 3, 'MV', 960, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(138, 4, 'ML', 223, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(139, 1, 'MT', 356, 0, 0, 1, 0, 'LLL NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(140, 5, 'MH', 692, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(141, 8, 'MQ', 596, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(142, 4, 'MR', 222, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(143, 1, 'HU', 36, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(144, 4, 'YT', 262, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(145, 2, 'MX', 52, 0, 1, 1, 1, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(146, 5, 'FM', 691, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(147, 7, 'MD', 373, 0, 0, 1, 0, 'C-NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(148, 7, 'MC', 377, 0, 0, 1, 0, '980NN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(149, 3, 'MN', 976, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(150, 7, 'ME', 382, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(151, 8, 'MS', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(152, 4, 'MA', 212, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(153, 4, 'MZ', 258, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(154, 4, 'NA', 264, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(155, 5, 'NR', 674, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(156, 3, 'NP', 977, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(157, 8, 'AN', 599, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(158, 5, 'NC', 687, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(159, 8, 'NI', 505, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(160, 4, 'NE', 227, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(161, 5, 'NU', 683, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(162, 5, 'NF', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(163, 5, 'MP', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(164, 3, 'OM', 968, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(165, 3, 'PK', 92, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(166, 5, 'PW', 680, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(167, 3, 'PS', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(168, 8, 'PA', 507, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(169, 5, 'PG', 675, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(170, 6, 'PY', 595, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(171, 6, 'PE', 51, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(172, 3, 'PH', 63, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(173, 5, 'PN', 0, 0, 0, 1, 0, 'LLLL NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(174, 8, 'PR', 0, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(175, 3, 'QA', 974, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(176, 4, 'RE', 262, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(177, 7, 'RU', 7, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(178, 4, 'RW', 250, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(179, 8, 'BL', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(180, 8, 'KN', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(181, 8, 'LC', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(182, 8, 'MF', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(183, 8, 'PM', 508, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(184, 8, 'VC', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(185, 5, 'WS', 685, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(186, 7, 'SM', 378, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(187, 4, 'ST', 239, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(188, 3, 'SA', 966, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(189, 4, 'SN', 221, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(190, 7, 'RS', 381, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(191, 4, 'SC', 248, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(192, 4, 'SL', 232, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(193, 1, 'SI', 386, 0, 0, 1, 0, 'C-NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(194, 5, 'SB', 677, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(195, 4, 'SO', 252, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(196, 8, 'GS', 0, 0, 0, 1, 0, 'LLLL NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(197, 3, 'LK', 94, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(198, 4, 'SD', 249, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(199, 8, 'SR', 597, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(200, 7, 'SJ', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(201, 4, 'SZ', 268, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(202, 3, 'SY', 963, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(203, 3, 'TW', 886, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(204, 3, 'TJ', 992, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(205, 4, 'TZ', 255, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(206, 3, 'TH', 66, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(207, 5, 'TK', 690, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(208, 5, 'TO', 676, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(209, 6, 'TT', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(210, 4, 'TN', 216, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(211, 7, 'TR', 90, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(212, 3, 'TM', 993, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(213, 8, 'TC', 0, 0, 0, 1, 0, 'LLLL NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(214, 5, 'TV', 688, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(215, 4, 'UG', 256, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(216, 1, 'UA', 380, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(217, 3, 'AE', 971, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(218, 6, 'UY', 598, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(219, 3, 'UZ', 998, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(220, 5, 'VU', 678, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(221, 6, 'VE', 58, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(222, 3, 'VN', 84, 0, 0, 1, 0, 'NNNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(223, 2, 'VG', 0, 0, 0, 1, 0, 'CNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(224, 2, 'VI', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(225, 5, 'WF', 681, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(226, 4, 'EH', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(227, 3, 'YE', 967, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(228, 4, 'ZM', 260, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(229, 4, 'ZW', 263, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(230, 7, 'AL', 355, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(231, 3, 'AF', 93, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(232, 5, 'AQ', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(233, 1, 'BA', 387, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(234, 5, 'BV', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(235, 5, 'IO', 0, 0, 0, 1, 0, 'LLLL NLL', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(236, 1, 'BG', 359, 0, 0, 1, 0, 'NNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(237, 8, 'KY', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(238, 3, 'CX', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(239, 3, 'CC', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(240, 5, 'CK', 682, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(241, 6, 'GF', 594, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(242, 5, 'PF', 689, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(243, 5, 'TF', 0, 0, 0, 1, 0, '', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0),
	(244, 7, 'AX', 0, 0, 0, 1, 0, 'NNNNN', 1, 18, 8, '2020-11-11 10:57:34', NULL, NULL, NULL, 0);
/*!40000 ALTER TABLE `config_pays` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_pays_lang
CREATE TABLE IF NOT EXISTS `config_pays_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89FF70A6E44244` (`pays_id`),
  KEY `IDX_89FF70B213FA4` (`lang_id`),
  CONSTRAINT `FK_89FF70A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `config_pays` (`id`),
  CONSTRAINT `FK_89FF70B213FA4` FOREIGN KEY (`lang_id`) REFERENCES `config_lang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=489 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_pays_lang : ~488 rows (environ)
/*!40000 ALTER TABLE `config_pays_lang` DISABLE KEYS */;
INSERT INTO `config_pays_lang` (`id`, `pays_id`, `lang_id`, `name`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 1, 1, 'Allemagne', '2020-11-11 10:56:54', NULL, '2020-11-23 10:28:26', 'abedr-hounsinouret-2020-11-16-08-40', 0),
	(2, 1, 2, 'Germany', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(3, 2, 1, 'Autriche', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(4, 2, 2, 'Austria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(5, 3, 1, 'Belgique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(6, 3, 2, 'Belgium', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(7, 4, 1, 'Canada', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(8, 4, 2, 'Canada', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(9, 5, 1, 'Chine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(10, 5, 2, 'China', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(11, 6, 1, 'Espagne', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(12, 6, 2, 'Spain', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(13, 7, 1, 'Finlande', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(14, 7, 2, 'Finland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(15, 8, 1, 'France', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(16, 8, 2, 'France', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(17, 9, 1, 'Grèce', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(18, 9, 2, 'Greece', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(19, 10, 1, 'Italie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(20, 10, 2, 'Italy', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(21, 11, 1, 'Japon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(22, 11, 2, 'Japan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(23, 12, 1, 'Luxembourg', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(24, 12, 2, 'Luxembourg', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(25, 13, 1, 'Pays-Bas', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(26, 13, 2, 'Netherlands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(27, 14, 1, 'Pologne', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(28, 14, 2, 'Poland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(29, 15, 1, 'Portugal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(30, 15, 2, 'Portugal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(31, 16, 1, 'République Tchèque', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(32, 16, 2, 'Czech Republic', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(33, 17, 1, 'Royaume-Uni', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(34, 17, 2, 'United Kingdom', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(35, 18, 1, 'Suède', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(36, 18, 2, 'Sweden', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(37, 19, 1, 'Suisse', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(38, 19, 2, 'Switzerland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(39, 20, 1, 'Danemark', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(40, 20, 2, 'Denmark', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(41, 21, 1, 'États-Unis', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(42, 21, 2, 'United States', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(43, 22, 1, 'R.A.S. Chinoise De Hong Kong', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(44, 22, 2, 'Hong Kong SAR China', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(45, 23, 1, 'Norvège', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(46, 23, 2, 'Norway', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(47, 24, 1, 'Australie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(48, 24, 2, 'Australia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(49, 25, 1, 'Singapour', '2020-11-11 10:56:54', NULL, '2020-11-11 11:31:24', 'abed-abed-2020-10-27-18-03', 0),
	(50, 25, 2, 'Singapore', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(51, 26, 1, 'Irlande', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(52, 26, 2, 'Ireland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(53, 27, 1, 'Nouvelle-Zélande', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(54, 27, 2, 'New Zealand', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(55, 28, 1, 'Corée Du Sud', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(56, 28, 2, 'South Korea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(57, 29, 1, 'Israël', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(58, 29, 2, 'Israel', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(59, 30, 1, 'Afrique Du Sud', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(60, 30, 2, 'South Africa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(61, 31, 1, 'Nigéria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(62, 31, 2, 'Nigeria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(63, 32, 1, 'Côte D’Ivoire', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(64, 32, 2, 'Côte D’Ivoire', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(65, 33, 1, 'Togo', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(66, 33, 2, 'Togo', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(67, 34, 1, 'Bolivie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(68, 34, 2, 'Bolivia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(69, 35, 1, 'Maurice', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(70, 35, 2, 'Mauritius', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(71, 36, 1, 'Roumanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(72, 36, 2, 'Romania', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(73, 37, 1, 'Slovaquie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(74, 37, 2, 'Slovakia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(75, 38, 1, 'Algérie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(76, 38, 2, 'Algeria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(77, 39, 1, 'Samoa Américaines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(78, 39, 2, 'American Samoa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(79, 40, 1, 'Andorre', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(80, 40, 2, 'Andorra', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(81, 41, 1, 'Angola', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(82, 41, 2, 'Angola', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(83, 42, 1, 'Anguilla', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(84, 42, 2, 'Anguilla', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(85, 43, 1, 'Antigua-et-Barbuda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(86, 43, 2, 'Antigua & Barbuda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(87, 44, 1, 'Argentine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(88, 44, 2, 'Argentina', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(89, 45, 1, 'Arménie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(90, 45, 2, 'Armenia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(91, 46, 1, 'Aruba', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(92, 46, 2, 'Aruba', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(93, 47, 1, 'Azerbaïdjan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(94, 47, 2, 'Azerbaijan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(95, 48, 1, 'Bahamas', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(96, 48, 2, 'Bahamas', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(97, 49, 1, 'Bahreïn', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(98, 49, 2, 'Bahrain', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(99, 50, 1, 'Bangladesh', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(100, 50, 2, 'Bangladesh', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(101, 51, 1, 'Barbade', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(102, 51, 2, 'Barbados', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(103, 52, 1, 'Biélorussie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(104, 52, 2, 'Belarus', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(105, 53, 1, 'Belize', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(106, 53, 2, 'Belize', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(107, 54, 1, 'Bénin', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(108, 54, 2, 'Benin', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(109, 55, 1, 'Bermudes', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(110, 55, 2, 'Bermuda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(111, 56, 1, 'Bhoutan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(112, 56, 2, 'Bhutan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(113, 57, 1, 'Botswana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(114, 57, 2, 'Botswana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(115, 58, 1, 'Brésil', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(116, 58, 2, 'Brazil', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(117, 59, 1, 'Brunéi Darussalam', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(118, 59, 2, 'Brunei', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(119, 60, 1, 'Burkina Faso', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(120, 60, 2, 'Burkina Faso', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(121, 61, 1, 'Myanmar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(122, 61, 2, 'Myanmar (Burma)', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(123, 62, 1, 'Burundi', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(124, 62, 2, 'Burundi', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(125, 63, 1, 'Cambodge', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(126, 63, 2, 'Cambodia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(127, 64, 1, 'Cameroun', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(128, 64, 2, 'Cameroon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(129, 65, 1, 'Cap-Vert', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(130, 65, 2, 'Cape Verde', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(131, 66, 1, 'République Centrafricaine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(132, 66, 2, 'Central African Republic', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(133, 67, 1, 'Tchad', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(134, 67, 2, 'Chad', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(135, 68, 1, 'Chili', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(136, 68, 2, 'Chile', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(137, 69, 1, 'Colombie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(138, 69, 2, 'Colombia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(139, 70, 1, 'Comores', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(140, 70, 2, 'Comoros', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(141, 71, 1, 'Congo-Kinshasa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(142, 71, 2, 'Congo - Kinshasa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(143, 72, 1, 'Congo-Brazzaville', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(144, 72, 2, 'Congo - Brazzaville', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(145, 73, 1, 'Costa Rica', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(146, 73, 2, 'Costa Rica', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(147, 74, 1, 'Croatie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(148, 74, 2, 'Croatia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(149, 75, 1, 'Cuba', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(150, 75, 2, 'Cuba', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(151, 76, 1, 'Chypre', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(152, 76, 2, 'Cyprus', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(153, 77, 1, 'Djibouti', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(154, 77, 2, 'Djibouti', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(155, 78, 1, 'Dominique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(156, 78, 2, 'Dominica', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(157, 79, 1, 'République Dominicaine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(158, 79, 2, 'Dominican Republic', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(159, 80, 1, 'Timor Oriental', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(160, 80, 2, 'Timor-Leste', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(161, 81, 1, 'Équateur', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(162, 81, 2, 'Ecuador', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(163, 82, 1, 'Égypte', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(164, 82, 2, 'Egypt', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(165, 83, 1, 'El Salvador', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(166, 83, 2, 'El Salvador', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(167, 84, 1, 'Guinée équatoriale', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(168, 84, 2, 'Equatorial Guinea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(169, 85, 1, 'Érythrée', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(170, 85, 2, 'Eritrea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(171, 86, 1, 'Estonie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(172, 86, 2, 'Estonia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(173, 87, 1, 'Éthiopie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(174, 87, 2, 'Ethiopia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(175, 88, 1, 'Îles Malouines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(176, 88, 2, 'Falkland Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(177, 89, 1, 'Îles Féroé', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(178, 89, 2, 'Faroe Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(179, 90, 1, 'Fidji', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(180, 90, 2, 'Fiji', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(181, 91, 1, 'Gabon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(182, 91, 2, 'Gabon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(183, 92, 1, 'Gambie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(184, 92, 2, 'Gambia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(185, 93, 1, 'Géorgie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(186, 93, 2, 'Georgia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(187, 94, 1, 'Ghana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(188, 94, 2, 'Ghana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(189, 95, 1, 'Grenade', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(190, 95, 2, 'Grenada', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(191, 96, 1, 'Groenland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(192, 96, 2, 'Greenland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(193, 97, 1, 'Gibraltar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(194, 97, 2, 'Gibraltar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(195, 98, 1, 'Guadeloupe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(196, 98, 2, 'Guadeloupe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(197, 99, 1, 'Guam', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(198, 99, 2, 'Guam', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(199, 100, 1, 'Guatemala', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(200, 100, 2, 'Guatemala', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(201, 101, 1, 'Guernesey', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(202, 101, 2, 'Guernsey', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(203, 102, 1, 'Guinée', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(204, 102, 2, 'Guinea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(205, 103, 1, 'Guinée-Bissau', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(206, 103, 2, 'Guinea-Bissau', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(207, 104, 1, 'Guyana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(208, 104, 2, 'Guyana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(209, 105, 1, 'Haïti', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(210, 105, 2, 'Haiti', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(211, 106, 1, 'Îles Heard Et McDonald', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(212, 106, 2, 'Heard & McDonald Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(213, 107, 1, 'État De La Cité Du Vatican', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(214, 107, 2, 'Vatican City', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(215, 108, 1, 'Honduras', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(216, 108, 2, 'Honduras', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(217, 109, 1, 'Islande', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(218, 109, 2, 'Iceland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(219, 110, 1, 'Inde', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(220, 110, 2, 'India', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(221, 111, 1, 'Indonésie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(222, 111, 2, 'Indonesia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(223, 112, 1, 'Iran', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(224, 112, 2, 'Iran', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(225, 113, 1, 'Irak', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(226, 113, 2, 'Iraq', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(227, 114, 1, 'Île De Man', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(228, 114, 2, 'Isle Of Man', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(229, 115, 1, 'Jamaïque', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(230, 115, 2, 'Jamaica', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(231, 116, 1, 'Jersey', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(232, 116, 2, 'Jersey', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(233, 117, 1, 'Jordanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(234, 117, 2, 'Jordan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(235, 118, 1, 'Kazakhstan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(236, 118, 2, 'Kazakhstan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(237, 119, 1, 'Kenya', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(238, 119, 2, 'Kenya', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(239, 120, 1, 'Kiribati', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(240, 120, 2, 'Kiribati', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(241, 121, 1, 'Corée Du Nord', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(242, 121, 2, 'North Korea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(243, 122, 1, 'Koweït', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(244, 122, 2, 'Kuwait', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(245, 123, 1, 'Kirghizistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(246, 123, 2, 'Kyrgyzstan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(247, 124, 1, 'Laos', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(248, 124, 2, 'Laos', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(249, 125, 1, 'Lettonie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(250, 125, 2, 'Latvia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(251, 126, 1, 'Liban', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(252, 126, 2, 'Lebanon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(253, 127, 1, 'Lesotho', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(254, 127, 2, 'Lesotho', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(255, 128, 1, 'Libéria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(256, 128, 2, 'Liberia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(257, 129, 1, 'Libye', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(258, 129, 2, 'Libya', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(259, 130, 1, 'Liechtenstein', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(260, 130, 2, 'Liechtenstein', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(261, 131, 1, 'Lituanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(262, 131, 2, 'Lithuania', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(263, 132, 1, 'R.A.S. Chinoise De Macao', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(264, 132, 2, 'Macau SAR China', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(265, 133, 1, 'Macédoine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(266, 133, 2, 'Macedonia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(267, 134, 1, 'Madagascar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(268, 134, 2, 'Madagascar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(269, 135, 1, 'Malawi', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(270, 135, 2, 'Malawi', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(271, 136, 1, 'Malaisie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(272, 136, 2, 'Malaysia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(273, 137, 1, 'Maldives', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(274, 137, 2, 'Maldives', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(275, 138, 1, 'Mali', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(276, 138, 2, 'Mali', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(277, 139, 1, 'Malte', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(278, 139, 2, 'Malta', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(279, 140, 1, 'Îles Marshall', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(280, 140, 2, 'Marshall Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(281, 141, 1, 'Martinique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(282, 141, 2, 'Martinique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(283, 142, 1, 'Mauritanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(284, 142, 2, 'Mauritania', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(285, 143, 1, 'Hongrie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(286, 143, 2, 'Hungary', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(287, 144, 1, 'Mayotte', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(288, 144, 2, 'Mayotte', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(289, 145, 1, 'Mexique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(290, 145, 2, 'Mexico', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(291, 146, 1, 'États Fédérés De Micronésie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(292, 146, 2, 'Micronesia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(293, 147, 1, 'Moldavie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(294, 147, 2, 'Moldova', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(295, 148, 1, 'Monaco', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(296, 148, 2, 'Monaco', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(297, 149, 1, 'Mongolie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(298, 149, 2, 'Mongolia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(299, 150, 1, 'Monténégro', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(300, 150, 2, 'Montenegro', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(301, 151, 1, 'Montserrat', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(302, 151, 2, 'Montserrat', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(303, 152, 1, 'Maroc', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(304, 152, 2, 'Morocco', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(305, 153, 1, 'Mozambique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(306, 153, 2, 'Mozambique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(307, 154, 1, 'Namibie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(308, 154, 2, 'Namibia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(309, 155, 1, 'Nauru', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(310, 155, 2, 'Nauru', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(311, 156, 1, 'Népal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(312, 156, 2, 'Nepal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(313, 157, 1, 'Antilles Néerlandaises', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(314, 157, 2, 'Netherlands Antilles', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(315, 158, 1, 'Nouvelle-Calédonie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(316, 158, 2, 'New Caledonia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(317, 159, 1, 'Nicaragua', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(318, 159, 2, 'Nicaragua', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(319, 160, 1, 'Niger', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(320, 160, 2, 'Niger', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(321, 161, 1, 'Niue', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(322, 161, 2, 'Niue', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(323, 162, 1, 'Île Norfolk', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(324, 162, 2, 'Norfolk Island', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(325, 163, 1, 'Îles Mariannes Du Nord', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(326, 163, 2, 'Northern Mariana Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(327, 164, 1, 'Oman', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(328, 164, 2, 'Oman', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(329, 165, 1, 'Pakistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(330, 165, 2, 'Pakistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(331, 166, 1, 'Palaos', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(332, 166, 2, 'Palau', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(333, 167, 1, 'Territoires Palestiniens', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(334, 167, 2, 'Palestinian Territories', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(335, 168, 1, 'Panama', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(336, 168, 2, 'Panama', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(337, 169, 1, 'Papouasie-Nouvelle-Guinée', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(338, 169, 2, 'Papua New Guinea', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(339, 170, 1, 'Paraguay', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(340, 170, 2, 'Paraguay', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(341, 171, 1, 'Pérou', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(342, 171, 2, 'Peru', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(343, 172, 1, 'Philippines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(344, 172, 2, 'Philippines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(345, 173, 1, 'Pitcairn', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(346, 173, 2, 'Pitcairn Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(347, 174, 1, 'Porto Rico', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(348, 174, 2, 'Puerto Rico', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(349, 175, 1, 'Qatar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(350, 175, 2, 'Qatar', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(351, 176, 1, 'La Réunion', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(352, 176, 2, 'Réunion', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(353, 177, 1, 'Russie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(354, 177, 2, 'Russia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(355, 178, 1, 'Rwanda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(356, 178, 2, 'Rwanda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(357, 179, 1, 'Saint-Barthélemy', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(358, 179, 2, 'St. Barthélemy', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(359, 180, 1, 'Saint-Christophe-et-Niévès', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(360, 180, 2, 'St. Kitts & Nevis', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(361, 181, 1, 'Sainte-Lucie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(362, 181, 2, 'St. Lucia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(363, 182, 1, 'Saint-Martin (partie Française)', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(364, 182, 2, 'St. Martin', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(365, 183, 1, 'Saint-Pierre-et-Miquelon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(366, 183, 2, 'St. Pierre & Miquelon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(367, 184, 1, 'Saint-Vincent-et-les-Grenadines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(368, 184, 2, 'St. Vincent & Grenadines', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(369, 185, 1, 'Samoa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(370, 185, 2, 'Samoa', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(371, 186, 1, 'Saint-Marin', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(372, 186, 2, 'San Marino', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(373, 187, 1, 'Sao Tomé-et-Principe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(374, 187, 2, 'São Tomé & Príncipe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(375, 188, 1, 'Arabie Saoudite', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(376, 188, 2, 'Saudi Arabia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(377, 189, 1, 'Sénégal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(378, 189, 2, 'Senegal', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(379, 190, 1, 'Serbie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(380, 190, 2, 'Serbia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(381, 191, 1, 'Seychelles', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(382, 191, 2, 'Seychelles', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(383, 192, 1, 'Sierra Leone', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(384, 192, 2, 'Sierra Leone', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(385, 193, 1, 'Slovénie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(386, 193, 2, 'Slovenia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(387, 194, 1, 'Îles Salomon', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(388, 194, 2, 'Solomon Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(389, 195, 1, 'Somalie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(390, 195, 2, 'Somalia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(391, 196, 1, 'Îles Géorgie Du Sud Et Sandwich Du Sud', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(392, 196, 2, 'South Georgia & South Sandwich Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(393, 197, 1, 'Sri Lanka', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(394, 197, 2, 'Sri Lanka', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(395, 198, 1, 'Soudan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(396, 198, 2, 'Sudan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(397, 199, 1, 'Suriname', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(398, 199, 2, 'Suriname', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(399, 200, 1, 'Svalbard Et Jan Mayen', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(400, 200, 2, 'Svalbard & Jan Mayen', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(401, 201, 1, 'Swaziland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(402, 201, 2, 'Swaziland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(403, 202, 1, 'Syrie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(404, 202, 2, 'Syria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(405, 203, 1, 'Taïwan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(406, 203, 2, 'Taiwan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(407, 204, 1, 'Tadjikistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(408, 204, 2, 'Tajikistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(409, 205, 1, 'Tanzanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(410, 205, 2, 'Tanzania', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(411, 206, 1, 'Thaïlande', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(412, 206, 2, 'Thailand', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(413, 207, 1, 'Tokelau', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(414, 207, 2, 'Tokelau', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(415, 208, 1, 'Tonga', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(416, 208, 2, 'Tonga', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(417, 209, 1, 'Trinité-et-Tobago', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(418, 209, 2, 'Trinidad & Tobago', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(419, 210, 1, 'Tunisie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(420, 210, 2, 'Tunisia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(421, 211, 1, 'Turquie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(422, 211, 2, 'Turkey', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(423, 212, 1, 'Turkménistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(424, 212, 2, 'Turkmenistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(425, 213, 1, 'Îles Turques-et-Caïques', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(426, 213, 2, 'Turks & Caicos Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(427, 214, 1, 'Tuvalu', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(428, 214, 2, 'Tuvalu', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(429, 215, 1, 'Ouganda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(430, 215, 2, 'Uganda', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(431, 216, 1, 'Ukraine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(432, 216, 2, 'Ukraine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(433, 217, 1, 'Émirats Arabes Unis', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(434, 217, 2, 'United Arab Emirates', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(435, 218, 1, 'Uruguay', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(436, 218, 2, 'Uruguay', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(437, 219, 1, 'Ouzbékistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(438, 219, 2, 'Uzbekistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(439, 220, 1, 'Vanuatu', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(440, 220, 2, 'Vanuatu', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(441, 221, 1, 'Venezuela', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(442, 221, 2, 'Venezuela', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(443, 222, 1, 'Vietnam', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(444, 222, 2, 'Vietnam', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(445, 223, 1, 'Îles Vierges Britanniques', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(446, 223, 2, 'British Virgin Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(447, 224, 1, 'Îles Vierges Des États-Unis', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(448, 224, 2, 'U.S. Virgin Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(449, 225, 1, 'Wallis-et-Futuna', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(450, 225, 2, 'Wallis & Futuna', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(451, 226, 1, 'Sahara Occidental', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(452, 226, 2, 'Western Sahara', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(453, 227, 1, 'Yémen', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(454, 227, 2, 'Yemen', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(455, 228, 1, 'Zambie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(456, 228, 2, 'Zambia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(457, 229, 1, 'Zimbabwe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(458, 229, 2, 'Zimbabwe', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(459, 230, 1, 'Albanie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(460, 230, 2, 'Albania', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(461, 231, 1, 'Afghanistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(462, 231, 2, 'Afghanistan', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(463, 232, 1, 'Antarctique', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(464, 232, 2, 'Antarctica', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(465, 233, 1, 'Bosnie-Herzégovine', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(466, 233, 2, 'Bosnia & Herzegovina', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(467, 234, 1, 'Île Bouvet', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(468, 234, 2, 'Bouvet Island', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(469, 235, 1, 'Territoire Britannique De L’océan Indien', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(470, 235, 2, 'British Indian Ocean Territory', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(471, 236, 1, 'Bulgarie', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(472, 236, 2, 'Bulgaria', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(473, 237, 1, 'Îles Caïmans', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(474, 237, 2, 'Cayman Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(475, 238, 1, 'Île Christmas', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(476, 238, 2, 'Christmas Island', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(477, 239, 1, 'Îles Cocos', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(478, 239, 2, 'Cocos (Keeling) Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(479, 240, 1, 'Îles Cook', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(480, 240, 2, 'Cook Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(481, 241, 1, 'Guyane Française', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(482, 241, 2, 'French Guiana', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(483, 242, 1, 'Polynésie Française', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(484, 242, 2, 'French Polynesia', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(485, 243, 1, 'Terres Australes Françaises', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(486, 243, 2, 'French Southern Territories', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(487, 244, 1, 'Îles Åland', '2020-11-11 10:56:54', NULL, NULL, '', 0),
	(488, 244, 2, 'Åland Islands', '2020-11-11 10:56:54', NULL, NULL, '', 0);
/*!40000 ALTER TABLE `config_pays_lang` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_raison_rejet
CREATE TABLE IF NOT EXISTS `config_raison_rejet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) NOT NULL,
  `raison` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lue` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFF40E03FCF77503` (`societe_id`),
  CONSTRAINT `FK_BFF40E03FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_raison_rejet : ~2 rows (environ)
/*!40000 ALTER TABLE `config_raison_rejet` DISABLE KEYS */;
INSERT INTO `config_raison_rejet` (`id`, `societe_id`, `raison`, `lue`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 8, 'sqqqqqqdffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffs', 1, '2020-11-24 16:17:03', 'abed-abed-2020-10-27-18-03', '2020-11-24 16:17:03', NULL, 0),
	(2, 8, 'df', 0, '2020-11-24 16:20:25', 'abed-abed-2020-10-27-18-03', '2020-11-24 16:20:25', NULL, 0),
	(3, 8, 'je rejette ', 0, '2020-11-26 11:57:18', 'abed-abed-2020-10-27-18-03', '2020-11-26 11:57:18', NULL, 0),
	(4, 7, 'zaefdez', 0, '2020-11-30 12:28:13', 'abed-abed-2020-10-27-18-03', '2020-11-30 12:28:13', NULL, 0);
/*!40000 ALTER TABLE `config_raison_rejet` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_societe
CREATE TABLE IF NOT EXISTS `config_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banque` int(11) NOT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `type_activite_id` int(11) DEFAULT NULL,
  `devise_id` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `raisonSociale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ifu_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registre_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registreCommerce` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ifu` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fonctionRepresentant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formeJuridique` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capital` int(11) DEFAULT NULL,
  `rib` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `site_web` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assujetiTva` tinyint(1) NOT NULL,
  `est_actif` tinyint(1) NOT NULL,
  `est_Profession_Liberale` tinyint(1) NOT NULL,
  `type_entreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exportation` tinyint(1) NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `deja_essayer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6C79FF4D77153098` (`code`),
  UNIQUE KEY `UNIQ_6C79FF4DD8D12E2A` (`raisonSociale`),
  UNIQUE KEY `UNIQ_6C79FF4DAB8F602F` (`ifu`),
  KEY `IDX_6C79FF4DB1F6CB3C` (`banque`),
  KEY `IDX_6C79FF4DA6E44244` (`pays_id`),
  KEY `IDX_6C79FF4DD0165F20` (`type_activite_id`),
  KEY `IDX_6C79FF4DF4445056` (`devise_id`),
  CONSTRAINT `FK_6C79FF4DA6E44244` FOREIGN KEY (`pays_id`) REFERENCES `config_pays_lang` (`id`),
  CONSTRAINT `FK_6C79FF4DB1F6CB3C` FOREIGN KEY (`banque`) REFERENCES `config_banque` (`id`),
  CONSTRAINT `FK_6C79FF4DD0165F20` FOREIGN KEY (`type_activite_id`) REFERENCES `config_type_activite` (`id`),
  CONSTRAINT `FK_6C79FF4DF4445056` FOREIGN KEY (`devise_id`) REFERENCES `config_devise` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_societe : ~4 rows (environ)
/*!40000 ALTER TABLE `config_societe` DISABLE KEYS */;
INSERT INTO `config_societe` (`id`, `banque`, `pays_id`, `type_activite_id`, `devise_id`, `code`, `raisonSociale`, `ifu_file`, `registre_file`, `adresse`, `telephone`, `email`, `registreCommerce`, `ifu`, `fonctionRepresentant`, `formeJuridique`, `capital`, `rib`, `site_web`, `assujetiTva`, `est_actif`, `est_Profession_Liberale`, `type_entreprise`, `ville`, `nom`, `prenom`, `exportation`, `logo`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`, `deja_essayer`) VALUES
	(1, 1, 1, 3, 1, 'ST01', 'ghrzeh', '/5fa56c29217de.Attestation IFU.pdf', '/5fa56c2a7a9dd.Attestation IFU.pdf', '02bp404', '21452318', 'afroshop@gmail.com', '256617996', '4646494925614', 'PDG', 'SA', 200000000, '2545', 'http://www.abed.com', 1, 1, 0, 'etablisement', 'CALAVI', 'abed', 'nego', 0, '/5e69d5f80a05d.icone_profil_homme.jpg', '2020-10-01 11:42:26', 'rezsq', '2020-12-01 15:56:11', 'abed-abed-2020-10-27-18-03', 0, 0),
	(4, 2, 3, 3, 2, 'STN01', 'AfroFhop', '/5fa56c29217de.Attestation IFU.pdf', '/5fa56c2a7a9dd.Attestation IFU.pdf', 'Akpakpa c', '21452318', 'afroshop@gmail.com', '256617996', '8974546464948', 'PDG', 'SA', 200000000, '2545', 'http://www.abeed.com', 1, 1, 0, 'societe', 'Abomey', 'Nego', 'last', 0, '/5e69d5f80a05d.icone_profil_homme.jpg', '2020-10-01 11:42:26', 'c', '2020-12-01 15:56:31', 'abed-abed-2020-10-27-18-03', 0, 0),
	(7, 2, 1, 1, 1, '44123', 'qszfddqf', '/5fa56c29217de.Attestation IFU.pdf', '/5fa56c2a7a9dd.Attestation IFU.pdf', '02bp404', '61169769', 'abed.hounsinou@gmail.com', 'zfzafr', '1023654120135', 'zrefr', 'Micro', 234545, 'zaf6324325', 'http://www.abaed.com', 1, 1, 1, 'societe', 'Abomey', 'Fifa', 'fisrt', 0, '/5e69d5f80a05d.icone_profil_homme.jpg', '2020-10-28 09:02:55', 'abed-abed-2020-10-27-18-03', '2020-12-01 14:44:25', 'abed-abed-2020-10-27-18-03', 0, 0),
	(8, 1, 1, 1, 3, 'ST00499', 'ad', '/5fb255e1cb78b.Rosalie-JOY-Transcash.pdf', '/5fb255e1cef2b.Rosalie-JOY-Transcash.pdf', '02bp404', '22861169769', 'abed.houtjnsinou@gmail.com', 'zfzdafr', '8745698745123', 'zrefr', 'Micro', 2345451, 'zaf6324325z', 'asdbed.com', 1, 0, 1, 'societe', 'CALAVI', 'ABEDR', 'Hounsinouret', 0, '/5e69d5f80a05d.icone_profil_homme.jpg', '2020-11-16 10:35:13', 'abedr-hounsinouret-2020-11-16-08-40', '2020-12-18 18:17:45', 'abedr-hounsinouret-2020-11-16-08-40', 0, 0),
	(9, 2, 1, 3, 1, 'ST00533', 'Fiabnee', '/5fe08f9a4ba2c.acte_abed.pdf', '/5fe08f9a95bab.acte_abed.pdf', 'calavi tankpè', '+(229).61.16.97.69', 'a@d.codm', '82652535', '8798456123154', 'Acheteur', NULL, 0, '258554225125145655', 'https://log.fr', 1, 0, 0, 'societe', 'abomey', 'HOUNSFDINOU', 'Abedd', 0, NULL, '2020-12-16 10:48:27', 'hounsfdinou-abedd-2020-12-16-10-23', '2020-12-21 12:05:46', 'hounsfdinou-abedd-2020-12-16-10-23', 0, 0);
/*!40000 ALTER TABLE `config_societe` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_taux
CREATE TABLE IF NOT EXISTS `config_taux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_taux_id_id` int(11) DEFAULT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur_taux` double NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_103A618D77153098` (`code`),
  UNIQUE KEY `UNIQ_103A618D70B09085` (`config_taux_id_id`),
  CONSTRAINT `FK_103A618D70B09085` FOREIGN KEY (`config_taux_id_id`) REFERENCES `config_taux` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_taux : ~3 rows (environ)
/*!40000 ALTER TABLE `config_taux` DISABLE KEYS */;
INSERT INTO `config_taux` (`id`, `config_taux_id_id`, `code`, `libelle`, `valeur_taux`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, NULL, 'tva', 'TVA', 18, NULL, '', NULL, NULL, 0),
	(2, NULL, 'aib_avec_ifu', 'AIB ', 1, NULL, '', NULL, NULL, 0),
	(3, NULL, 'aib_sans_ifu', 'AIB ', 5, NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_taux` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_taxe_groupe
CREATE TABLE IF NOT EXISTS `config_taxe_groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_taxe_groupe : ~2 rows (environ)
/*!40000 ALTER TABLE `config_taxe_groupe` DISABLE KEYS */;
INSERT INTO `config_taxe_groupe` (`id`, `code`, `libelle`, `created`, `createdBy`, `updateAt`, `supprimer`, `updateBy`) VALUES
	(1, '5d4f', 'Commun', '2020-11-24 18:54:38', 'abed', '2020-11-24 18:54:42', 0, NULL),
	(2, 'fd57', 'Solo', '2020-11-24 18:55:19', 'dsz', '2020-11-24 18:55:22', 0, NULL);
/*!40000 ALTER TABLE `config_taxe_groupe` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_type_activite
CREATE TABLE IF NOT EXISTS `config_type_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_type_activite : ~3 rows (environ)
/*!40000 ALTER TABLE `config_type_activite` DISABLE KEYS */;
INSERT INTO `config_type_activite` (`id`, `code`, `libelle`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'vente_article', 'Vente d\'articles', NULL, '', NULL, NULL, 0),
	(2, 'prestation_service', 'Prestation de services', NULL, '', NULL, NULL, 0),
	(3, 'article_service', 'Vente d\'articles et prestation de services', NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_type_activite` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_type_facture
CREATE TABLE IF NOT EXISTS `config_type_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `avoir` tinyint(1) NOT NULL,
  `export` tinyint(1) NOT NULL,
  `devis` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_type_facture : ~6 rows (environ)
/*!40000 ALTER TABLE `config_type_facture` DISABLE KEYS */;
INSERT INTO `config_type_facture` (`id`, `code`, `libelle`, `actif`, `avoir`, `export`, `devis`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'FV', 'Facture de vente', 1, 0, 0, 0, NULL, '', NULL, NULL, 0),
	(2, 'EV', 'Facture de vente à l’exportation', 1, 0, 1, 0, NULL, '', NULL, NULL, 0),
	(3, 'FA', 'Facture d\'avoir', 1, 1, 0, 0, NULL, '', NULL, NULL, 0),
	(4, 'EA', 'Facture d\'avoir à l’exportation', 1, 1, 1, 0, NULL, '', NULL, NULL, 0),
	(5, 'DV', 'Devis de vente', 1, 0, 0, 1, NULL, '', NULL, NULL, 0),
	(6, 'DE', 'Devis de vente à l\'exportation', 1, 0, 1, 1, NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_type_facture` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_type_generation
CREATE TABLE IF NOT EXISTS `config_type_generation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) DEFAULT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_societe` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_agence` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_fournisseur` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_client` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_article` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_service` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_approvisionnement` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_facture` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_inventaire` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2FEA8DA9FCF77503` (`societe_id`),
  CONSTRAINT `FK_2FEA8DA9FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_type_generation : ~9 rows (environ)
/*!40000 ALTER TABLE `config_type_generation` DISABLE KEYS */;
INSERT INTO `config_type_generation` (`id`, `societe_id`, `code`, `libelle`, `code_societe`, `code_agence`, `code_fournisseur`, `code_client`, `reference_article`, `reference_service`, `reference_approvisionnement`, `reference_facture`, `reference_inventaire`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 1, 'refArticle', 'Les codes Pour S1', 'POW', 'AG', 'FN', 'CLT', 'ART', 'SERV', 'APP', 'FACT', 'INV', '2021-10-22 13:03:00', '', NULL, NULL, 0),
	(2, 7, 'dfxg', 'Les codes Pour S1', 'sdqf', 'ds', 'sqgf', 'sd', 'sdfs', 'dsc', 'sda', 'sdq', 'fg', '2020-10-23 08:07:41', 'z', '2020-10-23 09:09:05', 'z', 1),
	(3, 4, 'ST01', 'Les codes Pour S2', 'ezg', 'ezg', 'ez', 'eg', 'ezgr', 'ezg', 'ezrg', 'ezg', 'erg', '2020-10-23 09:49:34', 'z', NULL, NULL, 0),
	(4, 1, 'ST01', 'Les codes Pour S1', 'qdsf', 'qSDF', 'SQDF', 'SQDF', 'sdf', 'df', 'SDQF', 'SDF', 'SDSF', '2020-10-23 10:16:28', 'z', NULL, NULL, 0),
	(5, 7, 'ST01', 'Les codes Pour S2', 'aze', 'qSDF', 'SQDF', 'SQDF', 'sdf', 'df', 'SDQF', 'SDF', 'SDSF', '2020-10-23 10:17:50', 'z', NULL, NULL, 0),
	(6, 1, 'dfsdf', 'Les codes Pour S1', 'dsg', 'agc', 'FN', 'CLT', 'ART', 'SERV', 'APP', 'FACT', 'INV', '2020-10-22 13:03:00', 'f', '2020-11-12 16:01:34', 'abed-abed-2020-10-27-18-03', 0),
	(7, 7, 'ST03', 'Les codes Pour S2', 'ddgf', 'qSDF', 'SQDF', 'SQDF', 'sdf', 'df', 'SDQF', 'SDF', 'SDSF', '2020-10-23 10:17:50', 'z', NULL, NULL, 0),
	(8, 4, 'ST04', 'Les codes Pour S2', 'sff', 'qSDF', 'SQDF', 'SQDF', 'sdf', 'df', 'SDQF', 'SDF', 'SDSF', '2020-10-23 10:17:50', 'z', NULL, NULL, 0),
	(9, 1, 'ST01', 'azzzzz', 'gb', 'dfwx', '<sgf', 's<g', 'ds<', 'fd', '<sg', 's<vg', '<sgv', '2020-11-19 16:01:31', 'azert-hounsinouerert-2020-11-17-16-49', '2020-11-19 16:02:00', 'azert-hounsinouerert-2020-11-17-16-49', 0);
/*!40000 ALTER TABLE `config_type_generation` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_type_generation_societe
CREATE TABLE IF NOT EXISTS `config_type_generation_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_generation_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `estGenere` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C5A02B6425D7D9F1` (`type_generation_id`),
  KEY `IDX_C5A02B64FCF77503` (`societe_id`),
  CONSTRAINT `FK_C5A02B6425D7D9F1` FOREIGN KEY (`type_generation_id`) REFERENCES `config_type_generation` (`id`),
  CONSTRAINT `FK_C5A02B64FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_type_generation_societe : ~25 rows (environ)
/*!40000 ALTER TABLE `config_type_generation_societe` DISABLE KEYS */;
INSERT INTO `config_type_generation_societe` (`id`, `type_generation_id`, `societe_id`, `estGenere`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 1, 1, 0, NULL, '', NULL, NULL, 0),
	(3, 3, 4, 0, '2020-10-23 15:13:46', 'hounsinou-abed', NULL, NULL, 0),
	(4, 4, 4, 0, '2020-10-23 15:15:38', 'hounsinou-abed', NULL, NULL, 0),
	(5, 2, 4, 0, '2020-10-23 15:16:01', 'hounsinou-abed', NULL, NULL, 0),
	(6, NULL, 1, 0, '2020-10-23 18:22:43', 'z', NULL, NULL, 0),
	(7, NULL, 1, 0, '2020-10-23 18:32:58', 'z', NULL, NULL, 0),
	(8, NULL, 1, 0, '2020-10-23 18:33:04', 'z', NULL, NULL, 0),
	(11, 1, 1, 0, '2020-10-23 18:46:05', 'z', NULL, NULL, 0),
	(12, 1, 1, 0, '2020-10-23 18:50:37', 'z', NULL, NULL, 0),
	(13, 1, 1, 0, '2020-10-23 18:53:28', 'z', NULL, NULL, 0),
	(14, 1, 1, 0, '2020-10-23 18:53:45', 'z', NULL, NULL, 0),
	(15, 1, 1, 0, '2020-10-23 18:55:46', 'z', NULL, NULL, 0),
	(16, 1, 1, 0, '2020-10-23 18:56:14', 'z', NULL, NULL, 0),
	(17, 6, 1, 0, '2020-10-23 18:56:26', 'z', NULL, NULL, 0),
	(18, 4, 1, 0, '2020-10-23 18:56:41', 'z', NULL, NULL, 0),
	(19, 1, 1, 0, '2020-10-23 18:57:02', 'z', NULL, NULL, 0),
	(20, 1, 1, 0, '2020-10-23 19:04:15', 'z', NULL, NULL, 0),
	(21, 1, 1, 0, '2020-10-26 08:30:44', 'z', NULL, NULL, 0),
	(22, 6, 1, 0, '2020-10-26 15:25:01', 'z', NULL, NULL, 0),
	(23, 4, 1, 0, '2020-10-26 16:57:57', 'z', NULL, NULL, 0),
	(24, 1, 1, 0, '2020-10-26 17:05:55', 'z', NULL, NULL, 0),
	(25, 1, 4, 1, '2019-10-27 09:54:44', 'z', NULL, NULL, 0),
	(26, 1, 1, 1, '2019-10-27 17:20:05', 'z', NULL, NULL, 0),
	(27, 4, 7, 1, '2020-10-27 17:20:23', 'z', NULL, NULL, 0),
	(28, 6, 1, 1, '2020-10-28 11:45:09', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(29, 8, 4, 1, '2020-11-27 18:12:05', 'abedr-hounsinouret-2020-11-16-08-40', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_type_generation_societe` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_unite_mesure
CREATE TABLE IF NOT EXISTS `config_unite_mesure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_unite_mesure : ~4 rows (environ)
/*!40000 ALTER TABLE `config_unite_mesure` DISABLE KEYS */;
INSERT INTO `config_unite_mesure` (`id`, `code`, `libelle`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'item', 'Item', NULL, '', NULL, NULL, 0),
	(2, 'heure', 'Heure', NULL, '', NULL, NULL, 0),
	(3, 'jour', 'Jour', NULL, '', NULL, NULL, 0),
	(4, 'mois', 'Mois', NULL, '', NULL, NULL, 0);
/*!40000 ALTER TABLE `config_unite_mesure` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. config_zone
CREATE TABLE IF NOT EXISTS `config_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.config_zone : ~8 rows (environ)
/*!40000 ALTER TABLE `config_zone` DISABLE KEYS */;
INSERT INTO `config_zone` (`id`, `name`, `active`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 'Europe', 1, '2020-11-11 11:26:55', NULL, NULL, NULL, 0),
	(2, 'North America', 1, '2020-11-11 11:26:56', NULL, NULL, NULL, 0),
	(3, 'Asia', 1, '2020-11-11 11:26:57', NULL, NULL, NULL, 0),
	(4, 'Africa', 1, '2020-11-11 11:26:58', NULL, NULL, NULL, 0),
	(5, 'Oceania', 1, '2020-11-11 11:26:59', NULL, NULL, NULL, 0),
	(6, 'South America', 1, '2020-11-11 11:27:00', NULL, NULL, NULL, 0),
	(7, 'Europe (non-EU)', 1, '2020-11-11 11:27:00', NULL, NULL, NULL, 0),
	(8, 'Central America/Antilla', 1, '2020-11-11 11:27:01', NULL, NULL, NULL, 0);
/*!40000 ALTER TABLE `config_zone` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. fos_user
CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agence_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_veririfer` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userPublicId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `est_activer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`),
  UNIQUE KEY `UNIQ_957A6479989D9B62` (`slug`),
  KEY `IDX_957A6479D725330D` (`agence_id`),
  CONSTRAINT `FK_957A6479D725330D` FOREIGN KEY (`agence_id`) REFERENCES `config_agence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.fos_user : ~18 rows (environ)
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` (`id`, `agence_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `nom`, `prenoms`, `slug`, `est_veririfer`, `created`, `createdBy`, `updateAt`, `updateBy`, `userPublicId`, `estSupprimer`, `est_activer`) VALUES
	(1, 1, 'testuser', 'testuser', 'test@example.com', 'test@example.com', 0, 'hEe8.WtwgGFaEdTXCjObxQDdGe.glbzPWtyW34xvFKw', 'pkjoU9by6+wzsGA1qguP8iVK4ybcIh7t2+rHRMHzwiyjl1n1wWp+sHWmpZeBqqdZmAcbSjz/6LdRUo3OTnyryA==', NULL, NULL, NULL, 'a:0:{}', 'ERZT', 'Erte', 'erzt-erte', 0, NULL, '', '2020-12-14 17:34:05', 'abedr-hounsinouret-2020-11-16-08-40', '45xdfgga23', 0, 0),
	(2, 2, 'roquib', 'roquib', 'daoudaroquib@ogi-informatique.com', 'daoudaroquib@ogi-informatique.com', 1, 'TJ5/GrcKVUTScrxvu2A7K854ie.0N7qJYoOF2zwPDyE', 'tFWwXo6Tx4QlDIY1qHMaP0LgV/oy5L8DcxVY53xAuvbV7Q0sMrzxTRC9Y+fD8Konf6tmHnp48Si1k1FMy+cbeA==', '2020-11-18 12:07:10', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_FNS_ADMIN";}', 'DAOUDA', 'Abdul-Roquib', 'z', 1, '2020-10-28 19:09:40', '', '2020-11-12 11:09:54', 'abed-abed-2020-10-27-18-03', '46xdfgga35', 0, 1),
	(5, 2, 'samad', 'samad', 'camarasamad@gmail.com', 'camarasamad@gmail.com', 1, 'X4Ofo1kXzmkkUwBeguBQ5Bk7mJFIZ8dFT7NiPY45dXA', 'YYlxsnReDSLJehuBiaJRP/g0RKEW2rVcyBlDbQSiIUDFjZ7U3zDGU+9FgBasnWw250JgS6W728Ujjq72jxH4pQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 'CAMARA', 'Samad', 'e', 0, NULL, '', NULL, NULL, '7ef30f83385e74a3203c0be', 0, 0),
	(6, 2, 'salim', 'salim', 'mirzasalim@gmail.com', 'mirzasalim@gmail.com', 1, 'g7G2UrjgkuiOhaY4J6DU3FfkvGWEF/4M0XHkt7R5d3k', 'n9YNjIwCA0U6mBkyUbtggTAGumrnWQuJudxebAtmI5lNM1FbMU2mjfCvKErHiqd+Dd4FtcoUzmq1hRx+hKTCqw==', NULL, NULL, NULL, 'a:1:{i:0;s:14:"ROLE_COMPTABLE";}', 'MIRZA', 'Salim', 'q', 0, NULL, '', NULL, NULL, '8bc4421d305e74f89a7e422', 0, 0),
	(7, 27, 'abnefi', 'abnefi1', 'abed.houn5sinou@gmail.com', 'abed.houn5sinou@gmail.com', 1, 'FUOUlGaKF2gtAh036np5qFCwGaBfKoKijl0TV0fKs/k', 'DawTIbQDkaQVoIceUJhMlHasIi9Hmoe21YeEVhY0D6gU2llf9Y+CVa421svfQi5HECHD318+MPbp3VyqJjq4hQ==', '2020-10-26 14:45:20', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'HOUNSINOU', 'Abed', 'hounsinou-abed', 0, NULL, '', NULL, NULL, '76e7faab695f89c58f20bcb', 0, 0),
	(8, 23, 'abenefi', 'abenefi', 'abed.houvnsinou@gmail.com', 'abed.houvnsinou@gmail.com', 1, 'y/UW39SPLWu11PgDTFyQSkv5yAu97I4C.Js6wwTGQ3A', 'CyaxruBWxRnyIXy/0Xk1hbMRbLRy97QEpl6NPfmFvT3aKC517yPX5KZgCks4e7TczM2sdaXWOMXeWqMLDTGgjA==', NULL, NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'ERTRE', 'Ere', 'ertre-ere', 0, NULL, '', '2020-11-17 16:10:08', 'abed-abed-2020-10-27-18-03', '719636387a5f89c957088d0', 0, 0),
	(9, 27, 'abneztgefi', 'abneztgefi', 'abed.hounetgsinou@gmail.com', 'abed.hounetgsinou@gmail.com', 1, '8arV5hho8udCDuKofqUuta69A27DYR0YZlA1EQmMjpw', 'EUzkUmlf4g03hKt+Jabjl7zIY0qpWWA4vzdqECJOWNV3AAD1AlVlkCGbHWCevmn9kfKzCrMrt9nqDrb1CJsKLw==', NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_CAISSE";}', 'EDGDZSG', 'Eztgr', 'edgdzsg-eztgr', 0, NULL, '', NULL, NULL, '4cf2e3acb95f89d2bf545ed', 0, 0),
	(10, 27, 'abnefiqF', 'abnefiqf', 'abed.hounsinsdfou@gmail.com', 'abed.hounsinsdfou@gmail.com', 1, 'C.VcanIZi2h6gn.9vKvMgXda4uhTtDO//QVBIHXE/Io', 'mo8CHo7jDQLLt6bz+YTk080ndgKtF5UJOL6hmgJG3IVmUSPXQhyuZm2WfFRaY3bGsYv9UMYhegaMx9tr3QH8gg==', NULL, NULL, NULL, 'a:1:{i:0;s:14:"ROLE_COMPTABLE";}', 'ERTRSE', 'Sfd', 'ertrse-sfd', 0, NULL, '', NULL, NULL, '809584923d5f89d31167426', 0, 0),
	(11, 27, 'raaaaaaaabetnefi', 'raaaaaaaabetnefi', 'abed.houetzsnsinou@gmail.com', 'abed.houetzsnsinou@gmail.com', 1, 'SgYOXRg/ZOOuAbRLdvq5Q6xWKrEMHsgmHXwIcAjy54E', 'a49Js5GNO33tLJn+R2oDXeweozvjl/3MmjVASwBRUr8iQzyXwm2HeDxmqQyaUxB9KSk2AU4g8h9/ZAr4/0SHHA==', NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_CAISSE";}', 'ERTTRETR', 'Tyry', 'erttretr-2020-10-16-17-09-tyry', 0, '2020-10-16 17:09:25', '', '2020-11-09 10:45:35', 'abed-abed-2020-10-27-18-03', '8fa5030ea65f89d3c5dd7b3', 0, 0),
	(19, 1, 'abnefi', 'abnefi', 'abed.hounsinou@gmail.com', 'abed.hounsinou@gmail.com', 1, 'gsyh5gHJoWw9iO7LIoh1C.dlTIq8ooyiHLc1ToHmW0o', 'HGkSLUOYWPhp3Qcj6iwIcsVUBV9AF/Mt0L65hD/NYnRpeUSCFDZ/nlxYrxWAlBcF4tnjqXsIaYbRgTM1Pz89pQ==', '2020-12-28 17:36:52', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_FNS_ADMIN";}', 'ABED', 'Abed', 'abed-abed-2020-10-27-18-03', 1, '2020-10-27 18:03:39', ' ', '2020-11-17 12:21:22', 'abed-abed-2020-10-27-18-03', ' ', 0, 1),
	(20, 2, 'admin', 'admin', 'abed.hounsinou@gmail.comdsqc', 'abed.hounsinou@gmail.comdsqc', 0, '4pEjwx4ALFPrCuOzok86OcL4OYCqQvPkOxB9v7lwtnE', 'INO8TKeMpPqbcxu7Ran5tzSQ4Hurwv/7X4KJC1+3B8mJVW193OlWB7/YJJ3q5ZFx/yEvUxsWH/27W39XBEWC8Q==', '2020-12-10 15:00:17', NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 'ABSDED', 'Houdsfnsinou', 'absded-houdsfnsinou-2020-11-12-17-18', 1, '2020-11-12 17:18:02', ' ', '2020-12-14 17:35:47', 'abedr-hounsinouret-2020-11-16-08-40', ' ', 0, 1),
	(21, 40, 'admin1', 'admin1', 'abed.houtjnsinou@gmail.com', 'abed.houtjnsinou@gmail.com', 1, 'QOYF/CRcl04f.CJYQPCVonGDJbxmSLoXcl/v7UiggJs', 'INO8TKeMpPqbcxu7Ran5tzSQ4Hurwv/7X4KJC1+3B8mJVW193OlWB7/YJJ3q5ZFx/yEvUxsWH/27W39XBEWC8Q==', '2020-12-29 08:41:36', NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 'ABEDR', 'Hounsinouret', 'abedr-hounsinouret-2020-11-16-08-40', 0, '2020-11-16 08:40:00', ' ', '2020-12-16 14:29:17', 'abedr-hounsinouret-2020-11-16-08-40', ' ', 0, 1),
	(22, 1, 'azert', 'azert', 'abed.houernsinou@gmail.com', 'abed.houernsinou@gmail.com', 1, 'MSBjnoFxNjQKmjJnpUDdfLnNbFYp4Yg00dZXED4bqC0', 'HGkSLUOYWPhp3Qcj6iwIcsVUBV9AF/Mt0L65hD/NYnRpeUSCFDZ/nlxYrxWAlBcF4tnjqXsIaYbRgTM1Pz89pQ==', '2020-11-19 16:01:02', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'AZERT', 'Hounsinouerert', 'azert-hounsinouerert-2020-11-17-16-49', 0, '2020-11-17 16:49:22', ' ', NULL, NULL, '69b0bc0ba75fb3ff129a358', 0, 0),
	(23, NULL, 'dfwhg', 'dfwhg', 'dwgf@gh.com', 'dwgf@gh.com', 1, 'P7eSRvJvU55D1CW8X1X0JhfgghiJZ93bToLc15MRWOg', 'INO8TKeMpPqbcxu7Ran5tzSQ4Hurwv/7X4KJC1+3B8mJVW193OlWB7/YJJ3q5ZFx/yEvUxsWH/27W39XBEWC8Q==', NULL, NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'GFVSD', 'Bfdwhnf', 'gfvsd-bfdwhnf-2020-11-18-09-45', 0, '2020-11-18 09:45:52', ' ', NULL, NULL, ' ', 0, 0),
	(24, 1, 'jesus', 'jesus', 'a@d.com', 'a@d.com', 1, 'dSw1n7UQi5BuYJTFqkdfHlOujB3YpOEtpNZBqau/80c', 'INO8TKeMpPqbcxu7Ran5tzSQ4Hurwv/7X4KJC1+3B8mJVW193OlWB7/YJJ3q5ZFx/yEvUxsWH/27W39XBEWC8Q==', '2020-12-03 16:16:58', NULL, NULL, 'a:8:{i:0;s:10:"ROLE_ADMIN";i:1;s:14:"ROLE_CLT_ADMIN";i:2;s:14:"ROLE_FNS_ADMIN";i:3;s:15:"ROLE_CONTROLEUR";i:4;s:11:"ROLE_CAISSE";i:5;s:12:"ROLE_VENDEUR";i:6;s:14:"ROLE_COMPTABLE";i:7;s:13:"ROLE_VISITEUR";}', 'JESUS', 'Christ', 'jesus-christ-2020-11-20-15-50', 1, '2020-11-20 15:50:09', ' ', '2020-12-11 15:35:56', 'abedr-hounsinouret-2020-11-16-08-40', ' ', 0, 0),
	(27, NULL, 'Super', 'super', 'a@d.coms', 'a@d.coms', 1, 'ht6C6iIEqahY3W4wEuvyjRCt9AyVlk0whVaII44MZys', '+HTkQngWRDTrxBn3jmM7Nx1THQwcmBWLyE16YAN0HXl6nGP0WZDJNXmGRhix5owBc1/KClOSojU+0vDb5MieDA==', '2020-12-07 17:37:33', NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 'SUPER', 'Admin', 'super-admin-2020-12-03-17-53', 1, '2020-12-03 17:53:30', ' ', NULL, NULL, ' ', 0, 0),
	(28, 42, 'leo', 'leo', 'a@d.codm', 'a@d.codm', 1, 'H4y5LiDPrIE16cT1h.g.C054raFNuKCPmdJxCq5dC.A', '+HTkQngWRDTrxBn3jmM7Nx1THQwcmBWLyE16YAN0HXl6nGP0WZDJNXmGRhix5owBc1/KClOSojU+0vDb5MieDA==', '2020-12-28 17:28:32', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'HOUNSFDINOU', 'Abedd', 'hounsfdinou-abedd-2020-12-16-10-23', 1, '2020-12-16 10:23:09', ' ', NULL, NULL, ' ', 0, 0),
	(29, NULL, 'azerty', 'azerty', 'abed.hounsinou@sdgmail.com', 'abed.hounsinou@sdgmail.com', 1, 'e2lwxCNv4BF.SX7bLZu2gwXPDyt3.ubVXRUMFIQDDhM', '+HTkQngWRDTrxBn3jmM7Nx1THQwcmBWLyE16YAN0HXl6nGP0WZDJNXmGRhix5owBc1/KClOSojU+0vDb5MieDA==', NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 'ERZTSAS', 'Zad', 'erztsas-zad-2020-12-16-10-45', 0, '2020-12-16 10:45:37', ' ', NULL, NULL, ' ', 0, 0),
	(30, NULL, 'hux', 'hux', 'huxleyar93@gmail.com', 'huxleyar93@gmail.com', 1, 'BChstzV7nbYVQMy7MvXECxOOvvj4EA.u06CJ0ZqmsGg', '+HTkQngWRDTrxBn3jmM7Nx1THQwcmBWLyE16YAN0HXl6nGP0WZDJNXmGRhix5owBc1/KClOSojU+0vDb5MieDA==', NULL, NULL, NULL, 'a:1:{i:0;s:14:"ROLE_CLT_ADMIN";}', 'USLER', 'Uslere', 'usler-uslere-2020-12-16-16-44', 0, '2020-12-16 16:44:05', ' ', NULL, NULL, ' ', 0, 0);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. mouchard_fichier
CREATE TABLE IF NOT EXISTS `mouchard_fichier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_action` datetime NOT NULL,
  `entity_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.mouchard_fichier : ~0 rows (environ)
/*!40000 ALTER TABLE `mouchard_fichier` DISABLE KEYS */;
/*!40000 ALTER TABLE `mouchard_fichier` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_approvisionnement
CREATE TABLE IF NOT EXISTS `stock_approvisionnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur_id` int(11) NOT NULL,
  `societe_id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_reception` date NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `userPublicId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_21A7FB1FAEA34913` (`reference`),
  KEY `IDX_21A7FB1F670C757F` (`fournisseur_id`),
  KEY `IDX_21A7FB1FFCF77503` (`societe_id`),
  CONSTRAINT `FK_21A7FB1F670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `tiers_fournisseur` (`id`),
  CONSTRAINT `FK_21A7FB1FFCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_approvisionnement : ~5 rows (environ)
/*!40000 ALTER TABLE `stock_approvisionnement` DISABLE KEYS */;
INSERT INTO `stock_approvisionnement` (`id`, `fournisseur_id`, `societe_id`, `reference`, `date_reception`, `created`, `updated_at`, `createdBy`, `updateBy`, `estSupprimer`, `userPublicId`) VALUES
	(2, 1, 1, 'AP0001', '2019-11-04', '2020-02-13 11:51:17', '2020-10-21 12:50:35', '', 'z', 1, 'Bb8IMY8qETj0yNS6SsEBYXVMD'),
	(6, 2, 1, 'AP0002', '2020-10-15', '2020-10-21 16:36:33', '2020-10-21 17:37:49', 'z', 'z', 0, '46xdfgga35'),
	(7, 1, 1, 'ST01APP85667', '2020-11-11', '2020-11-03 15:02:21', '2020-11-03 15:02:20', 'abed-abed-2020-10-27-18-03', NULL, 0, ' '),
	(8, 20, 1, 'ST01APP73832', '2020-11-12', '2020-11-11 16:17:17', '2020-11-11 16:17:16', 'abed-abed-2020-10-27-18-03', NULL, 0, ' '),
	(9, 1, 1, 'ST01APP53824', '2020-11-20', '2020-11-16 19:22:52', '2020-11-16 19:22:52', 'abed-abed-2020-10-27-18-03', NULL, 0, ' '),
	(10, 6, 1, 'ST01APP22877', '2020-11-03', '2020-11-23 11:40:44', '2020-11-23 11:40:41', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, 0, ' ');
/*!40000 ALTER TABLE `stock_approvisionnement` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_approvisionnement_detail
CREATE TABLE IF NOT EXISTS `stock_approvisionnement_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `approvisionnement_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `cout_achat_unitaire` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E37F1630AE741A98` (`approvisionnement_id`),
  KEY `IDX_E37F16307294869C` (`article_id`),
  CONSTRAINT `FK_E37F16307294869C` FOREIGN KEY (`article_id`) REFERENCES `stock_produit` (`id`),
  CONSTRAINT `FK_E37F1630AE741A98` FOREIGN KEY (`approvisionnement_id`) REFERENCES `stock_approvisionnement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_approvisionnement_detail : ~10 rows (environ)
/*!40000 ALTER TABLE `stock_approvisionnement_detail` DISABLE KEYS */;
INSERT INTO `stock_approvisionnement_detail` (`id`, `approvisionnement_id`, `article_id`, `quantite`, `cout_achat_unitaire`, `updated_at`, `created`, `createdBy`, `updateBy`, `estSupprimer`) VALUES
	(1, 2, 4, 10, 2000, '2020-02-13 11:51:18', NULL, '', NULL, 0),
	(2, 2, 6, 35, 1000, '2020-02-13 11:51:18', NULL, '', NULL, 0),
	(3, 6, 4, 450521, 514, '2020-10-21 17:37:49', NULL, 'z', 'z', 0),
	(4, 6, 6, 5836, 876, '2020-10-21 17:37:49', NULL, 'z', 'z', 0),
	(5, 7, 4, 45, 550, '2020-11-03 15:02:20', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(6, 7, 6, 85, 250, '2020-11-03 15:02:20', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(7, 8, 12, 562, 264, '2020-11-11 16:17:16', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(8, 8, 6, 8532, 12, '2020-11-11 16:17:16', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(9, 9, 6, 50, 2500, '2020-11-16 19:22:52', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(10, 9, 18, 10, 23500, '2020-11-16 19:22:52', NULL, 'abed-abed-2020-10-27-18-03', NULL, 0),
	(11, 10, 6, 54, 870, '2020-11-23 11:40:42', NULL, 'absded-houdsfnsinou-2020-11-12-17-18', NULL, 0);
/*!40000 ALTER TABLE `stock_approvisionnement_detail` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_categogie
CREATE TABLE IF NOT EXISTS `stock_categogie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_supprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CB0D5147FCF77503` (`societe_id`),
  CONSTRAINT `FK_CB0D5147FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_categogie : ~4 rows (environ)
/*!40000 ALTER TABLE `stock_categogie` DISABLE KEYS */;
INSERT INTO `stock_categogie` (`id`, `societe_id`, `libelle`, `code`, `description`, `created_at`, `createdBy`, `updateAt`, `updateBy`, `est_supprimer`) VALUES
	(1, 1, 'a', NULL, 'aezda', '2020-10-21 08:55:17', 'z', '2020-11-03 15:01:30', 'abed-abed-2020-10-27-18-03', 1),
	(2, 4, 'ado', NULL, 'qsfdsqfc', '2020-11-03 14:58:13', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(4, 1, 'ado', NULL, 'aezda', '2020-11-18 16:50:00', 'absded-houdsfnsinou-2020-11-12-17-18', '2020-11-18 17:42:52', 'absded-houdsfnsinou-2020-11-12-17-18', 0),
	(5, 1, 'adoa', NULL, 'aezda', '2020-11-18 17:10:00', 'absded-houdsfnsinou-2020-11-12-17-18', '2020-11-18 17:42:32', 'absded-houdsfnsinou-2020-11-12-17-18', 0);
/*!40000 ALTER TABLE `stock_categogie` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_inventaire
CREATE TABLE IF NOT EXISTS `stock_inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `societe_id` int(11) NOT NULL,
  `reference_inventaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_inventaire` date NOT NULL,
  `est_valide` tinyint(1) NOT NULL,
  `est_annule` tinyint(1) NOT NULL,
  `est_supprime` tinyint(1) NOT NULL,
  `date_validation` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9DC0D74C679715AF` (`reference_inventaire`),
  KEY `IDX_9DC0D74CD5E86FF` (`etat_id`),
  KEY `IDX_9DC0D74CA76ED395` (`user_id`),
  KEY `IDX_9DC0D74CFCF77503` (`societe_id`),
  CONSTRAINT `FK_9DC0D74CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_9DC0D74CD5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `config_etat` (`id`),
  CONSTRAINT `FK_9DC0D74CFCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_inventaire : ~12 rows (environ)
/*!40000 ALTER TABLE `stock_inventaire` DISABLE KEYS */;
INSERT INTO `stock_inventaire` (`id`, `etat_id`, `user_id`, `societe_id`, `reference_inventaire`, `date_inventaire`, `est_valide`, `est_annule`, `est_supprime`, `date_validation`, `created`, `updated_at`, `createdBy`, `updateBy`) VALUES
	(2, 2, 2, 4, 'Inventaire n° 01', '2020-03-13', 0, 0, 0, '2020-03-16', '2020-03-13 17:15:56', '2020-10-21 17:38:09', '', 'z'),
	(3, 2, 2, 1, 'Inventaire n° 02', '2020-03-16', 0, 0, 0, '2020-03-16', '2020-03-16 07:47:53', '2020-11-03 15:06:37', '', 'abed-abed-2020-10-27-18-03'),
	(4, 3, 2, 4, 'Inventaire n° 03', '2020-03-16', 0, 0, 0, '2020-03-16', '2020-03-16 13:57:49', '2020-03-16 13:57:49', '', NULL),
	(5, 2, 2, 1, 'Inventaire n° 04', '2020-03-16', 0, 0, 0, NULL, '2020-03-16 13:59:01', '2020-10-21 14:45:23', '', 'z'),
	(8, 1, 2, 4, 'Inventaire n° 05', '2020-10-21', 0, 0, 0, NULL, '2020-10-21 16:45:08', '2020-10-21 16:45:08', 'z', NULL),
	(9, 1, 2, 1, 'ST01SDQF30359', '2020-10-26', 0, 0, 0, NULL, '2020-10-26 17:02:35', '2020-10-26 17:02:34', 'z', NULL),
	(10, 1, 2, 1, 'ST01APP93452', '2020-10-26', 0, 0, 0, NULL, '2020-10-26 17:06:20', '2020-10-26 17:06:20', 'z', NULL),
	(11, 1, 2, 1, 'ST01APP64599', '2020-10-26', 0, 0, 0, NULL, '2020-10-26 17:06:38', '2020-10-26 17:06:38', 'z', NULL),
	(12, 3, 19, 1, 'ST01APP73658', '2020-11-03', 1, 0, 0, '2020-11-03', '2020-11-03 15:06:48', '2020-11-03 15:06:56', 'abed-abed-2020-10-27-18-03', 'abed-abed-2020-10-27-18-03'),
	(13, 2, 19, 1, 'ST01APP74874', '2020-11-11', 0, 0, 0, NULL, '2020-11-11 16:01:01', '2020-11-11 16:01:08', 'abed-abed-2020-10-27-18-03', 'abed-abed-2020-10-27-18-03'),
	(14, 1, 19, 1, 'ST01APP76885', '2020-11-13', 0, 0, 0, NULL, '2020-11-13 08:51:47', '2020-11-13 08:51:44', 'abed-abed-2020-10-27-18-03', NULL),
	(15, 1, 19, 1, 'ST01APP82851', '2020-11-16', 0, 0, 0, NULL, '2020-11-16 19:41:36', '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL),
	(16, 1, 20, 1, 'ST01APP15830', '2020-11-25', 0, 0, 0, NULL, '2020-11-25 10:19:16', '2020-11-25 10:19:12', 'absded-houdsfnsinou-2020-11-12-17-18', NULL);
/*!40000 ALTER TABLE `stock_inventaire` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_inventaire_detail
CREATE TABLE IF NOT EXISTS `stock_inventaire_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventaire_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `stock_theorique` double NOT NULL,
  `stock_reel` double NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FD9A7A28CE430A85` (`inventaire_id`),
  KEY `IDX_FD9A7A287294869C` (`article_id`),
  CONSTRAINT `FK_FD9A7A287294869C` FOREIGN KEY (`article_id`) REFERENCES `stock_produit` (`id`),
  CONSTRAINT `FK_FD9A7A28CE430A85` FOREIGN KEY (`inventaire_id`) REFERENCES `stock_inventaire` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_inventaire_detail : ~60 rows (environ)
/*!40000 ALTER TABLE `stock_inventaire_detail` DISABLE KEYS */;
INSERT INTO `stock_inventaire_detail` (`id`, `inventaire_id`, `article_id`, `stock_theorique`, `stock_reel`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`) VALUES
	(1, 2, 4, 2, 2, NULL, '', NULL, NULL, 0),
	(2, 2, 6, 20, 21, NULL, '', NULL, NULL, 0),
	(3, 2, 8, 3, 3, NULL, '', NULL, NULL, 0),
	(4, 2, 10, 0, 0, NULL, '', NULL, NULL, 0),
	(5, 3, 4, 2, 2, NULL, '', NULL, NULL, 0),
	(6, 3, 6, 20, 22, NULL, '', NULL, NULL, 0),
	(7, 3, 8, 3, 2, NULL, '', NULL, NULL, 0),
	(8, 3, 10, 0, 0, NULL, '', NULL, NULL, 0),
	(9, 4, 4, 2, 2, NULL, '', NULL, NULL, 0),
	(10, 4, 6, 21, 21, NULL, '', NULL, NULL, 0),
	(11, 4, 8, 3, 3, NULL, '', NULL, NULL, 0),
	(12, 4, 10, 0, 0, NULL, '', NULL, NULL, 0),
	(13, 5, 4, 2, 2, NULL, '', NULL, NULL, 0),
	(14, 5, 6, 21, 21, NULL, '', NULL, NULL, 0),
	(15, 5, 8, 3, 3, NULL, '', NULL, NULL, 0),
	(16, 5, 10, 0, 0, NULL, '', NULL, NULL, 0),
	(17, 8, 6, 5857, 5857, '2020-10-21 16:45:08', 'z', NULL, NULL, 0),
	(18, 8, 8, 77780, 77780, '2020-10-21 16:45:08', 'z', NULL, NULL, 0),
	(19, 8, 10, 0, 0, '2020-10-21 16:45:08', 'z', NULL, NULL, 0),
	(20, 8, 12, 0, 0, '2020-10-21 16:45:08', 'z', NULL, NULL, 0),
	(21, 8, 15, 0, 0, '2020-10-21 16:45:08', 'z', NULL, NULL, 0),
	(22, 9, 6, 5857, 5857, '2020-10-26 17:02:35', 'z', NULL, NULL, 0),
	(23, 9, 8, 77780, 77780, '2020-10-26 17:02:35', 'z', NULL, NULL, 0),
	(24, 9, 10, 0, 0, '2020-10-26 17:02:35', 'z', NULL, NULL, 0),
	(25, 9, 12, 0, 0, '2020-10-26 17:02:35', 'z', NULL, NULL, 0),
	(26, 9, 15, 0, 0, '2020-10-26 17:02:35', 'z', NULL, NULL, 0),
	(27, 10, 6, 5857, 5857, '2020-10-26 17:06:20', 'z', NULL, NULL, 0),
	(28, 10, 10, 0, 0, '2020-10-26 17:06:20', 'z', NULL, NULL, 0),
	(29, 10, 12, 0, 0, '2020-10-26 17:06:20', 'z', NULL, NULL, 0),
	(30, 10, 15, 0, 0, '2020-10-26 17:06:20', 'z', NULL, NULL, 0),
	(31, 11, 6, 5857, 5857, '2020-10-26 17:06:38', 'z', NULL, NULL, 0),
	(32, 11, 10, 0, 0, '2020-10-26 17:06:38', 'z', NULL, NULL, 0),
	(33, 11, 12, 0, 0, '2020-10-26 17:06:38', 'z', NULL, NULL, 0),
	(34, 11, 15, 0, 0, '2020-10-26 17:06:38', 'z', NULL, NULL, 0),
	(35, 12, 6, 5942, 5942, '2020-11-03 15:06:48', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(36, 12, 10, 0, 0, '2020-11-03 15:06:48', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(37, 12, 12, 0, 0, '2020-11-03 15:06:48', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(38, 12, 15, 0, 0, '2020-11-03 15:06:48', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(39, 12, 17, 0, 0, '2020-11-03 15:06:48', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(40, 13, 6, 5942, 5942, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(41, 13, 10, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(42, 13, 12, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(43, 13, 15, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(44, 13, 17, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(45, 13, 18, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(46, 13, 19, 0, 0, '2020-11-11 16:01:01', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(47, 14, 6, 14474, 14474, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(48, 14, 10, 0, 0, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(49, 14, 12, 562, 562, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(50, 14, 15, 0, 0, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(51, 14, 17, 0, 0, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(52, 14, 18, 0, 0, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(53, 14, 19, 0, 0, '2020-11-13 08:51:47', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(54, 15, 6, 14524, 14524, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(55, 15, 10, 0, 0, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(56, 15, 12, 562, 562, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(57, 15, 15, 0, 0, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(58, 15, 17, 0, 0, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(59, 15, 18, 10, 10, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(60, 15, 19, 0, 0, '2020-11-16 19:41:36', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0),
	(61, 16, 6, 14578, 14578, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(62, 16, 10, 0, 0, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(63, 16, 12, 562, 562, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(64, 16, 15, 0, 0, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(65, 16, 17, 0, 0, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(66, 16, 18, 10, 10, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0),
	(67, 16, 19, 0, 0, '2020-11-25 10:19:16', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, NULL, 0);
/*!40000 ALTER TABLE `stock_inventaire_detail` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. stock_produit
CREATE TABLE IF NOT EXISTS `stock_produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agence_id_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) NOT NULL,
  `societe_id` int(11) NOT NULL,
  `taxe_groupe_id` int(11) DEFAULT NULL,
  `unite_mesure_id` int(11) DEFAULT NULL,
  `reference` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix_unitaire_vente` double NOT NULL,
  `est_actif` tinyint(1) NOT NULL,
  `est_supprimer` tinyint(1) NOT NULL,
  `est_perimer` tinyint(1) NOT NULL,
  `est_perissable` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_interne` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `date_peremption` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stockDisponible` double DEFAULT NULL,
  `stockAlerte` double DEFAULT NULL,
  `stockMinimum` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3003FC8427B53334` (`reference_interne`),
  KEY `IDX_3003FC84D1F6E7C3` (`agence_id_id`),
  KEY `IDX_3003FC84BCF5E72D` (`categorie_id`),
  KEY `IDX_3003FC84FCF77503` (`societe_id`),
  KEY `IDX_3003FC84268B77D5` (`taxe_groupe_id`),
  KEY `IDX_3003FC84C75A06BF` (`unite_mesure_id`),
  CONSTRAINT `FK_3003FC84268B77D5` FOREIGN KEY (`taxe_groupe_id`) REFERENCES `config_taxe_groupe` (`id`),
  CONSTRAINT `FK_3003FC84BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `stock_categogie` (`id`),
  CONSTRAINT `FK_3003FC84C75A06BF` FOREIGN KEY (`unite_mesure_id`) REFERENCES `config_unite_mesure` (`id`),
  CONSTRAINT `FK_3003FC84D1F6E7C3` FOREIGN KEY (`agence_id_id`) REFERENCES `config_agence` (`id`),
  CONSTRAINT `FK_3003FC84FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.stock_produit : ~17 rows (environ)
/*!40000 ALTER TABLE `stock_produit` DISABLE KEYS */;
INSERT INTO `stock_produit` (`id`, `agence_id_id`, `categorie_id`, `societe_id`, `taxe_groupe_id`, `unite_mesure_id`, `reference`, `designation`, `prix_unitaire_vente`, `est_actif`, `est_supprimer`, `est_perimer`, `est_perissable`, `description`, `reference_interne`, `created`, `date_peremption`, `updated_at`, `createdBy`, `updateBy`, `type`, `stockDisponible`, `stockAlerte`, `stockMinimum`) VALUES
	(4, 1, 1, 4, NULL, NULL, 'ART0001', 'Article 1', 2500, 1, 1, 0, 0, NULL, 'a', '2020-02-13 11:47:45', NULL, '2020-10-21 16:09:06', '', 'z', 'article', 450566, 5, 3),
	(5, 1, 1, 1, NULL, 2, 'SER0001', 'Service 1', 800, 1, 0, 0, 0, NULL, 'z', '2020-02-13 11:48:38', NULL, '2020-02-13 11:48:38', '', NULL, 'service', NULL, NULL, NULL),
	(6, 25, 1, 1, NULL, NULL, 'ART0002', 'Article 2', 1500, 1, 0, 0, 0, NULL, 'e', '2020-12-28 18:14:20', NULL, '2020-11-03 14:38:54', 'abedr-hounsinouret-2020-11-16-08-40', 'abed-abed-2020-10-27-18-03', 'article', 14576, 8, 5),
	(7, 28, 1, 4, NULL, 3, 'SER0002', 'Service 2', 2000, 1, 0, 0, 0, NULL, 'r', '2020-02-13 11:50:28', NULL, '2020-02-13 11:50:28', '', NULL, 'service', NULL, NULL, NULL),
	(8, 1, 1, 4, NULL, NULL, 'ART0003', 'Article 3', 12500, 1, 0, 0, 0, NULL, 't', '2020-02-25 18:10:32', NULL, '2020-02-25 18:10:32', '', NULL, 'article', 77780, 3, 2),
	(9, 1, 1, 1, NULL, 3, 'SER0003', 'Service 3', 4500, 1, 0, 0, 0, NULL, 'y', '2020-02-26 10:41:13', NULL, '2020-10-21 12:18:21', '', 'z', 'service', NULL, NULL, NULL),
	(10, 3, 1, 1, NULL, NULL, 'ART0004', 'Article 4', 3650, 1, 0, 0, 0, NULL, 'u', '2020-11-03 15:07:04', NULL, '2020-03-05 15:41:12', 'abed-abed-2020-10-27-18-03', NULL, 'article', 0, 6, 4),
	(11, 23, 1, 4, NULL, 3, 'SER0004', 'Service 4', 2000, 1, 0, 0, 0, NULL, 'i', '2020-03-05 15:46:38', NULL, '2020-10-21 12:23:08', '', 'z', 'service', NULL, NULL, NULL),
	(12, 3, 1, 1, NULL, NULL, 'ART0005', 'Aaaahg', 20, 1, 0, 0, 0, 'ya', '3587564', '2020-11-03 15:07:04', '2020-10-21 11:26:42', '2020-10-21 16:09:29', 'abed-abed-2020-10-27-18-03', 'z', 'article', 562, 52, 10),
	(13, 3, 1, 4, NULL, NULL, 'ART0006', 'AErtgrgezbed', 564, 1, 1, 0, 0, 'sdtgztg', 'p', '2020-10-21 11:36:27', '2020-10-21 11:36:27', '2020-10-21 13:07:06', 'z', 'z', 'article', 0, 653, 100),
	(14, 27, 1, 1, NULL, 1, 'SER0005', 'Rfgteg', 2333, 1, 1, 0, 0, NULL, 'd', '2020-10-21 11:44:59', '2020-10-21 11:44:58', '2020-10-21 12:39:46', 'z', 'z', 'service', NULL, NULL, NULL),
	(15, 25, 1, 1, NULL, NULL, 'ART0007', 'Ertgrgergez', 564, 1, 0, 0, 0, 'arevcfgfq gq', 'aT', '2020-11-03 15:07:04', '2020-10-21 16:02:58', '2020-10-21 16:02:58', 'abed-abed-2020-10-27-18-03', NULL, 'article', 0, 5, 5),
	(16, 1, 1, 4, NULL, 2, 'SER0006', 'ABEDRfgzRteg', 2333, 1, 0, 0, 0, 'GVBSQG', 'T62487', '2020-10-21 16:22:24', '2020-10-21 16:22:24', '2020-10-21 16:22:24', 'z', NULL, 'service', NULL, NULL, NULL),
	(17, 23, 1, 1, NULL, NULL, 'ST01ART86588', 'Ref', 564, 1, 0, 0, 0, 'sfvqzerf', '35875', '2020-11-03 15:07:04', '2020-11-03 14:41:47', '2020-11-03 14:41:47', 'abed-abed-2020-10-27-18-03', NULL, 'article', 0, 65, 2),
	(18, 1, 1, 1, NULL, NULL, 'ST01ART28619', 'Riz Brézilien', 850, 1, 0, 0, 0, 'Trés interressant', '358777', '2020-11-11 15:31:32', '2020-11-11 15:31:32', '2020-11-11 15:32:24', 'abed-abed-2020-10-27-18-03', 'abed-abed-2020-10-27-18-03', 'article', 10, 158, 85),
	(19, 2, 1, 1, NULL, NULL, 'ST01ART59763', 'Razefre', 564, 1, 0, 0, 0, 'aeferagf', '3587515177', '2020-11-11 15:34:02', '2020-11-11 15:34:01', '2020-11-11 15:34:01', 'abed-abed-2020-10-27-18-03', NULL, 'article', 0, 52, 8),
	(20, NULL, 1, 1, NULL, 2, 'ST01SERV15851', 'Rtfrqss', 250, 1, 0, 0, 0, 'La belle vie', '234', '2020-11-11 16:37:20', '2020-11-11 16:37:20', '2020-11-11 16:37:20', 'abed-abed-2020-10-27-18-03', NULL, 'service', NULL, NULL, NULL),
	(21, 1, 4, 1, 2, NULL, 'ST01ART33835', 'Sorgo', 564, 1, 0, 0, 0, 'Céréale', '3587cvx77', '2020-12-08 17:30:31', '2020-12-08 17:30:28', '2020-12-08 17:30:28', 'absded-houdsfnsinou-2020-11-12-17-18', NULL, 'article', 0, 80, 20);
/*!40000 ALTER TABLE `stock_produit` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. tiers_client
CREATE TABLE IF NOT EXISTS `tiers_client` (
  `id` int(11) NOT NULL,
  `est_personne_moral` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_1F5F5AE5BF396750` FOREIGN KEY (`id`) REFERENCES `tiers_tiers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.tiers_client : ~16 rows (environ)
/*!40000 ALTER TABLE `tiers_client` DISABLE KEYS */;
INSERT INTO `tiers_client` (`id`, `est_personne_moral`) VALUES
	(3, 0),
	(4, 0),
	(5, 0),
	(7, 0),
	(8, 0),
	(10, 0),
	(11, 0),
	(12, 0),
	(13, 0),
	(14, 0),
	(15, 0),
	(17, 0),
	(18, 0),
	(19, 0),
	(21, 0),
	(23, 0);
/*!40000 ALTER TABLE `tiers_client` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. tiers_fournisseur
CREATE TABLE IF NOT EXISTS `tiers_fournisseur` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_5419B931BF396750` FOREIGN KEY (`id`) REFERENCES `tiers_tiers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.tiers_fournisseur : ~9 rows (environ)
/*!40000 ALTER TABLE `tiers_fournisseur` DISABLE KEYS */;
INSERT INTO `tiers_fournisseur` (`id`) VALUES
	(1),
	(2),
	(6),
	(20),
	(22),
	(24),
	(25),
	(26),
	(27);
/*!40000 ALTER TABLE `tiers_fournisseur` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. tiers_tiers
CREATE TABLE IF NOT EXISTS `tiers_tiers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) NOT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ifu` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_32510A6C6E55B5` (`nom`),
  UNIQUE KEY `UNIQ_32510AAB8F602F` (`ifu`),
  KEY `IDX_32510AFCF77503` (`societe_id`),
  KEY `IDX_32510AA6E44244` (`pays_id`),
  CONSTRAINT `FK_32510AA6E44244` FOREIGN KEY (`pays_id`) REFERENCES `config_pays_lang` (`id`),
  CONSTRAINT `FK_32510AFCF77503` FOREIGN KEY (`societe_id`) REFERENCES `config_societe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.tiers_tiers : ~25 rows (environ)
/*!40000 ALTER TABLE `tiers_tiers` DISABLE KEYS */;
INSERT INTO `tiers_tiers` (`id`, `societe_id`, `pays_id`, `code`, `nom`, `adresse`, `mail`, `telephone`, `ifu`, `created`, `createdBy`, `updateAt`, `updateBy`, `estSupprimer`, `type`) VALUES
	(1, 1, 1, 'FRS0001', 'Akidos', 'Akpakpa', '', '21 45 20 14', '2055484841253', '2020-10-19 16:56:18', NULL, NULL, NULL, 0, 'tiersFournisseur'),
	(2, 4, 2, 'FRS0002', 'ZAPATA', 'sicile', '', '+36 4949494', '8797997', '2020-10-19 16:56:23', NULL, NULL, NULL, 0, 'tiersFournisseur'),
	(3, 1, 1, 'CLT0001', 'Banana Samad', 'Cotonou', '', '854123694', '818181811881818', '2020-10-19 16:56:24', NULL, NULL, NULL, 0, 'tiersClient'),
	(4, 1, 2, 'CLT0002', 'Madara Saka', 'Kindonou', '', '95199756', '5411651515161', '2020-10-19 16:56:25', NULL, NULL, NULL, 0, 'tiersClient'),
	(5, 4, 3, 'CLT0003', 'Badarou OYENIRAN', 'Cotonou', '', '+229 95 19 97 56', '884', '2020-10-19 16:56:26', NULL, NULL, NULL, 0, 'tiersClient'),
	(6, 1, 3, 'FRS0003', 'Pablo Maserati', 'Fidjrossè Calvaire', '', '+36 545321688', '2055484841221', '2020-10-19 16:56:27', NULL, NULL, NULL, 0, 'tiersFournisseur'),
	(7, 1, 2, 'CLT0004', 'Binaté Kader', 'Akpakpa Avotrou', '', '+229 95 23 97 55', '5411652815181', '2020-10-19 16:56:27', NULL, NULL, NULL, 0, 'tiersClient'),
	(8, 4, 2, 'CLT0005', 'Willy Bayala', 'Cotonou', '', '+229 95 19 97 56', '818181811881811', '2020-10-19 16:56:28', NULL, NULL, NULL, 0, 'tiersClient'),
	(10, 1, 1, 'CLT0006', 'Zato Garba', 'Akpakpa Avotrou', '', '+229 95 19 97 56', '5411651515165', '2020-10-19 16:56:28', NULL, NULL, NULL, 0, 'tiersClient'),
	(11, 1, 3, 'CLT0007', 'Owen Boat', 'Haie Vive', '', '+229 54 12 36 96', '5411652415181', '2020-10-19 16:56:29', NULL, NULL, NULL, 0, 'tiersClient'),
	(12, 4, 1, 'CLT0008', 'Uncle Sam', 'Haie Vive', '', '+229 588454545', '54116514526160', '2020-10-19 16:56:30', NULL, NULL, NULL, 0, 'tiersClient'),
	(13, 1, 3, 'CLT0009', 'Zoé Camara', 'Kindonou', '', '+229 95 19 97 56', '541165151516147', '2020-10-19 16:56:29', NULL, NULL, NULL, 0, 'tiersClient'),
	(14, 1, 1, 'CLT0010', 'Ake Waz', 'Cotonou', 'akewaz@gmail.com', '+229 95 19 97 43', '5413651523169', '2020-10-19 16:56:31', NULL, NULL, NULL, 0, 'tiersClient'),
	(15, 4, 1, 'CLT0011', 'Wence Bocode', 'Kindonou', '', '+229 95 21 96 54', '5411651515162', '2020-10-19 16:56:31', NULL, NULL, NULL, 0, 'tiersClient'),
	(17, 1, 1, 'CLT0012', 'Waza', 'Cotonou', '', '95199756', '818181811881888', '2020-10-19 16:56:33', NULL, NULL, NULL, 0, 'tiersClient'),
	(18, 1, 1, 'CLT0013', 'Hounssqinou', '02bfp404', 'abed@gamil.coms', '61169769', '3243876542645', '2020-10-19 15:49:44', 'z', NULL, NULL, 0, 'tiersClient'),
	(19, 4, 1, 'CLT0014', 'Houenou', '02bfpfz404', 'abefd@gazmil.coms', '61169769', '3243876542646', '2020-10-19 15:52:35', 'z', '2020-10-19 16:59:01', 'z', 0, 'tiersClient'),
	(20, 1, 2, 'FRS0004', 'Hounsindou', '02bwsp404', 'abed.hounsinou@gmail.com', '64469338', '1111111111116', '2020-10-21 11:21:32', 'z', '2020-10-21 11:58:34', 'z', 0, 'tiersFournisseur'),
	(21, 1, 3, 'CLT0015', 'Hounezsinou', '02bpe404', 'abeed@gamil.com', '61169700', '7896541231234', '2020-10-21 11:23:48', 'z', '2020-10-21 11:24:00', 'z', 0, 'tiersClient'),
	(22, 4, 1, 'FRS0005', 'Houzensinou', '02bp404z', 'abed.hounsinozu@gmail.com', '64469339', '1111111111115', '2020-10-21 11:50:21', 'z', '2020-10-21 12:04:03', 'z', 1, 'tiersFournisseur'),
	(23, 1, 2, 'CLT0016', 'Hounsinoutfyj', '02bp404', 'abed@gamil.comd', '61169769', '7896541731234', '2020-10-21 12:05:18', 'z', '2020-10-21 12:08:55', 'z', 1, 'tiersClient'),
	(24, 1, 107, 'ST0129644', 'XdzfA', '02bp404', 'abed.hounsinou@gmail.com', '14562345', '1111111111114', '2020-11-11 12:12:06', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0, 'tiersFournisseur'),
	(25, 1, 107, 'ST0149610', 'XdzfAfg', '02bp404', 'abed.hounsinou@gmail.com', '14562345', '1111111111113', '2020-11-11 13:24:22', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0, 'tiersFournisseur'),
	(26, 1, 35, 'ST0172842', 'Zfz', 'Zae', 'abed.houzednsinou@gmail.com', '14562345', '1111111111112', '2020-11-12 18:12:52', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0, 'tiersFournisseur'),
	(27, 1, 107, 'ST0151843', 'Zefd', 'Zef', 'abed.houzafnsinou@gmail.com', '14562345', NULL, '2020-11-12 18:15:35', 'abed-abed-2020-10-27-18-03', NULL, NULL, 0, 'tiersFournisseur');
/*!40000 ALTER TABLE `tiers_tiers` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. user_agence
CREATE TABLE IF NOT EXISTS `user_agence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `agence_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1938194A76ED395` (`user_id`),
  KEY `IDX_1938194D725330D` (`agence_id`),
  CONSTRAINT `FK_1938194A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_1938194D725330D` FOREIGN KEY (`agence_id`) REFERENCES `config_agence` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.user_agence : ~0 rows (environ)
/*!40000 ALTER TABLE `user_agence` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_agence` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. user_mouchard
CREATE TABLE IF NOT EXISTS `user_mouchard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_action` datetime NOT NULL,
  `entity_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code_app` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `est_recupere` tinyint(1) DEFAULT NULL,
  `estSupprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.user_mouchard : ~0 rows (environ)
/*!40000 ALTER TABLE `user_mouchard` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_mouchard` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. user_societe
CREATE TABLE IF NOT EXISTS `user_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `agence_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `updateBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supprimer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_416823B7A76ED395` (`user_id`),
  KEY `IDX_416823B7D725330D` (`agence_id`),
  CONSTRAINT `FK_416823B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_416823B7D725330D` FOREIGN KEY (`agence_id`) REFERENCES `config_agence` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.user_societe : ~0 rows (environ)
/*!40000 ALTER TABLE `user_societe` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_societe` ENABLE KEYS */;

-- Listage de la structure de la table facturation_db. user_user
CREATE TABLE IF NOT EXISTS `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `userPublicId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F7129A8092FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_F7129A80A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_F7129A80C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table facturation_db.user_user : ~0 rows (environ)
/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;
INSERT INTO `user_user` (`id`, `password`, `email`, `enabled`, `roles`, `userPublicId`, `username`, `username_canonical`, `email_canonical`, `salt`, `last_login`, `confirmation_token`, `password_requested_at`) VALUES
	(1, 'Dossou paul', 'paul@gmail.com', 1, 'a:1:{i:0;s:7:"ROLE_RH";}', 'Bb8IMY8qETj0yNS6SsEBYXVMD', 'paul', '', '', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
