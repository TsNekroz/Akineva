<!DOCTYPE html>
<?php
require 'config/config.php';
require 'config/conexion.php';
require 'clases/clientes.php';
$db = new database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {
    $password = trim($_POST['password']);
    $usuario = trim($_POST['usuario']);
    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $con);
    }
}

?>

<!-- Aquí se muestra el mensaje de error -->
<?php foreach ($errors as $error) : ?>
    <p><?php echo $error; ?></p>
<?php endforeach; ?>




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
    <main class="form-login m-auto pt-4">
        <h1>Inicio de Sesión</h1>
        <form class="row g-3" action="login.php" method="post" autocomplete="off">
            <div class="col-md-12">
                <div class="form-floating">
                    <input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" required>
                    <label for="usuario">Usuario</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input class="form-control" type="password" name="password" id="password" placeholder="password" required>
                    <label for="password">Contraseña</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </div>
            <div class="col-md-12">
                ¿No tienes cuenta? <a href="registro.php">Registrate aqui</a>
            </div>
        </form>
    </main>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>