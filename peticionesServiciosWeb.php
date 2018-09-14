<?php
extract($_REQUEST);
include "../Modelo/Conexion.php";
include "../Modelo/DatosAprendiz.php";
error_reporting(1);

 $objDatosAprendiz = new DatosAprendiz();
$retorno = array('datos','mensaje');
                   
//eL Método Post se Utiliza para hacer actualizaciones, eliminar, insertar....
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_REQUEST['opcion']){   
        case 1: //consultar mediante ajax
            //$identificación se recibe del llamado mediante aja
            $resultado=$objDatosAprendiz->obtenerAprendizXIdentificacion($identificacion);
            if ($resultado->estado==true){
                if ($resultado->datos->rowCount()>0){
                    $aprendiz = $resultado->datos->fetchObject();
                    $retorno["datos"]=$aprendiz;   
                     $retorno["mensaje"]=$resultado->mensaje;
                   
                }else{
                   $retorno["datos"]=null;  
                   $retorno["mensaje"]="No existe aprendiz con esa identificación";
                }
            }else{
               $retorno["datos"]=null;
               $retorno["mensaje"]=$resultado->mensaje;
            }
            
            echo json_encode($retorno);
            break;

        case 2: //listar los empleados

            $resultado=$objDatosAprendiz->obtenerAprendices();
            if ($resultado->estado){
              if ($resultado->datos->rowCount()>0){   
                while($aprendiz = $resultado->datos->fetchObject()){
                    $retorno['datos'][] = $aprendiz;
                }
                $retorno["mensaje"]=$resultado->mensaje;
              }else{
                   $retorno['datos'] = null;
                   $retorno["mensaje"]="No hay aprendices registrados";
              }
            }else{
                $empleados['datos']=$resultado->datos;  
                $retorno["mensaje"]=$resultado->mensaje;
            }           
            echo json_encode($retorno);
            break;        
    }
}