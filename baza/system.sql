-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Wrz 2020, 21:20
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `system`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresykontrahentow`
--

CREATE TABLE `adresykontrahentow` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `ulica` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `numer` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `kod` varchar(6) COLLATE utf8_polish_ci NOT NULL,
  `miasto` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aplikacje`
--

CREATE TABLE `aplikacje` (
  `id` int(3) UNSIGNED NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `aplikacje`
--

INSERT INTO `aplikacje` (`id`, `nazwa`) VALUES
(1, 'eSekretariat');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aplikacje_moduly`
--

CREATE TABLE `aplikacje_moduly` (
  `id` int(10) UNSIGNED NOT NULL,
  `aplikacja` int(3) UNSIGNED NOT NULL,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `aplikacje_moduly`
--

INSERT INTO `aplikacje_moduly` (`id`, `aplikacja`, `nazwa`) VALUES
(1, 1, 'Dziennik wysyłek'),
(2, 1, 'Dziennik przyjęć'),
(3, 1, 'Dziennik delegacji');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostepy`
--

CREATE TABLE `dostepy` (
  `id` int(11) UNSIGNED NOT NULL,
  `uzytkownik` int(10) UNSIGNED NOT NULL,
  `aplikacja` int(3) UNSIGNED NOT NULL,
  `modul` int(10) UNSIGNED NOT NULL,
  `grupa` int(3) UNSIGNED NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dostepy`
--

INSERT INTO `dostepy` (`id`, `uzytkownik`, `aplikacja`, `modul`, `grupa`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 1),
(3, 1, 1, 3, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzialy`
--

CREATE TABLE `dzialy` (
  `id` int(3) UNSIGNED NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `skrot` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `dzialy`
--

INSERT INTO `dzialy` (`id`, `nazwa`, `skrot`) VALUES
(1, 'Administrator', 'ROOT'),
(2, 'Nie pracownik', '**');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `esekretariat_przychodzace`
--

CREATE TABLE `esekretariat_przychodzace` (
  `id` int(10) UNSIGNED NOT NULL,
  `nadawca` int(10) UNSIGNED NOT NULL,
  `temat` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `opisdodatkowy` text COLLATE utf8_polish_ci DEFAULT NULL,
  `datawplywu` date NOT NULL,
  `powiadomiono` text COLLATE utf8_polish_ci DEFAULT NULL,
  `zalacznik` text COLLATE utf8_polish_ci DEFAULT NULL,
  `datawystawienia` date DEFAULT NULL,
  `czypobrano` tinyint(4) DEFAULT NULL,
  `ktopobral` varchar(71) COLLATE utf8_polish_ci DEFAULT NULL,
  `dzial` int(3) UNSIGNED NOT NULL,
  `datapobrania` date DEFAULT NULL,
  `datawpisu` date NOT NULL,
  `wpisujacy` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `esekretariat_wychodzace`
--

CREATE TABLE `esekretariat_wychodzace` (
  `id` int(10) UNSIGNED NOT NULL,
  `adresat` int(10) UNSIGNED NOT NULL,
  `temat` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `datawyslania` date NOT NULL,
  `typnadania` int(5) UNSIGNED NOT NULL,
  `zalacznik` text COLLATE utf8_polish_ci DEFAULT NULL,
  `datawpisu` date NOT NULL,
  `wpisujacy` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id` int(3) UNSIGNED NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `grupy`
--

INSERT INTO `grupy` (`id`, `nazwa`) VALUES
(1, 'Root'),
(2, 'Administrator'),
(3, 'Użytkownik'),
(4, 'Podgląd'),
(5, 'Brak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `imiona`
--

CREATE TABLE `imiona` (
  `id` int(3) UNSIGNED NOT NULL,
  `imie` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `imiona`
--

INSERT INTO `imiona` (`id`, `imie`) VALUES
(1, ' '),
(2, 'Arkadiusz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nazwiska`
--

CREATE TABLE `nazwiska` (
  `id` int(3) UNSIGNED NOT NULL,
  `nazwisko` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `nazwiska`
--

INSERT INTO `nazwiska` (`id`, `nazwisko`) VALUES
(1, ' '),
(2, 'Orgaś');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prawemenu`
--

CREATE TABLE `prawemenu` (
  `id` int(11) NOT NULL,
  `uzytkownik` int(10) UNSIGNED NOT NULL,
  `todolist` tinyint(4) NOT NULL DEFAULT 0,
  `informacje` tinyint(4) NOT NULL DEFAULT 0,
  `zgloszeniaIT` tinyint(4) NOT NULL DEFAULT 0,
  `czat` tinyint(4) NOT NULL DEFAULT 0,
  `kalendarz` tinyint(4) NOT NULL DEFAULT 0,
  `aplikacje` tinyint(4) NOT NULL DEFAULT 0,
  `uzytkownicy` tinyint(4) NOT NULL DEFAULT 0,
  `dostepy` tinyint(4) NOT NULL DEFAULT 0,
  `zasobyIT` tinyint(4) NOT NULL DEFAULT 0,
  `ustawienia` tinyint(4) NOT NULL DEFAULT 0,
  `pomoc` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `prawemenu`
--

INSERT INTO `prawemenu` (`id`, `uzytkownik`, `todolist`, `informacje`, `zgloszeniaIT`, `czat`, `kalendarz`, `aplikacje`, `uzytkownicy`, `dostepy`, `zasobyIT`, `ustawienia`, `pomoc`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rejestracje`
--

CREATE TABLE `rejestracje` (
  `id` int(11) NOT NULL,
  `login` varchar(71) NOT NULL,
  `email` varchar(130) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `imie` int(3) UNSIGNED NOT NULL,
  `nazwisko` int(3) UNSIGNED NOT NULL,
  `kod` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `potwierdzone` int(1) DEFAULT NULL,
  `datarejestracji` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datapotwierdzenia` timestamp NULL DEFAULT NULL,
  `pracownik` tinyint(1) NOT NULL,
  `dzial` int(3) UNSIGNED DEFAULT NULL,
  `zaakceptowany` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stanowiska`
--

CREATE TABLE `stanowiska` (
  `id` int(3) UNSIGNED NOT NULL,
  `nazwa` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `stanowiska`
--

INSERT INTO `stanowiska` (`id`, `nazwa`) VALUES
(1, 'Root'),
(2, 'TMP');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `todolists`
--

CREATE TABLE `todolists` (
  `id` int(11) NOT NULL,
  `uzytkownik` int(10) UNSIGNED NOT NULL,
  `datawprowadzenia` datetime NOT NULL,
  `termin` date DEFAULT NULL,
  `temat` text NOT NULL,
  `opis` longtext DEFAULT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `todolists_szczegoly`
--

CREATE TABLE `todolists_szczegoly` (
  `id` int(11) NOT NULL,
  `zadanie` int(11) NOT NULL,
  `opis` text NOT NULL,
  `wykonanie` int(3) NOT NULL,
  `datadodania` datetime NOT NULL,
  `dataedycji` datetime NOT NULL,
  `glowne` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typynadania`
--

CREATE TABLE `typynadania` (
  `id` int(5) UNSIGNED NOT NULL,
  `typ` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `typynadania`
--

INSERT INTO `typynadania` (`id`, `typ`) VALUES
(1, 'Nierejestrowana'),
(2, 'Polecona'),
(3, 'Polecona z potwierdzeniem odbioru'),
(4, 'Zagraniczna z potwierdzeniem odbioru'),
(5, 'Zagraniczna nierejestrowana'),
(6, 'Pocztex');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(71) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `email` varchar(130) NOT NULL,
  `imie` int(3) UNSIGNED NOT NULL,
  `nazwisko` int(3) UNSIGNED NOT NULL,
  `dzial` int(3) UNSIGNED NOT NULL,
  `stanowisko` int(3) UNSIGNED DEFAULT NULL,
  `adresIPlogin` varchar(15) DEFAULT NULL,
  `systemoper` varchar(20) DEFAULT NULL,
  `przegladarka` varchar(50) DEFAULT NULL,
  `aktywny` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `imie`, `nazwisko`, `dzial`, `stanowisko`, `adresIPlogin`, `systemoper`, `przegladarka`, `aktywny`) VALUES
(1, 'test', '$2y$10$1Z6KM/G/aI6aaXhNd9jsOup1OQzvqAzzflxOyQFgoBIHzzRYPJLI.', 'test@test.pl', 1, 1, 1, 1, '::1', 'Windows 7', 'Mozilla Firefox', 'T');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresykontrahentow`
--
ALTER TABLE `adresykontrahentow`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `aplikacje`
--
ALTER TABLE `aplikacje`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `aplikacje_moduly`
--
ALTER TABLE `aplikacje_moduly`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aplikacja_idx` (`aplikacja`);

--
-- Indeksy dla tabeli `dostepy`
--
ALTER TABLE `dostepy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aplikacja_idx` (`aplikacja`),
  ADD KEY `grupa_idx` (`grupa`),
  ADD KEY `uzytkownik_idx` (`uzytkownik`),
  ADD KEY `modul_idx` (`modul`);

--
-- Indeksy dla tabeli `dzialy`
--
ALTER TABLE `dzialy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `esekretariat_przychodzace`
--
ALTER TABLE `esekretariat_przychodzace`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uzytkownikw_idx` (`wpisujacy`),
  ADD KEY `przychodzace_idx` (`nadawca`),
  ADD KEY `dzialprzych_idx` (`dzial`);

--
-- Indeksy dla tabeli `esekretariat_wychodzace`
--
ALTER TABLE `esekretariat_wychodzace`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `adresat_idx` (`adresat`),
  ADD KEY `typnadania_idx` (`typnadania`),
  ADD KEY `wpisujacy_idx` (`wpisujacy`);

--
-- Indeksy dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `imiona`
--
ALTER TABLE `imiona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `imie_UNIQUE` (`imie`);

--
-- Indeksy dla tabeli `nazwiska`
--
ALTER TABLE `nazwiska`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nazwisko_UNIQUE` (`nazwisko`);

--
-- Indeksy dla tabeli `prawemenu`
--
ALTER TABLE `prawemenu`
  ADD PRIMARY KEY (`id`,`uzytkownik`),
  ADD UNIQUE KEY `uzytkownik_UNIQUE` (`uzytkownik`),
  ADD KEY `uzytkownik_idx` (`uzytkownik`);

--
-- Indeksy dla tabeli `rejestracje`
--
ALTER TABLE `rejestracje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `imie_idx` (`imie`),
  ADD KEY `nazwisko_idx` (`nazwisko`),
  ADD KEY `dzialr_idx` (`dzial`);

--
-- Indeksy dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `todolists`
--
ALTER TABLE `todolists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uzytkownik_idx` (`uzytkownik`);

--
-- Indeksy dla tabeli `todolists_szczegoly`
--
ALTER TABLE `todolists_szczegoly`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `zadanie_idx` (`zadanie`);

--
-- Indeksy dla tabeli `typynadania`
--
ALTER TABLE `typynadania`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD KEY `imie_idx` (`imie`),
  ADD KEY `nazwisko_idx` (`nazwisko`),
  ADD KEY `dzial_idx` (`dzial`),
  ADD KEY `stanowisko_idx` (`stanowisko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `adresykontrahentow`
--
ALTER TABLE `adresykontrahentow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `aplikacje`
--
ALTER TABLE `aplikacje`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `aplikacje_moduly`
--
ALTER TABLE `aplikacje_moduly`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `dostepy`
--
ALTER TABLE `dostepy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `dzialy`
--
ALTER TABLE `dzialy`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `esekretariat_przychodzace`
--
ALTER TABLE `esekretariat_przychodzace`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `esekretariat_wychodzace`
--
ALTER TABLE `esekretariat_wychodzace`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `imiona`
--
ALTER TABLE `imiona`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `nazwiska`
--
ALTER TABLE `nazwiska`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `rejestracje`
--
ALTER TABLE `rejestracje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `todolists`
--
ALTER TABLE `todolists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `todolists_szczegoly`
--
ALTER TABLE `todolists_szczegoly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `typynadania`
--
ALTER TABLE `typynadania`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `aplikacje_moduly`
--
ALTER TABLE `aplikacje_moduly`
  ADD CONSTRAINT `aplikacjaid` FOREIGN KEY (`aplikacja`) REFERENCES `aplikacje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `dostepy`
--
ALTER TABLE `dostepy`
  ADD CONSTRAINT `aplikacja` FOREIGN KEY (`aplikacja`) REFERENCES `aplikacje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grupa` FOREIGN KEY (`grupa`) REFERENCES `grupy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `iduzytkownik` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `modul` FOREIGN KEY (`modul`) REFERENCES `aplikacje_moduly` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `esekretariat_przychodzace`
--
ALTER TABLE `esekretariat_przychodzace`
  ADD CONSTRAINT `dzialprzych` FOREIGN KEY (`dzial`) REFERENCES `dzialy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `przychodzace` FOREIGN KEY (`nadawca`) REFERENCES `adresykontrahentow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `uzytkownikw` FOREIGN KEY (`wpisujacy`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `esekretariat_wychodzace`
--
ALTER TABLE `esekretariat_wychodzace`
  ADD CONSTRAINT `adresat` FOREIGN KEY (`adresat`) REFERENCES `adresykontrahentow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `typnadania` FOREIGN KEY (`typnadania`) REFERENCES `typynadania` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `wpisujacy` FOREIGN KEY (`wpisujacy`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `prawemenu`
--
ALTER TABLE `prawemenu`
  ADD CONSTRAINT `uzytkownikpm` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `rejestracje`
--
ALTER TABLE `rejestracje`
  ADD CONSTRAINT `dzialr` FOREIGN KEY (`dzial`) REFERENCES `dzialy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `imier` FOREIGN KEY (`imie`) REFERENCES `imiona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nazwiskor` FOREIGN KEY (`nazwisko`) REFERENCES `nazwiska` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `todolists`
--
ALTER TABLE `todolists`
  ADD CONSTRAINT `uzytkownik` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `todolists_szczegoly`
--
ALTER TABLE `todolists_szczegoly`
  ADD CONSTRAINT `zadanie` FOREIGN KEY (`zadanie`) REFERENCES `todolists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `dzial` FOREIGN KEY (`dzial`) REFERENCES `dzialy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `imie` FOREIGN KEY (`imie`) REFERENCES `imiona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nazwisko` FOREIGN KEY (`nazwisko`) REFERENCES `nazwiska` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `stanowisko` FOREIGN KEY (`stanowisko`) REFERENCES `stanowiska` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
