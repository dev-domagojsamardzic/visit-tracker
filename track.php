<?php
// Allow resources hosted on other origins to access track.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require './src/Database.php';

// Validate method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Method not allowed
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Check if request body is present
$inputData = file_get_contents('php://input');

if (!$inputData) {
    // Bad request
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request body.']);
    exit;
}

// Validate all parameters are present
$data = json_decode($inputData, true);

if (!isset($data['visitor_id']) || !isset($data['page'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
    exit;
}

// Sanitize inputs
$visitorId = filter_var($data['visitor_id'], FILTER_UNSAFE_RAW);
$page = filter_var($data['page'], FILTER_SANITIZE_URL);

if (!$visitorId || strlen($visitorId) !== 10 || !$page) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameter present.']);
    exit;
}

$date = date('Y-m-d', strtotime('+1 day'));

try {

    $db = new Database();
    $sql = "INSERT IGNORE INTO visits (visitor_id, page, date) VALUES (?, ?, ?)";
    $db->execute($sql, [NULL, $page, $date]);

    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Success.']);

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
