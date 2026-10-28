<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['api_auth']) || $_SESSION['api_auth'] !== true) {
    echo json_encode(["error" => "No autorizado. Inicie sesión primero."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? '';

    if (empty($id)) {
        echo json_encode(["error" => "Falta el ID del participante a eliminar"]);
        exit;
    }

    $archivo = 'participantes.json';
    $datos = json_decode(file_get_contents($archivo), true);
    
    $datos_filtrados = array_filter($datos, function($participante) use ($id) {
        return $participante['id'] != $id;
    });

    if (count($datos) !== count($datos_filtrados)) {
        
        file_put_contents($archivo, json_encode(array_values($datos_filtrados), JSON_PRETTY_PRINT));
        echo json_encode(["mensaje" => "Participante eliminado"]);
    } else {
        echo json_encode(["error" => "Participante no encontrado"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido, utiliza GET"]);
}
?>