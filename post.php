<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    if (!empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $content);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedIn Clone - Feed</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f2ef;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #0a66c2;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            background-color: #004182;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background-color: #083b75;
        }

        .container {
            width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            resize: none;
            margin-bottom: 15px;
            outline: none;
        }

        textarea:focus {
            border-color: #0a66c2;
        }

        button {
            background-color: #0a66c2;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        button:hover {
            background-color: #004182;
        }

        .feed {
            margin-top: 30px;
        }

        .post {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 15px;
            border-radius: 10px;
            background-color: #f9fafb;
        }

        .post b {
            color: #0a66c2;
            font-size: 17px;
        }

        .post small {
            color: #777;
        }

        .no-posts {
            text-align: center;
            color: gray;
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <div class="navbar">
        <div>Welcome, <?php echo $_SESSION['user_name']; ?></div>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <form method="POST">
            <textarea name="content" placeholder="What's on your mind?" required></textarea>
            <button type="submit">Post</button>
        </form>

        <div class="feed">
            <h3>Recent Posts</h3>
            <?php
            $query = "SELECT posts.content, posts.created_at, users.name 
                      FROM posts 
                      JOIN users ON posts.user_id = users.id 
                      ORDER BY posts.created_at DESC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post'><b>" . htmlspecialchars($row['name']) . "</b><br>"
                        . nl2br(htmlspecialchars($row['content'])) .
                        "<br><small>Posted on " . $row['created_at'] . "</small></div>";
                }
            } else {
                echo "<div class='no-posts'>No posts yet. Be the first to post!</div>";
            }
            ?>
        </div>
    </div>

</body>
</html>
