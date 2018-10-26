

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/proyecto/public/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<?php include '../controladores/MostrarProductos.php';?>
<div class="container" style="margin-top: 20px">

    <div class="row">
        
        <div class="col s12 m12">
        
        
            <table>

                <thead class="teal">

                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Tamaño</th>
                        <th>Tipo de producto</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach($array as $value): ?>
                        <?php if($value['activo'] == 1): ?>
                        
                            <tr>
                                <th> <?php echo $value['nombre'] ?> </th>
                                <th> <?php echo $value['precio'] ?> </th>
                                <th> <?php echo $value['cantidad'] ?> </th>
                                <th> <?php echo $value['tamano'] ?> </th>
                                <th> <?php echo $value['tipo_producto'] ?> </th>
                                <th> 
                                    <a class="waves-effect waves-light btn">
                                        <i class="material-icons left">delete</i>
                                        Eliminar
                                    </a>

                                </th>
                            </tr>
                        <?php endif ?>

                    <?php endforeach ?>
                </tbody>
            </table>
        
        </div>
    
    
    </div>


</div>

    <!-- Script Materialice -->

    <script src="/proyecto/public/js/materialize.min.js"></script>

    <!-- Script Propios-->
    
</body>
</html>