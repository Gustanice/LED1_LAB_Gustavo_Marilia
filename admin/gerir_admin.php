<?php
require_once __DIR__ . '/../admin/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

// Buscar todos os admins
$stmt = $pdo->query("SELECT * FROM admin ORDER BY ID_admin DESC");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Processar apagamento de admin, se houver ?delete=ID
if (isset($_GET['delete'])) {
    $id_admin = intval($_GET['delete']);

    // Evitar apagar o próprio admin logado
    if ($id_admin == $_SESSION['ID_admin']) {
        $msg_erro = "Não podes apagar a tua própria conta!";
    } else {
        $stmt = $pdo->prepare("DELETE FROM admin WHERE ID_admin = ?");
        $stmt->execute([$id_admin]);
        $msg_sucesso = "Admin apagado com sucesso!";
        
        // Recarregar lista de admins
        $stmt = $pdo->query("SELECT * FROM admin ORDER BY ID_admin DESC");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Admins</title>
    <link rel="stylesheet" href="../pages/css/gerir_admin.css">
</head>
<body>

<h2>Gerir Admins</h2>
<a href="criar_admin.php">+ Criar Novo Admin</a>

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
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($admins) === 0): ?>
            <tr>
                <td colspan="4">Nenhum admin encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['ID_admin']) ?></td>
                    <td><?= htmlspecialchars($admin['Nome']) ?></td>
                    <td><?= htmlspecialchars($admin['Email']) ?></td>
                    <td>
                        <?php if ($admin['ID_admin'] != $_SESSION['ID_admin']): ?>
                            <a href="?delete=<?= $admin['ID_admin'] ?>" onclick="return confirm('Tens a certeza que queres apagar este admin?')">Apagar</a>
                        <?php else: ?>
                            — (tu)
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
