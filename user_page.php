<!DOCTYPE html>
<html lang="en">
<?php


  // Create connection
  $mysqli = new mysqli("localhost", "root", "", "ecranked");

  $username = $_GET["username"];

  $NewUser = false;
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
  }
  $_Ip = $_SERVER["REMOTE_ADDR"];
  $_AccessTime = date("Y-m-d H:i:s");

  $stmt = $mysqli->prepare("SELECT * FROM users WHERE `oculus_name` = ?");
  $stmt->bind_param('s', $username); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $result = $stmt->get_result();

  $userData = $result->fetch_assoc();
  if ($result->num_rows == 0) {
    header('Location: /home');
    die();
  }
  if ($userData["discord_name"] == NULL) {
    $discordID = NULL;
  } else {
    $discordID = $userData["discord_id"];
  }
  $ouclus_id = $userData["oculus_id"];
  $stmt = $mysqli->prepare("SELECT * FROM stats WHERE `oculus_id` = ?");
  $stmt->bind_param('s', $ouclus_id); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $result = $stmt->get_result();
  $statData = $result->fetch_assoc();



  $result = mysqli_query($mysqli, "SELECT COUNT(`session_id`) as 'total' FROM `ecranked`.`skims`");
  $all_games_total = ($result->fetch_assoc())["total"];

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
  echo $ip;
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


?>
<title><?php echo ucfirst($username) ?>'s User page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  body,
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    font-family: "Lato", sans-serif;
    color: white
  }

  .w3-bar,
  h1,
  button {
    font-family: "Montserrat", sans-serif
  }

  .fa-anchor,
  .fa-coffee {
    font-size: 200px
  }

  .discord-account-page {
    background-color: red;
    padding: 20px;
    margin: 20px 20px 20px 66%;

  }

  .discord-account-page-title {
    background-color: #fff;
    padding: 20px;
    margin: 10px;

  }

  .discord-account-page-title {
    background-color: #ff0;
    padding: 20px;
    margin: 20px 20px 20px 66%;

  }

  body {
    background-color: #222;

  }

  .rounded {
    border: 2px solid black;
    border-radius: 60px;
  }
  .autocomplete-items {
      position: relative;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
      font-size: 15px;
    }
  .autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #222; 
  border-bottom: 1px solid #d4d4d4; 
  }

  /*when hovering an item:*/
  .autocomplete-items div:hover {
  background-color: #444; 
  }
</style>


