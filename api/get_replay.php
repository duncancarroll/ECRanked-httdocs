<?php 
$servername = "localhost";
$username = "root";

// Create connection
$mysqli = new mysqli("localhost","root","","ecranked");
$fileurl = 'E:\ECRanked\Replays\combustion\[2021-08-24 00-28-17] E4C21CFD-1123-4F24-B47A-3241CD4CEBDA.echoreplay';
$NewUser = false;
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }

function CheckForRateLimit($mysqli,$IP,$TimeoutTime,$applyRatelimit){
    $AccessTime = date("Y-m-d H:i:s");
    if ($result = mysqli_query($mysqli, "SELECT * FROM rate_limit WHERE `ip` = '".$IP."'")) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $last_access = new DateTime($row["last_access"]);
                $since_start = $last_access->diff(new DateTime($AccessTime));
                $timeout = $row["timeout"];
    
                $seconds = $since_start->days * 24 * 60 * 60;
                $seconds += $since_start->h * 60 * 60;
                $seconds += $since_start->i *60 ;
                $seconds += $since_start->s;

                if ($seconds <$timeout){
                    mysqli_free_result($result);
                    return $timeout-$since_start->s;
                }
            }
        } else{
            mysqli_free_result($result);
            if ($applyRatelimit == false){
                $TimeoutTime = 0;
            }
            mysqli_query($mysqli, "INSERT INTO rate_limit (`ip`, `last_access`,`timeout`) VALUES ('".$IP."', '".$AccessTime."',".$TimeoutTime.");");
            return 0;
        }
    }
    if ($applyRatelimit){
        mysqli_query($mysqli, "UPDATE rate_limit SET `last_access` = '".$AccessTime."',`timeout` = ".$TimeoutTime." WHERE (`ip` = '".$IP."')");

    }
    return 0;
}

$_Ip = $_SERVER["REMOTE_ADDR"];
if(isset($_GET["test"])) {
    $FirstCheck = CheckForRateLimit($mysqli,$_Ip."-0",3,false);
    $SecondCheck = CheckForRateLimit($mysqli,$_Ip."-1",3,false);
    if ($SecondCheck > 0){
        http_response_code(429);
        echo $SecondCheck;
        die();
    }
    if ($FirstCheck > 0){
        http_response_code(429);
        echo $FirstCheck;
        die();
    }
    http_response_code(200);
    echo "No Ratelimit";
    die();
}

$FirstCheck = CheckForRateLimit($mysqli,$_Ip."-0",3,true);
if($FirstCheck > 0){
    http_response_code(429);
    echo "request rate limit please wait....<br>";  
    echo $FirstCheck;
    die();
}


if (isset($_GET["session_id"]) == false){
    http_response_code(400);
    echo "Missing key session_id";
    die();
}


$stmt = $mysqli->prepare("SELECT `replay_link` FROM skims WHERE `session_id` = ?");
$stmt->bind_param('s', $_GET["session_id"]); // 's' specifies the variable type => 'string'
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows < 1){
    http_response_code(404);
    echo "replay not found";  
    die();
}

while($row = $result->fetch_assoc()) {
    $fileurl = $row["replay_link"];
    $fileurl = str_replace("/", "\\", $fileurl);
}

$SecondCheck = CheckForRateLimit($mysqli,$_Ip."-1",300,true);
if($SecondCheck > 0){
    http_response_code(429);
    echo "request rate limit please wait....<br>";  
    echo $SecondCheck;
    die();
}


header("Content-type:application/pdf");
header('Content-Disposition: attachment; filename=' . $_GET["session_id"].".echoreplay");
readfile($fileurl);
?>