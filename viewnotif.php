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
<!-- This is employee account page-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        textarea {
        font-size: 18px; /* Adjust the font size as needed */
        height: 200px; /* Adjust the height as needed */
        overflow: auto; /* Enable scrollbars if content exceeds the height */
        }
    </style>

</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="?logout"><b>Log out</b> </a>
        <a href="adminhome.php"><b>Back</b> </a>

    </div>
    <form action="" method="post">
    <div class="mb-3">
        <label class="heading" ><b>Notification: <?php echo @$_GET['title']; ?></b></label>
        <form class="input-text"> 
        <textarea readonly rows="10" cols="50">
            <?php 
                echo @$_GET['message']; 
            ?>
        </textarea>
        </form>
        </div>
    </div>
    </form>
</html>