<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?PHP
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.
$sql  = "SELECT E.Pais " ;
$sql .= "FROM empresas E " ;
$sql .= "WHERE IdEmpresa=". $_POST['IdEmpresa']  ;
$res = mysql_query ($sql) or die (mysql_error());

$fila = mysql_fetch_array($res);

if ($fila['Pais'] == "AR"){
	header("Location: empl_nuevo_AR.php?IdEmpresa=" . $_POST['IdEmpresa']);
	exit();
} elseif ($fila['Pais'] == "UY"){
	header("Location: empl_nuevo_UY.php?IdEmpresa=" . $_POST['IdEmpresa']);
	exit();
} elseif ($fila['Pais'] == "CS"){
	header("Location: empl_nuevo_CS.php?IdEmpresa=" . $_POST['IdEmpresa']);
	exit();
} else {
	header("Location: empl_nuevo_AR.php?IdEmpresa=" . $_POST['IdEmpresa']);
	exit();
}
?>
