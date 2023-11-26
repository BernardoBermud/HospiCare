<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "config.php";
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


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

function registerEmployee($fName, $lName, $phone, $email, $role, $creatorid){
    $mysqli = connect();
    // trim white space from beginning and end of every argument
    $fName = trim($fName);
    $lName = trim($lName);
    $phone = trim($phone);
    $email = trim($email);
    //$password = trim($password);
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

    //Check that Phone number is written correctly
    $pattern = '/^\d{3}-\d{3}-\d{4}$/';

    // Perform the validation using the preg_match function
    if (preg_match($pattern, $phone)) {
        $numbers = explode('-', $phone);
        $firstNumber = $numbers[0];
        $secondNumber = $numbers[1];
        $thirdNumber = $numbers[2];
    
        if (!is_numeric($firstNumber) && !is_numeric($secondNumber) && !is_numeric($thirdNumber)) {
            return 'Invalid phone number';
        }
    }
    else{
        return 'Invalid phone number format';
    }
     
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
   
   //if(strlen($password) > 255){
        //return "Password is too long";
    //}

    // encrypt password
    $password = '';
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 0; $i < 8; $i++) {
        $password .= $characters[mt_rand(0, strlen($characters) - 1)];;
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // insert employee to database
    $stmt = $mysqli->prepare("INSERT INTO employees(fName, lName, phone, email, role, password, creatorid) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $fName, $lName, $phone, $email, $role, $hashed_password, $creatorid);
    $stmt->execute();
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
        //Sending Email with username and password process
        $sent = sendEmail($password, $email);
        if(!$sent){
            $stmt = $mysqli->prepare("DELETE FROM employees WHERE email=? AND phone=?");
            $stmt->bind_param("ss", $email, $phone);
            $stmt->execute();
            return "Error Trying to send Email to user, Try again";
        }
        else{
            return "Successfully registered user";
        }
    }
} // end of the registerEmployee function.

function changePassword($oldPassword, $newPassword, $newPasswordReenter){
    if($newPassword != $newPasswordReenter){
        return "New Passwords don't match";
    }
    if(strlen($newPassword) > 255){
        return "Password is too long";
    }
    $mysqli = connect();
    $oldPassword = trim($oldPassword);
    $newPassword = trim($newPassword);

    //Check for empty Fields
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

    $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_STRING);
    $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
    

    $userid = $_SESSION['id'];
    $query="SELECT password FROM employees WHERE id=$userid";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();

    if($row == NULL){
        return "Error loading database";
    }

    if(password_verify($oldPassword, $row["password"]) == FALSE){
        return "Incorrect password";
    }
    else{
        // encrypt password
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE employees SET password=? WHERE id=?");
        $stmt->bind_param("ss", $hashed_password, $_SESSION['id']);
        $stmt->execute();
        
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
        }
        else{
            return "Your password has been successfully changed";
        }
    }


}

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
    //print($data["password"]);
    //exit(-1);
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

function sendNotification($title, $message){
    $mysqli = connect();
    $title = trim($title);
    $message = trim($message);
    print($title);
    print($message);
    print($_SESSION["id"]);

    // check all arguments have values
    
    if(empty($title) || empty($message)){
        return "All fields are required";
    }

    // check for open or closing tag characters to prevent script insertion
    if(preg_match("/([<|>])/", $title) || preg_match("/([<|>])/", $message)){
        return "<> characters are not allowed";
    }
    
    $stmt = $mysqli->prepare("INSERT INTO notifications (creatorid, title, message) VALUES (?,?,?)");
    $stmt->bind_param("sss", $_SESSION["id"], $title, $message);
    $stmt->execute();
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }
}

//used by all roles
function editUser($fName, $lName, $phone, $email){
    $mysqli = connect();
    $fName = trim($fName);
    $lName = trim($lName);
    $phone = trim($phone);
    $email = trim($email);

    $args = func_get_args();

    //Check for empty Fields
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

    //Check that Phone number is written correctly
    $pattern = '/^\d{3}-\d{3}-\d{4}$/';

    // Perform the validation using the preg_match function
    if (preg_match($pattern, $phone)) {
        $numbers = explode('-', $phone);
        $firstNumber = $numbers[0];
        $secondNumber = $numbers[1];
        $thirdNumber = $numbers[2];
    
        if (!is_numeric($firstNumber) && !is_numeric($secondNumber) && !is_numeric($thirdNumber)) {
            return 'Invalid phone number';
        }
    }
    else{
        return 'Invalid phone number format';
    }

    $stmt = $mysqli->prepare("UPDATE employees SET fName=?, lName=?, phone=?, email=? WHERE id=?");
    $stmt->bind_param("sssss", $fName, $lName, $phone, $email, $_SESSION["id"]);
    $stmt->execute();
    //print($stmt);
    //exit(-1);
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}

function activePatient($patientid){
    $mysqli = connect();
    $patientid= trim($patientid);
    
    //Check for current active value of patient

    $query="SELECT * FROM patients WHERE id=$patientid";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();

    //In case that someone deleted patient while another is still in the page
    if(empty($patientid)){
        return "patient id not found";
    }
    if($row['active'] == 1){
        $stmt = $mysqli->prepare("UPDATE patients SET active=0 WHERE id=?");
    }
    else{
        $stmt = $mysqli->prepare("UPDATE patients SET active=1 WHERE id=?");
    }
    $stmt->bind_param("s", $patientid);
    $stmt->execute();
    print(stmt);
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}

