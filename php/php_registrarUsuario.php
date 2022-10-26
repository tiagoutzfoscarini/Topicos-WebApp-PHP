<?php

//require_once 'sendValidationEmail.php';
$errors = [];

// Validação de nome
if (!isset($_POST['name']) || strlen($_POST['name']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['name'])) {
    $errors[] = 1;
}
// Validação de email
if (!isset($_POST['email']) || strlen($_POST['email']) > 255 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 2;
}
// Validação de senha
if (!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])) {
    $errors[] = 3;
} else if (!isset($_POST['confirm-password']) || $_POST['confirm-password'] !== $_POST['password']) {
    $errors[] = 4;
}

// Se nenhuma validação falhou, prosseguir com o registro
if (count($errors) === 0) {
    if (isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
        // Conectar ao banco
        $conn = connect();
        if ($conn) {
            // Checar se email já está cadastrado
            $result = sqlSelect($conn, 'SELECT id FROM users WHERE email=?', 's', $_POST['email']);
            if ($result && $result->num_rows === 0) {
                // Criar a conta
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                // Insert ID, nome, email, senha e status de verificação no banco
                $id = sqlInsert($conn, 'INSERT INTO users VALUES (NULL, ?, ?, ?, ?, 0)', 'sss', $_POST['name'], $_POST['email'], $hash);
                if ($id !== -1) {
                    $err = sendValidationEmail($_POST['email']);
                    if ($err === 0) {
                        $errors[] = 0;
                    } else {
                        $errors[] = $err + 9;
                    }
                } else {
                    // Falha na inserção
                    $errors[] = 6;
                }
                $result->free_result();
            } else {
                // Email já existente
                $errors[] = 7;
            }
        } else {
            // Falha ao conectar no banco
            $errors[] = 8;
        }
    } else {
        // CSRF Token inválido
        $errors[] = 9;
    }
}

echo json_encode($errors);