<?php
require_once __DIR__ . '/protect.php';
require_once __DIR__ . '/../backend/config/db.php';

$stmt = $pdo->query("SELECT * FROM produtos ORDER BY ID_produto DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Componentes | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/css/gerir_produtos.css">
</head>
<body>

<div class="topo">
    <h1> Gerir Componentes</h1>
    <a href="criar_produtos.php" class="btn btn-criar">+ Criar Produto</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($produtos) === 0): ?>
            <tr>
                <td colspan="5">Nenhum componente encontrado.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto['ID_produto'] ?></td>
                <td>
                    <?php if ($produto['imagem_produto']): ?>
                       <img src="../pages/img/<?= htmlspecialchars($produto['imagem_produto']) ?>"9>

                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                <td><?= htmlspecialchars($produto['descricao_produto']) ?></td>
                <td class="acoes">
                    <a class="btn-editar" href="editar_produtos.php?id=<?= $produto['ID_produto'] ?>">Editar</a>
                    <a class="btn-apagar"
                       href="apagar_produtos.php?id=<?= $produto['ID_produto'] ?>"
                       onclick="return confirm('Tens a certeza que queres apagar este produto?')">
                       Apagar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
