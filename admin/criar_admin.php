<?php
require_once __DIR__ . '/../admin/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    $stmt = $pdo->prepare("INSERT INTO admin (nome, email, password, tipo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $password, $tipo]);

    $msg = " Utilizador criado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/css/criar_admin.css">

</head>
<body>

<h2>Criar Novo Utilizador</h2>

<?php if ($msg): ?>
<p style="color:green"><?= $msg ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <select name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="admin">Admin</option>
        <option value="utilizador">Utilizador</option>
    </select><br><br>
    <button type="submit">Criar Utilizador</button>
</form>
<a href="gerir_admin.php">← Voltar</a>
</body>
</html>
