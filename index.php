<?php
session_start();  
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="FiebigsFitness.css">
        <style>
            .error-message {
                color: red;
                margin-bottom: 10px;
                padding: 5px;
                text-align: center;
            }
        </style>
    </head>
    <body id="loginBody">
        <div id="title" style="background-color: white;">
            <h2 style="color: rgb(33, 184, 184)">Fiebig</h2>
            <h2 style="color: lightblue;">Fitness</h2>
        </div>

        <div class="wrapper">
            <div id="loginSection">
                <form action="signInFormHandler.php" method="POST">
                    <h3 style="font-style: italic; text-align: center;">Login</h3>

                    <label for="usernameInput"><b>Username</b></label>
                    <br>
                    <input type="text" name="usernameInput" placeholder="Enter Username">

                    <br><br>

                    <label for="passwordInput"><b>Password</b></label>
                    <br>
                    <input type="password" name="passwordInput" placeholder="Enter Password">

                    <br><br>

                    <?php
                        if (isset($_SESSION['errorMessage'])) {
                            echo '<p class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                            unset($_SESSION['errorMessage']); 
                        }
                    ?>

                    <div id="dateChangeButtons">    
                        <div> 
                            <button type="submit" class="loginButton" id="loginButton">Sign In</button>                     
                        </div>
                            <div style="flex-grow: 1;"></div>

                        <div>
                            <button type="button" class="loginButton" id="signUpButton" onclick="window.location.href='createAccount.php'">Sign Up</button> 
                        </div>
                    </div>  
                </form> 
            </div>
        </div>
    </body>
</html>
