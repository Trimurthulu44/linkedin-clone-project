<?php
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login | LinkedIn Clone</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" name="login">Login</button>
      <p>New user? <a href="signup.php">Signup</a></p>
    </form>
  </div>
</body>
</html>

<?php
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    header("Location: feed.php");
  } else {
    echo "<script>alert('Invalid email or password');</script>";
  }
}
?>
