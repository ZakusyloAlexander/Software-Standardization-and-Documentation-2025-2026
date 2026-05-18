<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="АвтоСклад Плюс — інтернет-магазин автозапчастин: двигун, гальма, підвіска, електрика, охолодження та кузовні елементи. Підбір по каталогу та доставка по Україні.">
    <meta name="keywords" content="автозапчастини, інтернет магазин, гальма, підвіска, двигун, акумулятор, доставка запчастин">
    <title>АвтоСклад Плюс — інтернет-магазин автозапчастин</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
<header class="topbar" role="banner">
    <div class="container topbar-inner">
        <div class="brand" itemscope itemtype="https://schema.org/Organization">
            <a class="brand-link" href="index.php" itemprop="url" aria-label="АвтоДеталі — головна сторінка">
                <span class="brand-text" itemprop="name">АвтоДеталі</span>
            </a>
        </div>

        <nav class="nav nav-center" role="navigation" aria-label="Головна навігація">
            <a href="index.php" class="nav-link" aria-current="page">Головна</a>
            <a href="index.php#products" class="nav-link">Каталог</a>
            <a href="index.php#categories-title" class="nav-link">Категорії</a>
            <a href="#delivery" class="nav-link">Доставка</a>
            <a href="#contacts" class="nav-link">Контакти</a>
        </nav>

        <div class="topbar-actions">
            <form class="search" action="index.php" method="get" role="search" aria-label="Пошук запчастин">
                <label class="visually-hidden" for="site-search">Пошук</label>
                <input
                    id="site-search"
                    name="q"
                    class="search-input"
                    type="search"
                    placeholder="Пошук по назві, артикулу або VIN..."
                    autocomplete="off"
                >
                <button class="search-submit" type="submit">Пошук</button>
            </form>

            <a class="text-action cart-action" href="cart.php" aria-label="Кошик">
                <span class="text-action-label">Кошик</span>
                <span class="cart-badge" id="cart-badge" style="display:none;">0</span>
            </a>

            <?php if(isLoggedIn()): ?>
                <a class="text-action" href="profile.php" aria-label="Профіль">Профіль</a>
                <a class="text-action" href="logout.php" aria-label="Вихід">Вихід</a>
                <?php if(isAdmin()): ?>
                    <a class="text-action" href="admin.php" aria-label="Адмін">Адмін</a>
                <?php endif; ?>
            <?php else: ?>
                <a class="text-action" href="login.php" aria-label="Увійти">Увійти</a>
            <?php endif; ?>
        </div>

        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Відкрити меню" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
<main class="main container" role="main">
