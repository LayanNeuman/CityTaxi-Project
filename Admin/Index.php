<?php
include '../config/config.php'; 
include '../config/syslogin.php';  // Include database configuration

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate user input
    if (empty($username) || empty($password)) {
        // Optionally, you can log this or show a more specific error
        echo "Username and Password cannot be empty.";
        exit;
    }

    // Initialize the login class (assuming you have a login class in your config.php)
    $userlogin = new Login($pdo);

    // Authenticate the user (check credentials)
    $result = $userlogin->authenticate($username, $password);

    if ($result) {
        // Redirect to dashboard or home page if login is successful
        header("Location: dashboard.php");
        exit();
    } else {
        // Show error message if login fails
      //  echo "Invalid Username or Password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4" style="width: 400px;">
      <h3 class="card-title text-center">Login</h3>
      <form method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="text-center mt-3">
          <a href="#">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
