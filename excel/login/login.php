<?php

require_once('../config/conexion.php');

echo"<link rel='stylesheet' href='http://localhost/excel/style/css/bootstrap.min.css'>";
echo"<link rel='stylesheet' href='http://localhost/excel/style/js/bootstrap.min.js'>";

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
     $nombreUsuario = $_POST["nombre"];
     $password = $_POST["password"];

     //Cifrar la contraseña utilizando password_hash ().
     $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
     /*echo'<pre>';
     print_r($hashedPassword );
     die();*/
     
     $query = "SELECT * FROM usuario WHERE nombre_usuario = '$nombreUsuario'";
     $resultadoUser = pg_query($query);
    //var_dump($query);
     if($rows = pg_num_rows($resultadoUser) == 1) {

      $row = pg_fetch_assoc($resultadoUser);
      $storedPassword = $row['password'];


      if (password_verify($password,$storedPassword)) {


         // Ver.
         $_SESSION["nombre"] = $nombreUsuario;

         header("Location: http://localhost/excel/login/inicio.php");

      }else {
         // Contraseña inválida
         echo "<div class='content-fluid m-5'>";
         echo "<h4 class='text-center mb-4'>Usuario o contraseña incorrectos</h4>";
         echo "<a class='btn btn-primary' href='http://localhost/excel/' role='button'>Atrás</a>";
         echo "</div>";
     }

      }else {

         // El usuario no existe en la base de datos
        echo "<div class='content-fluid m-5'>";
        echo "<h4 class='text-center mb-4'>Usuario o contraseña incorrectos</h4>";
        echo "<a class='btn btn-primary' href='http://localhost/excel/' role='button'>Atrás</a>";
        echo "</div>";
   }  
}