<?php
session_start(); 
require_once 'functions.php'; 
require_once 'db.php'; 

include 'header.php'; 

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT c.product_id, p.price, c.quantity, p.name, p.image 
                       FROM cart c 
                       JOIN products p ON c.product_id = p.id 
                       WHERE c.user_id=?");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll();

if (!$cart_items) {
    header('Location: cart.php');
    exit;
}

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['shipping_address'];
    
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, shipping_address) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $total, $address]);
    $order_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id=?");
    $stmt->execute([$_SESSION['user_id']]);

    echo "<div class='order-success'>
            <h2>Дякуємо за замовлення!</h2>
            <p>Ваше замовлення №$order_id успішно створене.</p>
            <a href='index.php' class='btn'>Повернутися до магазину</a>
          </div>";
    exit;
}
?>

<div class="checkout-container">
    <h2>Оформлення замовлення</h2>
    
    <div class="checkout-content">
        <div class="order-summary">
            <h3>Ваше замовлення</h3>
            <div class="order-items">
                <?php foreach ($cart_items as $item): ?>
                <div class="order-item">
                    <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="item-details">
                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                        <p>Кількість: <?= $item['quantity'] ?></p>
                        <p>Ціна: <?= $item['price'] ?>₴</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="order-total">
                <h3>Загальна сума: <?= $total ?>₴</h3>
            </div>
        </div>

        <div class="checkout-form">
            <h3>Дані для доставки</h3>
            <form method="post">
                <div class="form-group">
                    <label for="shipping_address">Адреса доставки:</label>
                    <input type="text" id="shipping_address" name="shipping_address" required placeholder="Введіть повну адресу доставки">
                </div>
                
                <div class="form-group">
                    <label for="phone">Номер телефону:</label>
                    <input type="tel" id="phone" name="phone" placeholder="+380 (XX) XXX-XX-XX">
                </div>
                
                <div class="form-group">
                    <label for="notes">Примітки до замовлення:</label>
                    <textarea id="notes" name="notes" placeholder="Додаткові побажання щодо доставки..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-confirm">Підтвердити замовлення</button>
            </form>
        </div>
    </div>
</div>
