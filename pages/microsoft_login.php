<?php
$clientId = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
$redirectUri = "http://localhost/led1_lab_gustavo_marilia/LED1_LAB_Gustavo_Marilia/pages/microsoft_callback.php";

$tenantId = "TENANT_ID_AQUI";

$url = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/authorize?" . http_build_query([
    "client_id" => $clientId,
    "response_type" => "code",
    "redirect_uri" => $redirectUri,
    "response_mode" => "query",
    "scope" => "openid profile email",
]);

header("Location: $url");
exit;
