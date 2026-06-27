<?php

include("../config/auth.php");
include("../config/conexion.php");

$usuario_id = $_SESSION['usuario'];

$productos = $conn->query("
SELECT 
    productos.*,
    categorias.nombre AS categoria,

    (
        SELECT COUNT(*)
        FROM favoritos
        WHERE favoritos.producto_id = productos.id
        AND favoritos.usuario_id = $usuario_id
    ) AS es_favorito

FROM productos
INNER JOIN categorias
ON productos.categoria_id = categorias.id
");

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();


$usuario_id = $_SESSION['usuario'];

$notificaciones = $conn->query("
SELECT COUNT(*) AS total
FROM pedidos
WHERE usuario_id = $usuario_id
AND estado = 'Listo'
");

$notificacion =
    $notificaciones->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CecyFood</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div id="toast"></div>

    <header class="topbar">
        <div>
            <div class="logo-mini">
                <img
                    src="../assets/img/logo.jpeg"
                    class="logo-app"
                    alt="logo">
            </div>
        </div>
        <div class="nombreapp">

            <h1>CecyFood</h1>

            <span>
                Cafetería Escolar
            </span>

        </div>
        <div class="carrito-icon">
            <a href="carrito.php">
                🛒<!--icono carrito-->
                <span id="contadorCarrito">
                    0
                </span>
            </a>
        </div>
        <button id="themeBtn">
            🌙
        </button>

    </header>
    <div class="busqueda">

        <input
            type="text"
            id="buscar"
            placeholder="Buscar comida...">
    </div>

    <div class="categorias">

        <button
            class="btn-categoria"
            onclick="filtrar('all',this)">
            Todos
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Comidas Completas',this)">
            🍽️ Comida completa
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Hamburguesas',this)">
            Hamburguesas
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Tortas',this)">
            Tortas
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Tacos',this)">
            Tacos
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Burritos',this)">
            Burritos
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Molletes',this)">
            Molletes
        </button>

        <button
            class="btn-categoria"
            onclick="filtrar('Bebidas',this)">
            Bebidas
        </button>
    </div>

    <?php if ($notificacion['total'] > 0) { ?>

        <div class="alerta-pedido">

            🔔 Tienes
            <?php echo $notificacion['total']; ?>

            pedido(s) listo(s) para recoger.

        </div>

    <?php } ?>

    <div class="productos-container">

        <?php

        $productosPorCategoria = [];

        while ($producto = $productos->fetch_assoc()) {
            $productosPorCategoria[$producto['categoria']][] = $producto;
        }

        ?>

        <?php foreach ($productosPorCategoria as $categoria => $items) { ?>

            <div class="categoria-bloque" data-categoria="<?php echo $categoria; ?>">

                <h2 class="titulo-categoria">
                    <?php echo $categoria; ?>
                </h2>

                <div class="carrusel-categoria">

                    <?php foreach ($items as $producto) { ?>

                        <div class="card producto"
                            data-categoria="<?php echo $producto['categoria']; ?>"
                            data-nombre="<?php echo strtolower($producto['nombre']); ?>">

                            <button
                                class="btn-favorito"
                                onclick="toggleFavorito(<?php echo $producto['id']; ?>)">

                                <?php echo $producto['es_favorito'] ? "❤️" : "🤍"; ?>

                            </button>

                            <a href="detalle.php?id=<?php echo $producto['id']; ?>">

                                <img src="../assets/img/productos/<?php echo $producto['imagen']; ?>">

                                <h3><?php echo $producto['nombre']; ?></h3>

                                <p>$<?php echo $producto['precio']; ?></p>

                                <p class="stock">
                                    Stock: <?php echo $producto['stock']; ?>
                                </p>

                            </a>

                            <button
                                onclick="agregarCarrito(<?php echo $producto['id']; ?>)"
                                <?php echo ($producto['stock'] <= 0) ? 'disabled' : ''; ?>
                                class="btn-agregar">

                                <?php echo ($producto['stock'] <= 0) ? 'Sin stock' : 'Agregar'; ?>

                            </button>

                        </div>

                    <?php } ?>

                </div>
            </div>

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

            <span class="nav-icon">
                🛒
            </span>

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
    <script src="../assets/js/carrito.js"></script>
    <script src="../assets/js/favoritos.js"></script>

</body>

</html>