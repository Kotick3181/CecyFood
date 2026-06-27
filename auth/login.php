<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header(
        "Location: ../cliente/menu.php"
    );
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CecyFood</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="manifest" href="/CecyFood/manifest.json">
    <meta name="theme-color" content="#8B4513">

</head>

<body>
    <div class="auth-container">
        <div class="logo-placeholder">
            <img
                src="../assets/img/logo.jpeg"
                class="logo-app"
                alt="logo">
        </div>

        <h2>Iniciar Sesion</h2>

        <form id="loginForm">

            <input
                type="text"
                name="numero_control"
                id="numero_control"
                placeholder="Numero de Control"
                required>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Contraseña"
                required>

            <button type="submit">
                Entrar
            </button>

        </form>

        <a href="registro.php">
            Crear Cuenta
        </a>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/CecyFood/sw.js')
                .then(function(registration) {
                    console.log('SW registrado correctamente');
                })
                .catch(function(error) {
                    console.error('Error al registrar SW:', error);
                });
        }
        
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let datos = new FormData();
            datos.append("numero_control", document.getElementById("numero_control").value);
            datos.append("password", document.getElementById("password").value);

            fetch("validar_login.php", {
                    method: "POST",
                    body: datos
                })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {

                        if (data.rol === "admin") {
                            window.location.href = "../admin/dashboard.php";
                        } else {
                            window.location.href = "../cliente/menu.php";
                        }

                    } else {
                        mostrarError(data.message);
                    }

                })
                .catch(() => {
                    mostrarError("Error de conexión");
                });
        });

        function mostrarError(msg) {

            let error = document.getElementById("error");

            if (!error) {
                error = document.createElement("div");
                error.id = "error";
                error.className = "error-login";
                document.querySelector("form").prepend(error);
            }

            error.innerText = "❌ " + msg;
        }
    </script>
</body>

</html>