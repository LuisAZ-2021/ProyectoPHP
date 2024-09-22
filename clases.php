<?php
include_once('tareas.php');

final class TareaContactoConcreta extends TareaContacto {
    public function agregar($datos) {

            // Validación de datos ingresados
            $nombre = $datos['nombre'] ?? '';
            $razon = $datos['razon'] ?? '';
            $telefono = $datos['telefono'] ?? '';
            $email = $datos['email'] ?? '';

            if (empty($nombre) || empty($razon) || empty($telefono) || empty($email)) {
                echo "Por favor, complete todos los campos del formulario.";
                return; // Detener la ejecución si los campos no están completos
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "El formato del correo electrónico no es válido.";
                return; // Detener la ejecución si el formato del correo es inválido
            }

            // Si todos los campos están completos y el formato del correo es válido,
            //creamos un array asociativo $datos_contacto
           
            $datos_contacto = [
                'nombre' => $nombre,
                'razon' => $razon,
                'telefono' => $telefono,
                'email' => $email
            ];

            // Verificamos si hay una sesión existente para los contactos, si no la hay, crearla
            if (!isset($_SESSION['contactos'])) {
                $_SESSION['contactos'] = array();
            }

            // Agregar el nuevo contacto al arreglo de contactos en la sesión
            $_SESSION['contactos'][] = $datos_contacto;


        // Redireccionamos despues de procesar el formulario si es necesario
        header("Location: formulario_contacto.php");
        exit(); // Aseguramos que el script se detenga después de redirigir
    }

    public function eliminar($indice) {
        // Se Implementa la lógica para eliminar la tarea de contacto
        if (isset($_SESSION['contactos'][$indice])) {
            unset($_SESSION['contactos'][$indice]);
        }
    }

    public function mostrarDetalles($indice) {
        // Se Implementa la lógica para mostrar detalles de la tarea de contacto
        if (isset($_SESSION['contactos'][$indice])) {
            $contacto = $_SESSION['contactos'][$indice];
            echo "<script>
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                 </script>";
            echo "<ul>
                    <li><strong>Nombre:</strong> {$contacto['nombre']}</li>
                    <li><strong>DNI:</strong> {$contacto['razon']}</li>
                    <li><strong>Teléfono:</strong> {$contacto['telefono']}</li>
                    <li><strong>Correo electrónico:</strong> {$contacto['email']}</li>
                  </ul>";
        }
    }
}


final class TareaProcesoConcreta extends TareaProceso {

    public function agregar($datos) {
        // Obtener el nombre del contacto para el que se agregarán tareas
        $nombreContacto = $datos['nombre'] ?? '';
    
        // Obtener la tarea y subtarea del formulario
        $tarea = $datos['tarea'] ?? '';
        $subtarea = $datos['subtarea'] ?? '';
    
        // Verificar si el nombre del contacto y la tarea no están vacíos
        if (!empty($nombreContacto) && !empty($tarea) && !empty($subtarea)) {
            // Crear una estructura de datos para almacenar el nombre de contacto, la tarea y subtarea
            $nuevaTarea = [
                'nombreContacto' => $nombreContacto,
                'tarea' => $tarea,
                'subtarea' => $subtarea
            ];
    
            // Verificar si el contacto ya tiene tareas almacenadas
            if (isset($_SESSION['tareas'])) {
                // Agregar la nueva tarea al array de tareas del contacto existente
                $_SESSION['tareas'][] = $nuevaTarea;
            } else {
                // Si el contacto no tiene tareas almacenadas aún, crear un array para almacenarlas
                $_SESSION['tareas'] = array($nuevaTarea);
            }
        } else {
            // Manejar la situación en la que el nombre del contacto o la tarea están vacíos
            echo "Por favor, complete el nombre del contacto, la tarea y la subtarea.";
        }
    }
    

    public function eliminar($indice) {
        // Se Implementa la lógica para eliminar la tarea de contacto
        if (isset($_SESSION['tareas'][$indice])) {
            unset($_SESSION['tareas'][$indice]);
        }
    }

    public function mostrarDetalles($indice) {
        // Se Implementa la lógica para mostrar detalles de la tarea de proceso
        if (isset($_SESSION['tareas'][$indice])) {
            $tareas = $_SESSION['tareas'][$indice];
            echo "<script>
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                 </script>";
            echo "<ul>
                    <li><strong>Nombre:</strong> {$tareas['nombreContacto']}</li>
                    <li><strong>DNI:</strong> {$tareas['tarea']}</li>
                    <li><strong>Teléfono:</strong> {$tareas['subtarea']}</li>
                  </ul>";
        }
    }

}

final class TareaRecordatorioConcreta extends TareaRecordatorio {

    public function agregar($datos) {
        // Se implementa la lógica para agregar recordatorio de contacto

                // Obtener el nombre del contacto para el que se agregarán recordatorios
                $nombreContacto = $datos['nombre'] ?? '';
    
                // Obtener el recordatorio, la hora y la fecha del formulario
                $recordatorio = $datos['recordatorio'] ?? '';
                $hora = $datos['hora'] ?? '';
                $fecha = $datos['fecha'] ?? '';
            
                // Verificar si el nombre del contactol, el recordatorio, la hora y la fecha si no están vacíos
                if (!empty($nombreContacto) && !empty($recordatorio) && !empty($hora) && !empty($fecha)) {
                    // Crear una estructura de datos para almacenar los datos
                    $nuevoRecordatorio = [
                        'nombreContacto' => $nombreContacto,
                        'recordatorio' => $recordatorio,
                        'hora' => $hora,
                        'fecha'=> $fecha
                    ];
            
                    // Verificar si el contacto ya tiene recordatorios almacenados
                    if (isset($_SESSION['recordatorios'])) {
                        // Agregar la nueva tarea al array de recordatorio del contacto existente
                        $_SESSION['recordatorios'][] = $nuevoRecordatorio;
                    } else {
                        
                        $_SESSION['recordatorios'] = array($nuevoRecordatorio);
                    }
                } else {
                    
                    echo "Por favor, complete los campos de Recordatorio, hora y fecha.";
                }
    }

    public function eliminar($indice) {
        // Implementa la lógica para eliminar el recordatorio
        if (isset($_SESSION['recordatorios'][$indice])) {
            unset($_SESSION['recordatorios'][$indice]);
        }
    }

    public function mostrarDetalles($indice) {
        // Implementa la lógica para mostrar detalles del recordatorio
        if (isset($_SESSION['recordatorios'][$indice])) {
            $recordatorios = $_SESSION['recordatorios'][$indice];
            echo "<script>
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                 </script>";
            echo "<ul>
                    <li><strong>Nombre:</strong> {$recordatorios['nombreContacto']}</li>
                    <li><strong>Recordatorio:</strong> {$recordatorios['recordatorio']}</li>
                    <li><strong>Hora:</strong> {$recordatorios['hora']}</li>
                    <li><strong>Fecha:</strong> {$recordatorios['fecha']}</li>
                  </ul>";
        }
    }
}

?>