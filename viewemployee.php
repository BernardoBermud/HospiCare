<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] == "admin"){
    header("Location: editemployee.php");
 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();

 $id = $_GET['id'];
 $query = "SELECT phone, email, role, active FROM employees where id = $id";
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();

 $phone = $row['phone'];
 $email = $row['email'];
 $role = $row['role'];
 $active = $row['active'];

# Possible role variables
 $ar_rvbs = ["nurse", "doctor", "admin"];
 $ar_rvbs2 =["active", "inactive"];

 


?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        h2 {
            color: #19297c;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
            height: 30px;
        }

        input[type=submit]{
            background-color: #b0e298;
            color:#19297c;
            border-radius: 16px;
            padding: 10px 20px;
            display: inline-block;
            text-align: center;
            margin: 8px 47%;
        }

        .error{
            text-align:center;
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;

        }

        .label{
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;
            margin-top: 5px;
            padding-right: 15px;

        }

        .label2{
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;
            margin-top: 8px;
            padding-left: 15px;

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
    <label class="heading" ><b>Employee Info</b></label>

        <h2>Name: <?php echo @$_GET['fName']. " ". @$_GET['lName']; ?></h2>
        <h2>Phone: <?php echo $phone; ?></h2>
        <h2>Email: <?php echo $email; ?></h2>
        <h2>Role: <?php echo $role; ?></h2>
        
    </form>
    </html>