<?php
require __DIR__ . '/../config.php';     //einbindung der config-Datei 
//in der config-Datei werden Funktionen und andere Dateien includiert
use App\Utils\HelperFunctions;          //einbinden der Helperfunktions

//session gestartet für die verwendung der Session-Variablen
session_start();

//Funktion für die überprüfung, ob der Benutzer eingeloggt ist
//sollte der Benutzer nicht eingeloggt sein wird er zum Login umgeleitet
HelperFunctions::loginCheck();

//Funktion für die überprüfung, ob die Cookies vorhanden sind
//sollten die Cookies nicht vorhanden sein öffnet sich ein PopUp
HelperFunctions::cookiesCheck();
?>


<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
	
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <!-- Navigation Icon -->
    <link rel="stylesheet" href="/../../../../css/vorlage.css" />
    <!-- Layout -->
    
    <link rel="stylesheet" href="../css/style.css" />
    
    <!-- Pseudolinks -->
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <!-- Script für Toggle -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script>
        function hidePopUp() {
        var popup = document.getElementById("cookie-popup");
        popup.classList.toggle("hidden");
        }
    </script>

</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <!-- #3949AB (Indigo)-->
        <header class="mdl-layout__header">
            <!-- Header -->
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title"><a href="home.php">Home|</a></span>
                <span class="mdl-layout-title"><a href="register.php">Register|</a></span>
                <?php 
                    //Nav-link wird nur angezeigt, wenn man als Admin eingeloggt ist  
                    if(isset($_SESSION["roles"][1])){
                        echo('<span class="mdl-layout-title"><a href="userPanel.php">userPanel|</a></span>');                        
                    }
                ?>
                    <span class="mdl-layout-title"><a href="accPanel.php">Profil|</a></span>
                    <span class="mdl-layout-title"><a href="logout.php">Logout</a></span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
                <nav class="mdl-navigation mdl-layout--large-screen-only">
                    <!-- Navigation rechts -->
                    
                </nav>
            </div>
        </header>
        <main class="mdl-layout__content">
            <!--Darstellung mit Bootstrap-->
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>User-Verwaltung</h5>
                        <?php 
                            //Ausgabe Username und User-Email   
                            echo ("Username: ".$_SESSION["user"]["name"].'<br>');
                            echo("E-mail: ".$_SESSION["user"]["email"]);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h5>Password-Reset</h5>
                        <!--Formular für das zurücksetzten des Userpasswort-->
                        <form id="passwordResetForm" method="post" action="userApi.php">
                            <label for="psw"><b>Password</b></label>
                            <!--Inputfeld für Password mit pattern-->
                            <input type="password" id="password" placeholder="Enter Password" name="passwordResetUser" 
                             pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            <br>
                            <label for="psw-repeat"><b>Repeat Password</b></label>
                            <!--Inputfeld für Password mit pattern-->
                            <input type="password" id="confirm_password" placeholder="Repeat Password" name="passwordResetRepeat" 
                             pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                             <span id='message'></span>
                            <!--Button führt funktion in JS aus für die Validierung und Passwort zurücksetzten über userApi.php-->
                            <button  onclick="validatePassword()" id="resetBtn">Password Reset</button>
                        </form>
                    </div>
                    <br> <br> 
                </div>
            </div>
        </main>
    </div>
    <!--Cookie-PopUp-->
    <?php if($_SESSION["cookieCheck"]) { ?>
            <div id="cookie-popup">
                <form id="cookies" method="post">
                    <div class="container">
                        <span>Wir verwenden Cookies für den Login <br>
                        Sie müssen der Verwendung zustimmen, andernfalls <br>
                        dürfen Sie unsere Lernplatform nicht verwenden. <br>
                        !Achtung mit dem Ablehnen der Cookies werden Sie <br>
                        zum Login weitergeleitet
                        </span>
                        <br>
                        <button id="loginbtn" type="submit" onClick="window.location.href='../index.php'" name="zumLogin" value="Submit" class="loginbtn">Ablehnen</button>
                        <button id="loginbtn" type="submit" onclick="hidePopUp()" name="submitbutton" value="Submit" class="loginbtn">Nur Notwendige</button>
                    </div>
                </form>
            </div>
    <?php  }; ?>
    <footer>
    </footer>
</body>
    <script  src="../js/main.js"></script>
</html>