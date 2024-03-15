-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 25 avr. 2022 à 09:58
-- Version du serveur :  10.3.34-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mamo9937_elyamaje`
--

-- --------------------------------------------------------

--
-- Structure de la table `accountambassadrices`
--

CREATE TABLE `accountambassadrices` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_commande` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_mois` tinyint(2) DEFAULT NULL,
  `annee` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` double(11,5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accountambassadrices`
--


-- --------------------------------------------------------

--
-- Structure de la table `accountpartenaires`
--

CREATE TABLE `accountpartenaires` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_commande` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_mois` tinyint(4) NOT NULL,
  `annee` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` decimal(11,4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accountpartenaires`
--

-- --------------------------------------------------------

--
-- Structure de la table `ambassadricecustomers`
--

CREATE TABLE `ambassadricecustomers` (
  `id` int(11) NOT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `is_admin` tinyint(11) DEFAULT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_promo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ambassadricecustomers`
--


-- --------------------------------------------------------

--
-- Structure de la table `ambassadrics`
--

CREATE TABLE `ambassadrics` (
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_commande` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ambassadrics`
--


-- --------------------------------------------------------

--
-- Structure de la table `bilandates`
--

CREATE TABLE `bilandates` (
  `id` int(11) NOT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `id_mois` int(2) NOT NULL,
  `date_jour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_annee` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bilandates`
--


-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_parent` int(11) NOT NULL DEFAULT 0,
  `label` varchar(180) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `color` varchar(8) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `import_key` varchar(14) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--


-- --------------------------------------------------------

--
-- Structure de la table `categorie_products`
--

CREATE TABLE `categorie_products` (
  `fk_categorie` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie_products`
--


-- --------------------------------------------------------

--
-- Structure de la table `codelives`
--

CREATE TABLE `codelives` (
  `id` int(11) NOT NULL,
  `is_admin` tinyint(2) NOT NULL,
  `code_live` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `codelives`
--


-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `id_coupons` int(11) NOT NULL,
  `code_promos` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `coupons`
--


-- --------------------------------------------------------

--
-- Structure de la table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `productid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `videos` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `data`
--


--
-- Structure de la table `datas`
--

CREATE TABLE `datas` (
  `id` int(11) NOT NULL,
  `productid` mediumint(8) NOT NULL,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_cercle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `videos` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ordercodepromoaffichage`
--

CREATE TABLE `ordercodepromoaffichage` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_promo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `csss` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cssss` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orderproduct`
--

CREATE TABLE `orderproduct` (
  `id` int(11) NOT NULL,
  `numero_order` int(11) NOT NULL,
  `product` varchar(150) NOT NULL,
  `total_achat_ht` decimal(11,5) NOT NULL,
  `total_achat_ttc` decimal(11,5) NOT NULL,
  `total_tv` decimal(11,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `satuts` int(11) NOT NULL,
  `origine` varchar(130) NOT NULL,
  `lastname` varchar(120) NOT NULL,
  `firtsname` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `total_ttc` decimal(10,5) NOT NULL,
  `tva` double(11,5) NOT NULL,
  `total_ht` decimal(11,5) NOT NULL,
  `product_info` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ordersambassadricecustoms`
--

CREATE TABLE `ordersambassadricecustoms` (
  `id` int(11) NOT NULL,
  `datet` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_promo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_commande` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ambassadrice` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `somme` decimal(14,11) NOT NULL,
  `some_tva` decimal(14,11) DEFAULT NULL,
  `notification` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_mois` tinyint(2) NOT NULL,
  `annee` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_live` tinyint(4) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ordersambassadricecustoms`
--


--
-- Structure de la table `orderutilisateurs`
--

CREATE TABLE `orderutilisateurs` (
  `id` int(11) NOT NULL,
  `datet` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ambassadrice` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_promo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `somme` decimal(11,5) NOT NULL,
  `ref_facture` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `utilisateur` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orderutilisateurs`
--


-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(19, 'martial@elyamaje.com', 'kcLq7ylf65vj1BmVuvoAS553y4K205vEPEMv55vjsQDVaGHT9gEszxuo00Q9kOIe', '2022-02-21 13:42:44');

-- --------------------------------------------------------

--
-- Structure de la table `permissioncodes`
--

CREATE TABLE `permissioncodes` (
  `id` int(11) NOT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datet` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pointbilans`
--

CREATE TABLE `pointbilans` (
  `id` int(11) NOT NULL,
  `id_ambassadrice` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mois` tinyint(4) NOT NULL,
  `mois` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `somme` decimal(11,4) NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pointbilans`
--


-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_reel` mediumint(8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--


-- --------------------------------------------------------

--
-- Structure de la table `recapaccounts`
--

CREATE TABLE `recapaccounts` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double(11,5) DEFAULT NULL,
  `montants` decimal(11,5) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_account` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actif` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_select` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribut` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addresse` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(2) DEFAULT NULL,
  `code_live` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acces_account` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accountambassadrices`
--
ALTER TABLE `accountambassadrices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `code_mois` (`code_mois`),
  ADD KEY `annee` (`annee`);

--
-- Index pour la table `accountpartenaires`
--
ALTER TABLE `accountpartenaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code_mois` (`code_mois`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `ambassadricecustomers`
--
ALTER TABLE `ambassadricecustomers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_amabassadrice` (`id_ambassadrice`),
  ADD KEY `date` (`date`),
  ADD KEY `email` (`email`),
  ADD KEY `code_postal` (`code_postal`) USING BTREE,
  ADD KEY `is_admin` (`is_admin`);

--
-- Index pour la table `ambassadrics`
--
ALTER TABLE `ambassadrics`
  ADD KEY `code_promo` (`id_commande`),
  ADD KEY `id_commande` (`nom`) USING BTREE;

--
-- Index pour la table `bilandates`
--
ALTER TABLE `bilandates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ambassadrice` (`id_ambassadrice`),
  ADD KEY `id_mois` (`id_mois`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_categorie_ref` (`entity`,`fk_parent`,`label`,`type`),
  ADD KEY `idx_categorie_type` (`type`),
  ADD KEY `idx_categorie_label` (`label`);

--
-- Index pour la table `categorie_products`
--
ALTER TABLE `categorie_products`
  ADD PRIMARY KEY (`fk_categorie`,`fk_product`),
  ADD KEY `idx_categorie_product_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_product_fk_product` (`fk_product`);

--
-- Index pour la table `codelives`
--
ALTER TABLE `codelives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ambassadrice` (`id_ambassadrice`),
  ADD UNIQUE KEY `code_live` (`code_live`),
  ADD KEY `is_admin` (`is_admin`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_coupons` (`id_coupons`),
  ADD KEY `code_promo` (`code_promos`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `datas`
--
ALTER TABLE `datas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_p` (`productid`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ambassadrice` (`id_ambassadrice`);

--
-- Index pour la table `ordercodepromoaffichage`
--
ALTER TABLE `ordercodepromoaffichage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `code_promo` (`code_promo`);

--
-- Index pour la table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_order` (`numero_order`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id_order` (`id_order`);

--
-- Index pour la table `ordersambassadricecustoms`
--
ALTER TABLE `ordersambassadricecustoms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_commande` (`id_commande`),
  ADD KEY `code_barre` (`code_promo`),
  ADD KEY `id_ambassadrice` (`id_ambassadrice`),
  ADD KEY `code_mois` (`code_mois`),
  ADD KEY `code_live` (`code_live`),
  ADD KEY `annee` (`annee`),
  ADD KEY `is_admin` (`is_admin`);

--
-- Index pour la table `orderutilisateurs`
--
ALTER TABLE `orderutilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_amabassadrice` (`id_ambassadrice`),
  ADD KEY `code_promo` (`code_promo`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissioncodes`
--
ALTER TABLE `permissioncodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ambassadrice` (`id_ambassadrice`),
  ADD KEY `email` (`email`);

--
-- Index pour la table `pointbilans`
--
ALTER TABLE `pointbilans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_mois` (`id_mois`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_product` (`id_product`);

--
-- Index pour la table `recapaccounts`
--
ALTER TABLE `recapaccounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `code_pastal` (`code_postal`),
  ADD KEY `actif` (`actif`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accountambassadrices`
--
ALTER TABLE `accountambassadrices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `accountpartenaires`
--
ALTER TABLE `accountpartenaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `ambassadricecustomers`
--
ALTER TABLE `ambassadricecustomers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pour la table `bilandates`
--
ALTER TABLE `bilandates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `codelives`
--
ALTER TABLE `codelives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2299;

--
-- AUTO_INCREMENT pour la table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT pour la table `datas`
--
ALTER TABLE `datas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ordercodepromoaffichage`
--
ALTER TABLE `ordercodepromoaffichage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orderproduct`
--
ALTER TABLE `orderproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ordersambassadricecustoms`
--
ALTER TABLE `ordersambassadricecustoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT pour la table `orderutilisateurs`
--
ALTER TABLE `orderutilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `permissioncodes`
--
ALTER TABLE `permissioncodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pointbilans`
--
ALTER TABLE `pointbilans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT pour la table `recapaccounts`
--
ALTER TABLE `recapaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
