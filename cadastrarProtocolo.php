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
            <td class="menuBarItem"><a class="menuButton" href="index.php"><input class='menuButton' type="submit" value="Início"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="protocolos.php"><input class='menuButton' type="submit" value="Ver protocolos"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="login.php"><input class='menuButton' type="submit" value="Login (funcionário)"/></a></td>
        </tr>
    </table>
</div>

<div class="cityBar">
    <table class="cityBarTable">
        <tr>
            <td class="cityBarName">Selecionar cidade:</td>
            <td class="cityBarItem"><a class="cityButton" href=""><input class='menuButton' type="submit" value="Igrejinha"/></a></td>
            <td class="cityBarItem"><a class="cityButton" href=""><input class='menuButton' type="submit" value="Parobé"/></a></td>
            <td class="cityBarItem"><a class="cityButton" href=""><input class='menuButton' type="submit" value="Taquara"/></a></td>
        </tr>
    </table>
</div>

<div class="newProtocolBox">
    <form id="newProtocolForm" class="newProtocolForm">
        <label class="problemType">Tipo de problema*:<select id="problemType">
            <option></option>
        </select></label>
        <br/>
        <label class="description">Descrição do problema*:<input id="description" type="" /></label>
        <br/>
        <label class="name">Nome completo*:<input id="name" type="text" /></label>
        <br/>
        <label class="cpf">CPF*:<input id="cpf" type="" /></label>
        <br/>
        <label class="phone">Telefone para contato*:<input id="tel" type="tel" /></label>
        <br/>
        <label class="email">Email para contato:<input id="email" type="email" /></label>
        <br/>
        <label class="images">Imagens:<input id="images" type="" /></label>
        <br/>
        <label class="address">Endereço*:<input id="address" type="" /></label>
        <br/>
        <label class="map"><input id="map" type="image" disabled /></label>
        <br/>
        <p class="notes">* campos obrigatórios</p>
        <input class='button' type="submit" value="Enviar solicitação"/>
    </form>
</div>

</body>
</body>

<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>

<?php

?>