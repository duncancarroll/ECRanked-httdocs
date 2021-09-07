<?php 
$servername = "localhost";
$username = "root";

// Create connection
$mysqli = new mysqli("localhost","root","","ecranked");
$fileurl = 'E:\ECRanked\Replays\combustion\[2021-08-14 21-37-52] B475B4E6-A3A6-428D-A5F0-EC9DC5673611.echoreplay';


$NewUser = false;
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
$_Ip = $_SERVER["REMOTE_ADDR"];
$_AccessTime = date("Y-m-d H:i:s");
if ($result = mysqli_query($mysqli, "SELECT * FROM rate_limit")) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $last_access = new DateTime($row["last_access"]);
            $since_start = $last_access->diff(new DateTime($_AccessTime));
            $timeout = $row["timeout"];

            $seconds = $since_start->days * 24 * 60 * 60;
            $seconds += $since_start->h * 60 * 60;
            $seconds += $since_start->i *60 ;
            $seconds += $since_start->s;
            
            if ($seconds <$timeout){
                http_response_code(429);
                echo "request rate limit please wait....<br>";  
                echo $timeout-$since_start->s ;
                die();
            }
        }
        mysqli_free_result($result);

    } else{
        mysqli_free_result($result);
        $NewUser = true;
    }
}


if (isset($_GET["session_id"])){
    
} else{
    http_response_code(400);
    echo "Missing key session_id";
    if ($NewUser){
        $result = mysqli_query($mysqli, "INSERT INTO rate_limit (`ip`, `last_access`,`timeout`) VALUES ('".$_Ip."', '".$_AccessTime."',3);");
    } else{
        $result = mysqli_query($mysqli, "UPDATE rate_limit SET `last_access` = '".$_AccessTime."',`timeout` = 3 WHERE (`ip` = '".$_Ip."')");
    }
    die();
}



$stmt = $mysqli->prepare("SELECT `replay_link` FROM skims WHERE `session_id` = ?");
$stmt->bind_param('s', $_GET["session_id"]); // 's' specifies the variable type => 'string'

$stmt->execute();

$result = $stmt->get_result();



while($row = $result->fetch_assoc()) {
    $fileurl = $row["replay_link"];
}


if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
$_Ip = $_SERVER["REMOTE_ADDR"];
$_AccessTime = date("Y-m-d H:i:s");


if ($result = mysqli_query($mysqli, "SELECT * FROM rate_limit")) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $last_access = new DateTime($row["last_access"]);
            $since_start = $last_access->diff(new DateTime($_AccessTime));
            $timeout = $row["timeout"];

            $seconds = $since_start->days * 24 * 60 * 60;
            $seconds += $since_start->h * 60 * 60;
            $seconds += $since_start->i *60 ;
            $seconds += $since_start->s;
            
            if ($seconds <$timeout){
                http_response_code(429);
                echo "rate limit please wait....<br>";  
                echo $timeout-$since_start->s ;
                die();
            }
        }
        mysqli_free_result($result);

    } else{
        mysqli_free_result($result);

        $result = mysqli_query($mysqli, "INSERT INTO rate_limit (`ip`, `last_access`,`timeout`) VALUES ('".$_Ip."', '".$_AccessTime."',60);");
    }
}


#echo $fileurl;

if ($NewUser){
    $result = mysqli_query($mysqli, "INSERT INTO rate_limit (`ip`, `last_access`,`timeout`) VALUES ('".$_Ip."', '".$_AccessTime."',600);");
} else{
    $result = mysqli_query($mysqli, "UPDATE rate_limit SET `last_access` = '".$_AccessTime."',`timeout` = 60 WHERE (`ip` = '".$_Ip."')");
}

header("Content-type:application/pdf");
header('Content-Disposition: attachment; filename=' . $_GET["session_id"].".echoreplay");
readfile( $fileurl );


?>