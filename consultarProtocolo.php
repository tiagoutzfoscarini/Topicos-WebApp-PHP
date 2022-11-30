<?php
$utils = include ('php/php_utils.php');
$config = include('php/config.php');
?>
<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <title>Consultar Protocolo</title>
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

<div class="protocolInformationBox">
    <form class="protocolInformationForm">
        <?php
        if (isset($_GET['id'])) {
            $id = (int)($_GET['id']);

            // Validação que o ID é um número, se não for, apresenta um aviso
            if (!is_integer($id) or $id <= 0) {
                echo "<script>alert('INVALID ID');</script>";
                $id = 1;
            }
        } else {
            $id = 1;
        }

        $conn = sql_connect();
        $sql = "SELECT * FROM protocols INNER JOIN problemTypes ON (protocols.protocolProblemTypeId = problemTypes.problemTypeId) INNER JOIN statusList ON (protocols.protocolStatusId = statusList.statusId) WHERE protocolId = $id";
        $stmt = sql_query_select($conn, $sql);


        while($row = sqlsrv_fetch_array($stmt)) {
            echo "<label class='labelProtocol'>Nº protocolo: <p class='labelProtocolValue'>{$row['protocolId']}</p></label><br/>";
            echo "<label class='labelProtocol'>Endereço: <p class='labelProtocolValue'>{$row['protocolAddress']}</p></label><br/>";
            echo "<label class='labelProtocol'>Tipo de problema: <p class='labelProtocolValue'>{$row['problemTypeName']}</p></label><br/>";
            echo "<label class='labelProtocol'>Descrição: <p class='labelProtocolValue'>{$row['protocolDescription']}</p></label><br/>";
            echo "<label class='labelProtocol'>Aberto por: <p class='labelProtocolValue'>{$row['protocolRequesterName']}</p></label><br/>";
            echo "<label class='labelProtocol'>Status: <p class='labelProtocolValue'>{$row['statusName']}</p></label>";
            echo "<td class='cityBarItem'><button id='buttonChangeStatus' class='button' ><a href='consultarProtocolo.php?id={$id}&changeStatus=true&protocolId={$row['protocolId']}'>Alterar status</a></button></td>";
//            echo "<td class='cityBarItem'><button id='buttonChangeStatus' class='button' onclick=";
//            echo sql_update_protocol_Status($conn, $row['protocolId']);
//            echo " >Alterar status</button></td>";
        }
        ?>
    </form>
</div>

</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>

<?php
if (isset($_GET['changeStatus']) and isset($_GET['protocolId'])) {
    $protocolId = (int)($_GET['protocolId']);
    $changeStatus = (bool)($_GET['changeStatus']);

    // Validação que o ID é um número, se não for, apresenta um aviso
    if (!is_integer($protocolId) or $protocolId <= 0) {
        echo "<script>alert('INVALID ID');</script>";
    }

    if ($changeStatus and $protocolId > 0) {
        $conn = sql_connect();
        sql_update_protocol_Status($conn, $protocolId);
    }
}
?>