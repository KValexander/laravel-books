-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 28 2021 г., 11:46
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
-- База данных: `books`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blogs`
--

CREATE TABLE `blogs` (
  `id_blog` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `blog_title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `book-group`
--

CREATE TABLE `book-group` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_groups` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id_bookmark` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int(11) NOT NULL,
  `chapter` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `book_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `russian_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `annotation` varchar(1215) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_year` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translate_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overall_volume` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation_volume` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genres` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translator` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `state` int(1) NOT NULL DEFAULT 0,
  `delete_marker` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id_book`, `id_user`, `book_title`, `russian_title`, `cover`, `annotation`, `release_year`, `isbn`, `release_status`, `translate_status`, `overall_volume`, `translation_volume`, `genres`, `tags`, `author`, `translator`, `type`, `views`, `downloads`, `state`, `delete_marker`, `created_at`, `updated_at`) VALUES
(1, 2, 'Accel World', 'Ускоренный мир', '/books/images/covers/accel_world_1610548892.jpg', 'Харуюки — мальчик с избыточным весом, недавно поступивший в среднюю школу. У него типичные для толстого ребенка проблемы: заниженная самооценка, издевательства одноклассников и так далее. Его единственная отдушина — виртуальный мир, где неуклюжее реальное тело не мешает быстрой реакции мозга. В школьной сети он играет в сквош, и его невероятные результаты замечает первая красавица школы Черноснежка. Она предлагает Харуюки открыть для себя иной мир, где скорость мысли и воля сражаться определяют все.', '2009', '978-4048675178', 'Продолжается', 'Продолжается', '25 томов', '25 томов', 'Боевик, Игры, Научная фантастика, Романтика, Школьная жизнь', 'Виртуальная реальность, Героиня красавица, Главный герой — мужчина, Есть аниме-адаптация, Есть манга-адаптация, Комплекс неполноценности, Любит персонажа старше себя, ММОРПГ, От слабого к сильному, Скрытые способности', 'Рэки Кавахара', 'Ushwood, RuRa-team', 'Новелла', 0, 0, 0, 0, '2021-01-13 11:41:32', '2021-01-18 08:17:02'),
(2, 2, 'Heavy Object', 'Тяжёлый объект', '/books/images/covers/heavy_object_1610729928.jpg', 'В итоге, войны не закончились.\n\nДаже в эту эпоху, — когда технический прогресс достиг каждого уголка Земли, когда с помощью мощных лазеров с лёгкостью отправляют шаттлы в космос, а самые влиятельные люди имеют личные виллы на Луне, — не было придумано ничего, что могло бы устранить барьеры между сердцами людей. И хотя компании, снабжающие население цифровым «комфортом» и «спиритизмом», уже перестали быть редкостью, — способ устранить из менталитета людей черты, провоцирующие раздоры, так и не был открыт.\n\nСтало вызванное новым видом вооружения изменение в правилах войны спасением для человечества или ступенью в его падении?\n\nЧто ж, кое-что изменилось.\n\nЛюди, забывшие себя в абсурдной тяге к убийствам, тоже изменились.\n\nА поблагодарить за это надо гигантское оружие, названное Объектами. (с)', '2009', '978-4048680691', 'Продолжается', 'Продолжается', '13 томов', '7 томов', 'Боевик, Военное, Меха, Научная фантастика', 'Война, Герой-извращенец, Главный герой — мужчина, Есть аниме-адаптация, Есть манга-адаптация, Кудэрэ, Солдаты, Умный главный герой, Элементы романтики', 'Казума Камачи', 'RuRa-team', 'Книга', 0, 0, 0, 0, '2021-01-15 13:58:48', '2021-01-15 16:58:48'),
(3, 2, 'OreGairu', 'Моя юношеская романтическая комедия оказалась неправильной, как я и предполагал', '/books/images/covers/oregairu_1610730413.jpg', 'Юность — это ложь. Сплошное зло.\n\nТе из вас, кто радуется юности, лишь обманывают себя и всех вокруг. Вы смотрите на всё сквозь розовые очки. И даже совершая смертельную ошибку, вы считаете её лишь доказательством того, что молоды.\n\nПриведу пример. Вляпавшись в преступление вроде воровства из магазина или общественные беспорядки, такие люди именуют это «юношеская неосторожность». Провалившись на экзамене, заявляют, что школа — это не просто место для учёбы. Прикрываясь «юностью», они плюют на мораль и нормы поведения.\n\nНеосмотрительность, проступки, тайны, враньё и даже собственные провалы для них всего лишь проявления юности. На своём порочном пути они считают свои провалы естественным доказательством юности, а провалы окружающих для них лишь провалы и ничего больше.\n\nЕсли провалы — это проявление юности, не следует ли считать, что неумение заводить друзей — это тоже признак юности? Но конечно же, они так не считают.\n\nЕрунда. Всё это всего лишь результат их оппортунизма. А значит, позор. Тех, кто полон вранья, тайн и обмана, следует презирать.\n\nОни — зло.\n\nИначе говоря, как бы иронично это ни звучало, истинно добродетельны те, кто не радуется своей юности.\n\nИ пусть все популярные сдохнут. (с)', '2011', '978-4094512625', 'Завершён', 'Завершён', '14 томов', '14 томов', 'Комедия, Романтика, Школьная жизнь', 'Герои непонятного пола, Героиня красавица, Главный герой — мужчина, Есть аниме-адаптация, Есть манга-адаптация, Одинокий главный герой, Современность, Социальные изгои, Умный главный герой', 'Ватару Ватари', 'RuRa-team', 'Новелла', 0, 0, 0, 0, '2021-01-15 14:06:53', '2021-01-15 17:06:53'),
(4, 2, 'Date a Live', 'Рандеву с Жизнью', '/books/images/covers/date_a_live_1610780472.png', 'Десятое апреля. Утро первого дня в школе после окончания весенних каникул. Разбуженный милой младшей сестрёнкой, Ицука Шидо думал, что это начало ещё одного обычного дня. Ничто не предвещало встречи с незнакомкой, которая зовёт себя Духом…\n\nУдарная волна не оставила и следа от городского пейзажа. На углу улицы, которая теперь превратилась в кратер, стояла девушка.\n\n— Ты тоже пришёл убить меня?\n\nОна — беда, грозящая уничтожением человечеству, монстр неизвестного происхождения, существо, отвергнутое миром. Есть лишь два способа остановить её: убийство или разговор.\n\nМладшая сестра, облачённая в военную форму, так сказала Шидо:\n\n— Просто сходи с ней на свидание и влюби в себя!\n\n— Что-о-о?!\n\nНачинается новая эра свиданий!', '2011', '978-4040710457', 'Завершён', 'Продолжается', '22 тома', '12 томов', 'Гарем, Меха, Научная фантастика, Романтика, Школьная жизнь', 'Альтернативная реальность, Братья или сёстры, Героиня красавица, Главный герой приёмный, Главный герой — мужчина, Духи, Есть аниме-адаптация, Есть видеоигра, Есть манга-адаптация, Заботливый главный герой', 'Тачибана Коши', 'Bad_Boy', 'Новелла', 0, 0, 0, 0, '2021-01-16 04:01:12', '2021-01-18 08:38:55'),
(7, 2, 'Название', 'Название', '/books/images/covers1_название_1624869492_orig.jpg', 'выа', '2021', '1234567', 'Продолжается', 'Продолжается', '213', '3213', 'Нету', 'Нету', 'Я', 'Я', 'Книга', 0, 0, 0, 0, '2021-06-28 05:38:12', '2021-06-28 08:38:12');

