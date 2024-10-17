<?php



//allow from any origin
header("Access-Control-Allow-Origin: *");

//allow the following HTTP methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

//allow the following headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//if it's a preflight request, exit early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../config/Database.php';
include_once '../Models/User.php';

class AuthController {

    public function register() {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        if (!$user->register()) {
            //username already exists
            echo json_encode(["status" => "error", "message" => "Username already exists"]);
        } else {
            echo json_encode(["status" => "success", "message" => "You have registered successfully!"]);
        }
    }

    public function login() {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        //set the response header to JSON
        header('Content-Type: application/json');

        if ($loggedInUser = $user->login()) {
            //return success message as JSON
            echo json_encode([
                "status" => "success",
                "message" => "You have logged in successfully!",
                "user" => $loggedInUser
            ]);
        } else {
            //return error message as JSON
            echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
        }
    }
}

$authController = new AuthController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'register') {
        $authController->register();
    } else if ($_POST['action'] == 'login') {
        $authController->login();
    }
}


?>
