<?php
namespace Controllers;

use Models\Player;
use Utils\Response;
use PDO;

class PlayerController
{
    private Player $playerModel;
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->playerModel = new Player($connection);
    }

    public function createPlayer(array $data): void
    {
        $this->playerModel->name = $data['name'] ?? null;
        $this->playerModel->age = $data['age'] ?? null;
        $this->playerModel->position_id = $this->getPositionIdByName($data['position']) ?? null;
        $this->playerModel->club_id = $this->getClubIdByName($data['club']) ?? null;
        $this->playerModel->nationality_id = $this->getNationalityIdByName($data['nationality']) ?? null;
        $this->playerModel->rating = $data['rating'] ?? null;
        $this->playerModel->photo_url = $data['photo_url'] ?? null;
        $this->playerModel->flag_url = $data['flag_url'] ?? null;
        $this->playerModel->pace = $data['pace'] ?? null;
        $this->playerModel->shooting = $data['shooting'] ?? null;
        $this->playerModel->passing = $data['passing'] ?? null;
        $this->playerModel->dribbling = $data['dribbling'] ?? null;
        $this->playerModel->defending = $data['defending'] ?? null;
        $this->playerModel->physical = $data['physical'] ?? null;

        if ($this->playerModel->create()) {
            Response::sendResponse(201, "Player created successfully");
        } else {
            Response::sendResponse(500, "Unable to create player");
        }
    }

    public function getAllPlayers(): void
    {
        $players = $this->playerModel->readAll();

        if (!empty($players)) {
            Response::sendResponse(200, "Players retrieved", $players);
        } else {
            Response::sendResponse(404, "No players found");
        }
    }

    public function getSinglePlayer(int $id): void
    {
        $this->playerModel->player_id = $id;
        $playerData = $this->playerModel->readSingle();

        if ($playerData) {
            Response::sendResponse(200, "Player retrieved", $playerData);
        } else {
            Response::sendResponse(404, "Player not found");
        }
    }
    public function updatePlayer(array $data): void
    {
        error_log("Beginning update process for player...");
        error_log("Received data: " . print_r($data, true));
    
        // Check for player_id instead of id
        if (!isset($data['id'])) {
            error_log("No player ID provided");
            Response::sendResponse(400, "Player ID is required");
            return;
        }
    
        // Set player_id first
        $this->playerModel->player_id = $data['id'];
        
        // Check if player exists
        $existingPlayer = $this->playerModel->readSingle();
        

        if (!$existingPlayer) {
            error_log("Player with ID {$data['id']} not found");
            Response::sendResponse(404, "Player not found  {$data['id']}");
            return;
        }
    
        // // Convert nationality name to ID
        $nationality_id = null;
        if (isset($data['nationality'])) {
            $nationality_id = $this->getNationalityIdByName($data['nationality']);
            error_log("Nationality lookup: {$data['nationality']} -> {$nationality_id}");
        }
    
        // Set all the properties
        $this->playerModel->name = $data['name'] ?? null;
        $this->playerModel->age = $data['age'] ?? null;
        $this->playerModel->position_id = isset($data['position']) ? $this->getPositionIdByName($data['position']) : null;
        $this->playerModel->club_id = isset($data['club']) ? $this->getClubIdByName($data['club']) : null;
        $this->playerModel->nationality_id = $nationality_id;
        $this->playerModel->rating = $data['rating'] ?? null;
        $this->playerModel->photo_url = $data['photo_url'] ?? null;
        $this->playerModel->pace = $data['pace'] ?? null;
        $this->playerModel->shooting = $data['shooting'] ?? null;
        $this->playerModel->passing = $data['passing'] ?? null;
        $this->playerModel->dribbling = $data['dribbling'] ?? null;
        $this->playerModel->defending = $data['defending'] ?? null;
        $this->playerModel->physical = $data['physical'] ?? null;
    
        // Log the final data being sent to update
        error_log("Attempting to update with data: " . print_r(get_object_vars($this->playerModel), true));
    
        if ($this->playerModel->update()) {
            error_log("Update successful");
            Response::sendResponse(200, "Player updated successfully");
        } else {
            error_log("Update failed");
            Response::sendResponse(500, "Unable to update player");
        }
    }
    public function deletePlayer(int $id): void
    {
        $this->playerModel->player_id = $id;

        if ($this->playerModel->delete()) {
            Response::sendResponse(200, "Player deleted successfully");
        } else {
            Response::sendResponse(500, "Unable to delete player");
        }
    }
    public function getPositionIdByName(string $position): ?int
    {
        $query = "SELECT id FROM positions WHERE position = :position LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':position', $position, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['id'] : null;
    }

    public function getClubIdByName(string $club): ?int
    {
        $query = "SELECT id FROM clubs WHERE name = :club LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':club', $club, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['id'] : null;
    }
    public function getNationalityIdByName(string $nationality): ?int
    {
        $query = "SELECT nationality_id FROM nationality WHERE name = :nationality LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':nationality', $nationality, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['nationality_id'] : null;
      

    }



}