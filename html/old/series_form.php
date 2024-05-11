<?php
session_start();

include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $seasons = intval($_POST['seasons']);
    $genre = htmlspecialchars($_POST['genre']);
    $platform = htmlspecialchars($_POST['platform']);

    $sql = "INSERT INTO series (title, seasons, genre, platform, user_id) 
            VALUES ('$title', $seasons, '$genre', '$platform', {$_SESSION['user_id']})";

    if (mysqli_query($conn, $sql)) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="series_form.css">
    <title>Add New Series</title>
</head>
<body>
<h2>Add New Series</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title"><br>
    <label for="seasons">Seasons:</label><br>
    <input type="number" id="seasons" name="seasons"><br>
    <label for="genre">Genre:</label><br>
    <input type="text" id="genre" name="genre"><br>
    <label for="platform">Platform:</label><br>
    <input type="text" id="platform" name="platform"><br><br>
    <input type="submit" value="Add Series">
</form>
<a href="home.php">Back to Home</a>
</body>
</html>
