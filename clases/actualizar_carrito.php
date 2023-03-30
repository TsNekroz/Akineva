<?php
require '../config/config.php';
require '../config/conexion.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if($action == 'agregar'){
        $cantidad= isset($_POST['cantidad']) ? $_POST['cantidad'] :0;
        $respuesta= agregar($id,$cantidad);
        if($respuesta > 0){
            $datos['ok'] = true;
        }else{
            $datos['ok'] = false;
        }
        $datos['sub'] =($respuesta);
    }else if($action == 'eliminar'){
        $datos['ok']=eliminar($id);
    }else{
        $datos['ok'] = false;
    }
}else{
    $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id,$cantidad){
    $res =0;
    if($id > 0 && $cantidad > 0 && is_numeric(($cantidad))){
        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] =$cantidad;
            $db = new database();
            $con = $db ->conectar();
            $sql = $con->prepare("SELECT count(id) FROM product WHERE id=?");
            $sql->execute([$id]);
            if ($sql->fetchColumn()> 0){
                $sql = $con->prepare("SELECT price FROM product WHERE id=?");
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $price = $row['price'];
                $res = $cantidad*$price;
                return $res;
            }
        }else{
            return $res;
        }
    }
}

function eliminar($id){
    if($id >0){
        if(isset($_SESSION['carrito']['productos'][$id])){
            unset($_SESSION['carrito']['productos'][$id]);
            return true;
        }
    }else{
        return false;
    }
}
?>
