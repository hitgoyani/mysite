


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
    $stmt = $conn->prepare('INSERT INTO contacts (name, email, message, submitted_at) VALUES (?, ?, ?, NOW())');
    $stmt->bind_param('sss', $name, $email, $message);
    $stmt->execute();

    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $txtFile = $dir . '/contact.txt';
    $csvFile = $dir . '/contact.csv';
    $line = date('Y-m-d H:i:s') . " | " . $name . " | " . $email . " | " . str_replace(["\r", ""], [' ', ' '], $message) . "";
    file_put_contents($txtFile, $line, FILE_APPEND | LOCK_EX);
    $csvLine = [date('Y-m-d H:i:s'), $name, $email, $message];
    $fp = fopen($csvFile, 'a');
    if ($fp) {
        fputcsv($fp, $csvLine);
        fclose($fp);
    }
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
}
?>

