<?php
require_once __DIR__ . '/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao_produto'];

if (!empty($_FILES['imagem_produto']['name'])) {

    $ext = strtolower(pathinfo($_FILES['imagem_produto']['name'], PATHINFO_EXTENSION));

    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidos)) {
        die("❌ Apenas imagens JPG, PNG ou WEBP são permitidas.");
    }

   
    if ($_FILES['imagem_produto']['size'] > 2 * 1024 * 1024) {
        die("❌ A imagem não pode ter mais de 2MB.");
    }

    // Nome único da imagem
    $nomeImagem = uniqid() . "." . $ext;
    $destino = __DIR__ . "/../pages/img/" . $nomeImagem;

    move_uploaded_file($_FILES['imagem_produto']['tmp_name'], $destino);

} else {
    $nomeImagem = null;
}


    $stmt = $pdo->prepare("
        INSERT INTO produtos (nome_produto, descricao_produto, imagem_produto)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$nome, $descricao, $nomeImagem]);

    $msg = "✅ Produto criado com sucesso!";
    
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<div class="box">
    <h1>➕ Criar Produto</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Nome do Produto</label>
        <input type="text" name="nome_produto" required>

        <label>Descrição</label>
        <textarea name="descricao_produto" rows="4" required></textarea>

        <label>Imagem</label>
        <input type="file" name="imagem_produto" accept="image/*">

        <button type="submit">Criar Produto</button>
    </form>

    <a href="gerir_produtos.php">⬅ Voltar</a>
</div>

</body>
</html>
