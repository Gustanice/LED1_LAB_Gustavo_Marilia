
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeD1 Lab - Eletrônica e Inovação</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>

<?php include '../includes/menu.php'; ?>

<section id="inicio" class="hero">
    <div class="container hero-content">
        <h4>BEM-VINDO AO FUTURO</h4>
        <h1>Transforme o seu projeto em <br><span class="gradient-text">Realidade</span>.</h1>
        <p>O laboratório definitivo para entusiastas de Arduino, IoT e prototipagem profissional.</p>
        
        <div class="buttons">
            <a href="#contato" class="btn-primary">Iniciar Projeto</a>
            <a href="#sobre" class="btn-outline">Saiba Mais</a>
        </div>

        <div class="hero-logos">
            <img src="img/logos.png" alt="Logos Institucionais">
        </div>
    </div>
</section>

    <section id="sobre" class="section-dark">
        <div class="container split-layout">
            <div class="text-block">
                <h2>Sobre a <span class="gradient-text">LED1Lab</span></h2>
                <p>Nascemos da paixão por conectar o mundo digital ao físico. A LED1Lab não é apenas um site de componestes, é um inventário de inovação.</p>
                <p>Nossa missão é facilitar o acesso aos alunos do agrupamento de Albergaria-a-Velha à tecnologia de ponta, microcontroladores básicos até sistemas complexos de Arduino.</p>
                
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
<div class="image-block carousel-container">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="img/carro-arduino.png" alt="Robô Industrial" class="floating-img">
            </div>
            <div class="swiper-slide">
                <img src="img/placas-arduino.png" alt="Arduino Uno" class="floating-img">
            </div>
            <div class="swiper-slide">
                <img src="img/garra-arduino.png" alt="Projeto IOT" class="floating-img">
            </div>
        </div>
        
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
        <div class="swiper-pagination"></div>
    </div>
</div>

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


  
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    effect: "fade", // Pode trocar por "slide" ou "coverflow"
    fadeEffect: { crossFade: true },
  });
</script>
</body>
</html>