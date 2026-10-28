<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['api_auth']) || $_SESSION['api_auth'] !== true) {
    echo json_encode(["error" => "No autorizado. Inicie sesión primero."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $numero_rifa = $_POST['numero_rifa'] ?? '';

    if (empty($id) || empty($nombre) || empty($apellido) || empty($numero_rifa)) {
        echo json_encode(["error" => "Faltan datos obligatorios (id, nombre, apellido, numero_rifa)"]);
        exit;
    }

    $archivo = 'participantes.json';
    $datos = json_decode(file_get_contents($archivo), true);
    $actualizado = false;

    foreach ($datos as &$participante) {
        if ($participante['id'] == $id) {
            $participante['nombre'] = $nombre;
            $participante['apellido'] = $apellido;
            $participante['numero_rifa'] = (int)$numero_rifa;
            $actualizado = true;
            break;
        }
    }

    if ($actualizado) {
        file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT));
        echo json_encode(["mensaje" => "Participante actualizado"]);
    } else {
        echo json_encode(["error" => "Participante no encontrado"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido, utiliza POST"]);
}
?>