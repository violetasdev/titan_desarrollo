<?php
namespace bloquesNovedad\bloqueHojadeVida\bloqueFuncionario\formulario;

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


class Formulario {

	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;

	function __construct($lenguaje, $formulario, $sql) {

		$this->miConfigurador = \Configurador::singleton ();

		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

		$this->lenguaje = $lenguaje;

		$this->miFormulario = $formulario;

		$this->miSql = $sql;

	}

	function formulario() {

		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */

		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		* Atributos que deben ser aplicados a todos los controles de este formulario.
		* Se utiliza un arreglo
		* independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		*
		* Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		* $atributos= array_merge($atributos,$atributosGlobales);
		*/
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST['tiempo']=time();

		$conexion = 'estructura';
		$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

		//var_dump($primerRecursoDB);
		//exit;

		// -------------------------------------------------------------------------------------------------

		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;

		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';

		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';

		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = false;
		//$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );

		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------

		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );

		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		// ---------------- CONTROL: Cuadro Mensaje Titulo --------------------------------------------------
		 
		$esteCampo = 'bloqueContenidoBusqueda';
		$atributos['texto'] = ' ';
		$atributos['estilo'] = 'jqueryui';
		$atributos['etiqueta'] = "<h2>".$this->lenguaje->getCadena ( $esteCampo )."</h2>";
		$tab ++;
		 
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoTexto( $atributos );
		 
		// --------------------------------------------------------------------------------------------------
		
		
		$esteCampo = "novedadesBusqueda";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		{
			// ---------------- CONTROL: Cuadro Mensaje SubTitulo -----------------------------------------------
			 
			$esteCampo = 'nombresBusqueda';
			$atributos['texto'] = ' ';
			$atributos['estilo'] = 'text-success';
			$atributos['etiqueta'] = "<h4>".$this->lenguaje->getCadena ( $esteCampo )."</h4>";
			$tab ++;
			 
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTexto( $atributos );
			 
			// --------------------------------------------------------------------------------------------------
				    
			// ---------------- CONTROL: Tabla --------------------------------------------------------
			
			// ---------------- CONTROL: Tabla Cargos sin Sara -----------------------------------------------
			
			$atributos['cadena_sql'] = $this->miSql->getCadenaSql("buscarRegistroUsuario");
			//$atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarRegistroxCargo");
			$matrizItems=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
			$longitud = count($matrizItems);
			
			$i=0;
			//echo '<div class="click">Click me to Disable/Enable a html button</div>';
			
			echo '<table id="tablaReporte" class="display" cellspacing="0" width="100%"> '
					. '<thead style="display: table-row-group">
						<tr>
							<th>'."CEDULA".'</th>
							<th>'."NOMBRE".'</th> 
							<th>'."APELLIDO".'</th> 
                            <th>'."FECHA REG".'</th> 
                            <th>'."CIUDAD".'</th>
                            <th>'."ESTADO".'</th>		
                            <th>'."GESTION".'</th>
                         </tr>
                        </thead>
                       <tfoot  style="display: table-header-group">
            <tr>
                <th>cedula</th>
                <th>nombre</th>
                <th>apellido</th>
                <th>fecha reg</th>
                <th>ciudad</th>
                <th>estado</th>
                <td>Acceso</td>
            </tr>
        	</tfoot>
                    <tbody>';
					
			
					while($i<$longitud){
						echo "<tr><td>".$matrizItems[$i][0]."</td>";
						echo "<td>".$matrizItems[$i][1]."</td>";
						echo "<td>".$matrizItems[$i][2]."</td>";
						echo "<td>".$matrizItems[$i][3]."</td>";
						//echo "<td>".$matrizItems[$i][4]."</td>";
						//echo "<td>".$matrizItems[$i][5]."</td>";
						//echo "<td>".$matrizItems[$i][6]."</td>";
						echo "<td>".$matrizItems[$i][7]."</td>";
						echo "<td>".$matrizItems[$i][8]."</td>";
						$estadoBusqueda = $matrizItems[$i][8];
						if($estadoBusqueda != "Aprobado"){
							echo "<td><input id=\"Button_".$i."\" class=\"btn btn-primary\" type=\"button\"
								value=\"Seleccionar\" disabled='disabled'/></td></tr>";
							
							//var_dump("ENTRA 1.... ".$matrizItems[$i][8]);
							
						}else{
							echo "<td><input id=\"Button_".$i."\" class=\"btn btn-primary\" type=\"button\"
								value=\"Seleccionar\" enabled='enabled'/></td></tr>";
							
							//var_dump("ENTRA 2.... ".$matrizItems[$i][8]);
						}
						
						/*
						//var_dump("Estado".$matrizItems[$i][8]);
						$esteCampo = 'botonActivarRegistro';
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab;
						$atributos ["tipo"] = 'boton';
						// submit: no se coloca si se desea un tipo button genérico
						//$atributos ['submit'] = true;
						$atributos ['deshabilitado'] = true;
						$atributos ["estiloMarco"] = '';
						$atributos ["estiloBoton"] = 'jqueryui';
						// verificar: true para verificar el formulario antes de pasarlo al servidor.
						$atributos ["verificar"] = '';
						$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
						$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
						//$tab ++;
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo "<td>".$this->miFormulario->campoBoton ( $atributos ). "</td></tr>";*/
						
						/*
						$esteCampo = 'botonModificar';
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab;
						$atributos ["tipo"] = 'boton';
						// submit: no se coloca si se desea un tipo button genérico
						$atributos ['submit'] = true;
						$atributos ["estiloMarco"] = '';
						$atributos ["estiloBoton"] = 'jqueryui';
						// verificar: true para verificar el formulario antes de pasarlo al servidor.
						$atributos ["verificar"] = '';
						$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
						$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
						//$tab ++;
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoBoton ( $atributos );
						$esteCampo = 'botonInactivar';
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab;
						$atributos ["tipo"] = 'boton';
						// submit: no se coloca si se desea un tipo button genérico
						$atributos ['submit'] = true;
						$atributos ["estiloMarco"] = '';
						$atributos ["estiloBoton"] = 'jqueryui';
						// verificar: true para verificar el formulario antes de pasarlo al servidor.
						$atributos ["verificar"] = '';
						$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
						$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
						$tab ++;
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoBoton ( $atributos ). "</td></tr>";*/
			
			
						$i+=1;
					}
					echo '</tbody></table>';
					 
			
			
			
			
			
			
			//$matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
			
			//var_dump($this->miSql->getCadenaSql("buscarRegistroUsuario"));
			//var_dump($primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda"));
			
			//$atributos['cadena_sql'] = $this->miSql->getCadenaSql("buscarRegistroUsuarioWhere");
			
			//var_dump($this->miSql->getCadenaSql("buscarRegistroUsuarioWhere"));
			//$matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
			
	// 		$a = 0;
			
	// 		foreach ($_REQUEST as $key => $values) {
			
	// 			$datos[0][$a] = $_REQUEST[$key];
	// 			$datos[0][$key] =$_REQUEST[$key];
	// 			$a++;
	// 		}
			
			//echo $this->miFormulario->tablaReporte($matrizItems);
			
		}
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		
		$esteCampo = "novedadesOpcionesRegistro";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		{
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioDocumentoBusqueda';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			 
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, minSize[5], custom[onlyNumberSp]';
			 
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 15;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			 
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				    
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioNombre';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			 
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, minSize[1], custom[onlyLetterSp]';
			 
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 30;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			 
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			 
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioApellido';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			 
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, minSize[1], custom[onlyLetterSp]';
			 
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 30;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			 
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				    
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioCantidadRegistroSuperior';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			 
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, custom[onlyNumberSp]';
			 
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 10;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			 
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				    
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioCantidadRegistroInformal';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, custom[onlyNumberSp]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 10;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioCantidadRegistroIdioma';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, custom[onlyNumberSp]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 10;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioCantidadRegistroExperiencia';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, custom[onlyNumberSp]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 10;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'funcionarioCantidadRegistroReferencia';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['estiloEtiqueta'] = 'labelTamano';
			
			$atributos ['obligatorio'] = true;
			$atributos ['etiquetaObligatorio'] = true;
			$atributos ['validar'] = 'required, maxSize[2], custom[onlyNumberSp]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 10;
			$atributos ['maximoTamanno'] = '';
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
		}
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botonesUsuario";
		$atributos ["estilo"] = "marcoBotones";
		$atributos ["titulo"] = "Entrar a Registro";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonRegistrarBusqueda';
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab;
		$atributos ["tipo"] = 'boton';
		// submit: no se coloca si se desea un tipo button genérico
		$atributos ['submit'] = true;
		$atributos ["estiloMarco"] = '';
		$atributos ["estiloBoton"] = 'jqueryui';
		// verificar: true para verificar el formulario antes de pasarlo al servidor.
		$atributos ["verificar"] = '';
		$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		
	    // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
        */

        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:

