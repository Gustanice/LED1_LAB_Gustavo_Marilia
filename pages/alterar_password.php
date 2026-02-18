<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_SESSION['ID_admin'])) {
    header("Location: login.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nova = $_POST['nova_password'];
    $confirmar = $_POST['confirmar_password'];

    if ($nova !== $confirmar) {
        $msg = "❌ As passwords não coincidem.";
    } elseif (strlen($nova) < 6) {
        $msg = "❌ A password deve ter pelo menos 6 caracteres.";
    } else {
        $hash = password_hash($nova, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "UPDATE admin 
             SET password = ?, primeiro_login = 0 
             WHERE ID_admin = ?"
        );
        $stmt->execute([$hash, $_SESSION['ID_admin']]);

        // depois de mudar, segue para o dashboard
        header("Location: ../admin/dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Alterar Password</title>
</head>
<body>

<h2>Alterar Password</h2>
<p>Por segurança, é obrigatório alterar a password no primeiro login.</p>

<?php if ($msg): ?>
<p style="color:red"><?= $msg ?></p>
<?php endif; ?>

<form method="POST">
    <input type="password" name="nova_password" placeholder="Nova password" required><br><br>
    <input type="password" name="confirmar_password" placeholder="Confirmar password" required><br><br>
    <button type="submit">Guardar</button>
</form>

</body>
</html>
