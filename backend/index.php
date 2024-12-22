<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Failed to load: $file");
    }
});

use Config\Database;
use Routes\PlayerRoutes;
use Routes\ClubRoutes;
 
require_once 'config/Database.php';
require_once 'utils/Response.php';
require_once 'routes/Routes.php';
require_once 'routes/Club.php';

// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Create database connection
    $database = new Database();
    $connection = $database->getConnection();

   
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    $resource = $segments[0] ?? '';

  
    switch ($resource) {
        case 'players':
            $playerRoutes = new PlayerRoutes($connection);
            $playerRoutes->handleRequest();
            break;

        case 'clubs':
            $clubRoutes = new ClubRoutes($connection);
            $clubRoutes->handleRequest();
            break;
        // case 'nationalities':
        //     $clubRoutes = new ClubRoutes($connection);
        //     $clubRoutes->handleRequest();
        //     break;

        default:
         
            http_response_code(404);
            echo json_encode([
                'status' => 404,
                'message' => 'Resource not found'
            ]);
            break;
    }
} catch (Exception $e) {
 
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 500,
        'message' => 'Internal Server Error',
        'error' => $e->getMessage()
    ]);
}