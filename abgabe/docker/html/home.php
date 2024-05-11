<?php
include_once 'protect.php';
include "db_conn.php";


$title = $_GET['title'] ?? '';
$genre = $_GET['genre'] ?? '';
$platform = $_GET['platform'] ?? '';
$result = searchSeries($conn, $title, $genre, $platform);
$platforms = getPlatforms($conn);
$genres = getGenres($conn);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="home.css">
    <title>Series Collection</title>
</head>
<body>

<h2>Series Collection</h2>


<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Seasons</th>
            <th>Genre</th>
            <th>Platform</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <!-- Suchfelder -->
        <tr class="tr-search">
            <form action="" method="GET">
                <td colspan="2">
                    <input type="text" name="title" placeholder="Search by title..." value="<?php echo isset($_GET['title']) ? $_GET['title'] : ''; ?>" style="width: 100%;">
                </td>
                <td>
                    <!-- Genre -->
                    <select name="genre" style="width: 100%;">
                        <option value="">Select a genre...</option>

                        <?php 
                        foreach ($genres as $genre) {
                            $selected = (isset($_GET['genre']) && $_GET['genre'] === $genre) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($genre) . '" ' . $selected . '>' . htmlspecialchars($genre) . '</option>';
                        }
                        ?>

                    </select>    
                </td>
                <td>
                    <!-- Platform -->
                    <select name="platform" style="width: 100%;">
                        <option value="">Select a platform...</option>
                        <?php 
                        foreach ($platforms as $platform) {
                            $selected = (isset($_GET['platform']) && $_GET['platform'] === $platform) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($platform) . '" ' . $selected . '>' . htmlspecialchars($platform) . '</option>';
                        }
                        ?>
                    </select>
                    
                </td>
                <td>
                    <input type="submit" value="Search">
                </td>
            </form>
        </tr>
    </tbody>

    <tbody>
    
    <?php 
    if (mysqli_num_rows($result) > 0): 
        while ($serie = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $serie['title']; ?></td>
            <td><?php echo $serie['seasons']; ?></td>
            <td><?php echo $serie['genre']; ?></td>
            <td><?php echo $serie['platform']; ?></td>
            <td><a class="deleteBtn" href="series_form.php?delete=<?php echo $serie['series_id']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; else:?>
        <tr>
            <td colspan="5" style="text-align: center;">No entries found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<a class="addBtn" href="series_form.php">Add New Series</a>
<a class="logoutBtn" href="logout.php">Logout</a>
</body>
</html>
