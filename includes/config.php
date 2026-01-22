<?php 
try{
    $pdo=new PDO("mysql:host=localhost;dbname=blogdb","root","");
}catch(PDOException $e){
    die( "Error" . $e->getMessage());
}
?>