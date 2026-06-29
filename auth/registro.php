<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: ../cliente/menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | CecyFood</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="auth-container">

        <div class="logo-placeholder">
             <img
                src="../assets/img/logo.jpeg"
                class="logo-app"
                alt="logo">
        </div>

        <h2>Crear Cuenta</h2>

        <form action="procesar_registro.php" method="post">

            <input
                type="text"
                name="nombre"
                placeholder="Nombre Completo"
                required>

            <input
                type="text"
                name="numero_control"
                placeholder="Numero de Control"
                required>

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required>

            <input
                type="password"
                name="confirmar"
                placeholder="Confirmar contraseña"
                required>

            <button type="submit">
                Registrarse
            </button>

        </form>

        <a href="login.php">
            Ya tengo cuenta
        </a>

    </div>

</body>

</html>