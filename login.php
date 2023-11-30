<?php

require "functions.php";

if(isset($_POST['submit'])){
    $response = loginEmployee($_POST['email'], $_POST['password']);
 }

?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
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
        </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="hospicarelogo.png">
        </div>
        <a href="index.php"><b>Back</b> </a>

    </div>
    <form action="" method="post">
    <label class="heading" ><b>Insert Credentials</b></label>
        <div class="input-text">
            <input type="text" name="email" value="<?php echo @$_POST['email']; ?>" placeholder="Email">
        </div>
        <div class="input-text">
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <input type="submit" name="submit" value="Log In">
   <p class="error" style=><?php echo @$response; ?></p>
    </form>

    <!--Code sampled from https://digitalfox-tutorials.com/tutorial.php?title=Coding-a-secure-login-system-with-php-and-mysql-->
</body>
</html>