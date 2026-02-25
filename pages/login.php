<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Validar domínio
    if (!preg_match('/@aeaav\.pt$/', $email)) {
        $erro = "Só é permitido login com email institucional (@aeaav.pt).";
    } else {
        // 2. Procurar utilizador
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Validar password
        if ($admin && password_verify($password, $admin['password'])) {
            // Definir variáveis de sessão
            $_SESSION['ID_admin'] = $admin['ID_admin'];
            $_SESSION['Nome'] = $admin['nome'];
            $_SESSION['tipo'] = strtolower($admin['tipo']);
            $_SESSION['primeiro_login'] = $admin['primeiro_login'];

            // 4. Verificação de Primeiro Login (Obrigatório para todos)
            if ($admin['primeiro_login'] == 1) {
                header("Location: alterar_password.php");
                exit;
            }

            // 5. Redirecionamento baseado no tipo de conta
            if ($_SESSION['tipo'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;

        } else {
            $erro = "Email ou password inválidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login | LED1/2 Lab</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/menu.php'; ?>

<main class="login-container">
    <form method="POST" class="login-form">
        <h2 align="center">Login</h2>
        <p style="text-align: center; color: #888; font-size: 0.9rem; margin-bottom: 20px;">Utiliza a tua conta @aeaav.pt</p>

        <?php if ($erro): ?>
            <div class="error-msg" style="color: #ff4444; background: rgba(255,68,68,0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem; border: 1px solid #ff4444;">
                <i class="fas fa-exclamation-circle"></i> <?= $erro ?>
            </div>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email Institucional" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Entrar</button>
        
        <div style="margin-top: 15px; text-align: center;">
            <a href="recuperar_pass.php" style="color: #FFC107; text-decoration: none; font-size: 0.85rem;">Esqueceste-te da password?</a>
        </div>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>