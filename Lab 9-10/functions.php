<?php
require_once 'db.php';
$pdo = $GLOBALS['pdo'];
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function getCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    return $stmt->fetchAll();
}

function getProductsByCategory($category_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=?");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll();
}

function getProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function searchProducts($query) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $stmt->execute(["%$query%", "%$query%"]);
    return $stmt->fetchAll();
}
?>
