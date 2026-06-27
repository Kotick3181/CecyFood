<?php
session_start();

include("../config/conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode([
        "success" => false,
        "message" => "No hay sesión"
    ]);
    exit();
}

$usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    echo json_encode([
        "success" => false,
        "message" => "Carrito vacío"
    ]);
    exit();
}

$metodo_pago = $_POST['metodo_pago'] ?? null;

if (!$metodo_pago) {
    echo json_encode([
        "success" => false,
        "message" => "Falta método de pago"
    ]);
    exit();
}

/* 🔥 INICIAR TRANSACCIÓN */
$conn->begin_transaction();

try {

    $total = 0;

    /* 1. VALIDAR STOCK Y CALCULAR TOTAL */
    foreach ($carrito as $id => $cantidad) {

        $sql = $conn->query("
            SELECT precio, stock 
            FROM productos
            WHERE id=$id
        ");

        $p = $sql->fetch_assoc();

        if (!$p) {
            throw new Exception("Producto no existe: $id");
        }

        /* 🔥 VALIDACIÓN CLAVE */
        if ($p['stock'] < $cantidad) {
            throw new Exception("Stock insuficiente en producto $id");
        }

        $total += $p['precio'] * $cantidad;
    }

    /* 2. INSERTAR PEDIDO */
    $stmt = $conn->prepare("
        INSERT INTO pedidos(
            usuario_id,
            total,
            metodo_pago
        )
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("ids", $usuario, $total, $metodo_pago);
    $stmt->execute();

    $pedido_id = $conn->insert_id;

    /* 3. DETALLES + DESCUENTO STOCK */
    foreach ($carrito as $id => $cantidad) {

        /* obtener precio */
        $sql = $conn->query("
            SELECT precio 
            FROM productos
            WHERE id=$id
        ");

        $p = $sql->fetch_assoc();

        $subtotal = $p['precio'] * $cantidad;

        /* detalle */
        $stmt = $conn->prepare("
            INSERT INTO detalle_pedido(
                pedido_id,
                producto_id,
                cantidad,
                subtotal
            )
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("iiid", $pedido_id, $id, $cantidad, $subtotal);
        $stmt->execute();

        /* descontar stock */
        $stmtStock = $conn->prepare("
            UPDATE productos
            SET stock = stock - ?
            WHERE id = ?
        ");

        $stmtStock->bind_param("ii", $cantidad, $id);
        $stmtStock->execute();
    }

    /* 4. LIMPIAR CARRITO */
    unset($_SESSION['carrito']);

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Pedido creado correctamente"
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}