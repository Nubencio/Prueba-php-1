<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario === 'userupla' && $password === 'upla123') {
        session_start();
        $_SESSION['api_auth'] = true;
        echo json_encode(["mensaje" => "Sesion iniciada exitosamente"]);
    } else {
        echo json_encode(["error" => "Credenciales incorrectas"]);
    }
} else {
    echo json_encode(["error" => "Metodo no permitido, utiliza POST"]);
}
?>