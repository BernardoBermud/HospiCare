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

 if(isset($_POST['submit'])){
    $response = sendNotification($_POST['title'], $_POST['message']);
    header("Location: adminhome.php");
 }

?>
<!DOCTYPE html>
<!-- This is employee account page-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        input[type=submit]{
            background-color: #b0e298;
            color:#19297c;
            border-radius: 16px;
            padding: 10px 20px;
            display: inline-block;
            text-align: center;
            margin: 8px 47%;
            font-family: Arial, Helvetica, sans-serif;
        }
        .error{
            text-align:center;
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;

        }
    </style>

</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="?logout"><b>Log out</b> </a>
        <a href="account.php"><b>Account</b> </a>

        <a href="adminhome.php"><b>Back</b> </a>

    </div>
    <form action="" method="post">
    <div class="mb-3">
        <label class="heading" ><b>New Notification</b></label>
        <div class="input-text">
            <input type="text" class="form-control" name="title" value="<?php echo @$_POST['title']; ?>" placeholder="Subject">
        </div>
        <form class="input-text"> 
        <textarea type="text" class="form-control" name="message" value="<?php echo @$_POST['message']; ?>" placeholder="Message"></textarea>
        </form>
        <div class="form-group" style="display: flex; justify-content: center;">
            <input type="submit" name="submit" value="Send">
        </div>
        <p class="error" style=><?php echo @$response; ?></p>
    </div>
    </form>
</body>
</html>

<?php
    $mysqli -> close();
?>