-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 12 2026 г., 09:34
-- Версия сервера: 8.0.45
-- Версия PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `5kvt_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(60) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`) VALUES
(1, 'accumulators', 'Аккумуляторы'),
(2, 'generators', 'Генераторы'),
(3, 'climate', 'Климатическая техника'),
(4, 'tools', 'Инструменты'),
(5, 'heating', 'Отопление');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `body`, `image`, `is_active`, `created_at`) VALUES
(1, 'Скидки до 30% на инструменты в июне!', 'Весь июнь действуют специальные цены на ручной и электроинструмент ведущих брендов. Успейте приобрести по выгодной цене.', 'images/electric-hand-planer-Photoroom.png', 1, '2026-06-11 07:49:45'),
(2, 'Новинка: генераторы HUTER 2026', 'Поступили в продажу новые модели бензиновых генераторов HUTER серии 2026 года с увеличенным ресурсом и пониженным расходом топлива.', 'images/snow-blower.png', 1, '2026-06-11 07:49:45'),
(3, 'Расширяем ассортимент климатической техники', 'В наш каталог добавлены промышленные тепловентиляторы Electrolux и стабилизаторы напряжения Daewoo. Доставка по всей России.', 'images/industrial-fan-heater-Photoroom.png', 1, '2026-06-11 07:49:45');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `comment` text,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('new','processing','shipped','completed','cancelled') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `comment`, `total_amount`, `status`, `created_at`) VALUES
(1, 3, 'Patrick', 'happypatrik2008@gmail.com', '+375298291261', 'гродно', '', 9900.00, 'new', '2026-06-11 07:50:35'),
(2, 3, 'Patrick', 'happypatrik2008@gmail.com', '+375298291261', 'гродно', '', 14257.00, 'new', '2026-06-11 09:22:37'),
(3, 3, 'Patrick', 'happypatrik2008@gmail.com', '+375298291261', 'минск', '', 28500.00, 'new', '2026-06-11 09:23:42'),
(4, 5, 'Боря', 'boria319@gmail.com', '+375298291261', 'grodno', '', 13400.00, 'new', '2026-06-12 06:30:50');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 10, 'Аккумуляторный дрель-шуруповёрт MAKITA DHP458', 9900.00, 1),
(2, 2, 8, 'Алмазный отрезной круг DIAM MASTER LINE', 1150.00, 3),
(3, 2, 11, 'Тепловая пушка BALLU BHP-P2-9', 6800.00, 1),
(4, 2, 7, 'Электрический рубанок ВИХРЬ Р-82СТ', 4007.00, 1),
(5, 3, 9, 'Пильный станок DEWALT DWE7492', 28500.00, 1),
(6, 4, 10, 'Аккумуляторный дрель-шуруповёрт MAKITA DHP458', 9900.00, 1),
(7, 4, 12, 'Масляный радиатор Electrolux EОH/S-1221', 3500.00, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `brand` varchar(120) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'images/cordless-drill-driver.png',
  `is_new` tinyint(1) DEFAULT '0',
  `is_promo` tinyint(1) DEFAULT '0',
  `stock` int UNSIGNED DEFAULT '10',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `description`, `price`, `old_price`, `image`, `is_new`, `is_promo`, `stock`, `created_at`) VALUES
