<?php

namespace bloquesModelo\bloqueContenido\funcion;


include_once('RedireccionadorEPS.php');

class FormProcessor {
    
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;
    
    function __construct($lenguaje, $sql) {
        
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    
    }
    
    function procesarFormulario() {    

        //Aquí va la lógica de procesamiento
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
       
        
                
                
        
         $datos = array(
            'nitRegistro' => $_REQUEST ['nitRegistro'],
            'nombreRegistro' => $_REQUEST ['nombreRegistro'],
            'direccionRegistro' => $_REQUEST ['direccionRegistro'],
            'telefonoRegistro' => $_REQUEST ['telefonoRegistro'],
            'extTelefonoRegistro' => $_REQUEST ['extTelefonoRegistro'],
            'faxRegistro' => $_REQUEST ['faxRegistro'],
            'extFaxRegistro' => $_REQUEST ['extFaxRegistro'],
            'lugarRegistro' => $_REQUEST ['lugarRegistro'],
            'nomRepreRegistro' => $_REQUEST ['nomRepreRegistro'],
            'emailRegistro' => $_REQUEST ['emailRegistro']
        );
//       
        
                
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modificarRegistro",$datos);
        $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
        RedireccionadorEPS::redireccionar('form');
    	        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }
    
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado= $miProcesador->procesarFormulario ();

