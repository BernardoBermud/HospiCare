<?php

require "config.php";

function connect(){
    $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
    
    if($mysqli->connect_errno != 0){
      $error = $mysqli->connect_error;
      $error_date = date("F j, Y, g:i a");
      $message = "{$error} | {$error_date} \r\n";
      file_put_contents("db-log.txt", $message, FILE_APPEND);
      return false;
    }
    else{
        $mysqli->set_charset("utf8mb4");
        return $mysqli;	
    } // end of if statement.
} // end of the connect function.

function registerEmployee($fName, $lName, $phone, $email, $role, $active, $password, $creatorid){
    $mysqli = connect();

    // trim white space from beginning and end of every argument
    $fName = trim($fName);
    $lName = trim($lName);
    $phone = trim($phone);
    $email = trim($email);
    $password = trim($password);
    $creatorid = trim($creatorid);

    // check all arguments have values
    $args = func_get_args();

    foreach ($args as $value) {
       if(empty($value)){
          return "All fields are required";
       }
    }

    // check for open or closing tag characters to prevent script insertion
    foreach ($args as $value) {
        if(preg_match("/([<|>])/", $value)){
           return "<> characters are not allowed";
        }
    }
// CHECK NAME IS STRING
// CHECK PHONE IS INT
     
     // check email is valid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return "Email is not valid";
    }

     // check if email is already in database
    $stmt = $mysqli->prepare("SELECT email FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if($data != NULL){
        return "Email already exists, please use a different email";
    }	

   // check if phone is already in database
   $stmt = $mysqli->prepare("SELECT phone FROM employees WHERE phone = ?");
   $stmt->bind_param("s", $phone);
   $stmt->execute();
   $result = $stmt->get_result();
   $data = $result->fetch_assoc();
   if($data != NULL){
      return "Phone number already exists, please use a different phone number";
    }
   
   if(strlen($password) > 255){
        return "Password is too long";
    }

    // encrypt password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // insert employee to database
    $stmt = $mysqli->prepare("INSERT INTO employees(fName, lName, phone, email, role, active, password, creatorid) VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssisi", $fName, $lName, $phone, $email, $role, $active, $hashed_password, $creatorid);
    $stmt->execute();
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";			
    }
} // end of the registerEmployee function.

function loginEmployee($email, $password){
    $mysqli = connect();
    $username = trim($email);
    $password = trim($password);

    if($email == "" || $password == ""){
        return "Both fields are required";
    }
 
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return "Email is not valid";
    }

    $sql = "SELECT id, email, password, role FROM employees WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
 
    if($data == NULL){
        return "Wrong username or password";
    }

    if(password_verify($password, $data["password"]) == FALSE){
        return "Wrong username or password";
    }
    else{
        $_SESSION["email"] = $email;
        $_SESSION["id"] = $data["id"];
        $_SESSION["role"] = $data["role"];


        if($data["role"] == "admin"){
            header("location: adminhome.php");
        }
        else{
            header("location: employeehome.php");
        }
        exit();
    }
} // end of loginEmployee function.

function getCreatorID($email){
    $sql = "SELECT id FROM employees WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

}

function logoutEmployee(){
    session_destroy();
    header("location: login.php");
    exit();
 }
?>