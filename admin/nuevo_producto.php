<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre =
        $_POST['nombre'];

    $descripcion =
        $_POST['descripcion'];

    $precio =
        $_POST['precio'];

    $stock = 
        $_POST['stock'];

    $categoria =
        $_POST['categoria'];

    $imagen =
        $_POST['imagen'];

    $nombreImagen =
        time() . "_" .
        $_FILES['imagen']['name'];

    $rutaDestino =
        "../assets/img/productos/" .
        $nombreImagen;

    move_uploaded_file(
        $_FILES['imagen']['tmp_name'],
        $rutaDestino
    );

    $imagen = $nombreImagen;

    $stmt =
        $conn->prepare(
            "INSERT INTO productos(
    nombre,
    descripcion,
    precio,
    stock,
    imagen,
    categoria_id
    )
    VALUES(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
    )"
        );

    $stmt->bind_param(
        "ssdsi",
        $nombre,
        $descripcion,
        $precio,
        $imagen,
        $categoria
    );

    $stmt->execute();

    header(
        "Location: productos.php"
    );
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Nuevo Producto</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="form-card">

        <h2>
            ➕ Nuevo Producto
        </h2>

        <form
            method="POST"
            enctype="multipart/form-data">

            <label>
                Nombre del producto
            </label>

            <input
                name="nombre"
                placeholder="Ej. Hamburguesa Especial"
                required>

            <label>
                Precio
            </label>

            <input
                name="precio"
                type="number"
                step="0.01"
                placeholder="0.00"
                required>

            <label>Stock</label>

            <input
                type="number"
                name="stock"
                min="0"
                required>

            <label>
                Descripción
            </label>

            <textarea
                name="descripcion"
                placeholder="Describe el producto..."
                required>
        </textarea>

            <label>
                Categoría
            </label>

            <select
                name="categoria">

                <option value="1">🍔 Hamburguesas</option>
                <option value="2">🥪 Tortas</option>
                <option value="3">🌮 Tacos</option>
                <option value="4">🌯 Burritos</option>
                <option value="5">🧀 Molletes</option>
                <option value="6">🥤 Bebidas</option>

            </select>

            <label>
                Imagen
            </label>

            <input
                type="file"
                name="imagen"
                accept="image/*"
                required>

            <img
                id="preview"
                src=""
                alt="Vista previa">

            <button
                class="btn-guardar">

                💾 Guardar Producto

            </button>

        </form>

    </div>

    <script>
        const imagen =
            document.querySelector(
                'input[name="imagen"]'
            );

        const preview =
            document.getElementById(
                'preview'
            );

        imagen.addEventListener(
            'change',
            function(e) {

                preview.src =
                    URL.createObjectURL(
                        e.target.files[0]
                    );

                preview.style.display =
                    'block';
            });
    </script>

    <script src="../assets/js/app.js"></script>

</body>

</html>