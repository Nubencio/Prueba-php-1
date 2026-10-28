<?php
session_start();


if (!isset($_SESSION['web_auth']) || $_SESSION['web_auth'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Panel Principal Protegido</h2>
    <p>Bienvenido. Has iniciado sesión correctamente.</p>
    <ul>
        <li><a href="rifa.php">Reserva de números (Rifa)</a></li>
        <li><a href="buscar.php">Buscar participantes</a></li>
        <li><a href="subir_comprobante.php">Subir comprobante</a></li>
        <li><a href="archivos.php">Ver archivos cargados</a></li>
        <li><a href="salir.php">Cerrar sesión</a></li>
    </ul>
</body>
</html>