<?php
include_once 'protect.php';
include "db_conn.php";

$platforms = getPlatforms($conn);
$genres = getGenres($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $seasons = intval($_POST['seasons']);
    $genre = htmlspecialchars($_POST['genre']);
    $platform = htmlspecialchars($_POST['platform']);
    $user_id = $_SESSION['user_id'];

    $insert_result = insertSeries($conn, $title, $seasons, $genre, $platform, $user_id);
    if ($insert_result === true) {
        header("Location: home.php");
        exit();
    } else {
        echo $insert_result;
    }
} elseif (isset($_GET['delete'])){
    $series_id = htmlspecialchars($_GET['delete']);
    $user_id = $_SESSION['user_id'];

    $delete_result = deleteSeries($conn, $series_id, $user_id);
    if ($delete_result === true) {
        header("Location: home.php");
        exit();
    } else {
        echo $delete_result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="series_form.css">
    <title>Add New Series</title>
</head>
<body>
<h2>Add New Series</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br>
    <label for="seasons">Seasons:</label><br>
    <input type="number" id="seasons" name="seasons" min="1" value="1" required><br>
    <label for="genre">Genre:</label><br>
    <input type="text" id="genre" name="genre" list="genres" required><br>

    <datalist id="genres">
    <?php
        foreach($genres as $genre)
            echo "<option>" . $genre . "</option>";
    ?>
    </datalist>

    <label for="platform">Platform:</label><br>
    <input type="text" id="platform" name="platform" list="platforms" required><br><br>

    <datalist id="platforms">
    <?php
        foreach($platforms as $platform)
            echo "<option>" . $platform . "</option>";
    ?>
    </datalist>

    <input type="submit" value="Add Series">
</form>
<a href="home.php">Back to Home</a>
</body>
</html>
