<?php 

function registrarproducto(array $datos, $con){
    $sql = $con->prepare("INSERT INTO product(name_product,description,price,stock,image) VALUES (?,?,?,?,?)");
    if($sql->execute($datos)) {
        return $con->lastInsertId();  
    }
    return 0;
}

?>