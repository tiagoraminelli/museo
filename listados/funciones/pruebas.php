<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/pieza.php");
require_once("../../modelo/datos_eliminados.php");
$registro = new DatosEliminados();
$tabla  = $registro->getTablasRelacionadasConPieza(40);
$datosTraidos = $registro->getDatosEliminadosByPiezaId(40);
var_dump($datosTraidos);
$save =  $registro->restorePiezaByTable(40);
 
if($save){
echo "se realizo el restaurado de la tabla: ";
}