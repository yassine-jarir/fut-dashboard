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
    public ?string $nationality_id = null;
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
                   nationality_id, rating) 
                  VALUES 
                  (:name, :age, :position_id, :club_id, :pace, :photo_url, :shooting, 
                   :passing, :dribbling, :defending, :physical
                 , :nationality_id, :rating)";

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
             $stmt->bindValue(':nationality_id', $this->nationality_id);
            $stmt->bindValue(':rating', $this->rating);

            return $stmt->execute();
        } catch (\PDOException $exception) {
            error_log("Create Player Error: " . $exception->getMessage());
            return false;
        }
    }

    public function readAll(): array
    {
         $query = "
            SELECT 
                p.player_id, 
                p.name, 
                p.age, 
                p.rating, 
                p.photo_url, 
                p.pace, 
                p.shooting, 
                p.passing, 
                p.dribbling, 
                p.defending, 
                p.physical, 
                pos.position,   
                c.name AS club_name,
                n.name AS nationality_name,
                n.flag_url 
            FROM 
                {$this->table_name} p
            LEFT JOIN 
                
                clubs c ON p.club_id = c.id
            LEFT JOIN 
                positions pos ON p.position_id = pos.id
            LEFT JOIN 
                nationality n ON p.nationality_id = n.nationality_id
            
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
                p.rating, 
                p.photo_url, 
                p.pace, 
                p.shooting, 
                p.passing, 
                p.dribbling, 
                p.defending, 
                p.physical, 
                pos.position,   
                c.name AS club_name,
                n.name AS nationality_name,
                n.flag_url 
            FROM 
                {$this->table_name} p
            LEFT JOIN 
                clubs c ON p.club_id = c.id
            LEFT JOIN 
                positions pos ON p.position_id = pos.id
            LEFT JOIN 
                nationality n ON p.nationality_id = n.nationality_id
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
        $query = "UPDATE {$this->table_name} 
                  SET name = :name, 
                      age = :age, 
                      position_id = :position_id, 
                      club_id = :club_id, 
                      nationality_id = :nationality_id, 
                      rating = :rating,
                      photo_url = :photo_url,
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
                ':name' => [$this->name, PDO::PARAM_STR],
                ':age' => [$this->age, $this->age === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':position_id' => [$this->position_id, $this->position_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':club_id' => [$this->club_id, $this->club_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':nationality_id' => [$this->nationality_id, $this->nationality_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':rating' => [$this->rating, $this->rating === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':photo_url' => [$this->photo_url, PDO::PARAM_STR],
                ':pace' => [$this->pace, $this->pace === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':shooting' => [$this->shooting, $this->shooting === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':passing' => [$this->passing, $this->passing === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':dribbling' => [$this->dribbling, $this->dribbling === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':defending' => [$this->defending, $this->defending === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':physical' => [$this->physical, $this->physical === null ? PDO::PARAM_NULL : PDO::PARAM_INT],
                ':player_id' => [$this->player_id, PDO::PARAM_INT]
            ];
    
             foreach ($params as $key => [$value, $type]) {
                $stmt->bindValue($key, $value, $type);
            }
    
            $result = $stmt->execute();
    
             if ($result && $stmt->rowCount() === 0) {
                error_log("Update executed but no rows were affected. Player ID might not exist.");
                return false;
            }
    
            return $result;
        } catch (\PDOException $exception) {
            error_log("Update Player Error: " . $exception->getMessage());
            error_log("SQL State: " . $exception->getCode());
            return false;
        }
    }


    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table_name} WHERE player_id = :player_id"; 

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