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
//abfrage ob Benutzer Admin-Rechte besitzt
if(!isset($_SESSION["roles"][1])){
    //wenn Benutzer keine Admin-Rechte besitzt wird das Script beendet mit einer Nachricht
    die('access denied <br><br> <a href="home.php">zurück zur Startseite</a>');
}

use App\Utils\MyRequest;
//Funktion für den login
function login(string $email, string $password): string
{
    $req = new MyRequest();
    try{
        //sendet request an den Server mit Email und Passwort für Authentifizierung
        $response = $req->request('POST', 'iam/auth/login', [], [
            'email' => $email,
            'password' => $password,
        ]);
        // gibt den accessToken zurück, bei erfolgreicher Authentifizierung
        return $response["accessToken"];
    }catch(\Exception $e){
        //gibt Fehlermeldung zurück
        var_dump($e->getMessage());
        exit;
    }
}

function getNewAccessToken(): string
{
    $req = new MyRequest();
    try{
        //Anfrage an den Server für einen neuen accessToken
        $response = $req->request('POST', 'iam/auth/refresh-access-token', [], []);
        return $response["token"];
    }catch(\Exception $e){
        var_dump($e->getMessage());
        exit;
    }
}
//Aufbau der Userverwaltung
function getUsers(){
    //token aus der Session übernommen
    $token = $_SESSION["accessToken"];
    $req = new MyRequest($token);
    //Abfrage aller User mit GET
    $response = $req->request('GET', 'iam/user', [], []);
    //response entält alle User und die Anzahl für Schleifen wird ermittelt
    $lenght=count($response);
    
    

    echo('<hr style="border-width: 5px;">');
    //erstellt für die anzahl User eine Übersicht für: Username, Email, User-ID und Rechte
    //User sind in einem Objekt gespeichert und können mit der Laufvariable angesprochen werden
    for($i = 0; $i < $lenght; $i++){
        echo('<div class="row">');
        echo('<div class="col-md-6">');
        echo("Username:  ");
        echo($response[$i]["name"]);
        echo("<br>Email:\t ");
        echo($response[$i]["email"]);
        echo("<br>User-ID:  ");
        echo($response[$i]["id"]);
        echo("<br>Rechte:\t ");
        $lenght2 = count($response[$i]["roles"]); 

        for($j = 0; $j < $lenght2; $j++){
            echo($response[$i]["roles"][$j]);   
        }
                
        echo("</div>");
        echo('<div class="col-md-6">');
        //erstellt die Schaltflächen für die User abhängig der Laufvariable
        echo('  
        <div class="row">
        <div class="col-md-6">
        <form class="activeForm" method="post" action="userPanel.php">
                <label for="active"> User active</label>
                <br>
                <label class="switch">');

        if($response[$i]["active"] == true){
            
            echo("<br>");
            echo('<input id="userCheckBox'.$i.'" name="checkBox'.$i);
            //Value entspricht der User-ID für spätere verwendung
            echo('" type="checkbox" value="'.$response[$i]["id"].'" onclick="handleClick(this)" checked >
            ');

        }else{
            
            echo("<br>");
            echo('<input id="userCheckBox'.$i.'" name="checkBox'.$i);
            ////Value entspricht der User-ID für spätere verwendung
            echo('" type="checkbox" value="'.$response[$i]["id"].'" onclick="handleClick(this)" >
            ');
        }
                    
        echo('            <span class="slider round"></span>
                </label>
                <br>
                
            </form>
            </div>
            <div class="col-md-6">
                <button class="Btn-Delete" id="Btn-Delete'.$i.'" value="'.$response[$i]["id"].'" onclick="deleteUser(this)" >delete</button>
            </div>
            </div>
                <br><br>            
        ');
        echo("</div></div>");
        echo('<hr style="border-width: 5px;">');
    }
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UserPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
	
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <!-- Navigation Icon -->
    <link rel="stylesheet" href="/../../../../css/vorlage.css" />
    <!-- Layout -->
    
    <link rel="stylesheet" href="/../../../../css/style.css" />
    
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
            <div class="container">
                
                    <div>
                        <?php
                            //Ausgabe des User-Name und seine Rechte
                            echo "Eingeloggt als: ";
                            echo($_SESSION["user"]["name"]);
                        ?>
                    </div>
                    <div>
                        <?php    echo "Rechte: ";
                            $lenght=count($_SESSION["roles"]);
                            for($i = 0; $i < $lenght; $i++){
                                echo($_SESSION["roles"][$i]);
                                echo("/ ");
                            }
                        ?>
                    </div>
                    <br>  
                    <h3>User Verwaltung</h3>
                    <button class="Btn-refresh" onClick="refresh(this)" value="refresh"><i class="bi bi-arrow-clockwise"></i></button>
                    
                    <button class="Btn-pwdReset" id="Btn-pwdReset" data-hidden-content="pwdReset" onclick="resetPupUp(event)">Password Reset</button>
                    
                    <div id="modalContent" class="modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Password Reset</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body"></div>
                            </div>
                        </div>
		            </div>
                    <div>
                            <?php
                                //auführen der Funktion zur erstellung der Userverwaltung
                                getUsers();
                            ?>
                        </div>
                    </form>
            </div>
            <div id="pwdReset" class="d-none">
                <div class="pwdResetUser">
                    <form id="passwordResetFormAdmin" name="pwdResetAdmin" method="post" action="userApi.php">
                        <select id="userIds" name="userIds">
                        <?php  
                        //Passwort zurücksetzten durch Admins per Dropdown-Menu
                        $token = $_SESSION["accessToken"];
                        $req = new MyRequest($token);
                        //Abfragen aller User vom Server mit GET für Dropdown-Menu
                        $response = $req->request('GET', 'iam/user', [], []);
                    
                        $lenght=count($response);
                        //Erstellung des Dropdown-Menu
                        for($i = 0; $i < $lenght; $i++){
                        echo('<option  style="pre-wrap;" value="'.$response[$i]["id"].'">
                                    Username: '.$response[$i]["name"].'   ||  Email: '.$response[$i]["email"].'</option>
                                
                            ');}
                        ?>
                        </select>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="psw"><b>Password</b></label>
                                <input type="password" id="password" placeholder="Enter Password" name="passwordResetAdmin" 
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <div class="col-md-6">
                                <label for="psw-repeat"><b>Repeat Password</b></label>
                                <input type="password" id="confirm_password" placeholder="Repeat Password" name="passwordResetRepeat" 
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <span class="message"></span>
                            </div>
                        </div>
                            <button id="btn-pwdReset" onclick="chanchePassword()" class="resetBtn">Password Reset</button>

                    </form>
                </div> 
		    </div>
        </main>
    </div>
</body>
    <script  src="../js/main.js"></script>
</html>