<?php

include('conexao2.php');

$luz = $_GET['luz'];
$est_luz2 = $_GET['est_luz2'];

$sql = "INSERT INTO   relatorio2 (luz, est_luz2) VALUES (:luz, :est_luz2)";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':luz', $luz);
$stmt->bindParam(':est_luz2', $est_luz2);

if($stmt->execute()) {
echo "salvo_com_sucesso";

}else{
echo "erro_ao_salvar";

}

?>