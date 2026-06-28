<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

// PROMEDIO DE CALIFICACIONES

$promedio = $conn->query("
SELECT AVG(calificacion) AS promedio
FROM satisfaccion
")->fetch_assoc();

$promedio = $promedio['promedio'] ?? 0;

// TOTAL DE OPINIONES

$totalOpiniones = $conn->query("
SELECT COUNT(*) AS total
FROM satisfaccion
")->fetch_assoc();

$totalOpiniones = $totalOpiniones['total'];

// PORCENTAJE DE OPINIONES POSITIVAS
// (4 y 5 estrellas)

$positivas = $conn->query("
SELECT COUNT(*) AS total
FROM satisfaccion
WHERE calificacion >= 4
")->fetch_assoc()['total'];

if ($totalOpiniones > 0) {

    $porcentajePositivas =
        round(
            ($positivas / $totalOpiniones) * 100
        );

} else {

    $porcentajePositivas = 0;

}

// LISTA DE OPINIONES

$opiniones = $conn->query("

SELECT

    satisfaccion.*,

    pedidos.id AS pedido,

    usuarios.nombre

FROM satisfaccion

INNER JOIN pedidos
ON satisfaccion.pedido_id = pedidos.id

INNER JOIN usuarios
ON pedidos.usuario_id = usuarios.id

ORDER BY satisfaccion.fecha DESC

");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de satisfaccion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="topbar">

        <h2>Opiniones de usuarios</h2>

        <button id="themeBtn">
            🌙
        </button>

    </header>

    <h2>⭐ Opiniones de los usuarios</h2>

    <div class="reportes-resumen">

        <div class="card-admin">
            <h3>⭐ Promedio</h3>
            <p><?php echo number_format($promedio, 1); ?></p>
        </div>

        <div class="card-admin">
            <h3>💬 Opiniones</h3>
            <p><?php echo $totalOpiniones; ?></p>
        </div>

        <div class="card-admin">
            <h3>😊 Positivas</h3>
            <p><?php echo $porcentajePositivas; ?>%</p>
        </div>

    </div>

    <div class="filtros-reportes">

        <button onclick="filtrarOpiniones('all',this)" class="activo">
            Todas
        </button>

        <button onclick="filtrarOpiniones('5',this)">
            ⭐⭐⭐⭐⭐
        </button>

        <button onclick="filtrarOpiniones('4',this)">
            ⭐⭐⭐⭐
        </button>

        <button onclick="filtrarOpiniones('3',this)">
            ⭐⭐⭐
        </button>

        <button onclick="filtrarOpiniones('2',this)">
            ⭐⭐
        </button>

        <button onclick="filtrarOpiniones('1',this)">
            ⭐
        </button>

    </div>

    <div class="opiniones-grid">

        <?php while ($o = $opiniones->fetch_assoc()) { ?>

            <div
                class="opinion-card"
                data-rating="<?php echo $o['calificacion']; ?>">

                <div class="opinion-header">

                    <div>

                        <h3>
                            👤 <?php echo $o['nombre']; ?>
                        </h3>

                        <span>
                            Pedido #<?php echo $o['pedido']; ?>
                        </span>

                    </div>

                    <div class="rating">

                        <?php

                        for ($i = 1; $i <= 5; $i++) {

                            echo $i <= $o['calificacion']
                                ? "⭐"
                                : "☆";
                        }

                        ?>

                    </div>

                </div>

                <p class="comentario">

                    "<?php echo $o['comentario']; ?>"

                </p>

                <div class="opinion-footer">

                    <span>

                        📅 <?php echo $o['fecha']; ?>

                    </span>

                </div>

            </div>

        <?php } ?>

    </div>

    <script src="../assets/js/app.js"></script>
    <script>
        function filtrarOpiniones(rating, boton) {

            document
                .querySelectorAll(".filtros-reportes button")
                .forEach(btn => btn.classList.remove("activo"));

            boton.classList.add("activo");

            document
                .querySelectorAll(".opinion-card")
                .forEach(card => {

                    if (rating == "all") {

                        card.style.display = "block";

                    } else {

                        card.style.display =
                            card.dataset.rating == rating ?
                            "block" :
                            "none";

                    }

                });

        }
    </script>

</body>

</html>