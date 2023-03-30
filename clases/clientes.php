<?php 

function registrarcliente(array $datos, $con){
    $sql = $con->prepare("INSERT INTO clientes(nombre,apellidos,email) VALUES (?,?,?)");
    if($sql->execute($datos)) {
        return $con->lastInsertId();  
    }
    return 0;
}

function registraruasuario(array $datos,$con){

    $sql = $con->prepare("INSERT INTO user(usuario,password,id_cliente) VALUES (?,?,?)");
   if($sql->execute($datos)){
    return true;
   }
   return false;

}

function usuarioexiste($usuario, $con){
    $sql = $con->prepare("SELECT id FROM user WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($sql->fetchColumn() >0){
return true;
    }
    return false;
}

function obtenercliente_por_correo($correo, $con) {
    $query = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$correo]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cliente !== false ? $cliente : false;
}


function obtenerusuario_por_nombre($usuario, $con) {
    $query = "SELECT * FROM user WHERE usuario = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user !== false ? $user : false;
}

function login($usuario, $password, $con){
    $sql = $con->prepare("SELECT id,usuario,password FROM user WHERE usuario = ? LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        if(esadmin($usuario, $con)){
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'] ;
                $_SESSION['user_name'] = $row['usuario'] ;
                header("location: index_admin.php");
                exit;
            } else {
                echo '<div style="position: fixed; top: 70%; left: 50%; transform: translate(-50%, -50%);" class="alert alert-danger" role="alert">
                ¡Error! contraseña o usuario incorrectos, inténtalo de nuevo.
              </div>';
        

            }
        } else {
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'] ;
                $_SESSION['user_name'] = $row['usuario'] ;
                header("location: index.php");
                exit;
            } else {
                echo '<div style="position: fixed; top: 70%; left: 50%; transform: translate(-50%, -50%);" class="alert alert-danger" role="alert">
                ¡Error! contraseña o usuario incorrectos, inténtalo de nuevo.
              </div>';
        
            }
        }
    }
    

}


function esadmin($usuario,$con){
    $sql = $con->prepare("SELECT activacion FROM user WHERE usuario = ? LIMIT 1");
    $sql->execute([$usuario]);
    $row =$sql->fetch(PDO::FETCH_ASSOC);
    if($row['activacion']==1){
        return true;
    }
    return false;
        
    }
