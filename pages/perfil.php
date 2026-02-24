<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../backend/config/db.php';

// Proteção: Só entra quem está logado
if (!isset($_SESSION['ID_admin'])) {
    header("Location: pages/login.php");
    exit();
}

$id_user = $_SESSION['ID_admin'];

try {
    // Consulta para buscar as requisições do utilizador logado
    $sql = "SELECT r.*, p.nome_produto, p.categoria 
            FROM requisicoes r 
            JOIN produtos p ON r.id_produto = p.ID_produto 
            WHERE r.id_admin = :id_user 
            ORDER BY r.data_requisicao DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_user' => $id_user]);
    $minhas_requisicoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $erro = "Erro ao carregar requisições: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Meu Painel - LED 1/2</title>
    <link rel="stylesheet" href="css/lab.css"> <style>
        .panel-container { margin-top: 120px; padding: 20px; color: white; }
        .table-requisicoes { width: 100%; border-collapse: collapse; margin-top: 20px; background: rgba(255,255,255,0.05); }
        .table-requisicoes th, .table-requisicoes td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
        .table-requisicoes th { color: #FFC107; text-transform: uppercase; font-size: 12px; }
        .status-badge { padding: 5px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-pendente { background: #ff9800; color: black; }
    </style>
</head>
<body>
    <?php include '../includes/menu.php'; ?>

    <div class="container panel-container">
        <h1>Olá, <?= htmlspecialchars($_SESSION['Nome']) ?>! 👋</h1>
        <p>Aqui podes consultar o histórico dos teus pedidos ao laboratório.</p>

        <?php if (empty($minhas_requisicoes)): ?>
            <p style="margin-top:30px; color: #888;">Ainda não realizaste nenhuma requisição.</p>
        <?php else: ?>
            <table class="table-requisicoes">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Categoria</th>
                        <th>Qtd.</th>
                        <th>Data</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($minhas_requisicoes as $req): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($req['nome_produto']) ?></strong></td>
                        <td><?= htmlspecialchars($req['categoria']) ?></td>
                        <td><?= $req['quantidade'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($req['data_requisicao'])) ?></td>
                        <td><span class="status-badge status-pendente">Entregue / Em uso</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>