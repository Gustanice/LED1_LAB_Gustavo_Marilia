
<?php
// Se tiveres alguma lógica de envio de e-mail, ela entra aqui
$mensagem_envio = ""; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - LeD1 Lab</title>
        <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/contactos.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;900&display=swap" rel="stylesheet">
</head>
<body>
       
    <?php 
    // Inclui o menu que está na pasta includes (um nível acima)
    include '../includes/menu.php'; 
    ?>
<section class="contact-hero">
    <div class="container">
        <div class="hero-text-center">
            <h1>Contacte - <span class="gradient-text">Nos</span></h1>
            <p>Estamos ao seu dispor para qualquer esclarecimento.</p>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container-fluid"> <div class="map-wrapper">
            
<iframe 
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3285.3983335577987!2d-8.48194138813652!3d40.68712607127811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd23757f50ae35e5%3A0xe53f1e9c0e6a9c4f!2sES%20de%20Albergaria-a-Velha!5e1!3m2!1spt-PT!2spt!4v1769614705977!5m2!1spt-PT!2spt" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
            
            <div class="floating-form-card">
                <div class="form-header">
                    <span class="sub-title">CONTACTE-NOS</span>
                    <h2>Fale connosco</h2>
                </div>
                
                <form method="POST" action="contactos.php">
                    <div class="form-row">
                        <div class="input-group">
                            <input type="text" name="nome" required placeholder=" ">
                            <label>NOME*</label>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" required placeholder=" ">
                            <label>E-MAIL*</label>
                        </div>
                    </div>

                    <div class="input-group">
                        <textarea name="mensagem" rows="4" required placeholder=" "></textarea>
                        <label>MENSAGEM*</label>
                    </div>

                    <button type="submit" class="btn-submit">Enviar Mensagem</button>
                </form>

                <div class="contact-mini-info">
                    <p>📍 Av. da Tecnologia, 1000, Marília-SP</p>
                    <p>📧 contato@led1lab.com.br</p>
                </div>
            </div>

        </div>
    </div>
</main>


    

</body>
</html>