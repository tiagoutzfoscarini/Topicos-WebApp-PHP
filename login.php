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
            <td class="menuBarItem"><a class="menuButton" href="protocolos.html"><input class='menuButton' type="submit" value="Ver protocolos"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="cadastrarProtocolo.html"><input class='menuButton' type="submit" value="Abrir solicitação"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="login.html"><input class='menuButton' type="submit" value="Login (funcionário)"/></a></td>
        </tr>
    </table>
</div>

<h3 class="menuTitle">Login de funcionário</h3>

<div class="loginBox">
    <form id="loginForm" class="loginForm">
        <label class="user">Usuário:<input/></label>
        <br/>
        <label class="password">Senha:<input/></label>
        <br/>
        <a class="helperButton" href="">Esqueci minha senha...</a>
        <br/>
        <input class='button' type="submit"  value="Login"/>
    </form>
</div>

</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>