<body>
  UwU whats this~

  <!-- Navbar -->
  <div class="w3-top" style="height:40px">
    <div class="w3-bar w3-dark-gray w3-card w3-left-align w3-large" style="height:51px;overflow:visible">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
      <a href="/home" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">Home</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">About</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">Takedown</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">Contact</a>
      <div class="w3-bar-item-left" style="float:right;height:100%">
        <form action="/user_search.php" autocomplete="off">
          <div class="autocomplete">
            <input id="myInput" type="text" name="username" class="round w3-small" placeholder="Search..." />
          </div>
          <input type="submit" style="display: none" />
      </div>


    </div>
    <div class="w3-bar w3-dark-gray w3-card w3-right-align w3-large">
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 4</a>
    </div>
  </div>


  <!-- Header -->
  <header class="w3-container w3-black w3-center" style="padding:100px 5px;background-image: url('/assets/combat_background.jpg'); background-size: cover;">
    <h1 class="w3-margin w3-jumbo"><?php echo ucfirst($username) ?></h1>
  </header>
  <?php


  $stmt = $mysqli->prepare("SELECT * FROM ecranked.skims WHERE `player_ids` LIKE CONCAT('%',?,'%') ORDER BY `start_time` DESC LIMIT 10");
  $stmt->bind_param('s', $ouclus_id); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $skimsData = $stmt->get_result();


  ?>

  <div class="user-page-container">
    <!-- Right Bar-->
    <div class="replays-container">
      <header style="padding:auto;text-align:center">
        <h2>Recent Games<h2>
      </header>


      <?php

      while ($skimData = $skimsData->fetch_assoc()) {
        $original_datetime = $skimData["start_time"];
        $timeZoneStr = date_default_timezone_get();
        $original_timezone = new DateTimeZone("UTC");

        // Instantiate the DateTime object, setting it's date, time and time zone.
        $datetime = new DateTime($original_datetime, $original_timezone);
        // Set the DateTime object's time zone to convert the time appropriately.
        $target_timezone = new DateTimeZone($timezone);
        $datetime->setTimeZone($target_timezone);

        // Outputs a date/time string based on the time zone you've set on the object.
        $triggerOn = $datetime->format('M jS g:iA');
        echo <<<EOT
        <a class="replay-links" href="/replay/{$skimData["session_id"] }">
          <p style="text-align: center">
            {$triggerOn} - [{$skimData["map"] }] 
          </p>
        </a>
        EOT;
      }

      ?>

    </div>
    <?php

      $stmt = $mysqli->prepare("SELECT * FROM ecranked.skims WHERE player_ids LIKE CONCAT('%',?,'%') LIMIT 10");
      $stmt->bind_param('s', $username); // 's' specifies the variable type => 'string'
      $stmt->execute();
      $result = $stmt->get_result();

      $skimData = $result->fetch_assoc();

      $total_games = $statData["total_games_combustion"] + $statData["total_games_dyson"] + $statData["total_games_fission"] + $statData["total_games_surge"];
      $total_deaths = $statData["total_deaths"];
      $average_speed = $statData["total_speed"] /  $statData["frames_speed"];
      $average_ping = $statData["total_ping"] /  $statData["frames_ping"];
      $percent_stopped = ($statData["total_stopped"] /  $statData["frames_stopped"]) * 100;
      $percent_upsidedown = ($statData["total_upsidedown"] /  $statData["frames_upsidedown"]) * 100;
      $deaths_per_game = $total_deaths /  $total_games;


      $total_games_width =   ($total_games / $all_games_total) * 100;
      $average_ping_width =   round(map(200, 10, 0, 100, $average_ping), 2);
      $total_deaths_width =   100;
      $average_speed_width = round(map(0, 5, 0, 100, $average_speed), 2);
      $deaths_per_game_width = round(map(5, 30, 0, 100, $deaths_per_game), 2);



      $total_games_bar        = "background-color:rgb(179,82,82); width:" . $total_games_width . "%";
      $average_ping_bar       = "background-color:rgb(179,82,82); width:" . $average_ping_width . "%";
      $total_deaths_bar       = "background-color:rgb(179,82,82); width:" . $total_deaths_width . "%";
      $average_speed_bar      = "background-color:rgb(179,82,82); width:" . $average_speed_width . "%";
      $percent_stopped_bar    = "background-color:rgb(179,82,82); width:" . $percent_stopped . "%";
      $percent_upsidedown_bar = "background-color:rgb(179,82,82); width:" . $percent_upsidedown . "%";
      $deaths_per_game_bar    = "background-color:rgb(179,82,82); width:" . $deaths_per_game_width . "%";


    ?>
    <div class="user-stats">
      <header><h1 style="text-align:center">Stats<h1></header>
      <header class="stats-grid" style="padding:auto;text-align:center">

        <div class="stat-container">
          Total Games
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $total_games_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($total_games) ?>
            </p>

          </div>
          </p>
        </div>
        <div class="stat-container">
          Total Deaths
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $total_deaths_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($total_deaths) ?>
            </p>

          </div>
        </div>
        <div class="stat-container">
          Average Ping
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $average_ping_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($average_ping, 1) ?>ms
            </p>

          </div>
          </p>
        </div>
        <div class="stat-container">
          Average Speed
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $average_speed_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($average_speed, 2) ?>m/s
            </p>

          </div>
          </p>
        </div>
        <div class="stat-container">
          Time stopped
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $percent_stopped_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($percent_stopped) ?>%
            </p>

          </div>
          </p>
        </div>
        <div class="stat-container">
          Inverted
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $percent_upsidedown_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($percent_upsidedown) ?>%
            </p>

          </div>
          </p>
        </div>
        <div class="stat-container">
          Deaths / game
          <div class="stats-bar">
            <p class="stat-bar" style="<?php echo $deaths_per_game_bar ?>"></p>
            <p class="stat-bar-text">
              <?php echo round($deaths_per_game, 1) ?>
            </p>

          </div>
          </p>
        </div>

      </header>


    </div>
    <!-- Left Bar-->
    <div class="discord-container">
      <a href=""></a>
      <?php
      if ($discordID == NULL) {
        echo <<<EOT
            <h1 style="text-align:center"> Discord Info </h1>
            <span style="font-size:15px;"> Theres no discord account linked. If you wish to link your discord account contact one of the developers</span>
          </div>
        EOT;

        die();
      }

      $curl_h = curl_init("https://discord.com/api/users/" . $discordID);

      curl_setopt(
        $curl_h,
        CURLOPT_HTTPHEADER,
        array(
          "User-Agent:EchoCombatRanked/2.15 ECRanked.com/2.4",
          "Authorization:Bot ODUyNjYwODI2NzEwOTk5MDUx.YMKERg.yW0azJLkVQoXrUWD1gL0LxvVn6Y",
        )
      );

      # do not output, but store to variable
      curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($curl_h);
      $jsonData = json_decode($response);
      #echo $jsonData->{'avatar'};
      $discordAvatarLink = "https://cdn.discordapp.com/avatars/" . $discordID . "/" . $jsonData->{'avatar'} . ".png";
      $discordFullName = $jsonData->{'username'} . "#" . $jsonData->{'discriminator'};
      echo <<<EOT
          <h1 style="text-align:center"> Discord Info </h1>
          <img style="border: 2px solid black; border-radius:100px; margin:10px" src=$discordAvatarLink alt="Discord PFP">
          <span style="font-size:20px;"> $discordFullName</span>
        </div>
      EOT;


      ?>

    </div>






  </div>

  <!-- First Grid -->


  <!-- Discord Info -->







  <script>
    // Used to toggle the menu on small screens when clicking on the menu button
    function myFunction() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else {
        x.className = x.className.replace(" w3-show", "");
      }
    }

    function autocomplete(inp, arr) {
      /*the autocomplete function takes two arguments,
      the text field element and an array of possible autocompleted values:*/
      var currentFocus;
      /*execute a function when someone writes in the text field:*/
      inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
         closeAllLists();
        
          if (val.length < 2){
            closeAllLists();
            return
          }
          if (!val) { return false;}
          currentFocus = -1;
          /*create a DIV element that will contain the items (values):*/
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          /*append the DIV element as a child of the autocomplete container:*/
          this.parentNode.appendChild(a);
          /*for each item in the array...*/
          for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");
              /*make the matching letters bold:*/
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
                  b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  inp.value = this.getElementsByTagName("input")[0].value;
                  
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
                  inp.parentElement.parentElement.submit()
              });
              a.appendChild(b);
            }
          }
          
      });
      /*execute a function presses a key on the keyboard:*/
      inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 13) {
            x.sumbit()
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
              /*and simulate a click on the "active" item:*/
              if (x) x[currentFocus].click();
            }
          }
      });
      function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
      }
      function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
          x[i].classList.remove("autocomplete-active");
        }
      }
      function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
          if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
    }
    
    var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

    var usernames = <?php echo json_encode($usernames)?>;
    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), usernames);
  </script>

</body>

</html>