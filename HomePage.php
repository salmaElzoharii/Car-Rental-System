<html>
<link rel="stylesheet" href="CarsPage.css">
<body>
    <?php
    session_start();
    ?>
<form id="carspage" method="post" action="HomePage.php"></form>
        <div><h1>Cars Rental Site</h1></div>

        <div><h2 onclick="home()">Home</h2></div>
        <div class="dropdown">
        <!-- <button onclick="myFunction()" -->
            <button class="searchbtn"></button>
                <div id="search_options" class="dropdown-content">
                <input type="text" placeholder="Search.." id="search_text" onkeyup="filter(event)">
                   
                    <a>Model
                        <b class = "sub-dropdown">
                            <div class = "sub-dropdown-content">
                            <b onclick="model(2010)">2010</b>
                            <b onclick="model(2011)">2011</b>
                            <b onclick="model(2012)">2012</b>
                            <b onclick="model(2013)">2013</b>
                            <b onclick="model(2014)">2014</b>
                            <b onclick="model(2015)">2015</b>
                            <b onclick="model(2016)">2016</b>
                            <b onclick="model(2017)">2017</b>
                            <b onclick="model(2018)">2018</b>
                            <b onclick="model(2019)">2019</b>
                            <b onclick="model(2020)">2020</b>
                            <b onclick="model(2021)">2021</b>
                            <b onclick="model(2022)">2022</b>
                            <b onclick="model(2023)">2023</b>
                            </div>
                        </b>
                    </a>
                    <a>Brand
                        <b class = "sub-dropdown">
                            <div class = "sub-dropdown-content">
                            <b onclick="brand('Bentley')">Bentley</b>
                            <b onclick="brand('Ferrari')">Ferrari</b>
                            <b onclick="brand('Mercedes')">Mercedes</b>
                            <b onclick="brand('Bugatti')">Bugatti</b>
                            <b onclick="brand('Lamborghini')">Lamborghini</b>
                            <b onclick="brand('Maserati')">Maserati</b>
                            <b onclick="brand('BMW')">BMW</b>
                            <b onclick="brand('Audi')">Audi</b>
                            <b onclick="brand('Porsche')">Porsche</b>
                            </div>
                        </b>
                    </a>
                    <a onclick="av()">Available</a>
                    <a>Price/Day Range
                        <div class="slidecontainer">
                        <input type="range" min="1" max="1000" value="500" class="slider" id="myRange">
                        <z onclick="price()"><span id="demo"></span></z>
                    </div>        
                    </a>
                    <a>Location
                        <b class = "sub-dropdown"  >
                            <div class = "sub-dropdown-content">
                            
                                    <!-- <b onclick="getloc()">Current Location</b> -->
                                    <b onclick="loc('Alexandria')">Alexandria</b>
                                    <b onclick="loc('Cairo')">Cairo</b>
                                    <b onclick="loc('Tanta')">Tanta</b>
                                    <b onclick="loc('Sinaii')">Sinaii</b>
                                    <b onclick="loc('GIza')">Giza</b>
                                    <b onclick="loc('Aswan')">Aswan</b>
                            </div>
                        </b>
                    </a>
                    <!-- <a>Color
                        <b class = "sub-dropdown">
                            <div class = "sub-dropdown-content">
                                    <b herf="#">Black</b>
                                    <b herf="#">Silver</b>
                                    <b herf="#">White</b>
                                    <b herf="#">Red</b>
                                    <b herf="#">Pink</b>
                                    <b herf="#">Light Blue</b>
                                    <b herf="#">Dark blue</b>
                                    <b herf="#">Violet</b>
                                    <b herf="#">Green</b>
                            </div>
                        </b>
                    </a> -->
                    
                    
                </div>
                </div>

