<?php

require_once __DIR__ . '/ApiClient.php';

class MOTService 
{
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    public function getMOTHistory($registrationNumber) {
        return $this->apiClient->getMOTHistory($registrationNumber);
    }
}

?>