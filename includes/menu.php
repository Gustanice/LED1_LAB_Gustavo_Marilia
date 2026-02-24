<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../backend/config/db.php';

// Buscar menu da base de dados
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
                        <a href="<?= htmlspecialchars($item['link_menu']) ?>">
                            <?= htmlspecialchars($item['nome_menu']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <?php if (isset($_SESSION['ID_admin'])): ?>
                    <li>
                        <a href="../pages/logout.php" class="btn-nav">
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="../pages/login.php" class="btn-nav">
                            Login
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>
