<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_SESSION['ID_admin'])) { header("Location: login.php"); exit(); }

$stmt = $pdo->prepare("
    SELECT r.quantidade, r.data_requisicao, p.nome_produto, p.categoria 
    FROM requisicoes r
    JOIN produtos p ON r.id_produto = p.ID_produto
    WHERE r.id_admin = ?
    ORDER BY r.data_requisicao DESC
");
$stmt->execute([$_SESSION['ID_admin']]);
$pedidos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos - LED1/2</title>
    <link rel="stylesheet" href="css/lab.css">
    <style>
        .panel { margin-top: 120px; color: white; background: rgba(0,0,0,0.5); padding: 30px; border-radius: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { color: #FFC107; text-align: left; border-bottom: 2px solid #FFC107; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #333; }
    </style>
</head>
<body>
    <?php include '../includes/menu.php'; ?>
    <div class="container panel">
        <h2>📦 As Minhas Requisições</h2>
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Categoria</th>
                    <th>Qtd.</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pedidos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome_produto']) ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td><?= $p['quantidade'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['data_requisicao'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>