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
    // Em produção, seria melhor logar o erro em vez de dar die
    die("Erro na ligação: " . $e->getMessage());
}

// ====== BUSCAR ITENS DO MENU ======
$stmt = $pdo->prepare("SELECT nome_menu, link_menu FROM menu ORDER BY ordem_menu ASC");
$stmt->execute();
$menuItens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<header id="navbar">
    <div class="container nav-flex">
        <div class="logo">
            Led<span class="gradient-num">1</span>lab
        </div>
        <nav>
            <ul class="nav-links">
                <?php foreach ($menuItens as $item): ?>
                    <li>
                        <a href="<?= htmlspecialchars($item['link_menu']) ?>">
                            <?= htmlspecialchars($item['nome_menu']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>