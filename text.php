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

 if($_SESSION["role"] != "admin"){
    header("Location: employeehome.php");
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

    <label class="heading" ><b>Admin Dashboard</b></label>

    <div class="threecolumn">
        <form action="" method="GET">
            <div class="search-container" style="text-align: center;">
                <input type="text" placeholder="Search Patient" name="search1" required value="<?php if(isset($_GET['search1'])){echo $_GET['search1']; } ?>" class="form-control">
                <button type="submit" class="fa fa-search"></button>
            </div>
        </form>
        <table cellspacing="0" cellpadding="0"  width="425">
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="5px" width="400"  >
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th></th>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:425px; height:200px; overflow-y:auto;">
                    <table cellspacing="0" cellpadding="1" width="400" style="text-align:center;" >
                    <?php 
                            if(isset($_GET['search1']))
                                {
                                    $filtervalues = $_GET['search1'];
                                    $query = "SELECT id, fName, lName FROM patients WHERE CONCAT(id,fName,lName) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($mysqli, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $items)
                                        {
                                            ?>
                                                <tr>
                                                    <td><a href="editpatient.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['id']; ?></a></td>
                                                    <td><a href="editpatient.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['fName']; ?></a></td>
                                                    <td><a href="editpatiend.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['lName']; ?></a></td>
                                                </tr>
                                            <?php
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
                                }
                                else{
                                    $query="SELECT id, fName, lName from patients"; 
                                    $result = mysqli_query($mysqli,$query);
                                    
                                    //Verificar si hubo error y si hubo imprimirlo
                                    if (!$result) {
                                        die("Invalid Query: " . mysqli_error($mysqli));
                                    }
                                    
                                    // Imprimo la información obtenida de la base de datos
                                    if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                        print "<tr><td>";
                                        print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["id"].'</a>';
                                        print "</td><td>";
                                        print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["fName"].'</a>';
                                        print "</td><td>";
                                        print '<a href="editpatient.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["lName"].'</a>';
                                        print "</td></tr>";
                                        }

                                    }
                                }
                        ?>
                    </table>  
                </div>
                </td>
            </tr>
        </table>
        <div class="form-group" style="display: flex; justify-content: center;">
                <a class="button" href="registerpatient.php" style="margin-top: 30px;"><b>Register Patient</b></a>
        </div>
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
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th></th>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <div style="width:425px; height:200px; overflow-y:auto;">
                    <table cellspacing="0" cellpadding="1" width="400" style="text-align:center;" >
                    <?php 
                            if(isset($_GET['search2']))
                                {
                                    $filtervalues = $_GET['search2'];
                                    $query = "SELECT id, fName, lName FROM employees WHERE CONCAT(id,fName,lName) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($mysqli, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $items)
                                        {
                                            ?>
                                                <tr>
                                                    <td><a href="editemployee.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['id']; ?></a></td>
                                                    <td><a href="editemployee.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['fName']; ?></a></td>
                                                    <td><a href="editemployee.php?id='.$items['id'].'&fName='.$items['fName'].'&lName='.$items['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['lName']; ?></a></td>
                                                </tr>
                                            <?php
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
                                }
                                else{
                                    $query="SELECT id, fName, lName from employees"; 
                                    $result = mysqli_query($mysqli,$query);
                                    
                                    //Verificar si hubo error y si hubo imprimirlo
                                    if (!$result) {
                                        die("Invalid Query: " . mysqli_error($mysqli));
                                    }
                                    
                                    // Imprimo la información obtenida de la base de datos
                                    if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                        print "<tr><td>";
                                        print '<a href="editemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["id"].'</a>';
                                        print "</td><td>";
                                        print '<a href="editemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["fName"].'</a>';
                                        print "</td><td>";
                                        print '<a href="editemployee.php?id='.$row['id'].'&fName='.$row['fName'].'&lName='.$row['lName'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["lName"].'</a>';
                                        print "</td></tr>";
                                        }

                                    }
                                }
                        ?>
                    </table>  
                </div>
                </td>
            </tr>
        </table>
        <div class="form-group" style="display: flex; justify-content: center;">
                <a class="button" href="registeremployee.php" style="margin-top: 30px;"><b>Register Employee</b></a>
        </div>
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
                            <th>ID</th>
                            <th>Sent Date</th>
                            <th>Title</th>
                            <th></th>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:425px; height:200px; overflow-y:auto;">
                        <table cellspacing="0" cellpadding="1" width="400" style="text-align:center; margin-left: 8px;" >
                            <?php 
                                if(isset($_GET['search3']))
                                {
                                    $filtervalues = $_GET['search3'];
                                    $query = "SELECT id, sentDate, title FROM notifications WHERE CONCAT(id,sentDate,title) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($mysqli, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $items)
                                        {
                                            ?>
                                                <tr>
                                                    <td><a href="viewnotif.php?id='.$items['id'].'&sentDate='.$items['sentDate'].'&title='.$items['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['id']; ?></a></td>
                                                    <td><a href="viewnotif.php?id='.$items['id'].'&sentDate='.$items['sentDate'].'&title='.$items['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['sentDate']; ?></a></td>
                                                    <td><a href="viewnotif.php?id='.$items['id'].'&sentDate='.$items['sentDate'].'&title='.$items['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><?= $items['title']; ?></a></td>
                                                </tr>
                                            <?php
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
                                }
                                else{
                                    $query="SELECT id, sentDate, title from notifications"; 
                                    $result = mysqli_query($mysqli,$query);
                                            
                                    //Verificar si hubo error y si hubo imprimirlo
                                    if (!$result) {
                                        die("Invalid Query: " . mysqli_error($mysqli));
                                    }
                                            
                                    // Imprimo la información obtenida de la base de datos
                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                            print "<tr><td>";
                                            print '<a href="viewnotif.php?id='.$row['id'].'&sentDate='.$row['sentDate'].'&title='.$row['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["id"].'</a>';
                                            print "</td><td>";
                                            print '<a href="viewnotif.php?id='.$row['id'].'&sentDate='.$row['sentDate'].'&title='.$row['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["sentDate"].'</a>';
                                            print "</td><td>";
                                            print '<a href="viewnotif.php?id='.$row['id'].'&sentDate='.$row['sentDate'].'&title='.$row['title'].'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">'.$row["title"].'</a>';
                                            print "</td></tr>";
                                        }

                                    }
                                }
                            ?>
                        </table>  
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-group" style="display: flex; justify-content: center;">
                <a class="button" href="functionTest.php" style="margin-top: 30px;"><b>Send Notification</b></a>
        </div>
    </div>
