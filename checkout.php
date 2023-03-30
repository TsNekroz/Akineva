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
                    <?php if(isset($_SESSION['user_id'])){?>
                    <a href="#" class="btn btn-success"><?php echo $_SESSION['user_name'];?></a>
                <?php } else {?>
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
                            <th>producto</th>
                            <th>precio</th>
                            <th>cantidad</th>
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
                                    <td>$<?php echo $precio; ?></td>
                                    <td><input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizarCantidad(this.value,<?php echo $_id; ?>)"></td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> $<?php echo $subtotal ?></div>
                                    </td>
                                    <td>
                                        <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">eliminar</a>
                                        
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"> $<?php echo $total ?> </p>
                                </td>
                            </tr>
                            </tr>
                    </tbody>
                <?php
                        } ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pago.php" class="btn btn-primary btn-lg">realizar pago</a>
                </div>
            </div>
        </div>
    </main>

   
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminaModal">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Desea eliminar el producto del carrrito?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()" 
                    >Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
       let eliminaModal = document.getElementById('eliminaModal')
eliminaModal.addEventListener('show.bs.modal', function(event) {
    let button = event.relatedTarget
    let id = button.getAttribute('data-bs-id')
    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
    buttonElimina.value=id;
}); 


        function actualizarCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'agregar');
            formData.append('id', id);
            formData.append('cantidad', cantidad);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(Response => Response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById("subtotal_" + id);
                        divsubtotal.innerHTML = data.sub;

                        let total = 0.00;
                        let list = document.getElementsByName('subtotal[]');

                        for (let i = 0; i < list.length; i++) {
                            total += parseInt(list[i].innerHTML.replace(/[$,]/g, ''));
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total);

                        document.getElementById('total').innerHTML = total;
                    }
                });
        }
        function eliminar() {
            let botonelimina =document.getElementById('btn-elimina')
            let id =botonelimina.value
            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', id);


            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(Response => Response.json())
                .then(data => {
                    if(data.ok){
                        location.reload()
                    }
                });
        }
    </script>

</body>

</html>