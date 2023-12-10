<?php

require "functions.php";


if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

if($_SESSION["role"] == "doctor"){
    header("Location: viewrecorddoctor.php?patientid={$_GET['patientid']}&recordid={$_GET['recordid']}&fName={$_GET['fName']}&lName={$_GET['lName']}");

 }

 if(isset($_GET['logout'])){
    logoutEmployee();
 }

 $mysqli = connect();

 $recordid = $_GET['recordid'];
 $patientquery = "SELECT * FROM records WHERE id = $recordid";
 $result = $mysqli->query($patientquery);
 $row = $result->fetch_assoc();

 $visitDate = $row['visitDate'];
 $diagnosis = $row['diagnosis'];
 $description = $row['description'];
 $visitType = $row['visitType'];
 $insurance = $row['insurance'];
 $servicePay = $row['servicePay'];
 $amountPaid = $row['amountPaid'];


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
            height: 200px; /* Adjust the height as needed */
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
        <a href="adminhome.php"><b>Back</b></a>
       <!--- <a href="viewpatient.php?patientid=<?php/// echo $_GET['patientid'] ?>&recordid=<?php ///echo $_GET['recordid'] ?>&fName=<?php/// echo $_GET['fName'] ?>&lName=<?php/// echo $_GET['lName'] ?>"><b>Back</b> </a> --->
    </div>

    <form action="" method="get">
    <label class="heading" ><b>Record Info</b></label>

        <div class="threecolumn">
            <h2>Visit Date: <?php echo $visitDate; ?></h2>
            <h2>Diagnosis: <?php echo $diagnosis; ?></h2>
            <h2>Visit Type: <?php echo $visitType; ?></h2>
            <h2>Insurance: <?php echo $insurance; ?></h2>
            <h2>Service Pay: <?php echo $servicePay; ?></h2>
            <h2>Amount Paid: <?php echo $amountPaid; ?></h2>
            <h2>Description:</h2>
            <form class="input-text"> 
            <textarea readonly rows="10" cols="50">
                <?php 
                    echo $description; 
                ?>
            </textarea>

        </div>

        </div>
        <div class="threecolumn">

            <table cellspacing="0" cellpadding="0"  width="600" margin-top='0'>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px" width="600">
                        <tr>
                            <th style="padding-left: 0px;">Medicine</th>
                            <th style="padding-right: 100px;">Dosage</th>
                            <th style="padding-right: 100px;">Start Date</th>
                            <th style="padding-right: 50px;">End Date</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:800px; height:250px; overflow-y:auto;">
                    <table cellspacing="5" cellpadding="1" width="600" style="margin-left: 8px;">
                    <?php 
                    
                        $query="SELECT * FROM prescriptions WHERE recordid=$recordid"; 
                        $result = mysqli_query($mysqli,$query);
                        
                        //Verificar si hubo error y si hubo imprimirlo
                        if (!$result) {
                            die("Invalid Query: " . mysqli_error($mysqli));
                        }
                        
                        // Imprimo la información obtenida de la base de datos
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            print "<tr><td style='margin-left: 10px;'>";
                            print '<a href="viewprescription.php?id='.$row['id'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["medicine"].'</a>';
                            print "</td><td style='margin-left: 40px;'>";
                            print '<a href="viewprescription.php?id='.$row['id'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["dosage"].'</a>';
                            print "</td><td style='padding-left: 40px;'>";
                            print '<a href="viewprescription.php?id='.$row['id'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["startDate"].'</a>';
                            print "</td><td style='padding-left: 40px;'>";
                            print '<a href="viewprescription.php?id='.$row['id'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["endDate"].'</a>';
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