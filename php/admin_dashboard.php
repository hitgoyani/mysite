<?php
session_start();
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.html');
    exit;
}
try {
    $users_count = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'] ?? 0;
    $events_count = $conn->query("SELECT COUNT(*) as cnt FROM events")->fetch_assoc()['cnt'] ?? 0;
    $contacts_count = $conn->query("SELECT COUNT(*) as cnt FROM contacts")->fetch_assoc()['cnt'] ?? 0;
} catch (Exception $e) {
    $users_count = $events_count = $contacts_count = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard - FitZone</title>
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
        <div class="auth-buttons">
            <a href="php/logout.php" class="btn">Logout</a>
        </div>
    </div>
    


    <div class="container">
        <div class="trainer-header">
            <h1>Admin Dashboard</h1>
            <div class="section-divider"></div>
            <p>Overview of site data</p>
        </div>
        <div class="highlights-list">
            <div class="highlight-card">
                <h3>Total Users</h3>
                <p><?php echo (int)$users_count; ?></p>
                <a href="php/users.php" class="btn">Manage Users</a>
            </div>
            <div class="highlight-card">
                <h3>Total Events</h3>
                <p><?php echo (int)$events_count; ?></p>
                <a href="php/events.php" class="btn">Manage Events</a>
            </div>
            <div class="highlight-card">
                <h3>Contact Messages</h3>
                <p><?php echo (int)$contacts_count; ?></p>
                <a href="php/index.php" class="btn">View DB</a>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 FitZone Gym. All rights reserved.</p>
    </footer>
</body>
</html>

