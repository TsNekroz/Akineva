<!DOCTYPE html>
<?php
require 'config/config.php';
require 'config/conexion.php';
require 'clases/clientes.php';
$db = new database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {
    $nombre = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    $usuario = trim($_POST['usuario']);
    
    // Validar si el correo ya existe en la base de datos
    $cliente = obtenercliente_por_correo($correo, $con);
    if ($cliente !== false) {
        $errors[] = "El correo ya está registrado";
    }
    
    // Validar si el usuario ya existe en la base de datos
    $usuario_db = obtenerusuario_por_nombre($usuario, $con);
    if ($usuario_db !== false) {
        $errors[] = "El usuario ya está registrado";
    }
    
    // Registrar el cliente si no hay errores
    if (count($errors) === 0) {
        $id = registrarcliente([$nombre, $apellidos, $correo], $con); 
        if ($id > 0) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            if (!registraruasuario([$usuario, $pass_hash, $id], $con)) { 
                $errors[] = "Error al registrar";
            } else {
                echo "<script>alert('Registrado correctamente.');</script>";
            }
        }
    }
    
    // Mostrar errores si los hay
    if (count($errors) > 0) { 
        $error_message = "Se han encontrado los siguientes errores:<br>";
        foreach ($errors as $error) {
            $error_message .= "- " . $error . "<br>";
        }
        echo "<script>alert('$error_message');</script>";
    }
}
?>



<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
   <!--Barra de navegación-->
   <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <strong>Akineva</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                       
                    </ul>
                    <a href="checkout.php" class="btn btn-primary me-2">Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_sesion" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">cerrar sesion</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-success">Ingresar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
    <!--Contenido-->
    <main>
        <div class="container">
            <h2>Datos del cliente</h2>
            <form class="row g-3" action="registro.php" method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span>Nombre</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="correo"><span class="text-danger">*</span>Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span>Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>