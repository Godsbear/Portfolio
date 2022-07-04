<?php

function buildNavbar(){
echo('
<header class="mdl-layout__header">
            <!-- Header -->
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title"><a href="home.php">Home|</a></span>
                <span class="mdl-layout-title"><a href="register.php">Register|</a></span>
            ');
                
                    if(isset($_SESSION["roles"][1])){
                        echo('<span class="mdl-layout-title"><a href="userPanel.php">userPanel|</a></span>');                        
                    }
echo('
                <span class="mdl-layout-title"><a href="accPanel.php">Profil|</a></span>
                    <span class="mdl-layout-title"><a href="logout.php">Logout</a></span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
                <nav class="mdl-navigation mdl-layout--large-screen-only">
                    <!-- Navigation rechts -->
                    
                </nav>
            </div>
        </header>
');
      }
?>