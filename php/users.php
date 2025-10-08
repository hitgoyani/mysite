<?php
session_start();
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id']) && ($_SESSION['role'] ?? '') === 'admin') {
    $delId = intval($_GET['delete_id']);
    $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $delId);
    $stmt->execute();
    header('Location: users.php');
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
    <title>Users - FitZone</title>
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
            <h1>Users</h1>
            <div class="section-divider"></div>
            <p><a href="php/add_user.php" class="btn">Add User</a></p>
        </div>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Mobile</th><th>Role</th><th>Action</th></tr>
            <?php
            try {
                $res = $conn->query('SELECT id, name, email, age, mobile, role FROM users ORDER BY id DESC');
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . (int)$row['id'] . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['age']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['mobile']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                    if (($_SESSION['role'] ?? '') === 'admin') {
                        echo '<td><a href="users.php?delete_id=' . (int)$row['id'] . '" onclick="return confirm(\'Delete this user?\')">Delete</a></td>';
                    } else {
                        echo '<td>-</td>';
                    }
                    echo '</tr>';
                }
            } catch (Exception $e) {
                echo '<tr><td colspan="7">Unable to load users.</td></tr>';
            }
            ?>
        </table>
    </div>
    <footer>
        <p>&copy; 2025 FitZone Gym. All rights reserved.</p>
    </footer>
</body>
</html>

