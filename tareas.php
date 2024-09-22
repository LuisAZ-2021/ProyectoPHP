<?php

//Creo la interface Tarea para luego utilizarlas en las clases siguientes
interface Tarea{

    public function agregar($datos);
    public function eliminar($indice);
    public function mostrarDetalles($indice);

}

//Creo las distintas clases abstractas para cada tarea que tiene que implementar la interface Tarea
abstract class TareaContacto implements Tarea
{
    public function agregar($datos){
        echo "agregar";
    }
    public function eliminar($indice){
        echo "eliminar";
    }
    public function mostrarDetalles($indice){
        echo "mostrar detalles";
    }
}

abstract class TareaProceso implements Tarea
{
    public function agregar($datos){
        echo "agregar";
    }
    public function eliminar($indice){
        echo "eliminar";
    }
    public function mostrarDetalles($indice){
        echo "mostrar detalles";
    }

}

abstract class TareaRecordatorio implements Tarea
{
    public function agregar($datos){
        echo "agregar";
    }
    public function eliminar($indice){
        echo "eliminar";
    }
    public function mostrarDetalles($indice){
        echo "mostrar detalles";
    }
}   

?>