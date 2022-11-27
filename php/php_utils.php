<?php
require_once '.\config.php';
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require 'PHPMailer-master/src/Exception.php';
//require 'PHPMailer-master/src/PHPMailer.php';
//require 'PHPMailer-master/src/SMTP.php';

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function validate_field_is_not_empty($field) {
    debug_to_console("Validating field: " . $field);

    if (empty($field)) {
        function_alert("Campo obrigatório não preenchido");
        return "";
    } else {
        return $field;
    }
}

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
    $stmt = sqlsrv_query( $conn, $query);

    if( $stmt === false ){
        debug_to_console("Error in executing SELECT query.</br>");
        die( print_r( sqlsrv_errors(), true));
    }

    return $stmt;
}


// Função para query select no SQL Server, recebe conexão e query
function sql_query_insert($conn, $query) {
    $stmt = sqlsrv_query( $conn, $query);

    if( $stmt === false ){
        debug_to_console("Error in executing INSERT query.</br>");
        die(print_r( sqlsrv_errors(), true));
    }

    return $stmt;
}
