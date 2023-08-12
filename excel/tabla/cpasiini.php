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
$query = "SELECT * FROM cpasiini LIMIT $porPagina OFFSET $empiezaPagina";
$resultado= pg_query($query);

echo"<link rel='stylesheet' href='http://localhost/excel/style/css/bootstrap.min.css'>";
echo"<link rel='stylesheet' href='http://localhost/excel/style/js/bootstrap.min.js'>";

echo"<div class='table-responsive'>";
echo "<table class='table table-info table-striped'>";
echo "<th>codpre</th>";
echo"<th>nompre</th>";
echo"<th>perpre</th>";
echo"<th>anopre</th>";
echo"<th>monasi</th>";
echo"<th>monprc</th>";
echo"<th>moncom</th>";
echo"<th>moncau</th>";
echo"<th>monpag</th>";
echo"<th>montra</th>";
echo"<th>montrn</th>";
echo"<th>monadi</th>";
echo"<th>mondim</th>";
echo"<th>monaju</th>";
echo"<th>mondis</th>";
echo"<th>difere</th>";
echo"<th>status</th>";
echo"<th>id</th>";


        
if(pg_num_rows($resultado)>0){

    while($row = pg_fetch_assoc($resultado)){  
    
     echo "<tr><td>" . $row["codpre"] . "</td><td>" . $row["nompre"] . "</td>
     <td>" . $row["perpre"] ."</td><td>" . $row["anopre"] . "</td><td>" . $row["monasi"] . "</td><td>" . $row["monprc"] . "</td>
     <td>" . $row["moncom"] . "</td><td>" . $row["moncau"] . "</td><td>" . $row["monpag"] . "</td>
     <td>" . $row["montra"] . "</td><td>" . $row["montrn"] . "</td><td>" . $row["monadi"] . "</td>
     <td>" . $row["mondim"] . "</td><td>" . $row["monaju"] . "</td><td>" . $row["mondis"] . "</td>
     <td>" . $row["difere"] . "</td><td>" . $row["status"] . "</td><td>" . $row["id"] . "</td></tr>";

    }
    echo "</table>";
    echo"</div>";

}

// Paginacion
$query = "SELECT * FROM cpasiini";
$resultado1 = pg_query ($query);
$totalRegistros = pg_num_rows($resultado1);
$totalPaginas = ceil($totalRegistros/$porPagina);

echo"<nav aria-label='Page navigation example'>";
echo"<div class='mx-auto text-center'>";
echo"<div class='m-3'</div>";
echo"<ul class='pagination justify-content-center'>";

echo"<li class='page-item'><a class='page-link' href='mostrar.php?pagina=1'>Anterior</a><li>";

$inicio = max(1,$pagina - 5);
$fin = min($inicio + 9, $totalPaginas);

for ($i=$inicio; $i <= $fin; $i++) { 
    echo"<li class='page-item'><a class='page-link' href='mostrar.php?pagina=".$i."'>".$i."</a></li>";
}

echo"<li class='page-item'><a class='page-link' href='mostrar.php?pagina=$totalPaginas'>Siguiente</a></li>";

echo"</ul>";
echo"</div>";
echo"</div>";
echo"</nav>";