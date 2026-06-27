<?php

include("../config/auth.php");
include("../config/conexion.php");

$id = intval($_GET['id']);

$detalles =
    $conn->query(

        "SELECT
detalle_pedido.*,
productos.nombre,
productos.imagen
FROM detalle_pedido
INNER JOIN productos
ON detalle_pedido.producto_id = productos.id
WHERE detalle_pedido.pedido_id = $id"
    );

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();

$usuario =
    $_SESSION['usuario'];


?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Pedido</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Detalle Pedido</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="contenedor">

        <?php

        while (
            $item =
            $detalles->fetch_assoc()
        ) {

        ?>

            <div class="detallepedido-card">

                <img
                    src="../assets/img/productos/<?php echo $item['imagen']; ?>"
                    alt="producto">

                <div class="info-producto">

                    <h3>
                        <?php echo $item['nombre']; ?>
                    </h3>

                    <p>
                        Cantidad:
                        <?php echo $item['cantidad']; ?>
                    </p>

                    <p class="subtotaldetalle">

                        $<?php
                            echo number_format(
                                $item['subtotal'],
                                2
                            );
                            ?>

                    </p>

                </div>

            </div>

        <?php  } ?>

    </div>

    <script src="../assets/js/app.js"></script>

</body>

</html>