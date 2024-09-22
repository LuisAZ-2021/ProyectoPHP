<?php
session_start();

include_once('clases.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tareaContacto = new TareaContactoConcreta();

    // Obtener los datos del formulario y almacenarlos en un array
    $datos = [
        'nombre' => $_POST['nombre'] ?? '',
        'razon' => $_POST['razon'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'email' => $_POST['email'] ?? ''
    ];

    // Llamar a la función agregar de la clase TareaContactoConcreta con el array de datos
    $tareaContacto->agregar($datos);

}

if (isset($_GET["cerrar"]) && ($_GET["cerrar"]==1)){
    session_destroy();

    header("location:index.php");
}

if (isset($_GET["eliminar"])) {
    $indiceEliminar = $_GET["eliminar"];
    $tareaContacto = new TareaContactoConcreta();
    $tareaContacto->eliminar($indiceEliminar);
    
    header("Location: formulario_contacto.php");
    exit();
}

if (isset($_GET["mostrar"])) {
    $indiceMostrar = $_GET["mostrar"];
    $tareaContacto = new TareaContactoConcreta();
    $tareaContacto->mostrarDetalles($indiceMostrar);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <style>

    body{
        background: #F1F8FF;
    }
    .logout-link {
        float: right; 
        margin-right: 10px;
    }
    </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col">
      
    </div>
    <div class="col-6 text-center " >
    <div class="container">
    <h1>Formulario de Contacto</h1>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label for="razon" class="form-label">DNI:</label>
            <input type="text" id="razon" name="razon" class="form-control">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="text" id="email" name="email" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Agregar Contacto</button>
    </form>
</div>
    </div>
    <div class="col">
    <a href="index.php" class="logout-link"> Ir al Inicio </a>
    <a href="formulario_contacto.php?cerrar=1" class="logout-link"> Cerrar Sesion </a>
    
    </div>
  </div>
</div>



<br/>
<br/>

    <!-- Se muestra la tabla con los datos ingresados -->
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo electrónico</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php

            if (isset($_SESSION['contactos'])) {
                foreach ($_SESSION['contactos'] as $index => $contacto) {
                    echo "<tr>
                            <td>{$contacto['nombre']}</td>
                            <td>{$contacto['razon']}</td>
                            <td>{$contacto['telefono']}</td>
                            <td>{$contacto['email']}</td>
                            <td>
                            <a href='formulario_contacto.php?eliminar={$index}' class='btn btn-primary'>Eliminar</a>
                            <a href='formulario_contacto.php?mostrar={$index}' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Mostrar Detalles</a>
                            <a href='formulario_proceso.php?asignar={$contacto['nombre']}' class='btn btn-primary'>Asignar Tarea</a>
                            </td>
                          </tr>";
                }
            }
            ?>
        

<!-- Muestro los detalles del contacto-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de contacto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Muestro los detalles del contacto -->

                <ul>
                    <li><strong>Nombre:</strong> <?php echo $contacto['nombre']; ?></li>
                    <li><strong>DNI:</strong> <?php echo $contacto['razon']; ?></li>
                    <li><strong>Teléfono:</strong> <?php echo $contacto['telefono']; ?></li>
                    <li><strong>Correo electrónico:</strong> <?php echo $contacto['email']; ?></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
                
            </tbody>
        </table>
    </div>

</body>
</html>
