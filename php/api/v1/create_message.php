<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Content-Type');
$input = json_decode(file_get_contents('php://input'), true);

{
    $message = $input['message'];

    // Database connection
    require '../../db/database.class.php';
    $db = new Database();
    $insertQuery = "INSERT INTO messages (content) VALUES ('{$message}')";
    $userId = $db->insertData($insertQuery);
    if($userId) {
        http_response_code(201);
        echo json_encode(['message' => 'Message creation succesfull.']);
    }else {
        http_response_code(500);
        echo json_encode(['message' => 'Message creation failed.']);
    }
}
?>