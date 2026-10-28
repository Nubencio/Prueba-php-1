<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_destroy();
    echo json_encode(["mensaje" => "Sesión cerrada correctamente"]);
} else {
    echo json_encode(["error" => "Método no permitido, utiliza GET"]);
}
?>