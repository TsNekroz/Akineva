<!DOCTYPE html>
<?php
require 'config/config.php';
require 'config/conexion.php';
$db = new database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;



$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id,name_product,price,$cantidad AS cantidad FROM product WHERE id=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("location: index.php");
    exit;
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
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>producto</th>
                                    <th>subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"><b>lista vacia</b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $productos) {
                                        $_id = $productos['id'];
                                        $nombre = $productos['name_product'];
                                        $precio = $productos['price'];
                                        $cantidad = $productos['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total += $subtotal;
                                ?>
                                        <tr>
                                            <td><?php echo $nombre; ?></td>
                                            <td>
                                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> $<?php echo $subtotal ?></div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <p class="h3 text-end" id="total"> $<?php echo $total ?> </p>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                        </table>
                    </div>
                   
                </div>

            </div>
        </div>
    </main>

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

    <script>
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $total; ?>
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            let url ='clases/captura.php'
            actions.order.capture().then(function(detalles) {
                console.log(detalles);
                let url ='clases/captura.php'
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                });
            }).catch(function(error) {
                console.error(error);
            });
        },
        onCancel: function(data) {
            alert("Pago cancelado.");
            console.log(data);
        }
    }).render('#paypal-button-container');
</script>


</body>

</html>