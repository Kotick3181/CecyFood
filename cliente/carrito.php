<?php

include("../config/auth.php");
include("../config/conexion.php");

$carrito = $_SESSION['carrito'] ?? [];

$total = 0;

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>
            Mi Carrito
        </h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="carrito-container">

        <?php
        if (empty($carrito)) {

            echo "
                <div class='carrito-vacio'>
                    <h2>🛒 Tu carrito está vacío</h2>
                    <p>Agrega productos desde el menú.</p>
                </div>
                ";
        } else {

            foreach ($carrito as $id => $cantidad) {

                $sql = $conn->query(
                    "SELECT * FROM productos
                    WHERE id = $id"
                );

                $producto =
                    $sql->fetch_assoc();

                $subtotal =
                    $producto['precio'] *
                    $cantidad;

                $total += $subtotal;

        ?>

                <div class="item-carrito">

                    <img
                        src="../assets/img/productos/<?php echo $producto['imagen']; ?>"
                        alt="producto">

                    <div class="info-carrito">

                        <h3>
                            <?php echo $producto['nombre']; ?>
                        </h3>

                        <p class="precio">
                            $<?php echo $producto['precio']; ?>
                        </p>

                        <div class="controles-carrito">

                            <button
                                class="btn-cantidad"
                                onclick="
                actualizar(
                <?php echo $id; ?>,
                'restar'
                )">
                                -
                            </button>

                            <span class="cantidad">
                                <?php echo $cantidad; ?>
                            </span>

                            <button
                                class="btn-cantidad"
                                onclick="
                actualizar(
                <?php echo $id; ?>,
                'sumar'
                )">
                                +
                            </button>

                        </div>

                    </div>

                    <div class="acciones-carrito">

                        <p class="subtotal">

                            $<?php
                                echo number_format(
                                    $subtotal,
                                    2
                                );
                                ?>

                        </p>

                        <button
                            class="btn-eliminar"
                            onclick="
            eliminar(
            <?php echo $id; ?>
            )">

                            🗑

                        </button>

                    </div>

                </div>

            <?php
            }
            ?>

            <div class="resumen-carrito">

                <h3>
                    Total a pagar
                </h3>

                <h2>

                    $<?php
                        echo number_format(
                            $total,
                            2
                        );
                        ?>

                </h2>

            </div>

            <div class="metodo-pago">

                <h3>💳 Método de pago</h3>

                <select id="metodoPago">

                    <option value="Efectivo">
                        💵 Efectivo
                    </option>

                    <option value="Tarjeta">
                        💳 Tarjeta
                    </option>

                </select>

            </div>

            <div id="datosTarjeta">

                <h3>💳 Pago con Tarjeta</h3>

                <input
                    type="text"
                    id="numeroTarjeta"
                    placeholder="Número de tarjeta">

                <input
                    type="text"
                    id="titular"
                    placeholder="Nombre del titular">

                <div class="fila-tarjeta">

                    <input
                        type="text"
                        id="vencimiento"
                        placeholder="MM/AA">

                    <input
                        type="password"
                        id="cvv"
                        placeholder="CVV">

                </div>

            </div>

            <button
                class="btn-confirmar"
                onclick="crearPedido()">

                Confirmar Pedido

            </button>

        <?php } ?>

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
    <script src="../assets/js/carrito_pagina.js"></script>

</body>

</html>