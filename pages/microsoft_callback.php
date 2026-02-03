<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';

$clientId = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
$clientSecret = "qzhyhfltlhfttfyp";
$redirectUri = "http://localhost/led1_lab_gustavo_marilia/LED1_LAB_Gustavo_Marilia/pages/login/microsoft_callback.php";

$code = $_GET['code'] ?? null;
if (!$code) {
    die("Erro no login Microsoft"); 
}

// Trocar code por token
$tokenUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";


$data = [
    "client_id" => $clientId,
    "client_secret" => $clientSecret,
    "code" => $code,
    "redirect_uri" => $redirectUri,
    "grant_type" => "authorization_code",
];

$options = [
    "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => http_build_query($data),
    ]
];

$response = file_get_contents($tokenUrl, false, stream_context_create($options));
$token = json_decode($response, true);

if (!isset($token['access_token'])) {
    die("Falha ao obter token");
}
