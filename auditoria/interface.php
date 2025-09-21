<?PHP
$documentLocation = $_SERVER['PHP_SELF'] ;
$camino = "";
if ($_SERVER['QUERY_STRING']) {
	$documentLocation .= $camino . $_SERVER['QUERY_STRING'] ;
}

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
}
if (1==2){
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables SERVER</b>";
	reset($_SERVER);
	while (list($variab, $valor) = each($_SERVER)){
		echo "<BR>server  =>".$variab."=".$valor ;
	}
}
if (1==2){
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables SESSION</b>";
	reset($_SESSION);
	while (list($variab, $valor) = each($_SESSION)){
		echo "<BR>session  =>".$variab."=".$valor ;
	}
	echo "<BR>- -------------------------------------------------------------------------------------";
}

?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="templatemenor.css" media="screen"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<SCRIPT LANGUAGE="JavaScript">
<!--
function checkData() {
    var f1 = document.forms [0] ;
    var wm = "Ocurrieron los siguientes Errores : ";
    var noerror = 1;
    var t1 = f1.usuario_digitado;
    if (t1.value == "" || t1.value == " " ) {
        wm += "Digite su nombre de Usuario" ;
        noerror = 0 ;
    }
    var t1 = f1.clave_digitada;
    if (t1.value == "" || t1.value == " " ) {
        wm += "Digite la contraseña";
        noerror = 0;
    }
    if (noerror == 0) {
        alert (wm) ;
        return false;
    }
    else return true;
}
//-->
</SCRIPT>
</head>

<body onLoad="document.form1.usuario_digitado.focus()">
<center>
<table width="100%" height="100%" >
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" height="100" align="center" >
		<img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/>
	</td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#ffffff" width="900" align="center" >
<center>
<form name = "form1" action='<?PHP echo $documentLocation?>' METHOD="post" onSubmit="return checkData()">
<table cellpadding="0" cellspacing="0" 1>
    <tr>
    <td heiqht="3O" COLSPAN="2" ALIGN="center"><h1>Ingreso de Usuarios</h1></td>
    </tr>
    
    <tr>
    <td height="24" COLSPAN="2" ALIGN="center"> <i><NOBR>
    <?PHP
    //revisa si hay mensajes de error.
    if ($message) {
    echo "<div class='error'>";
    echo $message;
    echo "</div>";
    } ?>
    </NOBR></i>
    </td>
    </tr>
    
    <tr>
    <td ALIGN="right" valign="bottom">
    <table cellpadding="4" cellspacing="1" >
        <tr>
        <td width="200" align="right" >Usuario: </td>
        <td width="200"> <input type="text" name="usuario_digitado" ></td>
        </tr>
        
        <tr>
        <td width="200" align="right">Contraseña: </td>
        <td width="200"><input type="password" name="clave_digitada"></td>
        </tr>
    
        <tr>
        <td>&nbsp;  </td>
        <td align="riqht"><input name="Submit" type="image" SRC="images/ingresar.gif" value="Submit"></td>
        </tr>
    </table>
    </td>
    </tr>
</table>
</form>
<BR>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