        // Paso 1: crear el listado de variables

        //$valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
        $valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );//Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=registrar"; //Opcion para Switch Case ------
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. 
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // ----------------FIN SECCION: Paso de variables -------------------------------------------------

        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------

        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario ( $atributos );

        return true;

    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
        $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );

        if ($mensaje) {

            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );

            if ($tipoMensaje == 'json') {

                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje ( $atributos );
            unset ( $atributos );

             
        }

        return true;

    }
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );


$miFormulario->formulario ();
$miFormulario->mensaje ();
/*
echo "DATOS DIGITADOS POR EL USUARIO"."<br/>";

//var_dump($_REQUEST["personaCarrera"]);

//echo "Nombre Digitado es: ".$_REQUEST["personaNombre"]."<br/>";
//echo "Apellido Digitado es: ".$_REQUEST["personaApellido"]."<br/>";

$seleccionUsuario;


switch ($_REQUEST["personaCarrera"]){
	case "-9":
			$seleccionUsuario = "formatearSQL";
		break;
	case "-8":
			$seleccionUsuario = "saraFormCreator";
		break;
	case "-7":
			$seleccionUsuario = "plugin                                            ";
		break;
	case "-6":
			$seleccionUsuario = "constructor                                       ";
		break;
	case "-5":
			$seleccionUsuario = "registro                                          ";
		break;
	case "-4":
			$seleccionUsuario = "codificador                                       ";
		break;
	case "-3":
			$seleccionUsuario = "desenlace                                         ";
		break;
	case "-2":
			$seleccionUsuario = "cruder                                            ";
		break;
	case "-1":
			$seleccionUsuario = "development                                       ";
		break;
	case "1":
			$seleccionUsuario = "index                                             ";
		break;
	case "2":
			$seleccionUsuario = "respuestaIndex                                    ";
		break;
	default:
}

//var_dump($seleccionUsuario);
//echo "Seleccion es: ".$seleccionUsuario."<br/>";

echo "<table border='1' align='center'>
	<tr bgcolor='skyblue'>
	<th>Datos</th>
	<th>Valor Digitado</th>";
echo "<tr><td>"."Nombre Digitado"."</td>";
echo "<td>".$_REQUEST["personaNombre"]."</td>";
echo "<tr><td>"."Apellido Digitado"."</td>";
echo "<td>".$_REQUEST["personaApellido"]."</td>";
echo "<tr><td>"."Seleccion Digitada"."</td>";
echo "<td>".$seleccionUsuario."</td>";
*/

?>