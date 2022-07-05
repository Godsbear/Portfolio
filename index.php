<?php
session_start();            //session start für session-Variable
    //abfrage ob Benutzer bereits eingeloggt ist
    //sollte der Benutzer bereits eingeloggt sein wird er zur Home-Seite weitergeleitet
    if(isset($_SESSION["user"]) && isset($_SESSION["refreshToken"])){
        header('Location: src/home.php');
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <meta charset="UTF-8">
    <title>Login </title>
</head>
<body>
    <main>
    <!--class container für darstellung des body durch Bootstrap-->
    <div class="container" style="margin-top: 20px;">  
    <h1>Portfolio Webentwicklung Mark Pimpl</h1>  
    <br>
    <!--Formular für Login, nach abschicken wird Api.php aufgerufen und die Angaben übergeben-->
    <form id="LoginForm" method="post" action="src/Api.php">
            <div class="container">
                <h1><i class="bi bi-person" style="color:#04AA6D;"></i> Login</h1>
                <label><b>Username</b></label>
                <input id="email" type="email" placeholder="Enter E-mail address" name="email" required>
                <label><b>Password</b></label>
                <!--inputfeld für Password mit pattern für Password für Länge und Komplexität-->
                <input id="password" type="password" placeholder="Enter Password" name="password" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-check">
                        <span class="psw ">New? <a href="src/register.php ">Register here</a></span>

                        </div>
                    </div>
                    <div class="col-sm-3 text-end ">
                        <span class="psw ">Forgot <a href="src/passwordReset.php ">password?</a></span>
                    </div>
                </div>
                <!--custom_captcha von Google gegen spam/bots
                    von Google übernommen-->
                <div class = "g-recaptcha" data-sitekey = "6LcF2TogAAAAAAs9B0jW3x0rjhONQkXCvGrdGmpO">
                <?php
                    if(isset($_POST['submit']) && $_POST['submit'] == 'Login'){
                    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
                    {
                            $secret = 'private_Google_Secret';
                            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                            $responseData = json_decode($verifyResponse);
                            if($responseData->success)
                            { ?>
                    <div style="color: limegreen;"><b>Your contact request have submitted successfully.</b></div>
                            <?php }
                            else
                            {?>
                                <div style="color: red;"><b>Robot verification failed, please try again.</b></div>
                            <?php }
                    }else{?>
                        <div style="color: red;"><b>Please do the robot verification.</b></div>
                <?php }
                    }
                ?>
                </div>   
                <input id="submitButton" name="submit_btn" type="submit" value=" Login ">                    
            </div>
        </form>
        </div>          
    </main>
</body>
</html>