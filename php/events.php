<?php
session_start();
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id']) && ($_SESSION['role'] ?? '') === 'admin') {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare('DELETE FROM events WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: events.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Events - FitZone</title>
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
            <h1>Events</h1>
            <div class="section-divider"></div>
            <p><a href="php/add_event.php" class="btn">Add Event</a></p>
        </div>
        <table>
            <tr><th>ID</th><th>Title</th><th>Date</th><th>Location</th><th>Action</th></tr>
            <?php
            try {
                $res = $conn->query('SELECT id, title, date, location FROM events ORDER BY date DESC');
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . (int)$row['id'] . '</td>';
                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['location']) . '</td>';
                    echo '<td><a href="update_event.php?id=' . (int)$row['id'] . '">Edit</a> ';
                    if (($_SESSION['role'] ?? '') === 'admin') echo ' <a href="events.php?delete_id=' . (int)$row['id'] . '" onclick="return confirm(\'Delete this event?\')">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } catch (Exception $e) {
                echo '<tr><td colspan="5">Unable to load events.</td></tr>';
            }
            ?>
        </table>
    </div>
    <footer>
        <p>&copy; 2025 FitZone Gym. All rights reserved.</p>
    </footer>
</body>
</html>

