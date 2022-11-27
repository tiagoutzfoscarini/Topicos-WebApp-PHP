<?php require_once 'php/php_utils.php'; ?>
<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Protocolo</title>
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

<div class="newProtocolBox">
    <form id="newProtocolForm" class="newProtocolForm" onsubmit="getFormData(event)">
<!--    <form id="newProtocolForm" class="newProtocolForm">-->
        <label class="problemType">Tipo de problema*:<select id="problemType">
            <?php
            $conn = sql_connect();
            $sql = "SELECT * FROM problemTypes";
            $stmt = sql_query_select($conn, $sql);

            while($row = sqlsrv_fetch_array($stmt)) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            sqlsrv_close($conn);
            ?>
        </select></label>
        <br/>
        <label class="description">Descrição do problema*:<input id="description" type="text" required /></label>
        <br/>
        <label class="name">Nome completo*:<input id="name" type="text" required /></label>
        <br/>
        <label class="cpf">CPF*:<input id="cpf" type="text" required /></label>
        <br/>
        <label class="phone">Telefone para contato*:<input id="tel" type="tel" required /></label>
        <br/>
        <label class="email">Email para contato:<input id="email" type="email" /></label>
        <br/>
        <label class="images">Imagens:<input id="images" type="file" /></label>
        <br/>
        <label class="city">Cidade*:<select id="city">
                <?php
                $conn = sql_connect();
                $sql = "SELECT * FROM cities";
                $stmt = sql_query_select($conn, $sql);

                while($row = sqlsrv_fetch_array($stmt)) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                sqlsrv_close($conn);
                ?>
            </select></label>
        <br/>
        <label class="address">Endereço*:<input id="address" type="text" required /></label>
        <br/>
        <label class="map">Mapa: <input id="map" type="" disabled /></label>
        <br/>
        <p class="notes">* campos obrigatórios</p>
        <input class='button' type="submit" value="Enviar solicitação"/>
    </form>
</div>

<!--Debugging only-->
<script>
    function getFormData(event) {
        event.preventDefault();
        var problemType = document.getElementById("problemType").value;
        var description = document.getElementById("description").value;
        var name = document.getElementById("name").value;
        var cpf = document.getElementById("cpf").value;
        var tel = document.getElementById("tel").value;
        var email = document.getElementById("email").value;
        var images = document.getElementById("images").value;
        var city = document.getElementById("city").value;
        var address = document.getElementById("address").value;

        console.log("problemType: " + problemType);
        console.log("description: " + description);
        console.log("name: " + name);
        console.log("cpf: " + cpf);
        console.log("tel: " + tel);
        console.log("email: " + email);
        console.log("images: " + images);
        console.log("city: " + city);
        console.log("address: " + address);
    }
</script>

<?php
// Submit do formulário
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = sql_connect();

    $problemType = validate_field_is_not_empty($_POST['problemType']);
    $description = validate_field_is_not_empty($_POST['description']);
    $name = validate_field_is_not_empty($_POST['name']);
    $cpf = validate_field_is_not_empty($_POST['cpf']);
    $tel = validate_field_is_not_empty($_POST['tel']);
    $email = validate_field_is_not_empty($_POST['email']);
    $images = validate_field_is_not_empty($_POST['images']);
    $city = validate_field_is_not_empty($_POST['city']);
    $address = validate_field_is_not_empty($_POST['address']);

    if ($problemType <> "" && $description <> "" && $name <> "" && $cpf <> "" && $tel <> "" && $city <> "" && $address <> "") {
        $sql = "INSERT INTO protocols (description, problemTypeId, cityId, address, statusId, requesterCpf, requesterName, requesterPhone)
                VALUES ($description, $problemType, $city, $address, 1, $cpf, $name, $tel)";

        $stmt = sql_query_insert($conn, $sql);

        if ($stmt) {
            echo "<script>alert('Protocolo cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar protocolo!');</script>";
        }
    } else {
        echo "<script>alert('Erro ao cadastrar protocolo!');</script>";
    }

    // Inserção do novo cadastro no banco

}
?>
</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>