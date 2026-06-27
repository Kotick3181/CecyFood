<?php

include("../config/auth.php");
include("../config/conexion.php");

$id = intval($_GET['id']);

$sql =
    $conn->query(
        "SELECT *
        FROM productos
        WHERE id=$id"
    );

$producto = $sql->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        <?php echo $producto['nombre']; ?>
    </title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <div class="detalle-producto">

        <img
            src="../assets/img/productos/<?php
                                            echo $producto['imagen'];
                                            ?>">

        <h1>
            <?php
            echo $producto['nombre'];
            ?>
        </h1>

        <p>
            <?php
            echo $producto['descripcion'];
            ?>
        </p>

        <h2>
            <?php
            echo $producto['precio'];
            ?>
        </h2>

        <button
            onclick="agregarCarrito(
        <?php echo $producto['id']; ?>
        )">
            Agregar al carrito
        </button>

    </div>

    <script src="../assets/js/carrito.js"></script>

</body>

</html>