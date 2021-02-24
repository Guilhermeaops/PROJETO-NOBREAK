<?php


$localhost= "localhost";
$user= "root";
$passw="";
$banco="formulario";

global $pdo;

try{
	//orientada a objetos em pdo
$PDO = new PDO("mysql:host="  . $localhost . ";dbname=" .  $banco   .  ";charset=utf8", $user,$passw); 


}catch(PDOException $erro){
  //echo "ERRO de conexão, detalhes: " .$erro->getMessage();
  echo "conexao_erro";

}



?>

