<?php
require __DIR__ . '/../config.php';
use App\Utils\HelperFunctions;


session_start();
    HelperFunctions::loginCheck();
    HelperFunctions::cookiesCheck();
    
?>


<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
	
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <!-- Navigation Icon -->
    <link rel="stylesheet" href="/css/vorlage.css" />
    <!-- Layout -->
    
    <link rel="stylesheet" href="/css/style.css" />
    
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
        <?php
            buildNavbar();
        ?>
        <main class="mdl-layout__content">
        <h1>Herzlich Willkommen <br> beim Portfolio von Mark Pimpl</h1>

        <div class="page-content">
            <p class="text-left font-20">
                Hier sehen Sie, was ich im Rahmen des Unterrichts bei CTC-Lohr<br>
                und darüber hinaus erarbeitet habe. Dies umfasst nur den Bereich <br>
                der Webentwicklung, da ich daran besonderes Interresse habe.<br><br>
                Ich habe die Inhalte in zwei Teile aufgeteilt.<br>
                Die nachfolgenden Links sind Themen die im Unterricht entstanden sind.<br>
                Den Code können Sie bei GitHub anschauen mit dem Folgenden Link:
            </p>
            <span id="linkGitHub"><a href="https://github.com/Godsbear/Portfolio" target="_blank" rel="noopener noreferrer">Link zum Code auf Github</a></span>
        </div>
        <div class="page-content">
            <br>
            <ul class="li">
                <li ><a class="nav-link" href="/src/mail.php">Email</a></li>
                <li ><a class="nav-link" href="/src/share.php">Download</a></li>
                <li ><a class="nav-link" href="/src/docu.php">Docu Mail-Server</a></li>
                <li ><a class="nav-link" href="/src/docu_bank-mailserver.php">Docu Bankmail-Server</a></li>	
                <li ><a class="nav-link" href="/src/docu_userpannel.php">Docu User-Verwaltung</a></li>	
            </ul>
        </div>
    </main>
    </div>   
 
    

    <footer>
        
    </footer>
</body>
<script  src="../js/main.js"></script>


</html>