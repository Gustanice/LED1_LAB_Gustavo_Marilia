<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../backend/config/db.php';

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

<header id="navbar">
    <div class="container nav-flex">
        <div class="logo">
                <img src="pages/img/logo_.png" alt="Logo LED 1/2" class="nav-logo-img">
        </div>
        <nav>
            <ul class="nav-links">
                <?php foreach ($menuItens as $item): ?>
                    <li>
                        <a href="<?= htmlspecialchars($item['link_menu']) ?>" 
                           class="<?= (trim($item['nome_menu']) == 'Requisição') ? 'btn-nav' : '' ?>">
                            <?= htmlspecialchars($item['nome_menu']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>

