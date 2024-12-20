<?php
namespace Controllers;

use Models\Club;
use Utils\Response;
use PDO;

class ClubController
{
    private Club $clubModel;
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->clubModel = new Club($connection);
    }

    public function createClub(array $data): void
    {
        $this->clubModel->name = $data['name'] ?? null;
        $this->clubModel->league = $data['league'] ?? null;
        $this->clubModel->country = $data['country'] ?? null;
        $this->clubModel->stadium = $data['stadium'] ?? null;
        $this->clubModel->logo_url = $data['logo_url'] ?? null;

        if ($this->clubModel->create()) {
            Response::sendResponse(201, "Club created successfully");
        } else {
            Response::sendResponse(500, "Unable to create club");
        }
    }

    public function getAllClubs(): void
    {
        $clubs = $this->clubModel->readAll();

        if (!empty($clubs)) {
            Response::sendResponse(200, "Clubs retrieved", $clubs);
        } else {
            Response::sendResponse(404, "No clubs found");
        }
    }

    public function getSingleClub(int $id): void
    {
        $this->clubModel->id = $id;
        $clubData = $this->clubModel->readSingle();

        if ($clubData) {
            Response::sendResponse(200, "Club retrieved", $clubData);
        } else {
            Response::sendResponse(404, "Club not found");
        }
    }

    public function updateClub(array $data): void
    {
        if (!isset($data['id'])) {
            Response::sendResponse(400, "Club ID is required");
            return;
        }

        $this->clubModel->id = $data['id'];
        $existingClub = $this->clubModel->readSingle();

        if (!$existingClub) {
            Response::sendResponse(404, "Club not found");
            return;
        }

        $this->clubModel->name = $data['name'] ?? null;
        $this->clubModel->league = $data['league'] ?? null;
        $this->clubModel->country = $data['country'] ?? null;
        $this->clubModel->stadium = $data['stadium'] ?? null;
        $this->clubModel->logo_url = $data['logo_url'] ?? null;

        if ($this->clubModel->update()) {
            Response::sendResponse(200, "Club updated successfully");
        } else {
            Response::sendResponse(500, "Unable to update club");
        }
    }

    public function deleteClub(int $id): void
    {
        $this->clubModel->id = $id;

        if ($this->clubModel->delete()) {
            Response::sendResponse(200, "Club deleted successfully");
        } else {
            Response::sendResponse(500, "Unable to delete club");
        }
    }
}