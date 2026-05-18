<?php
require_once 'functions.php';
$pdo = $GLOBALS['pdo'];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = 'Користувач з таким email вже існує';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        header('Location: login.php');
        exit;
    }
}
include 'header.php';
?>
<h2>Реєстрація</h2>
<form method="post">
    <input type="text" name="name" placeholder="Ім'я" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <button type="submit" class="btn">Зареєструватися</button>
</form>
<p class="error"><?= $error ?></p>
<?php include 'footer.php'; ?>
