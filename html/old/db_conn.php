<?php
include_once 'functions.php';

/*
 * Datenbankverbindung
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