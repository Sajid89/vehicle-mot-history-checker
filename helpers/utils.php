<?php

function validateRegistrationNumber($registration) {
    return preg_match('/^[A-Z0-9]{1,7}$/', strtoupper($registration));
}

?>