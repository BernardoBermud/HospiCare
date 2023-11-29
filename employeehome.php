<?php

require "functions.php";

if(!(isset($_SESSION["id"])))
{
    header("Location: login.php");
}

$mysqli = connect();

if(isset($_GET['logout'])){
    logoutEmployee();
 }

 if($_SESSION["role"] == "admin"){
    header("Location: adminhome.php");
 }

if(isset($_GET['employee'])){
    header("Location: editemployee.php");
}

?>

<!DOCTYPE html>
<!-- This is home page for admins-->
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
        </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="?logout"><b>Log out</b> </a>
        <a href="account.php"><b>Account</b> </a>

    </div>

    <label class="heading" ><b>Dashboard</b></label>

    <div class="threecolumn">
        <form action="" method="GET">
            <div class="search-container">
                <input type="text" placeholder="Search Patient" name="search1" value="<?php if(isset($_GET['search1'])){echo $_GET['search1']; } ?>" class="form-control">
                <button type="submit" class="fa fa-search"></button>
            </div>
        </form>
        <table cellspacing="0" cellpadding="0"  width="425">
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px" width="400">
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:425px; height:200px; overflow-y:auto;">
                    <table cellspacing="0" cellpadding="1" width="400" style="margin-left: 8px;">
                    <?php 
                        $filtervalues = $_GET['search1'];
                        $query = "SELECT id, fName, lName, phone FROM patients WHERE active=1 AND CONCAT(id,fName,lName) LIKE '%$filtervalues%' ";
                        $query_run = mysqli_query($mysqli, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_array($query_run,MYSQLI_ASSOC)) {
                                print "<tr><td>";
                                print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["fName"].'</a>';
                                print " ";
                                print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["lName"].'</a>';                                            
                                print "</td><td>";
                                print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["phone"].'</a>';
                                print "</td></tr>";
                            }
                        }
                        else
                        {
                            ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                            <?php
                        }
                    ?>
                    </table>  
                </div>
                </td>
            </tr>
        </table>
    </div>


    <div class="threecolumn">
        <form action="" method="GET">
            <div class="search-container" style="text-align: center;">
                <input type="text" placeholder="Search Employee" name="search2" value="<?php if(isset($_GET['search2'])){echo $_GET['search2']; } ?>" class="form-control">
                <button type="submit" class="fa fa-search"></button>
            </div>
        </form>
        <table cellspacing="0" cellpadding="0"  width="425">
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px" width="400"  >
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Role</th>
                            <th>Phone Number</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:425px; height:200px; overflow-y:auto;">
                    <table cellspacing="0" cellpadding="1" width="400"  >
                    <?php 
                        $filtervalues = $_GET['search2'];
                        $query = "SELECT id, fName, lName, role, phone FROM employees WHERE active=1 AND CONCAT(fName,lName, role) LIKE '%$filtervalues%' ";
                        $query_run = mysqli_query($mysqli, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_array($query_run,MYSQLI_ASSOC)) {
                                print "<tr><td>";
                                print '<a href="viewemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["fName"].'</a>';
                                print " ";
                                print '<a href="viewemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["lName"].'</a>';
                                print "</td><td>";
                                print '<a href="viewemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["role"].'</a>';
                                print "</td><td>";
                                print '<a href="viewemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["phone"].'</a>';
                                print "</td></tr>";
                            }
                        }
                        else
                        {
                            ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                            <?php
                        }
                    ?>
                    </table>  
                </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="threecolumn">
        <form action="" method="GET">
            <div class="search-container" style="text-align: center;">
                <input type="text" placeholder="Search Notification" name="search3" required value="<?php if(isset($_GET['search3'])){echo $_GET['search3']; } ?>" class="form-control">
                <button type="submit" class="fa fa-search"></button>
            </div>
        </form>
        <table cellspacing="0" cellpadding="0"  width="425">
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px 5px" width="400" style="padding-left:10px;" >
                        <tr>
                            <th>Title</th>
                            <th>Sent Date</th>
                            <th></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:425px; height:200px; overflow-y:auto;">
                        <table cellspacing="0" cellpadding="1" width="400" style="margin-left: 8px;" >
                            <?php 
                                $filtervalues = $_GET['search3'];
                                $query = "SELECT id, sentDate, title, message FROM notifications WHERE CONCAT(id,sentDate,title) LIKE '%$filtervalues%' ";
                                $query_run = mysqli_query($mysqli, $query);

                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    while($row = mysqli_fetch_array($query_run,MYSQLI_ASSOC)) {
                                        print "<tr><td>";
                                        print '<a href="viewnotif.php?id='.$row['id'].'&sentDate='.$row['sentDate'].'&title='.$row['title'].'&message='.$row['message'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["title"].'</a>';
                                        print "</td><td>";
                                        print '<a href="viewnotif.php?id='.$row['id'].'&sentDate='.$row['sentDate'].'&title='.$row['title'].'&message='.$row['message'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["sentDate"].'</a>';
                                        print "</td></tr>";
                                    }
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="4">No Record Found</td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </table>  
                    </div>
                </td>
            </tr>
        </table>
    </div>
