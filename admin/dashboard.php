<?php
session_start();
if (!isset($_SESSION['ID_admin']) || strtolower($_SESSION['tipo']) !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}
require_once __DIR__ . '/../backend/config/db.php';

// Estatísticas Rápidas
$total_prod = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$stock_baixo = $pdo->query("SELECT COUNT(*) FROM produtos WHERE quantidade < 5")->fetchColumn();
$total_req = $pdo->query("SELECT COUNT(*) FROM requisicoes")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | LED1 Lab</title>
    <link rel="stylesheet" href="../pages/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
<div class="dashboard">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="../pages/index.php" class="btn-site"><i class="fas fa-eye"></i> Ver Site</a>
            <h1>Painel Administrativo</h1>
        </div>
        <div class="user-info">
            <span>Olá, <?= htmlspecialchars($_SESSION['Nome']); ?></span>
            <a href="logout.php" class="logout">Sair</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card"><h3><?= $total_prod ?></h3><p>Produtos</p></div>
        <div class="stat-card alert"><h3><?= $stock_baixo ?></h3><p>Stock Crítico</p></div>
        <div class="stat-card"><h3><?= $total_req ?></h3><p>Requisições</p></div>
    </div>

    <div class="cards">
        <div class="card">
            <i class="fas fa-box"></i>
            <h3>Componentes</h3>
            <a href="gerir_produtos.php" class="btn-manage">Gerir Stock</a>
        </div>
        <div class="card">
            <i class="fas fa-exchange-alt"></i>
            <h3>Requisições</h3>
            <a href="gerir_requisicoes.php" class="btn-manage">Ver Pedidos</a>
        </div>
        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Utilizadores</h3>
            <a href="gerir_admin.php" class="btn-manage">Gerir Contas</a>
        </div>
        <div class="card">
            <i class="fas fa-list"></i>
            <h3>Menu</h3>
            <a href="gerir_menu.php" class="btn-manage">Editar Menu</a>
        </div>
    </div>
</div>
</body>
</html>