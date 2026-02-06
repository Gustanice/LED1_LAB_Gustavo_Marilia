<?php
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../admin/protect.php';

if (!isset($_SESSION['ID_admin'])) {
    header("Location: /./pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | LED1 Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/css/admin_dashboard.css">
</head>
<body>

<div class="dashboard">

    <div class="top-bar">
        <h1> Bem-vindo</h1>
        <a href="logout.php" class="logout">Sair</a>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Componentes</h3>
            <p>Gerir Componentes </p>
            <a href="gerir_produtos.php" class="logout">Gerir Componentes</a>
        </div>

        <div class="card">
            <h3>Menu</h3>
            <p>Editar menu do site</p>
        </div>

        <div class="card">
            <h3>Utilizadores</h3>
            <p>Gerir contas</p>
              <a href="gerir_admin.php" class="logout">Gerir Contas</a>
        </div>
    </div>

</div>

</body>
</html>
