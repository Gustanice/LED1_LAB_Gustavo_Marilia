<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../backend/config/db.php';

$response = [];

if (!isset($_SESSION['ID_admin'])) {
    echo json_encode(['status' => 'unauthorized', 'message' => 'Inicia sessão primeiro.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prod = intval($_POST['id_produto']);
    $qtd = intval($_POST['qtd']);
    $id_user = $_SESSION['ID_admin'];

    try {
        $stmt = $pdo->prepare("SELECT quantidade, nome_produto FROM produtos WHERE ID_produto = ?");
        $stmt->execute([$id_prod]);
        $p = $stmt->fetch();

        if ($p && $p['quantidade'] >= $qtd) {
            $pdo->beginTransaction();
            
            // 1. Baixa no Stock
            $up = $pdo->prepare("UPDATE produtos SET quantidade = quantidade - ? WHERE ID_produto = ?");
            $up->execute([$qtd, $id_prod]);

            // 2. Registo da Requisição
            $ins = $pdo->prepare("INSERT INTO requisicoes (id_admin, id_produto, quantidade) VALUES (?, ?, ?)");
            $ins->execute([$id_user, $id_prod, $qtd]);

            $pdo->commit();
            $response = ['status' => 'success', 'message' => 'Requisição de ' . $p['nome_produto'] . ' concluída!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Stock insuficiente.'];
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $response = ['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()];
    }
}
echo json_encode($response);