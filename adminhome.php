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

?>

<!DOCTYPE html>
<!-- This is home page for admins-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

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
        <div class="search-container" style="text-align: center;">
          <input type="text" placeholder="Search Patient" name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; color: #19297c;">
            <thead class="thead-light"><br><br><br>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
        </table>

        <div class="form-group" style="display: flex; justify-content: center;">
            <a class="button" href=""><b>Register Patient</b></a>
        </div>
    </div>

    <div class="threecolumn">
        <div class="search-container" style="text-align: center;">
            <input type="text" placeholder="Search Employee" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; color: #19297c;">
            <thead class="thead-light"><br><br><br>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
              </tr>
             </thead>
             <tbody>
        <?php
                   
            //Query para seleccionar toda la información encesaria que quier desplegar en la tabla de las ordenes
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
		        print $row['id'];
		        print "</td><td>";
                print $row['fName'];
		        print "</td><td>";
                print $row['lName'];
                }
            }
            ?>
            </tbody>
            </table>
            <div class="form-group" style="display: flex; justify-content: center;">
                <a class="button" href="registeremployee.php"><b>Register Employee</b></a>
           </div>
    </div>
    <div class="threecolumn">
        <div class="search-container" style="text-align: center;">
            <input type="text" placeholder="Search Notification" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; color: #19297c;">
            <thead class="thead-light"><br><br><br>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Date</th>
              </tr>
             </thead>
            </table>
            <div class="form-group" style="display: flex; justify-content: center;">
                <a class="button" href="functionTest.php"><b>Send Notification</b></a>
           </div>
    </div>

</body>
</html>