<?php
session_start();
if (!isset($_SESSION['ID_admin']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}

require_once __DIR__ . '/../backend/config/db.php';

$msg_sucesso = "";
$msg_erro = "";

// Buscar todos os itens do menu
$stmt = $pdo->query("SELECT * FROM menu ORDER BY ordem_menu ASC");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Processar apagamento
if (isset($_GET['delete'])) {
    $id_menu = intval($_GET['delete']);

    $stmt = $pdo->prepare("DELETE FROM menu WHERE ID_menu = ?");
    $stmt->execute([$id_menu]);

    $msg_sucesso = "Item do menu apagado com sucesso!";

    // Recarregar lista
    $stmt = $pdo->query("SELECT * FROM menu ORDER BY ordem_menu ASC");
    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Menu</title>
    <link rel="stylesheet" href="../pages/css/gerir_admin.css">
</head>
<body>

<h2>Gerir Menu</h2>
<a href="criar_menu.php">+ Criar Novo Item</a>

<?php if (!empty($msg_sucesso)): ?>
    <p style="color: green;"><?= htmlspecialchars($msg_sucesso) ?></p>
<?php endif; ?>

<?php if (!empty($msg_erro)): ?>
    <p style="color: red;"><?= htmlspecialchars($msg_erro) ?></p>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Link</th>
            <th>Ordem</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($menus) === 0): ?>
            <tr>
                <td colspan="6">Nenhum item encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($menus as $menu): ?>
                <tr>
                    <td><?= htmlspecialchars($menu['ID_menu']) ?></td>
                    <td><?= htmlspecialchars($menu['nome_menu']) ?></td>
                    <td><?= htmlspecialchars($menu['link_menu']) ?></td>
                    <td><?= htmlspecialchars($menu['ordem_menu']) ?></td>
                    <td><?= htmlspecialchars($menu['tipo_menu']) ?></td>
                    <td>
                        <a href="editar_menu.php?ID_menu=<?= $menu['ID_menu'] ?>">Editar</a>
                        <a href="?delete=<?= $menu['ID_menu'] ?>" 
                           onclick="return confirm('Tens a certeza que queres apagar este item?')">Apagar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
