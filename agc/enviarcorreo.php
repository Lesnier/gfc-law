<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GREMIAL AGC</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #c11c16;
	font-size: 18px;
}
.Estilo2 {font-size: 14px}
.Estilo3 {	font-weight: bold;
	color: #FFFFFF;
}
body {
	background-color: #525252;
}
-->
</style>
</head>
<title>enviarcorreo</title><? //Recepcion de datos 
$apellido=$_POST['apellido']; 
$nombre=$_POST['nombre']; 
$empresa=$_POST['empresa']; 
$correo=$_POST['correo']; $asunto=$_POST['asunto']; 
$consulta=$_POST['consulta']; 

// Fin de recpcion de datos 

// Accion de envio 

//---------// 

$para='contactenos@alienred.com'; 
$mensaje=' 

Mensaje de: 
'.$apellido.', '.$nombre.' 


Correo: 
'.$correo.' 

Asunto: 
'.$asunto.' 

Consulta: 
'.$consulta.' 
'; 
$desde='From: contactenos@alienred.com'; 
ini_set(sendmail_from,'contactenos@alienred.com'); 
mail($para,$asunto,$mensaje,$desde); 
echo''; 
?>
<body>
<div id="topPan">
	<a href="index.html"></a>
	<ul>
	  <li><a href="index.html">INICIO</a></li>
		<li><a href="ACCION SOCIAL.html">A. SOCIAL</a> </li>
		<li><a href="FOTOS.html">FOTOS</a></li>
		<li><a href="CURSOS.html">CURSOS</a></li>
		<li><a href="contacto.html">Contacto</a></li>
  </ul>
	
	<img src="images/logo.jpg" width="220" height="108" /></div>
<div id="bodytopmainPan">
<div id="bodytopPan">
  <p align="center">&nbsp;</p>
  <p align="center">Mensaje envido con exito, muchas gracias</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p></p>
	<p align="justify" class="Estilo2">&nbsp;</p>
  </div>
</div>
<div id="footermainPan">
  <div align="center">
    <p class="Estilo3">&nbsp;</p>
    <p class="Estilo3">&nbsp;</p>
    <p class="Estilo3">&nbsp;</p>
    <p class="Estilo3">&nbsp;</p>
    <p class="Estilo3">&nbsp;</p>
    <p class="Estilo3">&copy; 2012 GREMIAL  AGC</p>
  </div>
</div>
</body>
</html>
