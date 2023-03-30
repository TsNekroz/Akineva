<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=Afwp7hCR-zQB55srzEceB2SmNHcV5_eoLCSGb2KDRmHloA8Vm7A9ezyJNTaoQL7qe3Ulcb6OPyHawznN&currency=MXN"></script>
</head>

<body>
    <div id="paypal-button-container"></div>

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
                            value: 100
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                actions.order.capture().then(function(detalles) {
                    window.location.href="index.php"
                });
                console.log(data);
            },

            oncancel: function(data) {
                alert("pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
 <!-- //sb-xxvgm25289301@personal.example.com
?V7IuG>M -->
</body>

</html>