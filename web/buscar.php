<?php
session_start();

if (!isset($_SESSION['web_auth']) || $_SESSION['web_auth'] !== true) {
    header('Location: index.php');
    exit;
}

$resultados = [];
$busqueda = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busqueda = strtolower(trim($_POST['busqueda'] ?? ''));
    $archivo = '../api/participantes.json';
    
    if (file_exists($archivo)) {
        $datos = json_decode(file_get_contents($archivo), true);
        
        if (is_array($datos)) {
            foreach ($datos as $participante) {
                $nombre = strtolower($participante['nombre'] ?? '');
                $apellido = strtolower($participante['apellido'] ?? '');
                
                if (strpos($nombre, $busqueda) !== false || strpos($apellido, $busqueda) !== false) {
                    $resultados[] = $participante;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Buscar Participantes</h2>
    <a href="panel.php">Volver al Panel</a>
    <br><br>
    
    <form method="POST">
        <label>Nombre o Apellido:</label>
        <input type="text" name="busqueda" value="<?= htmlspecialchars($busqueda) ?>" required>
        <button type="submit">Buscar</button>
    </form>
    
    <br>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if (count($resultados) > 0): ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>N° Rifa</th>
                </tr>
                <?php foreach ($resultados as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['id']) ?></td>
                        <td><?= htmlspecialchars($r['nombre']) ?></td>
                        <td><?= htmlspecialchars($r['apellido']) ?></td>
                        <td><?= htmlspecialchars($r['numero_rifa']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No se encontraron resultados para "<?= htmlspecialchars($busqueda) ?>".</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>