<?php

namespace App\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OAuth
{
    private $config;
    private $http;

    public function __construct()
    {
        $this->config = require __DIR__ . "/../config/config.php";
        $this->http = new Client();
    }

    public function getAuthorizationUrl()
    {
        $params = [
            "client_id" => $this->config["client_id"],
            "redirect_uri" => $this->config["redirect_uri"],
            "scope" => $this->config["scopes"],
            "response_type" => "code",
            "access_type" => "offline"
        ];

        return $this->config["auth_url"] . "?" . http_build_query($params);
    }

    public function getTokenFromCode($code)
    {
        try {
            $response = $this->http->post($this->config["token_url"], [
                "form_params" => [
                    "grant_type" => "authorization_code",
                    "client_id" => $this->config["client_id"],
                    "client_secret" => $this->config["client_secret"],
                    "redirect_uri" => $this->config["redirect_uri"],
                    "code" => $code
                ]
            ]);

            $tokens = json_decode($response->getBody()->getContents(), true);

            // Assicurati che ci siano i campi necessari
            if (!isset($tokens["access_token"])) {
                throw new \Exception("La risposta non contiene un access token valido");
            }

            // Se non c'è expires_in, imposta un valore predefinito (3600 secondi = 1 ora)
            if (!isset($tokens["expires_in"])) {
                $tokens["expires_in"] = 3600;
            }

            $this->saveTokens($tokens);

            return $tokens;
        } catch (RequestException $e) {
            echo "Errore durante l'ottenimento del token: " . $e->getMessage();
            if ($e->hasResponse()) {
                echo "<br>Risposta: " . $e->getResponse()->getBody()->getContents();
            }
            return null;
        } catch (\Exception $e) {
            echo "Errore: " . $e->getMessage();
            return null;
        }
    }

    public function refreshToken()
    {
        $tokens = $this->getTokens();

        if (!isset($tokens["refresh_token"])) {
            return false;
        }

        try {
            $response = $this->http->post($this->config["token_url"], [
                "form_params" => [
                    "grant_type" => "refresh_token",
                    "client_id" => $this->config["client_id"],
                    "client_secret" => $this->config["client_secret"],
                    "refresh_token" => $tokens["refresh_token"]
                ]
            ]);

            $newTokens = json_decode($response->getBody()->getContents(), true);

            // Se non c'è expires_in, imposta un valore predefinito
            if (!isset($newTokens["expires_in"])) {
                $newTokens["expires_in"] = 3600;
            }

            // Mantieni il refresh token originale se non viene fornito un nuovo
            if (!isset($newTokens["refresh_token"]) && isset($tokens["refresh_token"])) {
                $newTokens["refresh_token"] = $tokens["refresh_token"];
            }

            $this->saveTokens($newTokens);
            return $newTokens;
        } catch (RequestException $e) {
            echo "Errore durante il refresh del token: " . $e->getMessage();
            if ($e->hasResponse()) {
                echo "<br>Risposta: " . $e->getResponse()->getBody()->getContents();
            }
            return null;
        }
    }

    public function saveTokens($tokens)
    {
        $tokens["created_at"] = time();
        $_SESSION["zoho_tokens"] = $tokens;
    }

    public function getTokens()
    {
        return isset($_SESSION["zoho_tokens"]) ? $_SESSION["zoho_tokens"] : [];
    }

    public function getAccessToken()
    {
        $tokens = $this->getTokens();

        if (empty($tokens) || !isset($tokens["access_token"])) {
            return null;
        }

        // Controlla se il token potrebbe essere scaduto
        if (isset($tokens["created_at"]) && isset($tokens["expires_in"])) {
            // Controlla se il token è scaduto (considerando un buffer di 60 secondi)
            if (time() > ($tokens["created_at"] + $tokens["expires_in"] - 60)) {
                $tokens = $this->refreshToken();

                if (!$tokens) {
                    return null;
                }
            }
        }

        return $tokens["access_token"];
    }

    public function isAuthenticated()
    {
        return $this->getAccessToken() !== null;
    }
}
