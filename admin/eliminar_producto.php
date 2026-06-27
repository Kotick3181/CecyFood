<?php

include "../config/conexion.php";

$id = (int)$_GET['id'];

$producto = $conn->query(
    "SELECT * FROM productos
    WHERE id = $id"
)->fetch_assoc();

if (isset($_POST['confirmar'])) {

    $conn->query(
        "DELETE FROM productos
        WHERE id = $id"
    );

    header("Location: productos.php");
    exit;
}

?>

<!DOCTYPE html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header class="topbar">

        <h2>Eliminar Producto</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="confirmar-card">

        <h2>⚠ Eliminar Producto</h2>

        <img src="../assets/img/productos/<?php echo $producto['imagen']; ?>">

        <h3>
            <?php echo $producto['nombre']; ?>
        </h3>

        <p>
            ¿Deseas eliminar este producto?
        </p>

        <div class="botones-confirmacion">

            <a
                href="productos.php"
                class="btn-cancelar">

                Cancelar

            </a>

            <form method="POST">

                <button
                    type="submit"
                    name="confirmar"
                    class="btn-eliminar-producto">
                    🗑 Eliminar
                </button>

            </form>

        </div>

    </div>

    <script src="../assets/js/app.js"></script>

</body>

</html>