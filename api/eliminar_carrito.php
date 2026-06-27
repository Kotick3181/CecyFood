<?php
session_start();

$id = intval($_POST['id']);

if(isset($_SESSION['carrito'][$id])){
    unset($_SESSION['carrito'][$id]);
}

echo json_encode([
    "success"=>true
]);