<?php

include("auth.php");

if($_SESSION['rol'] != 'admin'){

    header(

    "Location: ../cliente/menu.php"
    );
    exit();
}
