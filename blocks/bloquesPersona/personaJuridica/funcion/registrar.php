<?php

namespace bloquesPersona\personaJuridica\funcion;


include_once('Redireccionador.php');

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
       
        if(isset($_REQUEST['personaJuridicaIdentificacion'])){
                    switch($_REQUEST ['personaJuridicaIdentificacion']){
                           case 1 :
					$_REQUEST ['personaJuridicaIdentificacion']='4';
			   break;
                       
                           case 2 :
					$_REQUEST ['personaJuridicaIdentificacion']='5';
			   break;
                           
                    }
                }
                
                if(isset($_REQUEST['compuesto'])){
                    switch($_REQUEST ['compuesto']){
                           case 1 :
					$_REQUEST ['compuesto']='SI';
			   break;
                       
                           case 2 :
					$_REQUEST ['compuesto']='NO';
			   break;
                    }
                }
                
                if(isset($_REQUEST['autorretenedor'])){
                    switch($_REQUEST ['autorretenedor']){
                           case 1 :
					$_REQUEST ['autorretenedor']='Si';
			   break;
                       
                           case 2 :
					$_REQUEST ['autorretenedor']='No';
			   break;
                    }
                }
                
                if(isset($_REQUEST['GranContribuyente'])){
                	switch($_REQUEST ['GranContribuyente']){
                		case 1 :
                			$_REQUEST ['GranContribuyente']='Si';
                			break;
                			 
                		case 2 :
                			$_REQUEST ['GranContribuyente']='No';
                			break;
                	}
                }
                
                $datos = array(
                		'tipoDocumento' => $_REQUEST['personaJuridicaIdentificacion'],
                		'numeroDocumento' => $_REQUEST['personaJuridicaDocumento'],
                		'razonSocial' => $_REQUEST['razonSocial'],
                		'compuesto' => $_REQUEST['compuesto'],
                		'contribuyente' => $_REQUEST['GranContribuyente'],
                		'autorretenedor' => $_REQUEST['autorretenedor']
                		
                );
         
          
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarRegistroBasico",$datos);
        $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        
//         $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarRegistroComercial",$datos);
//         $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
        Redireccionador::redireccionar('form');
    	        
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

