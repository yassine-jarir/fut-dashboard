<?php
namespace Config;

class Database
{
    private string $host = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private string $dbname = 'fut';
    private ?\PDO $connection = null;

    public function getConnection(): ?\PDO
    {

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new \PDO($dsn, $this->username, $this->password, $options);
            return $this->connection;
        } catch (\PDOException $exception) {
     
            error_log("PDO Connection Error: " . $exception->getMessage());
            throw new \Exception("Database Connection Failed: " . $exception->getMessage());
        }
    }
}