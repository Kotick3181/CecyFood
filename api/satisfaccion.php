<?php
session_start();

include("../config/conexion.php");

header("Content-Type: application/json");

if (!isset($_SESSION['usuario'])) {

    echo json_encode([
        "success" => false,
        "message" => "Sesión no válida"
    ]);

    exit();
}

$pedido_id = intval($_POST["pedido_id"]);
$calificacion = intval($_POST["calificacion"]);
$comentario = trim($_POST["comentario"]);

$usuario_id = $_SESSION["usuario"];


/*
    Evitar que el usuario califique
    dos veces el mismo pedido
*/

$consulta = $conn->prepare("
SELECT id
FROM satisfaccion
WHERE pedido_id = ?
AND usuario_id = ?
");

$consulta->bind_param(
    "ii",
    $pedido_id,
    $usuario_id
);

$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Este pedido ya fue calificado."
    ]);

    exit();
}


/*
    Guardar satisfacción
*/

$stmt = $conn->prepare("
INSERT INTO satisfaccion
(
    pedido_id,
    usuario_id,
    calificacion,
    comentario
)
VALUES
(
    ?,
    ?,
    ?,
    ?
)
");

$stmt->bind_param(
    "iiis",
    $pedido_id,
    $usuario_id,
    $calificacion,
    $comentario
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "No se pudo guardar la satisfacción."
    ]);

}