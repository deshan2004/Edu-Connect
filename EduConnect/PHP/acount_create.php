<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" href="../Style/course_details.css" />
</head>
<body>

<div class="sidebar">
    <h2>Gallery Café</h2>
    <a href="../admin.html">Dashboard</a>
    <a href="/PHP/ADMIN.php">Manage Course Details</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>User Management</h1>
    </div>

    <div class="container">
        <div class="form-container">
            <div class="form-card">
                <h3>Add New User</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="user_level">User Level:</label>
                    <select id="user_level" name="user_level" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    <button type="submit" name="add_user" class="btn">Add User</button>
                </form>
            </div>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Level</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = new mysqli("localhost", "root", "", "educonnect_db");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['add_user'])) {
                    $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_level) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['password'], $_POST['user_level']);
                    $stmt->execute();
                    $stmt->close();
                } elseif (isset($_POST['update_user'])) {
                    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, user_level=? WHERE id=?");
                    $stmt->bind_param("sssi", $_POST['updated_name'], $_POST['updated_email'], $_POST['updated_user_level'], $_POST['id_to_update']);
                    $stmt->execute();
                    $stmt->close();
                } elseif (isset($_POST['delete_user'])) {
                    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
                    $stmt->bind_param("i", $_POST['id_to_delete']);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $result = $conn->query("SELECT id, name, email, user_level FROM users");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["name"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["user_level"]."</td>
                            <td class='action-forms'>
                                <div class='form-card'>
                                    <h3>Update User</h3>
                                    <form method='post'>
                                        <input type='hidden' name='id_to_update' value='".$row["id"]."'>
                                        <label>Name:</label>
                                        <input type='text' name='updated_name' value='".$row["name"]."' required>
                                        <label>Email:</label>
                                        <input type='email' name='updated_email' value='".$row["email"]."' required>
                                        <label>User Level:</label>
                                        <select name='updated_user_level'>
                                            <option value='user' ".($row["user_level"] == 'user' ? 'selected' : '').">User</option>
                                            <option value='admin' ".($row["user_level"] == 'admin' ? 'selected' : '').">Admin</option>
                                            <option value='staff' ".($row["user_level"] == 'staff' ? 'selected' : '').">Staff</option>
                                        </select>
                                        <button type='submit' name='update_user' class='btn'>Update</button>
                                    </form>
                                </div>
                                <div class='form-card'>
                                    <h3>Delete User</h3>
                                    <form method='post'>
                                        <input type='hidden' name='id_to_delete' value='".$row["id"]."'>
                                        <button type='submit' name='delete_user' class='btn btn-danger'>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</div>
</body>
</html>
