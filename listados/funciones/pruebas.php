<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/pieza.php");
require_once("../../modelo/datos_eliminados.php");
require_once ("../../modelo/arqueologia.php");
require_once ("../../modelo/paleontologia.php");
require_once ("../../modelo/osteologia.php");
require_once ("../../modelo/geologia.php");
require_once ("../../modelo/ictiologia.php");
require_once ("../../modelo/botanica.php");
require_once ("../../modelo/octologia.php");
require_once ("../../modelo/zoologia.php");
/*

echo "<h1>"."pruebas.php"."</h1>"."<br>";

$clase = new octologia();
$datos = $clase->buscarOctologias("1");
echo "<pre>";
var_dump($datos);
echo "</pre>";
 */