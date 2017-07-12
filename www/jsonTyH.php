<?php
header('Content-Type: application/json');

function cambiafechamysql($fecha){ 

	$lafecha = "'".substr($fecha,6,4)."/".substr($fecha,3,2)."/".substr($fecha,0,2)." ".substr($fecha,11,5)."'";

   	   	   	return $lafecha; 
   	   	   	}
$fechaini = cambiafechamysql($_GET['fecha1']);
$fechafin = cambiafechamysql($_GET['fecha2']);

include("configuracion.php");
$query = "SELECT fecha, temp, humedad FROM registro where fecha >= ".$fechaini." AND fecha <= ".$fechafin." ORDER BY id";
$result = mysql_query($query) or die("Error en la instruccion SQL");
$puntos_grafica = array();
while($row = mysql_fetch_array($result))
{        
    $punto = array("label" => $row['fecha'] , "y" => $row['temp'] , "y2" => $row['humedad']);
    array_push($puntos_grafica, $punto);        
}
echo json_encode($puntos_grafica, JSON_NUMERIC_CHECK); 

mysql_close($conexion);
?>