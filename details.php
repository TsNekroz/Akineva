<!DOCTYPE html>

<?php
require 'config/config.php';
require 'config/conexion.php';
$db = new database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'error de operacion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(id) FROM product WHERE id=?");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT id,name_product,description,price,image FROM product WHERE id=?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $name = $row['name_product'];
            $des = $row['description'];
            $price = $row['price'];
            $image = $row['image'];
        }
        // La lógica del código después de verificar el token exitoso
    } else {
        echo 'error';
        exit;
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
                        <a href="#" class="btn btn-success"><?php echo $_SESSION['user_name']; ?></a>
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
                <div class="col-md-6 order-md-1">
                    <img src="img/<?php echo $image; ?>" alt="<?php echo $image; ?>" class="d-block w-100">
                </div>
                <div class="col-md-6 order-md-2">
                    <h2> <?php echo $name; ?></h2>
                    <h2>$ <?php echo $price; ?></h2>
                    <p class="lead">
                        <?php echo $des; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary " type="button">comprar ahora</button></button>
                        <button class="btn btn-outline-primary " type="button" onclick="addproducto(<?php echo $id; ?>,'<?php echo $token_tmp; ?>')">agregar carrito</button></button>
                    </div>

                </div>

            </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function addproducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(Response => Response.json())
                .then(data => {
                        if (data.ok) {
                            let elemento = document.getElementById("num_cart")
                            elemento.innerHTML = data.numero
                        }
                    }

                )
        }
    </script>

</body>

</html>