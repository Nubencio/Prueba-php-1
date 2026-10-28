<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['api_auth']) || $_SESSION['api_auth'] !== true) {
    echo json_encode(["error" => "No autorizado. Inicie sesión primero."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $datos = file_get_contents('premios.json');
    echo $datos;
} else {
    echo json_encode(["error" => "Método no permitido, utiliza GET"]);
}
?>