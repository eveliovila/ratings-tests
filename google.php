<?php
include("connect.php"); 

//cadena de conexion 

//DEBO PREPARAR LOS TEXTOS QUE VOY A BUSCAR si la cadena existe 
if ($busqueda<>''){ 
   //CUENTA EL NUMERO DE PALABRAS 
   $trozos=explode(" ",$buscar); 
   $numero=count($trozos); 
  if ($numero==1) { 
   //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE 
   $cadbusca="SELECT  Title from Films  WHERE VISIBLE =1 AND Title LIKE '%$busqueda%' LIMIT 50"; 
  } elseif ($numero>1) { 
  //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST 
  //busqueda de frases con mas de una palabra y un algoritmo especializado 
  $cadbusca="SELECT  Title , MATCH ( Title ) AGAINST ( '$busqueda' ) AS Score FROM Films WHERE MATCH ( Films ) AGAINST ( '$busqueda' ) LIMIT 50";
} 
$result=mysql("teleformacion", $cadbusca); 
While($row=mysql_fetch_object($result)) 
{ 
   //Mostramos los titulos de los articulos o lo que deseemos... 
  $referencia=$row->REFERENCIA; 
   $titulo=$row->TITULO; 
   echo $referencia." - ".$titulo."<br>";; 
} 

}
?>