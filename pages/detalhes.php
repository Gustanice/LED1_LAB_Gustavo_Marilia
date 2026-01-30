<?php
// 1. Configuração da Base de Dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "led1_lab_gustavo_marilia"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// 2. Capturar o ID do produto pela URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Procurar o produto específico
if ($id > 0) {
    $sql = "SELECT * FROM produtos WHERE ID_produto = $id";
    $result = $conn->query($sql);
    $produto = $result->fetch_assoc();
}

// 4. Se o produto não existir, volta para o laboratório
if (!$produto) {
    header("Location: lab.php");
    exit();
}

// Preparar variáveis de exibição
$stock = $produto['quantidade'];
$img_path = "img/" . basename($produto['imagem_produto']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome_produto']); ?> | LeD1 Lab</title>
    
    <link rel="stylesheet" href="css/lab.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include '../includes/menu.php'; ?>

    <div class="container page-detalhes">
        <a href="lab.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> ← Voltar ao Laboratório
        </a>
        
        <div class="detalhes-wrapper">
            <div class="detalhes-img">
                <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($produto['nome_produto']); ?>">
            </div>
            
            <div class="detalhes-info">
                <span class="category-tag"><?php echo $produto['categoria']; ?></span>
                <h1><?php echo htmlspecialchars($produto['nome_produto']); ?></h1>
                
                <p class="descricao-completa">
                    <?php echo nl2br(htmlspecialchars($produto['descricao_produto'])); ?>
                </p>

                <div class="requisicao-box">
                    <h3>Solicitar Material</h3>
                    
                    <form action="processa_requisicao.php" method="POST">
                        <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
                        
                        <div class="m-action">
                            <label for="qtd">Quantidade:</label>
                            <input type="number" name="qtd" id="qtd" value="1" min="1" max="<?php echo $stock; ?>" 
                                   <?php echo ($stock <= 0) ? 'disabled' : ''; ?>>
                            
                            <button type="submit" class="btn-request" <?php echo ($stock <= 0) ? 'disabled' : ''; ?>>
                                <?php echo ($stock > 0) ? 'Confirmar Requisição' : 'Indisponível'; ?>
                            </button>
                        </div>
                        
                        <p class="stock-info">
                            <?php if($stock > 0): ?>
                                ● Atualmente temos <strong><?php echo $stock; ?></strong> unidades em stock.
                            <?php else: ?>
                                <span style="color: #f44336;">● Este material está temporariamente esgotado.</span>
                            <?php endif; ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>