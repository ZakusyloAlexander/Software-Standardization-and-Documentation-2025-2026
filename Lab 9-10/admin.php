<?php
require_once 'functions.php';
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

if (isset($_POST['add_product'])) {
    $stmt = $pdo->prepare("INSERT INTO products (name, short_description, description, price, image, stock, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['short_description'],
        $_POST['description'],
        $_POST['price'],
        $_POST['image'],
        $_POST['stock'],
        $_POST['category_id']
    ]);
    header('Location: admin.php');
    exit;
}

if (isset($_POST['update_product'])) {
    $stmt = $pdo->prepare("UPDATE products SET name=?, short_description=?, description=?, price=?, image=?, stock=?, category_id=? WHERE id=?");
    $stmt->execute([
        $_POST['name'],
        $_POST['short_description'],
        $_POST['description'],
        $_POST['price'],
        $_POST['image'],
        $_POST['stock'],
        $_POST['category_id'],
        $_POST['product_id']
    ]);
    header('Location: admin.php');
    exit;
}

if ($action === 'delete_product' && $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    header('Location: admin.php');
    exit;
}

if ($action === 'delete_user' && $id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=? AND id != ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header('Location: admin.php');
    exit;
}

if ($action === 'change_role' && $id) {
    $new_role = $_GET['role'] === 'admin' ? 'admin' : 'user';
    $stmt = $pdo->prepare("UPDATE users SET role=? WHERE id=?");
    $stmt->execute([$new_role, $id]);
    header('Location: admin.php');
    exit;
}

if ($action === 'update_order_status' && $id) {
    $new_status = $_POST['status'] ?? 'Нове';
    $stmt = $pdo->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->execute([$new_status, $id]);
    header('Location: admin.php');
    exit;
}

$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC")->fetchAll();
$users = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY id ASC")->fetchAll();
$orders = $pdo->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.created_at DESC")->fetchAll();
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

include 'header.php';
?>

<div class="admin-container">
    <h2>⚙️ Панель адміністратора</h2>

    <div class="admin-section">
        <h3>🛍️ Управління товарами</h3>
        
        <div class="admin-form">
            <h4><?= isset($_GET['edit_product']) ? 'Редагувати товар' : 'Додати новий товар' ?></h4>
            <form method="post">
                <?php if (isset($_GET['edit_product'])): 
                    $edit_product = $pdo->query("SELECT * FROM products WHERE id=" . (int)$_GET['edit_product'])->fetch();
                ?>
                <input type="hidden" name="product_id" value="<?= $edit_product['id'] ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <input type="text" name="name" placeholder="Назва товару" value="<?= $edit_product['name'] ?? '' ?>" required>
                    <input type="text" name="short_description" placeholder="Короткий опис" value="<?= $edit_product['short_description'] ?? '' ?>">
                    <input type="number" name="price" placeholder="Ціна" step="0.01" value="<?= $edit_product['price'] ?? '' ?>" required>
                    <input type="number" name="stock" placeholder="Кількість" value="<?= $edit_product['stock'] ?? 0 ?>">
                    <input type="text" name="image" placeholder="Назва зображення" value="<?= $edit_product['image'] ?? '' ?>">
                    <select name="category_id" required>
                        <option value="">Оберіть категорію</option>
                        <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($edit_product['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <textarea name="description" placeholder="Повний опис товару"><?= $edit_product['description'] ?? '' ?></textarea>
                
                <button type="submit" name="<?= isset($_GET['edit_product']) ? 'update_product' : 'add_product' ?>" class="btn">
                    <?= isset($_GET['edit_product']) ? 'Оновити товар' : 'Додати товар' ?>
                </button>
                <?php if (isset($_GET['edit_product'])): ?>
                <a href="admin.php" class="btn btn-secondary">Скасувати</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="admin-table-container">
            <h4>Список товарів (<?= count($products) ?>)</h4>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Зображення</th>
                        <th>Назва</th>
                        <th>Категорія</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="table-img"></td>
                        <td><?= $p['name'] ?></td>
                        <td><?= $p['category_name'] ?></td>
                        <td><?= $p['price'] ?>₴</td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <a href="admin.php?edit_product=<?= $p['id'] ?>" class="btn-sm btn-edit">✏️</a>
                            <a href="admin.php?action=delete_product&id=<?= $p['id'] ?>" 
                               class="btn-sm btn-delete" 
                               onclick="return confirm('Видалити цей товар?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section">
        <h3>👥 Управління користувачами</h3>
        
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата реєстрації</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= $u['name'] ?></td>
                        <td><?= $u['email'] ?></td>
                        <td>
                            <span class="role-badge <?= $u['role'] ?>"><?= $u['role'] ?></span>
                        </td>
                        <td><?= date('d.m.Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                            <a href="admin.php?action=change_role&id=<?= $u['id'] ?>&role=<?= $u['role'] === 'admin' ? 'user' : 'admin' ?>" 
                               class="btn-sm <?= $u['role'] === 'admin' ? 'btn-demote' : 'btn-promote' ?>">
                                <?= $u['role'] === 'admin' ? '👎' : '👍' ?>
                            </a>
                            <a href="admin.php?action=delete_user&id=<?= $u['id'] ?>" 
                               class="btn-sm btn-delete"
                               onclick="return confirm('Видалити цього користувача?')">🗑️</a>
                            <?php else: ?>
                            <span class="text-muted">Поточний</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section">
        <h3>📦 Управління замовленнями</h3>
        
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Користувач</th>
                        <th>Сума</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $o): ?>
                    <tr>
                        <td>#<?= $o['id'] ?></td>
                        <td><?= $o['user_name'] ?></td>
                        <td><?= $o['total'] ?>₴</td>
                        <td>
                            <form method="post" action="admin.php?action=update_order_status&id=<?= $o['id'] ?>" class="status-form">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="Нове" <?= $o['status'] === 'Нове' ? 'selected' : '' ?>>Нове</option>
                                    <option value="В обробці" <?= $o['status'] === 'В обробці' ? 'selected' : '' ?>>В обробці</option>
                                    <option value="Відправлено" <?= $o['status'] === 'Відправлено' ? 'selected' : '' ?>>Відправлено</option>
                                    <option value="Виконано" <?= $o['status'] === 'Виконано' ? 'selected' : '' ?>>Виконано</option>
                                    <option value="Скасовано" <?= $o['status'] === 'Скасовано' ? 'selected' : '' ?>>Скасовано</option>
                                </select>
                            </form>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>