<!DOCTYPE html>
<?php
require 'config/config.php';
require 'config/conexion.php';
$db = new database();
$con = $db->conectar();




$detalles = array();


$sql = $con->prepare("SELECT id_compra, id_product, nombre, precio, cantidad FROM detai_compra");
$sql->execute();
$detalles = $sql->fetchAll(PDO::FETCH_ASSOC);



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
                        <li class="nav-item">
                            <a href="registro_pro.php" class="nav-link active">Agregar productos</a>
                        </li>
                        <li class="nav-item">
                            <a href="ventas.php" class="nav-link active">Catalogo de ventas</a>
                        </li>
                        <li class="nav-item">
                            <a href="productos.php" class="nav-link active">Catalogo de productos</a>
                        </li>
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>id_compra</th>
                            <th>id_product</th>
                            <th>Nombre del producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($detalles as $productos) {
                            $_id = $productos['id_compra'];
                            $nombre = $productos['nombre'];
                            $id_pro = $productos['id_product'];
                            $precio = $productos['precio'];
                            $cantidad = $productos['cantidad'];
                        ?>
                            <tr>
                                <td><?php echo $_id; ?></td>
                                <td><?php echo $id_pro; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td>$<?php echo $precio; ?></td>
                                <td><?php echo $cantidad; ?></td>


                            <?php
                        }



                            ?>
                            <tr>
                            </tr>
                            </tr>
                    </tbody>

                </table>
            </div>

        </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



</body>

</html>