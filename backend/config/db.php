<?php
// backend/config/db.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "led1_lab_gustavo_marilia";

try {
    // Esta linha cria a conexão PDO que usamos no menu
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ADICIONA ESTA LINHA ABAIXO para manter compatibilidade com o teu index.php antigo:
    $conn = new mysqli($host, $user, $pass, $dbname); 

} catch (PDOException $e) {
    die("Erro na ligação: " . $e->getMessage());
}
?>