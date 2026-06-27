<?php

include("../config/conexion.php");

$result = $conn->query("
    SELECT id, estado
    FROM pedidos
    ORDER BY id DESC
");

$pedidos = [];

while($row = $result->fetch_assoc()){
    $pedidos[] = $row;
}

echo json_encode($pedidos);