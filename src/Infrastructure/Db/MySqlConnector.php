<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Infrastructure\Db;

class MySqlConnector implements DbConnector
{
    private \PDO $conn;

    public function __construct($hostname, $username, $password, $database, $port)
    {
        try {
            $this->conn = new \PDO("mysql:host=$hostname;port=$port;dbname=$database", $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Failed to connect to MySql: ' . $e->getMessage());
        }
    }

    public function getConnection() : \PDO
    {
        return $this->conn;
    }
}
