<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT midterm, final FROM students WHERE id='$id'";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    $finalGrade = (0.4 * $row["midterm"]) + (0.6 * $row["final"]);
    $status = $finalGrade >= 75 ? "Pass" : "Fail";

    echo json_encode([
        "finalGrade" => number_format($finalGrade, 2),
        "status" => $status
    ]);
} else {
    echo json_encode(["Student not found"]);
}
?>
