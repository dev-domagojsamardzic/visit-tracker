<?php

// Allow resources hosted on other origins to access track.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';

use App\DB\Database;
use App\Validators\InputValidator;

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

// Validate inputs
$visitorId = $data['visitor_id'] ?? '';
$page = $data['page'] ?? '';

if (!InputValidator::validateVisitorId($visitorId) || !InputValidator::validateUrl($page)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameter present.']);
    exit;
}

$date = date('Y-m-d');

try {

    $db = new Database();
    $sql = "INSERT IGNORE INTO visits (visitor_id, page, date) VALUES (?, ?, ?)";
    $db->execute($sql, [$visitorId, $page, $date]);

    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Success.']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
