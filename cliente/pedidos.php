<?php

include("../config/auth.php");
include("../config/conexion.php");

$usuario =
    $_SESSION['usuario'];

$pedidos = $conn->query("
SELECT 
    pedidos.*,
    (
        SELECT COUNT(*) 
        FROM satisfaccion 
        WHERE satisfaccion.pedido_id = pedidos.id
    ) AS ya_calificado
FROM pedidos
WHERE usuario_id = $usuario
ORDER BY fecha DESC
");

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
    <title>Pedidos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Mis Pedidos</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="contenedor">

        <?php

        while (
            $p =
            $pedidos->fetch_assoc()
        ) {
        ?>

            <?php

            $clase = "";

            switch ($p['estado']) {

                case "Pendiente":
                    $clase = "estado-pendiente";
                    break;

                case "Preparando":
                    $clase = "estado-preparando";
                    break;

                case "Listo":
                    $clase = "estado-listo";
                    break;

                case "Entregado":
                    $clase = "estado-entregado";
                    break;
            }

            ?>

            <div class="pedido-card <?php echo $clase; ?>">

                <h3>
                    Pedido #<?php
                            echo $p['id'];
                            ?>
                </h3>

                <p class="fecha-pedido">

                    📅 <?php echo $p['fecha']; ?>

                </p>

                <div class="estado-badge">

                    <?php

                    if ($p['estado'] == "Pendiente") {
                        echo "🟠 Pendiente";
                    }

                    if ($p['estado'] == "Preparando") {
                        echo "🟡 Preparando";
                    }

                    if ($p['estado'] == "Listo") {
                        echo "🟢 Listo";
                    }

                    if ($p['estado'] == "Entregado") {
                        echo "🔵 Entregado";
                    }

                    ?>

                </div>

                <p>
                    Total:
                    $<?php
                        echo $p['total'];
                        ?>
                </p>

                <?php

                $avance = 1;

                if ($p['estado'] == "Preparando") {
                    $avance = 2;
                }

                if ($p['estado'] == "Listo") {
                    $avance = 3;
                }

                if ($p['estado'] == "Entregado") {
                    $avance = 4;
                }

                ?>

                <div class="progreso">

                    <div class="paso <?php if ($avance >= 1) echo 'activo'; ?>"></div>

                    <div class="paso <?php if ($avance >= 2) echo 'activo'; ?>"></div>

                    <div class="paso <?php if ($avance >= 3) echo 'activo'; ?>"></div>

                    <div class="paso <?php if ($avance >= 4) echo 'activo'; ?>"></div>

                </div>

                <div class="etapas">

                    <span>Pendiente</span>

                    <span>Preparando</span>

                    <span>Listo</span>

                    <span>Entregado</span>

                </div>

                <p>

                    <?php

                    if (
                        $p['metodo_pago']
                        == "Efectivo"
                    ) {
                        echo "💵 Efectivo";
                    } else {
                        echo "💳 Tarjeta";
                    }

                    ?>

                </p>

                <div class="acciones-pedido">

                    <a
                        class="btn-detalle"
                        href="detalle_pedido.php?id=<?php echo $p['id']; ?>">

                        👁 Ver Detalle

                    </a>

                    <a
                        class="btn-ticket"
                        href="ticket.php?id=<?php echo $p['id']; ?>"
                        target="_blank">

                        📄 Ticket

                    </a>

                </div>

                <?php if ($p['estado'] == "Entregado" && $p['ya_calificado'] == 0) { ?>

                    <button
                        class="btn-satisfaccion"
                        onclick="abrirSatisfaccion(<?php echo $p['id']; ?>)">

                        ⭐ Calificar pedido

                    </button>

                <?php } ?>

                <?php if ($p['ya_calificado'] == 1) { ?>

                    <p class="ya-calificado">
                        ⭐ Ya calificaste este pedido
                    </p>

                <?php } ?>

            </div>

    </div>

    <div id="modalSatisfaccion" class="modal">

        <div class="modal-content">

            <h3>¿Qué te pareció tu pedido?</h3>

            <input type="hidden" id="pedido_id">

            <div class="estrellas">
                <span onclick="setRating(1)">⭐</span>
                <span onclick="setRating(2)">⭐</span>
                <span onclick="setRating(3)">⭐</span>
                <span onclick="setRating(4)">⭐</span>
                <span onclick="setRating(5)">⭐</span>
            </div>

            <textarea id="comentario" placeholder="Comentario opcional"></textarea>

            <button onclick="enviarSatisfaccion()">
                Enviar
            </button>

            <button onclick="cerrarModal()">
                Cancelar
            </button>

        </div>

    </div>

<?php } ?>

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

<div id="toast"></div>


<script src="../assets/js/app.js"></script>
<script>
    let rating = 0;

    function abrirSatisfaccion(id) {
        document.getElementById("pedido_id").value = id;
        document.getElementById("modalSatisfaccion").style.display = "flex";
    }

    function cerrarModal() {
        document.getElementById("modalSatisfaccion").style.display = "none";
    }

    function setRating(valor) {
        rating = valor;
    }

    function enviarSatisfaccion() {

        let pedido_id = document.getElementById("pedido_id").value;
        let comentario = document.getElementById("comentario").value;

        let datos = new FormData();
        datos.append("pedido_id", pedido_id);
        datos.append("calificacion", rating);
        datos.append("comentario", comentario);

        fetch("../api/satisfaccion.php", {
                method: "POST",
                body: datos
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {
                    mostrarToast("⭐ ¡Gracias por tu opinión!");
                    cerrarModal();
                } else {
                    mostrarToast("❌ No se pudo enviar tu opinión.");
                }

            });
    }

    function mostrarToast(mensaje) {

    const toast = document.getElementById("toast");

    toast.innerHTML = mensaje;

    toast.classList.add("mostrar");

    setTimeout(() => {
        toast.classList.remove("mostrar");
    }, 3000);

}
</script>

</body>

</html>