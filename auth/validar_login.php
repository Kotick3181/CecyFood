<?php
session_start();
include("../config/conexion.php");

$numero = $_POST['numero_control'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE numero_control=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero);
$stmt->execute();
$result = $stmt->get_result();

$response = ["success" => false];

if ($result->num_rows == 1) {

    $usuario = $result->fetch_assoc();

    if (password_verify($password, $usuario['password'])) {

        session_regenerate_id(true);

        $_SESSION['usuario'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        $response["success"] = true;
        $response["rol"] = $usuario['rol'];

    } else {
        $response["message"] = "Contraseña incorrecta";
    }

} else {
    $response["message"] = "Usuario no encontrado";
}

echo json_encode($response);