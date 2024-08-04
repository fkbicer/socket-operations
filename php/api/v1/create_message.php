<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST verilerini al
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Verilerin geçerli olup olmadığını kontrol et
    if (!empty($message)) {

        // Database connection
        require '../../db/database.class.php';
        $db = new Database();
        $insertQuery = 'INSERT INTO messages (content) VALUES (?)';
        $userId = $db->insertData($insertQuery,array($message));

        if($userId) {
            http_response_code(201);
            echo json_encode(['message' => 'User creation succesfull.']);
        }else {
            http_response_code(500);
            echo json_encode(['message' => 'User creation failed.']);
        }
    } else {
        // Hatalı veri durumunda yanıt döner
        echo 'Invalid data';
    }
} else {
    // Geçerli olmayan istek türü durumunda yanıt döner
    echo 'Invalid request method';
}
?>