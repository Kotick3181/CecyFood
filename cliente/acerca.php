<?php

include("../config/auth.php");
include("../config/conexion.php");

$version_app = "1.0.0";
$ultima_actualizacion = "Junio 2026";

$php_version = PHP_VERSION;
$mysql_version = $conn->server_info;

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Acerca de</title>

    <link rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

    <header class="topbar">

    <a href="perfil.php" class="btn-back">
        ←
    </a>

    <h2>Acerca de</h2>

    <button id="themeBtn">
        🌙
    </button>

</header>

<div class="contenedor">

    <div class="card-acerca">

        <img
            src="../assets/img/logo.jpeg"
            class="logo-acerca"
            alt="Logo">

        <h2>CecyFood</h2>

        <p class="subtitulo">
            Tu cafetería escolar en tu bolsillo
        </p>

        <span class="version">
            Versión <?php echo $version_app; ?>
        </span>

    </div>

    <div class="info-card">

        <h3>📖 Acerca de</h3>

        <p>

            CecyFood es una aplicación desarrollada para facilitar
            la compra de alimentos dentro de la cafetería del
            CECyTEM Plantel Coacalco.

            Permite consultar el menú, realizar pedidos,
            guardar productos favoritos y dar seguimiento al
            estado de cada orden desde cualquier dispositivo.

        </p>

    </div>

    <div class="info-card">

        <h3>💻 Información de la aplicación</h3>

        <div class="fila-info">

            <span>📱 Versión</span>

            <strong><?php echo $version_app; ?></strong>

        </div>

        <div class="fila-info">

            <span>🆕 Última actualización</span>

            <strong><?php echo $ultima_actualizacion; ?></strong>

        </div>

        <div class="fila-info">

            <span>🐘 PHP</span>

            <strong><?php echo $php_version; ?></strong>

        </div>

        <div class="fila-info">

            <span>🗄️ MySQL</span>

            <strong><?php echo $mysql_version; ?></strong>

        </div>

        <div class="fila-info">

            <span>📱 Plataforma</span>

            <strong>PWA</strong>

        </div>

        <div class="fila-info">

            <span>🔐 Seguridad</span>

            <strong>Contraseñas cifradas</strong>

        </div>

    </div>

    <div class="info-card">

        <h3>👨‍💻 Desarrolladores</h3>

        <p>Fabian García Solís</p>

        <p>Ángel Lona Flores</p>

    </div>

    <div class="info-card">

        <h3>🏫 Institución</h3>

        <p>

            CECyTEM Plantel Coacalco

        </p>

        <p>

            Proyecto desarrollado como parte de la formación
            académica de la carrera de Programación.

        </p>

    </div>

    <div class="info-card">

        <h3>🔒 Aviso de privacidad</h3>

        <p>

            La información proporcionada por los usuarios es utilizada
            únicamente para el funcionamiento de la aplicación y la
            gestión de pedidos dentro de la cafetería escolar.

        </p>

    </div>

    <div class="info-card">

        <h3>❤️ Gracias por utilizar CecyFood</h3>

        <p>

            Nuestro objetivo es hacer más rápida, organizada y cómoda
            la experiencia de compra dentro de la cafetería escolar.

        </p>

    </div>

</div>

</div>

<script src="../assets/js/app.js"></script>

</body>

</html>