<?php
session_start();
$nome_ssid = $_POST['ssid'];
$senha_ssid = $_POST['senha'];
$id = $_POST['id'];

$localhost= "localhost";
$user= "root";
$passw="";
$banco="wifi";

//criar servidor

$con = mysqli_connect($localhost,$user, $passw, $banco);

//$nome_ssid = "A";

$sql= "UPDATE dados SET ssid = '$nome_ssid ' WHERE id= $id";
$result = mysqli_query($con, $sql);
$sql= "UPDATE dados SET senha = '$senha_ssid ' WHERE id= $id";
$result = mysqli_query($con, $sql);

unset($result);
header("Location:index.php?pg=manu.wifi");
?>