<?php

include("../config/conexion.php");

$nombre = trim($_POST['nombre']);
$numero = trim($_POST['numero_control']);

$password = $_POST['password'];
$confirmar = $_POST['confirmar'];

if ($password != $confirmar) {
    die("Las contraceñas no coinciden");
}

$sql = "SELECT id
FROM usuarios
WHERE numero_control=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $numero);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("Ya esxiste ese numero de control");
}

$passwordHash =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );

$sql = "INSERT INTO usuarios(
nombre,
numero_control,
password
)
VALUES (?,?,?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sss",
    $nombre,
    $numero,
    $passwordHash
);

if ($stmt->execute()) {

    header("location: login.php");
} else {
    echo "Error al registrar";
}
