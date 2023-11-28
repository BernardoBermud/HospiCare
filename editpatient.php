<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] != "admin"){
    header("Location: viewpatient.php");
 }

if(isset($_POST['submit'])){
    $response = editPatient($_GET['id'], $_POST['fName'], $_POST['lName'], $_POST['phone'], $_POST['email'], $_POST['active']);
 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();

 $id = $_GET['id'];
 $query = "SELECT phone, email, active FROM patients where id = $id";
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();

 $phone = $row['phone'];
 $email = $row['email'];
 $active = $row['active'];

 $ar_rvbs2 =["active", "inactive"];
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        h1 {
            color: #19297c;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            font-family: Arial, Helvetica, sans-serif;
            height: 200px;
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
        <h1>Edit Employee</h1>

        <div class="twocolumn">
            <div class="input-text">
                <label class="label" style="margin-top: 8px;"> First Name:</label>
                <input type="text" name="fName" value="<?php echo @$_GET['fName']; ?>" placeholder="First Name">
            </div>
            <div class="input-text">
                <label class="label" style="margin-top: 8px;"> Last Name:</label>
                <input type="text" name="lName" value="<?php echo @$_GET['lName']; ?>" placeholder="Last Name">
            </div>
            <div class="input-text">
                <label class="label" style="margin-top: 8px;">Phone:</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone Number">
            </div>
            <div class="input-text">
                <label class="label" style="margin-top: 8px;">Email:</label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email">
            </div>
        </div>
        <div class="twocolumn">
        
            <div class="input-text" style= "padding: -10 0; height: 30px !important;">
                <label class="label" style="margin-top: 8px;">Activity Status:</label>
                <?php makeRadioStatus($ar_rvbs2, $active); ?>

            </div>
            
            <div class="input-text">
               <input type="hidden" name="creatorid" value="<?php echo @$_SESSION['id'] ?>" placeholder="<?php echo @$_SESSION['id']; ?>" readonly>
              
            </div>
        </div>
        <input type="submit" name="submit" value="Save">
   <p class="error" style=><?php echo @$response; ?></p>
    </form>
    </html>