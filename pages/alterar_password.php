<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';

// 1. Verificar se está logado
if (!isset($_SESSION['ID_admin'])) {
    header("Location: login.php");
    exit;
}

$msg = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nova = $_POST['nova_password'];
    $confirmar = $_POST['confirmar_password'];

    if ($nova !== $confirmar) {
        $msg = "As passwords não coincidem.";
        $status = "error";
    } elseif (strlen($nova) < 6) {
        $msg = "A password deve ter pelo menos 6 caracteres.";
        $status = "error";
    } else {
        $hash = password_hash($nova, PASSWORD_DEFAULT);

        try {
            // Atualiza a pass e marca que já não é o primeiro login
            $stmt = $pdo->prepare("UPDATE admin SET password = ?, primeiro_login = 0 WHERE ID_admin = ?");
            $stmt->execute([$hash, $_SESSION['ID_admin']]);

            // Atualiza a sessão para o redirecionamento global saber que já mudou
            $_SESSION['primeiro_login'] = 0;

            header("Location: perfil.php?msg=password_alterada");
            exit;
        } catch (PDOException $e) {
            $msg = "Erro ao atualizar base de dados.";
            $status = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Segurança | LED1 Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .auth-container {
            max-width: 450px;
            margin: 100px auto;
            background: var(--bg-card);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            text-align: center;
        }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; color: var(--primary-yellow); margin-bottom: 8px; font-size: 0.9rem; }
        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #333;
            background: #0b0c10;
            color: white;
            outline: none;
        }
        .form-group input:focus { border-color: var(--primary-yellow); }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-error { background: rgba(255, 68, 68, 0.2); color: #ff4444; border: 1px solid #ff4444; }
    </style>
</head>
<body>

    <div class="auth-container">
        <i class="fas fa-shield-alt fa-3x" style="color: var(--primary-yellow); margin-bottom: 20px;"></i>
        <h2>Alterar Password</h2>
        <p style="color: #888; margin-bottom: 30px; font-size: 0.9rem;">
            Por questões de segurança, deves definir uma nova password para continuar.
        </p>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $status ?>"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nova Password</label>
                <input type="password" name="nova_password" placeholder="Mínimo 6 caracteres" required>
            </div>

            <div class="form-group">
                <label>Confirmar Nova Password</label>
                <input type="password" name="confirmar_password" placeholder="Repita a password" required>
            </div>

            <button type="submit" class="btn-manage" style="width: 100%; margin-top: 10px;">
                Atualizar Password e Entrar
            </button>
        </form>

        <a href="perfil.php" style="display:block; margin-top: 20px; color: #555; text-decoration: none; font-size: 0.8rem;">
            Cancelar e Voltar
        </a>
    </div>

</body>
</html>