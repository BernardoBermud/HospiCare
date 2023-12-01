<?php
    require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] == "nurse" or $_SESSION["role"] == "admin"){
    header("Location: viewrecord.php");
 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();

 if(isset($_POST['submit'])){
    $response = addPrescription($_GET['patientid'], $_GET['recordid'], $_POST['medicine'], $_POST['dosage'], $_POST['frequency'], $_POST['description'], $_POST['startDate'], $_POST['endDate']);
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
        </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="?logout"><b>Log out</b> </a>
        <a href="account.php"><b>Account</b> </a>

        <a href="viewrecorddoctor.php?patientid=<?php echo $_GET['patientid'] ?>&recordid=<?php echo $_GET['recordid'] ?>&fName=<?php echo $_GET['fName'] ?>&lName=<?php echo $_GET['lName'] ?>"><b>Back</b> </a>
    </div>

    <form action="" method="post">
    <label class="heading" ><b>Add Prescription</b></label>

    

        <div class="threecolumn">
            <div class="input-text">
                <input type="text" name="medicine" value="<?php echo @$_POST['medicine']; ?>" placeholder="Medicine">
            </div>
            <div class="input-text">
                <input type="text" name="dosage" value="<?php echo @$_POST['dosage']; ?>" placeholder="Dosage">
            </div>
            <div class="input-text">
                <input type="text" name="frequency" value="<?php echo @$_POST['frequency']; ?>" placeholder="Frequency">
            </div>
        </div>

        <div class="threecolumn">
            <div class="input-text"> 
            <textarea type="text" class="form-control" style="margin-right: 100px;" name="description" value="<?php echo @$_POST['description']; ?>" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="threecolumn">
            <div class="input-text">
                <input type="text" name="startDate" value="<?php echo @$_POST['startDate']; ?>" placeholder="Start Date (YYYY-MM-DD)">
            </div>

            <div class="input-text">
                <input type="text" name="endDate" value="<?php echo @$_POST['endDate']; ?>" placeholder="End Date (YYYY-MM-DD)">
            </div>
        </div>

        <input type="submit" style="margin-top: 70px;"name="submit" value="Add">
        <p class="error" style=><?php echo @$response; ?></p>
    </form>
    </body>
    </html>

    <?php
        $mysqli -> close();
    ?>