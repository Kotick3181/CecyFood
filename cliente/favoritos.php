<?php
session_start();

require_once("../config/conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario'];

$sql = $conn->prepare("
SELECT
    productos.*
FROM favoritos
INNER JOIN productos
ON favoritos.producto_id = productos.id
WHERE favoritos.usuario_id = ?
");

$sql->bind_param(
    "i",
    $usuario_id
);

$sql->execute();

$favoritos = $sql->get_result();

$usuario_id = $_SESSION['usuario'];

$favoritos_count = $conn->query("
SELECT COUNT(*) AS total
FROM favoritos
WHERE usuario_id = $usuario_id
")->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Mis Favoritos
    </title>

    <link rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>
    <header class="topbar">

        <h2>Mis favoritos</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>
    <div class="productos">

        <?php
        if ($favoritos->num_rows > 0):
        ?>

            <?php
            while (
                $producto =
                $favoritos->fetch_assoc()
            ):
            ?>

                <div class="card">

                    <a
                        href="detalle.php?id=<?php echo $producto['id']; ?>">

                        <img
                            src="../assets/img/productos/<?php echo $producto['imagen']; ?>"
                            alt="producto">

                        <h3>
                            <?php echo $producto['nombre']; ?>
                        </h3>

                        <p>
                            $<?php echo $producto['precio']; ?>
                        </p>

                    </a>

                    <button
                        class="btn-eliminar-favorito"
                        onclick="eliminarFavorito(
<?php echo $producto['id']; ?>
)">

                        ❤️ Eliminar

                    </button>

                    <button
                        class="btn-carrito-favorito"
                        onclick="agregarCarrito(
    <?php echo $producto['id']; ?>
    )">

                        🛒 Agregar al carrito

                    </button>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="favoritos-vacio">

                <h2>

                    ❤️

                </h2>

                <h3>

                    No tienes favoritos

                </h3>

                <p>

                    Explora el menú y guarda tus productos favoritos.

                </p>

                <a
                    class="btn-menu"
                    href="menu.php">

                    🍔 Ir al Menú

                </a>

            </div>

        <?php endif; ?>

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
    <script src="../assets/js/carrito.js"></script>
    <script src="../assets/js/favoritos.js"></script>

</body>

</html>