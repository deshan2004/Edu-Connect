<?php
$conn = new mysqli("localhost", "root", "", "educonnect_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

function updateStatus($conn, $id, $status) {
    $stmt = $conn->prepare("UPDATE contacts SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'], $_POST['contact_id'])) {
        $action = $_POST['action'];
        $id = $_POST['contact_id'];
        if ($action === 'confirm') updateStatus($conn, $id, 'confirmed');
        if ($action === 'cancel') updateStatus($conn, $id, 'cancelled');
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Contacts - EduConnect</title>
  <link rel="stylesheet" href="../Style/About.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f0f0;
      margin: 0; padding: 0;
    }
    .container {
      max-width: 1100px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
    }
    .sub-header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    h1 { font-size: 2.5rem; margin: 0; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    .btn-confirm {
      background-color: #4CAF50;
      color: white;
    }
    .btn-cancel {
      background-color: #ff4d4d;
      color: white;
    }
    .btn {
      padding: 8px 14px;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }
    .footer {
      text-align: center;
      margin-top: 40px;
      background: #333;
      color: white;
      padding: 20px;
    }
  </style>
</head>
<body>

<section class="sub-header">
  <nav>
    <div class="nav-links" id="navLinks">
      <ul>
        <li><a href="../staff.html">HOME</a></li>
      </ul>
    </div>
  </nav>
  <h1>Contact Submissions</h1>
</section>

<div class="container">
  <table>
    <thead>
      <tr>
        <th>Name</th><th>Email</th><th>Address</th><th>Message</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td>
          <?php if ($row['status'] === 'pending'): ?>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="contact_id" value="<?= $row['id'] ?>" />
            <button type="submit" name="action" value="confirm" class="btn btn-confirm">Confirm</button>
            <button type="submit" name="action" value="cancel" class="btn btn-cancel">Cancel</button>
          </form>
          <?php else: ?>
            <strong><?= ucfirst($row['status']) ?></strong>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<section class="footer">
  <h4>Contact Management</h4>
  <p>Gallery Café - EduConnect</p>
</section>

</body>
</html>

<?php $conn->close(); ?>
