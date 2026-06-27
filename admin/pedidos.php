<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

$pedidos =
    $conn->query(
        "SELECT
        pedidos.*,
        usuarios.nombre
        FROM pedidos
        INNER JOIN usuarios
        ON pedidos.usuario_id =
        usuarios.id
        ORDER BY pedidos.fecha DESC"
    );

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Pedidos</h2>

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

            <div class="admin-pedido-card <?php echo strtolower($p['estado']); ?>"
                id="pedido-<?php echo $p['id']; ?>">

                <div class="pedido-top">

                    <h3>Pedido #<?php echo $p['id']; ?></h3>

                    <span class="badge-estado">
                        <?php echo $p['estado']; ?>
                    </span>

                </div>

                <p class="pedido-fecha">📅 <?php echo $p['fecha']; ?></p>

                <p class="pedido-user">👤 Usuario: <?php echo $p['usuario_id']; ?></p>

                <p class="pedido-total">
                    💰 Total: <strong>$<?php echo $p['total']; ?></strong>
                </p>

                <div class="pedido-acciones">

                    <a href="../cliente/detalle_pedido.php?id=<?php echo $p['id']; ?>" class="btn-info">
                        👁 Detalle
                    </a>

                    <a href="../cliente/ticket.php?id=<?php echo $p['id']; ?>" target="_blank" class="btn-ticket">
                        📄 Ticket
                    </a>

                    <select onchange="cambiarEstado(<?php echo $p['id']; ?>, this.value)" class="select-estado">

                        <option <?php if ($p['estado'] == "Pendiente") echo "selected"; ?>>Pendiente</option>
                        <option <?php if ($p['estado'] == "Preparando") echo "selected"; ?>>Preparando</option>
                        <option <?php if ($p['estado'] == "Listo") echo "selected"; ?>>Listo</option>
                        <option <?php if ($p['estado'] == "Entregado") echo "selected"; ?>>Entregado</option>

                    </select>

                </div>

            </div>
        <?php } ?>

    </div>

    <div id="toast" class="toast"></div>

    <script src="../assets/js/app.js"></script>
    <script>
        function cambiarEstado(id, estado) {

            let datos = new FormData();
            datos.append("id", id);
            datos.append("estado", estado);

            fetch("../api/actualizar_estado.php", {
                    method: "POST",
                    body: datos
                })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {
                        mostrarToast("✅ Estado actualizado");
                    } else {
                        mostrarToast("❌ Error al actualizar");
                    }

                });

        }

        let estadosPrevios = {};

        function cargarEstados() {

            fetch("../api/pedidos_estado.php")
                .then(res => res.json())
                .then(data => {

                    data.forEach(pedido => {

                        const card = document.getElementById("pedido-" + pedido.id);

                        if (!card) return;

                        const badge = card.querySelector(".badge-estado");

                        const estadoAnterior = estadosPrevios[pedido.id];

                        // si cambió el estado
                        if (estadoAnterior && estadoAnterior !== pedido.estado) {

                            badge.innerText = pedido.estado;

                            // actualizar color de clase
                            card.classList.remove(
                                "pendiente",
                                "preparando",
                                "listo",
                                "entregado"
                            );

                            card.classList.add(pedido.estado.toLowerCase());

                            mostrarToast("🔄 Pedido #" + pedido.id + " actualizado");

                        }

                        estadosPrevios[pedido.id] = pedido.estado;

                    });

                });

        }

        // inicial
        cargarEstados();

        // cada 5 segundos
        setInterval(cargarEstados, 5000);
    </script>
</body>

</html>