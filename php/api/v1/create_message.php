<?php 
require '../../functions/routing.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['token'])
    ) {
    $token = $input['token'];

    // Database connection
    require '../../db/database.class.php';
    $db = new Database();
    $updateQuery= "UPDATE tokens SET expired_at = NOW() WHERE token = ?";
    $updatedRowCount = $db->updateData($updateQuery,array($token));
    if($updatedRowCount) {
        http_response_code(201);
        echo json_encode([
            'message' => "Token terminated successfully.",
            'token' => $token
        ]);
    }else {
        http_response_code(500);
        echo json_encode([
            'message' => "Token cannot terminate."
        ]);
    }
} else {
    echo "Bu sayfayı görüntülemeye yetkiniz bulunmamaktadır.";
    go("login.html");
}
?>