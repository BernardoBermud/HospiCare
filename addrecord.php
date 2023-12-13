<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

///echo $_GET['id'];
$mysqli = connect();

if(isset($_GET['logout'])){
    logoutEmployee();
 }

 if($_SESSION["role"] != "admin"){
    header("Location: employeehome.php");
 }

 if(isset($_POST['submit'])){
    $response = addRecord($_GET['id'], $_POST['visitDate'], $_POST['diagnosis'], $_POST['description'], $_POST['visitType'], $_POST['insurance'], $_POST['servicePay'], $_POST['amountPaid']);
    if($response == "success") header("Location: editpatient.php?id={$_GET['id']}&fName={$_GET['fName']}&lName={$_GET['lName']}");
 }

?>

<!DOCTYPE html>
<!-- This is add record page-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        table {
            margin-top: 10px;
            font-family: Arial, Helvetica, sans-serif;
            color: #19297c;
            padding-left: 5%;
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
        <a href="account.php"><b>Account</b> </a>

        <a  href="editpatient.php?id=<?php echo $_GET['id'] ?>&fName=<?php echo $_GET['fName'] ?>&lName=<?php echo $_GET['lName'] ?>"><b>Back</b> </a>

    </div>

    <form action="" method="post">
    <label class="heading" ><b>Add Patient Record</b></label>

    

        <div class="threecolumn">
            <div class="input-text">
                <input type="date" name="visitDate" value="<?php echo @$_POST['visitDate']; ?>" placeholder="Visit Date (YYYY-MM-DD)">
            </div>
            <div class="input-text">
                <input type="text" name="diagnosis" value="<?php echo @$_POST['diagnosis']; ?>" placeholder="Diagnosis">
            </div>
            <div class="input-text">
                <input type="text" name="visitType" value="<?php echo @$_POST['visitType']; ?>" placeholder="Visit Type">
            </div>
        </div>

        <div class="threecolumn">
            <div class="input-text"> 
            <textarea type="text" class="form-control" style="margin-right: 100px;" name="description" value="<?php echo @$_POST['description']; ?>" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="threecolumn">
            <div class="input-text">
                <input type="text" name="insurance" value="<?php echo @$_POST['insurance']; ?>" placeholder="Insurance">
            </div>

            <div class="input-text">
                <input type="text" name="servicePay" value="<?php echo @$_POST['servicePay']; ?>" placeholder="Cost of Service">
            </div>

            <div class="input-text">
                <input type="text" name="amountPaid" value="<?php echo @$_POST['amountPaid']; ?>" placeholder="Amount Paid">
            </div>
        </div>

        <input type="submit" style="margin-top: 70px;"name="submit" value="Add">
        <p class="error" style=><?php echo @$response; ?></p>
    </form>
    </body>
    </html>
<!--
    <?php
        //$mysqli -> close();
    ?>
    -->