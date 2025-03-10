<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

// connects to database
$conn = new mysqli("localhost", "root", "", "students_grades");

if ($conn->connect_error) {
    die(json_encode(["Failed: " . $conn->connect_error]));
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON input."]);
    exit;
}

if (!isset($data['student_id'])) {
    echo json_encode(["error" => "Missing student_id. Please provide a student_id to delete."]);
    exit;
}

$id = (int)$data['student_id'];

$sql = "DELETE FROM students WHERE student_id = $id";

// execute and check result
if ($conn->query($sql) === TRUE) {
    echo json_encode(["Student deleted successfully"]);
} else {
    echo json_encode(["Error deleting student: " . $conn->error]);
}

$conn->close();
?>
