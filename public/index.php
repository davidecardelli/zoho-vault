<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";

use App\Auth\OAuth;
use App\Api\Vault;

$oauth = new OAuth();
$vault = new Vault();

/**
 * Effettua il reindirizzamento e termina lo script.
 *
 * @param string $url URL di destinazione.
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Verifica se l'utente è autenticato, altrimenti lo reindirizza al login.
 */
function ensureAuthenticated(OAuth $oauth): void
{
    if (!$oauth->isAuthenticated()) {
        redirect("/?action=login");
    }
}

// Gestione del callback OAuth
if (isset($_GET["code"])) {
    echo "<div style='background: #dff0d8; padding: 10px; margin-bottom: 15px;'>Codice di autorizzazione ricevuto: {$_GET["code"]}</div>";
    echo "<div style='background: #dff0d8; padding: 10px; margin-bottom: 15px;'>Token ottenuti: ";
    var_dump($oauth->getTokenFromCode($_GET["code"]));
    echo "</div>";

    redirect("/");
}

// Gestione delle azioni
$action = $_GET["action"] ?? "";

switch ($action) {
    case "login":
        redirect($oauth->getAuthorizationUrl());

    case "logout":
        unset($_SESSION["zoho_tokens"]);
        redirect("/");

    case "list":
        ensureAuthenticated($oauth);
        try {
            $secrets = $vault->getSecrets();
            include __DIR__ . "/views/list.php";
        } catch (\Exception $e) {
            echo "Errore: " . $e->getMessage();
        }
        exit;

    case "create":
        ensureAuthenticated($oauth);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $vault->createSecret([
                    "secretName" => $_POST["name"],
                    "secretPassword" => $_POST["password"]
                ]);
                redirect("/?action=list");
            } catch (\Exception $e) {
                echo "Errore: " . $e->getMessage();
            }
        }

        include __DIR__ . "/views/create.php";
        exit;

    default:
        include __DIR__ . "/views/home.php";
        exit;
}
