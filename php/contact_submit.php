


﻿<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    http_response_code(400);
    exit;
}
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$message = trim($data['message'] ?? '');
if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($message) < 5) {
    echo json_encode(['success' => false, 'error' => 'Validation failed']);
    http_response_code(422);
    exit;
}
try {
    $stmt = $conn->prepare('INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())');
    $stmt->bind_param('sss', $name, $email, $message);
    $stmt->execute();
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
}
?>

