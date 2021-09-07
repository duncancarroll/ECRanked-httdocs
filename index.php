<!DOCTYPE html>
<html lang="en">
<?php


// Create connection
$mysqli = new mysqli("localhost", "root", "", "ecranked");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$result = mysqli_query($mysqli, "SELECT `oculus_name` FROM `ecranked`.`users`");
$usernames = [];
while($row = $result->fetch_assoc()){
  array_push($usernames, $row["oculus_name"]);
}

?>
<title>ECRanked</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
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
    font-family: "Lato", sans-serif
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
    font-size: 30px;
    width:100%;
  }
  .autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #222; 
    border-bottom: 1px solid #d4d4d4; 
    width:100%;
  }

  /*when hovering an item:*/
  .autocomplete-items div:hover {
  background-color: #444; 
  }
</style>

<body>

  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-dark-gray w3-card w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red"
        href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">About</a>
      <a href="mailto:support@ecranked.com?subject=Takedown%20Request"
        class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">Takedown</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-gray">Contact</a>
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
  <header class="w3-container w3-black w3-center" style="padding:100px 5px">
    <h1 class="w3-margin w3-jumbo">ECRanked</h1>
  </header>

  <div class="w3-container w3-dark-gray w3-center w3-padding-64">
    <div class="w3-xxlarge">Find Your Stats!</div>
    <div class="search-container" style="width:50%">
      <form action="/user_search.php"  autocomplete="off">
        <div class="autocomplete" style="width:100%;margin:10% 50%">
            <input id="myInput" type="text" name="username" class="round w3-xxlarge" style="width:100%" placeholder="Search..." />
        </div>
        <input type="submit" style="display: none" />
      </form>
    </div>

  </div>

  <!-- First Grid -->
  <div class="w3-row-padding w3-padding-64 w3-container w3-dark-gray">
    <div class="w3-content">
      <div class="w3-twothird">
        <h1>How it works</h1>
        <h5 class="w3-padding-32">ECRanked is a system that tracks, saves, and displays data gathered from games of Echo
          Combat. Starting September 1st 2021 almost all games will be spectated and saved. The data that is saved is
          publicly avalable data given to us via the Combat API. The data is only used to caculate intresting statistics
          about players that would have been otherwise impossible to make</h5>
      </div>
    </div>
  </div>

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
      inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();

        if (val.length < 2) {
          closeAllLists();
          return
        }
        if (!val) { return false; }
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
            b.addEventListener("click", function (e) {
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
      inp.addEventListener("keydown", function (e) {
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



    var usernames = <?php echo json_encode($usernames) ?>;
    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), usernames);

  </script>

</body>

</html>