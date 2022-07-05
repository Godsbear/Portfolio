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
	$titel= "Download";
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
    <!-- class container aus Bootstrap für einheitliche darstellung des bodys (main-Bereich)-->
	<div class="container download">
		<br>
		<h1>Download Bereich</h1>
		<br>
		<p>Für die Downloadliste wird ein Verziechnis ausgelesen und anschließend<br>
            eine Liste mit php über eine Schleife gefüllt.<br>
            Somit wird bei jedem Laden die Liste neu erstellt mit den Aktuellen Inhalten.<br><br>
            Mittels Button kann die Datei heruntergeladen werden und mit dem Namen als Link,<br>
            kann der Inhalt der Datei im Web, sofern möglich, angesehen werden.<br>
        </p>
		<!--Tabelle für die Downloadliste-->
		<table id="myShare"> 

        <?php     
            //angabe des Verzeichniss für den Downloadbereich
            $verzeichnis = "../download";
            // Test, ob es sich um ein Verzeichnis handelt
            if ( is_dir ( $verzeichnis ))
            {
                echo '<tr> <th class="file-name" onclick="sortTable(0)">Dateiname</th><th onclick="sortTable(1)">Dateigröße</th><th class="date" onclick="sortTable(2)">Änderungsdatum</th><th onclick="sortTable(3)">Dateityp</th></tr>';
                // öffnen des Verzeichnisses
                if ( $handle = opendir($verzeichnis) )
                {
                    // einlesen der Verzeichnisses
                    while (($file = readdir($handle)) !== false)
                    {
                        //zusammensetzten von Dateipfad und Filename
                        $realfile = $verzeichnis . "/" . $file;
                        //abfrage damit bestimmte Dateien nicht angezeigt werden
                        if($file == "." || $file == ".." || substr($file, -1) =="~" || substr($file, -1) == "#"){
                            continue;
                        }
                        echo '<tr><td class="file-name">
                            <a class="btn btn-primary" href="'.$realfile.'" download role="button"><i class="bi bi-download"></i></a>
                            <a href="'.$realfile.'" target="_blank" rel="noopener noreferrer">'.$file.' </a>
                            </td>';

                        echo '<td class="file-size">';
                        //file-Größe in Bytes
                        $filesize = filesize($realfile);
                        $size = "B";
                        //abfrage der file-Größe für die richtige Endung B, KB und MB
                        if($filesize >= 1000){
                            $filesize = round($filesize / 1024, 1);
                            $size = "KB";
                        }
                        if($filesize >= 1000){
                            $filesize = round($filesize / 1024, 1); // megabytes with 1 digit
                            $size = "MB";
                        }
                        //Ausgabe der file-Größe mit richtiger Einheit
                        echo $filesize." ".$size."</td>";
                        echo '<td class="date">';
                        //Ausgabe des Datums der letzten änderung in Format
                        echo date ("F d Y H:i:s.", filemtime($realfile));
                        echo '</td>';
                        
                        //file-extension bestimmen
                        $pi = pathinfo($realfile);                            
                        if(isset($pi['extension'])){
                            $filetype = $pi['extension']; // txt  
                        }
                        //file-extension ausgeben
                        echo '<td class="file-type">'.$filetype.'</td>';
                        echo "</tr>";
                    }
                    //verzeichnis schließen
                    closedir($handle);
                }
            }          
        ?>

        </table>
</main>		
<footer>
</footer>
<script src="/js/main.js"></script>
<script src="../js/navbar.js"></script>
</body>
</html>


