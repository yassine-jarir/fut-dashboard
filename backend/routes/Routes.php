<?php
namespace Routes;

use Controllers\PlayerController;
use PDO;

class PlayerRoutes
{
    private PlayerController $playerController;

    public function __construct(PDO $connection)
    {
        $this->playerController = new PlayerController($connection);
    }

    public function handleRequest(): void
    {
        // Get request method
        $method = $_SERVER['REQUEST_METHOD'];

        // Get URI parts
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriParts = explode('/', $uri);

        // Remove empty parts and index
        $uriParts = array_filter($uriParts);
        $uriParts = array_values($uriParts); // Re-index array after filtering

        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json; charset=UTF-8');

        switch ($method) {
            case 'POST':
                // Create player
                if (count($uriParts) === 1 && $uriParts[0] === 'players') {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->playerController->createPlayer($data);
                }
                break;

            case 'GET':
                // Get all players
                if (count($uriParts) === 1 && $uriParts[0] === 'players') {
                    $this->playerController->getAllPlayers();
                }
                // Get single player
                elseif (
                    count($uriParts) === 2 &&
                    $uriParts[0] === 'players' &&
                    is_numeric($uriParts[1])
                ) {
                    $this->playerController->getSinglePlayer((int) $uriParts[1]);
                }
                break;

            case 'PUT':
                if (count($uriParts) === 2 && $uriParts[0] === 'players' && is_numeric($uriParts[1])) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $data['id'] = (int) $uriParts[1];
                    $this->playerController->updatePlayer($data);
                }
                break;
            case 'DELETE':
                // Delete player
                if (
                    count($uriParts) === 2 &&
                    $uriParts[0] === 'players' &&
                    is_numeric($uriParts[1])
                ) {
                    $this->playerController->deletePlayer((int) $uriParts[1]);
                }
                break;

            case 'OPTIONS':
                // Handle preflight requests for CORS
                http_response_code(200);
                break;

            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                break;
        }
    }
}