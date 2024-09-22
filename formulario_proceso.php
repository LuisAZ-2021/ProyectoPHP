<?php
session_start();

include_once('clases.php');


if (isset($_GET["cerrar"]) && ($_GET["cerrar"]==1)){
    session_destroy();

    header("location:index.php");
}
// reutilizamos el código para probar la eliminación
if (isset($_GET["eliminar_tarea"])) {
    $indiceEliminar_tarea = $_GET["eliminar_tarea"];

    // Obtener el nombre antes de eliminar el índice
    $nombreGuardado = '';

    if (isset($_SESSION['tareas'][$indiceEliminar_tarea]['nombreContacto'])) {
        $nombreGuardado = $_SESSION['tareas'][$indiceEliminar_tarea]['nombreContacto'];
    }
    $tareaProceso = new TareaProcesoConcreta();
    $tareaProceso->eliminar($indiceEliminar_tarea);
    
    header("location:formulario_proceso.php?asignar=$nombreGuardado");
    exit();
}




if (isset($_GET["mostrar_tareas"])) {
    $indiceMostrar = $_GET["mostrar_tareas"];
    $tareaProceso = new TareaProcesoConcreta();
    $tareaProceso->mostrarDetalles($indiceMostrar);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tareaProceso = new TareaProcesoConcreta();

    // Obtenemos los datos del formulario y almacenarlos en un array
    $datos = [
        'nombre' => $_POST['nombre'] ?? '',
        'tarea' => $_POST['tarea'] ?? '',
        'subtarea' => $_POST['subtarea'] ?? ''
    ];

    // Llamamos a la función agregar de la clase TareaProcesoConcreta con los datos del formulario
    $tareaProceso->agregar($datos);
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
    <div class="col mt-3">
      
    </div>
    <div class="col-7 text-center mt-3">
    <div class="container">
    <h1>Formulario de Tarea de Procesos </h1>


    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
        <?php
            // Obtener el índice del contacto
            $indiceContacto = $_GET['asignar'] ?? null;
            //$nombre_seleccionado=$_SESSION['contactos'][$indiceContacto];
            $nombre_seleccionado=$_GET['asignar'];
            $valor=1;
            // Verificar si el índice del contacto está presente y existe en la sesión
            if ($_GET['asignar']) {
                $contactoSeleccionado = $_GET['asignar'];
                $nombreContacto = $_GET['asignar'];
                

                // Mostramos el nombre del contacto en el campo "Contacto"
                echo "<label for='nombre' class='form-label'>Contacto:</label>";
                echo "<input type='text' id='nombre' name='nombre' class='form-control' value='$nombreContacto' readonly>";
                
            } else if($valor != 1){

                echo "<input type='text' id='nombre' name='nombre' value='$nombre_seleccionado'>";
            } else {
                // Manejamos la situación donde no se proporciona un índice válido
                echo "<p>No se ha proporcionado un índice de contacto válido.</p>";
                echo "<input type='text' id='nombre' name='nombre' value='$nombre_seleccionado'>";
            }
            ?>
            <input type="hidden" id="nombre_contacto" name="nombre_contacto" value="<?php echo htmlspecialchars($nombreContacto); ?>">
        </div>
        <div class="mb-3">
            <label for="tarea" class="form-label">Tarea:</label>
            <select id="tarea" name="tarea" class="form-select">
                <?php
                // Definimos las tareas y sus subtareas
                $tareas = [
                    "Preparacion de un evento" => [
                        "Hacer lista de invitados",
                        "Alquilar un salon",
                        "Hacer tarjetas de invitacion"
                    ],
                    "Preparacion de Vacaciones" => [
                        "Comprar boletos",
                        "Reservar alojamiento",
                        "Hacer lista de empaque"
                    ],
                    "Hacer compras en supermercado" => [
                        "Ver catalogo",
                        "Comparar precios",
                        "Comparar Marcas"
                    ]
                ];

                // Mostramos las tareas en el formulario
                foreach ($tareas as $tarea => $subtareas) {
                    echo "<option value='$tarea'>$tarea</option>";
                }
                ?>
            </select>
            <!--<input type="text" id="razon" name="razon" class="form-control">-->
        </div>
        <div class="mb-3">
        <label for="subtarea" class="form-label">Subtareas:</label>
            <input type="text" id="subtarea" name="subtarea" class="form-control" readonly>
        </div>
        <button type="submit" id="agregarSubtareas" class="btn btn-primary">Agregar Tarea a Contacto</button>
    </form>
</div>
    </div>
    <div class="col mt-3">
    <a href="formulario_contacto.php" class="logout-link"> Ir al pantalla anterior</a>
    <a href="formulario_contacto.php?cerrar=1" class="logout-link"> Cerrar Sesion</a>
    
    </div>
  </div>
</div>

<br/>
<br/>



            <!-- Muestro la tabla -->
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Contacto</th>
                            <th scope="col">Tarea</th>
                            <th scope="col">Subtareas</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <!-- Filas de la tabla -->
                            <?php
                            if (isset($_SESSION['tareas'])) {
                foreach ($_SESSION['tareas'] as $index => $tareas) {
                    echo "<tr>
                            <td>{$tareas['nombreContacto']}</td>
                            <td>{$tareas['tarea']}</td>
                            <td>{$tareas['subtarea']}</td>
                            <td>
                            <a href='formulario_proceso.php?eliminar_tarea={$index}' class='btn btn-primary'>Eliminar</a>
                            <a href='formulario_proceso.php?mostrar_tareas={$index}' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Mostrar Detalles</a>
                            <a href='formulario_recordatorio.php?asignar_recordatorio={$tareas['nombreContacto']}' class='btn btn-primary'>Recordatorio</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Detalles de Procesos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mostramos los detalles del contacto -->

                <ul>
                    <li><strong>Nombre:</strong> <?php echo $tareas['nombreContacto']; ?></li>
                    <li><strong>Tarea:</strong> <?php echo $tareas['tarea']; ?></li>
                    <li><strong>Subtarea:</strong> <?php echo $tareas['subtarea']; ?></li>
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
    <script>
    // Obtener el campo de selección de tareas y subtareas
    const tareaSelect = document.getElementById('tarea');
    const subtareaInput = document.getElementById('subtarea');
    const agregarSubtareasBtn = document.getElementById('agregarSubtareas');

    // Definimos las subtareas para cada tarea
    const subtareasPorTarea = {
        "Preparacion de un evento": [
            "Hacer lista de invitados",
            "Alquilar un salon",
            "Hacer tarjetas de invitacion"
        ],
        "Preparacion de Vacaciones": [
            "Comprar boletos",
            "Reservar alojamiento",
            "Hacer lista de empaque"
        ],
        "Hacer compras en supermercado": [
            "Ver catalogo",
            "Comparar precios",
            "Comparar Marcas"
        ]
    };

    // Función para actualizar las subtareas según la tarea seleccionada
    tareaSelect.addEventListener('change', function() {
        // Obtener la tarea seleccionada
        const selectedTarea = tareaSelect.value;

        // Obtener las subtareas correspondientes a la tarea seleccionada
        const subtareas = subtareasPorTarea[selectedTarea];
        subtareaInput.value = subtareas.join(', ');

    });

    agregarSubtareasBtn.addEventListener('click', function() {
        const contactoSubtareas = subtareaInput.value;

        console.log('Subtareas a agregar al contacto:', contactoSubtareas);
    });

    // Disparar el evento 'change' para cargar las subtareas inicialmente
    tareaSelect.dispatchEvent(new Event('change'));
</script>
</body>
</html>