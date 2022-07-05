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
	$titel= "Email-Service";
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
	<div class="container download">
		<br>
		<h1>Herzlich Wilkommen <br>aktuell Mailversand ohne Funktion</h1>
		<br>
		<p>
			Dieses Formular funktioniert nur im Lan, da der Mailserver<br>
			 nur unverschlüsselt sendet.<br><br>
			Nach absenden des Formulars wird eine E-Mail aus den Eingaben zusammen gesetzt.<br>
			Die Mail wird dann mit der Funktion mail() von PHP über einen SMTP Server versendet.<br>
			Wichtig dabei ist die Angabe enctype="multipart/form-data" beim Formular,<br>
			damit auch Anhänge versendet werden können.
		</p>
		<form id="email-service" enctype="multipart/form-data" method="POST" action="mail.php">
			<label for="absender-name">Name: </label><br>
			<input class="mail-address" type="text" id="absender-name" name="absender-name"><br>
			<label for="absender">Absender-Email:</label><br>
			<input class="mail-address" type="email" id="absender" name="absender"><br>
			<label for="empfaenger">Empfänger-Email:</label><br>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			
			<input class="mail-address" type="email" id="empfaenger" name="empfaenger" list="Email-Adressen">
			<div class="containerCC">
				<div>
					<button class="add_form_fieldCC">Weitere Empfänger Cc
						<span style="font-size:16px; font-weight:bold;">+ </span>
					</button>
				</div>
			</div>
			<div class="containerBCC">
				<div>
					<button class="add_form_fieldBCC">Weitere Empfänger Bcc 
						<span style="font-size:16px; font-weight:bold;">+ </span>
					</button>
				</div>
			</div>
			<br> <br>
			<datalist id="Email-Adressen">
				<option value="muhkue@bank4.u5.fi212"> 
				<option value="iriwan@bank1.u5.fi212"> 
				<option value="marpim@bank1.u5.fi212"> 
				<option value="thomor@bank1.u5.fi212"> 
				<option value="sanhus@bank2.u5.fi212"> 
				<option value="tobsch@bank2.u5.fi212"> 
				<option value="sanber@bank2.u5.fi212">
				<option value="flomen@bank3.u5.fi212">
				<option value="renkow@bank3.u5.fi212">
				<option value="marsei@bank3.u5.fi212">
				<option value="danjez@bank4.u5.fi212">
				<option value="ricwai@bank4.u5.fi212">
				<option value="cemyil@bank4.u5.fi212">
				<option value="samdae@bank5.u5.fi212">
				<option value="margel@bank5.u5.fi212">
				<option value="terdet@bank5.u5.fi212">
				<option value="kevgol@bank5.u5.fi212">
				<option value="yaktop@bank5.u5.fi212">
				<option value="oezkal@bank6.u5.fi212">
				<option value="ivaerp@bank6.u5.fi212">
				<option value="andkul@bank6.u5.fi212">
				<option value="nz@bank9.u5.fi212">
				<option value="michol@bank6.u5.fi212">
				
				
        	</datalist> 
        	<input class="mail-address" type="Text" id="betreff" name="betreff" placeholder="Betreff.."><br>
        	<!-- MAX_FILE_SIZE muss vor dem Datei-Eingabefeld stehen -->
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			<!-- Der Name des Eingabefelds bestimmt den Namen im $_FILES-Array -->
			 <input name="datei_feld" type="file" multiple />
        	<br>
			<label for="data">Mail-Inhalt:</label><br>
			<textarea id="mail-data" type="text" id="data" name="data"> </textarea><br>
			<input type="checkbox" name="loop" ><br><br>
			 <input type="submit" name="confirm" value="Submit">
			 
			 </form>
			
		<?php
			
			if(isset($_POST["confirm"])){
				
				ini_set("SMTP", "kwadsch.fi212.netz");
				ini_set("sendmail_from", $_POST["absender"]);
				
				$content = $_POST["data"];
				$bccList = "";
				if(isset($_POST["empfaengerBCC"])){
					$listCount = count($_POST["empfaengerBCC"]);
					
					for($i=0; $i<$listCount; $i++){
						$bccList .= $_POST["empfaengerBCC"][$i];
						
						if($i<$listCount -1){
							$bccList .= ",";
						}
					}
				}
				$ccList = "";
				if(isset($_POST["empfaengerCC"])){
					$listCount = count($_POST["empfaengerCC"]);
					
					for($i=0; $i<$listCount; $i++){
						$ccList .= $_POST["empfaengerCC"][$i];
						
						if($i<$listCount -1){
							$ccList .= ",";
						}
					}
				}
				
				
				$headers = "From: ".$_POST["absender"]."\r\n".
							"Cc: ".$ccList."\r\n".
							"Bcc: ".$bccList."\r\n";				
				$jump = 0;			
				
				
				if($_FILES["datei_feld"]["error"] != 0){
					
					switch ($_FILES["datei_feld"]["error"]) {
						case 1:
							echo "Datei ist zu groß";
							break;
						case 2:
							echo "Datei ist zu groß";
							break;
						case 3:
							echo "Datei nur teilweise hochgeladen";
							break;
						case 4:
							echo "keine Datei hochgeladen";
							break;
						case 6:
							echo "unbekannter Fehler, bitte noch einmal hochladen";
							break;
						case 7:
							echo "Speichern der Datei fehlgeschalgen";
							break;
						case 8:
							echo "Hochladen der Datei nicht möglich";
							break;
					}
				}else{
					$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));
					$upload_tmp_dir = "/tmp";
					echo("<br><br>Test");
					 
					
					
					$anhang = array();
					$anhang["name"] = $_FILES['datei_feld']['name'];
					$anhang["size"] = $_FILES['datei_feld']['size'];
					$anhang["type"] = $_FILES['datei_feld']['type'];
					$anhang["data"] = implode("",file($_FILES['datei_feld']['tmp_name']));
									
					//$anhang ist ein Mehrdimensionals Array
				   //$anhang enthält mehrere Dateien
				   
					function mail_att($to,$ccList,$bccList, $subject, $message, $anhang) {
						$absender = $_POST["absender-name"];
						$absender_mail = $_POST["absender"];
						$reply = $_POST["absender"];
					
						$mt_rand = rand(1111111111111111, 9999999999999999); // 21 . "_=";
						$mime_boundary_mixed = "=_mixed " . $mt_rand . "_=";
						$mime_boundary_alternative = "=_alternative " . $mt_rand . "_=";
					
						$header = "From:" . $absender . "<" . $absender_mail . ">\n";
						$header.= "Reply-To: " . $reply . "\n";
						$header.= 'Cc: '. $ccList . "\n";
						$header.= 'Bcc: '. $bccList . "\n";
						$header.= 'MIME-Version: 1.0' . "\r\n";
						$header.= 'Content-type: text/html; "charset=utf-8"' . $mime_boundary_mixed . '"' . "\r\n";
						$contentf = '--' . $mime_boundary_mixed . "\r\n";
						$contentf.= 'Content-Type: multipart/alternative; boundary="' . $mime_boundary_alternative . '"' . "\r\n\r\n";
						$contentf.= '--' . $mime_boundary_alternative . "\r\n" . 'Content-type: text/html; "charset=utf-8"' . "\r\n\r\n";
						$contentf.= $message . "\r\n\r\n";
						$contentf.= '--' . $mime_boundary_alternative . '--' . "\r\n\r\n";
					
						//$anhang ist ein Mehrdimensionals Array 
						//$anhang enthält mehrere Dateien 
						
						
						if (is_array($anhang) AND is_array(current($anhang))) {
							foreach ($anhang AS $dat) {
								$data = chunk_split(base64_encode($dat['data']));
								$contentf.= '--' . $mime_boundary_mixed . "\r\n";
								$contentf.= 'Content-Disposition: attachment; filename="' . $dat['name'] . '"' . "\r\n";
								$contentf.= "Content-Length: ." . $dat['size'] . ";\r\n";
								$contentf.= "Content-Type: " . $dat['type'] . "; name=\"" . $dat['name'] . "\r\n";
								$contentf.= "Content-Transfer-Encoding: base64\r\n\r\n";
								$contentf.= $data . "\r\n";
							}
							$contentf .= "--" . $mime_boundary_mixed . "--" . "\r\n";
						} else { //Nur 1 Datei als Anhang 
							$data = chunk_split(base64_encode($anhang['data']));
							$contentf.= '--' . $mime_boundary_mixed . "\r\n";
							$contentf.= 'Content-Disposition: attachment; filename="' . $anhang['name'] . '"' . "\r\n";
							$contentf.= "Content-Length: ." . $anhang['size'] . ";\r\n";
							$contentf.= "Content-Type: " . $anhang['type'] . "; name=\"" . $anhang['name'] . "\r\n";
							$contentf.= "Content-Transfer-Encoding: base64\r\n\r\n";
							$contentf.= $data . "\r\n";
							$contentf.= "--" . $mime_boundary_mixed . "--";
						}
					
						if(isset($_POST["loop"])){
							for($i=0;$i<5;$i++){
								mail($to, $subject, $contentf, $header);
								echo '<script>alert("Email gesendet an: '.$to.'und Cc'.$ccList.', Bcc '.$bccList.' ")</script>';
								var_dump($to);
							}
						}else{
							mail($to, $subject, $contentf, $header);
							echo '<script>alert("Email gesendet an: '.$to.'und Cc'.$ccList.', Bcc '.$bccList.' ")</script>';
							var_dump($to);
						}
					}
						mail_att($_POST["empfaenger"],$ccList,$bccList, $_POST["betreff"], $content, $anhang);
						echo("<br><br>Email an ".$_POST["empfaenger"].", ".$bccList." gesendet <br> Date:".date("Y-m-d H:i:s"));
						$jump = 1;
					}
			
			if($jump !=1){
				if(isset($_POST["loop"])){
					for($i=0;$i<5;$i++){
						mail($_POST["empfaenger"], $_POST["betreff"], $content, $headers);
						echo("<br><br>Email an ".$_POST["empfaenger"].", Cc:".$ccList.", Bcc:".$bccList." gesendet <br> Date:".date("Y-m-d H:i:s"));
					}
				}else{
					mail($_POST["empfaenger"], $_POST["betreff"], $content, $headers);
				echo("<br><br>Email an ".$_POST["empfaenger"].", Cc:".$ccList.", Bcc:".$bccList." gesendet <br> Date:".date("Y-m-d H:i:s"));
				}
			
			}
				
				
		}
			
		?>
		
		
		
		
        <script>
        	$(document).ready(function() {
				var max_fields = 25;
				var wrapperCC = $(".containerCC");
				var add_buttonCC = $(".add_form_fieldCC");
			
				var x = 1;
				$(add_buttonCC).click(function(e) {
					e.preventDefault();
					if (x < max_fields) {
						x++;
						$(wrapperCC).append('<div><input class="mail-address" type="email" name="empfaengerCC[]" list="Email-Adressen"/><a href="#" class="delete">Delete</a></div>'); //add input box
					} else {
						alert('You Reached the limits')
					}
				});
			
				$(wrapperCC).on("click", ".delete", function(e) {
					e.preventDefault();
					$(this).parent('div').remove();
					x--;
				})
				
				
				var wrapperBCC = $(".containerBCC");
				var add_buttonBCC = $(".add_form_fieldBCC");
			
				var y = 1;
				$(add_buttonBCC).click(function(e) {
					e.preventDefault();
					if (y < max_fields) {
						y++;
						$(wrapperBCC).append('<div><input class="mail-address" type="email" name="empfaengerBCC[]" list="Email-Adressen"/><a href="#" class="delete">Delete</a></div>'); //add input box
					} else {
						alert('You Reached the limits')
					}
				});
			
				$(wrapperBCC).on("click", ".delete", function(e) {
					e.preventDefault();
					$(this).parent('div').remove();
					x--;
				})
    		});
        </script>

</main>		
<footer>
</footer>
<script src="../js/main.js"></script>
</body>
</html>

<?php
/*
		
*/
?>