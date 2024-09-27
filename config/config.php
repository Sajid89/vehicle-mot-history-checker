<?php

// get client_id, client_secret, tenant_id, api_key from https://documentation.history.mot.api.gov.uk/mot-history-api/authentication/
return [
    'client_id' => '',
    'client_secret' => '',
    'tenant_id' => '',
    'api_key' => '',
    'token_url' => 'https://login.microsoftonline.com/{tenantId}/oauth2/v2.0/token',
    'mot_api_url' => 'https://history.mot.api.gov.uk/v1/trade/vehicles/registration/'
];

?>
