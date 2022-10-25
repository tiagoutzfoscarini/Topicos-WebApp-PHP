<?php
require_once 'php/utils.php';
?>
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
            <td class="menuBarItem"><a class="menuButton" href="pg_protocolos.php"><input class='menuButton' type="submit" value="Ver protocolos"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="pg_cadastrarProtocolo.php"><input class='menuButton' type="submit" value="Abrir solicitação"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="pg_login.php"><input class='menuButton' type="submit" value="Login (funcionário)"/></a></td>
        </tr>
    </table>
</div>

<h3 class="menuTitle">Login de funcionário</h3>
<div id="errs" class="errcontainer"></div>
<div class="loginBox">
    <form id="registerForm" class="loginForm">
        <label class="inputUser">Nome:<input id="inputUser" name="user" type="text" required placeholder="Informe seu nome" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/></label>
        <br/>
        <label class="inputEmail">Email:<input id="inputEmail" name="email" type="email" autocomplete="email" required placeholder="Informe seu email" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/></label>
        <br/>
        <label class="inputPassword">Senha:<input id="inputPassword" name="password" type="password" autocomplete="current-password" required placeholder="Informe uma senha" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/></label>
        <br/>
        <label class="inputCity">Cidade:<select id="inputCity">
            <option></option>
        </select></label>
        <input class='button' onclick="register()" value="Registrar"/>
    </form>
</div>

</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>

<?php

?>