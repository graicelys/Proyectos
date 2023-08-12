<?php
/*define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'gobernacion');
define('NUM_ITEMS_BY_PAGE', 12);
$mysqli = new mysqli('localhost','root', '','gobernacion');
if($mysqli->connect_errno){
   echo "Fallo conexion". $mysqli->connect_error;
   die();
}*/

$conexion = pg_connect("host=localhost dbname=gobernacion user=postgres password=12345");

if ($conexion) {
   
   //echo"Conectado";
}else {
   echo"Coneccion Fallida";
}
