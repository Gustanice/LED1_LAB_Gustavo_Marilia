<?php
require_once __DIR__ . '/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

// Verifica se o ID do admin foi fornecido
if (!isset($_GET['ID_admin']) || empty($_GET['ID_admin'])) {
    die("ID do admin não fornecido.");
}

$id_admin = intval($_GET['ID_admin']);
// Buscar admin pelo ID
$stmt = $pdo->prepare("SELECT * FROM admin WHERE ID_admin = ?");
$stmt->execute([$id_admin]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Admin não encontrado.");
}

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['Nome'] ?? '';
    $email = $_POST['Email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar campos obrigatórios
    if (empty($nome) || empty($email)) {
        $erro = "Nome e email são obrigatórios.";
    } else {
        if (!empty($password)) {
            // Atualizar com nova password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admin SET Nome = ?, email = ?, password = ? WHERE ID_admin = ?");
            $stmt->execute([$nome, $email, $hashed_password, $id_admin]);
        } else {
            // Atualizar sem alterar password
            $stmt = $pdo->prepare("UPDATE admin SET Nome = ?, email = ? WHERE ID_admin = ?");
            $stmt->execute([$nome, $email, $id_admin]);
        }
        $mensagem = "Admin atualizado com sucesso!";

        // Recarregar dados do admin
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE ID_admin = ?");
        $stmt->execute([$id_admin]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Admin | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/css/editar_produtos.css">
</head>
<body>
<div class="topo">
    <h1>Editar Admin</h1>
    <a href="gerir_admin.php">← Voltar</a>
</div>

<?php if (!empty($erro)): ?>
    <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<?php if (!empty($mensagem)): ?>
    <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<form action="" method="post">
    <label>Nome:</label><br>
    <input type="text" name="Nome" value="<?= htmlspecialchars($admin['Nome']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="Email" value="<?= htmlspecialchars($admin['Email']) ?>" required><br><br>

    <label>Nova Password (opcional):</label><br>
    <input type="password" name="password" placeholder="Deixa em branco para não alterar"><br><br>

    <button type="submit">Atualizar Admin</button>
</form>
</body>
</html>
