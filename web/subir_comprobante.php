<?php
session_start();

if (!isset($_SESSION['web_auth']) || $_SESSION['web_auth'] !== true) {
    header('Location: index.php');
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['comprobante'])) {
    $directorio_subida = 'uploads/';

    if (!is_dir($directorio_subida)) {
        mkdir($directorio_subida, 0777, true);
    }

    $nombre_archivo = basename($_FILES['comprobante']['name']);
    $ruta_final = $directorio_subida . $nombre_archivo;

    if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta_final)) {
        $mensaje = "<span style='color:green;'>Comprobante subido exitosamente: $nombre_archivo</span>";
    } else {
        $mensaje = "<span style='color:red;'>Error al subir el archivo. Verifica los permisos.</span>";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Subir Comprobante</h2>
    <a href="panel.php">Volver al Panel</a>
    <br><br>
    
    <?= $mensaje ? "<p>$mensaje</p>" : "" ?>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Selecciona un archivo desde tu equipo:</label><br><br>
        <input type="file" name="comprobante" required><br><br>
        <button type="submit">Subir Archivo</button>
    </form>
</body>
</html>