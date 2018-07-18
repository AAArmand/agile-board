-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 18 2018 г., 16:20
-- Версия сервера: 5.6.38
-- Версия PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `agile_board`
--
CREATE DATABASE IF NOT EXISTS `agile_board` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `agile_board`;

-- --------------------------------------------------------

--
-- Структура таблицы `sprints`
--

DROP TABLE IF EXISTS `sprints`;
CREATE TABLE `sprints` (
  `id` int(10) UNSIGNED NOT NULL,
  `week_number` int(11) NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `del` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sprints`
--

INSERT INTO `sprints` (`id`, `week_number`, `year`, `creation_timestamp`, `status`, `del`) VALUES
(1, 30, 2018, '2018-07-17 14:26:43', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `estimate_hours` int(11) DEFAULT NULL,
  `estimate_minutes` int(11) DEFAULT NULL,
  `spend_hours` int(11) DEFAULT NULL,
  `spend_minutes` int(11) DEFAULT NULL,
  `sprint_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `priority` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `del` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `estimate_hours`, `estimate_minutes`, `spend_hours`, `spend_minutes`, `sprint_id`, `status`, `priority`, `creation_timestamp`, `del`) VALUES
(1, 'Новая задача', 'Эта задача сложная', NULL, NULL, NULL, NULL, 1, 1, 1, '2018-07-17 14:28:25', 0),
(2, 'Привет', 'мир', 2, 3, NULL, NULL, NULL, 1, 1, '2018-07-17 16:35:57', 0),
(3, 'Привет', 'мир', NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-07-17 15:46:39', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `sprints`
--
ALTER TABLE `sprints`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `sprints`
--
ALTER TABLE `sprints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
