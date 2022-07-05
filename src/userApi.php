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
            
    //axios JS
    //User activ oder inactiv setzten
    //abfrage, ob die checkbox gecheckt ist
    if(isset($_POST["active"])) {  
            //setzt den User anhand der ID activ oder inactiv    
            HelperFunctions::setActive();
    }

    if(isset($_POST["userId"])){
        //löscht anhand der User-ID den User
        HelperFunctions::deleteUser();
    }
 
    if(isset($_POST["passwordResetUser"])){
        //var_dump($_POST["passwordResetUser"]);
        //Passwort änderung durch User
        HelperFunctions::pwdResetUser();
        header("Location: accPanel.php");
    }

    
    if(isset($_POST["chanchePwd"])){
        //var_dump($_POST["chanchePwd"]);
        //var_dump($_POST["id"]);
        //Passwort änderung durch Admin für User anhand Auswahl im Dropdown-Menu
        HelperFunctions::pwdResetAdmin();
        header("Location: userPanel.php");
    }

    if(isset($_POST["userIds"]) && isset($_POST["passwordResetAdmin"])){
    //var_dump($_POST["userIds"]);
    //var_dump($_POST["passwordResetAdmin"]);
    HelperFunctions::pwdResetAdmin();
    header("Location: userPanel.php");
    }

?>