<?php
define("CLIENTE_ID","Afwp7hCR-zQB55srzEceB2SmNHcV5_eoLCSGb2KDRmHloA8Vm7A9ezyJNTaoQL7qe3Ulcb6OPyHawznN");
define("KEY_TOKEN","Nino.naknO");
define("CURRENCY","MXN");
session_start();

$num_cart =0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>
