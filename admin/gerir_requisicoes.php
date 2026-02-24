<?php
session_start();
if (!isset($_SESSION['ID_admin']) || strtolower($_SESSION['tipo']) !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}
require_once __DIR__ . '/../backend/config/db.php';

// --- LÓGICA DE DEVOLUÇÃO ---
if (isset($_GET['devolver']) && isset($_GET['prod']) && isset($_GET['qtd'])) {
    $id_req = intval($_GET['devolver']);
    $id_prod = intval($_GET['prod']);
    $qtd = intval($_GET['qtd']);

    try {
        $pdo->beginTransaction();

        // 1. Devolver a quantidade ao stock dos produtos
        $updateStock = $pdo->prepare("UPDATE produtos SET quantidade = quantidade + ? WHERE ID_produto = ?");
        $updateStock->execute([$qtd, $id_prod]);

        // 2. Remover a requisição (ou podes alterar o status para 'devolvido' se tiveres essa coluna)
        $deleteReq = $pdo->prepare("DELETE FROM requisicoes WHERE ID_requisicao = ?");
        $deleteReq->execute([$id_req]);

        $pdo->commit();
        header("Location: gerir_requisicoes.php?msg=sucesso");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $erro = "Erro ao devolver: " . $e->getMessage();
    }
}

// --- LÓGICA DE PESQUISA ---
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT r.*, p.nome_produto, a.Nome as nome_utilizador, a.email 
          FROM requisicoes r
          JOIN produtos p ON r.id_produto = p.ID_produto
          JOIN admin a ON r.id_admin = a.ID_admin
          WHERE p.nome_produto LIKE :search OR a.Nome LIKE :search OR a.email LIKE :search
          ORDER BY r.data_requisicao DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([':search' => "%$search%"]);
$requisicoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Requisições | Admin</title>
    <link rel="stylesheet" href="../pages/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .search-container { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-input { 
            flex: 1; padding: 12px; border-radius: 5px; border: 1px solid #333; 
            background: #1f2833; color: white; 
        }
        .btn-search { background: #FFC107; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        
        .table-container { background: #1f2833; padding: 20px; border-radius: 10px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; color: white; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #FFC107; color: #FFC107; }
        td { padding: 15px; border-bottom: 1px solid #333; }
        
        .btn-devolver { 
            background: #4caf50; color: white; padding: 8px 12px; border-radius: 4px; 
            text-decoration: none; font-size: 0.85rem; font-weight: bold;
        }
        .btn-devolver:hover { background: #45a049; }
        .msg-sucesso { background: #4caf50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="dashboard.php" class="btn-site"><i class="fas fa-arrow-left"></i> Voltar</a>
            <h1>Gerir Requisições</h1>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="msg-sucesso">Item devolvido com sucesso e stock atualizado!</div>
    <?php endif; ?>

    <form class="search-container" method="GET">
        <input type="text" name="search" class="search-input" placeholder="Pesquisar por aluno, email ou componente..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
    </form>

    <div class="table-container">
        <?php if (count($requisicoes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Componente</th>
                        <th>Qtd.</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requisicoes as $r): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($r['nome_utilizador']) ?></strong><br>
                                <small style="color: #888;"><?= htmlspecialchars($r['email']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($r['nome_produto']) ?></td>
                            <td><?= $r['quantidade'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($r['data_requisicao'])) ?></td>
                            <td>
                                <a href="?devolver=<?= $r['ID_requisicao'] ?>&prod=<?= $r['id_produto'] ?>&qtd=<?= $r['quantidade'] ?>" 
                                   class="btn-devolver" 
                                   onclick="return confirm('Confirmar que o material foi devolvido ao laboratório?')">
                                   <i class="fas fa-undo"></i> Marcar Devolvido
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: #888; padding: 20px;">Nenhuma requisição encontrada.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>