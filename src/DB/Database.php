<?php

namespace App\DB;

use PDO;
use PDOStatement;
use Exception;
use PDOException;

class Database
{
    // TODO: proper way is to move this to .env
    /**
     * Host: docker service name: 'db'
     * @var string
     */
    private string $host = 'db';
    /**
     * @var string
     */
    private string $database = 'tracker';
    /**
     * @var string
     */
    private string $username = 'tracker_user';
    /**
     * @var string
     */
    private string $password = 'tracker_password';
    /**
     * @var PDO|null
     */
    private ?PDO $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->database);
            $connection = new PDO($dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $connection;
        } catch (PDOException $e) {
            throw new Exception('Database connection failed. ' . $e->getMessage());
        }
    }

    /**
     * Execute a query with given parameters
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $sql, array $params = []): PDOStatement
    {
        $statement = $this->connection->prepare($sql);

        foreach ($params as $index => $value) {
            $statement->bindValue($index + 1, $value);
        }

        $statement->execute();
        return $statement;
    }
}
