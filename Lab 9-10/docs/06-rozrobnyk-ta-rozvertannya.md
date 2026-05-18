# Керівництво розробника та розгортання

## 6.1 Отримання коду

Клонувати або скопіювати каталог `Lab 9-10/` на локальний веб-сервер. Корінь сайту = ця папка (де лежать `index.php`, `.htaccess`).

## 6.2 OpenServer (конфігурація з репозиторію)

Файл `.osp/project.ini`:

```ini
[autoparts-store.local]
php_engine = PHP-8.0
project_dir = {base_dir}
public_dir = {base_dir}
```

Створити домен `autoparts-store.local`, увімкнути PHP 8.0 та MySQL 8.0.

## 6.3 База даних

### Варіант A — SQL-дамп

```bash
mysql -u root < autoparts_shop.sql
```

### Варіант B — автоматична ініціалізація

При першому зверненні до будь-якої сторінки з `require db.php` виконається `ensure_autoparts_schema()`.

Перевірити параметри в `db.php`:

```php
$host = 'MySQL-8.0';
$db   = 'autoparts_store';
$user = 'root';
$pass = '';
```

Змінити під свій інстанс MySQL за потреби.

## 6.4 Перевірка установки

| Крок | URL / дія | Очікування |
|------|-----------|------------|
| 1 | `/ping.php` | Текст `OK: PHP працює.` |
| 2 | `/index.php` | Головна з категоріями |
| 3 | Вхід admin | Доступ до `/admin.php` |

## 6.5 Структура для розширення

| Задача | Файли для змін |
|--------|----------------|
| Новий хелпер БД | `functions.php` |
| Нова публічна сторінка | `newpage.php` + `header`/`footer` |
| Стилі | `app.css` (рекомендовано) |
| Клієнтська логіка | `script.js` |
| Seed даних | `db.php` або `autoparts_shop.sql` |

## 6.6 Реалізація пошуку (рекомендація)

У `index.php` після `require_once 'functions.php'`:

```php
if (!empty($_GET['q'])) {
    $products = searchProducts(trim($_GET['q']));
    // відобразити окрему секцію результатів
}
```

Функція `searchProducts` уже є в `functions.php`.

## 6.7 Тестування HTTP (Postman)

Імпортувати `docs/api/AutoSklad-Plus.postman_collection.json`.  
Змінна `baseUrl`: `http://autoparts-store.local` (або `http://localhost/Lab%209-10`).

**Важливо:** більшість запитів повертають **HTML**, не JSON. Для API-тестів перевіряйте код відповіді, редіректи `302`, наявність cookie сесії `PHPSESSID`.

## 6.8 Swagger / OpenAPI

Файл `docs/api/openapi.yaml` описує:

- публічні GET-сторінки;
- POST-форми з `application/x-www-form-urlencoded`;
- сесію через cookie.

Відкрити в [Swagger Editor](https://editor.swagger.io/) або VS Code з розширенням OpenAPI.

## 6.9 Службові скрипти

| Файл | Призначення |
|------|-------------|
| `delete_users.php` | CLI/браузер: видалення demo users client/maria |
| `auth.php` | Редірект неавторизованих (майже порожній) |

## 6.10 Контрольний список перед здачею лабораторної

- [ ] MySQL доступний, таблиці створені  
- [ ] `ping.php` відповідає OK  
- [ ] Зображення в `images/` відповідають полю `products.image`  
- [ ] Вхід user і admin працює  
- [ ] Повний цикл: кошик → checkout → профіль  
- [ ] Адмін змінює статус замовлення  
- [ ] Документація в `docs/` відкривається в Markdown-переглядачі  

## 6.11 Відомі технічні борги

1. Plaintext паролі.  
2. Нереалізований пошук.  
3. `category.php` — конкатенація id у SQL.  
4. Бейдж кошика в JS не з сервера.  
5. Дубль CSS (`style.css`, `ui.css`) без підключення.
