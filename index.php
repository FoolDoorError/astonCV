<?php
session_start();
require_once 'db.php';
$searchTerm = $_GET['search'] ?? ''; 
if ($searchTerm) {
    //if they searched, look for matching names OR programming languages
    $sql = "SELECT id, name, email, keyprogramming FROM cvs WHERE name LIKE :search OR keyprogramming LIKE :search";
    $stmt = $db->prepare($sql);
    $stmt->execute(['search' => '%' . $searchTerm . '%']); 
} else {
    //if no search, just load everyone
    $sql = "SELECT id, name, email, keyprogramming FROM cvs";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}
$cvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AstonCV</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
        <a href="index.php">Home</a> | 
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="update.php">Update My CV</a> |
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        <?php endif; ?>
        </nav>
        <h1>Welcome to AstonCV</h1>
        <h2>All CVs</h2>
        <form method="GET" action="index.php" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by name or programming language..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
            <a href="index.php">Clear</a>
        </form>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Key Skills</th>
                <th>Action</th> </tr>
            <?php foreach ($cvs as $cv): ?>
            <tr>
                <td><?php echo htmlspecialchars($cv['name']); ?></td>
                <td><?php echo htmlspecialchars($cv['email']); ?></td>
                <td><?php echo htmlspecialchars($cv['keyprogramming']); ?></td>
                <td><a href="details.php?id=<?php echo $cv['id']; ?>">View Profile</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>