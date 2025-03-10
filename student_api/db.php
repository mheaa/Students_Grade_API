<?php
$host = "localhost";
$user = "root";
$pass = ""; // no pass 
$dbname = "students_grades";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["Database connection failed"]));
}
?>
