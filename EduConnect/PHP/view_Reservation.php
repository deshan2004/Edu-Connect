<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "educonnect_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cancel"])) {
        $id = $_POST["cancel"];
        $conn->query("DELETE FROM enrollments WHERE id=$id");
    }
    if (isset($_POST["confirm"])) {
        $id = $_POST["confirm"];
        $name = $_POST["name_$id"] . " (Confirmed)";
        $conn->query("UPDATE enrollments SET name='$name' WHERE id=$id");
    }
}

$result = $conn->query("SELECT * FROM enrollments ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Enrollments | EduConnect</title>
  <link rel="stylesheet" href="../Style/About.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .sub-header {
      background-color: #343a40;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    .sub-header h1 {
      margin: 0;
      font-size: 2.5rem;
    }

    .container {
      padding: 30px;
      max-width: 1200px;
      margin: auto;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-top: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #dee2e6;
    }

    table th {
      background-color: #f2f2f2;
      color: #495057;
      text-transform: uppercase;
    }

    .btn {
      padding: 8px 12px;
      margin: 3px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .btn-confirm {
      background-color: #28a745;
      color: white;
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<section class="sub-header">
        <nav>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../staff.html">HOME</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <h1>Manage Enrollment</h1>
    </section>

  

  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Course</th>
          <th>Enroll Date</th>
          <th>Qualifications</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= $row["phone"] ?></td>
            <td><?= $row["course"] ?></td>
            <td><?= $row["enroll_date"] ?></td>
            <td><?= nl2br(htmlspecialchars($row["qualifications"])) ?></td>
            <td><?= $row["created_at"] ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="name_<?= $row["id"] ?>" value="<?= htmlspecialchars($row["name"]) ?>">
                <button class="btn btn-confirm" type="submit" name="confirm" value="<?= $row["id"] ?>">Confirm</button>
                <button class="btn btn-cancel" type="submit" name="cancel" value="<?= $row["id"] ?>">Cancel</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>

  <section class="footer" style="text-align:center; padding: 20px; background: #343a40; color: #fff;">
    <h4>ABOUT US</h4>
    <p>EDUCONNECT - Learn. Connect. Grow.</p>
  </section>
</body>
</html>
