<?php

function buildNavbar(){
echo('
<header>
	<div class="navbar">
		<nav>
			
				<li ><a class="nav-link" href="/index.php">Home</a></li>
				<li ><a class="nav-link" href="/schulprojekt/src/mail.php">Email</a></li>
				<li ><a class="nav-link" href="/schulprojekt/src/share.php">Download</a></li>');	  
				if(isset($_SESSION["roles"][1])){
					echo('<li><a class="nav-link" href="mittagEssen.php">Essens Auswahl|</a></li>');                        
				}
echo('
				<li ><a class="nav-link" href="/schulprojekt/src/docu.php">Docu Mail-Server</a></li>
				<li ><a class="nav-link" href="/schulprojekt/src/docu_bank-mailserver.php">Docu Bankmail-Server</a></li>		
		</nav>
	</div>
</header>
');
      }
?>