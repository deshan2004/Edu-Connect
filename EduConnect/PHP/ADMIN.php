<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <link rel="stylesheet" href="../Style/course_details.css" />
</head>

<body>
<div class="sidebar">
    <h2>Gallery Café</h2>
    <a href="../admin.html">Dashboard</a>
    <a href="./acount_create.php">Manage Users</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Course Management</h1>
    </div>

    <div class="container">
        <div class="form-container">
            <div class="form-card">
                <h3>Add New Course</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="name">Course Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="price">Course Fee:</label>
                    <input type="text" id="price" name="price" required>
                    <label for="faculty">Faculty:</label>
                    <select id="faculty" name="faculty" required>
                        <option value="" disabled selected>Select Faculty</option>
                        <option value="Faculty of Computing">Faculty of Computing</option>
                        <option value="Faculty of Management">Faculty of Management</option>
                        <option value="Faculty of Engineering">Faculty of Engineering</option>
                        <option value="Faculty of Marine Engineering">Faculty of Marine Engineering</option>
                        <option value="Faculty of Health Sciences">Faculty of Health Sciences</option>
                        <option value="Faculty of Law">Faculty of Law</option>
                    </select>
                    <button type="submit" name="add" class="btn">Add Course</button>
                </form>
            </div>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Fee</th>
                <th>Faculty</th>
                <th>Actions</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "educonnect_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['add'])) {
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $faculty = $_POST['faculty'];
                    $stmt = $conn->prepare("INSERT INTO courses (name, price, faculty) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $name, $price, $faculty);
                    $stmt->execute();
                    $stmt->close();
                } elseif (isset($_POST['update'])) {
                    $id = $_POST['id_to_update'];
                    $updated_name = $_POST['updated_name'];
                    $updated_price = $_POST['updated_price'];
                    $updated_faculty = $_POST['updated_faculty'];
                    $stmt = $conn->prepare("UPDATE courses SET name=?, price=?, faculty=? WHERE id=?");
                    $stmt->bind_param("sssi", $updated_name, $updated_price, $updated_faculty, $id);
                    $stmt->execute();
                    $stmt->close();
                } elseif (isset($_POST['delete'])) {
                    $id = $_POST['id_to_delete'];
                    $stmt = $conn->prepare("DELETE FROM courses WHERE id=?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $search_query = isset($_GET['search']) ? $_GET['search'] : '';

            $sql = "SELECT id, name, price, faculty FROM courses WHERE name LIKE '%$search_query%' OR faculty LIKE '%$search_query%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["name"]."</td>
                            <td>$".$row["price"]."</td>
                            <td>".$row["faculty"]."</td>
                            <td class='action-forms'>
                                <!-- Update form -->
                                <div class='form-card'>
                                    <h3>Update Course</h3>
                                    <form action='' method='post'>
                                        <input type='hidden' name='id_to_update' value='".$row["id"]."'>
                                        <label for='updated_name'>Course Name:</label>
                                        <input type='text' id='updated_name' name='updated_name' required value='".$row["name"]."'>
                                        <label for='updated_price'>Course Fee:</label>
                                        <input type='text' id='updated_price' name='updated_price' required value='".$row["price"]."'>
                                        <label for='updated_faculty'>Faculty:</label>
                                        <select id='updated_faculty' name='updated_faculty' required>
                                            <option value='Faculty of Computing'".($row["faculty"] == 'Faculty of Computing' ? ' selected' : '').">Faculty of Computing</option>
                                            <option value='Faculty of Management'".($row["faculty"] == 'Faculty of Management' ? ' selected' : '').">Faculty of Management</option>
                                            <option value='Faculty of Engineering'".($row["faculty"] == 'Faculty of Engineering' ? ' selected' : '').">Faculty of Engineering</option>
                                            <option value='Faculty of Marine Engineering'".($row["faculty"] == 'Faculty of Marine Engineering' ? ' selected' : '').">Faculty of Marine Engineering</option>
                                            <option value='Faculty of Health Sciences'".($row["faculty"] == 'Faculty of Health Sciences' ? ' selected' : '').">Faculty of Health Sciences</option>
                                            <option value='Faculty of Law'".($row["faculty"] == 'Faculty of Law' ? ' selected' : '').">Faculty of Law</option>
                                        </select>
                                        <button type='submit' name='update' class='btn'>Update</button>
                                    </form>
                                </div>

                                <!-- Delete form -->
                                <div class='form-card'>
                                    <h3>Delete Course</h3>
                                    <form action='' method='post'>
                                        <input type='hidden' name='id_to_delete' value='".$row["id"]."'>
                                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No courses found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</div>
</body>
</html>
