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
        
        switch ($tipo) {
            
            /**
             * Clausulas específicas
             */
            case 'insertarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.eps ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nit,';                
                $cadenaSql .= 'id_ubicacion,';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'direccion,';
                $cadenaSql .= 'telefono,';
                $cadenaSql .= 'ext_telefono,';
                $cadenaSql .= 'fax,';
                $cadenaSql .= 'ext_fax,';
                $cadenaSql .= 'nom_representante,';
                $cadenaSql .= 'email,';
                $cadenaSql .= 'estado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $variable ['nitRegistro'] . ', ';
                $cadenaSql .= $variable ['id_ubicacion'] . ', ';
                $cadenaSql .= '\'' . $variable ['nombreRegistro']  . '\', ';
                $cadenaSql .= '\'' . $variable ['direccionRegistro']  . '\', ';
                $cadenaSql .= $variable ['telefonoRegistro'] . ', ';
                $cadenaSql .= $variable ['extTelefonoRegistro'] . ', ';
                $cadenaSql .= $variable ['faxRegistro'] . ', ';
                $cadenaSql .= $variable ['extFaxRegistro'] . ', ';
                $cadenaSql .= '\'' . $variable ['nomRepreRegistro'] . '\', ';
                $cadenaSql .= '\'' . $variable ['emailRegistro'] . '\', ';
                $cadenaSql .= '\'' . 'Activo' . '\' ';
                $cadenaSql .= ') ';
                break;
            
                
             case 'buscarRegistroxEPS' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'nit as NIT, ';
                        $cadenaSql .= 'nombre as NOMBRE, ';
                        $cadenaSql .= 'estado as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.eps ';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'nombre=\'' . $_REQUEST ['usuario']  . '\' AND ';
//                        $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';
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
                            
                        case 'buscarIdUbicacion' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ubicacion as ID_UBICACION ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.ubicacion ';
				$cadenaSql .= 'WHERE ';
                                $cadenaSql .= 'id_pais = ';
                                $cadenaSql .=  112 . ' AND ';
                                $cadenaSql .= 'id_departamento = '; 
                                $cadenaSql .= $variable ['fdpDepartamento'] . ' AND ';
                                $cadenaSql .= 'id_ciudad = ';
                                $cadenaSql .= $variable ['fdpCiudad'] . ';';
				break;  
                       case 'buscarUbicacion' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
                                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.ubicacion ';
				$cadenaSql .= 'WHERE ';
                                $cadenaSql .= 'id_ubicacion = ';
                                $cadenaSql .= $variable .'';
		       break;   
                       case 'buscarCiudadUbicacion' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre as NOMBRE, ';
                                $cadenaSql .= 'departamento as DEPARTAMENTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.ciudad ';
				$cadenaSql .= 'WHERE ';
                                $cadenaSql .= 'id_ciudad = ';
                                $cadenaSql .= $variable .'';
		       break; 
               case 'insertarUbicacion' :
				
        	$cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'otro.ubicacion ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'id_pais,';                
                $cadenaSql .= 'id_departamento,';
                $cadenaSql .= 'id_ciudad';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= 112 . ', ';
                $cadenaSql .= $variable ['fdpDepartamento'] . ', ';
                $cadenaSql .= $variable ['fdpCiudad'] . '';
                $cadenaSql .= ') ';
				break;  
             
                case 'buscarModificarxEPS' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'nit as NIT, ';
                        $cadenaSql .= 'id_ubicacion as ID_UBICACION, ';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'direccion as DIRECCION,';
                        $cadenaSql .= 'telefono as TELEFONO,';
                        $cadenaSql .= 'ext_telefono as EXT_TELEFONO, ';
                        $cadenaSql .= 'fax as FAX, ';
                        $cadenaSql .= 'ext_fax as EXT_FAX, ';
                        $cadenaSql .= 'nom_representante as NOM_REPRESENTANTE, ';
                        $cadenaSql .= 'email as EMAIL ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.eps';
                        
                break;       
            
             case 'buscarVerdetallexEPS' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'nit as NIT, ';
                        $cadenaSql .= 'id_ubicacion as ID_UBICACION, ';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'direccion as DIRECCION,';
                        $cadenaSql .= 'telefono as TELEFONO,';
                        $cadenaSql .= 'ext_telefono as EXT_TELEFONO, ';
                        $cadenaSql .= 'fax as FAX, ';
                        $cadenaSql .= 'ext_fax as EXT_FAX, ';
                        $cadenaSql .= 'nom_representante as NOM_REPRESENTANTE, ';
                        $cadenaSql .= 'email as EMAIL, ';
                        $cadenaSql .= 'estado as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.eps';
                        
                break;
                
            case 'modificarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.eps ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'id_ubicacion = ';
                $cadenaSql .= $variable ['id_ubicacion'] . ', ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= '\'' . $variable ['nombreRegistro']  . '\', ';
                $cadenaSql .= 'direccion = ';
                $cadenaSql .= '\'' . $variable ['direccionRegistro']  . '\', ';
                $cadenaSql .= 'telefono = ';
                $cadenaSql .= $variable ['telefonoRegistro'] . ', ';
                $cadenaSql .= 'ext_telefono = ';
                $cadenaSql .= $variable ['extTelefonoRegistro'] . ', ';
                $cadenaSql .= 'fax = ';
                $cadenaSql .= $variable ['faxRegistro'] . ', ';
                $cadenaSql .= 'ext_fax = ';
                $cadenaSql .= $variable ['extFaxRegistro'] . ', ';
                $cadenaSql .= 'nom_representante = ';
                $cadenaSql .= '\'' . $variable ['nomRepreRegistro'] . '\', ';
                $cadenaSql .= 'email = ';
                $cadenaSql .= '\'' . $variable ['emailRegistro'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= $variable ['nitRegistro'] . ' ';
                break;
               
              case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.eps ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= '\'' . $variable ['estadoRegistro']  . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= '\'' . $variable ['nitRegistro']  . '\'';
              break;
            
        
        }
        
        return $cadenaSql;
    
    }
}
?>
