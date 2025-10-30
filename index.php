<?php
session_start();
include 'db.php';

// If the user is not logged in, send them to login page
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feed | LinkedIn Clone</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f3f2ef;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: #0a66c2;
      color: white;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar h2 {
      margin: 0;
    }

    .post-box {
      background: white;
      width: 500px;
      margin: 30px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    textarea {
      width: 100%;
      height: 100px;
      border-radius: 6px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 15px;
      resize: none;
    }

    button {
      margin-top: 10px;
      width: 100%;
      background-color: #0a66c2;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #004182;
    }

    .feed {
      width: 500px;
      margin: 20px auto;
    }

    .post {
      background: white;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .logout {
      color: white;
      text-decoration: none;
      background: #ff4b5c;
      padding: 8px 15px;
      border-radius: 5px;
    }

    .logout:hover {
      background: #e63946;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <h2>Welcome, <?php echo $_SESSION['name']; ?> 👋</h2>
    <a href="logout.php" class="logout">Logout</a>
  </div>

  <div class="post-box">
    <form method="POST" action="post.php">
      <textarea name="content" placeholder="Start a post..." required></textarea>
      <button type="submit">Post</button>
    </form>
  </div>

  <div class="feed">
    <?php
      $query = "SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
      $result = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='post'><b>" . htmlspecialchars($row['name']) . "</b><br><p>" . htmlspecialchars($row['content']) . "</p><small>Posted on " . $row['created_at'] . "</small></div>";
      }
    ?>
  </div>
</body>
</html>

