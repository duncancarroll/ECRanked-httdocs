<?php
#$ini_array = parse_ini_file("config.ini");
#print_r($ini_array['api_key']);
#echo (get_cfg_var('api_key'));

print("Content-Type: text/html\n\n");
$ini_array = parse_ini_file("config.ini");
if ($ini_array['api_key'] != $_POST["key"]){
    echo("Not authorized");
    die();

}
$mysqli = new mysqli("localhost", "root", "", "ecranked");
  

$NewUser = false;
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$stmt = $mysqli->prepare("UPDATE ecranked.users SET about_string = ? WHERE (oculus_name = ?);");
$stmt->bind_param('ss', $_POST["about_string"],$_POST["oculus_name"]); // 's' specifies the variable type => 'string'
$stmt->execute();
$result = $stmt->get_result();
#!python.exe


?>
