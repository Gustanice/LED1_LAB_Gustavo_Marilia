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

$stmt = $pdo->prepare("SELECT nome_menu, link_menu FROM menu ORDER BY ordem_menu ASC");
$stmt->execute();
$menuItens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<header id="navbar">
    <div class="container nav-flex">
        <div class="logo">
            <a href="index.php" style="text-decoration: none;">
                <strong class="footer-logo">LED<span class="gradient-num">1/2</span></strong>
            </a>
        </div>

        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <nav class="nav-container">
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

<style>
    /* --- Header e Navegação Base --- */
#navbar {
    background: rgba(11, 12, 16, 0.98);
    padding: 15px 0;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1001;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-family: 'Poppins', sans-serif;
}

.nav-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* --- Logo Estilizada --- */
.logo, .footer-logo {
    font-size: 1.8rem;
    font-weight: 900;
    color: #fff;
    letter-spacing: -1px;
    text-decoration: none;
}

.gradient-num {
    display: inline-block;
    background: linear-gradient(180deg, #FFC107 0%, #3F51B5 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 2.2rem;
    margin: 0 2px;
    transform: translateY(2px);
}

/* --- Links Desktop --- */
.nav-links {
    list-style: none;
    display: flex;
    gap: 30px;
    align-items: center;
}

.nav-links a {
    color: #c5c6c7;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #FFC107;
}

/* --- Botão de Destaque --- */
.btn-nav {
    border: 1px solid #FFC107;
    padding: 8px 20px;
    border-radius: 20px;
    color: #FFC107 !important;
}

.btn-nav:hover {
    background: #FFC107;
    color: #000 !important;
}

/* --- Hamburger Icon --- */
.menu-toggle {
    display: none;
    cursor: pointer;
    /* push the toggle to the right in the flex container */
    margin-left: auto;
}

.bar {
    display: block;
    width: 25px;
    height: 3px;
    margin: 5px auto;
    transition: 0.3s;
    background: #fff;
}

/* --- RESPONSIVIDADE (Direita para Esquerda) --- */
@media (max-width: 768px) {
    /* Remove o padding lateral do container para o ícone encostar no canto */
    .nav-flex {
        padding-right: 5px; 
    }

    .menu-toggle {
        display: block;
        z-index: 1002;
    }

    .nav-links {
        position: fixed;
        right: -100%; /* Escondido fora do ecrã à direita */
        top: 0;
        flex-direction: column;
        background: #0b0c10;
        width: 75%; /* Largura do menu lateral */
        height: 100vh;
        transition: 0.4s ease-in-out;
        padding: 100px 30px; 
        gap: 30px;
        align-items: flex-end; /* Encosta os links à direita no menu aberto */
        text-align: right;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.5);
    }

    .nav-links.active {
        right: 0; /* Desliza para dentro do ecrã */
    }

    /* Animação do Hamburger para X */
    #mobile-menu.is-active .bar:nth-child(2) { opacity: 0; }
    #mobile-menu.is-active .bar:nth-child(1) { transform: translateY(8px) rotate(45deg); }
    #mobile-menu.is-active .bar:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
}
</style>

<script>
    // Script para abrir/fechar o menu
    const menu = document.querySelector('#mobile-menu');
    const menuLinks = document.querySelector('.nav-links');

    menu.addEventListener('click', function() {
        menu.classList.toggle('is-active');
        menuLinks.classList.toggle('active');
    });

    // Fechar o menu ao clicar num link
    document.querySelectorAll('.nav-links a').forEach(n => n.addEventListener('click', () => {
        menu.classList.remove('is-active');
        menuLinks.classList.remove('active');
    }));
</script>