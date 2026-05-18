<?php
require_once 'functions.php';
$id = $_GET['id'] ?? 0;
$product = getProduct($id);

if (!$product) {
    header('Location: index.php');
    exit;
}

include 'header.php';

// Отримуємо товари з тієї ж категорії
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
$stmt->execute([$product['category_id'], $id]);
$related_products = $stmt->fetchAll();
?>

<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Навігаційний шлях">
    <ol class="breadcrumb-list">
        <li><a href="index.php">Головна</a></li>
        <li><span aria-hidden="true">/</span></li>
        <li><a href="category.php?id=<?= $product['category_id'] ?>">Категорія</a></li>
        <li><span aria-hidden="true">/</span></li>
        <li aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
    </ol>
</nav>

<!-- Product Detail Section -->
<section class="product-detail-section" itemscope itemtype="https://schema.org/Product">
    <div class="product-detail-container">
        <div class="product-gallery">
            <div class="product-main-image">
                <img src="images/<?= htmlspecialchars($product['image']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="product-img"
                     itemprop="image"
                     id="main-product-image">
            </div>
        </div>
        
        <div class="product-info">
            <div class="product-header">
                <h1 class="product-title" itemprop="name"><?= htmlspecialchars($product['name']) ?></h1>
                <div class="product-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                    <div class="stars" aria-label="Рейтинг 4.5 з 5">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <meta itemprop="ratingValue" content="4.5">
                    <meta itemprop="reviewCount" content="127">
                </div>
            </div>
            
            <div class="product-price-section" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <div class="price-main">
                    <span class="price-value" itemprop="price" content="<?= $product['price'] ?>">
                        <?= number_format($product['price'], 0, ',', ' ') ?>₴
                    </span>
                    <meta itemprop="priceCurrency" content="UAH">
                </div>
                <?php if($product['stock'] > 0): ?>
                    <div class="stock-info stock-available">
                        <span class="stock-icon">✓</span>
                        <span>На складі (<?= $product['stock'] ?> шт.)</span>
                    </div>
                <?php else: ?>
                    <div class="stock-info stock-unavailable">
                        <span class="stock-icon">✗</span>
                        <span>Немає в наявності</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="product-description-full" itemprop="description">
                <h3 class="description-title">Опис товару</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
            
            <div class="product-features">
                <h3 class="features-title">Особливості</h3>
                <ul class="features-list">
                    <li><span class="feature-icon">✓</span> Гарантія від постачальника</li>
                    <li><span class="feature-icon">✓</span> Перевірка перед відправкою</li>
                    <li><span class="feature-icon">✓</span> Доставка перевізником</li>
                    <li><span class="feature-icon">✓</span> Консультація щодо встановлення</li>
                </ul>
            </div>
            
            <form action="cart.php" method="post" class="product-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="quantity-selector">
                    <label for="quantity" class="quantity-label">Кількість:</label>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn minus" aria-label="Зменшити кількість">-</button>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               value="1" 
                               min="1" 
                               max="<?= $product['stock'] ?>"
                               class="quantity-input"
                               aria-label="Кількість товару">
                        <button type="button" class="quantity-btn plus" aria-label="Збільшити кількість">+</button>
                    </div>
                </div>
                <button type="submit" 
                        name="add_to_cart" 
                        class="btn btn-add-cart"
                        <?= $product['stock'] == 0 ? 'disabled' : '' ?>>
                    <span class="btn-icon">🛒</span>
                    <span class="btn-text">Додати в кошик</span>
                </button>
            </form>
        </div>
    </div>
</section>

<?php if (!empty($related_products)): ?>
<!-- Related Products Section -->
<section class="related-products-section" aria-labelledby="related-title">
    <h2 id="related-title" class="section-title">
        <span class="title-accent">З цієї</span>
        <span class="title-text">категорії</span>
    </h2>
    <div class="product-list">
        <?php foreach($related_products as $p): ?>
            <article class="product-card" itemscope itemtype="https://schema.org/Product">
                <a href="product.php?id=<?= $p['id'] ?>" class="product-link">
                    <div class="product-image-wrapper">
                        <img src="images/<?= htmlspecialchars($p['image']) ?>" 
                             alt="<?= htmlspecialchars($p['name']) ?>"
                             class="product-image"
                             itemprop="image"
                             loading="lazy">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name" itemprop="name"><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="product-description"><?= htmlspecialchars($p['short_description']) ?></p>
                        <div class="product-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                            <meta itemprop="price" content="<?= $p['price'] ?>">
                            <meta itemprop="priceCurrency" content="UAH">
                            <span class="price-value"><?= number_format($p['price'], 0, ',', ' ') ?>₴</span>
                        </div>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<script>
// Quantity controls
document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const input = this.parentElement.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        
        if (this.classList.contains('plus') && currentValue < max) {
            input.value = currentValue + 1;
        } else if (this.classList.contains('minus') && currentValue > min) {
            input.value = currentValue - 1;
        }
    });
});
</script>

<?php include 'footer.php'; ?>
