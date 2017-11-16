-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Nov 16, 2017 alle 12:53
-- Versione del server: 10.1.16-MariaDB
-- Versione PHP: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mangacards`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amazon`
--

CREATE TABLE `amazon` (
  `NomeOfferta` varchar(255) CHARACTER SET latin1 NOT NULL,
  `TipoProdotto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Serie` varchar(255) CHARACTER SET latin1 NOT NULL,
  `DataUscita` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prezzo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Autore` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Piattaforma` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LinkAcquisto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `comics`
--

CREATE TABLE `comics` (
  `Nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NomeOriginale` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Autori` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Testi` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Disegni` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Editore` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `episodi_anime`
--

CREATE TABLE `episodi_anime` (
  `Numero` int(255) NOT NULL,
  `NomeAnime` varchar(255) CHARACTER SET latin1 NOT NULL,
  `VersioneAnime` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NomeEpisodio` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DataJPN` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `DataITA` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Trama` varchar(2555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `extra_anime`
--

CREATE TABLE `extra_anime` (
  `Nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NomeAnime` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Tipo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `DataUscita` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `gamestop`
--

CREATE TABLE `gamestop` (
  `NomeOfferta` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Serie` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Piattaforma` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Produttore` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Prezzo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `PrezzoUsato` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `DataUscita` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `PEGI` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LinkAcquisto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `jpop`
--

CREATE TABLE `jpop` (
  `NomeOfferta` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Serie` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Prezzo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Autore` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Dettagli` varchar(2555) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LinkAcquisto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `manga`
--

CREATE TABLE `manga` (
  `Nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NomeOriginale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Autori` varchar(255) CHARACTER SET latin1 NOT NULL,
  `EditoreITA` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NumVolJPN` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NumVolITA` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `panini`
--

CREATE TABLE `panini` (
  `NomeOfferta` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Serie` varchar(255) CHARACTER SET latin1 NOT NULL,
  `TipoProdotto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Autori` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Descrizione` varchar(2555) CHARACTER SET latin1 DEFAULT NULL,
  `Edizione` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `InfoEdizione` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Prezzo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `PrezzoScontato` varchar(255) CHARACTER SET latin1 NOT NULL,
  `DataUscita` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LinkAcquisto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `NumeroVolume` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `rwedizioni`
--

CREATE TABLE `rwedizioni` (
  `NomeOfferta` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Serie` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Linea` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Collana` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `SerieEditoriale` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Autori` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Prezzo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `DataUscita` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Contenuti` varchar(2555) CHARACTER SET latin1 DEFAULT NULL,
  `Descrizione` varchar(2555) CHARACTER SET latin1 DEFAULT NULL,
  `Immagine` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LinkAcquisto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `volumi_manga`
--

CREATE TABLE `volumi_manga` (
  `Numero` varchar(255) CHARACTER SET latin1 NOT NULL,
  `NomeManga` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NomeVolume` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DataJPN` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `DataITA` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Trama` varchar(2555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ListaCapitoli` varchar(2555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Creation_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `amazon`
--
ALTER TABLE `amazon`
  ADD PRIMARY KEY (`NomeOfferta`,`TipoProdotto`,`Serie`);

--
-- Indici per le tabelle `comics`
--
ALTER TABLE `comics`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `episodi_anime`
--
ALTER TABLE `episodi_anime`
  ADD PRIMARY KEY (`Numero`,`NomeAnime`);

--
-- Indici per le tabelle `extra_anime`
--
ALTER TABLE `extra_anime`
  ADD PRIMARY KEY (`Nome`,`NomeAnime`);

--
-- Indici per le tabelle `gamestop`
--
ALTER TABLE `gamestop`
  ADD PRIMARY KEY (`NomeOfferta`,`Serie`,`Piattaforma`);

--
-- Indici per le tabelle `jpop`
--
ALTER TABLE `jpop`
  ADD PRIMARY KEY (`NomeOfferta`,`Serie`);

--
-- Indici per le tabelle `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `panini`
--
ALTER TABLE `panini`
  ADD PRIMARY KEY (`NomeOfferta`,`Serie`);

--
-- Indici per le tabelle `rwedizioni`
--
ALTER TABLE `rwedizioni`
  ADD PRIMARY KEY (`NomeOfferta`,`Serie`);

--
-- Indici per le tabelle `volumi_manga`
--
ALTER TABLE `volumi_manga`
  ADD PRIMARY KEY (`Numero`,`NomeManga`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
