<?php
require_once 'db.php';
//check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //fetch the specific CV from the database
    $sql = "SELECT * FROM cvs WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $cv = $stmt->fetch(PDO::FETCH_ASSOC);
    //if no CV is found, redirect back to home
    if (!$cv) {
        header("Location: index.php");
        exit;
    }
} else {
    //if no ID in URL, redirect back to home
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($cv['name']); ?> - AstonCV</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <nav>
        <a href="index.php"> Back to all CVs</a>
    </nav>
    <div class="profile-card">
        <h1><?php echo htmlspecialchars($cv['name']); ?>'s Profile</h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($cv['email']); ?></p>
        <p><strong>Key Skills:</strong> <?php echo htmlspecialchars($cv['keyprogramming']); ?></p>
        <p><strong>Education:</strong> <?php echo htmlspecialchars($cv['education']); ?></p>
        <p><strong>About Me:</strong> <?php echo htmlspecialchars($cv['profile']); ?></p>
        <p><strong>Links:</strong> <a href="<?php echo htmlspecialchars($cv['URLlinks']); ?>" target="_blank">Portfolio/GitHub</a></p>
    </div>
    </body>
</html>
