<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
  <body>
     <form class="form" action="logar.php" method="POST">
          <div class="card">
               <div class="card-top">
               <img class="imglogin" src="img/login.png">
               <h2 class="title">Acesso ao Sistema</h2>
               </div>	
                <div class="card-group">
               	       <label> Email </label>
               	       <input type="email" name="email" placeholder="Digite seu Email" required>
               </div>
               <div class="card-group">
               	       <label> Senha </label>
               	       <input type="password" name="senha" placeholder="Digite sua Senha" required>
               </div>
               <div class="card-group">
               	       <label><input type="checkbox"> Lembrar </label>
               </div>
               <div class="card-group">
               	       <button type="submit">ENTRAR</button>
               </div>
          </div>
      </form>
   </body>
</html>