<?php
require __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

return [
    "client_id" => $_ENV["ZOHO_CLIENT_ID"],
    "client_secret" => $_ENV["ZOHO_CLIENT_SECRET"],
    "redirect_uri" => $_ENV["ZOHO_REDIRECT_URI"],
    "scopes" => $_ENV["ZOHO_SCOPES"],
    "auth_url" => $_ENV["ZOHO_AUTH_URL"],
    "token_url" => $_ENV["ZOHO_TOKEN_URL"],
    "api_base_url" => $_ENV["ZOHO_API_BASE_URL"]
];
