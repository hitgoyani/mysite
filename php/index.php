


﻿<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/fix_ui.css">
    <title>FitZone Gym - Database System</title>
    <style>
        body{font-family:Arial;margin:20px;background:#f0f0f0;}
        .container{max-width:800px;margin:0 auto;background:white;padding:20px;border-radius:10px;}
        h1{color:#009e7f;text-align:center;}
        table{width:100%;border-collapse:collapse;margin:20px 0;}
        th,td{border:1px solid #ddd;padding:12px;text-align:left;}
        th{background:#009e7f;color:white;}
        .section{margin:30px 0;}
        .stats{display:flex;justify-content:space-around;margin:20px 0;}
        .stat-box{background:#009e7f;color:white;padding:20px;border-radius:5px;text-align:center;}
    </style>
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

    <div class="container">
        <h1>FitZone Gym Database System</h1>
        <div class="stats">
            <?php
            try {
                $users_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'] ?? 0;
            } catch (Exception $e) {
                $users_count = 0;
            }
            try {
                $trainers_count = $conn->query("SELECT COUNT(*) as count FROM trainers")->fetch_assoc()['count'] ?? 0;
            } catch (Exception $e) {
                $trainers_count = 0;
            }
            ?>
            <div class="stat-box">
                <h3><?php echo htmlspecialchars($users_count); ?></h3>
                <p>Total Members</p>
            </div>
            <div class="stat-box">
                <h3><?php echo htmlspecialchars($trainers_count); ?></h3>
                <p>Active Trainers</p>
            </div>
        </div>
        <div class="section">
            <h2>Gym Members</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Mobile</th>
                </tr>
                <?php
                try {
                    $result = $conn->query("SELECT * FROM users");
                    while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                    echo "</tr>";
                    }
                } catch (Exception $e) {
                    echo '<tr><td colspan="5">Unable to load users table.</td></tr>';
                }
                ?>
            </table>
        </div>
        <div class="section">
            <h2>Our Trainers</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Experience</th>
                    <th>Email</th>
                </tr>
                <?php
                try {
                    $result = $conn->query("SELECT * FROM trainers");
                    while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['experience_years']) . " years</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                    }
                } catch (Exception $e) {
                    echo '<tr><td colspan="5">Unable to load trainers table.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>

