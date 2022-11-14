<?php

require_once 'JSONDatabase.php';


/**
 *
 */
class RegValidator
{
    private string $name;
    private string $login;
    private string $email;
    private string $password;
    private string $confirm_password;

    private string $namePattern = "/[a-zA-Z_\-0-9]{2,}/m";
    private string $loginPattern = "/[a-zA-Z_\-0-9]{6,}/m";
    private string $passwordPattern = "/(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?=.*[A-Za-z]).*$/m";

    private JSONDatabase $db;

    private array $errors;

    /**
     * @param string $name
     * @param string $login
     * @param string $email
     * @param string $password
     */
    public function __construct(string $name, string $login, string $email, string $password, string $confirm_password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;

        $this->db = JSONDatabase::getInstance();
        $this->db->connect();

        $this->errors = [
            'name' => '',
            'email' => '',
            'login' => '',
            'password' => '',
            'confirm_password' => '',
        ];
    }

    public function validate()
    {
        if ($this->emailValidation() && $this->nameValidation() && $this->passwordConfirmation()
            && $this->loginValidation() && $this->passwordValidation() && $this->checkUniqueness()) {

            $this->passwordHash();
            return true;
        } else {
            if (!$this->emailValidation()) {
                $this->errors['email'] = 'Incorrect format. Email must be email...';
            }
            if (!$this->passwordValidation()) {
                $this->errors['password'] = "Incorrect format. Password must be at least 6 characters long 
                    and contain letters and numbers.";
            }
            if (!$this->passwordConfirmation()) {
                $this->errors['confirm_password'] = "Passwords do not match.";
            }
            if (!$this->loginValidation()) {
                $this->errors['login'] = "Incorrect format. Login must be at least 6 characters long.";
            }
            if (!$this->nameValidation()) {
                $this->errors['name'] = "Incorrect format. Name must be at least 2 characters long.";
            }
        }

        return false;
    }

    public function nameValidation(): bool
    {
        return preg_match($this->namePattern, $this->name);
    }

    public function loginValidation(): bool
    {
        return preg_match($this->loginPattern, $this->login);
    }

    public function emailValidation(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function passwordValidation(): bool
    {
        return preg_match($this->passwordPattern, $this->password);
    }

    public function passwordConfirmation(): bool
    {
        return $this->password === $this->confirm_password;
    }

    public function passwordHash()
    {
        $this->password = sha1($this->password);
    }

    public function checkUniqueness(): bool
    {
        $flag = true;
        if ($this->checkElUniqueness('login', $this->login) !== null) {
            $this->errors['login'] = 'Login is not unique';
            $flag = false;
        }
        if ($this->checkElUniqueness('email', $this->email) !== null) {
            $this->errors['email'] = 'Email is not unique';
            $flag = false;
        }
        return $flag;
    }

    public function checkElUniqueness(string $field, string $element)
    {
        return $this->db->selectWhere([$field], $field, $element);
    }

    public function saveUserInDatabase()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'login' => $this->login,
            'password' => $this->password,
        ];

        $this->db->insert($data);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}