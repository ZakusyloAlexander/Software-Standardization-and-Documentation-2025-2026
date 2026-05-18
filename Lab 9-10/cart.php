<?php
require_once 'functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->execute([$_SESSION['user_id'], $product_id, $quantity, $quantity]);
    header('Location: cart.php');
    exit;
}

if (isset($_GET['remove'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
    $stmt->execute([(int)$_GET['remove'], $_SESSION['user_id']]);
    header('Location: cart.php');
    exit;
}

if (isset($_POST['update_quantity'])) {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$quantity, $cart_id, $_SESSION['user_id']]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->execute([$cart_id, $_SESSION['user_id']]);
    }
    header('Location: cart.php');
    exit;
}

$stmt = $pdo->prepare("SELECT c.id as cart_id, p.*, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id=?");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll();

include 'header.php';
?>

<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Навігаційний шлях">
    <ol class="breadcrumb-list">
        <li><a href="index.php">Головна</a></li>
        <li><span aria-hidden="true">/</span></li>
        <li aria-current="page">Кошик</li>
    </ol>
</nav>

<!-- Cart Section -->
<section class="cart-section" aria-labelledby="cart-title">
    <h1 id="cart-title" class="page-title">
        <span class="title-icon">🛒</span>
        <span class="title-text">Ваш кошик</span>
    </h1>
    
    <?php if ($cart_items): ?>
        <div class="cart-container">
            <div class="cart-items" role="list" itemscope itemtype="https://schema.org/ItemList">
                <?php 
                $total = 0;
                foreach ($cart_items as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <article class="cart-item" 
                             role="listitem"
                             itemscope 
                             itemtype="https://schema.org/Product"
                             data-cart-id="<?= $item['cart_id'] ?>">
                        <div class="cart-item-image">
                            <img src="images/<?= htmlspecialchars($item['image']) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 itemprop="image">
                        </div>
                        <div class="cart-item-info">
                            <h3 class="cart-item-name" itemprop="name">
                                <a href="product.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a>
                            </h3>
                            <p class="cart-item-description" itemprop="description">
                                <?= htmlspecialchars($item['short_description']) ?>
                            </p>
                            <div class="cart-item-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                <meta itemprop="price" content="<?= $item['price'] ?>">
                                <meta itemprop="priceCurrency" content="UAH">
                                <span class="price-unit"><?= number_format($item['price'], 0, ',', ' ') ?>₴</span>
                                <span class="price-total">× <?= $item['quantity'] ?> = <?= number_format($subtotal, 0, ',', ' ') ?>₴</span>
                            </div>
                        </div>
                        <div class="cart-item-controls">
                            <form method="post" class="quantity-form">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <div class="quantity-controls">
                                    <button type="button" class="quantity-btn minus" data-cart-id="<?= $item['cart_id'] ?>">-</button>
                                    <input type="number" 
                                           name="quantity" 
                                           value="<?= $item['quantity'] ?>" 
                                           min="1" 
                                           max="<?= $item['stock'] ?>"
                                           class="quantity-input"
                                           readonly>
                                    <button type="button" class="quantity-btn plus" data-cart-id="<?= $item['cart_id'] ?>">+</button>
                                </div>
                                <input type="hidden" name="update_quantity" value="1">
                            </form>
                            <a href="?remove=<?= $item['cart_id'] ?>" 
                               class="btn-remove"
                               aria-label="Видалити <?= htmlspecialchars($item['name']) ?> з кошика">
                                <span class="remove-icon">🗑️</span>
                                <span class="remove-text">Видалити</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <aside class="cart-summary" role="complementary">
                <div class="summary-card">
                    <h2 class="summary-title">Підсумок замовлення</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span class="summary-label">Товарів:</span>
                            <span class="summary-value"><?= count($cart_items) ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Проміжна сума:</span>
                            <span class="summary-value"><?= number_format($total, 0, ',', ' ') ?>₴</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span class="summary-label">До сплати:</span>
                            <span class="summary-value"><?= number_format($total, 0, ',', ' ') ?>₴</span>
                        </div>
                    </div>
                    <a href="checkout.php" class="btn btn-checkout">
                        <span class="btn-icon">💳</span>
                        <span class="btn-text">Оформити замовлення</span>
                    </a>
                    <a href="index.php" class="btn btn-continue">
                        <span class="btn-icon">←</span>
                        <span class="btn-text">Продовжити покупки</span>
                    </a>
                </div>
            </aside>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h2 class="empty-cart-title">Ваш кошик порожній</h2>
            <p class="empty-cart-text">Додайте запчастини до кошика, щоб оформити замовлення</p>
            <a href="index.php" class="btn btn-primary">Перейти до каталогу</a>
        </div>
    <?php endif; ?>
</section>

<script>
// Cart quantity controls
document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const cartId = this.dataset.cartId;
        const form = this.closest('.quantity-form');
        const input = form.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        
        if (this.classList.contains('plus') && currentValue < max) {
            input.value = currentValue + 1;
        } else if (this.classList.contains('minus') && currentValue > min) {
            input.value = currentValue - 1;
        }
        
        // Auto-submit on change
        if (input.value != currentValue) {
            form.submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>
