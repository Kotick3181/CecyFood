<?php
session_start();

$id = intval($_POST['id']);
$accion = $_POST['accion'];

if(isset($_SESSION['carrito'][$id])){

    if($accion =="sumar"){
        $_SESSION['carrito'][$id]++;
    }

    if($accion == "restar"){

        $_SESSION['carrito'][$id]--;

        if($_SESSION['carrito'][$id]<=0){
            unset($_SESSION['carrito'][$id]);
        }
    }
}

echo json_encode([
    "success"=>true
]);