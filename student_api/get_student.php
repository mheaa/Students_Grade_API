<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Connect to DB
$conn = new mysqli("localhost", "root", "", "students_grades");

if ($conn->connect_error) {
    die(json_encode(["Failed: " . $conn->connect_error]));
}

$result = $conn->query("SELECT student_id, student_name, midterm_score, final_score, final_grade, status FROM students");

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);

$conn->close();
?>
