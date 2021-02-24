	<?php

require 'verifica.php';

if(isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])):?>



	<!DOCTYPE html>
	<html>
	<head>
	<title>Fortec--Alerta</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	</head>
	<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">Fortec Alerta</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
	  <li class="nav-item active">
	    <a class="nav-link" href="index.php">Início <span class="sr-only">(current)</span></a>
	  </li>
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Formulário
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?pg=Relatório">Relatório Queda de Luz</a>
          <a class="dropdown-item" href="index.php?pg=Relatório2">Relatório Volta de Luz</a>
      </div>
      </li> 
    </ul>
	</ul>
	<div class="form-inline my-2 my-lg-0">
 <label class="mr-3"><?php echo $nomeUser; ?></label>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
		 <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Redefinir
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?pg=manu.wifi">Wifi</a>
      </div>
      </li> 
    </ul>
<a href="logout.php">SAIR</a>

	</div>

	</div>

	</nav>

<main>
	<div class="container-fluid">

	
<?php
$pg="";
if(isset($_GET['pg']) && !empty($_GET['pg'])){
    $pg = addslashes($_GET['pg']);
}
switch ($pg) {
case 'Relatório': require 'relatorio.php'; break;
case 'Relatório2': require 'relatorio2.php'; break;
case 'manu.wifi': require 'wifi.php'; break;
default: require 'home.php';
}

?>


	</div>

</main>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	</body>
	</html>

	<?php else: header("Location: login.php"); endif; ?>
	