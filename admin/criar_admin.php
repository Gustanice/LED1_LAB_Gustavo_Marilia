<?php
require_once __DIR__ . '/../admin/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO admin (nome, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $password]);

    $msg = "Admin criado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Admin</title>
</head>
<body>

<h2>Criar Novo Admin</h2>

<?php if ($msg): ?>
<p style="color:green"><?= $msg ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Criar Admin</button>
</form>

</body>
</html>
