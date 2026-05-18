# Документація програмного забезпечення «АвтоСклад Плюс»

**Дисципліна:** Стандартизація та документування ПЗ  
**Лабораторна робота:** 9–10  
**Каталог проєкту:** `Lab 9-10/` (корінь веб-додатку)  
**Дата підготовки:** 19 травня 2026 р.

---

## Примітка щодо шляху `magazin-games`

Під час аналізу **папка `Lab 9-10/magazin-games` не виявлена**. Усі вихідні файли розташовані безпосередньо в `Lab 9-10/`. Документація побудована виключно на реальному коді цього каталогу.

Фактична предметна область проєкту — **інтернет-магазин автозапчастин** («АвтоСклад Плюс» / «АвтоДеталі»), а не магазин відеоігор. У Swagger і Postman відображено саме ці сутності (`products`, `categories`, `cart`, `orders`).

---

## Склад комплекту документації

| № | Документ | Призначення |
|---|----------|-------------|
| 00 | [00-analiz-proektu.md](00-analiz-proektu.md) | Звіт про аналіз структури, стеку та обмежень |
| 01 | [01-zagalnyy-opys.md](01-zagalnyy-opys.md) | Загальний опис ПЗ, цілі, функціональність |
| 02 | [02-arkhitektura.md](02-arkhitektura.md) | Архітектура, модулі, потоки даних |
| 03 | [03-baza-danykh.md](03-baza-danykh.md) | Схема БД, таблиці, зв’язки, демо-дані |
| 04 | [04-interfeys-ta-storinky.md](04-interfeys-ta-storinky.md) | Сторінки, навігація, UI, клієнтський JS |
| 05 | [05-posibnyk-korystuvacha.md](05-posibnyk-korystuvacha.md) | Посібник користувача та сценарії |
| 06 | [06-rozrobnyk-ta-rozvertannya.md](06-rozrobnyk-ta-rozvertannya.md) | Інструкції для розробника та розгортання |
| API | [api/openapi.yaml](api/openapi.yaml) | OpenAPI 3.0 — HTTP-контракт сторінок і форм |
| API | [api/AutoSklad-Plus.postman_collection.json](api/AutoSklad-Plus.postman_collection.json) | Колекція Postman для ручного тестування |

---

## Швидкий старт

1. Імпортувати `autoparts_shop.sql` у MySQL або покластися на автостворення схеми в `db.php`.
2. Налаштувати OpenServer / Apache з PHP 8.0, корінь сайту = `Lab 9-10/`.
3. Перевірити `ping.php` — має повернути `OK: PHP працює.`
4. Увійти як адміністратор: `admin@gmail.com` / `123`.

---

## Технологічний стек (фактичний)

| Компонент | Технологія |
|-----------|------------|
| Мова сервера | PHP 8.0 |
| База даних | MySQL 8.0 (`autoparts_store`) |
| Доступ до БД | PDO |
| Сесії | `session_start()` (PHP) |
| Клієнт | HTML5, CSS (`app.css`), JavaScript (`script.js`) |
| Веб-сервер | Apache (`.htaccess`, OpenServer) |

**Відсутньо в проєкті:** `package.json`, Node.js, React/Vue, окремий REST API, Swagger UI у runtime.
