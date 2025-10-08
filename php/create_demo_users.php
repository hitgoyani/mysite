


<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../login.html');
    exit;
}
?>
// Script to create demo users with hashed passwords
require_once __DIR__ . '/db.php';
$users = [
  ['adminfit','admin@fitzone.com','admin123','admin'],
  ['john_doe','john@example.com','john123','user'],
  ['emma_fitness','emma@example.com','emma123','user'],
  ['ramesh_member','ramesh@example.com','ramesh123','user'],
];
foreach($users as $u){
  $username = $u[0]; $email = $u[1]; $password = $u[2]; $role = $u[3];
  $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=? LIMIT 1");
  mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
  mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
  if (mysqli_stmt_num_rows($stmt)>0){ mysqli_stmt_close($stmt); echo "User {$username} exists"; continue; }
  mysqli_stmt_close($stmt);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $ins = mysqli_prepare($conn, "INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)");
  mysqli_stmt_bind_param($ins, 'ssss', $username, $email, $hash, $role);
  mysqli_stmt_execute($ins);
  mysqli_stmt_close($ins);
  echo "Inserted {$username}";
}
echo "Done";
?>
