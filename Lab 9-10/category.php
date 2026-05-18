<?php
require_once 'functions.php';
$category_id = $_GET['id'] ?? 0;
$category_products = getProductsByCategory($category_id);
$category_name = $pdo->query("SELECT name FROM categories WHERE id=$category_id")->fetchColumn();
include 'header.php';

$categories = getCategories();
?>

<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Навігаційний шлях">
    <ol class="breadcrumb-list">
        <li><a href="index.php">Головна</a></li>
        <li><span aria-hidden="true">/</span></li>
        <li aria-current="page"><?= htmlspecialchars($category_name) ?></li>
    </ol>
</nav>

<!-- Category Header -->
<section class="category-header">
    <h1 class="category-title">
        <span class="title-accent">Категорія:</span>
        <span class="title-text"><?= htmlspecialchars($category_name) ?></span>
    </h1>
    <p class="category-count">
        Знайдено товарів: <strong><?= count($category_products) ?></strong>
    </p>
</section>

<!-- Categories Navigation -->
<section class="categories-section">
    <h2 class="section-title visually-hidden">Всі категорії</h2>
    <div class="categories" role="list">
        <?php foreach($categories as $cat): ?>
            <a href="category.php?id=<?= $cat['id'] ?>" 
               class="category-link <?= $cat['id'] == $category_id ? 'active' : '' ?>"
               role="listitem"
               aria-label="Переглянути категорію <?= htmlspecialchars($cat['name']) ?>"
               <?= $cat['id'] == $category_id ? 'aria-current="page"' : '' ?>>
                <span class="category-icon"><?php 
                    $icons = ['⚙️', '🛑', '🛞', '⚡', '❄️', '🚗'];
                    echo $icons[$cat['id'] - 1] ?? '📦';
                ?></span>
                <span class="category-name"><?= htmlspecialchars($cat['name']) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Products Grid -->
<section class="products-section" aria-labelledby="products-title">
    <?php if (empty($category_products)): ?>
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h2 class="empty-title">Товарів не знайдено</h2>
            <p class="empty-text">У цій категорії поки що немає товарів.</p>
            <a href="index.php" class="btn">Повернутися на головну</a>
        </div>
    <?php else: ?>
        <div class="product-list" role="list" itemscope itemtype="https://schema.org/ItemList">
            <?php foreach($category_products as $p): ?>
                <article class="product-card" 
                         role="listitem"
                         itemscope 
                         itemtype="https://schema.org/Product"
                         data-product-id="<?= $p['id'] ?>">
                    <a href="product.php?id=<?= $p['id'] ?>" 
                       class="product-link"
                       aria-label="Деталі товару <?= htmlspecialchars($p['name']) ?>">
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

<?php include 'footer.php'; ?>
