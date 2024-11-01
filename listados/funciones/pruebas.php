<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/pieza.php");
require_once("../../modelo/datos_eliminados.php");
$registro = new DatosEliminados();
$tabla  = $registro->getTablasRelacionadasConPieza(28);
//$datosTraidos = $registro->getDatosEliminadosByPiezaId(40);
$datosEliminados = $registro->getDatosEliminadosByPiezaId(28);
echo "<pre>";
echo "</pre>";

echo "<pre>";
//var_dump($datosTraidos);
echo "</pre>";
echo "<pre>";
var_dump($datosEliminados);
echo "</pre>";

//$save =  $registro->restorePiezaByTable(28);
 
if($save){
echo "se realizo el restaurado de la tabla: ";
}else{
    echo "error";
}