<?php
    include 'connectingDatabase.php';
    
    // $sql = "SELECT * FROM car";
    if (isset($_POST['model'])){
        $x = trim($_POST["model"]);
        $x = intval($x); 
        $sql = "SELECT * FROM car where Car_year= $x";
    }
    else if  (isset($_POST['brand'])){
        $x = trim($_POST["brand"]);
        $sql = "SELECT * FROM car where brand= '$x'";
    }
    else if  (isset($_POST['av'])){
        // $x = trim($_POST["available"]); 
        $sql = "SELECT * FROM car where availability_status= 'active'";
    }
    else if  (isset($_POST['loc'])){
        $x = trim($_POST["loc"]); 
        $sql = "SELECT * FROM car where location= '$x'";
    }
    else if  (isset($_POST['price'])){
        $x = trim($_POST["price"]); 
        $x = intval($x); 
        $sql = "SELECT * FROM car where price<= $x";
    }
    else{
        
        $today=date("Y-m-d");
        $changeStatus="update car set availability_status='rented' where plate_id in (SELECT plate_id FROM reservation where pickup_date='$today')";
        $db->query($changeStatus);
        $returnStatus="update car set availability_status='active' where plate_id in (SELECT plate_id FROM reservation where return_date='$today')";
        $db->query($returnStatus);
        $sql = "SELECT * FROM car";
        }
    
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        ?>
        <div class = "container">
            <?php
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $availability_status = $row["availability_status"];
            $price = $row["price"];
            $location = $row["location"];
            $image = $row["image_path"];
            $brand = $row["brand"];
            $plate_id=$row["plate_id"];
            $availability_status = $row["availability_status"];
            
            ?>

            <form method="post">
                <div class="container">
                    
                    <div class="box">
                        <a href="reserveCar.php?id=<?php echo $plate_id ?>">
                            <img class=img  src="car_images/<?php echo $image ?>" >
                        </a>
                        <h3>Brand :
                            <?php echo $brand ?>
                         </h3>
                        <h3>Status :
                            <?php echo $availability_status ?>
                         </h3>
                        <h3>location :
                            <?php echo $location ?>
                        </h3>
                        <h3>price per day : <a>
                                <?php echo $price ?>
                            </a> $</h3>
                    </div>
                </div>
            </form>
            <?php
        }
    }
    else {
        ?> <h4>We're so sorry!</h4>
            <h4>The term you entered yeild no results =(</h4>
            <h4>Try again later!! </h4> <?php
    }
    if($_SESSION['alert']=="alert")
    {
        echo '<script>alert("Car is already rented. Choose another Car.");</script>';
    }

    
    
    $db->close(); ?>



</body>

<script>
       

    function filter(evt) {
    var input, f, a, i;

    input = document.getElementById("search_text");
    f = input.value.toUpperCase();
    div = document.getElementById("search_options");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(f) > -1) {
        a[i].style.display = "";
        } else {
        a[i].style.display = "none";
        }
    }
    }

    function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude;
}
    function getloc() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function home(){
    var form = document.getElementById("carspage");
    form.action = "HomePage.php";
    form.submit();
}
function model($x){
    var hiddenField = document.createElement("input");
    hiddenField.type = "hidden";
    hiddenField.name = "model";
    hiddenField.value = $x;

    var form = document.getElementById("carspage");
    form.appendChild(hiddenField);
    form.action = "HomePage.php";
    form.submit();
}

function brand($x){
    var hiddenField = document.createElement("input");
    hiddenField.type = "hidden";
    hiddenField.name = "brand";
    hiddenField.value = $x;

    var form = document.getElementById("carspage");
    form.appendChild(hiddenField);
    form.action = "HomePage.php";
    form.submit();
}

function av(){
    var hiddenField = document.createElement("input");
    hiddenField.type = "hidden";
    hiddenField.name = "av";
    // hiddenField.value = $x;

    var form = document.getElementById("carspage");
    form.appendChild(hiddenField);
    form.action = "HomePage.php";
    form.submit();
}

function loc($x){
    var hiddenField = document.createElement("input");
    hiddenField.type = "hidden";
    hiddenField.name = "loc";
    hiddenField.value = $x;

    var form = document.getElementById("carspage");
    form.appendChild(hiddenField);
    form.action = "HomePage.php";
    form.submit();
}
var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;

        slider.oninput = function() {
        output.innerHTML = this.value;
        }  

    function price(){
        $x =slider.value
    var hiddenField = document.createElement("input");
    hiddenField.type = "hidden";
    hiddenField.name = "price";
    hiddenField.value = $x;

    var form = document.getElementById("carspage");
    form.appendChild(hiddenField);
    form.action = "HomePage.php";
    form.submit();
}

        </script>
</html>