function activeEmployee($employeeid){
    $mysqli = connect();
    $employeeid= trim($employeeid);
    
    //Check for current active value of patient

    $query="SELECT * FROM employees WHERE id=$employeeid";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();

    //In case that user wants to self activate or deactivate.
    if($row[id] == $_SESSION["id"]){
        return "Eroor: Unable to self activate or deactivate, please ask for other admin to do so";
    }

    //In case that someone deleted patient while another is still in the page
    if(empty($employeeid)){
        return "Employee id not found";
    }
    if($row['active'] == 1){
        $stmt = $mysqli->prepare("UPDATE employees SET active=0 WHERE id=?");
    }
    else{
        $stmt = $mysqli->prepare("UPDATE employees SET active=1 WHERE id=?");
    }
    $stmt->bind_param("s", $employeeid);
    $stmt->execute();
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}

function editEmployee($employeeid, $fName, $lName, $phone, $email, $role){
    $mysqli = connect();
    $employeeid = trim($employeeid);
    $fName = trim($fName);
    $lName = trim($lName);
    $phone = trim($phone);
    $email = trim($email);
    $role = trim($role);

    $args = func_get_args();

    //Check for empty Fields
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

    //Check that Phone number is written correctly
        /* INSERT CODE*/
    $pattern = '/^\d{3}-\d{3}-\d{4}$/';

    // Perform the validation using the preg_match function
    if (preg_match($pattern, $phone)) {
        $numbers = explode('-', $phone);
        $firstNumber = $numbers[0];
        $secondNumber = $numbers[1];
        $thirdNumber = $numbers[2];
    
        if (!is_numeric($firstNumber) && !is_numeric($secondNumber) && !is_numeric($thirdNumber)) {
            return 'Invalid phone number';
        }
    }
    else{
        return 'Invalid phone number format';
    }

    $stmt = $mysqli->prepare("UPDATE employees SET fName=?, lName=?, phone=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("ssssss", $fName, $lName, $phone, $email, $role, $employeeid);
    $stmt->execute();
    //print($stmt);
    //exit(-1);
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}


function addRecord($patientid, $visitDate, $diagnosis, $description, $visitType, $insurance, $servicePay, $amountPayed){
    $mysqli = connect();
    $patientid = trim($patientid);
    $visitDate = trim($visitDate);
    $diagnosis = trim($diagnosis);
    $description = trim($description);
    $visitType = trim($visitType);
    $insurance = trim($insurance);
    $servicePay = trim($servicePay);
    $amountPayed = trim($amountPayed);

    $args = func_get_args();

    //Check for empty Fields
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

    $stmt = $mysqli->prepare("INSERT INTO records (patientid, creatorid, visitDate, diagnosis, description,  visitType, insurance, servicePay, amountPayed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $patientid, $_SESSION['id'], $visitDate, $diagnosis, $description, $visitType, $insurance, $servicePay, $amountPayed);
    $stmt->execute();
    //print($stmt);
    //exit(-1);
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}

function addPrescription($patientid, $recordid, $medicine, $dosage, $frequency, $description, $startDate, $endDate){
    $mysqli = connect();
    $patientid = trim($patientid);
    $recordid = trim($recordid);
    $medicine = trim($medicine);
    $dosage = trim($dosage);
    $frequency = trim($frequency);
    $description = trim($description);
    $endDate= trim($endDate);
    $startDate= trim($startDate);

    $args = func_get_args();

    //Check for empty Fields
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

    //Check that the starting date is not after the end date or viceversa
        /* YOUR CODE HERE*/

    $stmt = $mysqli->prepare("INSERT INTO prescriptions (patientid, doctorid, recordid, medicine, dosage, frequency, description, startDate, endDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $patientid, $_SESSION['id'], $recordid, $medicine, $dosage, $frequency, $description, $startDate, $endDate);
    $stmt->execute();
    //print($stmt);
    //exit(-1);
    
    if($stmt->affected_rows != 1){
      return "An error occurred. Please try again";
    }
   else{
      return "success";
    }   
}

function sendEmail($password, $email){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hospicare.mail@gmail.com';
    $mail->Password = 'muqmlfhjvdfjmcqc';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('hospicare.mail@gmail.com');

    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = "New Hospicare Account Information";
    $mail->Body = '<pre>'. "Welcome to your new hospicare account. ". '<pre>'. '<pre>'. 
    "Use the following information to log into your account:". '<pre>'.
    "Username: ". $email. '<pre>'. "Password: ". $password. '<pre>'."If any doubt about the legitimacy 
    of this message, please contact the following email: ". $_SESSION["email"];

    if ($mail->send()) {
        //return 'Email sent successfully.';
        return true;
    } else {
        //return 'Email sending failed. Error: ' . $mail->ErrorInfo;
        return false;
    }
}


function logoutEmployee(){
    session_destroy();
    header("location: login.php");
    exit();
 }
?>