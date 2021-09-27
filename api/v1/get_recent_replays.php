
<?php
$mysqli = new mysqli("localhost", "root", "", "ecranked");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$query = "SELECT session_id,start_time,map FROM ecranked.skims ORDER BY `start_time` DESC LIMIT 20";
$result = mysqli_query($mysqli, $query);
$replays = [];
while($row = $result->fetch_assoc()){
  array_push($replays, ["session_id" => $row["session_id"],"start_time" => $row["start_time"],"map" => $row["map"]]);
}
header('Content-Type: application/json; charset=utf-8');

echo json_encode($replays)


?>