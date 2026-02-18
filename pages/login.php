<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../includes/menu.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1️⃣ validar domínio
    if (!preg_match('/@aeaav\.pt$/', $email)) {
        $erro = "Só é permitido login com email institucional (@aeaav.pt).";
    } else {
        // 2️⃣ procurar utilizador
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3️⃣ validar password
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['ID_admin'] = $admin['ID_admin'];
            $_SESSION['Nome'] = $admin['nome'];
            $_SESSION['tipo'] = $admin['tipo'];
            $_SESSION['primeiro_login'] = $admin['primeiro_login'];

           if ($admin['tipo'] === 'admin') {
    header("Location: ../admin/dashboard.php");
    exit;
} else {
    header("Location: ../pages/index.php");
    exit;
}

        } else {
            $erro = "Email ou password inválidos.";
        }
    }
}
?>

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
       <title>LED1/2 - Eletrônica e Inovação</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">

</head>
<body>



<?php if ($erro): ?>
<p style="color:red"><?= $erro ?></p>
<?php endif; ?>

<main class="login-container">
<form method="POST">
    <h2 align="center">Login</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Entrar</button>
</form>


</main>
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
