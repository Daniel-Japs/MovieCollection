<?php
/* XAMPP
$host="localhost";
$user="root";
$pass="";
$db="series";

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/

$sname = "mysql";
$port= 3306;
$uname = "test";
$password = "test";
$db_name = "series";

$conn = new mysqli($sname, $uname, $password, $db_name, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function searchSeries($conn, $title= null, $genre= null, $platform= null) {
    $sql = "SELECT * FROM series WHERE user_id = ?";
    $types = 'i'; // integer parameter
    $params = [$_SESSION['user_id']]; 

    if ($title !== null && $title !== '') {
        $sql .= " AND title LIKE CONCAT('%', ?, '%')";
        $types .= 's'; 
        $params[] = $title;
    }
    if ($genre !== null && $genre !== '') {
        $sql .= " AND genre LIKE CONCAT('%', ?, '%')";
        $types .= 's';
        $params[] = $genre;
    }
    if ($platform !== null && $platform !== '') {
        $sql .= " AND platform LIKE CONCAT('%', ?, '%')";
        $types .= 's';
        $params[] = $platform;
    }
    $sql .= " ORDER BY title,seasons,genre,platform";
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, $types, ...$params); // Splat Operator
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}


function getPlatforms($conn) {
    $platforms = array();
    $sql = "SELECT DISTINCT platform FROM series WHERE user_id = {$_SESSION['user_id']} ORDER BY platform ASC";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('MySQL error: ' . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $platforms[] = $row['platform'];
    }

    mysqli_free_result($result);

    return $platforms;
}

function getGenres($conn) {
    $genres = array();
    $sql = "SELECT DISTINCT genre FROM series WHERE user_id = {$_SESSION['user_id']} ORDER BY genre ASC";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('MySQL error: ' . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $genres[] = $row['genre'];
    }

    mysqli_free_result($result);

    return $genres;
}



function insertSeries($conn, $title, $seasons, $genre, $platform, $user_id) {
    $sql = "INSERT INTO series (title, seasons, genre, platform, user_id) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return "MySQL prepare error: " . mysqli_error($conn);
    }

    mysqli_stmt_bind_param($stmt, "sissi", $title, $seasons, $genre, $platform, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        $error = "Error: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        return $error;
    }
}

function deleteSeries($conn, $series_id, $user_id) {
    $sql = "DELETE FROM series WHERE user_id = ? AND series_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return "MySQL prepare error: " . mysqli_error($conn);
    }

    mysqli_stmt_bind_param($stmt, "ii", $user_id, $series_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        $error = "Error: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        return $error;
    }
}



?>
