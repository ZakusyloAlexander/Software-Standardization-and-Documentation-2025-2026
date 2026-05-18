# Звіт з аналізу проєкту Lab 9-10

## 1. Мета аналізу

Проведено повний огляд каталогу `Lab 9-10/` перед підготовкою документації зі стандартизації ПЗ. Мета — зафіксувати реальну структуру, технології, функції та обмеження без шаблонних припущень.

## 2. Структура каталогів

```
Lab 9-10/
├── .htaccess              # Apache: DirectoryIndex, rewrite на index.php
├── .osp/
│   └── project.ini        # OpenServer: PHP-8.0, autoparts-store.local
├── admin.php              # Панель адміністратора
├── app.css                # Основні стилі (підключено в header.php)
├── auth.php               # Заглушка: редірект неавторизованих на login
├── autoparts_shop.sql     # SQL-дамп БД autoparts_store
├── cart.php               # Кошик (CRUD позицій)
├── category.php           # Каталог за категорією
├── checkout.php           # Оформлення замовлення
├── db.php                 # PDO + ensure_autoparts_schema()
├── delete_users.php       # Утиліта видалення демо-користувачів
├── footer.php             # Підвал + підключення script.js
├── functions.php          # Сесія, хелпери, запити до БД
├── header.php             # Шапка, навігація, пошук (форма)
├── index.html             # Редірект на index.php
├── index.php              # Головна сторінка
├── login.php / logout.php / register.php
├── ping.php               # Перевірка PHP
├── product.php            # Картка товару
├── profile.php            # Профіль і історія замовлень
├── script.js              # Клієнтська логіка
├── style.css / ui.css     # Додаткові стилі (не підключені в header)
└── docs/                  # Документація (цей комплект)
```

**Не знайдено:** підкаталог `magazin-games`, `package.json`, `node_modules`, `images/` у списку файлів (зображення очікуються в `images/` за шляхами в БД, напр. `ap_engine_01.jpg`).

## 3. Аналіз залежностей

| Очікування (типовий frontend) | Факт у проєкті |
|------------------------------|----------------|
| `package.json`, npm | **Відсутній** |
| React / Vue / Angular | **Відсутній** |
| Composer / PSR-4 | **Відсутній** |
| Окремий API-сервер | **Відсутній** |

**Серверні залежності:** PHP 8.0, розширення PDO MySQL, сесії PHP.  
**Клієнтські:** нативний DOM API в `script.js`, без jQuery/npm.

## 4. Маршрутизація (routing)

Проєкт використовує **класичну file-based routing** PHP:

| URL | Файл | Метод | Авторизація |
|-----|------|-------|-------------|
| `/` або `/index.php` | `index.php` | GET | Ні |
| `/category.php?id={n}` | `category.php` | GET | Ні |
| `/product.php?id={n}` | `product.php` | GET | Ні |
| `/cart.php` | `cart.php` | GET/POST | Так (`isLoggedIn`) |
| `/cart.php?remove={cart_id}` | `cart.php` | GET | Так |
| `/checkout.php` | `checkout.php` | GET/POST | Так |
| `/login.php` | `login.php` | GET/POST | Ні (редирект якщо вже в системі) |
| `/register.php` | `register.php` | GET/POST | Ні |
| `/logout.php` | `logout.php` | GET | Ні |
| `/profile.php` | `profile.php` | GET | Так |
| `/admin.php` | `admin.php` | GET/POST | Роль `admin` |
| `/ping.php` | `ping.php` | GET | Ні |
| `/auth.php` | `auth.php` | GET | Редірект на login |

`.htaccess` встановлює `DirectoryIndex index.php` і rewrite кореня на `index.php`.

## 5. Компоненти та повторне використання

| «Компонент» | Файл | Роль |
|-------------|------|------|
| Шапка | `header.php` | HTML head, meta, nav, пошук, посилання кошик/профіль |
| Підвал | `footer.php` | Контакти, закриття `main`, `script.js` |
| Бізнес-логіка | `functions.php` | `getCategories`, `getProduct`, `getProductsByCategory`, `searchProducts` |
| Підключення БД | `db.php` | PDO, міграція/seed через `ensure_autoparts_schema()` |

Окремих PHP-класів або шаблонізатора (Twig, Blade) **немає**.

## 6. Робота з даними

- **Читання:** прямі SQL-запити через `$pdo` у сторінках і функціях.
- **Кошик:** таблиця `cart`, унікальний ключ `(user_id, product_id)`, `ON DUPLICATE KEY UPDATE` при додаванні.
- **Замовлення:** `orders` + `order_items`, після checkout кошик очищується.
- **Адмін:** INSERT/UPDATE/DELETE для `products`, `users`, `orders.status`.

## 7. Клієнтська логіка (`script.js`)

| Функція | Реалізація |
|---------|------------|
| Мобільне меню | Toggle класу `.active` на `.nav` |
| Ripple на кнопках | Динамічний `<span class="ripple">` |
| Бейдж кошика | `localStorage.cartCount` — **не синхронізується з сервером** |
| Швидке «+» в каталозі | POST-форма на `cart.php` (потрібен вхід) |
| Плавний скрол | `scrollIntoView` для якорів `#` |
| Валідація форм | Перевірка `[required]` перед submit |
| Scroll reveal | `IntersectionObserver` для секцій |

## 8. Функції, оголошені але не використані

| Елемент | Статус |
|---------|--------|
| `searchProducts($query)` у `functions.php` | **Не викликається** |
| Форма пошуку в `header.php` (`GET index.php?q=`) | **index.php не обробляє `q`** |
| Поля `phone`, `notes` у `checkout.php` | **Не зберігаються в БД** |
| `style.css`, `ui.css` | **Не підключені** в `header.php` |
| Рейтинг 4.5 / 127 відгуків на `product.php` | **Статичний markup**, не з БД |

## 9. Безпека (фактичний стан)

- Паролі в БД зберігаються **відкритим текстом** (`password === $user['password']` у `login.php`).
- У `category.php` назва категорії: `$pdo->query("SELECT name FROM categories WHERE id=$category_id")` — ризик SQL-ін'єкції при некоректному `id`.
- У `admin.php` редагування товару: `query("SELECT * FROM products WHERE id=" . (int)$_GET['edit_product'])` — приведення до int знижує ризик.
- Немає CSRF-токенів на формах.
- `htmlspecialchars()` використовується при виводі назв товарів у більшості місць.

## 10. Висновок для документації

Проєкт — **монолітний PHP + MySQL інтернет-магазин автозапчастин** з сесійною авторизацією, серверним рендерингом HTML і мінімальним JavaScript. Документація описує саме цю систему; функції магазину ігор, REST JSON API та сучасний SPA-стек **в коді відсутні** і в документацію не включені.
