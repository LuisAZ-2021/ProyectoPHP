<?php
session_start();

include_once('clases.php');


if (isset($_GET["cerrar"]) && ($_GET["cerrar"]==1)){
    session_destroy();

    header("location:index.php");
}
// reutilizamos el código para probar
if (isset($_GET["eliminar_recordatorio"])) {
    $indiceEliminar_record = $_GET["eliminar_recordatorio"];

    // Obtener el nombre antes de eliminar el índice
    $nombreGuardado = '';

    if (isset($_SESSION['recordatorios'][$indiceEliminar_record]['nombreContacto'])) {
        $nombreGuardado = $_SESSION['recordatorios'][$indiceEliminar_record]['nombreContacto'];
    }
    $tareaRecordatorio = new TareaRecordatorioConcreta();
    $tareaRecordatorio->eliminar($indiceEliminar_record);
    
    header("location:formulario_recordatorio.php?asignar_recordatorio=$nombreGuardado");
    exit();
}




if (isset($_GET["mostrar_recordatorio"])) {
    $indiceMostrar = $_GET["mostrar_recordatorio"];
    $tareaRecordatorio = new TareaRecordatorioConcreta();
    $tareaRecordatorio->mostrarDetalles($indiceMostrar);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tareaRecordatorio = new TareaRecordatorioConcreta();

    // Obtenemos los datos del formulario y almacenarlos en un array
    $datos = [
        'nombre' => $_POST['nombre'] ?? '',
        'recordatorio' => $_POST['recordatorio'] ?? '',
        'hora' => $_POST['hora'] ?? '',
        'fecha' => $_POST['fecha'] ?? ''
    ];

    $tareaRecordatorio->agregar($datos);
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
    <div class="col-7 text-center mt-3">
    <div class="container">
    <h1>Formulario de Recordatorio </h1>


    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
        <?php
            // Obtener el índice del contacto
            $indiceContacto = $_GET['asignar_recordatorio'] ?? null;
            //$nombre_seleccionado=$_SESSION['contactos'][$indiceContacto];
            $nombre_seleccionado=$_GET['asignar_recordatorio'];
            $valor=1;
            // Verificar si el índice del contacto está presente y existe en la sesión
            if ($_GET['asignar_recordatorio']) {
                $contactoSeleccionado = $_GET['asignar_recordatorio'];
                $nombreContacto = $_GET['asignar_recordatorio'];
                

                // Mostrar el nombre del contacto en el campo "Contacto"
                echo "<label for='nombre' class='form-label'>Contacto:</label>";
                echo "<input type='text' id='nombre' name='nombre' class='form-control' value='$nombreContacto' readonly>";
                
            } else if($valor != 1){
                // Manejar la situación donde no se proporciona un índice válido
                //echo "<p>No se ha proporcionado un índice de contacto válido.</p>";
                echo "<input type='text' id='nombre' name='nombre' value='$nombre_seleccionado'>";
            } else {
                // Manejar la situación donde no se proporciona un índice válido
                echo "<p>No se ha proporcionado un índice de contacto válido.</p>";
                echo "<input type='text' id='nombre' name='nombre' value='$nombre_seleccionado'>";
            }
            ?>
            
        </div>
        <div class="mb-3">
            <label for="tarea" class="form-label">Tarea:</label>
            <select id="recordatorio" name="recordatorio" class="form-select">
                <?php
                // Definimos los recordatorios
                $recordatorio = [
                    "Fecha de Cumpleaños",
                    "Fecha de Aniversario",
                    "Reunion Laboral",
                    "Festival",
                    "Reunion Familiar"
                ];

                // Los mostramos en el formulario
                foreach ($recordatorio as $recordar) {
                    echo "<option value='$recordar'>$recordar</option>";
                }
                ?>
            </select>
            <!--<input type="text" id="razon" name="razon" class="form-control">-->
        </div>
        <div class="mb-3">
            <label for="hora">Hora:</label>
            <!-- Campo de selección de hora -->
            <input type="time" id="hora" name="hora" class="form-control">
        </div>
        <div class="mb-3">
            <label for="fecha">Fecha:</label>
            <!-- Campo de selección de fecha -->
            <input type="date" id="fecha" name="fecha" class="form-control">
        </div>
    <button type="submit" id="agregarRecordatorio" class="btn btn-primary">Agregar Recordatorio</button>
    </form>
</div>
    </div>
    <div class="col">
    <a href="formulario_contacto.php?cerrar=1" class="logout-link"> Cerrar Sesion</a>
    <a href="index.php" class="logout-link"> Ir al Inicio</a>
    </div>
  </div>
</div>

<br/>
<br/>


            <!-- comienza la tabla -->
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Contacto</th>
                            <th scope="col">Recordatorio</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <!-- Filas de la tabla -->
                            <?php
                            if (isset($_SESSION['recordatorios'])) {
                foreach ($_SESSION['recordatorios'] as $index => $recordar) {
                    echo "<tr>
                            <td>{$recordar['nombreContacto']}</td>
                            <td>{$recordar['recordatorio']}</td>
                            <td>{$recordar['hora']}</td>
                            <td>{$recordar['fecha']}</td>
                            <td>
                            <a href='formulario_recordatorio.php?eliminar_recordatorio={$index}' class='btn btn-primary'>Eliminar</a>
                            <a href='formulario_recordatorio.php?mostrar_recordatorio={$index}' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Mostrar Detalles</a>
                            
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
                <h5 class="modal-title" id="exampleModalLabel">Detalles de Recordatorio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mostramos los detalles del contacto -->

                <ul>
                    <li><strong>Nombre:</strong> <?php echo $recordar['nombreContacto']; ?></li>
                    <li><strong>Recordatorio:</strong> <?php echo $recordar['recordatorio']; ?></li>
                    <li><strong>Hora:</strong> <?php echo $recordar['hora']; ?></li>
                    <li><strong>Fecha:</strong> <?php echo $recordar['fecha']; ?></li>
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