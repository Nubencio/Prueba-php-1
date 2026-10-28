<?php
session_start();

// Validar que la sesión esté iniciada
if (!isset($_SESSION['web_auth']) || $_SESSION['web_auth'] !== true) {
    header('Location: index.php');
    exit;
}

// Inicializar la cantidad de números en la sesión si no existe
if (!isset($_SESSION['cantidad_rifas'])) {
    $_SESSION['cantidad_rifas'] = 0;
}

// Procesar el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'agregar') {
            $_SESSION['cantidad_rifas']++;
        } elseif ($_POST['accion'] === 'quitar' && $_SESSION['cantidad_rifas'] > 0) {
            $_SESSION['cantidad_rifas']--;
        }
    }

    header('Location: rifa.php');
    exit;
}

$precio_unitario = 2000;
$cantidad = $_SESSION['cantidad_rifas'];
$total = $cantidad * $precio_unitario;
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Reserva de Números</h2>
    <a href="panel.php">Volver al Panel</a>
    <br><br>
    
    <p><strong>Números reservados:</strong> <?= $cantidad ?></p>
    <p><strong>Precio por número:</strong> $<?= number_format($precio_unitario, 0, ',', '.') ?></p>
    <p><strong>Total a pagar:</strong> $<?= number_format($total, 0, ',', '.') ?></p>
    
    <form method="POST">
        <button type="submit" name="accion" value="agregar">Agregar Número (+)</button>
        <button type="submit" name="accion" value="quitar" <?= $cantidad <= 0 ? 'disabled' : '' ?>>Quitar Número (-)</button>
    </form>
</body>
</html>