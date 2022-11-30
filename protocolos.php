<?php include_once 'php/php_utils.php'; ?>
<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <title>Protocolo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

<body class="body">
<h1 class="mainTitle">Setor de protocolo online</h1>

<div class="menuBar">
    <table class="menuBarTable">
        <tr>
            <td class="menuBarItem"><a class="menuButton" href="index.php"><input class='menuButton' type="submit" value="Início"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="cadastrarProtocolo.php"><input class='menuButton' type="submit" value="Abrir solicitação"/></a></td>
            <td class="menuBarItem"><a class="menuButton" href="login.php"><input class='menuButton' type="submit" value="Login (funcionário)"/></a></td>
        </tr>
    </table>
</div>

<div class="cityBar">
    <table class="cityBarTable">
        <tr>
            <td class="cityBarName">Selecionar cidade:</td>
            <?php
            $conn = sql_connect();
            $sql = "SELECT * FROM cities";
            $stmt = sql_query_select($conn, $sql);

            while($row = sqlsrv_fetch_array($stmt)) {
                echo "<td class='cityBarItem'><a class='cityButton' href='protocolos.php?id={$row['cityId']}'><input class='menuButton' type='submit' value='{$row['cityName']}'></a></td>";
            }
            sqlsrv_close($conn);
            ?>
        </tr>
    </table>
</div>

<div>
    <table class="tableProtocols">
        <tr>
            <td class="tableHeader">Nº protocolo</td>
            <td class="tableHeader">Endereço</td>
            <td class="tableHeader">Tipo de problema</td>
            <td class="tableHeader">Status</td>
            <td class="tableHeader"></td>
        </tr>

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
//        $sql = "SELECT * FROM protocols WHERE cityId = $id";

        $sql = "SELECT * FROM protocols INNER JOIN problemTypes ON (protocols.protocolProblemTypeId = problemTypes.problemTypeId) INNER JOIN statusList ON (protocols.protocolStatusId = statusList.statusId) WHERE protocolCityId = $id";

        $stmt = sql_query_select($conn, $sql);

        while($row = sqlsrv_fetch_array($stmt)) {
            echo "<tr>";
            echo "<td>" . $row['protocolId'] . "</td>";
            echo "<td>" . $row['protocolAddress'] . "</td>";
            echo "<td>" . $row['problemTypeName'] . "</td>";
            echo "<td>" . $row['statusName'] . "</td>";
            echo "<td>" . "<a class='button' href='consultarProtocolo.php?id={$row['protocolId']}'>Consultar</a>" . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>

<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>


<?php

//// Consulta no banco
//$query = "SELECT * FROM Cadastro;";
//$result = mysqli_query($mysql, $query);
//
//echo "{$result->num_rows} cadastro(s) encontrado(s):";
//
//// Encerra a conexão com o banco
//mysqli_close($mysql);
//
//// Código não usado
////session_start();
////$_SESSION['consultarId'] = 0;
//// Apresenta a tabela com os currículos cadastrados (nome e email)
////echo "<table><tr><th>ID</th><th>NOME</th><th>EMAIL</th></tr>";
//echo "<table><tr><th>Nome</th><th>Email</th></tr>";
//
//while($row = mysqli_fetch_assoc($result)) {
//    echo "<tr>";
////    echo "<td>" . $row['id'] . "</td>";
//    echo "<td>" . $row['nome'] . "</td>";
//    echo "<td>" . $row['email'] . "</td>";
//    echo "<td>" . "<a class='button' href='consultar.php?id={$row['id']}'>Consultar</a>" . "</td>";
//    echo "</tr>";
//}
//
//echo "</table>";

?>
