DROP DATABASE IF EXISTS autoparts_store;
CREATE DATABASE autoparts_store
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE autoparts_store;

-- ---------- users ----------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (name, email, password, role) VALUES
('Адмін', 'admin@gmail.com', '123', 'admin'),
('Тест Клієнт', 'client@gmail.com', '123', 'user'),
('Марія Іванова', 'maria@gmail.com', '123', 'user'),
('Олексій Петренко', 'oleksiy@gmail.com', '123', 'user');

-- ---------- categories ----------
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name) VALUES
('Двигун і ГРМ'),
('Гальмівна система'),
('Підвіска та рульове'),
('Електрика та освітлення'),
('Охолодження та кондиціонер'),
('Кузов і скло');

-- ---------- products ----------
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    short_description VARCHAR(255),
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    image VARCHAR(255),
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (category_id, name, short_description, description, price, image, stock) VALUES
-- Двигун і ГРМ
(1, 'Форсунка Bosch 0445110646', 'Common Rail, дизель 1.6–2.0 TDI', 'Оригінальна форсунка з упором на стабільний розпил і довгий ресурс. Підходить для популярних дизельних блоків VW Group. Перед встановленням рекомендована діагностика ТНВД.', 4680.00, 'ap_engine_01.jpg', 14),
(1, 'Ремінь ГРМ Gates PowerGrip', 'Синхронізація розподільчого вала', 'Стійкий до високих температур і масла, знижує ризик перескоку. Заміна за регламентом або при ознаках зносу.', 1120.00, 'ap_engine_02.jpg', 28),
(1, 'Ролик натягувача INA', 'Для комплектів ГРМ', 'Підшипник закритого типу, зменшує шум і вібрації ременя. Сумісний із більшістю комплектів INA/Gates.', 890.00, 'ap_engine_03.jpg', 22),
(1, 'Ланцюг ГРМ IWIS', 'Для бензинових TSI', 'Міцні пластини та оптимальне змащення. Вирівнює навантаження на шестернях при холодному запуску.', 5840.00, 'ap_engine_04.jpg', 9),
(1, 'Прокладка ГБЦ Elring', 'Мідно-асбестовий композит', 'Герметизує камеру згоряння, стійка до перепадів температури. Поставляється з рекомендаціями по моменту затягування.', 1340.00, 'ap_engine_05.jpg', 17),

-- Гальмівна система
(2, 'Колодки передні Brembo', 'Керамічна суміш, низький пил', 'Стабільне гальмування у дощ і спеку. Підходить для щоденної експлуатації та довгих пробігів.', 3200.00, 'ap_brake_01.jpg', 19),
(2, 'Диски гальмівні Zimmermann', 'Вентильовані, пара 288 мм', 'Покриття Z-Coat проти корозії. Рівномірне охолодження ребер при інтенсивному гальмуванні.', 5100.00, 'ap_brake_02.jpg', 11),
(2, 'Супорт гальмівний TRW', 'Передній лівий, з ущільнювачами', 'Відновлена геометрія поршня, комплект кріплень. Перед монтажем — прокачка системи та заміна рідини.', 7800.00, 'ap_brake_03.jpg', 6),
(2, 'Рідина гальмівна ATE DOT4', 'Каністра 1 л', 'Висока температура кипіння, сумісна з АБС і ESP. Заміна за календарем або після ремонту контурів.', 420.00, 'ap_brake_04.jpg', 55),
(2, 'Датчик АБС Bosch', 'Передній правий', 'Точна передача імпульсів обертання. Запобігає блокуванню коліс на слизькій дорозі.', 1180.00, 'ap_brake_05.jpg', 24),

-- Підвіска та рульове
(3, 'Амортизатор передній Sachs', 'Газомасляний, шток 14 мм', 'Плавний хід і короткий відскок. Підходить для заміни попарно на одній осі.', 2900.00, 'ap_susp_01.jpg', 16),
(3, 'Пружина підвіски Lesjöfors', 'Задня, посилена', 'Зберігає кліренс при повному завантаженні. Покриття захищає від корозії в зоні клімату.', 2100.00, 'ap_susp_02.jpg', 13),
(3, 'Рульова тяга Lemförder', 'Права, з наконечником', 'Точна геометрія кута повороту. Після заміни — обов\'язкове регулювання розвалу-сходження.', 1650.00, 'ap_susp_03.jpg', 20),
(3, 'Сайлентблок переднього важеля Febi', 'Гідравлічний прес-посадка', 'Еластомер стійкий до мастил і пилу. Зменшує «дзвін» підвіски на нерівностях.', 480.00, 'ap_susp_04.jpg', 40),
(3, 'Кульова опора Moog', 'Нижня, з пильником', 'Посилений шарнір, захист від бруду. Контролюйте люфт при кожному ТО.', 920.00, 'ap_susp_05.jpg', 31),

