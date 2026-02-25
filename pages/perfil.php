<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../backend/config/db.php';

// Proteção: Só entra quem está logado
if (!isset($_SESSION['ID_admin'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['ID_admin'];
$nome_user = $_SESSION['Nome'];

try {
    // Contagem de pedidos para as estatísticas
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM requisicoes WHERE id_admin = ?");
    $stmt_count->execute([$id_user]);
    $total_pedidos = $stmt_count->fetchColumn();
} catch (PDOException $e) {
    $total_pedidos = 0;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minha Conta | LED1 Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Ajuste específico para garantir que o menu.php não choque com o layout */
        body { padding-top: 80px; } 
    </style>
</head>
<body>



<div class="dashboard">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="lab.php" class="btn-site"><i class="fas fa-microchip"></i> Voltar ao Lab</a>
            <h1>Área do Utilizador</h1>
        </div>
        <div class="user-info">
            <span>Olá, <strong><?= htmlspecialchars($nome_user); ?></strong></span>
            <a href="logout.php" class="logout">Sair</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <h3><?= $total_pedidos ?></h3>
            <p>Materiais Requisitados</p>
        </div>
        <div class="stat-card">
            <h3>Ativo</h3>
            <p>Estado da Conta</p>
        </div>
    </div>

    <div class="cards">
        
        <div class="card">
            <i class="fas fa-box-open"></i>
            <h3>Meus Pedidos</h3>
            <p>Consulta a lista de todos os materiais que tens em tua posse ou já devolveste.</p>
            <a href="minhas_requisicoes.php" class="btn-manage">Ver Histórico</a>
        </div>

        <div class="card">
            <i class="fas fa-key"></i>
            <h3>Segurança</h3>
            <p>Precisas de mudar a tua senha? Mantém a tua conta segura alterando-a regularmente.</p>
            <a href="alterar_password.php" class="btn-manage">Alterar Senha</a>
        </div>

        <div class="card">
            <i class="fas fa-comment-dots"></i>
            <h3>Suporte</h3>
            <p>Tens dúvidas sobre algum material ou problema com a tua requisição?</p>
            <a href="mailto:admin@aeaav.pt" class="btn-manage">Contactar Admin</a>
        </div>

    </div>
</div>

</body>
</html>