<?php

class ApiClient 
{
    private $config;
    private $tokenFile = __DIR__ . '/../token.json';

    public function __construct() {
        $this->config = require __DIR__ . '/../config/config.php';
    }

    // Get the access token, either from the file or by fetching a new one
    public function getAccessToken() {
        if (file_exists($this->tokenFile)) {
            $data = json_decode(file_get_contents($this->tokenFile), true);
            if (isset($data['access_token']) && $data['expires_at'] > time()) {
                return $data['access_token'];
            }
        }
        return $this->requestNewAccessToken();
    }

    // Request a new access token from the Microsoft OAuth server
    private function requestNewAccessToken() {
        $url = str_replace('{tenantId}', $this->config['tenant_id'], $this->config['token_url']);
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope' => 'https://tapi.dvsa.gov.uk/.default'
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            die('Error fetching access token');
        }

        $token = json_decode($result, true);
        $this->saveAccessToken($token);
        return $token['access_token'];
    }

    // Save the access token to a file
    private function saveAccessToken($token) {
        $expiresAt = time() + $token['expires_in'];
        file_put_contents($this->tokenFile, json_encode([
            'access_token' => $token['access_token'],
            'expires_at' => $expiresAt
        ]));
    }

    // Make API request to fetch MOT history
    function getMOTHistory($registrationNumber) 
    {
        $accessToken = $this->getAccessToken();
        $apiKey = $this->config['api_key'];
    
        $url = "https://history.mot.api.gov.uk/v1/trade/vehicles/registration/" . rawurlencode($registrationNumber);
    
        $ch = curl_init();
    
        // Set the URL and other necessary options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "X-API-Key: $apiKey",
            "accept: application/json"
        ]);
    
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if ($response === false) {
            $error = "cURL Error: " . curl_error($ch);
            file_put_contents('logs/api.log', date('Y-m-d H:i:s') . ' - ' . $error . PHP_EOL, FILE_APPEND);
            curl_close($ch);
            return false;
        }
    
        // Get the HTTP response status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        curl_close($ch);
        
        // Check if the HTTP response code is 200 (OK)
        if ($httpCode !== 200) {
            $error = "HTTP Error: " . $httpCode;
            file_put_contents('logs/api.log', date('Y-m-d H:i:s') . ' - ' . $error . PHP_EOL, FILE_APPEND);
            file_put_contents('logs/api.log', date('Y-m-d H:i:s') . ' - API Response: ' . $response . PHP_EOL, FILE_APPEND);

            if ($httpCode === 400) {
                $data = json_decode($response, true);
                return $data;
            }

            return null;
        }
    
        $data = json_decode($response, true);

        // Log the API response
        file_put_contents('logs/api.log', date('Y-m-d H:i:s') . ' - API Response: ' . $response . PHP_EOL, FILE_APPEND);

        return $data;
    }        
}
?>
