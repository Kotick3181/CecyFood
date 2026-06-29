<?php

include "../config/conexion.php";

$id = $_GET['id'];

$producto = $conn->query(
    "SELECT * FROM productos
    WHERE id = $id"
)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];

    $stock = $_POST['stock'];

    $sql = "
UPDATE productos
SET
    nombre='$nombre',
    precio='$precio',
    descripcion='$descripcion',
    categoria_id='$categoria',
    stock='$stock'
WHERE id=$id
";

    $conn->query($sql);

    header("Location: productos.php");
    exit;
}

?>

<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar productos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Editar Productos</h2>

        <button id="themeBtn">
            🌙
        </button>
    </header>

    <div class="form-card">
        <h2>Editar Producto</h2>

        <form method="POST" class="form-editar">

            <label>Nombre</label>
            <input
                type="text"
                name="nombre"
                value="<?php echo $producto['nombre']; ?>"
                required>

            <label>Precio</label>
            <input
                type="number"
                step="0.01"
                name="precio"
                value="<?php echo $producto['precio']; ?>"
                required>

            <label>Descripción</label>
            <textarea
                name="descripcion"
                required><?php echo $producto['descripcion']; ?></textarea>

            <label>Categoría</label>

            <select name="categoria">

                <option value="1" <?php if ($producto['categoria_id'] == 1) echo "selected"; ?>>Hamburguesas</option>

                <option value="2" <?php if ($producto['categoria_id'] == 2) echo "selected"; ?>>Tortas</option>

                <option value="3" <?php if ($producto['categoria_id'] == 3) echo "selected"; ?>>Tacos</option>

                <option value="4" <?php if ($producto['categoria_id'] == 4) echo "selected"; ?>>Burritos</option>

                <option value="5" <?php if ($producto['categoria_id'] == 5) echo "selected"; ?>>Molletes</option>

                <option value="6" <?php if ($producto['categoria_id'] == 6) echo "selected"; ?>>Bebidas</option>

                <option value="7" <?php if ($producto['categoria_id'] == 7) echo "selected"; ?>>Comidas Completas</option>

            </select>

            <label>Stock</label>

            <input
                type="number"
                name="stock"
                value="<?php echo $producto['stock']; ?>"
                min="0">

            <div class="botones">

                <button type="submit" class="btn-guardar">
                    Guardar Cambios
                </button>

                <a href="productos.php" class="btn-cancelar">
                    Cancelar
                </a>

            </div>

        </form>
    </div>

    <script src="../assets/js/app.js"></script>

</body>

</html>