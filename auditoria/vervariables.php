<?PHP
	session_start() ; 
?>
<?PHP
if (1==1){
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables SESSION</b>";
	echo "<BR>---------------------------------------------------------------------------------------";
/*
		$x = "contenido x";
	echo "<BR>session  => usuario   "."=".$x;
	$_SESSION['IdEmpresa'] = "1";
	$_SESSION['Empresa'] = "2";
	$_SESSION['Pais'] = "3";
	$_SESSION['Logo'] = "4";
*/
	echo "<BR>---------------------------------------------------------------------------------------";
	reset($_SESSION);
	while (list($variab, $valor) = each($_SESSION)){
		echo "<BR>session  =>".$variab."=".$valor ;
	}
	echo "<BR>session  => usuario   "."=".$_SESSION['usuario'];
	echo "<BR>session  => clave     "."=".$_SESSION['clave'];
	echo "<BR>session  => IdEmpresa "."=".$_SESSION['IdEmpresa'];
	echo "<BR>session  => Empresa   "."=".$_SESSION['Empresa'];
	echo "<BR>session  => Pais      "."=".$_SESSION['Pais'];
	echo "<BR>session  => Logo      "."=".$_SESSION['Logo'];
	echo "<BR>- -------------------------------------------------------------------------------------";
}
if (1==1){
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
if (1==1){
	echo "<BR>---------------------------------------------------------------------------------------";
	echo "<BR><b>variables SERVER</b>";
	reset($_SERVER);
	while (list($variab, $valor) = each($_SERVER)){
		echo "<BR>server  =>".$variab."=".$valor ;
	}
}

?>
