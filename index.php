<?php 
    include("functions.php");
    $mysqli = connect();
    $query="SELECT * FROM employees";
	$result = mysqli_query($mysqli,$query);
    while($row = mysqli_fetch_assoc($result))
	{
        //Columnas de cada fila
        print ($row['id'] . " ");
		print ($row['fName'] . " ");
        print ($row['lName'] . " ");
        print ($row['phone'] ." ");
        print ($row['email'] ." ");
        print ($row['role'] ."\n");
	}
    print("Hellooooo");
?>


<!DOCTYPE html>
<!-- This is the main page before logging in-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
<!-- The .txt style is for the message that will be displayed in the middle of the page -->
    <style>
        .txt {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            color: #19297c;
            height: 500px;
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="login.php"><b>Log In</b> </a>

    </div>

    <div class="txt"><b>Welcome to the Hospicare System!</b></div>
</body>
</html>