-- Електрика та освітлення
(4, 'Акумулятор Varta Blue Dynamic 60Ah', 'Пусковий струм 540 A', 'Кальційна технологія, низький саморозряд. Підходить для авто з Start-Stop (за підбором).', 4200.00, 'ap_elec_01.jpg', 12),
(4, 'Генератор Bosch 120A', 'Шків з обгонною муфтою', 'Стабільна напруга під навантаженням кондиціонера та фар. Перевірка діодного моста при здачі старого.', 11200.00, 'ap_elec_02.jpg', 5),
(4, 'Реле 12V Hella 40A', 'Універсальне, 4 контакти', 'Для фар, сигналу, додаткових споживачів. Герметичний корпус.', 185.00, 'ap_elec_03.jpg', 70),
(4, 'Лампа H7 Philips WhiteVision', 'Набір 2 шт., +60% світла', 'Біле світло без засліплення зустрічних. Відповідає ECE для доріг загального користування.', 640.00, 'ap_elec_04.jpg', 38),
(4, 'Адаптер OBD-II Bluetooth', 'Діагностика через смартфон', 'Читання кодів помилок, стирання errors, live data. Сумісний із Android/iOS застосунками.', 890.00, 'ap_elec_05.jpg', 27),

-- Охолодження та кондиціонер
(5, 'Радіатор охолодження Nissens', 'Алюмінієвий, з пластиковими бачками', 'Ефективна тепловіддача, опір корозії. Перевірте сумісність кріплень вентилятора.', 5600.00, 'ap_cool_01.jpg', 8),
(5, 'Термостат Wahler 87°C', 'З корпусом для деяких моделей', 'Точне відкриття клапана, стабільна робоча температура двигуна.', 1120.00, 'ap_cool_02.jpg', 18),
(5, 'Ремінь приводний Contitech 6PK', 'Еластичний, стійкий до тріщин', 'Для навісного обладнання: генератор, ГУР, кондиціонер. Заміна при тріщинах або натягу.', 740.00, 'ap_cool_03.jpg', 33),
(5, 'Вентилятор охолодження Valeo', 'Двохшвидкісний, 400W', 'Знижує температуру в пробках і на підйомах. Перевірка реле та датчика перед заміною.', 4300.00, 'ap_cool_04.jpg', 10),
(5, 'Антифриз G12++ 1 л', 'Готовий розчин −35°C', 'Довготривала захист алюмінію та пластику системи. Не змішувати з силікатними рідинами.', 520.00, 'ap_cool_05.jpg', 48),

-- Кузов і скло
(6, 'Дзеркало бокове ліве з обігрівом', 'Під фарбування', 'Регулювання електроприводом, підігрів для зими. Кріплення під стандартні кліпси.', 2400.00, 'ap_body_01.jpg', 15),
(6, 'Бампер передній нефарбований', 'ПП пластик, під ПТФ', 'Поставляється без ґрунту; потрібне фарбування в колір кузова.', 6800.00, 'ap_body_02.jpg', 4),
(6, 'Крило переднє праве', 'Сталеве, під лак', 'Геометрія під заводські зазори. Антикорозійне фосфатування з заводу.', 4200.00, 'ap_body_03.jpg', 7),
(6, 'Скло лобове з шаром підігріву', 'Зелена смуга, VIN-маркування', 'Встановлення з клеєм та підушками безпеки за регламентом СТО.', 9200.00, 'ap_body_04.jpg', 3),
(6, 'Бризковики повний комплект', '4 шт., чорні матові', 'Зменшують бруд на порогах і задньому склі. Кріплення в штатні отвори.', 680.00, 'ap_body_05.jpg', 42);

-- ---------- cart ----------
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE ON DELETE CASCADE,
    UNIQUE KEY ux_user_product (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO cart (user_id, product_id, quantity) VALUES
(2, 1, 1),
(2, 6, 2),
(3, 3, 1),
(3, 12, 1);

-- ---------- orders ----------
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(50) NOT NULL DEFAULT 'Нове',
    shipping_address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO orders (user_id, total, status, shipping_address) VALUES
(2, 6020.00, 'Нове', 'м. Київ, вул. Хрещатик, 10'),
(3, 890.00, 'В обробці', 'м. Львів, вул. Січових Стрільців, 5');

-- ---------- order_items ----------
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 4680.00),
(1, 5, 1, 1340.00),
(2, 3, 1, 890.00);

-- ---------------------------------------------------------------------------
-- Опційно (після імпорту): видалити тільки client@gmail.com та maria@gmail.com
-- разом із кошиком і замовленнями — виконайте окремо у phpMyAdmin, якщо треба
-- ---------------------------------------------------------------------------
-- USE autoparts_store;
-- DELETE FROM cart WHERE user_id IN (SELECT id FROM users WHERE email IN ('client@gmail.com', 'maria@gmail.com'));
-- DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id IN (SELECT id FROM users WHERE email IN ('client@gmail.com', 'maria@gmail.com')));
-- DELETE FROM orders WHERE user_id IN (SELECT id FROM users WHERE email IN ('client@gmail.com', 'maria@gmail.com'));
-- DELETE FROM users WHERE email IN ('client@gmail.com', 'maria@gmail.com');