(1, 1, 'DELTA', 'АКБ Delta CT 1207 7Ач', 'Аккумулятор для ИБП, солнечных батарей. 12В 7Ач.', 1290.00, NULL, 'images/ups-inverter-box.png', 1, 0, 15, '2026-06-11 07:49:44'),
(2, 1, 'VARTA', 'АКБ Varta Blue Dynamic 60Ач', 'Автомобильный аккумулятор, кальциевый, 60Ач.', 5490.00, 6200.00, 'images/ups-power-station.png', 0, 1, 8, '2026-06-11 07:49:44'),
(3, 2, 'HUTER', 'Генератор HUTER DY6500L', 'Бензиновый генератор 5 кВт, 4-тактный двигатель.', 32900.00, NULL, 'images/snow-blower.png', 1, 0, 3, '2026-06-11 07:49:44'),
(4, 2, 'CHAMPION', 'Генератор Champion GPG6500', 'Дизельная электростанция 5.5 кВт.', 41000.00, 45000.00, 'images/snow-blower.png', 0, 1, 2, '2026-06-11 07:49:44'),
(5, 3, 'ELECTROLUX', 'Тепловентилятор Electrolux EFH/S-1115', 'Промышленный тепловентилятор 1.5 кВт.', 4200.00, 5000.00, 'images/industrial-fan-heater-Photoroom.png', 0, 1, 20, '2026-06-11 07:49:44'),
(6, 3, 'DAEWOO', 'Стабилизатор Daewoo DW-TZM5VA', 'Настенный стабилизатор напряжения 5 кВА.', 7800.00, NULL, 'images/wall-voltage-stabilizer-Photoroom.png', 1, 0, 7, '2026-06-11 07:49:44'),
(7, 4, 'ВИХРЬ', 'Электрический рубанок ВИХРЬ Р-82СТ', 'Электрорубанок 710 Вт, ширина строгания 82 мм.', 4007.00, 5129.00, 'images/electric-hand-planer-Photoroom.png', 0, 1, 12, '2026-06-11 07:49:44'),
(8, 4, 'DIAM', 'Алмазный отрезной круг DIAM MASTER LINE', 'Диаметр 230 мм, для болгарки.', 1150.00, 1490.00, 'images/diamond-saw-blade-Photoroom.png', 0, 1, 50, '2026-06-11 07:49:44'),
(9, 4, 'DEWALT', 'Пильный станок DEWALT DWE7492', 'Торцовочная пила 2000 Вт, диск 250 мм.', 28500.00, NULL, 'images/miter-saw-Photoroom.png', 1, 0, 4, '2026-06-11 07:49:44'),
(10, 4, 'MAKITA', 'Аккумуляторный дрель-шуруповёрт MAKITA DHP458', '18В, 2 аккумулятора в комплекте.', 9900.00, 11500.00, 'images/cordless-drill-driver.png', 0, 1, 9, '2026-06-11 07:49:44'),
(11, 5, 'BALLU', 'Тепловая пушка BALLU BHP-P2-9', 'Электрическая, 9 кВт, для больших помещений.', 6800.00, NULL, 'images/industrial-fan-heater-Photoroom.png', 1, 0, 6, '2026-06-11 07:49:44'),
(12, 5, 'ELECTROLUX', 'Масляный радиатор Electrolux EОH/S-1221', '2.2 кВт, 11 секций, термостат.', 3500.00, 4100.00, 'images/industrial-fan-heater-Photoroom.png', 0, 0, 14, '2026-06-11 07:49:44');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Тестовый пользователь', 'test@test.ru', '+79001234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '2026-06-11 07:49:44'),
(2, 'Администратор', 'admin@5kvt.ru', '+74997199994', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-06-11 07:49:44'),
(3, 'Patrick', 'happypatrik2008@gmail.com', '+375298291261', '$2y$10$OJIDmWe/aIOAnDH2..3.Ju/lHrGJExe28GSH9XhJK/DNMCRf5KSqi', 'user', '2026-06-11 07:50:10'),
(4, 'Dexter', 'marculevicpatrik@gmail.com', '+375298291261', '$2y$10$VqoLmePQL2bhvBdkA99BMeiUvDfQodHiqqg44VgL0zaQ.vnNZQAGK', 'user', '2026-06-11 17:26:09'),
(5, 'Боря', 'boria319@gmail.com', '+375298291261', '$2y$10$g5Aynd0/koaQu.Ad2APbl.hQ.JW3O1V6REVIJEy0gwYb.YIwEy0/K', 'user', '2026-06-12 06:30:08');

-- --------------------------------------------------------

--
-- Структура таблицы `user_carts`
--

CREATE TABLE `user_carts` (
  `user_id` int UNSIGNED NOT NULL,
  `cart` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_carts`
--

INSERT INTO `user_carts` (`user_id`, `cart`, `updated_at`) VALUES
(3, '{\"9\":1,\"11\":1}', '2026-06-11 17:26:35'),
(4, '{\"9\":1}', '2026-06-11 17:26:23');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_carts`
--
ALTER TABLE `user_carts`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_carts`
--
ALTER TABLE `user_carts`
  ADD CONSTRAINT `user_carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
