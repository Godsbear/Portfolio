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
<!DOCTYPE html>
<html>
<?php
    //schreibt durch die funktion den Header der HTML-Seite
    //kann dadurch leichter verwaltetwerden
    //funktion steht in /schulprojekt/src/utils/header.php
	$titel= "Docu Gruppen-Mail-Server";
	buildHeaderSchool($titel);
?>
<body>
<?php
    //schreibt durch die funktion die Navigationsbar der HTML-Seite
    //kann dadurch leichter verwaltetwerden
    //funktion steht in /schulprojekt/src/utils/nav.php
    buildNavbarSchool();
?>	
<main>
	<br>
	<div class="container">
		<h1>Veranschaulichung der User-Verwaltung<br></h1>
        <div class="userpannel">
            <p class="conf">
                Bei der User-Verwaltung wird eine Anfrage an den Server geschickt um alle Existierenden User abzufragen.<br>
                Danach wird für jeden User eine Schaltfläsche erstellt die 
                den User-Namen und die User-ID anzuzeigen und <br>
                User activ oder inaktiv zu setzen oder den User zu löschen.<br>
                Bei dem aktivieren oder deaktivieren eines User wird eine Anfrage and den Server geschickt<br>
                mit PATCH, die die User-ID und active = true/false enthält.<br>
                Das löschen erfolgt durch eine Anfrage an den Server mit POST und der User-ID.
            </p>
            <input class="zoom imageBtn" type="image" src="/img/User_Verwaltung.PNG" width="70%" >
            <br><br>
            <p class="conf">
                Desweiteren wird ein PopUp erstellt womit man das Passwort der User<br>
                zurücksetzten kann. Für das zurücksetzten wird der User per Dropdown-Menu<br>
                ausgewählt  und das neue Passwort gesetzt.
            </p>
            <input class="zoom imageBtn" type="image" src="/img/Passwort_reset.PNG" width="70%" >
        </div>
	</div>
</main>
<footer>
</footer>
<script src="../js/navbar.js"></script>
<script src="../js/main.js"></script>
</body>
</html>

