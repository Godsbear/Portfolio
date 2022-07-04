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
		<h1>Dokumentation Gruppen-Mail-Server<br></h1>
	
	<p>
		Angaben für die Konfiguration eines übergeordneten SMTP Mail-Server.<br>
		Dieser SMTP-Server hat nochmals mehrere untergeordnete SMTP-Server.<br>
		Den Mail-Server haben wir im Rahmen einer Gruppenarbeit konfiguriert.<br>
		Dieser funktioniert nur im Lan und auch nur mit DNS.
	</p>
		
	<ul >
		<li>
                <h3>Konfiguration Bank-Mail-Server - SMTP (/etc/postfix/main.cf)</h3>
                <div class="conf">
					<p>
						#Überprüfen der /etc/resolv.conf, dort sollte der nameserver 172.21.59.205 drinstehen<br> #Editieren der main.cf als root auf Bankserver<br> myhostname = karl1.$mydomain<br> mydomain = bank1.u5.fi212<br> myorigin = $mydomain<br> mydestination
						= $myhostname, $mydomain, localhost.$mydomain, localhost<br> inet_interfaces = $myhostname, localhost<br> mynetworks = 172.21.0.0/16, 127.0.0.0/8<br> alias_maps = hash:/etc/postfix/aliases<br> alias_database = $alias_maps<br> mail_spool_directory
						= /var/spool/mail<br><br> #Testen der remote Konfiguration: <br> Auf Bankserver zum Testen der Syntax der main.cf: <br> # newaliases<br> SMTP-Server starten als root auf Bankserver: <br> # systemctl start postfix<br> # netstat -ltn
						--> 172.21.51.0: 25 und 127.0.0.1:25<br> # telnet 172.21.51.0 25<br> EHLO SMTP-Server-FQDN<br> MAIL FROM: Sender-Adresse<br> RCPT TO: Empfänger-Adresse<br> DATA
						<br> Test-Mail verfassen und<br> beenden mit Enter-Taste . Enter-Taste<br> .
						<br> QUIT
						<br><br>
					</p>
				</div>
                    <hr>
                    <h3>Konfiguration Bank-Mail-Server - POP3 (/etc/tpop3d.conf)</h3>
				<div class="conf">
					<p>
						listen-address: 172.21.51.0:110(bank1.u5.fi212)<br> log-facility: mail<br> mailbox: bsd:/var/spool/mail/$(user)<br> auth-pam-enable: yes<br> #Testen der remote Konfiguration am Bankserver: <br> # systemctl start pop3d<br> # netstat
						-ltn --> 172.21.51.0: 110<br> # telnet 172.21.51.0 110<br> USER Accountname<br> PASS Passwort<br> LIST
						<br> RETR Nummer der Mail<br> QUIT
						<br><br>
					</p>
				</div>
                    <hr>
                    <h3>Konfiguration des lokalen SMTP-Server (/etc/postfix/main.cf) </h3>
				<div class="conf">
					<p>
						#am Beispiel von Platz 1 in Reihe 1, Hostname keine<br> myhostname = keine.bank1.u5.fi212<br> mydomain = bank1.u5.fi212<br> myorigin = $myhostname<br> mydestination = $myhostname, localhost.$mydomain, localhost<br> relayhost = $mydomain<br>                    inet_interfaces = $myhostname, localhost<br> mynetworks = 172.21.0.0/16, 127.0.0.0/8<br> alias_maps = hash:/etc/postfix/aliases<br> alias_database = $alias_maps<br> mail_spool_directory = /var/spool/mail<br> #Testen der lokalen Konfiguration
						am lokalen Rechner: <br> # newaliases<br> SMTP-Server starten als root auf lokalem Rechner: <br> # systemctl start postfix<br> # netstat -ltn --> 172.21.51.1: 25 und 127.0.0.1:25<br> # telnet 172.21.51.1 25<br> EHLO SMTP-Server-FQDN<br>                    MAIL FROM: Sender-Adresse<br> RCPT TO: Empfänger-Adresse<br> DATA
						<br> Test-Mail verfassen und<br> beenden mit Enter-Taste . Enter-Taste<br> .
						<br> QUIT
						<br><br>
                	</p>
				</div>
        </li>
            <hr>


		<li>
			<h3>Konfiguration des lokalen SMTP-Server (/etc/postfix/main.cf) </h3>
			<h3>User und Gruppe erstellen</h3>
			<div class="conf">
			<p>
				#gruppe erstellen für Bankreihe 1<br>
					groupadd -g 8100 mailuser<br><br>
			
				#user in Bankreihe 1 erstellen <br>
					useradd -u 8111 -g 8100 -d /home/users/iriwan -m -c "Iris Wanzenboeck Bank1" -s /bin/bash iriwan<br>
					useradd -u 8112 -g 8100 -d /home/users/marpim -m -c "Mark Pimpl Bank1" -s /bin/bash marpim<br>
					useradd -u 8113 -g 8100 -d /home/users/thomor -m -c "Thomas Morgenstern Bank1" -s /bin/bash thomor<br><br>
					
					useradd -u 8121 -g 8100 -d /home/users/iw -m -c "Iris Wanzenboeck Bank1" -s /bin/bash iw<br>
					useradd -u 8122 -g 8100 -d /home/users/mp -m -c "Mark Pimpl Bank1" -s /bin/bash mp<br>
					useradd -u 8123 -g 8100 -d /home/users/tm -m -c "Thomas Morgenstern Bank1" -s /bin/bash tm
			</p>
					</div>
		</li>
		<hr>
		<li>
			<h3>Alte User löschen</h3>
			<div class="conf">
				#Alle "normalen" user, die nicht mehr benötigt werden gelöscht<br>
				userdel r1-1 r1-2 r1-3<br>
				rm -r -f /home/users/r1-1 /home/users/r1-1 /home/users/r1-1<br>
			</div>
		</li>
		<hr>
		<li>
			<h3>Aliases erstellen</h3>
			<div class="conf">
				#Aliase für die Bankreihen nur die ersten acc<br>
				# Aliase fuer 1. Account<br><br>
				
					bank1:	iriwan@bank1.u5.fi212, marpim@bank1.u5.fi212, thomor@bank1.u5.fi212<br>
					bank2:	sanhus@bank2.u5.fi212, tobsch@bank2.u5.fi212, sanber@bank2.u5.fi212<br>
					bank3:	flomen@bank3.u5.fi212, renkow@bank3.u5.fi212, marsei@bank3.u5.fi212<br>
					bank4:	danjez@bank4.u5.fi212, ricwai@bank4.u5.fi212, cemyil@bank4.u5.fi212, muhkue@bank4.u5.fi212<br>
					bank5:	samdae@bank5.u5.fi212, margel@bank5.u5.fi212, terdet@bank5.u5.fi212, kevgol@bank5.u5.fi212, yaktop@bank5.u5.fi212<br>
					bank6:	oezkal@bank6.u5.fi212, ivaerp@bank6.u5.fi212, andkul@bank6.u5.fi212, michol@bank6.u5.fi212<br><br>
				
				#Aliase für die Bankreihen nur die zweiten acc<br>
				# Aliase fuer 2. Account<br><br>
				
					www-r1:	iw@bank1.u5.fi212, mp@bank1.u5.fi212, tm@bank1.u5.fi212<br>
					www-r2:	sh@bank2.u5.fi212, ts@bank2.u5.fi212, sb@bank2.u5.fi212<br>
					www-r3:	fm@bank3.u5.fi212, rk@bank3.u5.fi212, ms@bank3.u5.fi212<br>
					www-r4:	dj@bank4.u5.fi212, rw@bank4.u5.fi212, cy@bank4.u5.fi212, mk@bank4.u5.fi212<br>
					www-r5:	sd@bank5.u5.fi212, mg@bank5.u5.fi212, td@bank5.u5.fi212, kg@bank5.u5.fi212, yt@bank5.u5.fi212<br>
					www-r6:	ok@bank6.u5.fi212, ie@bank6.u5.fi212, ak@bank6.u5.fi212, mh@bank6.u5.fi212<br><br>
					
				#Aliase für die Namen in bank1<br>
					schorsch.gorgel: iriwan@bank1.u5.fi212<br>
					fizli.puzli: thomor@bank1.u5.fi212<br>
					mark.pimpl: marpim@bank1.u5.fi212
			</div>
		
		</li>
		<hr>
		<li>
			<h3>Neue User an Lokalem System erstellen</h3>
			<div class="conf">
				# 2 neue acc am localem system erstellen<br>
				useradd -u 1811 -g 1000 -d /home/users/bank1ma -m -c "Mark Pimpl Bank1" -s /bin/bash bank1ma<br>
				bank1ma:x:1811:1000:Mark Pimpl Bank1:/home/users/bank1ma:/bin/bash<br><br>
				
				useradd -u 1812 -g 1000 -d /home/users/bank1pi -m -c "Mark Pimpl Bank1" -s /bin/bash bank1pi<br>
				bank1pi:x:1812:1000:Mark Pimpl Bank1:/home/users/bank1pi:/bin/bash<br>
			</div>
		</li>
		<hr>
		<li>
			<h3>Fetchmail einrichten an Lokalem System</h3>
			<div class="conf">
				#fetchmail Angabe für das abhohlen der Mails<br>
				poll mailer.reihe1.fi212.netz with proto pop3<br>
					user marpim with password 'mailnix' is bank1ma here keep<br><br>
				
				poll mailer.reihe1.fi212.netz with proto pop3<br>
					user mp with password 'mailnix' is bank1pi here keep
			</div>
		</li>
		<hr>
	
	</ul>
	</div>
</main>
<footer>
</footer>
<script src="../javascript/stickyNav.js"></script>
</body>
</html>

