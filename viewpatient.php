<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] == "admin"){
    header("Location: editpatient.php");
 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();
 $patientid = $_GET['patientid'];
 $query = "SELECT * FROM patients where id = $patientid";
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();

 $phone = $row['phone'];
 $email = $row['email'];
$active = $row['active'];
$fName = $row['fName'];
$lName = $row['lName'];

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

        table {
    margin-top: 0px;
    font-family: Arial, Helvetica, sans-serif;
    color: #19297c;
    padding-left: 5%;
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

    <form action="" method="get">
    <label class="heading" ><b>Patient Info</b></label>
        <div class="threecolumn">
            <h2>Name: <?php echo @$_GET['fName']. " ". @$_GET['lName']; ?></h2>
            <h2>Phone: <?php echo $phone; ?></h2>
            <h2>Email: <?php echo $email; ?></h2>
        </div>
        <div class="threecolumn">

            <table cellspacing="0" cellpadding="0"  width="325" margin-top='0'>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px" width="400">
                        <tr>
                            <th style="padding-left: 30px;">Date</th>
                            <th style="padding-left: 50px;">Visit Type</th>
                            <th style="padding-right: 30px;">Diagnosis</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:425px; height:250px; overflow-y:auto;">
                    <table cellspacing="5" cellpadding="1" width="350" style="margin-left: 8px;">
                    <?php 
                        $query="SELECT id, visitDate, visitType, diagnosis FROM records WHERE patientid=$patientid"; 
                        $result = mysqli_query($mysqli,$query);
                        
                        //Verificar si hubo error y si hubo imprimirlo
                        if (!$result) {
                            die("Invalid Query: " . mysqli_error($mysqli));
                        }
                        
                        // Imprimo la información obtenida de la base de datos
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            print "<tr><td >";
                            print '<a href="viewrecord.php?patientid='.$patientid.'&recordid='.$row['id'].'&fName='.$fName.'&lName='.$lName.'&visitDate='.$row['visitDate'].'&visitType='.$row['visitType'].'&diagnosis='.$row['diagnosis'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["visitDate"].'</a>';
                            print "</td><td style='margin-left: 20px;'>";
                            print '<a href="viewrecord.php?patientid='.$patientid.'&recordid='.$row['id'].'&fName='.$fName.'&lName='.$lName.'&visitDate='.$row['visitDate'].'&visitType='.$row['visitType'].'&diagnosis='.$row['diagnosis'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["visitType"].'</a>';
                            print "</td><td style='padding-left: 5px;'>";
                            print '<a href="viewrecord.php?patientid='.$patientid.'&recordid='.$row['id'].'&fName='.$fName.'&lName='.$lName.'&visitDate='.$row['visitDate'].'&visitType='.$row['visitType'].'&diagnosis='.$row['diagnosis'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["diagnosis"].'</a>';
                            print "</td></tr>";
                            }

                        }
                    ?>
                    </table>  
                </div>
                </td>
            </tr>
        </table>
            
        </div>

    </form>
    </body>
    </html>

    <?php
        $mysqli -> close();
     ?>