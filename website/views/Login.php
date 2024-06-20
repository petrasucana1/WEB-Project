<?php
include_once '../app/models/Admin.php';
$admin = new Admin();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $admin->getAdminByEmail($email);

    if ($result) {
        $hashed_password_from_db = $result['Password']; 

        if (password_verify($password, $hashed_password_from_db)) {
            session_start();
            $_SESSION['email'] = $email; 

            header("Location: Dashboard.php");
            exit;
        } else {
            $errors[] = "Parola introdusă nu este corectă.";
        }
    } else {
        $errors[] = "Email-ul introdus nu există.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles/styles_login.css">
    <style>
        .error-message {
            display: <?php echo (empty($errors)) ? 'none' : 'block'; ?>;
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px;
            border: 1px solid #f5c6cb;
            margin-top: 10px;
            max-width: 50%; 
            text-align: center; 
            position: fixed;
            left: 50%; 
            transform: translateX(-50%);
            z-index: 1000; 
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login Form</h2>
    <form action="#" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Your email.." required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Your password.." required>
        <div class="form-footer">
            <input type="submit" value="Login">
            <a href="Home.php">Back to homepage</a>
        </div>
    </form>
</div>
<div class="error-message" id="error-message">
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
</div>


<script>
    const errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'block';
    setTimeout(function() {
        errorMessage.style.display = 'none';
    }, 2000); 
</script>
</body>
</html>
