<?php
require_once 'functions.php';
include 'header.php';

$categories = getCategories();
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
$products = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero-section" aria-labelledby="hero-title">
    <div class="hero-content">
        <h1 id="hero-title" class="hero-title">
            <span class="hero-title-main">АвтоСклад Плюс</span>
            <span class="hero-title-sub">Запчастини без зайвих кілометрів</span>
        </h1>
        <p class="hero-description">
            Оригінальні та аналоги для легкових автомобілів: двигун, гальма, підвіска, електрика та кузов.
            Зручний каталог, актуальні залишки на складі та відправка перевізником по всій Україні.
        </p>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">30+</span>
                <span class="stat-label">Позицій</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">6</span>
                <span class="stat-label">Категорій</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">Пн–Сб</span>
                <span class="stat-label">Консультації</span>
            </div>
        </div>
        <a href="#products" class="btn btn-hero">До каталогу</a>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="delivery" aria-labelledby="features-title">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🚚</div>
            <h3 class="feature-title">Доставка по Україні</h3>
            <p class="feature-text">Відправка Новою та Укрпоштою у зручне відділення</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🛡️</div>
            <h3 class="feature-title">Гарантія якості</h3>
            <p class="feature-text">Перевірені постачальники та документи на вузли</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💳</div>
            <h3 class="feature-title">Безпечна оплата</h3>
            <p class="feature-text">Картка, кеш на доставку або безготівковий розрахунок</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔧</div>
            <h3 class="feature-title">Підбір під авто</h3>
            <p class="feature-text">Допоможемо з артикулами та сумісністю за VIN</p>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section" aria-labelledby="categories-title">
    <h2 id="categories-title" class="section-title">
        <span class="title-accent">Категорії</span>
        <span class="title-text">запчастин</span>
    </h2>
    <div class="categories" role="list">
        <?php foreach($categories as $cat): ?>
            <a href="category.php?id=<?= $cat['id'] ?>" 
               class="category-link" 
               role="listitem"
               aria-label="Переглянути категорію <?= htmlspecialchars($cat['name']) ?>">
                <span class="category-icon"><?php 
                    $icons = ['⚙️', '🛑', '🛞', '⚡', '❄️', '🚗'];
                    echo $icons[$cat['id'] - 1] ?? '📦';
                ?></span>
                <span class="category-name"><?= htmlspecialchars($cat['name']) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="products-section" aria-labelledby="products-title">
    <div class="section-header">
        <h2 id="products-title" class="section-title">
            <span class="title-accent">Нові</span>
            <span class="title-text">надходження</span>
        </h2>
        <p class="section-subtitle">Останні позиції на складі</p>
    </div>
    
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <p class="empty-text">Наразі товарів немає. Завітайте пізніше!</p>
        </div>
    <?php else: ?>
        <div class="product-list" role="list" itemscope itemtype="https://schema.org/ItemList">
            <?php foreach($products as $index => $p): ?>
                <article class="product-card" 
                         role="listitem"
                         itemscope 
                         itemtype="https://schema.org/Product"
                         data-product-id="<?= $p['id'] ?>">
                    <a href="product.php?id=<?= $p['id'] ?>" class="product-link" aria-label="Деталі товару <?= htmlspecialchars($p['name']) ?>">
                        <div class="product-image-wrapper">
                            <img src="images/<?= htmlspecialchars($p['image']) ?>" 
                                 alt="<?= htmlspecialchars($p['name']) ?>"
                                 class="product-image"
                                 itemprop="image"
                                 loading="lazy">
                            <div class="product-overlay">
                                <span class="overlay-text">Детальніше</span>
                            </div>
                            <?php if($p['stock'] > 0 && $p['stock'] < 5): ?>
                                <span class="stock-badge stock-low">Залишилось <?= $p['stock'] ?></span>
                            <?php elseif($p['stock'] == 0): ?>
                                <span class="stock-badge stock-out">Немає в наявності</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name" itemprop="name"><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="product-description" itemprop="description"><?= htmlspecialchars($p['short_description']) ?></p>
                            <div class="product-footer">
                                <div class="product-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="price" content="<?= $p['price'] ?>">
                                    <meta itemprop="priceCurrency" content="UAH">
                                    <span class="price-value"><?= number_format($p['price'], 0, ',', ' ') ?>₴</span>
                                </div>
                                <button class="btn-add-to-cart" 
                                        data-product-id="<?= $p['id'] ?>"
                                        aria-label="Додати <?= htmlspecialchars($p['name']) ?> до кошика"
                                        <?= $p['stock'] == 0 ? 'disabled' : '' ?>>
                                    <span class="btn-icon">+</span>
                                </button>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- CTA Section -->
<section class="cta-section" aria-labelledby="cta-title">
    <div class="cta-content">
        <h2 id="cta-title" class="cta-title">Потрібна конкретна запчастина?</h2>
        <p class="cta-text">Оберіть категорію або зверніться до менеджера — підкажемо артикул і сумісність</p>
        <a href="#categories-title" class="btn btn-cta">Переглянути категорії</a>
    </div>
</section>

<?php include 'footer.php'; ?>
