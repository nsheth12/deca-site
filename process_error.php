<?php
require_once("./includes/connection.inc.php");

header('Content-Type: text/xml');

$conn = dbConnect("write");

$problem_id = $_GET['pid'];
$submittedBy = $_GET['uid'];
$description = $_GET['description'];

$sql = "INSERT INTO errors (problem_id, submittedBy, errorDescription) VALUES (?, ?, ?)";
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('dds', $problem_id, $submittedBy, $description);
$stmt->execute();

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
echo '<response>';
echo 'Thank you for your error report. We will look into it.';
echo '</response>';