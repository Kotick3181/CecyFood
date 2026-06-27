<?php

include("../config/admin_auth.php");
include("../config/conexion.php");

$id = $_POST['id'];
$estado = $_POST['estado'];

$stmt = $conn->prepare("
    UPDATE pedidos 
    SET estado = ? 
    WHERE id = ?
");

$stmt->bind_param("si", $estado, $id);
$stmt->execute();

echo json_encode(["success"=>true]);