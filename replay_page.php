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
    header('Location: /home');
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
  $skimDataJson = json_decode(file_get_contents($skim_link), true);



?>
<title><?php echo htmlspecialchars($session_id, ENT_QUOTES, 'UTF-8')?></title>
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
            <input id="myInput" type="text" name="username" class="round-search w3-small" placeholder="Search..." />
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
    <h1 class="w3-margin w3-xlarge" style="font-size:10px"><?php echo htmlspecialchars($session_id,ENT_QUOTES, 'UTF-8')?></h1>
  </header>
  <?php


  $stmt = $mysqli->prepare("SELECT * FROM ecranked.skims WHERE `player_ids` LIKE CONCAT('%',?,'%') ORDER BY `start_time` DESC LIMIT 10");
  $stmt->bind_param('s', $ouclus_id); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $skimsData = $stmt->get_result();


  ?>

  <div class="user-page-container">
    <!-- Right Bar-->
    <div class="round replays-container">
      <header style="padding:auto;text-align:center">
        <h1>Players<h1>
      </header>


      <?php
        $oculus_ids = $skimData["player_ids"];
        $oculus_ids_arr = explode (",", $oculus_ids); 
        foreach ($skimDataJson["players"] as $player_data){
            $oculus_id = $player_data["userid"];
            $team_id = $player_data["team"];
            switch ($team_id) {
              case 0:
                $team_class = "orange-team-color";
                # code...
                break;
              
              case 1:
                $team_class = "blue-team-color";
                # code...
                break;

              default:
                $team_class = "";

                # code...
                break;
            }
            $result = mysqli_query($mysqli, "SELECT `oculus_name` FROM `users` WHERE `oculus_id` = ".$oculus_id);
            $row = $result->fetch_assoc();
            if($row){
              $oculus_name = $row["oculus_name"];

            }else
            {
              $oculus_name = "anonymous";

            }

            // Outputs a date/time string based on the time zone you've set on the object.
            echo <<<EOT
            <a class="fully-rounded button-list $team_class" href="/user/$oculus_name/stats">
              <p style="text-align: center">
                $oculus_name
              </p>
            </a>
            EOT;
        }

      ?>

    </div>
    
    <div class="round user-stats">
      <header><h1 style="text-align:center">About Game<h1></header>
      <header class="stats-grid" style="padding:auto;text-align:center">

        

      </header>


    </div>
    <script>
      

    </script>
    <!-- Left Bar-->
    <div class="round download-container">
      <div class="round download-sub-container">
        <h1 style="text-align:center;cursor:pointer" onclick="downloadReplay('<?php echo htmlspecialchars($session_id, ENT_QUOTES, 'UTF-8')?>',this)"> Download </h1>

      </div>
      <p class= "download-timeout" id="discord-timeout-id" style="opacity:0%;height:0px;background-color:rgba(0,0,0,0)"> 
      Your downloading too much please wait
      </p>
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

    function downloadReplay(session_id,element){
      var responce = fetch(window.location.href+"/trydownload")
      responce.then(function(responce) {
        statusCode = responce.status
        if (statusCode == 200){
          location.href = window.location.href+"/download";
        }
        else
        {
          responce.text().then(
            function(seconds) {
              Errorelement = document.getElementById("discord-timeout-id");
              Errorelement.style = "opacity:0%;height:0px;background-color:rgba(0,0,0,0);animation-duration: 3s;animation-name: slidein;";
              Errorelement.innerHTML = "Your downloading too much please wait "+seconds+" seconds before trying again";

              setTimeout(function ()
              {
                Errorelement.innerHTML = "Your downloading too much please wait "+(seconds-1)+" seconds before trying again";
                setTimeout(function ()
                {
                  Errorelement.innerHTML = "Your downloading too much please wait "+(seconds-2)+" seconds before trying again";
                      setTimeout(function ()
                  {
                    Errorelement.style = "opacity:0%;height:0px;background-color:rgba(0,0,0,0)";
                  }, 1000);
                }, 1000);
              }, 1000);
            })
        }
      });
        // .then(function(responce) {
        //   console.log(responce);
        //   returnStatus = responce["status"]
        //   
        //   return response
        // })
        // .then(response => console.log(response.text()))
      
      
      
      
      // .then(function(response) {
      //   return response
      // }).then(function(data) {
      //   console.log(data);
      //   returnStatus = data["status"]
      //   if (returnStatus == 200){
      //     location.href = window.location.href+"/download";
      //   } else {
      //     let seconds = response.text();
      //     alert("you downloading too much please wait "+seconds+" seconds");
      //   }
      // }).catch(function() {
      //   console.log("Booo");
      // });
    }
  </script>

</body>

</html>