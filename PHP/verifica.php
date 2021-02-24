<?php

require 'conexao.php';

if(isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {

require_once 'Usuario.class.php';

$u = new Usuario();

$listlogged = $u-> logged($_SESSION['idUser']);

$nomeUser = $listlogged['nome'];

}else{
	
header("Location: login.php");

}


?>