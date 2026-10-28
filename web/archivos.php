<?php
session_start();

if (!isset($_SESSION['web_auth']) || $_SESSION['web_auth'] !== true) {
    header('Location: index.php');
    exit;
}

$directorio = 'uploads/';
$archivos = [];


if (is_dir($directorio)) {

    $archivos = array_diff(scandir($directorio), array('.', '..'));
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Archivos Cargados</h2>
    <a href="panel.php">Volver al Panel</a>
    <br><br>
    
    <?php if (!empty($archivos)): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Nombre del Archivo</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($archivos as $archivo): ?>
                <tr>
                    <td><?= htmlspecialchars($archivo) ?></td>

                    <td><a href="<?= $directorio . htmlspecialchars($archivo) ?>" target="_blank">Ver archivo</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay archivos cargados en el sistema en este momento.</p>
    <?php endif; ?>
</body>
</html>