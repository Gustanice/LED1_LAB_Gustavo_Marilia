<?php
session_start();
if (!isset($_SESSION['ID_admin']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}

require_once __DIR__ . '/../backend/config/db.php';

$id = intval($_GET['ID_menu']);
$stmt = $pdo->prepare("SELECT * FROM menu WHERE ID_menu = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$menu) {
    die("Item não encontrado.");
}

$msg_sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome_menu'];
    $link = $_POST['link_menu'];
    $ordem = intval($_POST['ordem_menu']);
    $tipo = $_POST['tipo_menu'];

    $stmt = $pdo->prepare("UPDATE menu SET nome_menu=?, link_menu=?, ordem_menu=?, tipo_menu=? WHERE ID_menu=?");
    $stmt->execute([$nome, $link, $ordem, $tipo, $id]);

    $msg_sucesso = "Item atualizado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Item Menu</title>
    <link rel="stylesheet" href="../pages/css/criar_admin.css">
</head>
<body>

<div class="container-form">
    <h2>Editar Item Menu</h2>

    <?php if ($msg_sucesso): ?>
        <p class="msg-sucesso"><?= htmlspecialchars($msg_sucesso) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome do Menu</label>
        <input type="text" name="nome_menu" value="<?= htmlspecialchars($menu['nome_menu']) ?>" required>

        <label>Link</label>
        <input type="text" name="link_menu" value="<?= htmlspecialchars($menu['link_menu']) ?>" required>

        <label>Ordem</label>
        <input type="number" name="ordem_menu" value="<?= htmlspecialchars($menu['ordem_menu']) ?>" required>

        <label>Tipo</label>
        <select name="tipo_menu" required>
            <option value="publico" <?= $menu['tipo_menu']=='publico' ? 'selected' : '' ?>>Público</option>
            <option value="admin" <?= $menu['tipo_menu']=='admin' ? 'selected' : '' ?>>Admin</option>
            <option value="utilizador" <?= $menu['tipo_menu']=='utilizador' ? 'selected' : '' ?>>Utilizador</option>
        </select>

        <button type="submit">Guardar</button>
        <a href="gerir_menu.php" class="btn-voltar">← Voltar</a>
    </form>
</div>

</body>
</html>
        