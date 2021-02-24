<?php

include('conexao2.php');

$est_sensor = $_GET['est_sensor'];
$est_luz = $_GET['est_luz'];

$sql = "INSERT INTO   relatorio1 (est_sensor, est_luz) VALUES (:est_sensor, :est_luz)";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':est_sensor', $est_sensor);
$stmt->bindParam(':est_luz', $est_luz);

if($stmt->execute()) {
echo "salvo_com_sucesso";

}else{
echo "erro_ao_salvar";

}

?>