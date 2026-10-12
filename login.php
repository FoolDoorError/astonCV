<?php
session_start();
require_once 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //find the user by email
    $sql = "SELECT * FROM cvs WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //verify the user exists and the password matches the hash
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        //redirect them back to the home page
        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - AstonCV</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <a href="index.php">Home</a> | 
            <a href="register.php">Register</a>
        </nav>
        <h1>Login to AstonCV</h1>
        <?php if ($message): ?>
            <p style="color: red; font-weight: bold;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <p>
                <label for="email">Email Address:</label><br>
                <input type="email" id="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </p>
            <button type="submit">Login</button>
        </form>
    </body>
</html>