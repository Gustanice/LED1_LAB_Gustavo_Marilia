
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeD1 Lab - Eletrônica e Inovação</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700;900&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../includes/menu.php'; ?>


    <section id="inicio" class="hero">
        <div class="container hero-content">
            <h4>BEM-VINDO AO FUTURO</h4>
            <h1>Transforme código em <br><span class="gradient-text">Realidade</span>.</h1>
            <p>O laboratório definitivo para entusiastas de Arduino, IoT e prototipagem profissional.</p>
            <div class="buttons">
                <a href="#contato" class="btn-primary">Iniciar Projeto</a>
                <a href="#sobre" class="btn-outline">Saiba Mais</a>
            </div>
        </div>
    </section>

    <section id="sobre" class="section-dark">
        <div class="container split-layout">
            <div class="text-block">
                <h2>Sobre a <span class="gradient-text">LeD1</span></h2>
                <p>Nascemos da paixão por conectar o mundo digital ao físico. A LeD1 Lab não é apenas uma loja de componentes, é um hub de inovação.</p>
                <p>Nossa missão é democratizar o acesso à tecnologia de ponta, oferecendo desde microcontroladores básicos até sistemas complexos de automação industrial.</p>
                
                <div class="stats">
                    <div class="stat-item">
                        <h3>+500</h3>
                        <p>Projetos</p>
                    </div>
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Satisfação</p>
                    </div>
                </div>
            </div>
            <div class="image-block">
                <div class="tech-box">
                    <div class="circuit-line"></div>
                    <span>ARDUINO<br>CERTIFIED</span>
                </div>
            </div>
        </div>
    </section>

    <section id="servicos" class="container section-padding">
        <h2 class="text-center">Nossas Especialidades</h2>
        <div class="grid-cards">
            <div class="card">
                <div class="icon">⚙️</div>
                <h3>Prototipagem</h3>
                <p>Desenvolvimento rápido de PCBs e circuitos para validar sua ideia.</p>
            </div>
            <div class="card">
                <div class="icon">📶</div>
                <h3>IoT & Conectividade</h3>
                <p>Soluções inteligentes conectadas via Wi-Fi, Bluetooth e LoRaWAN.</p>
            </div>
            <div class="card">
                <div class="icon">🎓</div>
                <h3>Educação Maker</h3>
                <p>Kits didáticos e workshops para escolas e universidades.</p>
            </div>
        </div>
    </section>

    <section id="contato" class="section-gradient">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info">
                    <h2>Vamos Conversar?</h2>
                    <p>Tire suas dúvidas ou solicite um orçamento personalizado.</p>
                    <ul class="info-list">
                        <li>📍 Av. da Tecnologia, 1000 - Tech Park</li>
                        <li>📧 contato@led1lab.com.br</li>
                        <li>📱 (11) 99999-9999</li>
                    </ul>
                </div>
                
                <div class="contact-form">
                    <?php echo $mensagem_envio; ?>
                    <form method="POST" action="index.php#contato">
                        <div class="input-group">
                            <label>Nome</label>
                            <input type="text" name="nome" required placeholder="Seu nome">
                        </div>
                        <div class="input-group">
                            <label>E-mail</label>
                            <input type="email" name="email" required placeholder="seu@email.com">
                        </div>
                        <div class="input-group">
                            <label>Mensagem</label>
                            <textarea name="mensagem" rows="4" required placeholder="Como podemos ajudar?"></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Enviar Mensagem</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-content">
            <p>&copy; <?php echo date("Y"); ?> LeD1 Lab. Todos os direitos reservados.</p>
            <div class="socials">
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
                <a href="#">GitHub</a>
            </div>
        </div>
    </footer>

</body>
</html>