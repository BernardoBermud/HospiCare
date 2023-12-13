<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] != "admin"){
    header("Location: viewemployee.php");
 }

if(isset($_POST['submit'])){
    $response = editEmployee($_GET['id'], $_POST['fName'], $_POST['lName'], $_POST['phone'], $_POST['email'], $_POST['role'], $_POST['active']);
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
        input[type=submit]{
            background-color: #b0e298;
            color:#19297c;
            border-radius: 16px;
            padding: 10px 20px;
            display: inline-block;
            text-align: center;
            margin: 8px 47%;
        }

        .success-text {
            text-align:center;
            font-family: Arial, Helvetica, sans-serif;
            color: green;
        }

        .error{
            text-align:center;
            font-family: Arial, Helvetica, sans-serif;
            color: #FF0000;
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

        <a href="adminhome.php"><b>Back</b> </a>
    </div>

    <form action="" method="post">
         <label class="heading" ><b>Edit Employee</b></label>

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
                <label class="label" style="margin-top: 8px;">Role:</label>
                <?php makeRadioRole($ar_rvbs, $role); ?>

            </div>

        
            <div class="input-text" style= "padding: -10 0; height: 30px !important;">
                <label class="label" style="margin-top: 8px;">Activity Status:</label>
                <?php makeRadioStatus($ar_rvbs2, $active); ?>

            </div>
            
            <div class="input-text">
               <input type="hidden" name="creatorid" value="<?php echo @$_SESSION['id'] ?>" placeholder="<?php echo @$_SESSION['id']; ?>" readonly>
              
            </div>
        </div>
        <input type="submit" name="submit" value="Save">
        <p class="<?php echo ($response == 'success') ? 'success-text' : 'error'; ?>">
            <?php echo $response; ?>
        </p>

    </form>
    </body>
    </html>

<?php
    $mysqli -> close();
?>