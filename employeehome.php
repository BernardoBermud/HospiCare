<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

$mysqli = connect();

if(isset($_GET['logout'])){
    logoutEmployee();
 }

?>

<!DOCTYPE html>
<!-- This is home page for doctors and nurses-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="?logout"><b>Log out</b> </a>
        <a href="account.php"><b>Account</b> </a>

    </div>
    <label class="heading" ><b>Employee Dashboard</b></label>

    <div class="twocolumn">
        <div class="search-container" style="text-align: center;">
          <input type="text" placeholder="Search Patient" name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; color: #19297c;">
            <thead class="thead-light"><br><br><br>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="twocolumn">
        <div class="search-container" style="text-align: center;">
          <input type="text" placeholder="Search Notification" name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; color: #19297c;">
            <thead class="thead-light"><br><br><br>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
        </table>
    </div>

</body>
</html>