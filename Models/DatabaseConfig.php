<?php

class DatabaseConfig
{
    /**
     * @var string Host
     */
    private $host;
    /**
     * @var string User
     */
    private $user;
    /**
     * @var string Password
     */
    private $password;
    /**
     * @var string Database
     */
    private $db;
    /**
     * @var false|resource
     */
    public $connection;

    public function __construct()
    {
        $config = require_once 'config.php';
        $this->user = $config['user'];
        $this->db = $config['db'];
        $this->host = $config['host'];
        $this->password = $config['password'];
    }

    public function openConnection()
    {
        $connectionString = "host=$this->host port=5432 dbname=$this->db user=$this->user password=$this->password";
        try {
            $this->connection = pg_pconnect($connectionString);
        } catch (Exception $e) {
            die("Error in connection: " . $e->getMessage());
        }
    }

    public function closeConnection()
    {
        try {
            pg_close($this->connection);
        } catch (Exception $e) {
            die("Error in closing: " . $e->getMessage());
        }
    }
}
