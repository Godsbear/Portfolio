<?php

function doRegister($name, $email, $password)
{   // url for server request  --> authentication and token generation
    $url = "https://fb-dev-gateway.herokuapp.com/iam/user";  

    // require PHP cURL extension  (https://faq.miniorange.com/knowledgebase/enable-php-curl-extension-2/)
    // set up POST-request with json-type
    $curl = curl_init($url);    //start curl-session
    //curl_setopt add options to curl
    curl_setopt($curl, CURLOPT_URL, $url);  //url for server request
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));    //add array with parameter
    curl_setopt($curl, CURLOPT_POST, true);  //send POST request
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //convert reply to string
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(["name" => $name, "email" => $email, "password" => $password]));  //data to use for POST request
    
    //store the reply in var $resp
    $resp = curl_exec($curl);
    // close curl-session
    curl_close($curl);
    //decode $resp from json-type to php-type (object) and return $resp
    return json_decode($resp,true);
}

    //condition POST is set (email and password)
if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["passwordRepeat"])){
    //call function doLogin with parameter from Form (email,password) and store return in $resp
    if($_POST["password"] == $_POST["passwordRepeat"]){
    $resp = doRegister($_POST["name"], $_POST["email"], $_POST["password"]);
    
        if(isset($resp["code"])){
                header("Location: register.php");
            
        }else{
            header("Location: ../index.php");
        }

    }else{
        die("Passord not match");
    }
}else{
    die("Formular unvolständig");
}

?>