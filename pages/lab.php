<?php
// Configuração da Base de Dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "led1_lab_gustavo_marilia"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Capturar filtros e pesquisa
$filtro_led = isset($_GET['led']) ? $_GET['led'] : '';
$filtro_cat = isset($_GET['cat']) ? $_GET['cat'] : '';
$pesquisa   = isset($_GET['search']) ? $_GET['search'] : '';

// Construir a Query SQL dinâmica
$sql = "SELECT * FROM produtos WHERE 1=1";

// 🔹 FILTRO LED (LED 1 / LED 2 / AMBOS)
if ($filtro_led != '') {
    $led = $conn->real_escape_string($filtro_led);
    $sql .= " AND (tipo_led = '$led' OR tipo_led = 'AMBOS')";
}

// 🔹 FILTRO CATEGORIA
if ($filtro_cat != '') {
    $sql .= " AND categoria = '" . $conn->real_escape_string($filtro_cat) . "'";
}

// 🔹 PESQUISA
if ($pesquisa != '') {
    $search = $conn->real_escape_string($pesquisa);
    $sql .= " AND (
        nome_produto LIKE '%$search%' 
        OR descricao_produto LIKE '%$search%'
    )";
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

<?php include '../includes/menu.php'; ?>

<section class="lab-hero container">
    <h1>Material de <span class="gradient-text">Laboratório</span></h1>

    <div class="search-container">
        <form action="lab.php" method="GET" class="search-box">
            <input type="text" name="search" placeholder="O que procuras hoje?" value="<?php echo htmlspecialchars($pesquisa); ?>">

            <?php if($filtro_led): ?>
                <input type="hidden" name="led" value="<?php echo $filtro_led; ?>">
            <?php endif; ?>

            <?php if($filtro_cat): ?>
                <input type="hidden" name="cat" value="<?php echo $filtro_cat; ?>">
            <?php endif; ?>

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
                <a href="?led=LED 1" class="opt <?php echo $filtro_led == 'LED 1' ? 'active' : ''; ?>">LED 1</a>
                <a href="?led=LED 2" class="opt <?php echo $filtro_led == 'LED 2' ? 'active' : ''; ?>">LED 2</a>
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
                    $img_path = "img/" . basename($row['imagem_produto']);
            ?>
                <a href="detalhes.php?id=<?php echo $row['ID_produto']; ?>" class="card-link">
                    <div class="component-card">
                        <div class="card-img-container">
                            <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($row['nome_produto']); ?>">
                        </div>
                        <div class="card-body">
                            <span class="category-tag"><?php echo $row['categoria']; ?></span>
                            <h3><?php echo $row['nome_produto']; ?></h3>
                            <div class="stock-status <?php echo $stock > 0 ? 'in' : 'out'; ?>">
                                ● <?php echo $stock > 0 ? "Disponível ($stock)" : "Indisponível"; ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
                }
            } else {
                echo "<div class='no-results'><p>Nenhum resultado encontrado.</p></div>";
            }
            ?>
        </div>
    </main>
</div>

</body>
</html>
