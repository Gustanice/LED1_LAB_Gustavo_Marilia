<?php
// ====== LIGAÇÃO À BASE DE DADOS ======
$host = "localhost";
$dbname = "LED1_LAB_Gustavo_Marilia";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na ligação: " . $e->getMessage());
}

// ====== BUSCAR ITENS DO MENU ======
$stmt = $pdo->prepare("SELECT nome_menu, link_menu FROM menu ORDER BY ordem_menu ASC");
$stmt->execute();
$menuItens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        nav {
            background-color: #222;
            padding: 10px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            color: #00c3ff;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <?php foreach ($menuItens as $item): ?>
            <li>
                <a href="<?= htmlspecialchars($item['link_menu']) ?>">
                    <?= htmlspecialchars($item['nome_menu']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

</body>
</html>
