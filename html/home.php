<?php
session_start();

include "db_conn.php";
$sql = "SELECT * FROM series.series";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Series Collection</title>
</head>
<body>
<h2>Series Collection</h2>


<table>
    <tr>
        <th>Title</th>
        <th>Seasons</th>
        <th>Genre</th>
        <th>Platform</th>
    </tr>
    <?php while ($serie = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $serie['title']; ?></td>
            <td><?php echo $serie['seasons']; ?></td>
            <td><?php echo $serie['genre']; ?></td>
            <td><?php echo $serie['platform']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="series_form.php">Add New Series</a>
</body>
</html>
