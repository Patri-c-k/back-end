-- ============================================================
-- 5КВТ SHOP — База данных
-- Создать БД: 5kvt_db
-- ============================================================



-- -----------------------------------------------------------
-- Категории товаров
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id`   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(60)  NOT NULL UNIQUE,
  `name` VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`code`, `name`) VALUES
  ('accumulators',  'Аккумуляторы'),
  ('generators',    'Генераторы'),
  ('climate',       'Климатическая техника'),
  ('tools',         'Инструменты'),
  ('heating',       'Отопление');

-- -----------------------------------------------------------
-- Товары
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `brand`       VARCHAR(120) NOT NULL,
  `name`        VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price`       DECIMAL(10,2) NOT NULL,
  `old_price`   DECIMAL(10,2) DEFAULT NULL,
  `image`       VARCHAR(255) DEFAULT 'images/cordless-drill-driver.png',
  `is_new`      TINYINT(1) DEFAULT 0,
  `is_promo`    TINYINT(1) DEFAULT 0,
  `stock`       INT UNSIGNED DEFAULT 10,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`category_id`,`brand`,`name`,`description`,`price`,`old_price`,`image`,`is_new`,`is_promo`,`stock`) VALUES
  (1,'DELTA','АКБ Delta CT 1207 7Ач','Аккумулятор для ИБП, солнечных батарей. 12В 7Ач.',1290.00,NULL,'images/ups-inverter-box.png',1,0,15),
  (1,'VARTA','АКБ Varta Blue Dynamic 60Ач','Автомобильный аккумулятор, кальциевый, 60Ач.',5490.00,6200.00,'images/ups-power-station.png',0,1,8),
  (2,'HUTER','Генератор HUTER DY6500L','Бензиновый генератор 5 кВт, 4-тактный двигатель.',32900.00,NULL,'images/snow-blower.png',1,0,3),
  (2,'CHAMPION','Генератор Champion GPG6500','Дизельная электростанция 5.5 кВт.',41000.00,45000.00,'images/snow-blower.png',0,1,2),
  (3,'ELECTROLUX','Тепловентилятор Electrolux EFH/S-1115','Промышленный тепловентилятор 1.5 кВт.',4200.00,5000.00,'images/industrial-fan-heater-Photoroom.png',0,1,20),
  (3,'DAEWOO','Стабилизатор Daewoo DW-TZM5VA','Настенный стабилизатор напряжения 5 кВА.',7800.00,NULL,'images/wall-voltage-stabilizer-Photoroom.png',1,0,7),
  (4,'ВИХРЬ','Электрический рубанок ВИХРЬ Р-82СТ','Электрорубанок 710 Вт, ширина строгания 82 мм.',4007.00,5129.00,'images/electric-hand-planer-Photoroom.png',0,1,12),
  (4,'DIAM','Алмазный отрезной круг DIAM MASTER LINE','Диаметр 230 мм, для болгарки.',1150.00,1490.00,'images/diamond-saw-blade-Photoroom.png',0,1,50),
  (4,'DEWALT','Пильный станок DEWALT DWE7492','Торцовочная пила 2000 Вт, диск 250 мм.',28500.00,NULL,'images/miter-saw-Photoroom.png',1,0,4),
  (4,'MAKITA','Аккумуляторный дрель-шуруповёрт MAKITA DHP458','18В, 2 аккумулятора в комплекте.',9900.00,11500.00,'images/cordless-drill-driver.png',0,1,9),
  (5,'BALLU','Тепловая пушка BALLU BHP-P2-9','Электрическая, 9 кВт, для больших помещений.',6800.00,NULL,'images/industrial-fan-heater-Photoroom.png',1,0,6),
  (5,'ELECTROLUX','Масляный радиатор Electrolux EОH/S-1221','2.2 кВт, 11 секций, термостат.',3500.00,4100.00,'images/industrial-fan-heater-Photoroom.png',0,0,14);

-- -----------------------------------------------------------
-- Пользователи
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(120) NOT NULL,
  `email`      VARCHAR(180) NOT NULL UNIQUE,
  `phone`      VARCHAR(30) DEFAULT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `role`       ENUM('user','admin') DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Тестовый пользователь: email=test@test.ru  пароль=123456
INSERT INTO `users` (`name`,`email`,`phone`,`password`,`role`) VALUES
  ('Тестовый пользователь','test@test.ru','+79001234567',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','user'),
  ('Администратор','admin@5kvt.ru','+74997199994',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin');

-- -----------------------------------------------------------
-- Заказы
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id`       INT UNSIGNED DEFAULT NULL,
  `name`          VARCHAR(120) NOT NULL,
  `email`         VARCHAR(180) NOT NULL,
  `phone`         VARCHAR(30)  NOT NULL,
  `address`       VARCHAR(255) NOT NULL,
  `comment`       TEXT DEFAULT NULL,
  `total_amount`  DECIMAL(10,2) NOT NULL DEFAULT 0,
  `status`        ENUM('new','processing','shipped','completed','cancelled') DEFAULT 'new',
  `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Позиции заказа
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id`   INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `price`      DECIMAL(10,2) NOT NULL,
  `quantity`   INT UNSIGNED  NOT NULL DEFAULT 1,
  FOREIGN KEY (`order_id`)   REFERENCES `orders`(`id`)   ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Новости / контент главной страницы
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `news` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`      VARCHAR(255) NOT NULL,
  `body`       TEXT NOT NULL,
  `image`      VARCHAR(255) DEFAULT NULL,
  `is_active`  TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news` (`title`,`body`,`image`) VALUES
  ('Скидки до 30% на инструменты в июне!',
   'Весь июнь действуют специальные цены на ручной и электроинструмент ведущих брендов. Успейте приобрести по выгодной цене.',
   'images/electric-hand-planer-Photoroom.png'),
  ('Новинка: генераторы HUTER 2026',
   'Поступили в продажу новые модели бензиновых генераторов HUTER серии 2026 года с увеличенным ресурсом и пониженным расходом топлива.',
   'images/snow-blower.png'),
  ('Расширяем ассортимент климатической техники',
   'В наш каталог добавлены промышленные тепловентиляторы Electrolux и стабилизаторы напряжения Daewoo. Доставка по всей России.',
   'images/industrial-fan-heater-Photoroom.png');
