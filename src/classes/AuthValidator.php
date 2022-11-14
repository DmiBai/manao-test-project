<?php

require_once 'JSONDatabase.php';

class AuthValidator
{
    private string $login;
    private string $password;

    private JSONDatabase $db;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;

        $this->db = JSONDatabase::getInstance();
        $this->db->connect();
    }

    public function auth(): ?string
    {
        $userData = $this->db->selectWhere(['name', 'password'], 'login', $this->login);

        //check if password from form and db are the same
        if ($userData && $userData[0]['password'] === sha1($this->password)) {
            return $userData[0]['name'];
        } else {
            return null;
        }
    }
}