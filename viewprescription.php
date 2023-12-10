<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();

 $id = $_GET['id'];
 $query = "SELECT * FROM prescriptions where id = $id";
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();

 $medicine = $row['medicine'];
 $dosage = $row['dosage'];
 $frequency = $row['frequency'];
 $description = $row['description'];
 $startDate = $row['startDate'];
 $endDate = $row['endDate'];

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
        textarea {
            font-size: 18px; /* Adjust the font size as needed */
            height: 100px; /* Adjust the height as needed */
            overflow: auto; /* Enable scrollbars if content exceeds the height */
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
        <a href="account.php"><b>Account</b> </a>

        <a href="employeehome.php"><b>Back</b> </a>
    </div>

    <form action="" method="post">
    <label class="heading" ><b>Prescription Info</b></label>

        <h2>Medicine: <?php echo $medicine; ?></h2>
        <h2>Dosage: <?php echo $dosage; ?></h2>
        <h2>Start Date: <?php echo $startDate; ?></h2>
        <h2>End Date: <?php echo $endDate; ?></h2>
        <h2>Frequency:</h2>
        <textarea readonly rows="10" cols="50" style="height: 50px;">
            <?php 
                echo $frequency; 
            ?>
        </textarea>
        <h2>Description:</h2>
        <textarea readonly rows="10" cols="50">
            <?php 
                echo $description;
            ?>
        </textarea>
        
    </form>
    </body>
    </html>

<?php
    $mysqli -> close();
?>