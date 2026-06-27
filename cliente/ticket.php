<?php
session_start();

require_once("../config/conexion.php");
require("../fpdf/fpdf.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Pedido no especificado");
}

$pedido_id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario'];

$pedido = $conn->query("
SELECT
    pedidos.*,
    usuarios.nombre,
    usuarios.numero_control
FROM pedidos
INNER JOIN usuarios
ON pedidos.usuario_id = usuarios.id
WHERE pedidos.id = $pedido_id
AND pedidos.usuario_id = $usuario_id
");

if ($pedido->num_rows == 0) {
    die("Pedido no encontrado");
}

$pedido = $pedido->fetch_assoc();

$detalle = $conn->query("
SELECT
    detalle_pedido.*,
    productos.nombre
FROM detalle_pedido
INNER JOIN productos
ON detalle_pedido.producto_id = productos.id
WHERE detalle_pedido.pedido_id = $pedido_id
");

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'CECYFOOD', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 8, 'Pedido #' . $pedido['id'], 0, 1);

$pdf->Cell(
    0,
    8,
    utf8_decode('Cliente: ' . $pedido['nombre']),
    0,
    1
);

$pdf->Cell(
    0,
    8,
    'No. Control: ' . $pedido['numero_control'],
    0,
    1
);

$pdf->Cell(
    0,
    8,
    'Fecha: ' . $pedido['fecha'],
    0,
    1
);

$pdf->Cell(
    0,
    8,
    'Estado: ' . $pedido['estado'],
    0,
    1
);

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(80, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);

$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

while ($item = $detalle->fetch_assoc()) {

    $pdf->Cell(
        80,
        10,
        utf8_decode($item['nombre']),
        1
    );

    $pdf->Cell(
        30,
        10,
        $item['cantidad'],
        1
    );

    $pdf->Cell(
        40,
        10,
        '$' . $item['subtotal'],
        1
    );

    $pdf->Ln();
}

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 14);

$pdf->Cell(
    0,
    10,
    'TOTAL: $' . $pedido['total'],
    0,
    1,
    'R'
);

$pdf->Ln(10);

$pdf->SetFont('Arial', 'I', 11);

$pdf->Cell(
    0,
    10,
    utf8_decode('Gracias por comprar en CecyFood'),
    0,
    1,
    'C'
);

$pdf->Output(
    'I',
    'Ticket_CecyFood_' . $pedido['id'] . '.pdf'
);
