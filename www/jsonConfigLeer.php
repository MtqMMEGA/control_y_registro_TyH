<?php

include("configuracion.php");

$query = "SELECT * FROM configuracion WHERE id=1";
$result = mysql_query($query) or die("Error en la instruccion SQL");
$datos_config = array();
if ($result)
{
	while($row = mysql_fetch_array($result))
	{        
		$datos = array(email => $row['email'] , TMax => $row['temp_max'], HMax => $row['humedad_max'], intervalo => $row['intervalo'], alarma => $row['alertas']);
		array_push($datos_config, $datos);
	}
}
else
{
	$datos = array(email => "" , TMax => "", HMax => "", intervalo => "", alarma => "");
	array_push($datos_config, $datos);
}
echo json_encode($datos, JSON_NUMERIC_CHECK);

mysql_close($conexion);
?>
