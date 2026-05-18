<?php
require_once 'functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

include 'header.php';
?>
<h2>Профіль</h2>
<p><strong>Ім'я:</strong> <?= $user['name'] ?></p>
<p><strong>Email:</strong> <?= $user['email'] ?></p>

<h3>Мої замовлення</h3>
<?php if ($orders): ?>
<table class="cart-table">
<tr><th>ID</th><th>Дата</th><th>Сума</th><th>Статус</th></tr>
<?php foreach ($orders as $o): ?>
<tr>
    <td><?= $o['id'] ?></td>
    <td><?= $o['created_at'] ?></td>
    <td><?= $o['total'] ?>₴</td>
    <td><?= $o['status'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>У вас ще немає замовлень.</p>
<?php endif; ?>
<?php include 'footer.php'; ?>
