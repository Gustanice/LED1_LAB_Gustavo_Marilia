<?php
require_once __DIR__ . '/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

// Verifica se o ID do produto foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do produto não fornecido.");
}

$id_produto = intval($_GET['id']);

// Buscar produto pelo ID para obter a imagem
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE ID_produto = ?");
$stmt->execute([$id_produto]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

// Apagar imagem do servidor, se existir
if (!empty($produto['imagem_produto'])) {
    $caminho_imagem = __DIR__ . '/../pages/img/' . $produto['imagem_produto'];
    if (file_exists($caminho_imagem)) {
        unlink($caminho_imagem);
    }
}

// Apagar produto da base de dados
$stmt = $pdo->prepare("DELETE FROM produtos WHERE ID_produto = ?");
$stmt->execute([$id_produto]);

// Redirecionar de volta para gerir_produtos.php
header("Location: gerir_produtos.php");
exit;
?>
