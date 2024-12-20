<?php
namespace Models;

use PDO;

class Player
{
    private PDO $connection;
    private string $table_name = 'players';

    // Player properties
    public ?int $player_id = null;
    public ?string $name = null;
    public ?int $age = null;
    public ?int $position_id = null;
    public ?int $club_id = null;
    public ?string $nationality = null;
    public ?int $rating = null;
    public ?string $photo_url = null;
    public ?string $flag_url = null;
    public ?int $pace = null;
    public ?int $shooting = null;
    public ?int $passing = null;
    public ?int $dribbling = null;
    public ?int $defending = null;
    public ?int $physical = null;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(): bool
    {
        $query = "INSERT INTO {$this->table_name} 
                  (name,age, position_id, club_id, pace, photo_url, shooting, 
                   passing, dribbling, defending, physical,
                   flag_url, nationality, rating) 
                  VALUES 
                  (:name, :age, :position_id, :club_id, :pace, :photo_url, :shooting, 
                   :passing, :dribbling, :defending, :physical,
                   :flag_url, :nationality, :rating)";

        try {
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(':name', $this->name);
            $stmt->bindValue(':age', $this->age);
            $stmt->bindValue(':position_id', $this->position_id);
            $stmt->bindValue(':club_id', $this->club_id);
            $stmt->bindValue(':pace', $this->pace);
            $stmt->bindValue(':photo_url', $this->photo_url);
            $stmt->bindValue(':shooting', $this->shooting);
            $stmt->bindValue(':passing', $this->passing);
            $stmt->bindValue(':dribbling', $this->dribbling);
            $stmt->bindValue(':defending', $this->defending);
            $stmt->bindValue(':physical', $this->physical);
            $stmt->bindValue(':flag_url', $this->flag_url);
            $stmt->bindValue(':nationality', $this->nationality);
            $stmt->bindValue(':rating', $this->rating);

            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Create Player Error: " . $exception->getMessage());
            return false;
        }
    }

    public function readAll(): array
    {
        // Modify the query to join with positions and clubs tables
        $query = "
            SELECT 
                p.player_id, 
                p.name, 
                p.age, 
                p.nationality, 
                p.rating, 
                p.photo_url, 
                p.flag_url, 
                p.pace, 
                p.shooting, 
                p.passing, 
                p.dribbling, 
                p.defending, 
                p.physical, 
                pos.position,   
                c.name AS club_name      
            FROM 
                {$this->table_name} p
            LEFT JOIN 
                
                clubs c ON p.club_id = c.id
            LEFT JOIN 
                positions pos ON p.position_id = pos.id
        ";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
            error_log("Read All Players Error: " . $exception->getMessage());
            return [];
        }
    }


    public function readSingle(): ?array
    {
        $query = "
            SELECT 
                p.player_id, 
                p.name, 
                p.age, 
                p.nationality, 
                p.rating, 
                p.photo_url, 
                p.flag_url, 
                p.pace, 
                p.shooting, 
                p.passing, 
                p.dribbling, 
                p.defending, 
                p.physical,
                p.position_id,
                p.club_id,
                pos.position,
                c.name AS club_name
            FROM 
                {$this->table_name} p
            LEFT JOIN 
                clubs c ON p.club_id = c.id
            LEFT JOIN 
                positions pos ON p.position_id = pos.id
            WHERE 
                p.player_id = :id";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $this->player_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (\PDOException $exception) {
            error_log("Read Single Player Error: " . $exception->getMessage());
            return null;
        }
    }

    public function update(): bool
    {
        error_log("Starting update in Player model");
        error_log("Player ID being updated: " . $this->player_id);

        $query = "UPDATE {$this->table_name} 
                  SET name = :name, 
                      age = :age, 
                      position_id = :position_id, 
                      club_id = :club_id, 
                      nationality = :nationality, 
                      rating = :rating,
                      photo_url = :photo_url,
                      flag_url = :flag_url,
                      pace = :pace,
                      shooting = :shooting,
                      passing = :passing,
                      dribbling = :dribbling,
                      defending = :defending,
                      physical = :physical
                  WHERE player_id = :player_id";

        try {
            $stmt = $this->connection->prepare($query);

            $params = [
                ':name' => $this->name,
                ':age' => $this->age,
                ':position_id' => $this->position_id,
                ':club_id' => $this->club_id,
                ':nationality' => $this->nationality,
                ':rating' => $this->rating,
                ':photo_url' => $this->photo_url,
                ':flag_url' => $this->flag_url,
                ':pace' => $this->pace,
                ':shooting' => $this->shooting,
                ':passing' => $this->passing,
                ':dribbling' => $this->dribbling,
                ':defending' => $this->defending,
                ':physical' => $this->physical,
                ':player_id' => $this->player_id
            ];

            error_log("Parameters for update: " . print_r($params, true));

            foreach ($params as $key => $value) {
                $stmt->bindValue(
                    $key,
                    $value,
                    $value === null ? PDO::PARAM_NULL :
                    (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR)
                );
            }

            $result = $stmt->execute();
            error_log("Update execution result: " . ($result ? "true" : "false"));
            error_log("Rows affected: " . $stmt->rowCount());

            return $result;
        } catch (\PDOException $exception) {
            error_log("Update Player Error: " . $exception->getMessage());
            error_log("SQL State: " . $exception->getCode());
            return false;
        }
    }


    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table_name} WHERE player_id = :player_id"; //:player_id is a placeholder in the SQL query.

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':player_id', $this->player_id); // Take the value stored in $this->player_id  and replace the placeholder :player_id in the SQL query with that value.
            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Delete Player Error: " . $exception->getMessage());
            return false;
        }
    }
}