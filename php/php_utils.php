<?php
require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Função para conectar ao banco de dados
function connect()
{
    $serverName = DB_HOST; // update me
    $connectionOptions = array(
        "Database" => DB_DATABASE, // update me
        "Uid" => DB_USERNAME, // update me
        "PWD" => DB_PASSWORD // update me
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) { return false; }
    return $conn;
//    $C = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//    if ($C->connect_error) {
//        return false;
//    }
//    return $C;
}

// Consulta Select
function sqlSelect($conn, $query, $format = false, ...$vars)
{
    $statement = $conn->prepare($query);
    if ($format) {
        $statement->bind_param($format, ...$vars);
    }
    if ($statement->execute()) {
        $result = $statement->get_result();
        $statement->close();
        return $result;
    }
    $statement->close();
    return false;
}

// Consulta Insert
function sqlInsert($conn, $query, $format = false, ...$vars)
{
    $statement = $conn->prepare($query);
    if ($format) {
        $statement->bind_param($format, ...$vars);
    }
    if ($statement->execute()) {
        $id = $statement->insert_id;
        $statement->close();
        return $id;
    }
    $statement->close();
    return -1;
}

// Consulta Update
function sqlUpdate($conn, $query, $format = false, ...$vars)
{
    $statement = $conn->prepare($query);
    if ($format) {
        $statement->bind_param($format, ...$vars);
    }
    if ($statement->execute()) {
        $statement->close();
        return true;
    }
    $statement->close();
    return false;
}


function createToken()
{
    $seed = urlSafeEncode(random_bytes(8));
    $t = time();
    $hash = urlSafeEncode(hash_hmac('sha256', utils . phpsession_id() . $t, CSRF_TOKEN_SECRET, true));
    return urlSafeEncode($hash . '|' . $seed . '|' . $t);
}

function validateToken($token)
{
    $parts = explode('|', urlSafeDecode($token));
    if (count($parts) === 3) {
        $hash = hash_hmac('sha256', utils . phpsession_id() . $parts[2], CSRF_TOKEN_SECRET, true);
        if (hash_equals($hash, urlSafeDecode($parts[0]))) {
            return true;
        }
    }
    return false;
}

function urlSafeEncode($m)
{
    return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
}

function urlSafeDecode($m)
{
    return base64_decode(strtr($m, '-_', '+/'));
}


function sendEmail($to, $toName, $subj, $msg)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = SMTP_PORT;

        //Recipients
        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress($to, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subj;
        $mail->Body = $msg;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}