<?php
extract($_REQUEST);
include "../Modelo/Conexion.php";
include "../Modelo/Aprendiz.php";
include "../Modelo/DatosAprendiz.php";
error_reporting(1);

$archivo = fopen("aprendices2.csv", 'r');
$fila=0;
$aprendiz = new Aprendiz();
$datosAprendiz = new DatosAprendiz();

while($registro = fgetcsv($archivo,1000,';')){
    $aprendiz->setIdentificacion(utf8_decode($registro[0]));
    $aprendiz->setNombres(utf8_decode($registro[1]));
    $aprendiz->setApellidos(utf8_decode($registro[2]));   
    $aprendiz->setCorreo($registro[3]);
   // print_r($aprendiz);
    $datosAprendiz->agregarAprendiz($aprendiz);
 }
fclose($archivo);

echo "Listo";

