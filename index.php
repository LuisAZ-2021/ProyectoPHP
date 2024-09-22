<?php
session_start();

if (isset($_GET["cerrar"]) && ($_GET["cerrar"]==1)){
    session_destroy();

    header("location:formulario_index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <style>

    body{
        background: #F1F8FF;
      }
    .logout-link {
        float: right; 
    }
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col">
            
            </div>
            <div class="col-5 text-center mt-4">
                <h1>Procesamiento de Tareas </h1>
            </div>
            <div class="col mt-4">
            <a href="formulario_contacto.php?cerrar=1" class="logout-link"> Cerrar Sesion</a>
            </div>
        </div>
    </div>
    

    <br/>
    <br/>
    <br/>
    <br/>

    <div class="container">
        <div class="row">
            <div class="col text-center">
                
            </div>
            <div class="col text-center">
                
                <a type="button" href="formulario_contacto.php" class="btn btn-primary">Ingresar Contacto</a>
            </div>
            <div class="col text-center">
                
            </div>
        </div>
    </div>

    </body>
</html>