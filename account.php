<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if(isset($_POST['submit'])){
    $response = editUser($_POST['fName'], $_POST['lName'], $_POST['phone'], $_POST['email']);
 }


$mysqli = connect();
$query = 'SELECT fName, lName, phone, role FROM employees where id=?';
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
 $row = $result->fetch_assoc();

if(isset($_GET['logout'])){
    logoutEmployee();
 }

if($_SESSION["role"] != "admin"){

}

?>

<!DOCTYPE html>
<!-- This is the employee account page-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .label{
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;
            margin-top: 16px;
            padding-right: 15px;

        }

        p{
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;
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
    <label class="heading" ><b>Employee Account</b></label>

    </div>
    <form action="" method="post">

        <div class='twocolumn'>

            <div class="input-text">
                <label class="label" style="margin-top: 8px;"> First Name:</label>
                <input type="text" name="fName" value="<?php echo $row['fName']; ?>" placeholder="First Name">
            </div>

            <div class="input-text">
                <label class="label" style="margin-top: 8px;"> Last Name:</label>
                <input type="text" name="lName" value="<?php echo $row['lName']; ?>" placeholder="Last Name">
            </div>

            <div class="input-text">
                <label class="label" style="margin-top: 8px;"> Phone:</label>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>" placeholder="Phone">
            </div>

            <div class="input-text">
                <label class="label" style="margin-top: 8px;">Email:</label>
                <input type="text" name="email" value="<?php echo @$_SESSION['email']; ?>" placeholder="Email">
            </div>

        </div>

        <div class="twocolumn">

        <div class="input-text">
                <label class="label" > Employee ID:</label>
                <p> <?php echo @$_SESSION['id'] ?></p>                
        </div>
        <div class="input-text">
                <label class="label" >Role:</label>
                <p> <?php echo $row['role'] ?></p>                
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