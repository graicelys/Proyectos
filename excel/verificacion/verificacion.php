<?php 

require_once('../vendor/autoload.php');
require_once('../config/conexion.php');


// lectura a hoja de calculo.
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// Ruta de la hoja y variables.
$directorioDestino = 'respaldo/'; ///
$nombreArchivo = $_FILES['file']['name'];//
$ubicacionTemporal = $_FILES['file']['tmp_name'];//
$leer = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();//
$spreadsheet = $leer->load($ubicacionTemporal);//
$worksheet = $spreadsheet->getActiveSheet();//

// Mover el archivo a la carpeta respaldo.
$destino = $directorioDestino . $nombreArchivo;
move_uploaded_file($ubicacionTemporal, $destino);
// Dividir el conto.
$documento = IOFactory :: load ($destino); //carga la hoja *.
$hoja = $documento->getActiveSheet(); // Seleccionar la hoja *.

$filaInicial = 2;
$filaActual = $filaInicial;
$camposNoSubidos = array();
$camposNoSubidos1 = array();

echo"<link rel='stylesheet' href='http://localhost/excel/style/css/bootstrap.min.css'>";
echo"<link rel='stylesheet' href='http://localhost/excel/style/js/bootstrap.min.js'>";


echo "<div class='content-fluid m-5'>";
echo "<a class='btn btn-primary me-md-2' href='http://localhost/excel/login/inicio.php' role='button'>Inicio</a>";
echo "<a class='btn btn-primary' href='file.php' role='button'>Cargar Archivo</a>";
echo "</div>";



while ($worksheet->getCell('A'. $filaActual)->getValue() !=''){ // Se  define cuando llega la ultima fila del archivo.
  
  $cod = $worksheet->getCell('A'.$filaActual)->getValue();
  $cod1 = $worksheet->getCell('A'.$filaActual)->getValue();

  
  $queryP = "SELECT * FROM cpasiini WHERE codpre = '$cod'";
  $resultadoP = pg_query($queryP);
  $resultadoH = isset($resultadoP) ? $resultadoP : '';
  //var_dump($resultadoH);
  $filaP = pg_fetch_assoc($resultadoH);
  $codpre = isset($filaP['codpre']) ? $filaP['codpre'] : '';
  //var_dump($resultadoP);
    
  $queryF = "SELECT * FROM cpdisfuefin WHERE codpre = '$cod1'";
  $resultadoF = pg_query($queryF);
  $filaF = pg_fetch_assoc($resultadoF);
  $codpreF = isset($filaF['codpre']) ? $filaF['codpre'] : '';

  /*
  $query= "SELECT * FROM cpasiini WHERE codpre = '$cod'";
  $resultado = pg_query($query);
  $fila = pg_fetch_assoc($resultado);
  $codpre = $fila1 ['codpre'];
  //var_dump($codpre);
  
  $query= "SELECT * FROM cpdisfuefin WHERE codpre = '$cod1'";
  $resultado1 = pg_query($query);
  $fila1 = pg_fetch_assoc($resultado1);
  $codpre1 = $fila1 ['codpre'];
   */
  
  if($cod != $codpre || $cod1 != $codpreF ){ // Si codpre no existe cargarlo en la base de datos.
  $valorA = $worksheet->getCell('A'.$filaActual)->getValue();
  $valorB = $worksheet->getCell('B'.$filaActual)->getValue();
  $valorC = $worksheet->getCell('C'.$filaActual)->getValue();
  $valorD = $worksheet->getCell('D'.$filaActual)->getValue();
  $valorE = $worksheet->getCell('E'.$filaActual)->getValue();
  $valorF = $worksheet->getCell('F'.$filaActual)->getValue();
  $valorG = $worksheet->getCell('G'.$filaActual)->getValue();
  $valorH = $worksheet->getCell('H'.$filaActual)->getValue();
  $valorI = $worksheet->getCell('I'.$filaActual)->getValue();
  $valorJ = $worksheet->getCell('J'.$filaActual)->getValue();
  $valorK = $worksheet->getCell('K'.$filaActual)->getValue();
  $valorL = $worksheet->getCell('L'.$filaActual)->getValue();
  $valorM = $worksheet->getCell('M'.$filaActual)->getValue();
  $valorN = $worksheet->getCell('N'.$filaActual)->getValue();
  $valorO = $worksheet->getCell('O'.$filaActual)->getValue();
  $valorP = $worksheet->getCell('P'.$filaActual)->getValue();
  $valorQ = $worksheet->getCell('Q'.$filaActual)->getValue();
  $valorR = $worksheet->getCell('R'.$filaActual)->getValue();

  $query = "INSERT INTO cpdisfuefin (correl,origen,fuefin,fecdis,codpre,monasi,refdis,status) 
  VALUES ('0','$valorB','0','0','$valorA', $valorE,'0','$valorQ')"; 
  $consulta = pg_query($query);
   // Devidir el monasi.
   $montototal = $valorE / 12;

   // Carga la segunda tabla 12 veces, e incrementa el campo perpre.
    for($valorC= 0; $valorC <=12; $valorC++){

     $query = "INSERT INTO cpasiini(codpre,nompre,perpre,anopre,monasi,monprc,moncom,moncau,  monpag,  montra,  montrn,  monadi,  mondim,  monaju, mondis, difere, status)
     VALUES ('$valorA', '$valorB', (LPAD('$valorC', 2,'0')), '$valorD', $valorE, 0, 0, 0, 0, 0, 0, 0, 0, 0,
     $valorO, $valorP , '$valorQ')";
     
     // Divide el campo monasi en doce luego del segunda fila.
     $valor_a_dividir = $worksheet->getCell('E'. $filaActual)->getValue();
     $resultado_division = $valor_a_dividir/12;
     $resultados = array();
     $resultados = $resultado_division;
     $valorE =$resultados;
     $consulta1 = pg_query($query);

    }

  }else {
    // Si ya existe en la base de datos, se agrega al array de campos no subidos.
     array_push($camposNoSubidos,$cod);
     array_push($camposNoSubidos1,$cod1);
  }

  $filaActual++;
}

// Mostrar los campos no subidos
if (count($camposNoSubidos) > 0) {

   echo "<div class='content-fluid m-5'>";
   echo "<p></p>";
   $ver = "Los siguientes codpre de partidas no fueron subidos porque ya existen en cpasiini :<br> " . implode("<br>", $camposNoSubidos);
   echo $ver;
   echo "<p></p>";
   echo "</div>";
}

if (count($camposNoSubidos1) > 0) {

   echo "<div class='content-fluid m-5'>";
   echo "<p></p>";
   $ver1 = "Los siguientes codpre de partidas no fueron subidos porque ya existen en cpdisfuefin :<br> " . implode("<br>", $camposNoSubidos1);
   echo $ver1;
   echo "<p></p>";
   echo "</div>";
}
echo "<div class='content-fluid m-5'>";
echo "<p> Carga completa </p>";
echo "</div>";


