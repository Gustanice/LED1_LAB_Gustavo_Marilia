<?php
session_start();
if (!isset($_SESSION['ID_admin']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}

require_once __DIR__ . '/../backend/config/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome_menu'];
    $link = $_POST['link_menu'];
    $ordem = intval($_POST['ordem_menu']);
    $tipo = $_POST['tipo_menu'];

    $stmt = $pdo->prepare("INSERT INTO menu (nome_menu, link_menu, ordem_menu, tipo_menu) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $link, $ordem, $tipo]);

    $msg = "Item criado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Item Menu</title>
    <link rel="stylesheet" href="../pages/css/criar_admin.css">
</head>
<body>

<div class="container-form">
    <h2>Criar Novo Item Menu</h2>

    <?php if ($msg): ?>
        <p class="msg-sucesso"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome do Menu</label>
        <input type="text" name="nome_menu" placeholder="Nome do menu" required>

        <label>Link</label>
        <input type="text" name="link_menu" placeholder="Link (ex: index.php)" required>

        <label>Ordem</label>
        <input type="number" name="ordem_menu" placeholder="Ordem" required>

        <label>Tipo</label>
        <select name="tipo_menu" required>
            <option value="publico">Público</option>
            <option value="admin">Admin</option>
            <option value="utilizador">Utilizador</option>
        </select>

        <button type="submit">Criar</button>
        <a href="gerir_menu.php" class="btn-voltar">← Voltar</a>
    </form>
</div>

</body>
</html>
