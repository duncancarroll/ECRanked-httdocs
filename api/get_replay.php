<?php 
$servername = "localhost";
$username = "root";

// Create connection
$mysqli = new mysqli("localhost","root","","ecranked");
$fileurl = 'E:\ECRanked\Replays\combustion\[2021-08-24 00-28-17] E4C21CFD-1123-4F24-B47A-3241CD4CEBDA.echoreplay';
$NewUser = false;

if ($mysqli -> connect_errno) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(503);

    echo json_encode($arr = [
        "code" => 503,
        "message" => "Failed to connect to MySQL: " . $mysqli -> connect_error
    ]);
    exit();
  }


function ApplyRateLimit($mysqli,$IP,$TimeoutTime){
    $CurrentTime = new DateTime(date("Y-m-d H:i:s"));
    $NewAccessTime  = date("Y-m-d H:i:s", time() + $TimeoutTime);
    if ($result = mysqli_query($mysqli, "SELECT * FROM rate_limit WHERE `ip` = '".$IP."'")) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $timeoutTime = new DateTime($row["timeout"]);

                #IF YOU PASS
                if ($CurrentTime >= $timeoutTime){
                    mysqli_query($mysqli, "UPDATE rate_limit SET `timeout` = '".$NewAccessTime."' WHERE (`ip` = '".$IP."')");
                    return 0;
                } else{
                    $since_start = $timeoutTime->diff($CurrentTime);
                    $seconds = $since_start->days * 24 * 60 * 60;
                    $seconds += $since_start->h * 60 * 60;
                    $seconds += $since_start->i *60 ;
                    $seconds += $since_start->s;
                    mysqli_free_result($result);
                    return $seconds;
                }
            }
        } else{
            mysqli_query($mysqli, "INSERT INTO rate_limit (`ip`, `timeout`) VALUES ('".$IP."', '".$NewAccessTime."');");
            mysqli_free_result($result);
            return 0;
        }
    }
    return "error";

}

function CheckForRateLimit($mysqli,$IP){
    $CurrentTime = new DateTime(date("Y-m-d H:i:s"));
    if ($result = mysqli_query($mysqli, "SELECT * FROM rate_limit WHERE `ip` = '".$IP."'")) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $timeoutTime = new DateTime($row["timeout"]);

                #IF YOU PASS
                if ($CurrentTime > $timeoutTime){
                    return 0;
                } else{
                    $since_start = $timeoutTime->diff($CurrentTime);
                    $seconds = $since_start->days * 24 * 60 * 60;
                    $seconds += $since_start->h * 60 * 60;
                    $seconds += $since_start->i *60 ;
                    $seconds += $since_start->s;
                    mysqli_free_result($result);
                    return $seconds;
                }
            }
        } else{
            mysqli_free_result($result);
            return 0;
        }
    }
}

$_Ip = $_SERVER["REMOTE_ADDR"];
if(isset($_GET["test"])) {
    header('Content-Type: application/json; charset=utf-8');

    $Check = max(CheckForRateLimit($mysqli,$_Ip."-0"),CheckForRateLimit($mysqli,$_Ip."-1"));

    $SecondCheck = CheckForRateLimit($mysqli,$_Ip."-1");
    $FirstCheck = CheckForRateLimit($mysqli,$_Ip."-0");
    if ($Check > 0){
        http_response_code(429);
        echo json_encode($arr = [
            "code" => 429,
            "message" => "you are being ratelimited",
            "timeout" => $Check
        ]);        
        die();
    }
    http_response_code(200);
    echo json_encode($arr = [
        "code" => 200,
        "message" => "no ratelimit",
        "timeout" => 0
    ]);
    die();
}


### BASIC PROTECTIVE RATELIMIT OF EVERY THREE SECONDS

$FirstCheck = max(ApplyRateLimit($mysqli,$_Ip."-0",3),CheckForRateLimit($mysqli,$_Ip."-1"));
if($FirstCheck >0){
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(429);
    echo json_encode($arr = [
        "code" => 429,
        "message" => "you are being ratelimited",
        "timeout" => $FirstCheck
    ]);  
    die();
}

if (isset($_GET["session_id"]) == false){
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    echo json_encode($arr = [
        "code" => 400,
        "message" => "missing key `session_id`",
        "timeout" => 0
    ]);  
    die();
}

$stmt = $mysqli->prepare("SELECT `replay_link` FROM skims WHERE `session_id` = ?");
$stmt->bind_param('s', $_GET["session_id"]); // 's' specifies the variable type => 'string'
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows < 1){
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode($arr = [
        "code" => 404,
        "message" => "replay not found",
        "timeout" => 0
    ]);  
    die();
}

while($row = $result->fetch_assoc()) {
    $fileurl = $row["replay_link"];
    $fileurl = str_replace("/", "\\", $fileurl);
}





### PROTECTIVE RATE LIMIT OF 10 MIN

$SecondCheck = ApplyRateLimit($mysqli,$_Ip."-1",300);
if($SecondCheck > 0){
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(429);
    echo json_encode($arr = [
        "code" => 429,
        "message" => "you are being ratelimited",
        "timeout" => $SecondCheck
    ]);  
    die();
}

header("Content-type:application/echoreplay");
header('Content-Disposition: attachment; filename=' . $_GET["session_id"].".echoreplay");
readfile($fileurl);
?>