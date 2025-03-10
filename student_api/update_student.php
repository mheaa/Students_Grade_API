<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

// connects to database
$conn = new mysqli("localhost", "root", "", "students_grades");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON input."]);
    exit;
}

if (
    !isset($data['student_id']) || 
    !isset($data['student_name']) || 
    !isset($data['midterm_score']) || 
    !isset($data['final_score'])
) {
    echo json_encode(["error" => "Missing required fields. Please provide student_id, student_name, midterm_score, final_score."]);
    exit;
}

$id = (int)$data['student_id'];
$name = $conn->real_escape_string($data['student_name']);
$midterm = (float)$data['midterm_score'];
$final = (float)$data['final_score'];

// calculates final grade and status
$final_grade = ($midterm + $final) / 2;
$status = $final_grade >= 75 ? 'Passed' : 'Failed';

$sql = "UPDATE students SET 
            student_name = '$name', 
            midterm_score = $midterm, 
            final_score = $final, 
            final_grade = $final_grade, 
            status = '$status'
        WHERE student_id = $id";

// execute and check result
if ($conn->query($sql) === TRUE) {
    echo json_encode(["Student updated successfully"]);
} else {
    echo json_encode(["Error updating student: " . $conn->error]);
}

$conn->close();
?>
