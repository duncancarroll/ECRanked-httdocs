<?php
#$ini_array = parse_ini_file("config.ini");
#print_r($ini_array['api_key']);
#echo (get_cfg_var('api_key'));
header("Location: /user/".$_GET["username"]."/stats");
die();

?>