-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2017 г., 17:49
-- Версия сервера: 5.7.14
-- Версия PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `volga`
--

-- --------------------------------------------------------

--
-- Структура таблицы `todo_tasks`
--

CREATE TABLE `todo_tasks` (
  `id` int(11) NOT NULL,
  `sess_id` varchar(32) NOT NULL,
  `name` varchar(256) NOT NULL,
  `time_add` datetime DEFAULT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT '0',
  `date_completed` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `todo_tasks`
--

INSERT INTO `todo_tasks` (`id`, `sess_id`, `name`, `time_add`, `completed`, `date_completed`) VALUES
(8, 'a58c80fcfb9d89f7c728b557ab8ad458', '111222333', '2017-04-29 17:26:05', 1, '2017-04-29 21:34:55'),
(6, 'a58c80fcfb9d89f7c728b557ab8ad458', '111', '2017-04-29 17:26:00', 1, '2017-04-29 21:34:55'),
(7, 'a58c80fcfb9d89f7c728b557ab8ad458', 'aaa', '2017-04-29 17:26:02', 0, '2017-04-29 17:39:43'),
(9, 'a58c80fcfb9d89f7c728b557ab8ad458', 'bbbb', '2017-04-29 17:26:07', 0, '2017-04-29 17:39:43');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `auth_key` varchar(64) NOT NULL,
  `lasttime_query` datetime DEFAULT NULL,
  `count_days` int(11) NOT NULL DEFAULT '0',
  `count_days_all` int(11) NOT NULL DEFAULT '0',
  `num_seconds_limit` int(11) NOT NULL DEFAULT '60',
  `max_queryies_in_period` int(11) NOT NULL DEFAULT '10'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_id`, `auth_key`, `lasttime_query`, `count_days`, `count_days_all`, `num_seconds_limit`, `max_queryies_in_period`) VALUES
(1, 'qwerty_user', 'qwerty12345', '2017-04-29 12:45:14', 3, 3, 60, 10),
(2, 'asdf_user', 'asdf54321', '2017-04-29 13:44:32', 1, 1, 60, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_data`
--

INSERT INTO `user_data` (`id`, `user_id`, `name`, `value`) VALUES
(1, 1, 'asd', 'val3'),
(2, 1, 'qwe', 'val4'),
(3, 2, 'asd', 'Ð¿Ñ€Ð¸Ð²ÐµÑ‚'),
(4, 2, 'qwe', 'qwe data for qwerty_user'),
(5, 2, 'zxc', 'hello');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `todo_tasks`
--
ALTER TABLE `todo_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `todo_tasks`
--
ALTER TABLE `todo_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
