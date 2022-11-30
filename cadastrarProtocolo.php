<?php
$utils = include ('php/php_utils.php');
$config = include('config.php');
?>
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

<div class="protocolBox">
    <form id="newProtocolForm" class="protocolForm" action="cadastrarProtocolo.php" method="post" >
        <label class="problemType">Tipo de problema*:<select id="problemType" name="problemType" required >
            <?php
            $conn = sql_connect();
            $sql = "SELECT * FROM problemTypes ORDER BY problemTypeName ASC";
            $stmt = sql_query_select($conn, $sql);

            while($row = sqlsrv_fetch_array($stmt)) {
                echo "<option value='{$row['problemTypeId']}'>{$row['problemTypeName']}</option>";
            }
            sqlsrv_close($conn);
            ?>
            </select></label>
        <br/>
        <label class="description">Descrição do problema*:<input id="description" name="description" type="text" placeholder="Conte o que aconteceu..." required ></label>
        <br/>
        <label class="name">Nome completo*:<input id="name" name="name" type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ ]+" placeholder="Informe seu nome completo..." required ></label>
        <br/>
        <label class="cpf">CPF*:<input id="cpf" name="cpf" type="text" placeholder="Informe seu CPF: 00000000000 (sem pontos, espaços ou traços)" required ></label>
        <br/>
        <label class="phone">Telefone para contato*:<input id="tel" name="tel" type="tel" size="11" pattern="[0-9]{2}[0-9]{9}" placeholder="Informe seu telefone no formato 519xxxxxxxx (sem pontos, espaços ou traços)" required ></label>
        <br/>
        <label class="email">Email para contato:<input id="email" name="email" type="email" placeholder="xxxxx@xxxxx.xxx" ></label>
        <br/>
        <label class="images">Imagens:<input id="images" name="images" type="file" accept="image/png, image/jpeg" multiple="multiple" ></label>
        <br/>
        <label class="city">Cidade*:<select id="city" name="city" required>
                <?php
                $conn = sql_connect();
                $sql = "SELECT * FROM cities ORDER BY cityName ASC";
                $stmt = sql_query_select($conn, $sql);

                while($row = sqlsrv_fetch_array($stmt)) {
                    echo "<option value='{$row['cityId']}'>{$row['cityName']}</option>";
                }
                sqlsrv_close($conn);
                ?>
            </select></label>
        <br/>
        <label class="address">Endereço*:<input id="address" type="text" name="address" placeholder="Informe o endereço do ocorrido, rua e número aproximado" required ></label>
        <br/>
<!--        <label class="map">Mapa: <input id="map" type="" disabled /></label>-->
<!--        <br/>-->
        <p class="notes">* campos obrigatórios</p>
        <input class='button' type="submit" name="submit" value="Enviar solicitação"/>
    </form>
</div>
<?php
// Submit do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $form_problemType = $_POST['problemType'];
    $form_description = $_POST['description'];
    $form_name = $_POST['name'];
    $form_cpf = $_POST['cpf'];
    $form_tel = $_POST['tel'];
    $form_email = $_POST['email'];
    $form_city = $_POST['city'];
    $form_address = $_POST['address'];

//    $form_problemType = isset($_POST['problemType']) ? $_POST['problemType'] : false;
//    $form_description = isset($_POST['description']) ? $_POST['description'] : false;
//    $form_name = isset($_POST['name']) ? $_POST['name'] : false;
//    $form_cpf = isset($_POST['cpf']) ? $_POST['cpf'] : false;
//    $form_tel = isset($_POST['tel']) ? $_POST['tel'] : false;
//    $form_city = isset($_POST['city']) ? $_POST['city'] : false;
//    $form_address = isset($_POST['address']) ? $_POST['address'] : false;

    $form_email = isset($_POST['email']) ? $_POST['email'] : false;
    $form_images = isset($_POST['images']) ? $_POST['images'] : false;

    $form_cpf = validate_CPF(str_replace(" ", "", $form_cpf));
//    $form_tel = validate_phone(str_replace(" ", "", $form_tel));

    $conn = sql_connect();

    if ($form_problemType && $form_description && $form_name && $form_cpf && $form_tel && $form_city && $form_address) {
        $sql = "INSERT INTO protocols (protocolProblemTypeId, protocolDescription, protocolRequesterName, protocolRequesterCpf, protocolRequesterPhone, protocolRequesterEmail, protocolCityId, protocolAddress, protocolStatusId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

//        $sql = "INSERT INTO protocols ('description', 'problemTypeId', 'cityId', 'address', 'statusId', 'requesterCpf', 'requesterName', 'requesterPhone') VALUES ('$form_description', '$form_description', '$form_city', '$form_address', 1, '$form_cpf', '$form_name', '$form_tel')";

        $params = array($form_problemType, $form_description, $form_name, $form_cpf, $form_tel, $form_email, $form_city, $form_address, 1);

        $stmt = sql_query_insert($conn, $sql, $params);

        if ($stmt) {
            echo "<script>alert('Protocolo cadastrado com sucesso!');</script>";
        } else {
//            echo "<script type='text/javascript'> alert('".json_encode($errors)."') </script>";
            echo "<script>alert('Erro ao cadastrar protocolo! Falha ao inserir no banco!');</script>";
        }
    } else {
//        echo "<script type='text/javascript'> alert('".json_encode($errors)."') </script>";
        echo "<script>alert('Erro ao cadastrar protocolo! Valores faltando!');</script>";
    }

    sqlsrv_close($conn);
}
?>
</body>
<footer>
    <p>&copy; Faccat - Tópicos Especiais 2022/02</p>
</footer>
</html>