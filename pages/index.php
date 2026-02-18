
<?php
// 1. Configuração da Base de Dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "led1_lab_gustavo_marilia"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// 2. Procurar 4 componentes aleatórios para a vitrine
$sql_random = "SELECT * FROM produtos ORDER BY RAND() LIMIT 4";
$res_random = $conn->query($sql_random);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED1/2 - Eletrônica e Inovação</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>

<?php 
require_once __DIR__ . '/../backend/config/db.php';
include '../includes/menu.php'; 
?>


<main>
<section id="inicio" class="hero">
    <div class="container hero-content">
        <h4 style="letter-spacing: 2px; color: var(--primary-gold);">LABORATÓRIOS LED1 & LED2</h4>
        
        <h1>Inovação Tecnológica em <br><span class="gradient-text">TGPSI</span>.</h1>
        
        <p>Explore o centro de prototipagem avançada. Desde redes e programação até sistemas multimédia e eletrónica aplicada.</p>
        
        <div class="buttons">
            <a href="#requisicao" class="btn-primary">Requisitar Material</a>
            <a href="#vitrine-aleatoria" class="btn-outline">Ver Inventário</a>
        </div>

        <div class="hero-logos">
            <img src="img/logos.png" alt="Agrupamento de Escolas e Curso TGPSI" >
        </div>
    </div>
</section>
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section id="sobre" class="section-sobre">
    <div class="container sobre-wrapper">
        
        <div class="sobre-text">
            <span class="badge-tech">AGRUPAMENTO DE ALBERGARIA-A-VELHA</span>
            <h2>Gestão de Recursos <span class="gradient-text">TGPSI</span></h2>
            
            <p class="lead">
                Desenvolvido por alunos do Curso Profissional de Técnico de Gestão e Programação de Sistemas Informáticos.
            </p>
            <p class="description">
                Esta plataforma foi criada para modernizar e facilitar o processo de requisição de material para os laboratórios <strong>LED1</strong> e <strong>LED2</strong>. 
                O nosso objetivo é garantir que todos os alunos e professores tenham acesso rápido e organizado aos componentes eletrónicos e equipamentos necessários para os seus projetos escolares.
            </p>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon-box">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div>
                        <h3>LED1 & 2</h3>
                        <p>Laboratórios</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="icon-box">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div>
                        <h3>TGPSI</h3>
                        <p>Curso Profissional</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon-box">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3>Fácil</h3>
                        <p>Requisição Digital</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="sobre-visual">
            <div class="visual-decoration"></div> <div class="swiper mySwiper carousel-frame">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="img/mesa_audio.png" alt="Equipamento LED1">
                        <div class="slide-overlay">
                            <span>Laboratório LED1</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="img/placas-arduino.png" alt="Componentes Eletrónicos">
                        <div class="slide-overlay">
                            <span>Material TGPSI</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="img/impressora3d.png" alt="Impressão 3D LED2">
                        <div class="slide-overlay">
                            <span>Laboratório LED2</span>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-button-next custom-nav"></div>
                <div class="swiper-button-prev custom-nav"></div>
                <div class="swiper-pagination custom-pag"></div>
            </div>
        </div>

    </div>
</section>

<section id="vitrine-aleatoria" class="container section-padding">
        <div class="text-center" style="margin-bottom: 40px; font-size: 1.6rem;">
            <h2>O nosso <span class="gradient-text">Inventário</span></h2>
            <p>Pesquise agora ou descubra componentes aleatórios abaixo.</p>

            <div class="search-container" style="max-width: 600px; margin: 25px auto;">
                <form action="../pages/lab.php" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="O que precisas para o teu projeto?">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div>

        <div class="grid-cards">
            <?php if ($res_random && $res_random->num_rows > 0): ?>
                <?php while($row = $res_random->fetch_assoc()): 
                    $img = "img/" . basename($row['imagem_produto']);
                ?>
                    <div class="component-card">
                        <div class="card-img-container">
                            <img src="<?php echo $img; ?>" onerror="this.src='img/logo.png'">
                        </div>
                        <div class="card-body">
                            <span class="category-tag"><?php echo $row['categoria']; ?></span>
                            <h3><?php echo $row['nome_produto']; ?></h3>
                            <a href="../pages/detalhes.php?id=<?php echo $row['ID_produto']; ?>" class="btn-back" style="font-size: 0.8rem; color:white;">Ver mais detalhes</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">A carregar componentes...</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center" style="margin-top: 40px;">
            <a href="../pages/lab.php" class="btn-outline">Ver Catálogo Completo</a>
        </div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper(".mySwiper", {
    loop: true,
    spaceBetween: 30,
    centeredSlides: true,
    speed: 800, // Velocidade da transição
    autoplay: {
      delay: 3000, // Muda a cada 3 segundos
      disableOnInteraction: false, // Continua a rodar mesmo se o utilizador clicar
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    // Efeito de transição suave
    effect: "slide", 
  });
</script>
</body>
</main>     
<div>
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
  </div>
</html>