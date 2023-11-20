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

 if($_SESSION["role"] != "admin"){
    header("Location: employeehome.php");
 }

?>
<!DOCTYPE html>
<!-- This is employee account page-->
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
        <a href="adminhome.php"><b>Back</b> </a>

    </div>
    <div class="mb-3">
        <label class="heading" ><b>New Notification</b></label>
        <div class="input-text">
            <input type="text" class="form-control" placeholder="Subject" name="n_subject" value="">
        </div>
        <form> <textarea placeholder="Body"></textarea></form>
        <div class="form-group" style="display: flex; justify-content: center;">
             <label class="button"><b>Send Notification</b></label>
        </div>
    </div>
</html>