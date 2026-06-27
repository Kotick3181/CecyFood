<?php

include("../config/auth.php");
include("../config/conexion.php");

$id = $_SESSION['usuario'];

$sql =
    $conn->query(
        "SELECT *
    FROM usuarios
    WHERE id = $id"
    );

$usuario =
    $sql->fetch_assoc();

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header class="topbar">

        <h2>Mi perfil</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="perfil-card">

        <div class="avatar">

            👤

        </div>

        <h2>

            <?php
            echo $usuario['nombre'];
            ?>

        </h2>

        <div class="info-perfil">

            <p>

                🆔
                <?php
                echo $usuario['numero_control'];
                ?>

            </p>

            <p>

                🎓
                <?php
                echo ucfirst(
                    $usuario['rol']
                );
                ?>

            </p>

        </div>

        <div class="acciones-perfil">

            <a
                class="btn-perfil"
                href="configuracion.php">

                ⚙ Configuración

            </a>

            <a
                class="btn-perfil"
                href="acerca.php">

                ℹ Acerca de la App

            </a>

            <a
                class="btn-logout"
                href="../auth/logout.php">

                🚪 Cerrar Sesión

            </a>

        </div>

    </div>

    <nav class="bottom-nav">

        <a href="menu.php" class="nav-item">

            <span class="nav-icon">🏠</span>

            <span class="nav-text">
                Inicio
            </span>

        </a>

        <a href="carrito.php" class="nav-item">

            <span class="nav-icon">🛒</span>

            <span class="nav-text">
                Carrito
            </span>

        </a>

        <a href="pedidos.php" class="nav-item">

            <span class="nav-icon">📦</span>

            <span class="nav-text">
                Pedidos
            </span>

        </a>

        <a href="favoritos.php" class="nav-item">

            <span class="nav-icon">❤️</span>

            <span class="nav-text">
                Favoritos
            </span>

            <span class="fav-badge">
                <?php echo $favoritos_count['total']; ?>
            </span>

        </a>

        <a href="perfil.php" class="nav-item">

            <span class="nav-icon">👤</span>

            <span class="nav-text">
                Perfil
            </span>

        </a>

    </nav>

    <script src="../assets/js/app.js"></script>

</body>

</html>