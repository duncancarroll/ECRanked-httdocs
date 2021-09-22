<!DOCTYPE html>
<html lang="en">
<?php


  // Create connection
  $mysqli = new mysqli("localhost", "root", "", "ecranked");
  
  $session_id = $_GET["session_id"];

  $NewUser = false;
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
  }
  $_Ip = $_SERVER["REMOTE_ADDR"];
  $_AccessTime = date("Y-m-d H:i:s");

  $stmt = $mysqli->prepare("SELECT * FROM `skims` WHERE `session_id` = ?");
  $stmt->bind_param('s', $session_id); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $result = $stmt->get_result();
  
  
  $skimData = $result->fetch_assoc();
  if ($result->num_rows == 0) {
    header("Status: 404 Not Found");
    echo("session id not found");
    die();
  }

  function map(float $inmin, float $inmax, float $outmin, float $outmax, float $value)
  {
    $v = ($value - $inmin) / ($inmax - $inmin);
    $out = ($v * ($outmax - $outmin)) + $outmin;
    if ($out > $outmax) {
      return $outmax;
    }
    if ($out < $outmin) {
      return $outmin;
    }
    return $out;
  }
  
  $ip = $_SERVER['REMOTE_ADDR'];
  if($ip == "::1" or $ip == "192.168.1.1"){
    $timezone = "BST";
  } else{
    $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
    $ipInfo = json_decode($ipInfo);
    $timezone = $ipInfo->timezone;

  }
  $result = mysqli_query($mysqli, "SELECT `oculus_name` FROM `ecranked`.`users`");
  
  $usernames = [];
  while($row = $result->fetch_assoc()){
    array_push($usernames, $row["oculus_name"]);
  }
  $replay_link = $skimData["replay_link"];
  $skim_link = str_replace("Replays","Skims",$replay_link);
  $skim_link = str_replace(".echoreplay",".ecrs",$skim_link);
  try {
    //code...
  } catch (\Throwable $th) {
    //throw $th;
  }
  #echo (str_replace("Replays","Skims",$skimData["replay_link"]));
  
  $skim_str = file_get_contents($skim_link);
  header('Content-Type: application/json; charset=utf-8');

?>
<?php echo($skim_str) ?>
</html>