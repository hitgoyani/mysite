


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
$age = intval($data['age'] ?? 0);
$mobile = trim($data['mobile'] ?? '');
$password = $data['password'] ?? '';
if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || $age < 12 || $age > 120 || !preg_match('/^[0-9]{10}$/', $mobile) || strlen($password) < 6) {
    echo json_encode(['success' => false, 'error' => 'Validation failed']);
    http_response_code(422);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
try {
    $role = 'user';
    $stmt = $conn->prepare('INSERT INTO users (name, email, age, mobile, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
    $stmt->bind_param('ssisss', $name, $email, $age, $mobile, $password_hash, $role);
    $stmt->execute();
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
}
?>

