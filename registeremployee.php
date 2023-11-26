<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if(isset($_POST['submit'])){
    $response = registerEmployee($_POST['fName'], $_POST['lName'], $_POST['phone'], $_POST['email'], $_POST['role'], $_POST['creatorid']);
 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }
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
        <h1>Register Employee</h1>

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
             <label class="label">Role</label>

                    <select id="role" name="role" value="<?php echo @$_POST['role']; ?>">
                    <option value="nurse">nurse</option>
                    <option value="doctor">doctor</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <div class="input-text" style= "padding: -10 0; height: 30px !important;">
            
            <div class="input-text">
               <input type="hidden" name="creatorid" value="<?php echo @$_SESSION['id'] ?>" placeholder="<?php echo @$_SESSION['id']; ?>" readonly>
              
            </div>
        </div>
        <input type="submit" name="submit" value="Log In">
   <p class="error" style=><?php echo @$response; ?></p>
    </form>
    </html>
