<?php
require_once '../classes/RegValidator.php';

if ((isset($_POST['name'])) && (isset($_POST['email'])) && (isset($_POST['login'])) &&
    (isset($_POST['password'])) && (isset($_POST['confirm_password']))) {

    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $validator = new RegValidator($name, $login, $email, $password, $confirm_password);
    if (!$validator->validate()) {
        echo json_encode($validator->getErrors());
    } else {
        $validator->saveUserInDatabase();
        echo json_encode('success');
    }
}