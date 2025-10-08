


﻿<?php
session_start();
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $mobile = trim($_POST['mobile'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = ($_POST['role'] ?? 'user');
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (name, email, age, mobile, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->bind_param('ssisss', $name, $email, $age, $mobile, $hash, $role);
        $stmt->execute();
        header('Location: users.php');
        exit;
    } else {
        $error = 'Invalid input';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add User - FitZone</title>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-left">
    <a href="/index.html" class="logo">FitZone</a>
  </div>
  <div class="nav-center">
    <a href="/index.html">Home</a>
    <a href="/aboutus.html">About</a>
    <a href="/contact.html">Contact</a>
    <a href="/faq.html">FAQ</a>
    <a href="/gallery.html">Gallery</a>
    <a href="/trainers.html">Trainers</a>
    <a href="/membership.html">Membership</a>
  </div>
  <div class="nav-right">
    <?php if(isset($_SESSION['user'])): ?>
      <a href="/dashboard.php">Dashboard</a>
      <?php if($_SESSION['role'] === 'admin'): ?>
        <a href="/admin_dashboard.php">Admin</a>
      <?php endif; ?>
      <a href="/php/logout.php" class="btn-logout">Logout</a>
    <?php else: ?>
      <a href="/login.html" class="btn-login">Login</a>
      <a href="/newmember.html" class="btn-register">Register</a>
    <?php endif; ?>
  </div>
</nav>

    <div class="top-bar">
        <h1><span class="fitzone-logo">FitZone</span></h1>
    </div>
    <div class="container">
        <div class="trainer-header">
            <h1>Add User</h1>
            <div class="section-divider"></div>
        </div>
        <?php if (!empty($error)) echo '<div class="error">' . htmlspecialchars($error) . '</div>'; ?>
        <form method="post">
            <label>Name</label>
            <input name="name" required>
            <label>Email</label>
            <input name="email" type="email" required>
            <label>Age</label>
            <input name="age" type="number">
            <label>Mobile</label>
            <input name="mobile">
            <label>Password</label>
            <input name="password" type="password" required>
            <?php if (($_SESSION['role'] ?? '') === 'admin') { ?>
            <label>Role</label>
            <select name="role"><option value="user">User</option><option value="admin">Admin</option></select>
            <?php } ?>
            <button type="submit" class="btn">Add</button>
        </form>
    </div>
</body>
</html>

