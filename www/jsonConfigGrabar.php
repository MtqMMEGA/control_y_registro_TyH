<?php

include("configuracion.php");

$email_alerta = $_GET['email_alerta'];
$TMax = $_GET['TMax'];
$HMax = $_GET['HMax'];
$intervalo = $_GET['intervalo'];

if ( isset($_GET['alarma']) && $_GET['alarma']==1)
    $alarma=true;
else
	$alarma=false;

$query = "UPDATE configuracion SET email ='".$email_alerta."' , temp_max = ".$TMax.", humedad_max = ".$HMax." , intervalo =".$intervalo." , alertas ='".$alarma."' WHERE id=1";

$result = mysql_query($query) or die("Error en la instruccion SQL");
if ($result)
	echo"1";
else
	echo "0";
mysql_close($conexion);
?>
