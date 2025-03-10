<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$conn = new mysqli("localhost", "root", "", "students_grades");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

$student_name = $data['student_name'];
$midterm_score = $data['midterm_score'];
$final_score = $data['final_score'];

// calculate final grade and status
$final_grade = ($midterm_score + $final_score) / 2;
$status = $final_grade >= 75 ? 'Passed' : 'Failed';

$sql = "INSERT INTO students (student_name, midterm_score, final_score, final_grade, status) 
        VALUES ('$student_name', $midterm_score, $final_score, $final_grade, '$status')";

if ($conn->query($sql)) {
    echo json_encode(["Student added successfully."]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
