<?php

require_once '../classes/AuthValidator.php';

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $auth = new AuthValidator($login, $password);

    $authRes = $auth->auth();

    if ($authRes !== null) {
        echo json_encode(['success' => $authRes]);
    } else {
        echo json_encode(['error' => 'Incorrect login or password']);
    }
}