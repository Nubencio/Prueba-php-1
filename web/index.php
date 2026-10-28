<?php
session_start();
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $captcha_user = (int)($_POST['captcha'] ?? 0);

    if ($usuario === 'userupla' && $password === 'upla123' && $captcha_user === $_SESSION['captcha_res']) {
        $_SESSION['web_auth'] = true;
        header('Location: panel.php');
        exit;
    } else {
        $error = "Acceso denegado. Verifica tus datos o el cálculo.";
    }
}


$n1 = rand(1, 10);
$n2 = rand(1, 10);
$_SESSION['captcha_res'] = $n1 + $n2;
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Inicio de Sesión - Sistema Web</h2>
    <p style="color:red;"><?= $error ?></p>
    <form method="POST">
        Usuario: <input type="text" name="usuario" required><br><br>
        Contraseña: <input type="password" name="password" required><br><br>
        CAPTCHA: ¿Cuánto es <?= $n1 ?> + <?= $n2 ?>? <br>
        <input type="number" name="captcha" required><br><br>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>