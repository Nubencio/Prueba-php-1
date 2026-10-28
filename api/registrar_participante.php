<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['api_auth']) || $_SESSION['api_auth'] !== true) {
    http_response_code(401);
    echo json_encode([
        "error" => "No autorizado. Inicie sesión primero."
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "error" => "Método no permitido. Utiliza POST."
    ]);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$numero_rifa = $_POST['numero_rifa'] ?? '';

if ($nombre === '' || $apellido === '' || $numero_rifa === '') {
    http_response_code(400);
    echo json_encode([
        "error" => "Faltan datos obligatorios: nombre, apellido y numero_rifa."
    ]);
    exit;
}

$numero_rifa_validado = filter_var(
    $numero_rifa,
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if ($numero_rifa_validado === false) {
    http_response_code(400);
    echo json_encode([
        "error" => "El número de rifa debe ser un entero mayor que cero."
    ]);
    exit;
}

$archivo = __DIR__ . '/participantes.json';

if (!file_exists($archivo) || !is_readable($archivo)) {
    http_response_code(500);
    echo json_encode([
        "error" => "No se pudo encontrar o leer participantes.json."
    ]);
    exit;
}

$contenido = file_get_contents($archivo);
$datos = json_decode($contenido, true);

if (!is_array($datos)) {
    http_response_code(500);
    echo json_encode([
        "error" => "participantes.json no contiene un arreglo JSON válido."
    ]);
    exit;
}

$nombre_comparar = strtolower($nombre);
$apellido_comparar = strtolower($apellido);

foreach ($datos as $participante) {
    $nombre_existente = strtolower(trim($participante['nombre'] ?? ''));
    $apellido_existente = strtolower(trim($participante['apellido'] ?? ''));
    $numero_existente = (int)($participante['numero_rifa'] ?? 0);

    if (
        $nombre_existente === $nombre_comparar &&
        $apellido_existente === $apellido_comparar &&
        $numero_existente === (int)$numero_rifa_validado
    ) {
        http_response_code(409);
        echo json_encode([
            "error" => "El participante ya está registrado."
        ]);
        exit;
    }
}

$ids = array_column($datos, 'id');
$nuevo_id = empty($ids) ? 1 : max($ids) + 1;

$nuevo_participante = [
    "id" => $nuevo_id,
    "nombre" => $nombre,
    "apellido" => $apellido,
    "numero_rifa" => (int)$numero_rifa_validado
];

$datos[] = $nuevo_participante;

$resultado = file_put_contents(
    $archivo,
    json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

if ($resultado === false) {
    http_response_code(500);
    echo json_encode([
        "error" => "No se pudo guardar el participante."
    ]);
    exit;
}

http_response_code(201);
echo json_encode([
    "mensaje" => "Participante registrado correctamente.",
    "datos" => $nuevo_participante
], JSON_UNESCAPED_UNICODE);
?>