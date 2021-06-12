<?php
session_unset();
require_once  'Controllers/CarController.php';
$controller = new CarController();
$controller->index();
