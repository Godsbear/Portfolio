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
	$titel= "Docu SMTP-Server";
	buildHeader($titel);
?>
<body>
<?php
    //schreibt durch die funktion die Navigationsbar der HTML-Seite
    //kann dadurch leichter verwaltetwerden
    //funktion steht in /schulprojekt/src/utils/nav.php
    buildNavbar();
?>
<main>
	<br>
	<div class="container">
		<h1>Dokumentation Mail-Server<br></h1>
	
	<p>
		Angaben für die Konfiguration eines übergeordneten SMTP Mail-Server.<br>
		Den Mail-Server haben wir im Rahmen einer Gruppenarbeit konfiguriert.<br>
		Dieser funktioniert nur im Lan und auch nur mit DNS.
	</p>
		
	<ul >
		<li>
			<h3>User und Gruppe erstellen</h3>
			<p class="conf">
				#Gruppe erstellen mit -g &lt;groupID&gt; &lt;GruppenName&gt;<br>
				<span class="highlightingCM">groupadd</span> -g 50100 ftp50100<br>			
				<br>#apache der Gruppe hinzufügen<br>
				<span class="highlightingCM">usermod</span> -a -G ftp50100 apache<br>
				<br>#User erstellen mit -userID -gruppenID -d (HOME-Verzeichnis /srv/apache/share/vhosts_remote/)<br>
				# -s (shell) &lt;userName&gt;<br>
				<span class="highlightingCM">useradd</span> -u 50101 -g ftp50100 -d /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/./public <br>
				-s /bin/bash ftp50101
			</p>
		</li>
		<hr>
		<li>
			<h3>Verzeichnisse erstellen</h3>
			<p class="conf">
				#Verzeichnis erstellen<br>
				<span class="highlightingCM">mkdir</span> -p /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/public<br>
				<span class="highlightingCM">mkdir</span> -p /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/logs<br>
				<br>#Rechte anpassen<br>
				<span class="highlightingCM">chown</span> ftp50101:ftp50100 /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/public/<br>
				<span class="highlightingCM">chmod</span> 750 /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/public/<br>
				<span class="highlightingCM">chmod</span> 550 /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/<br>
				<span class="highlightingCM">chgrp</span> ftp50100 /srv/apache/share/vhosts_remote/50101_nur.bade.wanne/<br>
				<span class="highlightingCM">chmod</span> 555 /srv/apache/share/vhosts_remote/<br>
				<span class="highlightingCM">chmod</span> 555 /srv/apache/share/<br>
				<span class="highlightingCM">chown</span> 0:0 /srv/apache/share/<br>
				<span class="highlightingCM">chmod</span> 555 apache/			
			</p>
		</li>
		<hr>
		<li>
			<h3>Konfigurieren der IP-Adresse 10.212.5N.ZZZ/16</h3>
			<p class="conf">
				N = Bankreihe, ZZZ = Sitzplatznummer <br><br>
				In der Datei network in /etc/init.d/ muss die Ip hinzugefügt werden.<br>
				bei start und bei Stop:<br>
				'/sbin/ip addr add 10.212.51.2/16 broadcast 10.212.255.255 dev eth0 label eth0:n55 &&' <br><br>
				!!Wichtig voher mit network	stop network devices anhalten und nach dem speichern wieder starten	
			</p>
		
		</li>
		<hr>
		<li>
			<h3>Vhost für Nachbar erstellen</h3>
			<p class="conf">
				In der Datei httpd-vhosts.conf (/usr/local/apache2/etc/extra) wird ein neuer Vhost angelegt mit:<br><br>
	
					<div class="conf">
				<span class="highlighting">&lt;VirtualHost 10.212.51.2:80&gt;</span> 
					
						#Servername und Serveradmin <br>
						<span class="highlighting">ServerName</span> iris.fi212.netz<br>
						<span class="highlighting">ServerAdmin</span> webmaster@fi212.netz<br>
						<br>#Server-speziefische Log-files<br>
						<span class="highlighting">ErrorLog</span>	&quot;/srv/apache/share/vhosts_remote/50201_iris.fi212.netz/logs/error/50201_iris.fi212.netz_error.log&quot;<br>
						<span class="highlighting">CustomLog</span>	&quot;/srv/apache/share/vhosts_remote/50201_iris.fi212.netz/logs/access/50201_iris.fi212.netz_access.log&quot; common<br>
						<br>#eigenes DocumentRoot<br>
						<span class="highlighting">DocumentRoot</span> &quot;/srv/apache/share/vhosts_remote/50201_iris.fi212.netz/public/&quot;<br>
						<span class="highlighting">IndexOptions</span> +FoldersFirst +IgnoreCase +NameWidth=* +SuppressDescription <br><br>
						<div class="conf">
							<span class="highlighting">&lt;Directory &quot;/srv/apache/share/vhosts_remote/50201_iris.fi212.netz/public&quot;&gt;</span>	
							#Browsinglisten und symbol. Link erlauben<br>
							<span class="highlighting">Options</span> Indexes FollowSymlinks 
							<br>#externe Konfigurationsdatei (AccessFilename) verbieten<br>
							<span class="highlighting">AllowOverride</span> Indexes AuthConfig FileInfo NonFatal=all
							<br>#Zugriff fuer alle erlauben<br>
							<span class="highlighting">Require</span> all granted
							<span class="highlighting">&lt;/Directory&gt;<br></span>
						</div>
						<br>#Dateiangabe für Configdatei für Webspace (.htaccess)<br>
						<span class="highlighting">AccessFileName</span> .htaccess<br>
						<br>#Reguläre Ausdruecke mit ~ beginnend durch leerzeichen getrennt<br>
						<div class="conf">
							<span class="highlighting">&lt;DirectoryMatch "^/.*/\.htconf.*"&gt;</span>
							
							<span class="highlighting">Options</span> none<br>
							<span class="highlighting">AllowOverride</span> none<br>
							<span class="highlighting">Require</span> all denied<br>
						</div>	
						<span class="highlighting">&lt;/DirectoryMatch&gt;</span>	
					</div>
					<span class="highlighting">&lt;/VirtualHost&gt;</span>
				
				</p>
		</li>
		<hr>
		<li>
			<h3>Konfiguration mit .htaccess</h3>
			<p>
				<div class="conf">
					#Browsingliste aktivieren und darstellung anpassen<br>
					<span class="highlighting">Options</span> +Indexes<br>
					<span class="highlighting">IndexOptions</span> +FancyIndexing +FoldersFirst +IgnoreCase +NameWidth=* +SuppressDescription +HTMLconfle<br><br>
					#Dateien und Verzeichnisse die nicht in der Browsingliste angezeigt werden sollen<br>
					<span class="highlighting">IndexIgnore</span> .??* *~ *# HEADER* README* RCS CVS *,v *,t<br>
					<span class="highlighting">IndexIgnore</span> *.css css *.bck *.bak fehler*<br><br>
					
					#Dateipfad für Header und Footer für die Browsingliste <br>
					<span class="highlighting">ReadmeName</span> /README.html<br>
					<span class="highlighting">HeaderName</span> /HEADER.html<br><br>
					#Alias für das Verzeichnis der Fehlermeldungen<br>
					<span class="highlighting">Alias</span> /fehler/ /fehler/<br><br>
					#Angabe der Fehlermeldungen mit Dateipfad<br>
					<span class="highlighting">ErrorDocument</span> 400 /fehler/error-400.html<br>
					<span class="highlighting">ErrorDocument</span> 401 /fehler/error-401.html<br>
					<span class="highlighting">ErrorDocument</span> 402 /fehler/error-402.html<br>
					<span class="highlighting">ErrorDocument</span> 403 /fehler/error-403.html<br>
					<span class="highlighting">ErrorDocument</span> 404 /fehler/error-404.html <br>
					<span class="highlighting">ErrorDocument</span> 405 /fehler/error-405.html<br>
					<span class="highlighting">ErrorDocument</span> 406 /fehler/error-406.html<br>
					<span class="highlighting">ErrorDocument</span> 408 /fehler/error-408.html<br><br>
					
					<span class="highlighting">ErrorDocument</span> 500 /fehler/error-500.html<br>
					<span class="highlighting">ErrorDocument</span> 501 /fehler/error-501.html<br>
					<span class="highlighting">ErrorDocument</span> 502 /fehler/error-502.html
				</div>
			</p>
		</li>
		<hr>
		<li>
			<h3>Authentifizierung für Bank1</h3>
			<p>
				<div class="conf"> 
					#Art der Authentifizierung: basic<br>
					<span class="highlighting">AuthType</span> Basic<br>
					<span class="highlighting">AuthName</span> "very importent person"<br>
					<span class="highlighting">AuthBasicProvider</span> file<br>
					#Variable DOCROOT wurde in der Vhost datei definiert und enthält den Dateipfad von ServerRoot<br>
					<span class="highlighting">AuthUserfile</span> "${DOCROOT}/config/.htconf/.htpasswd.basic"<br>
					<span class="highlighting">AuthGroupfile</span> "${DOCROOT}/config/.htconf/.htgroup"<br>
					#User stehen in .htpasswd.basic<br>
					<span class="highlighting">Require</span> user mark iris thomas
				</div>
			<p>
		</li>
		
	</ul>
	</div>
</main>
<footer>
</footer>
<script src="../javascript/stickyNav.js"></script>
</body>
</html>

