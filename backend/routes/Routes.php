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
        
        $method = $_SERVER['REQUEST_METHOD'];

       
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriParts = explode('/', $uri);

       
        $uriParts = array_filter($uriParts);
        $uriParts = array_values($uriParts); 

       
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json; charset=UTF-8');

        switch ($method) {
            case 'POST':
               
                if (count($uriParts) === 1 && $uriParts[0] === 'players') {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->playerController->createPlayer($data);
                }
                break;

            case 'GET':
                
                if (count($uriParts) === 1 && $uriParts[0] === 'players') {
                    $this->playerController->getAllPlayers();
                }
               
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
             
                if (
                    count($uriParts) === 2 &&
                    $uriParts[0] === 'players' &&
                    is_numeric($uriParts[1])
                ) {
                    $this->playerController->deletePlayer((int) $uriParts[1]);
                }
                break;

            case 'OPTIONS':
                http_response_code(200);
                break;

            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                break;
        }
    }
}