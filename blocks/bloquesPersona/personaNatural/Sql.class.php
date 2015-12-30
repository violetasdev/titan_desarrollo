<?php

namespace bloquesModelo\bloqueContenido;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */



class Sql extends \Sql {
    
    var $miConfigurador;
    
    function getCadenaSql($tipo, $variable = '') {
        
        
        
        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
        $idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
        $cadenaSql='';
        switch ($tipo) {
            
            /**
             * Clausulas específicas
             */
            case 'insertarRegistroBasico' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'persona.persona_natural ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'documento,';
                $cadenaSql .= 'tipodocumento,';
                $cadenaSql .= 'consecutivo,';
                $cadenaSql .= 'primer_nombre,';
                $cadenaSql .= 'segundo_nombre,';
                $cadenaSql .= 'primer_apellido,';
                $cadenaSql .= 'segundo_apellido,';
                $cadenaSql .= 'gran_contribuyente,';
                $cadenaSql .= 'autoretenedor,';
                $cadenaSql .= 'regimen_tributario,';
                $cadenaSql .= 'estado_solicitud,';
                $cadenaSql .= 'soporte_documento';
            	$cadenaSql .= ') ';
            	$cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
            	$cadenaSql .= $_REQUEST ['personaNaturalDocumento']. ', ';
            	$cadenaSql .= $_REQUEST ['personaNaturalIdentificacion'] . ', ';
            	$cadenaSql .= '2' . ', ';
            	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalPrimerNombre'] . '\''.', ';
            	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalSegundoNombre'].'\''. ', ';
            	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalPrimerApellido'] . '\''. ', ';
            	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalSegundoApellido'] .'\''. ', ';
            	$cadenaSql .= $_REQUEST ['personaNaturalContribuyente'] .  ', ';
            	$cadenaSql .= $_REQUEST ['personaNaturalAutorretenedor'] . ', ';
            	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalRegimen'] .'\''. ', ';
//             	$cadenaSql .= '\'' . $_REQUEST ['emailRegistro'] . '\''. ', ';
            	$cadenaSql .= '\'' . 'Modificable' . '\' ';
            	$cadenaSql .= ') ';
                break;
            
          case 'insertarRegistroComercial' :
                	$cadenaSql = 'INSERT INTO ';
                	$cadenaSql .= 'persona.info_comercial ';
                	$cadenaSql .= '( ';
                	$cadenaSql .= 'consecutivo,';
                	$cadenaSql .= 'banco,';
                	$cadenaSql .= 'tipo_cuenta,';
                	$cadenaSql .= 'numero_cuenta,';
                	$cadenaSql .= 'tipo_pago,';
                	$cadenaSql .= 'estado,';
                	$cadenaSql .= 'fecha_creacion,';
                	$cadenaSql .= 'usuario_creo,';
                	$cadenaSql .= 'soporte_rut';
                	$cadenaSql .= ') ';
                	$cadenaSql .= 'VALUES ';
                	$cadenaSql .= '( ';
                	$cadenaSql .= $_REQUEST ['personaNaturalConsecutivo']. ', ';
                	$cadenaSql .= $_REQUEST ['personaNaturalBanco'] . ', ';
                	$cadenaSql .= $_REQUEST ['personaNaturalTipoCuenta'] . ', ';
                	$cadenasql .= $_REQUEST ['personaNaturalNumeroCuenta'] . ', ';
                	$cadenasql .= $_REQUEST ['personaNaturalTipoPago'] . ', ';
                	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalPrimerNombre'] . '\''.', ';
                	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalSegundoNombre'].'\''. ', ';
                	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalPrimerApellido'] . '\''. ', ';
                	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalSegundoApellido'] .'\''. ', ';
                	$cadenaSql .= $_REQUEST ['personaNaturalContribuyente'] .  ', ';
                	$cadenaSql .= $_REQUEST ['personaNaturalAutorretenedor'] . ', ';
                	$cadenaSql .= '\'' .$_REQUEST ['personaNaturalRegimen'] .'\''. ', ';
                	//             	$cadenaSql .= '\'' . $_REQUEST ['emailRegistro'] . '\''. ', ';
                	$cadenaSql .= '\'' . 'Activo' . '\' ';
                	$cadenaSql .= ') ';
                	break;
            
          
                
             case 'buscarRegistroxCargo' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'documento as DOCUMENTO, ';
                        $cadenaSql .= 'primer_nombre as PRIMER_NOMBRE, ';
                        $cadenaSql .= 'segundo_nombre as SEGUNDO_NOMBRE,';
                        $cadenaSql .= 'primer_apellido as PRIMER_APELLIDO,';
                        $cadenaSql .= 'segundo_apellido as SEGUNDO_APELLIDO,';
                        $cadenaSql .= 'regimen_tributario as REGIMEN_TRIBUTARIO, ';
                        $cadenaSql .= 'estado_solicitud as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'persona.persona_natural';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'ESTADO=\'' .'modificabl'. '\' OR ';
//                        $cadenaSql .= 'ESTADO=\'' . 'rechazada' . '\' ';
                        
                break;
                
              
                	
                case 'buscarModificarxPersona' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'documento as DOCUMENTO, ';
                        $cadenaSql .= 'primer_nombre as PRIMER_NOMBRE, ';
                        $cadenaSql .= 'segundo_nombre as SEGUNDO_NOMBRE,';
                        $cadenaSql .= 'primer_apellido as PRIMER_APELLIDO,';
                        $cadenaSql .= 'segundo_apellido as SEGUNDO_APELLIDO,';
                        $cadenaSql .= 'regimen_tributario as REGIMEN_TRIBUTARIO, ';
                        $cadenaSql .= 'estado_solicitud as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'persona.persona_natural';
                        
                break;
            
            
            case 'buscarVerdetallexCargo' :
                
               	$cadenaSql = 'SELECT ';
                $cadenaSql .= 'documento as	DOCUMENTO, ';
                $cadenaSql .= 'tipodocumento as TIPO_DOCUMENTO, ';
                $cadenaSql .= 'consecutivo as CONSECUTIVO, ';
                $cadenaSql .= 'primer_nombre as PRIMER_NOMBRE, ';
                $cadenaSql .= 'segundo_nombre as SEGUNDO_NOMBRE, ';
                $cadenaSql .= 'primer_apellido as PRIMER_APELLIDO, ';
                $cadenaSql .= 'segundo_apellido as SEGUNDO_APELLIDO, ';
                $cadenaSql .= 'gran_contribuyente as CONTRIBUYENTE, ';
                $cadenaSql .= 'autoretenedor as AUTORRETENEDOR, ';
                $cadenaSql .= 'regimen_tributario as REGIMEN ';
                $cadenaSql .= 'estado_solicitud as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'persona.persona_natural';
                        
                break;

            case 'modificarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.cargo ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'nivel = ';
                $cadenaSql .= $variable ['nivelRegistro'] . ', ';
                $cadenaSql .= 'grado = ';
                $cadenaSql .= $variable ['gradoRegistro'] . ', ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= '\'' . $variable ['nombreRegistro']  . '\', ';
                $cadenaSql .= 'sueldo = ';
                $cadenaSql .= $variable ['sueldoRegistro'] . ', ';
                $cadenaSql .= 'tipo_sueldo = ';
                $cadenaSql .= '\'' . $variable['tipoSueldoRegistro'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'codigo_cargo = ';
                $cadenaSql .= '\'' . $variable ['codigoRegistro']  . '\'';
                break;
                
             case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.cargo ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= '\'' . $variable ['estadoRegistro']  . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'codigo_cargo = ';
                $cadenaSql .= '\'' . $variable ['codigoRegistro']  . '\'';
                break;
                
                case 'buscarPais' :
                
                	$cadenaSql = 'SELECT ';
                	$cadenaSql .= 'id_pais as ID_PAIS, ';
                	$cadenaSql .= 'nombre_pais as NOMBRE ';
                	$cadenaSql .= 'FROM ';
                	$cadenaSql .= 'otro.pais';
                	break;
                		
                case 'buscarDepartamento' ://Provisionalmente solo Departamentos de Colombia
                
                	$cadenaSql = 'SELECT ';
                	$cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                	$cadenaSql .= 'nombre as NOMBRE ';
                	$cadenaSql .= 'FROM ';
                	$cadenaSql .= 'otro.departamento ';
                	$cadenaSql .= 'WHERE ';
                	$cadenaSql .= 'id_pais = 112;';
                	break;
                	 
                case 'buscarDepartamentoAjax' :
                
                	$cadenaSql = 'SELECT ';
                	$cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                	$cadenaSql .= 'nombre as NOMBRE ';
                	$cadenaSql .= 'FROM ';
                	$cadenaSql .= 'otro.departamento ';
                	$cadenaSql .= 'WHERE ';
                	$cadenaSql .= 'id_pais = ' . $variable . ';';
                	break;
                	 
                case 'buscarCiudad' : //Provisionalmente Solo Ciudades de Colombia sin Agrupar
                
                	$cadenaSql = 'SELECT ';
                	$cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
                	$cadenaSql .= 'nombre as NOMBRE ';
                	$cadenaSql .= 'FROM ';
                	$cadenaSql .= 'otro.ciudad ';
                	$cadenaSql .= 'WHERE ';
                	$cadenaSql .= 'ab_pais = \'CO\';';
                	break;
                
                case 'buscarCiudadAjax' :
                
                	$cadenaSql = 'SELECT ';
                	$cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
                	$cadenaSql .= 'nombre as NOMBRECIUDAD ';
                	$cadenaSql .= 'FROM ';
                	$cadenaSql .= 'otro.ciudad ';
                	$cadenaSql .= 'WHERE ';
                	$cadenaSql .= 'id_departamento = ' . $variable . ';';
                	break;
        
        }
        
       
        
        return $cadenaSql;
    
    }
}
?>