-- --------------------------------------------------------

--
-- Структура таблицы `chapters`
--

CREATE TABLE `chapters` (
  `id_chapter` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `volume_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter` int(11) NOT NULL,
  `chapter_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chapters`
--

INSERT INTO `chapters` (`id_chapter`, `id_book`, `id_user`, `volume`, `volume_title`, `chapter`, `chapter_title`, `chapter_content`, `path`, `type`, `state`, `created_at`, `updated_at`) VALUES
(6, 4, 2, 1, 'Тупик Токи', 1, '1', '0', '/books/files/chapters/date_a_live/date_a_live_vol1_chapter1_-_1_1610881684.epub', 'chapter', 1, '2021-01-17 08:08:04', '2021-01-18 18:51:25'),
(7, 4, 2, 2, 'Кукла Ёшино', 0, '0', '0', '/books/files/chapters/date_a_live/date_a_live_vol1_wholly_-__1610949769.fb2', 'wholly', 0, '2021-01-18 03:02:49', '2021-01-18 18:54:03'),
(8, 4, 2, 1, 'Тупик Токи', 2, '2', '0', '/books/files/chapters/date_a_live/date_a_live_vol1_chapter2_-_2_1610987688.epub', 'chapter', 0, '2021-01-18 13:34:48', '2021-01-18 16:34:48'),
(9, 4, 2, 1, 'Тупик Токи', 3, '0', '0', '/books/files/chapters/date_a_live/date_a_live_vol1_prologue3_-_0_1610987951.fb2', 'prologue', 0, '2021-01-18 13:39:11', '2021-01-18 16:39:11'),
(10, 3, 2, 1, '1', 0, '1', '0', '/books/files/chapters/oregairu/oregairu_vol1_wholly_-_1_1611409884.fb2', 'wholly', 0, '2021-01-23 10:51:24', '2021-01-23 13:51:24'),
(11, 3, 2, 2, '2', 0, '2', '0', '/books/files/chapters/oregairu/oregairu_vol2_wholly_-_2_1611409965.epub', 'wholly', 0, '2021-01-23 10:52:45', '2021-01-23 13:52:45'),
(13, 3, 2, 3, '3', 0, '3', '0', '/books/files/chapters/oregairu/oregairu_vol3_wholly_-_3_1611410028.docx', 'wholly', 0, '2021-01-23 10:53:48', '2021-01-23 13:53:48');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dialogs`
--

CREATE TABLE `dialogs` (
  `id_dialog` int(11) NOT NULL,
  `id_first` int(11) NOT NULL,
  `id_second` int(11) NOT NULL,
  `last_message_id` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `directory_genres`
--

CREATE TABLE `directory_genres` (
  `id_genre` int(11) NOT NULL,
  `genre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `directory_tags`
--

CREATE TABLE `directory_tags` (
  `id_tag` int(11) NOT NULL,
  `tag` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id_friend` int(11) NOT NULL,
  `id_first` int(11) NOT NULL,
  `id_second` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id_groups` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book-group` int(11) NOT NULL,
  `covers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_dialog` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_adressee` int(11) NOT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_blog` int(11) NOT NULL,
  `post_title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `like` int(11) NOT NULL DEFAULT 0,
  `dislike` int(11) NOT NULL DEFAULT 0,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

CREATE TABLE `ratings` (
  `id_rating` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `review_title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `like` int(11) NOT NULL DEFAULT 0,
  `dislike` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(31) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int(1) DEFAULT 4,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online` int(1) NOT NULL DEFAULT 0,
  `state` int(1) NOT NULL DEFAULT 1,
  `ban` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `login`, `password`, `email`, `remember_token`, `access`, `gender`, `avatar`, `category`, `online`, `state`, `ban`, `created_at`, `updated_at`) VALUES
(2, 'Администратор 1', 'Администратор', '1', 'admin', '$2y$10$WKxUJwOrKbbnZLL/bgCsoebQcSZXMqj.iOoZQ1CQneXfb7rxZ4IYO', '1@1', 'BrwUfi2kxCd5MATwgpmqu0tg7wvgAZkloaAuoZHjdjgXkIfJHxs0yRT19Vy6', 1, NULL, NULL, NULL, 1, 1, 0, '2021-01-13 05:14:42', '2021-01-18 05:38:11'),
(3, 'Модератор 2', 'Модератор', '2', 'moderator', '$2y$10$22o4RyVmQ/90ET6WfB2x3.r/TzMHOGKHKWxPmGcKPOAJNrLbwlV5u', '2@2', 'OOGSS0T5cKDWaMDyjmGtm6vtA7OcPgIyRwxRmgWJsJuHPslUIb3q2gQG8q87', 2, NULL, NULL, NULL, 0, 1, 0, '2021-01-13 05:15:29', '2021-01-16 15:32:03'),
(4, 'Редактор 3', 'Редактор', '3', 'editor', '$2y$10$1.tIRsjqac0GWkky1mgb5u5EV2lBt1YZ19SLiToZGl3WFYedE36xG', '3@3', 'zlTpmSs03AwamOsAdQR9ZHveButVFqOv8l0qvbuBSg9Tpm16Xr8CB50FiWsf', 3, NULL, NULL, NULL, 0, 1, 0, '2021-01-13 05:16:32', '2021-01-18 08:37:24'),
(5, 'Пользователь 4', 'Пользователь', '4', 'user', '$2y$10$4Ct8AxgJWz4sE0Js4id3jOWFkLaoNMQ/tpchi.XLxwuV7.uXr90Mq', '4@4', NULL, 4, NULL, NULL, NULL, 0, 1, 0, '2021-01-13 05:23:06', '2021-01-13 08:23:06');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id_blog`);

--
-- Индексы таблицы `book-group`
--
ALTER TABLE `book-group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id_bookmark`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`);

--
-- Индексы таблицы `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id_chapter`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Индексы таблицы `dialogs`
--
ALTER TABLE `dialogs`
  ADD PRIMARY KEY (`id_dialog`);

--
-- Индексы таблицы `directory_genres`
--
ALTER TABLE `directory_genres`
  ADD PRIMARY KEY (`id_genre`);

--
-- Индексы таблицы `directory_tags`
--
ALTER TABLE `directory_tags`
  ADD PRIMARY KEY (`id_tag`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id_friend`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_groups`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Индексы таблицы `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id_rating`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LOGIN` (`login`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `book-group`
--
ALTER TABLE `book-group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id_bookmark` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id_chapter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dialogs`
--
ALTER TABLE `dialogs`
  MODIFY `id_dialog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `directory_genres`
--
ALTER TABLE `directory_genres`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `directory_tags`
--
ALTER TABLE `directory_tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id_friend` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id_groups` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
