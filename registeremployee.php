<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if(isset($_POST['submit'])){
    if(!(isset($_POST['role']))){
        $response= "All fields are required";
    }
    else{
    $response = registerEmployee($_POST['fName'], $_POST['lName'], $_POST['phone'], $_POST['email'], $_POST['role'], $_POST['creatorid']);
    if($response == "success") header("Location: adminhome.php");
    }
}

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $ar_rvbs = ["nurse", "doctor", "admin"];
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
    <label class="heading" ><b>Register Employee</b></label>

        <div class="twocolumn">
            <div class="input-text">
                <input type="text" name="fName" value="<?php echo @$_POST['fName']; ?>" placeholder="First Name">
            </div>
            <div class="input-text">
                <input type="text" name="lName" value="<?php echo @$_POST['lName']; ?>" placeholder="Last Name">
            </div>
            <div class="input-text">
                <input type="text" name="phone" value="<?php echo @$_POST['phone']; ?>" placeholder="Phone Number">
            </div>
            <div class="input-text">
                <input type="text" name="email" value="<?php echo @$_POST['email']; ?>" placeholder="Email">
            </div>
        </div>
        <div class="twocolumn">
             <div class="input-text" style= "padding: -10 0; height: 30px !important;">
             <label class="label" style="margin-top: 8px;">Role:</label>
                <?php
                    foreach ($ar_rvbs as $value)
                    {
                    $checked = '';                          
                    echo '<label class="label2">'.$value.'</label>';
                    echo '<input type="radio" name = "role" value = "'.$value.'" >';
                    }
                ?>

            </div>
            
            <div class="input-text">
               <input type="hidden" name="creatorid" value="<?php echo @$_SESSION['id'] ?>" placeholder="<?php echo @$_SESSION['id']; ?>" readonly>
              
            </div>
        </div>
        <input type="submit" name="submit" value="Register">
   <p class="error" style=><?php echo @$response; ?></p>
    </form>
    </body>
    </html>