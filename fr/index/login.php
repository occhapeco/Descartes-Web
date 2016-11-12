<?php require_once("permissao.php"); ?>

<html lang="pt">
<head>
    <title>Water²</title>
</head>
<body>
    <div class="card card-container-login">
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" action="logar.php" method="POST">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
            <button class="btn btn-primary" type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
