<?php
require_once __DIR__ . '/../backend/config/db.php';
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Verificar se o email existe
    $stmt = $pdo->prepare("SELECT id_admin FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        // Aqui, num sistema real, enviarias um email com um TOKEN.
        // Como demonstração, vamos apenas simular que o pedido foi enviado ao administrador.
        $mensagem = "Um pedido de recuperação foi enviado para o administrador do laboratório. Por favor, aguarda contacto.";
    } else {
        $mensagem = "Email não encontrado no nosso sistema.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Password - LED 1/2</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="login-container">
        <form method="POST">
            <h2>Recuperar Acesso</h2>
            <p style="font-size: 0.9rem; color: #888; margin-bottom: 20px;">
                Insere o teu email @aeaav.pt para solicitar uma nova password.
            </p>

            <?php if ($mensagem): ?>
                <p style="color: #FFC107; margin-bottom: 15px;"><?= $mensagem ?></p>
            <?php endif; ?>

            <input type="email" name="email" placeholder="Teu email institucional" required>
            <button type="submit">Solicitar Nova Password</button>
            
            <p style="margin-top: 20px;">
                <a href="login.php" style="color: #FFC107; text-decoration: none;">Voltar ao Login</a>
            </p>
        </form>
    </main>
</body>
</html>