<?php
include("connect.php"); 

if ($busqueda<>''){ 
   $trozos=explode(" ",$buscar); 
   $numero=count($trozos); 
  if ($numero==1) { 
   $cadbusca="SELECT  Title from Films  WHERE VISIBLE =1 AND Title LIKE '%$busqueda%' LIMIT 50"; 
  } elseif ($numero>1) { 
  $cadbusca="SELECT  Title , MATCH ( Title ) AGAINST ( '$busqueda' ) AS Score FROM Films WHERE MATCH ( Films ) AGAINST ( '$busqueda' ) LIMIT 50";
} 
$result=mysql("teleformacion", $cadbusca); 
While($row=mysql_fetch_object($result)) 
{ 
  $referencia=$row->REFERENCIA; 
   $titulo=$row->TITULO; 
   echo $referencia." - ".$titulo."<br>";; 
} 

}
?>
