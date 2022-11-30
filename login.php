<?php include_once 'php/php_utils.php'; ?>
<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

<body class="body">
<h1 class="mainTitle">Setor de protocolo online</h1>

<div class="menuBar">
    <table class="menuBarTable">
        <tr>
            <td class="menuBarItem"><a class="menuButton" href="protocolos.php"><input class='menuButton' type="submit" value="Ver protocolos"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="cadastrarProtocolo.php"><input class='menuButton' type="submit" value="Abrir solicitação"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="login.php"><input class='menuButton' type="submit" value="Login (funcionário)"/></a></td>
        </tr>
    </table>
</div>

<h3 class="menuTitle">Login de funcionário</h3>

<div class="loginBox">
    <form id="loginForm" class="loginForm">
        <label class="inputEmail">Usuário:<input id="inputEmail" name="email" type="email" autocomplete="email" required placeholder="Informe seu usuário (email)" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/></label>
        <br/>
        <label class="inputPassword">Senha:<input id="inputPassword" name="password" type="password" autocomplete="current-password" required placeholder="Informe sua senha" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/></label>
        <br/>
        <a class="helperButton" href="">Esqueci minha senha...</a>
        <br/>
        <br/>
        <a class="helperButton" href="login.php">Cadastrar usuário...</a>
        <br/>
        <br/>
        <input class='button' type="submit"  value="Login"/>
    </form>
</div>

</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>

<?php

?>