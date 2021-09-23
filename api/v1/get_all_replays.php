<?php


// Create connection
$mysqli = new mysqli("localhost", "root", "", "ecranked");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$result = mysqli_query($mysqli, "SELECT `session_id` FROM `ecranked`.`skims`");
$usernames = [];
while($row = $result->fetch_assoc()){
  array_push($usernames, $row["session_id"]);
}
header('Content-Type: application/json; charset=utf-8');

echo json_encode($usernames)
?>