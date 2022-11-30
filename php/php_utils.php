<?php
$config = include('config.php');

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function validate_CPF($cpf) {
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

//function validate_phone($telefone){
//    $telefone = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));
//
//    $regexTelefone = '[0-9]{11}';
////    $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
//    if (preg_match($regexTelefone, $telefone)) {
//        return true;
//    } else {
//        return false;
//    }
//}

//function test_input($data) {
//    $data = trim($data);
////    $data = stripslashes($data);
////    $data = htmlspecialchars($data);
//    $data = filter_var($data, FILTER_SANITIZE_STRING);
//    return $data;
//}
//
//function validate_field_is_not_empty($errorArray, $field, $fieldDisplayName) {
//    if (empty($_POST[$field])) {
//        $errorMsg = "$fieldDisplayName não pode ser vazio";
//        array_push($errorArray, $errorMsg);
//        return false;
//    } else {
//        return true;
//    }
//}

// Função para conectar ao banco de dados
function sql_connect() {
    // Conectar ao servidor e banco
    global $db_host;
    global $db_port;
    global $db_name;
    global $db_username;
    global $db_password;

    /* Specify the server and connection string attributes. */
    $serverName = $db_host;
    $databaseName = $db_name;

    /* Get UID and PWD from application-specific files.  */
    $uid = $db_username;
    $pwd = $db_password;
    $connectionInfo = array("UID"=>$uid,
        "PWD"=>$pwd,
        "Database"=>$databaseName,
        "CharacterSet" => "UTF-8");

    /* Connect using SQL Server Authentication. */
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if( $conn === false )
    {
        debug_to_console("Unable to connect.</br>");
        die( print_r( sqlsrv_errors(), true));
    }

    return $conn;
}

// Função para query select no SQL Server, recebe conexão e query
function sql_query_select($conn, $query) {
    $stmt = sqlsrv_query($conn, $query);

    if ($stmt === false ) {
        debug_to_console("Error in executing SELECT query.</br>");
        die( print_r( sqlsrv_errors(), true));
    }

    return $stmt;
}


// Função para query select no SQL Server, recebe conexão e query
function sql_query_insert($conn, $query, $params) {
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false ) {
        debug_to_console("Error in executing INSERT query.</br>");
        die(print_r(sqlsrv_errors(), true));
    }

    return $stmt;
}

function sql_get_max_status_id($conn) {
    $query = "SELECT MAX(statusId) AS max_id FROM statusList";
    $stmt = sql_query_select($conn, $query);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row['max_id'];
}

function sql_get_current_protocol_status($conn, $protocolId) {
    $query = "SELECT * FROM protocols WHERE protocolId = $protocolId";
    $stmt = sql_query_select($conn, $query);

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    return $row['protocolStatusId'];
}

// Função para query update protocol no SQL Server, recebe query e novo status
function sql_update_protocol_Status($conn, $protocolId) {
    $currentStatus = sql_get_current_protocol_status($conn, $protocolId);
    $maxStatus = sql_get_max_status_id($conn);

    if ($currentStatus < $maxStatus) {
        $newStatus = $currentStatus + 1;
    } else {
        $newStatus = 1;
    }

    $query = "UPDATE protocols SET protocolStatusId = ? WHERE protocolId = ?";
    $params = array($newStatus, $protocolId);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false ) {
        debug_to_console("Error in executing UPDATE query.</br>");
        die(print_r(sqlsrv_errors(), true));
    }

    return $stmt;
}