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
    
    <body>
        <div id = "title" style="background-color: white;">
            <h2 style = "color: rgb(33, 184, 184)">Fiebig</h2>
            <h2 style = "color: lightblue;">Fitness</h2>
        </div>

        <div id = "loginOrCreateAccount">
            <form action = "createAccountFormHandler.php" method = "POST">
                <h3 style = "font-style: italic; text-align: center;">Create Account</h3>

                <label for="createUsernameInput"><b>Create Username</b></label>
                <br>
                <input type="text" name = "createUsernameInput" placeholder="Enter Username" autocomplete="off">

                <br><br>

                <label for="createPasswordInput"><b>Create Password</b></label>
                <br>
                <input type="password" name = "createPasswordInput" placeholder="Enter Password" autocomplete="off">

                <br><br>

                <?php
                    session_start();
                    if (isset($_SESSION['errorMessage'])) {
                        echo '<p class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                        unset($_SESSION['errorMessage']);
                    }
                ?>
           
                <div id="dateChangeButtons">    
                    <div> 
                        <button type="button" class="loginButton" id="backpButton" onclick="window.location.href='index.php'">Back</button>
                    </div>
                        <div style="flex-grow: 1;"></div>
                    <div>
                        <button type="submit" class="loginButton" id="createButton">Sign Up</button>
                    </div>
                </div> 
            </form>
        </div>
    </body>
</html> 