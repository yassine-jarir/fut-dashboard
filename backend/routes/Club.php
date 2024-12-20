<?php
namespace Routes;

use Controllers\ClubController;
use PDO;

class ClubRoutes
{
    private ClubController $clubController;

    public function __construct(PDO $connection)
    {
        $this->clubController = new ClubController($connection);
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
             
                if (count($uriParts) === 1 && $uriParts[0] === 'clubs') {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->clubController->createClub($data);
                }
                break;

            case 'GET':
               
                if (count($uriParts) === 1 && $uriParts[0] === 'clubs') {
                    $this->clubController->getAllClubs();
                }
              
                elseif (
                    count($uriParts) === 2 &&
                    $uriParts[0] === 'clubs' &&
                    is_numeric($uriParts[1])
                ) {
                    $this->clubController->getSingleClub((int) $uriParts[1]);
                }
                break;

            case 'PUT':
                if (count($uriParts) === 2 && $uriParts[0] === 'clubs' && is_numeric($uriParts[1])) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $data['id'] = (int) $uriParts[1];
                    $this->clubController->updateClub($data);
                }
                break;

            case 'DELETE':
           
                if (
                    count($uriParts) === 2 &&
                    $uriParts[0] === 'clubs' &&
                    is_numeric($uriParts[1])
                ) {
                    $this->clubController->deleteClub((int) $uriParts[1]);
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