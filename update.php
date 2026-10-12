<?php
session_start();
require_once 'db.php';
//if a user isn't logged in kick them out to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$message = '';
//check if the update form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $education = strip_tags($_POST['education']);
    $profile = strip_tags($_POST['profile']);
    $keyprogramming = strip_tags($_POST['keyprogramming']);
    $urllinks = strip_tags($_POST['urllinks']);
    $sql = "UPDATE cvs SET education = :education, profile = :profile, keyprogramming = :keyprogramming, URLlinks = :urllinks WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'education' => $education,
        'profile' => $profile,
        'keyprogramming' => $keyprogramming,
        'urllinks' => $urllinks,
        'id' => $user_id
    ]);
    $message = "Your CV has been successfully updated!";
}

$sql = "SELECT * FROM cvs WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute(['id' => $user_id]);
$cv = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update CV</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <a href="index.php">Home</a> | 
            <a href="logout.php">Logout</a>
        </nav>
        <h1>Update Your CV Details</h1>
        <?php if ($message): ?>
            <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="update.php">
            <p>
                <label for="keyprogramming">Programming Languages:</label><br>
                <input type="text" id="keyprogramming" name="keyprogramming" value="<?php echo htmlspecialchars($cv['keyprogramming'] ?? ''); ?>" style="width: 300px;">
            </p>
            <p>
                <label for="education">Education:</label><br>
                <input type="text" id="education" name="education" value="<?php echo htmlspecialchars($cv['education'] ?? ''); ?>" style="width: 300px;">
            </p>
            <p>
                <label for="urllinks">Portfolio/GitHub URL:</label><br>
                <input type="url" id="urllinks" name="urllinks" value="<?php echo htmlspecialchars($cv['URLlinks'] ?? ''); ?>" style="width: 300px;">
            </p>
            <p>
                <label for="profile">Personal Profile Summary:</label><br>
                <textarea id="profile" name="profile" rows="5" style="width: 300px;"><?php echo htmlspecialchars($cv['profile'] ?? ''); ?></textarea>
            </p>
            <button type="submit">Save Changes</button>
        </form>
    </body>
</html>