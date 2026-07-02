<?php

include("../config/auth.php");
include("../config/conexion.php");

$id = intval($_GET['id']);

$id = intval($_GET['id']);

$producto = $conn->query("
SELECT
    productos.*,
    categorias.nombre AS categoria
FROM productos

INNER JOIN categorias
ON productos.categoria_id = categorias.id

WHERE productos.id = $id
")->fetch_assoc();

$relacionados = $conn->query("
SELECT *
FROM productos

WHERE categoria_id = {$producto['categoria_id']}
AND id != {$producto['id']}
AND stock > 0

ORDER BY RAND()

LIMIT 5
");

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();


?>

<!DOCTYPE html>
<html>

<head>

    <title>
        <?php echo $producto['nombre']; ?>
    </title>

    <link rel="stylesheet"
        href="../assets/css/style.css?v=<?php echo time(); ?>">

</head>

<body>
    <div id="toast"></div>
    <header class="topbar">

        <a href="menu.php" class="btn-volver">
            ← Regresar
        </a>

        <h2>Detalle del producto</h2>

        <div class="carrito-icon">
            <a href="carrito.php">
                🛒
                <span id="contadorCarrito">0</span>
            </a>
        </div>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="detalle-card">

        <img
            class="detalle-img"
            src="../assets/img/productos/<?php echo $producto['imagen']; ?>"
            alt="<?php echo $producto['nombre']; ?>">

        <div class="detalle-info">

            <span class="categoria-producto">
                🍽️ <?php echo $producto['categoria']; ?>
            </span>

            <h1>
                <?php echo $producto['nombre']; ?>
            </h1>

            <h2 class="precio">
                $<?php echo number_format($producto['precio'], 2); ?>
            </h2>

            <p class="descripcion">
                <?php echo $producto['descripcion']; ?>
            </p>

            <div class="datos-extra">

                <div class="dato">

                    📦

                    <?php

                    if ($producto['stock'] > 5) {

                        echo "Disponible (" . $producto['stock'] . ")";
                    } elseif ($producto['stock'] > 0) {

                        echo "Últimas " . $producto['stock'] . " piezas";
                    } else {

                        echo "Agotado";
                    }

                    ?>

                </div>

            </div>

            <div class="cantidad-box">

                <span>Cantidad</span>



                <div class="cantidad">

                    <button
                        class="btn-cantidad"
                        onclick="cambiarCantidad(-1)">
                        -
                    </button>

                    <span
                        id="cantidad">
                        1
                    </span>

                    <button
                        class="btn-cantidad"
                        onclick="cambiarCantidad(1)">
                        +
                    </button>

                </div>

            </div>



            <button

                class="btn-comprar"

                onclick="agregarCarrito(<?php echo $producto['id']; ?>)"

                <?php echo ($producto['stock'] <= 0) ? "disabled" : ""; ?>>

                <?php

                if ($producto['stock'] > 0) {

                    echo "🛒 Agregar al carrito";
                } else {

                    echo "Sin stock";
                }

                ?>

            </button>

        </div>

        <?php if ($relacionados->num_rows > 0) { ?>

            <div class="relacionados">

                <h2>
                    🍴 También te puede interesar
                </h2>

                <div class="relacionados-slider">

                    <?php while ($r = $relacionados->fetch_assoc()) { ?>

                        <div class="card-relacionado">

                            <a href="detalle.php?id=<?php echo $r['id']; ?>">

                                <img
                                    src="../assets/img/productos/<?php echo $r['imagen']; ?>"
                                    alt="<?php echo $r['nombre']; ?>">

                                <h4>

                                    <?php echo $r['nombre']; ?>

                                </h4>

                                <p>

                                    $<?php echo number_format($r['precio'], 2); ?>

                                </p>

                            </a>

                            <button

                                class="btn-relacionado"

                                onclick="agregarCarrito(
        <?php echo $r['id']; ?>,
        <?php echo $r['stock']; ?>
    )"

                                <?php echo ($r['stock'] <= 0) ? "disabled" : ""; ?>>

                                <?php

                                if ($r['stock'] > 0) {

                                    echo "🛒 Agregar";
                                } else {

                                    echo "🚫 Sin stock";
                                }

                                ?>

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
    

    <script>
        function cambiarCantidad(valor){

    const cantidad = document.getElementById("cantidad");

    let actual = parseInt(cantidad.innerText);

    let max = <?php echo $producto['stock']; ?>;

    actual += valor;

    if(actual < 1){
        actual = 1;
    }

    if(actual > max){
        actual = max;
    }

    cantidad.innerText = actual;

}
    </script>

</body>

</html>