<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

$accountID = $_SESSION['AccountID'];

if (isset($_GET['date'])) {
    $dateView = $_GET['date']; 
} else {
    $dateView = date('Y-m-d');  
}


if (isset($_GET['moveBackwards'])) {
    $dateView = date('Y-m-d', strtotime($dateView . ' -1 day'));
} elseif (isset($_GET['moveForwards'])) {
    $dateView = date('Y-m-d', strtotime($dateView . ' +1 day')); 
}
$formattedDate = date('d M Y', strtotime($dateView));

try {
    require_once "dbConnection.php";  
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<html>
    <link rel="stylesheet" href="FiebigsFitness.css">
    <div id = homeTitle>
        <div> 
            <h2 style = "color: rgb(33, 184, 184)">Fiebig</h2>
            <h2 style = "color: lightblue;">Fitness</h2>
        </div>
        <div style = "flex-grow: 1;">
        </div>
        <div>
            <a href = "settings.php"><button id = "titleButton">Settings</button></a>
            <a href = "logout.php"><button id = "titleButton">Logout</button></a>
        </div>
    </div>  
    
    <div id = 'homeButtonsContainer'>
        <a href = "home.php"><button id = "homeButtons">Home</button></a>
        <a href = "food.php"><button id = "homeButtons">Food</button></a>
        <a href = "exercise.php"><button id = "homeButtons" >Exercise</button></a>
        <a href = "goals.php"><button id = "homeButtons" >Goals</button></a>
        <a href = "bmi.php"><button id = "homeButtons" >BMI</button></a>
        <a href = "calorieCalc.php"><button id = "homeButtons" >Calorie Calulator</button></a>
        <a href = "workout.php"><button id = "homeButtons" >Workouts</button></a>
    </div>
 

    <div id="exerciseHome">
        <h3 style="font-style: italic; text-align: center;">Exercise Diary For Date: <?php echo htmlspecialchars($formattedDate);?></h3>

        <br>

        <div id="exerciseLayout">
            <h4>Cardio Vascular Exercise</h4>
            <form action="addExercise.php" method="POST">
                <input type="text" name="exerciseName" id="ageInput" placeholder="Type Exercise">
                <input type="hidden" name="exerciseType" value="Cardio Vascular Exercise">
                <input type="hidden" name="exerciseDate" value="<?php echo $dateView; ?>">
                <button type="submit" class="loginButton">Submit</button>
            </form>

            <h4>Strength Training</h4>
            <form action="addExercise.php" method="POST">
                <input type="text" name="exerciseName" id="ageInput" placeholder="Type Exercise">
                <input type="hidden" name="exerciseType" value="Strength Training">
                <input type="hidden" name="exerciseDate" value="<?php echo $dateView; ?>">
                <button type="submit" class="loginButton">Submit</button>
            </form>

            <div id="dateChangeButtons">    
                <div> 
                    <a href="exercise.php?moveBackwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Previous</button></a>
                </div>
                    <div style="flex-grow: 1;"></div>
                <div> 
                    <a href="exercise.php?moveForwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Next</button></a>
                </div>
            </div>
        </div>
    </div>
</html>
