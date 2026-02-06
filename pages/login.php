<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../includes/menu.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['ID_admin'] = $admin['ID_admin'];
        $_SESSION['Nome'] = $admin['Nome'];
    

        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        $erro = "Email ou password inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
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
</body>
</html>
