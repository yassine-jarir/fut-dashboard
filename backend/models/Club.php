<?php
namespace Models;

use PDO;

class Club
{
    private PDO $connection;
    private string $table_name = 'clubs';

    // Club properties
    public ?int $id = null;
    public ?string $name = null;
    public ?string $nationality = null;

    public ?string $logo_url = null;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(): bool
    {
        $query = "INSERT INTO {$this->table_name} 
                  (name,    logo_url) 
                  VALUES 
                  (:name,    :logo_url)";

        try {
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(':name', $this->name);
             $stmt->bindValue(':logo_url', $this->logo_url);

            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Create Club Error: " . $exception->getMessage());
            return false;
        }
    }

    public function readAll(): array
    {
        $query = "SELECT * FROM {$this->table_name}";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
            error_log("Read All Clubs Error: " . $exception->getMessage());
            return [];
        }
    }

    public function readSingle(): ?array
    {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $this->id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (\PDOException $exception) {
            error_log("Read Single Club Error: " . $exception->getMessage());
            return null;
        }
    }

    public function update(): bool
    {
        $query = "UPDATE {$this->table_name} 
                  SET name = :name,
                      logo_url = :logo_url
                  WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(':name', $this->name);
          
        
            $stmt->bindValue(':logo_url', $this->logo_url);
            $stmt->bindValue(':id', $this->id);

            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Update Club Error: " . $exception->getMessage());
            return false;
        }
    }

    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $this->id);
            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Delete Club Error: " . $exception->getMessage());
            return false;
        }
    }
}