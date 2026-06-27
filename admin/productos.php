<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

$productos =
    $conn->query(
        "SELECT *
    FROM productos 
    ORDER BY id DESC"
    );

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Productos</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <input
        type="text"
        id="buscarProducto"
        placeholder="🔍 Buscar producto...">

    <div class="contenedor">

        <?php

        while (
            $p =
            $productos->fetch_assoc()
        ) {
        ?>

            <div class="producto-admin">

                <img
                    src="../assets/img/productos/<?php echo $p['imagen']; ?>"
                    alt="producto">

                <h3>

                    <?php
                    echo $p['nombre'];
                    ?>

                </h3>

                <p class="precio">

                    $<?php
                        echo number_format(
                            $p['precio'],
                            2
                        );
                        ?>

                </p>

                <p>
                    Stock:
                    <?php echo $p['stock']; ?>
                </p>

                <div class="acciones-admin">

                    <a
                        class="btn-editar"
                        href="editar_producto.php?id=<?php echo $p['id']; ?>">

                        ✏ Editar

                    </a>

                    <a
                        class="btn-eliminaradmin"
                        href="eliminar_producto.php?id=<?php echo $p['id']; ?>">

                        🗑 Eliminar

                    </a>

                </div>

            </div>
        <?php } ?>
    </div>
    <a class="btn-admin"
        href="nuevo_producto.php">
        Agregar producto
    </a>

    <script src="../assets/js/app.js"></script>

</body>

</html>