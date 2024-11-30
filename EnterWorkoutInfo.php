<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

$accountID = $_SESSION['AccountID'];

try {
    require_once "dbConnection.php";  
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="FiebigsFitness.css">
    <title>Enter Workout Plan</title>
    </head>
    <body>
        <div id="homeTitle">
            <div> 
                <h2 style="color: rgb(33, 184, 154)">Fiebig</h2> <!-- Fixed color -->
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

        <form action="updateWorkoutPlan.php" method="POST">
            <div id="enterWorkoutLayout">
                <h3 style="font-style: italic; text-align: center;">Enter Workout Plan:</h3>
                
                <br>
                
                <div id="enterWorkout">
                    <h4>Workout Plan</h4>
                
                    <label for="workoutName">Name:</label>
                    <input type="text" name="workoutName" placeholder="Name Workout" style="width: 150px;">

                    <br><br>
                
                    <label for="workoutDayOne">Day 1:</label>
                    <input type="text" name="workoutDayOne" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDayTwo">Day 2:</label>
                    <input type="text" name="workoutDayTwo" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDayThree">Day 3:</label>
                    <input type="text" name="workoutDayThree" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDayFour">Day 4:</label>
                    <input type="text" name="workoutDayFour" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDayFive">Day 5:</label>
                    <input type="text" name="workoutDayFive" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDaySix">Day 6:</label>
                    <input type="text" name="workoutDaySix" placeholder="Enter Workout" style="width: 150px;">

                    <br><br>

                    <label for="workoutDaySeven">Day 7:</label>
                    <input type="text" name="workoutDaySeven" placeholder="Enter Workout" style="width: 150px;">
                    
                    <br><br>               
                </div>  
            </div>

            <div id="dateChangeButtons"> 
            <div style="flex-grow: 0.4;"></div>  
                <div> 
                    <a href="workout.php"><button type="button" class="loginButton" name="backButton">Back</button></a>
                </div>
                <div style="flex-grow: 0.2;"></div>  
                <div> 
                    <button type="submit" class="loginButton">Create Plan</button>
                </div>
            </div>
            <div style="flex-grow: 0.4;"></div>  
        </form>
    </body>
</html>
