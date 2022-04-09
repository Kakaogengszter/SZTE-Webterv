-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Ápr 09. 17:01
-- Kiszolgáló verziója: 10.4.22-MariaDB
-- PHP verzió: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `recipes`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `content` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `inbox`
--

CREATE TABLE `inbox` (
  `messageID` int(11) NOT NULL,
  `kitolID` int(11) NOT NULL,
  `kinekID` int(11) NOT NULL,
  `message` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `inbox`
--

INSERT INTO `inbox` (`messageID`, `kitolID`, `kinekID`, `message`) VALUES
(1, 7, 11, 'Szia!\r\nEz egy teszt üzenet tesztelek2-nek.'),
(2, 11, 7, 'Szia!\r\nEz egy teszt üzenet tesztelek-nek.'),
(7, 12, 11, 'Macska'),
(8, 12, 7, 'Kutya'),
(9, 12, 11, 'ASDSA'),
(11, 11, 12, 'Hali te!'),
(12, 11, 7, 'Első válasz üzenet!');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `recipes`
--

CREATE TABLE `recipes` (
  `recipeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `content` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `birthdate` date NOT NULL,
  `picture` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `isEmailPrivate` int(11) NOT NULL DEFAULT 0,
  `isBirthDatePrivate` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`, `birthdate`, `picture`, `isEmailPrivate`, `isBirthDatePrivate`) VALUES
(7, 'tesztelek', 'teszt.elek@gmail.com', '$2y$10$BgVutF50iniBjbHQ3cBWDevr4E9YN.S3BpcJ5d4o40K7iyAgNbZIO', '2022-03-31', 'default.jpg', 0, 0),
(11, 'tesztelek2', 'tesztelek2@gmail.com', '$2y$10$EaOC20AxuIM0vUiinCg6bOCrDYwwxFDvac9B9ZInVBrc3.nqt9eam', '2022-04-03', 'kep.jpg', 0, 0),
(12, 'tesztelek3', 'tesztelek3@gmail.com', '$2y$10$vKlTQdJtFmyRJaqSuiSKgObumuEy3/RCajFbU0YyVYc8qPVZVtToe', '2022-04-03', 'default.jpg', 0, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`messageID`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `inbox`
--
ALTER TABLE `inbox`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
