


﻿<?php
session_start();
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: events.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    if ($title && $date) {
        $stmt = $conn->prepare('UPDATE events SET title=?, description=?, date=?, location=? WHERE id=?');
        $stmt->bind_param('ssssi', $title, $description, $date, $location, $id);
        $stmt->execute();
        header('Location: events.php');
        exit;
    } else {
        $error = 'Title and date required';
    }
}
$row = $conn->query('SELECT * FROM events WHERE id=' . $id)->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Update Event - FitZone</title>
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

    <div class="top-bar"><h1><span class="fitzone-logo">FitZone</span></h1></div>
    <div class="container">
        <div class="trainer-header"><h1>Update Event</h1><div class="section-divider"></div></div>
        <?php if (!empty($error)) echo '<div class="error">' . htmlspecialchars($error) . '</div>'; ?>
        <form method="post">
            <label>Title</label>
            <input name="title" value="<?php echo htmlspecialchars($row['title'] ?? ''); ?>" required>
            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($row['description'] ?? ''); ?></textarea>
            <label>Date</label>
            <input name="date" type="date" value="<?php echo htmlspecialchars($row['date'] ?? ''); ?>" required>
            <label>Location</label>
            <input name="location" value="<?php echo htmlspecialchars($row['location'] ?? ''); ?>">
            <button type="submit" class="btn">Update Event</button>
        </form>
    </div>
</body>
</html>

