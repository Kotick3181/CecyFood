<?php
session_start();

$total =0;

if(isset($_SESSION['carrito'])){
    $total = array_sum($_SESSION['carrito']);
}

echo json_encode([
    "cantidad"=>$total
]);