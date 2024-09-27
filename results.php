<?php

require_once 'helpers/utils.php';
require_once 'src/MOTService.php';

$registration = $_GET['registration'];

$motService = new MOTService();

if (!empty($registration)) {
    $data = $motService->getMOTHistory($registration);
} else {
    $data = null;
}

include 'views/result_view.php';

?>
