<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style type="text/css">
		.form{
width: 400px;
margin: auto; 
padding-top:180px; 
}

.card{
box-shadow: 1px 1px 5px #ccc;
background-color: rgb(245,222,179);
padding: 30px;
border-radius: 5px;

}
}
.card-group{
margin-bottom: 10px;

}
.card-group > label{
width: 100%;
color: black;
display: block;
}
.card-group > input{
border-radius: 5px;
outline: 0;
width: 100%;
height: 25px;
padding: 5px;

}
}
.card-a > button{
	background-color: gray;
width: 100%;
border-radius: 30 px;
padding: 25px;
color: white;
border: 0px;
outline: 0;
}

	</style>
</head>
<body>
	<form class="form" action="conexao3.php" method="POST">
<div class="card">
	<div class="card-top">
		<h2 > Nova Rede </h2>
	</div>
<div class="card-group">
	<label>SSID</label>
	<input type="text" name="ssid" placeholder="Digite seu SSID">
	
</div>	
<div class="card-group">
	<label>Senha</label>
	<input type="password" name="senha" placeholder="Digite sua Senha">
	
</div>	
<div class="card-group">
	<label>ID</label>
	<input type="number" name="id" placeholder="Digite seu ID">
	
</div>	
<div class="card-a">
	<button type="submit" > SALVAR  </button>
</div>
</div>
</form>
</body>
</html>