<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <form class="col-7" >
        <H3 class="text-center text-secondary p-4 m -auto">REGISTRO</H3>
        <?php
    
        
        ?>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="Nombre">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Apellido</label>
            <input type="text" class="form-control" name="apellido">
          </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DNI</label>
            <input type="text" class="form-control" name="dni">
          </div>
        
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" name="fecha">
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo">
          </div>

          

          <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">REGISTRAR</button>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>