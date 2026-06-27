<?php

include("../config/conexion.php");

header('Content-Type: application/json');

$totalProductos = $conn->query("SELECT COUNT(*) as total FROM productos")->fetch_assoc()['total'];

$totalUsuarios = $conn->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc()['total'];

$totalPedidos = $conn->query("SELECT COUNT(*) as total FROM pedidos")->fetch_assoc()['total'];

$ventas = $conn->query("SELECT SUM(total) as total FROM pedidos")->fetch_assoc()['total'];

$pendientes = $conn->query("
    SELECT COUNT(*) as total 
    FROM pedidos 
    WHERE estado = 'Pendiente'
")->fetch_assoc()['total'];

echo json_encode([
    "productos" => $totalProductos,
    "usuarios" => $totalUsuarios,
    "pedidos" => $totalPedidos,
    "ventas" => $ventas ?? 0,
    "pendientes" => $pendientes
]);