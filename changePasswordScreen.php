<?php
session_start();
?>

<html>
    <link rel="stylesheet" href="FiebigsFitness.css">
    
    <div id="homeTitle">
        <div> 
            <h2 style="color: rgb(33, 184, 184)">Fiebig</h2>
            <h2 style="color: lightblue;">Fitness</h2>
        </div>
        <div style="flex-grow: 1;"></div>
        <div>
            <a href="settings.php"><button id="titleButton">Settings</button></a>
            <a href="logout.php"><button id="titleButton">Logout</button></a>
        </div>
    </div>  

    <div id="homeButtonsContainer">
        <a href="home.php"><button id="homeButtons">Home</button></a>
        <a href="food.php"><button id="homeButtons">Food</button></a>
        <a href="exercise.php"><button id="homeButtons">Exercise</button></a>
        <a href="goals.php"><button id="homeButtons">Goals</button></a>
        <a href="bmi.php"><button id="homeButtons">BMI</button></a>
        <a href="calorieCalc.php"><button id="homeButtons">Calorie Calculator</button></a>
        <a href="workout.php"><button id="homeButtons">Workouts</button></a>
    </div>

    <br><br>

    <div id="settingsHome">
        <h3 style="font-style: italic; text-align: center;">Change Password</h3>

            <form action="updatePassword.php" method="POST">            
                <input type="password" name="changePasswordInput" placeholder="Change Password" required></input>

                <div id="dateChangeButtons">    
                    <div> 
                    <a href="settings.php"><button type="button" class="loginButton" name="backButton">Back</button></a>
                    </div>
                        <div style="flex-grow: 1;"></div>
                    <div> 
                        <button type="submit" class="loginButton" id="changePassword">Change</button>
                    </div>
                </div>

                
            </form>
            <?php
                if (isset($_SESSION['errorMessage'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                    unset($_SESSION['errorMessage']); 
                } else if (isset($_SESSION['successMessage'])) {
                    echo '<p class="success-message">' . htmlspecialchars($_SESSION['successMessage']) . '</p>';
                    unset($_SESSION['successMessage']); 
                }
            ?>   
    </div>
</html>
