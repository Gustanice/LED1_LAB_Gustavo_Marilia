<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_SESSION['ID_admin'])) { 
    header("Location: login.php"); 
    exit(); 
}

$id_user = $_SESSION['ID_admin'];

// Consulta para buscar os pedidos do utilizador
$stmt = $pdo->prepare("
    SELECT r.quantidade, r.data_requisicao, p.nome_produto, p.categoria 
    FROM requisicoes r
    JOIN produtos p ON r.id_produto = p.ID_produto
    WHERE r.id_admin = ?
    ORDER BY r.data_requisicao DESC
");
$stmt->execute([$id_user]);
$pedidos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos | LED1 Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos específicos para a tabela dentro do layout dark */
        .table-container {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-white);
        }

        th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid var(--primary-yellow);
            color: var(--primary-yellow);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.95rem;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .status-badge {
            background: rgba(63, 81, 181, 0.2);
            color: var(--primary-blue);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--primary-blue);
        }

        body { padding-top: 80px; }
    </style>
</head>
<body>



    <div class="dashboard">
        <div class="top-bar">
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="perfil.php" class="btn-site"><i class="fas fa-arrow-left"></i> Voltar</a>
                <h1>As Minhas Requisições</h1>
            </div>
            <div class="user-info">
                <span class="status-badge"><i class="fas fa-history"></i> Histórico</span>
            </div>
        </div>

        <div class="table-container">
            <?php if (count($pedidos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-microchip"></i> Material</th>
                            <th><i class="fas fa-tag"></i> Categoria</th>
                            <th><i class="fas fa-sort-numeric-up"></i> Qtd.</th>
                            <th><i class="fas fa-calendar-alt"></i> Data de Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pedidos as $p): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($p['nome_produto']) ?></strong></td>
                            <td><?= htmlspecialchars($p['categoria']) ?></td>
                            <td><?= $p['quantidade'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['data_requisicao'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-inbox fa-3x" style="color: #333; margin-bottom: 20px;"></i>
                    <p style="color: #888;">Ainda não realizaste nenhuma requisição.</p>
                    <a href="lab.php" class="btn-manage" style="display: inline-block; width: auto; margin-top: 20px;">Explorar Laboratório</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>