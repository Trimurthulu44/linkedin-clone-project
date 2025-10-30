<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! You can now login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LinkedIn Clone - Signup</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg, #0a66c2, #004182);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    background: white;
    padding: 40px;
    border-radius: 12px;
    width: 380px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    text-align: center;
}
.container img {
    width: 60px;
    margin-bottom: 20px;
}
input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
}
button {
    background-color: #0a66c2;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
button:hover {
    background-color: #004182;
}
a {
    color: #0a66c2;
    text-decoration: none;
    font-weight: 600;
}
</style>
</head>
<body>
    <div class="container">
        <img src="images/linkedin.png" alt="LinkedIn Logo">
        <h2>Create your account</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
