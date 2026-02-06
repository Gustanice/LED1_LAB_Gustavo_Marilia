<?php
// 1. Configuração da Base de Dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "led1_lab_gustavo_marilia"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// 2. Capturar variáveis da URL e limpar para evitar SQL Injection
$pesquisa = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filtro_led = isset($_GET['led']) ? $conn->real_escape_string($_GET['led']) : '';
$filtro_cat = isset($_GET['cat']) ? $conn->real_escape_string($_GET['cat']) : '';

// 3. Construir a Query SQL dinâmica
// Nota: Ajustei os nomes das colunas para baterem certo com o seu loop (nome_produto, categoria, etc)
$sql = "SELECT * FROM produtos WHERE 1=1";

// 🔹 FILTRO LED
if ($filtro_led != '') {
    $sql .= " AND (tipo_led = '$filtro_led' OR tipo_led = 'AMBOS')";
}

// 🔹 FILTRO CATEGORIA
if ($filtro_cat != '') {
    $sql .= " AND categoria = '$filtro_cat'";
}

// 🔹 PESQUISA POR TEXTO
if ($pesquisa != '') {
    $sql .= " AND (nome_produto LIKE '%$pesquisa%' OR descricao_produto LIKE '%$pesquisa%' OR categoria LIKE '%$pesquisa%')";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratório - Requisitar Componentes | LeD Lab</title>
    
    <link rel="stylesheet" href="css/lab.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="background-animado">
    <div class="wrap-svgs">
        <?php for($i=0; $i<8; $i++): ?>
            <svg class="floating-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
        <?php endfor; ?>
    </div>
</div>

<?php include '../includes/menu.php'; ?>

<section class="lab-hero container">
    <h1>Material de <span class="gradient-text">Laboratório</span></h1>

    <div class="search-container">
        <form action="lab.php" method="GET" class="search-box">
            <?php if(!empty($filtro_led)): ?>
                <input type="hidden" name="led" value="<?php echo htmlspecialchars($filtro_led); ?>">
            <?php endif; ?>
            
            <?php if(!empty($filtro_cat)): ?>
                <input type="hidden" name="cat" value="<?php echo htmlspecialchars($filtro_cat); ?>">
            <?php endif; ?>

            <div style="position: relative; flex: 1; display: flex; align-items: center;">
                <input type="text" name="search" placeholder="O que procuras hoje?" 
                       value="<?php echo htmlspecialchars($pesquisa); ?>">
                
                <?php if(!empty($pesquisa)): ?>
                    <a href="lab.php?<?php echo ($filtro_led ? "led=$filtro_led" : "") . ($filtro_cat ? "&cat=$filtro_cat" : ""); ?>" 
                       style="position: absolute; right: 15px; color: #f44336; text-decoration: none; font-weight: bold;">✕</a>
                <?php endif; ?>
            </div>

            <button type="submit">Pesquisar</button>
        </form>
    </div>
</section>

<div class="container lab-layout">
    
    <aside class="sidebar-filters">
        <div class="filter-card">
            <h3>Área do LED</h3>
            <div class="filter-options">
                <a href="lab.php" class="opt <?php echo $filtro_led == '' ? 'active' : ''; ?>">Todos</a>
                <a href="?led=LED 1<?php echo $pesquisa ? "&search=$pesquisa" : ""; ?>" class="opt <?php echo $filtro_led == 'LED 1' ? 'active' : ''; ?>">LED 1</a>
                <a href="?led=LED 2<?php echo $pesquisa ? "&search=$pesquisa" : ""; ?>" class="opt <?php echo $filtro_led == 'LED 2' ? 'active' : ''; ?>">LED 2</a>
            </div>
        </div>

        <div class="filter-card">
            <h3>Categorias</h3>
            <div class="filter-options">
                <a href="?cat=Equipamento Comum&led=<?php echo $filtro_led; ?>" class="opt <?php echo $filtro_cat == 'Equipamento Comum' ? 'active' : ''; ?>">Equipamento Comum</a>
                <a href="?cat=Programação e Robótica&led=<?php echo $filtro_led; ?>" class="opt <?php echo $filtro_cat == 'Programação e Robótica' ? 'active' : ''; ?>">Programação e Robótica</a>
                <a href="?cat=STEM&led=<?php echo $filtro_led; ?>" class="opt <?php echo $filtro_cat == 'STEM' ? 'active' : ''; ?>">STEM</a>

                <?php if ($filtro_led == 'LED 2' || $filtro_led == ''): ?>
                    <a href="?cat=Artes e Multimédia&led=<?php echo $filtro_led; ?>" class="opt <?php echo $filtro_cat == 'Artes e Multimédia' ? 'active' : ''; ?>">Artes e Multimédia</a>
                <?php endif; ?>
            </div>
        </div>

        <a href="lab.php" class="btn-reset">Limpar Filtros</a>
    </aside>

    <main class="products-content">
        <div class="components-grid">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $stock = $row['quantidade'];
                    // Ajuste o caminho da imagem conforme sua pasta real
                    $img_path = "img/" . basename($row['imagem_produto']); 
            ?>
                <a href="detalhes.php?id=<?php echo $row['ID_produto']; ?>" class="card-link">
                    <div class="component-card">
                        <div class="card-img-container">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($row['nome_produto']); ?>" 
                                 onerror="this.src='../img/default.png';">
                        </div>
                        <div class="card-body">
                            <span class="category-tag"><?php echo htmlspecialchars($row['categoria']); ?></span>
                            <h3><?php echo htmlspecialchars($row['nome_produto']); ?></h3>
                            <div class="stock-status <?php echo $stock > 0 ? 'in' : 'out'; ?>">
                                ● <?php echo $stock > 0 ? "Disponível ($stock)" : "Indisponível"; ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
                }
            } else {
                echo "<div class='no-results'><p style='color: white;'>Nenhum componente encontrado para esta busca.</p></div>";
            }
            ?>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>