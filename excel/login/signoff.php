<?php

require_once('../config/conexion.php');

session_start();
// Cerrar todas las variables de sesión.
session_destroy();

header ("Location: http://localhost/excel/");
exit();