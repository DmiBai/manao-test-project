<?php

class JSONDatabase
{
    private stdClass $json;
    private string $path = '';

    private static $instance = null;
    private array $required = [
        'name',
        'email',
        'login',
        'password',
    ];

    public function __construct()
    {
        //TODO: do not add anything
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }

    /**
     * @param string $path
     * @return void
     */
    public function connect(string $path = '../../db/users.json')
    {
        if (!file_exists($path)) {
            fopen($path, 'w+');
        }

        $this->path = $path;

        //create pattern content if file is empty
        if (json_decode(file_get_contents("$this->path")) == null) {
            $file = fopen("$this->path", "w");
            if ($file) {
                fwrite($file, json_encode(['users' => []]));
                fclose($file);
            }
        }
        $this->json = json_decode(file_get_contents($this->path));

    }

    /**
     * @param array $data = [$name, $email, $login, $password]
     * @return bool
     */
    public function insert(array $data): int
    {
        $this->connect();

        //check if there are all required fields
        foreach ($this->required as $item) {
            if (!array_key_exists($item, $data)) {
                return 1;
            }
        }

        array_push($this->json->users, $data);
        $this->write();

        return 0;
    }

    public function selectWhere(array $columns, string $key, string $value)
    {
        if ($columns === null || !isset($this->json)) {
            return null;
        }

        $whereRes = [];
        //select rows with chosen key value
        foreach ($this->json->users as $rowKey => $row) {
            while ($item = current($row)) {
                if ($item === $value) {
                    if (key($row) === $key) {
                        $whereRes[$rowKey] = $row;
                    }
                }
                next($row);
            }
        }

        if (count($whereRes) === 0) {
            return null;
        }

        $result = [];
        //select only needed columns from rows
        foreach ($whereRes as $key => $row) {
            $temp = [];
            foreach ($columns as $column) {
                $temp[$column] = $row->$column;
            }
            array_push($result, $temp);
        }

        return $result;

    }

    private function write()
    {
        $file = fopen($this->path, "w");
        fwrite($file, json_encode($this->json));
    }
}
