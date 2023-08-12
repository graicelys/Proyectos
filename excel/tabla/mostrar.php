<?php
require_once('../config/conexion.php');
require_once('../login/login.php');

//session_start();

if (!isset($_SESSION["nombre"])) {
  // El usuario esta logiado.
  header("Location: http://localhost/excel/tabla/mostrar.php");
  exit();

}
/*else{
    header("Location: http://localhost/excel/");
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/excel/style/css/bootstrap.min.css">
    
    <title>cpasiini</title>
</head>
<body>
    <header>
    <nav class="navbar" style="background-color: #6EC5F7">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://localhost/excel/login/inicio.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="btn btn-primary" href="http://localhost/excel/login/signoff.php" role="button">Cerrar Sesión</a>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost/excel/verificacion/file.php">Subir Archivo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/excel/tabla/mostrar.php">cpasiini</a>
        </li>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/excel/tabla/mostrar2.php">cpdisfuefin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>
    <main class="content-fluid m-5">
      <h1 class="text-center mb-4">cpasiini</h1>
      
      <?php include 'cpasiini.php';?>
      
    </main>
    <script src="http://localhost/excel/style/js/bootstrap.min.js"></script>  
</body>
</html>