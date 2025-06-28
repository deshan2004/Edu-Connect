<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EDUCONNECT</title>
  <link rel="stylesheet" href="../Style/items.css" />
  <style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e0e0e0;
    color: #333;
  }

  .sub-header {
    background: linear-gradient(rgba(30, 30, 30, 0.7), rgba(50, 50, 50, 0.7)), 
                url('../image/enroll.jpg') no-repeat center center/cover;
    color: white;
    padding: 60px 20px;
    text-align: center;
    filter: grayscale(100%);
  }

  nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
  }

  .nav-links ul {
    list-style: none;
    display: flex;
    gap: 20px;
  }

  .nav-links ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
  }

  .nav-links ul li a:hover {
    color: #ccc;
  }

  .menu {
    padding: 50px 20px;
    max-width: 1200px;
    margin: auto;
  }

  .menu-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
  }

  .menu-item {
    background: #f1f1f1;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .menu-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }

  .menu-faculty {
    font-size: 0.85rem;
    background-color: #888;
    color: white;
    padding: 4px 10px;
    border-radius: 50px;
    display: inline-block;
    margin-bottom: 10px;
    font-weight: 600;
  }

  .menu-name {
    font-size: 1.2rem;
    font-weight: bold;
    color: #222;
    margin-bottom: 5px;
  }

  .menu-price {
    color: #444;
    font-size: 1rem;
    font-weight: 600;
  }

  .footer {
    background: #444;
    color: white;
    text-align: center;
    padding: 30px 20px;
  }

  .footer .icons i {
    margin: 10px;
    font-size: 20px;
    color: #fff;
    transition: color 0.3s;
  }

  .footer .icons i:hover {
    color: #bbb;
  }
</style>

</head>
<body>

  <section class="sub-header">
    <nav>
      <a href="../index.html" style="color: #fff; text-decoration: none; font-size: 1.5rem; font-weight: bold; text-decoration: underline;">Gallery Café</a>
      <div class="nav-links" id="navLinks">
        <ul>
          <li><a href="../index.html">HOME</a></li>
          <li><a href="../aboutUs.html">ABOUT</a></li>
          <li><a href="../items.html">MENU</a></li>
          <li><a href="../contactUs.html">CONTACT</a></li>
        </ul>
      </div>
    </nav>
    <h1>Available Courses & Degree Programs</h1>
  </section>

  <section class="menu" id="menu">
    <div class="menu-items">
      <?php
      $conn = new mysqli("localhost", "root", "", "educonnect_db");

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT id, name, price, faculty FROM courses";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<div class='menu-item'>
                  <p class='menu-faculty'>" . strtoupper($row["faculty"]) . "</p>
                  <p class='menu-name'>{$row["name"]}</p>
                  <p class='menu-price'>\${$row["price"]}</p>
                </div>";
        }
      } else {
        echo "<p>No courses found</p>";
      }
      $conn->close();
      ?>
    </div>
  </section>

  <section class="footer">
    <h4>ABOUT US</h4>
  </section>

</body>
</html>
