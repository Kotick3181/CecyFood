<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

$totalProductos =
    $conn->query(
        "SELECT COUNT(*) total
        FROM productos"
    )->fetch_assoc()['total'];

$totalUsuarios =
    $conn->query(
        "SELECT COUNT(*) total
        FROM usuarios"
    )->fetch_assoc()['total'];

$totalPedidos =
    $conn->query(
        "SELECT COUNT(*) total
        FROM pedidos"
    )->fetch_assoc()['total'];

$ventas =
    $conn->query(
        "SELECT 
        SUM(total) AS total
        FROM pedidos"
    )->fetch_assoc();

$masVendidos =
    $conn->query("
            SELECT 
            p.nombre,
            SUM(dp.cantidad) AS vendidos

            FROM detalle_pedido dp

            INNER JOIN productos p
            ON dp.producto_id = p.id

            GROUP BY p.id

            ORDER BY vendidos DESC

            LIMIT 5
        ");

$topClientes =
    $conn->query("
            SELECT
            u.nombre,
            COUNT(p.id) pedidos
            
            FROM usuarios u
            
            INNER JOIN pedidos p
            ON u.id = p.usuario_id
            
            GROUP BY u.id
            
            ORDER BY pedidos DESC
            
            LIMIT 5
            ");

$pendientes = $conn->query("
        SELECT COUNT(*) AS total
        FROM pedidos
        WHERE estado = 'Pendiente'
        ");

$pedidosPendientes =
    $pendientes->fetch_assoc()['total'];

$topFavoritos = $conn->query("
        SELECT
            productos.nombre,
            COUNT(*) AS favoritos
        FROM favoritos

        INNER JOIN productos
        ON favoritos.producto_id = productos.id

        GROUP BY productos.id

        ORDER BY favoritos DESC

        LIMIT 5
    ");

$estadisticasEstados = $conn->query("
        SELECT estado, COUNT(*) as total
        FROM pedidos
        GROUP BY estado
    ");

$labelsEstados = [];
$datosEstados = [];

while ($fila = $estadisticasEstados->fetch_assoc()) {

    $labelsEstados[] = $fila['estado'];
    $datosEstados[] = $fila['total'];
}



?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <div class="admin-title">

            <h2>👋 Bienvenido, Administrador</h2>

            <p class="sub-admin">
                Administra la cafetería en tiempo real
            </p>

        </div>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <div class="quick-actions">

        <a href="productos.php" class="action-card">
            📦 Productos
        </a>

        <a href="pedidos.php" class="action-card">
            🛒 Pedidos
        </a>

        <a href="nuevo_producto.php" class="action-card">
            ➕ Nuevo producto
        </a>

        <a href="reportes.php" class="action-card">
            📊 Reportes
        </a>

    </div>

    <div class="dashboard-layout">
        <div class="dashboard">

            <div class="card-admin productos">
                <h3>📦 Productos</h3>
                <p><?php echo $totalProductos; ?></p>
                <p id="productosCount">0</p>
            </div>

            <div class="card-admin usuarios">
                <h3>👥 Usuarios</h3>
                <p><?php echo $totalUsuarios; ?></p>
                <p id="usuariosCount">0</p>
            </div>

            <div class="card-admin pedidos">
                <h3>🛒 Pedidos</h3>
                <p><?php echo $totalPedidos; ?></p>
                <p id="pedidosCount">0</p>
            </div>

            <div class="card-admin ventas">
                <h3>💰 Ventas</h3>
                <p>$<?php echo number_format($ventas['total'] ?? 0, 2); ?></p>
                <p id="ventasCount">0</p>
            </div>

            <div class="card-admin pendientes">
                <h3>⏳ Pendientes</h3>
                <p><?php echo $pedidosPendientes; ?></p>
                <p id="pendientesCount">0</p>
            </div>

            <div class="card-admin lista">

                <h3>❤️ Top Favoritos</h3>

                <?php while ($f = $topFavoritos->fetch_assoc()) { ?>

                    <div class="item-lista">
                        <span><?php echo $f['nombre']; ?></span>
                        <strong><?php echo $f['favoritos']; ?></strong>
                    </div>

                <?php } ?>

            </div>

            <div class="card-admin lista">

                <h3>🔥 Top Productos</h3>

                <?php while ($m = $masVendidos->fetch_assoc()) { ?>

                    <div class="item-lista">
                        <span><?php echo $m['nombre']; ?></span>
                        <strong><?php echo $m['vendidos']; ?></strong>
                    </div>

                <?php } ?>

            </div>

            <div class="card-admin lista">

                <h3>🏆 Top Clientes</h3>

                <?php while ($c = $topClientes->fetch_assoc()) { ?>

                    <div class="item-lista">
                        <span><?php echo $c['nombre']; ?></span>
                        <strong><?php echo $c['pedidos']; ?> pedidos</strong>
                    </div>

                <?php } ?>

            </div>

        </div>

        <div class="grafica-container">

            <h2>
                📊 Pedidos por Estado
            </h2>

            <canvas id="graficaEstados"></canvas>

        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const estados = <?php
                        echo json_encode($labelsEstados);
                        ?>;

        const cantidades = <?php
                            echo json_encode($datosEstados);
                            ?>;

        new Chart(
            document.getElementById(
                'graficaEstados'
            ), {

                type: 'doughnut',

                data: {

                    labels: estados,

                    datasets: [{

                        label: 'Pedidos',

                        data: cantidades

                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }


            }
        )

        let prevPedidos = 0;

        function animarContador(id, nuevoValor) {
            const el = document.getElementById(id);
            let actual = parseInt(el.innerText) || 0;

            let intervalo = setInterval(() => {
                if (actual < nuevoValor) actual++;
                else if (actual > nuevoValor) actual--;
                else clearInterval(intervalo);

                el.innerText = actual;
            }, 20);
        }

        function cargarDashboard() {

            fetch("../api/dashboard_data.php")
                .then(res => res.json())
                .then(data => {

                    animarContador("productosCount", data.productos);
                    animarContador("usuariosCount", data.usuarios);
                    animarContador("pedidosCount", data.pedidos);
                    animarContador("ventasCount", Math.round(data.ventas));
                    animarContador("pendientesCount", data.pendientes);

                    // 🔴 ALERTA DE NUEVOS PEDIDOS
                    if (data.pedidos > prevPedidos) {
                        mostrarToast("🔔 Nuevo pedido recibido");
                    }

                    prevPedidos = data.pedidos;

                });

        }

        // primera carga
        cargarDashboard();

        // auto refresh cada 10s
        setInterval(cargarDashboard, 10000);

        function mostrarToast(msg) {
            const toast = document.getElementById("toast");
            toast.innerText = msg;
            toast.classList.add("mostrar");

            setTimeout(() => {
                toast.classList.remove("mostrar");
            }, 3000);
        }
    </script>

    <script src="../assets/js/app.js"></script>
</body>

</html>