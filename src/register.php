<?php
require __DIR__ . '/../config.php';

?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

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
            
        </header>
        <main class="mdl-layout__content">
        <div class="container">    
            <form method="POST" id="RegisterForm" action="apiRegister.php" name="register">
                <div class="container">
                    <h1><i class="bi bi-person-plus" style="color:#04AA6D;"></i> Register</h1>
                    <p>Please fill in this form to create an account.</p>
                    <p>Login with E-Mail and Password</p>
                    <hr>

                    <label for="name"><b>Name</b></label>
                    <input type="text" placeholder="Enter Nachname" name="name" id="username" required>

                    <label for="vorName"><b>Vorname</b></label>
                    <input type="text" placeholder="Enter Vorname" name="vorName" id="username" required>

                    <label for="email"><b>Email <div class="tooltip info"><i class="bi bi-info-circle"></i><span class="tooltiptext">Bitte gültige E-Mail-Adresse angeben,<br>wird als Login-Name verwendet</span></div></b></label>
                    <input type="email" placeholder="Enter Email" name="email" id="useremail" required>
                    <br>
                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" id="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <br>
                    <label for="psw-repeat"><b>Repeat Password</b></label>
                    <input type="password" placeholder="Repeat Password" name="passwordRepeat" id="psw-repeat"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <hr>

                    <button type="submit" id="registerBtn">Register</button>
                </div>

                <div class="container signin">
                    <p>Already have an account? <a href="../index.php">Sign in</a>.</p>
                </div>
            </form>
        </div>
        </main>
    
</body>

</html>