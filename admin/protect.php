<?php
session_start();
if (!isset($_SESSION['ID_admin'])) {
    header("Location: ../pages/login.php");
    exit;
}
if ($_SESSION['primeiro_login'] ?? 0 == 1) {
    header("Location: ../pages/alterar_password.php");
    exit;
}
if (!isset($_SESSION['ID_admin']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../pages/index.php");
    exit;
}


?>