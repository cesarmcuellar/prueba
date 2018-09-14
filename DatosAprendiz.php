<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatosEmpleado
 *
 * @author CesarCuellar
 */
class DatosAprendiz {
    //put your code here
    private $miConexion;   
    private $retorno;
    
    public function __construct() {
        $this->miConexion = Conexion::singleton();
        $this->retorno = new stdClass();
    }
    
    /**
     * Agrega un empleado a la base de datos
     * @param Empleado $unEmpleado
     * @param type $rol
     * @return type
     */
    public function agregarAprendiz(Aprendiz $unAprendiz){           
        try{            
            //agregar tabla aprendices
            $consulta="insert into aprendices2 values(null,?,?,?,?)";
            $resultado=$this->miConexion->prepare($consulta);
            $resultado->bindParam(1,$unAprendiz->getIdentificacion());
            $resultado->bindParam(2,$unAprendiz->getNombres());
            $resultado->bindParam(3,$unAprendiz->getApellidos());
            $resultado->bindParam(4,$unAprendiz->getCorreo());
            $resultado->execute();               
            $this->retorno->estado=true;
            $this->retorno->datos=$resultado;
            $this->retorno->mensaje="Empleado agregado correctamente";            
        } catch (PDOException $ex) {
            $this->mensaje=$ex->getMessage();          
            $this->retorno->estado=false;
            $this->retorno->datos=null;
            $this->retorno->mensaje=$this->mensaje;
        }        
        return $this->retorno;
    }
    
    /**
     * Método que obtiene el listado de todos los empledos
     * @return type stdclass
     */
    public function obtenerAprendices(){
        try{
            $consulta="select * from aprendices";
            $resultado=$this->miConexion->query($consulta);
            $this->retorno->estado=true;
            $this->retorno->datos=$resultado;
            $this->retorno->mensaje="Listado de Aprendices";            
        } catch (PDOException $ex) {
            $this->retorno->estado=false;
            $this->retorno->datos=null;
            $this->retorno->mensaje=$ex->getMessage();
        }
        return $this->retorno;
    }

    /**
     * Método que obtiene los datos del empleado por su # de documento
     * @param type string $identificacion
     * @return type stdclass
     */
    public function obtenerAprendizXIdentificacion($identificacion){
        $this->mensaje=null;        
        try{
            $consulta="select * from aprendices where aprIdentificacion=?";
            $resultado=$this->miConexion->prepare($consulta);
            $resultado->bindParam(1,$identificacion);
            $resultado->execute();
            $this->retorno->estado=true;
            $this->retorno->datos=$resultado;
            $this->retorno->mensaje="Datos del Aprendiz";            
        } catch (PDOException $ex) {
            $this->retorno->estado=false;
            $this->retorno->datos=null;
            $this->retorno->mensaje=$ex->getMessage();
        }        
        return $this->retorno;
    }
    
    public function obtenerEmpleadosPorValor($valor){
        try{
            $consulta = "select personas.*, empleados.* from personas "
             ." inner join empleados on empleados.empPersona=personas.idPersona"
            . " where (personas.perIdentificacion like ?) or (personas.perNombres like ?)"
            . " or (personas.perApellidos like ?) or (personas.perCorreo like ?)"
            . " or (empleados.empCargo like ?)";             
            $valor="%".$valor."%";
            $resultado=$this->miConexion->prepare($consulta);
            $resultado->bindParam(1, $valor);
            $resultado->bindParam(2,$valor);
            $resultado->bindParam(3,$valor);
            $resultado->bindParam(4,$valor);
            $resultado->bindParam(5,$valor);
            $resultado->execute();
            $this->retorno->estado=true;
            $this->retorno->datos=$resultado;
            $this->retorno->mensaje="Listado de Empleados";            
        } catch (PDOException $ex) {
            $this->retorno->estado=false;
            $this->retorno->datos=null;
            $this->retorno->mensaje=$ex->getMessage();
        }
        return $this->retorno;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getRetorno() {
        return $this->retorno;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setRetorno($retorno) {
        $this->retorno = $retorno;
    }


    
}



