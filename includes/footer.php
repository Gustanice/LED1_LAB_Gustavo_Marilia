<?php
require_once __DIR__ . '/../backend/config/db.php';

$stmt = $pdo->query("SELECT * FROM footer LIMIT 1");
$footer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .main-footer {
        background-color: #0b0c10; 
        color: #c5c6c7;
        padding: 60px 0 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        font-family: 'Inter', sans-serif;
    }

    .footer-container {
        max-width: 1200px;
        margin-left: 10%; /* Mantém um respiro à esquerda, mas alinha o conteúdo lá */
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        padding: 0 20px;
    }

    .footer-column {
        text-align: left; /* Garante alinhamento à esquerda em cada coluna */
    }

    .footer-logo {
        font-size: 1.6rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 15px;
        display: block;
        text-align: left;
    }

    .footer-logo span {
        background: linear-gradient(90deg, #ffc107, #3f51b5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .footer-column h4 {
        color: #fff;
        margin-bottom: 20px;
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        position: relative;
    }

    /* Linha decorativa debaixo do título, alinhada à esquerda */
    .footer-column h4::after {
        content: '';
        display: block;
        width: 30px;
        height: 2px;
        background: #ffc107;
        margin-top: 8px;
    }

    .footer-text {
        font-size: 0.9rem;
        line-height: 1.6;
        max-width: 300px; /* Evita que o texto estique muito */
    }

    .footer-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        justify-content: flex-start; /* Força ícones à esquerda */
    }

    .footer-list i {
        color: #ffc107;
        width: 18px;
    }

    .footer-list a {
        color: #c5c6c7;
        text-decoration: none;
        transition: 0.3s;
    }

    .footer-list a:hover {
        color: #ffc107;
    }

    .footer-socials {
        display: flex;
        gap: 12px;
        justify-content: flex-start; /* Alinha redes sociais à esquerda */
    }

    .footer-socials a {
        width: 38px;
        height: 38px;
        background: #1f2833;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px; /* Formato levemente quadrado moderno */
        color: #fff;
        transition: 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-socials a:hover {
        background: #ffc107;
        color: #0b0c10;
        transform: translateY(-3px);
    }

    .footer-bottom {
        max-width: 1200px;
        margin-left: 20%;
        margin-top: 50px;
        padding: 20px 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 0.8rem;
        text-align: center; /* Copyright à esquerda */
        opacity: 0.5;
    }
</style>

<footer class="main-footer">
    <div class="footer-container">
        
        <div class="footer-column">
            <strong class="footer-logo">LED<span>1/2</span></strong>
            <p class="footer-text">Inovação e tecnologia ao serviço da educação e prototipagem profissional.</p>
        </div>

        <div class="footer-column">
            <h4>Sede</h4>
            <ul class="footer-list">
                <li><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($footer['morada']) ?></li>
                <li><i class="fas fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($footer['email']) ?>"><?= htmlspecialchars($footer['email']) ?></a></li>
                <li><i class="fas fa-phone"></i> <?= htmlspecialchars($footer['telefone']) ?></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Social</h4>
            <div class="footer-socials">
                <a href="<?= $footer['instagram'] ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="<?= $footer['linkedin'] ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="<?= $footer['github'] ?>" target="_blank"><i class="fab fa-github"></i></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
      &copy; <?= date('Y') ?> LED1/2 - Eletrônica e Inovação. <br> Desenvolvido por Gustavo Marília.  
        <br>Todos os direitos reservados.
    </div>
</footer>