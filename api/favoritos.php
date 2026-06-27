<?php
session_start();
require_once("../config/conexion.php");

header("Content-Type: application/json");

if (!isset($_SESSION['usuario'])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Debes iniciar sesión"
    ]);
    exit();
}

$usuario_id = $_SESSION['usuario'];
$producto_id = intval($_POST['producto_id']);

$verificar = $conn->prepare("
SELECT id
FROM favoritos
WHERE usuario_id = ?
AND producto_id = ?
");

$verificar->bind_param(
    "ii",
    $usuario_id,
    $producto_id
);

$verificar->execute();

$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {

    $eliminar = $conn->prepare("
    DELETE FROM favoritos
    WHERE usuario_id = ?
    AND producto_id = ?
    ");

    $eliminar->bind_param(
        "ii",
        $usuario_id,
        $producto_id
    );

    $eliminar->execute();

    echo json_encode([
        "success" => true,
        "accion" => "eliminado"
    ]);

} else {

    $insertar = $conn->prepare("
    INSERT INTO favoritos(
        usuario_id,
        producto_id
    )
    VALUES(
        ?,
        ?
    )
    ");

    $insertar->bind_param(
        "ii",
        $usuario_id,
        $producto_id
    );

    $insertar->execute();

    echo json_encode([
        "success" => true,
        "accion" => "agregado"
    ]);
}
?>