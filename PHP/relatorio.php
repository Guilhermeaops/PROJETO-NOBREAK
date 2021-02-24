<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style type="text/css">

/* ESTILOS GERAIS*/
.container{
	padding-top: 150px;
	width: 50%;
	margin:0 auto;
}

/*ESTILOS FORMULARIO*/

.areaPesquisa{
	border-radius: 5px;
	background-color: #9C9C9C;
	padding: 10px;
}

input{

	padding: 10px;
	margin: 5px 0;
	border: 1px solid #000;
	border-radius: 3px;
}

input[type=text]{
	width: 35%;
}
input[type=submit]{
width: 20%;
background-color: #2E8B57;
color: #fff;

}

/* ESTILOS TABELA*/ 

table{
	border-collapse: collapse;
	width: 100%;
	margin-top: 10px;
}
table th{

	background-color: #2E8B57;
	color: #fff;
	height: 30px;
}
</style>
</head>
<body>
<div class="container">
<div class="areaPesquisa">
<form action="" method="post">
<input type="text" name="data" placeholder="Mês/Ano">
<input type="submit" name="submit" value="Buscar">
</form>
</div>

<?php
include('conexao2.php');
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
//echo "<h1> Recebeu a data:" .$_POST['data']    ."</h1>";
$dataPesquisa = $_POST['data'];
$dataArray = explode("/", $dataPesquisa);
$dataPesquisa = $dataArray[1] .  "-"  . $dataArray[0];


$sql = " SELECT * FROM relatorio1 WHERE data_hora LIKE '%" . $dataPesquisa .  "%' "; 
}else{
//echo "<h1>Não Recebeu Nada, vai mostrar o mês atual</h1>";
$dataAtual = date('Y-m');
$nulo='2000-02';

//echo "Mês Atual: " .$dataAtual; 
$sql = " SELECT * FROM relatorio1 WHERE data_hora LIKE '%" . $nulo .  "%' "; 
}
$stmt = $PDO->prepare($sql);
$stmt->execute();

echo "<table border=\"1\">";

echo "<tr> <th>Estado Sensor</th> <th>Estado Luz</th>  <th>Data/Hora</th>  </tr>";

while ($linha = $stmt->fetch(PDO::FETCH_OBJ)) {
$timestamp = strtotime($linha->data_hora);
$dataTabela = date('d/m/Y H:i:s', $timestamp);

echo"<tr>";
echo"<td>" . $linha->est_sensor ."</td>";
echo"<td>" . $linha->est_luz   ."</td>";
echo"<td>" . $dataTabela  ."</td>";
echo"</tr>";	
}

echo "</table>";


?>
</div>
</body>
</html>
