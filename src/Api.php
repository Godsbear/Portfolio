<?php
require __DIR__ . '/../config.php';
use App\Utils\HelperFunctions;
  
session_start();        //start session for declare SESSION-varible

if (isset($_POST['submit_btn']) && isset($_POST['g-recaptcha-response'])) {   
    
    // Storing google recaptcha response
    // in $recaptcha variable
    $recaptcha = $_POST['g-recaptcha-response'];
  
    // Put secret key here, which we get
    // from google console
    $secret_key = '6LcF2TogAAAAALjjO-_RzLEGMkOK1HtA6doOzkuk';
  
    // Hitting request to the URL, Google will
    // respond with success or error scenario
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;
  
    // Making request to verify captcha
    $response = file_get_contents($url);
  
    // Response return by google is in
    // JSON format, so we have to parse
    // that json
    $response = json_decode($response);
  
    // Checking, if response is true or not
    if (!$response->success == true) {
        die( header("Location: ../index.php"));
    }
}else{
    die( header("Location: ../index.php"));
}


    //condition POST is set (email and password)
if(isset($_POST["email"]) && isset($_POST["password"])){
    //call function doLogin with parameter from Form (email,password) and store return in $resp
    $resp = HelperFunctions::doLogin($_POST["email"], $_POST["password"]);
    
    //if auth. correctly
    //store users with roles in var $role
    $role = $resp["user"]["roles"];
    //set SESSION variable (can only be used if session_start())
    $_SESSION["user"] = $resp["user"];
    $_SESSION["userId"]= $resp["id"];
    $_SESSION["accessToken"] = $resp["accessToken"];
    $_SESSION["refreshToken"] = $resp["refreshToken"];
    $_SESSION["roles"] = $role;
    
    //redirect to home.php
    header("Location: /src/home.php");
    

}else{
    //if email or password is not set, exit script with Error-Messege
    die("pls enter email and password");
}
?>

