<?php

$mysqli = new mysqli('localhost','root', '','blog');
if($mysqli->connect_errno){
   echo "Fallo conexion". $mysqli->connect_error;
   die();
}