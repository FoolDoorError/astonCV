<?php
require_once 'db.php';
$message = '';
//check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //this scrambles the password so it isn't stored as plain text
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    try {
        //prepare the SQL to insert the new user
        //use placeholders to prevent SQL injection
        $sql = "INSERT INTO cvs (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $db->prepare($sql);
        //execute the query with the user's data and the hashed password
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
        ]);
        $message = "Registered successfuly";
    } catch(PDOException $e) { 
        $message = "That email is already registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register - AstonCV</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href="index.php"> Back to Home</a>
        <h1>Register for AstonCV</h1>
        <?php if ($message): ?>
            <p style="color: blue; font-weight: bold;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <p>
                <label for="name">Full Name:</label><br>
                <input type="text" id="name" name="name" required>
            </p>
            <p>
                <label for="email">Email Address:</label><br>
                <input type="email" id="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </p>
            <button type="submit">Register</button>
        </form>
    </body>
</html>