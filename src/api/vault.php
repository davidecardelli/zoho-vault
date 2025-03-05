<?php

namespace App\Api;

use App\Auth\OAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Vault
{
    private $config;
    private $oauth;
    private $http;

    public function __construct()
    {
        $this->config = require __DIR__ . "/../config/config.php";
        $this->oauth = new OAuth();
        $this->http = new Client([
            "base_uri" => $this->config["api_base_url"]
        ]);
    }

    private function request($method, $endpoint, $params = [])
    {
        $accessToken = $this->oauth->getAccessToken();

        if (!$accessToken) {
            throw new \Exception("Non sei autenticato");
        }

        try {
            $options = [
                "headers" => [
                    "Authorization" => "Zoho-oauthtoken " . $accessToken,
                    "Content-Type" => "application/json"
                ]
            ];

            if (!empty($params)) {
                if ($method === "GET") {
                    $options["query"] = $params;
                } else {
                    $options["json"] = $params;
                }
            }

            $response = $this->http->request($method, $endpoint, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();

            if ($e->hasResponse()) {
                $errorMessage = $e->getResponse()->getBody()->getContents();
            }

            throw new \Exception("Errore API Zoho Vault: " . $errorMessage);
        }
    }

    public function getSecrets()
    {
        // Dalla documentazione Zoho Vault, l'endpoint corretto è 'api/rest/json/v1/secrets'
        return $this->request("GET", "api/rest/json/v1/secrets", [
            "pageNum" => 1,
            "rowPerPage" => 50,
            "isAsc" => "true"
        ]);
    }

    public function getSecret($secretId)
    {
        return $this->request("GET", "api/rest/json/v1/secrets/" . $secretId);
    }

    public function createSecret($data)
    {
        return $this->request("POST", "api/rest/json/v1/secrets", $data);
    }

    public function updateSecret($secretId, $data)
    {
        return $this->request("PUT", "api/rest/json/v1/secrets/" . $secretId, $data);
    }

    public function deleteSecret($secretId)
    {
        return $this->request("DELETE", "api/rest/json/v1/secrets/" . $secretId);
    }

    // Aggiunti metodi per le camere (chambers)
    public function getChambers()
    {
        return $this->request("GET", "api/rest/json/v1/chambers", [
            "pageNum" => 1,
            "rowPerPage" => 50,
            "isAsc" => "true"
        ]);
    }

    public function getChamberSecrets($chamberId)
    {
        return $this->request("GET", "api/rest/json/v1/chambers/" . $chamberId, [
            "pageNum" => 1,
            "rowPerPage" => 50,
            "isAsc" => "true"
        ]);
    }
}
