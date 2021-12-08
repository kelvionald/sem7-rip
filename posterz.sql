-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 18 2021 г., 20:32
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `posterz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `follower`
--

CREATE TABLE `follower` (
  `follower_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `readable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `follower`
--

INSERT INTO `follower` (`follower_id`, `reader_id`, `readable_id`) VALUES
(1, 2, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `yc_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `image`
--

INSERT INTO `image` (`image_id`, `post_id`, `yc_key`) VALUES
(26, 33, 'b615633a-41fd-47cd-b53a-20b87046f02a'),
(27, 34, 'c0d36481-710a-4fdf-aca8-7ad52c029590');

-- --------------------------------------------------------

--
-- Структура таблицы `like`
--

CREATE TABLE `like` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `like`
--

INSERT INTO `like` (`like_id`, `post_id`, `user_id`) VALUES
(1, 3, 1),
(3, 33, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE `photo` (
  `photo_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`photo_id`, `filename`) VALUES
(1, '1.jpg'),
(2, '2.jpg'),
(3, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `repost_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `commenting_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`post_id`, `content`, `user_id`, `repost_id`, `created_at`, `updated_at`, `commenting_id`) VALUES
(5, 'однажды вечером за день до Хэллоуина вы находите письмо с приглашением на тематическую встречу в честь наступающего праздника\n\nтут вы сможете подготовиться к Хэллоуину\n\ncw: интерактив может содержать слегка пугающие сцены, хотя я старалась подбирать-', 2, NULL, '2021-11-01 14:02:56', '2021-11-01 14:02:56', NULL),
(13, 'ем в маке 🍔', 2, NULL, '2021-11-01 14:15:28', '2021-11-01 14:15:28', NULL),
(14, 'Первые покупатели начали получать свои MacBook Pro с «чёлкой». Есть фото и видео\r\nКрасавчики! …\r\n', 1, NULL, '2021-11-01 14:17:21', '2021-11-01 14:17:21', NULL),
(15, 'Глава Минздрава Михаил Мурашко доложил о положительном эффекте от нерабочих дней — число больных COVID-19 под наблюдением врачей снизилось на 3 600 человек. Сейчас их 1 млн 376 тыс., сообщил Мурашко.', 1, NULL, '2021-11-01 14:26:10', '2021-11-01 14:26:10', NULL),
(16, '🥩Реальный размер пенсий в России за год снизился на 1,8%, следует из данных Росстата. По сравнению с августом этого года падение составило 0,6%. \n\nСредний размер пенсии в России в сентябре составил 15 847 руб.', 1, NULL, '2021-11-01 14:27:03', '2021-11-01 14:27:03', NULL),
(33, 'котьки', 1, NULL, '2021-11-10 19:28:34', '2021-11-10 19:28:34', NULL),
(34, 'е', 1, NULL, '2021-11-18 17:20:13', '2021-11-18 17:20:13', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `network` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_block` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `network`, `identity`, `login`, `nickname`, `remember_token`, `description`, `password`, `photo_id`, `role_id`, `created_at`, `updated_at`, `is_block`) VALUES
(1, 'vkontakte', 'http://vk.com/id135510265', 'ru_rbc', 'РБК', 'hBjDFQWxelihwVcYqtqu6IFcvr3LxXDtdTepCbxqPDKfR37m6Fwphv9H4J3r', 'Всё про экономику и политику для самых разных людей.', NULL, 2, 1, '2021-10-06 17:27:07', '2021-11-01 14:31:18', 0),
(2, 'google', 'https://plus.google.com/u/0/103503088276690551611/', 'maybe_meateater', 'софикó 𓆈', 'aiKoCkmQCYUdYSufKPkay0cg226zrv3JlYI4cnzJ6YVzXDDXv6VClgYMqOQ2', '● мясоедка, тургенев, чудрин | вообще, я софа | либерализм, pls ●', NULL, 1, 1, '2021-11-01 13:27:13', '2021-11-01 13:57:53', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`follower_id`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Индексы таблицы `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`like_id`);

--
-- Индексы таблицы `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photo_id`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `follower`
--
ALTER TABLE `follower`
  MODIFY `follower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `like`
--
ALTER TABLE `like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `photo`
--
ALTER TABLE `photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
