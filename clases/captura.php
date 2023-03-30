<?php
require '..//config/config.php';
require '../config/conexion.php';
$db = new database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json,true);
echo '<pre>';
print_r($datos);
echo '</pre>';
if(is_array($datos)){
    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s',strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = $con->prepare("INSERT INTO compra(id_transaccion,fecha,status,email,id_cliente,total) VALUES(?,?,?,?,?,?)");
    $sql->execute([$id_transaccion,$fecha_nueva,$status,$email,$id_cliente,$total]);
    $id = $con->lastInsertId();

    if($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
                $sql = $con->prepare("SELECT id,name_product,price FROM product WHERE id=?");
                $sql->execute([$clave]);
                $row_prod= $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['price'];
                

                $sql_insert = $con->prepare("INSERT INTO detai_compra(id_compra,id_product,nombre,precio,cantidad) VALUES(?,?,?,?,?)");
                $sql_insert->execute([$id,$clave,$row_prod['name_product'],$precio,$cantidad]);
            }
        }
        unset($_SESSION['carrito']);
    }

}



?>