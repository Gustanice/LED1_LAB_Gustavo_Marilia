<?php
require_once __DIR__ . '/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

// Verifica se o ID do produto foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do produto não fornecido.");
}

$id_produto = intval($_GET['id']);

// Buscar produto pelo ID
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE ID_produto = ?");
$stmt->execute([$id_produto]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_produto'] ?? '';
    $descricao = $_POST['descricao_produto'] ?? '';

    // Validar campos obrigatórios
    if (empty($nome) || empty($descricao)) {
        $erro = "Nome e descrição são obrigatórios.";
    } else {
        // Verificar se uma nova imagem foi enviada
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] === UPLOAD_ERR_OK) {
            $imagem_tmp = $_FILES['imagem_produto']['tmp_name'];
            $imagem_nome = basename($_FILES['imagem_produto']['name']);
            $pasta_destino = __DIR__ . '/../pages/img/' . $imagem_nome;

            // Mover imagem para a pasta destino
            if (move_uploaded_file($imagem_tmp, $pasta_destino)) {
                // Atualizar produto com nova imagem
                $stmt = $pdo->prepare("UPDATE produtos SET nome_produto = ?, descricao_produto = ?, imagem_produto = ? WHERE ID_produto = ?");
                $stmt->execute([$nome, $descricao, $imagem_nome, $id_produto]);
                $mensagem = "Produto atualizado com sucesso!";
            } else {
                $erro = "Erro ao enviar a imagem.";
            }
        } else {
            // Atualizar produto sem alterar imagem
            $stmt = $pdo->prepare("UPDATE produtos SET nome_produto = ?, descricao_produto = ? WHERE ID_produto = ?");
            $stmt->execute([$nome, $descricao, $id_produto]);
            $mensagem = "Produto atualizado com sucesso!";
        }

        // Recarregar dados do produto
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ID_produto = ?");
        $stmt->execute([$id_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Componente | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/css/editar_produtos.css">
</head>
<body>
<div class="topo">
    <h1>Editar Componente</h1>
    <a href="gerir_produtos.php">← Voltar</a>
</div>

<?php if (!empty($erro)): ?>
    <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<?php if (!empty($mensagem)): ?>
    <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label>Nome:</label><br>
    <input type="text" name="nome_produto" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao_produto" rows="5" required><?= htmlspecialchars($produto['descricao_produto']) ?></textarea><br><br>

    <label>Imagem atual:</label><br>
    <?php if ($produto['imagem_produto']): ?>
        <img src="../pages/img/<?= htmlspecialchars($produto['imagem_produto']) ?>" width="150"><br>
    <?php else: ?>
        —
    <?php endif; ?><br><br>

    <label>Nova Imagem (opcional):</label><br>
    <input type="file" name="imagem_produto" accept="image/*"><br><br>

    <button type="submit">Atualizar Componente</button>
</form>
</body>
</html>
