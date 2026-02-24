<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../backend/config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$produto = null;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE ID_produto = :id");
        $stmt->execute([':id' => $id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro na base de dados: " . $e->getMessage());
    }
}

if (!$produto) {
    header("Location: lab.php");
    exit();
}

$stock = $produto['quantidade'];
$img_path = "img/" . basename($produto['imagem_produto']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED1/2 - <?= htmlspecialchars($produto['nome_produto']); ?></title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/lab.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include '../includes/menu.php'; ?>

    <div class="container page-detalhes" style="margin-top: 100px;">
        <a href="lab.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar ao Laboratório
        </a>
        
        <div class="detalhes-wrapper">
            <div class="detalhes-img">
                <img src="<?= $img_path; ?>" alt="<?= htmlspecialchars($produto['nome_produto']); ?>">
            </div>
            
            <div class="detalhes-info">
                <span class="category-tag"><?= htmlspecialchars($produto['categoria']); ?></span>
                <h1><?= htmlspecialchars($produto['nome_produto']); ?></h1>
                
                <p class="descricao-completa">
                    <?= nl2br(htmlspecialchars($produto['descricao_produto'])); ?>
                </p>

                <div class="requisicao-box">
                    <h3>Solicitar Material</h3>
                    
                    <form id="form-requisicao">
                        <input type="hidden" name="id_produto" value="<?= $produto['ID_produto']; ?>">
                        
                        <div class="m-action">
                            <label for="qtd">Quantidade:</label>
                            <input type="number" name="qtd" id="qtd" value="1" min="1" max="<?= $stock; ?>" 
                                   <?= ($stock <= 0) ? 'disabled' : ''; ?>>
                            
                            <button type="submit" class="btn-nav" <?= ($stock <= 0) ? 'disabled' : ''; ?>>
                                <?= (isset($_SESSION['ID_admin'])) ? ($stock > 0 ? 'Confirmar Requisição' : 'Indisponível') : 'Fazer Login para Requisitar'; ?>
                            </button>
                        </div>
                        
                        <p class="stock-info" style="margin-top: 10px;">
                            <?php if($stock > 0): ?>
                                ● Atualmente temos <strong><?= $stock; ?></strong> unidades em stock.
                            <?php else: ?>
                                <span style="color: #f44336;">● Este material está temporariamente esgotado.</span>
                            <?php endif; ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.querySelector('#form-requisicao').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // AJUSTE: Se já estás na pasta 'pages', chama o ficheiro diretamente
        fetch('processa_requisicao.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro na rede');
            return response.json();
        })
        .then(data => {
            if (data.status === 'unauthorized') {
                Swal.fire({
                    title: 'Acesso Restrito',
                    text: data.message,
                    icon: 'warning',
                    confirmButtonColor: '#FFC107',
                    background: '#1a1a1a',
                    color: '#fff'
                }).then(() => {
                    // AJUSTE: Redireciona para login.php na mesma pasta
                    window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.pathname + window.location.search);
                });

            } else if (data.status === 'success') {
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#FFC107',
                    background: '#1a1a1a',
                    color: '#fff'
                }).then(() => {
                    location.reload();
                });

            } else {
                Swal.fire({
                    title: 'Atenção',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#f44336',
                    background: '#1a1a1a',
                    color: '#fff'
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
                title: 'Erro de Conexão',
                text: 'Certifica-te que o processa_requisicao.php existe nesta pasta.',
                icon: 'error',
                background: '#1a1a1a',
                color: '#fff'
            });
        });
    });
    </script>

    <?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>