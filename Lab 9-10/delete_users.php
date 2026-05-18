<?php
require_once 'db.php';

try {
    // Отримуємо ID користувачів, яких потрібно видалити
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email IN (?, ?)");
    $stmt->execute(['client@gmail.com', 'maria@gmail.com']);
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($userIds)) {
        echo "Користувачі client@gmail.com та maria@gmail.com не знайдені в базі даних.\n";
        exit;
    }
    
    echo "Знайдено користувачів для видалення. ID: " . implode(', ', $userIds) . "\n";
    
    // Починаємо транзакцію
    $pdo->beginTransaction();
    
    // Видаляємо дані з кошика
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id IN (" . implode(',', array_fill(0, count($userIds), '?')) . ")");
    $stmt->execute($userIds);
    $cartDeleted = $stmt->rowCount();
    echo "Видалено записів з кошика: $cartDeleted\n";
    
    // Отримуємо ID замовлень цих користувачів
    $stmt = $pdo->prepare("SELECT id FROM orders WHERE user_id IN (" . implode(',', array_fill(0, count($userIds), '?')) . ")");
    $stmt->execute($userIds);
    $orderIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($orderIds)) {
        // Видаляємо елементи замовлень
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id IN (" . implode(',', array_fill(0, count($orderIds), '?')) . ")");
        $stmt->execute($orderIds);
        $itemsDeleted = $stmt->rowCount();
        echo "Видалено елементів замовлень: $itemsDeleted\n";
        
        // Видаляємо замовлення
        $stmt = $pdo->prepare("DELETE FROM orders WHERE user_id IN (" . implode(',', array_fill(0, count($userIds), '?')) . ")");
        $stmt->execute($userIds);
        $ordersDeleted = $stmt->rowCount();
        echo "Видалено замовлень: $ordersDeleted\n";
    }
    
    // Видаляємо самих користувачів
    $stmt = $pdo->prepare("DELETE FROM users WHERE email IN (?, ?)");
    $stmt->execute(['client@gmail.com', 'maria@gmail.com']);
    $usersDeleted = $stmt->rowCount();
    echo "Видалено користувачів: $usersDeleted\n";
    
    // Підтверджуємо транзакцію
    $pdo->commit();
    
    echo "\n✅ Успішно видалено користувачів client@gmail.com та maria@gmail.com та всі пов'язані дані!\n";
    
} catch (PDOException $e) {
    // Відкатуємо транзакцію у разі помилки
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Помилка: " . $e->getMessage() . "\n";
}
?>


