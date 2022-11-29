<?php
require_once '.\config.php';

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
