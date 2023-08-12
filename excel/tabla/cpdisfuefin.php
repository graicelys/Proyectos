<?php

require_once('../vendor/autoload.php');
require_once('../config/conexion.php');

$porPagina = 13;
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];

} else{
        $pagina = 1;
}

$empiezaPagina = ($pagina-1) * $porPagina = 13;
$query = "SELECT * FROM cpdisfuefin LIMIT $porPagina OFFSET $empiezaPagina";
$resultado= pg_query($query);

echo"<link rel='stylesheet' href='http://localhost/excel/style/css/bootstrap.min.css'>";
echo"<link rel='stylesheet' href='http://localhost/excel/style/js/bootstrap.min.js'>";

echo"<div class='table-responsive'>";
echo "<table class='table table-info table-striped'>";
echo "<th>correl</th>";
echo"<th>origen</th>";
echo"<th>fuefin</th>";
echo"<th>fecdis</th>";
echo"<th>codpre</th>";
echo"<th>monasi</th>";
echo"<th>refdis</th>";
echo"<th>status</th>";
echo"<th>id</th>";


        
if(pg_num_rows($resultado)>0){

    while($row = pg_fetch_assoc($resultado)){
     echo "<tr><td>" . $row["correl"] . "</td><td>" . $row["origen"] . "</td>
     <td>" . $row["fuefin"] ."</td><td>" . $row["fecdis"] . "</td><td>" . $row["codpre"] . "</td>
     <td>" . $row["monasi"] . "</td><td>" . $row["refdis"] . "</td><td>" . $row["status"] . "</td><td>" . $row["id"] . "</td></tr>"; 
    }
    echo "</table>";
    echo"</div>";
}

// Paginacion
$query = "SELECT * FROM cpdisfuefin";
$resultado1 = pg_query ($query);
$totalRegistros = pg_num_rows($resultado1);
$totalPaginas = ceil($totalRegistros/$porPagina);

echo"<nav aria-label='Page navigation example'>";
echo"<div class='mx-auto text-center'>";
echo"<div class='m-3'</div>";
echo"<ul class='pagination justify-content-center'>";

echo"<li class='page-item'><a class='page-link' href='mostrar2.php?pagina=1'>Anterior</a><li>";

$inicio = max(1,$pagina - 5);
$fin = min($inicio + 9, $totalPaginas);

for ($i=$inicio; $i <= $fin; $i++) { 
    echo"<li class='page-item'><a class='page-link' href='mostrar2.php?pagina=".$i."'>".$i."</a></li>";
}

echo"<li class='page-item'><a class='page-link' href='mostrar2.php?pagina=$totalPaginas'>Siguiente</a></li>";

echo"</ul>";
echo"</div>";
echo"</div>";
echo"</nav>";