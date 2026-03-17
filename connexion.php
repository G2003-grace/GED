<?php 

try {
$bd=new PDO('mysql:host=localhost;dbname=ged','root','');	
} 
catch (Exception $e) {
die("Erreur de connexion à la base de données");	
}

 ?>