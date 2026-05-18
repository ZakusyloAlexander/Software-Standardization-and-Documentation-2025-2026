<?php
require_once 'functions.php';
$pdo = $GLOBALS['pdo'];
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && $password === $user['password']) { 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неправильний email або пароль';
    }
}
include 'header.php';
?>
<h2>Вхід</h2>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <button type="submit" class="btn">Увійти</button>
</form>
<p class="error"><?= $error ?></p>
<?php include 'footer.php'; ?>
